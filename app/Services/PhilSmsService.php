<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class PhilSmsService
{
    /**
     * Send one SMS message using the PhilSMS API.
     *
     * This method makes a real HTTP request only when called.
     * The application controller must check the SMS-enabled setting first.
     */
    public function send(string $number, string $message): array
    {
        $apiToken = config('services.philsms.api_token');
        $senderId = config('services.philsms.sender_id');
        $baseUrl = config(
            'services.philsms.base_url',
            'https://app.philsms.com/api/v3'
        );

        if (empty($apiToken)) {
            return [
                'success' => false,
                'message' => 'PhilSMS API token is not configured.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }

        if (empty($senderId)) {
            return [
                'success' => false,
                'message' => 'PhilSMS sender ID is not configured.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }

        $number = trim($number);
        $message = trim($message);

        if ($number === '' || $message === '') {
            return [
                'success' => false,
                'message' => 'The recipient number and message are required.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }

        $recipient = preg_replace('/[\s\-()]/', '', $number);

        if (! is_string($recipient) || $recipient === '') {
            return [
                'success' => false,
                'message' => 'The recipient number is invalid.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }

        // Normalize common Philippine mobile number formats.
        if (str_starts_with($recipient, '+63')) {
            $recipient = substr($recipient, 1);
        } elseif (preg_match('/^09\d{9}$/', $recipient)) {
            $recipient = '63' . substr($recipient, 1);
        } elseif (preg_match('/^9\d{9}$/', $recipient)) {
            $recipient = '63' . $recipient;
        }

        try {
            $response = Http::withToken($apiToken)
                ->acceptJson()
                ->asJson()
                ->timeout(20)
                ->post(rtrim($baseUrl, '/') . '/sms/send', [
                    'recipient' => $recipient,
                    'sender_id' => $senderId,
                    'type' => 'plain',
                    'message' => $message,
                ]);

            $body = $response->json();

            if (
                ! $response->successful()
                || ! is_array($body)
                || strtolower((string) ($body['status'] ?? '')) !== 'success'
            ) {
                $errorMessage = is_array($body)
                    ? ($body['message'] ?? null)
                    : null;

                return [
                    'success' => false,
                    'message' => is_string($errorMessage)
                        ? $errorMessage
                        : 'PhilSMS rejected the SMS request. Please check the API response and configuration.',
                    'provider_status' => is_array($body)
                        ? ($body['status'] ?? null)
                        : null,
                    'message_id' => null,
                ];
            }

            $data = $body['data'] ?? null;

            // Some responses may return a list of message reports.
            if (is_array($data) && array_is_list($data)) {
                $data = $data[0] ?? null;
            }

            $messageId = is_array($data)
                ? ($data['uid'] ?? $data['message_id'] ?? $data['id'] ?? null)
                : null;

            $providerStatus = is_array($data)
                ? ($data['status'] ?? $body['status'] ?? null)
                : $body['status'];

            return [
                'success' => true,
                'message' => 'PhilSMS accepted the SMS request.',
                'provider_status' => $providerStatus,
                'message_id' => $messageId,
            ];
        } catch (Throwable $exception) {
            // Do not log the API token or the full request.
            Log::warning('PhilSMS request failed.', [
                'exception' => class_basename($exception),
            ]);

            return [
                'success' => false,
                'message' => 'The SMS request could not be completed because of a connection or service error.',
                'provider_status' => null,
                'message_id' => null,
            ];
        }
    }
}