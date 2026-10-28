<?php

namespace App\Services;

use App\Support\PhilippineMobileNumberFormatter;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UniSmsService
{
    /**
     * Send one SMS message using the UniSMS API.
     *
     * This method makes a real HTTP request only when called.
     * The application controller must check the SMS-enabled setting first.
     *
     * @return array{
     *     success: bool,
     *     message: string,
     *     provider_status: string|null,
     *     message_id: string|null,
     *     http_status: int|null,
     *     content_type: string|null,
     *     response_is_json: bool|null,
     *     outcome_uncertain: bool
     * }
     */
    public function send(
        string $number,
        string $message,
        ?int $deliveryId = null
    ): array {
        $secretKey = config('services.unisms.secret_key');
        $senderId = config('services.unisms.sender_id');
        $baseUrl = config(
            'services.unisms.base_url',
            'https://unismsapi.com/api'
        );

        if (! filled($secretKey)) {
            return $this->result(
                false,
                'UniSMS secret key is not configured.'
            );
        }

        $endpoint = $this->endpointUrl($baseUrl);

        if ($endpoint === null) {
            return $this->result(
                false,
                'UniSMS base URL is invalid. Use https://unismsapi.com/api.'
            );
        }

        if (! is_string($senderId) || trim($senderId) === '') {
            return $this->result(
                false,
                'UniSMS sender ID is not configured.'
            );
        }

        $number = trim($number);
        $message = trim($message);

        if ($number === '' || $message === '') {
            return $this->result(
                false,
                'The recipient number and message are required.'
            );
        }

        $normalizedNumber = PhilippineMobileNumberFormatter::normalize($number);

        if (! PhilippineMobileNumberFormatter::isValid($normalizedNumber)) {
            return $this->result(
                false,
                'The recipient number must be a valid Philippine mobile number.'
            );
        }

        $recipient = '+'.$normalizedNumber;
        $requestedAt = now()->toIso8601String();
        $requiredFieldsPresent = [
            'secret_key' => filled($secretKey),
            'recipient' => $recipient !== '',
            'content' => $message !== '',
            'sender_id' => filled($senderId),
        ];

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withBasicAuth($secretKey, '')
                ->connectTimeout(5)
                ->timeout(20)
                ->post($endpoint, [
                    'recipient' => $recipient,
                    'content' => $message,
                    'sender_id' => trim($senderId),
                ]);

            return $this->handleResponse(
                $response,
                $endpoint,
                $secretKey,
                $number,
                $recipient,
                $message,
                trim($senderId),
                $deliveryId,
                $requestedAt
            );
        } catch (ConnectionException $exception) {
            $failureMessage = 'The connection to UniSMS failed; provider acceptance is unknown. Check UniSMS activity before retrying to avoid a duplicate message.';

            Log::warning('UniSMS connection outcome is unknown.', [
                'delivery_id' => $deliveryId,
                'requested_at' => $requestedAt,
                'endpoint_path' => parse_url($endpoint, PHP_URL_PATH),
                'exception' => class_basename($exception),
                'secret_key_configured' => filled($secretKey),
                'sender_id_configured' => filled($senderId),
                'required_fields_present' => $requiredFieldsPresent,
                'outcome_uncertain' => true,
            ]);

            return $this->result(
                false,
                $failureMessage,
                outcomeUncertain: true
            );
        }
    }

    /**
     * @return array{
     *     success: bool,
     *     message: string,
     *     provider_status: string|null,
     *     message_id: string|null,
     *     http_status: int|null,
     *     content_type: string|null,
     *     response_is_json: bool|null,
     *     outcome_uncertain: bool
     * }
     */
    private function handleResponse(
        Response $response,
        string $endpoint,
        string $secretKey,
        string $originalNumber,
        string $recipient,
        string $message,
        string $senderId,
        ?int $deliveryId,
        string $requestedAt
    ): array {
        $rawBody = $response->body();
        $body = json_decode($rawBody, true);
        $responseIsJson = json_last_error() === JSON_ERROR_NONE;
        $contentType = $this->sanitizeContentType(
            $response->header('Content-Type')
        );
        $providerMessage = is_array($body) && is_array($body['message'] ?? null)
            ? $body['message']
            : null;
        $providerStatus = is_string($providerMessage['status'] ?? null)
            ? $providerMessage['status']
            : null;
        $messageId = $this->sanitizeMessageId(
            $providerMessage['reference_id'] ?? null
        );

        if (
            $response->status() === 201
            && $providerStatus === 'pending'
            && $messageId !== null
        ) {
            Log::info('UniSMS accepted a delivery.', [
                'delivery_id' => $deliveryId,
                'requested_at' => $requestedAt,
                'endpoint_path' => parse_url($endpoint, PHP_URL_PATH),
                'http_status' => $response->status(),
                'provider_status' => $providerStatus,
                'message_id' => $messageId,
                'content_type' => $contentType,
                'response_is_json' => $responseIsJson,
                'secret_key_configured' => filled($secretKey),
                'sender_id_configured' => $senderId !== '',
                'required_fields_present' => [
                    'secret_key' => filled($secretKey),
                    'recipient' => $recipient !== '',
                    'content' => $message !== '',
                    'sender_id' => $senderId !== '',
                ],
            ]);

            return $this->result(
                true,
                'UniSMS accepted the message into its queue.',
                $providerStatus,
                $messageId,
                $response->status(),
                $contentType,
                $responseIsJson
            );
        }

        $providerError = $this->extractProviderMessage(
            $body,
            $secretKey,
            $originalNumber,
            $recipient,
            $message,
            $senderId
        );

        $failureMessage = $this->responseFailureMessage(
            $response,
            $body,
            $responseIsJson,
            $contentType,
            $providerStatus,
            $providerError
        );
        $outcomeUncertain = $response->serverError()
            || $response->successful();

        if ($outcomeUncertain) {
            $failureMessage .= ' Provider acceptance is uncertain; check UniSMS activity before retrying to avoid a duplicate message.';
        }

        Log::warning('UniSMS did not confirm message acceptance.', [
            'delivery_id' => $deliveryId,
            'requested_at' => $requestedAt,
            'endpoint_path' => parse_url($endpoint, PHP_URL_PATH),
            'http_status' => $response->status(),
            'provider_status' => $providerStatus,
            'provider_message' => $providerError,
            'message_id' => $messageId,
            'content_type' => $contentType,
            'response_is_json' => $responseIsJson,
            'response_excerpt' => $this->sanitizeResponseExcerpt(
                $rawBody,
                $secretKey,
                $originalNumber,
                $recipient,
                $message,
                $senderId
            ),
            'secret_key_configured' => filled($secretKey),
            'sender_id_configured' => $senderId !== '',
            'required_fields_present' => [
                'secret_key' => filled($secretKey),
                'recipient' => $recipient !== '',
                'content' => $message !== '',
                'sender_id' => $senderId !== '',
            ],
            'outcome_uncertain' => $outcomeUncertain,
        ]);

        return $this->result(
            false,
            $failureMessage,
            $providerStatus,
            $messageId,
            $response->status(),
            $contentType,
            $responseIsJson,
            $outcomeUncertain
        );
    }

    private function endpointUrl(string $baseUrl): ?string
    {
        if ($baseUrl !== trim($baseUrl)) {
            return null;
        }

        $parts = parse_url($baseUrl);

        if (! is_array($parts)) {
            return null;
        }

        $scheme = strtolower((string) ($parts['scheme'] ?? ''));
        $host = strtolower((string) ($parts['host'] ?? ''));
        $path = rtrim((string) ($parts['path'] ?? ''), '/');

        if (
            $scheme !== 'https'
            || $host !== 'unismsapi.com'
            || $path !== '/api'
            || isset($parts['user'])
            || isset($parts['pass'])
            || isset($parts['query'])
            || isset($parts['fragment'])
            || (isset($parts['port']) && $parts['port'] !== 443)
        ) {
            return null;
        }

        return rtrim($baseUrl, '/').'/sms';
    }

    private function responseFailureMessage(
        Response $response,
        mixed $body,
        bool $responseIsJson,
        ?string $contentType,
        ?string $providerStatus,
        ?string $providerMessage
    ): string {
        $httpStatus = $response->status();

        if ($providerMessage !== null && $providerMessage !== '') {
            $details = "UniSMS did not accept the request (HTTP {$httpStatus}";

            if ($providerStatus !== null) {
                $details .= ", message status {$providerStatus}";
            }

            $details .= "): {$providerMessage}";

            return $details;
        }

        if (! $responseIsJson) {
            $responseType = $contentType ?? 'unknown content type';

            return "UniSMS returned HTTP {$httpStatus} with a non-JSON response ({$responseType}); the provider response could not be parsed.";
        }

        if (! is_array($body)) {
            return "UniSMS returned HTTP {$httpStatus} with valid JSON, but not a JSON object.";
        }

        if ($providerStatus !== null) {
            return "UniSMS returned HTTP {$httpStatus} with message status {$providerStatus} but no readable error message.";
        }

        return "UniSMS returned HTTP {$httpStatus} without a readable provider error message.";
    }

    private function extractProviderMessage(
        mixed $body,
        string $secretKey,
        string $originalNumber,
        string $recipient,
        string $message,
        string $senderId
    ): ?string {
        if (! is_array($body)) {
            return null;
        }

        $messageKeys = ['message', 'error', 'errors', 'detail', 'description'];
        $nodes = [[$body, false]];
        $messages = [];

        while ($nodes !== []) {
            [$node, $insideErrors] = array_pop($nodes);

            foreach ($node as $key => $value) {
                $normalizedKey = is_string($key) ? mb_strtolower($key) : '';
                $isMessageKey = in_array($normalizedKey, $messageKeys, true);

                if (is_array($value)) {
                    $nodes[] = [$value, $insideErrors || $normalizedKey === 'errors'];
                } elseif (
                    is_string($value)
                    && trim($value) !== ''
                    && ($isMessageKey || $insideErrors)
                ) {
                    $messages[] = $this->sanitizeProviderMessage(
                        $value,
                        $secretKey,
                        $originalNumber,
                        $recipient,
                        $message,
                        $senderId
                    );
                }
            }
        }

        $messages = array_values(array_unique(array_filter($messages)));

        return $messages === []
            ? null
            : mb_substr(implode(' | ', array_slice($messages, 0, 3)), 0, 500);
    }

    private function sanitizeResponseExcerpt(
        string $rawBody,
        string $secretKey,
        string $originalNumber,
        string $recipient,
        string $message,
        string $senderId
    ): ?string {
        if (trim($rawBody) === '') {
            return null;
        }

        $safeExcerpt = $rawBody;

        foreach (array_unique([
            $secretKey,
            $originalNumber,
            $recipient,
            $message,
            $senderId,
        ]) as $sensitiveValue) {
            if ($sensitiveValue !== '') {
                $safeExcerpt = str_replace($sensitiveValue, '[redacted]', $safeExcerpt);

                $encodedSensitiveValue = json_encode(
                    $sensitiveValue,
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );

                if (is_string($encodedSensitiveValue)) {
                    $escapedSensitiveValue = substr($encodedSensitiveValue, 1, -1);

                    if ($escapedSensitiveValue !== '') {
                        $safeExcerpt = str_replace(
                            $escapedSensitiveValue,
                            '[redacted]',
                            $safeExcerpt
                        );
                    }
                }
            }
        }

        $safeExcerpt = preg_replace(
            '/("(?:secret[_-]?key|api[_-]?key|access[_-]?token|authorization|phone_number|phone|recipient|mobile|msisdn|content|sender_id)"\s*:\s*)"[^"]*"/i',
            '$1"[redacted]"',
            $safeExcerpt
        ) ?? '[provider response redacted]';
        $safeExcerpt = preg_replace(
            '/([?&](?:api[_-]?key|secret[_-]?key|access[_-]?token)=)[^&\s"<>]+/i',
            '$1[redacted]',
            $safeExcerpt
        ) ?? '[provider response redacted]';
        $safeExcerpt = preg_replace(
            '/(?<!\d)(?:\+?63|0)9\d{9}(?!\d)/',
            '[phone redacted]',
            $safeExcerpt
        ) ?? '[provider response redacted]';
        $safeExcerpt = preg_replace(
            '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/',
            ' ',
            strip_tags($safeExcerpt)
        ) ?? '[provider response redacted]';

        return mb_substr(trim($safeExcerpt), 0, 1000);
    }

    private function sanitizeProviderMessage(
        string $providerMessage,
        string $secretKey,
        string $originalNumber,
        string $recipient,
        string $message,
        string $senderId
    ): string {
        $safeMessage = strip_tags($providerMessage);

        foreach (array_unique([
            $secretKey,
            $originalNumber,
            $recipient,
            $message,
            $senderId,
        ]) as $sensitiveValue) {
            if ($sensitiveValue !== '') {
                $safeMessage = str_replace($sensitiveValue, '[redacted]', $safeMessage);
            }
        }

        $safeMessage = preg_replace(
            '/\b(secret[_-]?key|api[_-]?key|authorization|phone_number|recipient|content|message|sender_id)\s*[:=]\s*[^\s&,;]+/i',
            '$1=[redacted]',
            $safeMessage
        ) ?? '[provider message redacted]';
        $safeMessage = preg_replace(
            '/(?<!\d)(?:\+?63|0)9\d{9}(?!\d)/',
            '[phone redacted]',
            $safeMessage
        ) ?? '[provider message redacted]';

        return mb_substr(trim($safeMessage), 0, 500);
    }

    private function sanitizeContentType(?string $contentType): ?string
    {
        if ($contentType === null) {
            return null;
        }

        return mb_substr(
            preg_replace('/[^A-Za-z0-9!#$&^_.+;=\/ -]/', '', $contentType) ?? '',
            0,
            100
        );
    }

    private function sanitizeMessageId(mixed $messageId): ?string
    {
        if (
            ! is_string($messageId)
            || preg_match('/\A[A-Za-z0-9._:-]{1,128}\z/', $messageId) !== 1
        ) {
            return null;
        }

        return $messageId;
    }

    /**
     * @return array{
     *     success: bool,
     *     message: string,
     *     provider_status: int|string|null,
     *     message_id: string|null,
     *     http_status: int|null,
     *     content_type: string|null,
     *     response_is_json: bool|null,
     *     outcome_uncertain: bool
     * }
     */
    private function result(
        bool $success,
        string $message,
        ?string $providerStatus = null,
        ?string $messageId = null,
        ?int $httpStatus = null,
        ?string $contentType = null,
        ?bool $responseIsJson = null,
        bool $outcomeUncertain = false
    ): array {
        return [
            'success' => $success,
            'message' => $message,
            'provider_status' => $providerStatus,
            'message_id' => $messageId,
            'http_status' => $httpStatus,
            'content_type' => $contentType,
            'response_is_json' => $responseIsJson,
            'outcome_uncertain' => $outcomeUncertain,
        ];
    }
}
