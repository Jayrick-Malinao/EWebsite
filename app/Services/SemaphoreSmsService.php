<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SemaphoreSmsService
{
    /**
     * Send one SMS message through the Semaphore API.
     *
     * @return array{
     *     success: bool,
     *     message: string,
     *     provider_status: string|null,
     *     message_id: string|null
     * }
     */
    public function send(string $number, string $message): array
    {
        $apiKey = config('services.semaphore.api_key');
        $baseUrl = config('services.semaphore.base_url');
        $senderName = config('services.semaphore.sender_name');

        if (empty($apiKey)) {
            return [
                'success' => false,
                'message' => 'Semaphore API key is not configured.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }

        if (empty(trim($number)) || empty(trim($message))) {
            return [
                'success' => false,
                'message' => 'The recipient number and SMS message are required.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }

        $payload = [
            'apikey' => $apiKey,
            'number' => trim($number),
            'message' => trim($message),
        ];

        if (!empty($senderName)) {
            $payload['sendername'] = $senderName;
        }

        try {
            $response = Http::asForm()
                ->acceptJson()
                ->timeout(20)
                ->post(
                    rtrim($baseUrl, '/') . '/messages',
                    $payload
                );

            $data = $response->json();

            if (!$response->successful()) {
                $errorMessage = 'Semaphore rejected the SMS request.';

                if (is_array($data)) {
                    $errorMessage = $data['message']
                        ?? $data['error']
                        ?? $errorMessage;
                }

                return [
                    'success' => false,
                    'message' => $errorMessage,
                    'provider_status' => null,
                    'message_id' => null,
                ];
            }

            // Semaphore normally returns an array of message records.
            $result = is_array($data) && array_is_list($data)
                ? ($data[0] ?? null)
                : $data;

            if (!is_array($result)) {
                return [
                    'success' => false,
                    'message' => 'Semaphore returned an unexpected response.',
                    'provider_status' => null,
                    'message_id' => null,
                ];
            }

            $providerStatus = $result['status'] ?? null;
            $messageId = $result['message_id'] ?? null;

            if (
                empty($messageId)
                || !in_array(
                    strtolower((string) $providerStatus),
                    ['queued', 'pending', 'sent'],
                    true
                )
            ) {
                return [
                    'success' => false,
                    'message' => 'Semaphore did not confirm acceptance of the SMS.',
                    'provider_status' => $providerStatus,
                    'message_id' => $messageId
                        ? (string) $messageId
                        : null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Semaphore accepted the SMS request.',
                'provider_status' => (string) $providerStatus,
                'message_id' => (string) $messageId,
            ];
        } catch (Throwable $exception) {
            // Do not log the API key or the full request payload.
            Log::warning('Semaphore SMS request failed.', [
                'exception' => class_basename($exception),
            ]);

            return [
                'success' => false,
                'message' => 'Unable to connect to Semaphore. Please try again later.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }
    }
}
