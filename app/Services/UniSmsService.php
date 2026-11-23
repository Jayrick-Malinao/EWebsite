<?php

namespace App\Services;

use App\Models\AnnouncementSmsDelivery;
use App\Support\PhilippineMobileNumberFormatter;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UniSmsService
{
    /**
     * Read the current UniSMS account balance without changing provider state.
     *
     * @return array{
     *     available: bool,
     *     sms_credits: int|null,
     *     status: string|null,
     *     message: string|null
     * }
     */
    public function accountBalance(): array
    {
        $secretKey = config('services.unisms.secret_key');

        if (! is_string($secretKey) || trim($secretKey) === '') {
            return $this->unavailableBalance(
                'UniSMS secret key is not configured.'
            );
        }

        try {
            $response = Http::acceptJson()
                ->withBasicAuth($secretKey, '')
                ->connectTimeout(3)
                ->timeout(5)
                ->withoutRedirecting()
                ->get('https://unismsapi.com/api/account');
        } catch (ConnectionException) {
            return $this->unavailableBalance(
                'UniSMS account balance is temporarily unavailable.'
            );
        }

        if (! $response->successful()) {
            return $this->unavailableBalance(
                "UniSMS account balance is unavailable (HTTP {$response->status()})."
            );
        }

        $account = $response->json();
        $smsCredits = is_array($account)
            ? ($account['sms_credits'] ?? null)
            : null;
        $status = is_array($account)
            ? ($account['status'] ?? null)
            : null;

        if (
            ! is_int($smsCredits)
            || $smsCredits < 0
            || ! is_string($status)
            || trim($status) === ''
        ) {
            return $this->unavailableBalance(
                'UniSMS returned an invalid account balance response.'
            );
        }

        return [
            'available' => true,
            'sms_credits' => $smsCredits,
            'status' => $status,
            'message' => null,
        ];
    }

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

        if (mb_strlen($message) > 670) {
            return $this->result(
                false,
                'The SMS message exceeds the UniSMS limit of 670 characters.'
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
                ->withoutRedirecting()
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
     * @return array{success: bool, updated: bool, message: string, retry_later: bool}
     */
    public function refreshDeliveryStatus(AnnouncementSmsDelivery $delivery): array
    {
        $secretKey = config('services.unisms.secret_key');
        $baseUrl = config('services.unisms.base_url', 'https://unismsapi.com/api');
        $endpoint = is_string($baseUrl) ? $this->endpointUrl($baseUrl) : null;
        $reference = $this->sanitizeMessageId($delivery->provider_reference);

        if (! is_string($secretKey) || trim($secretKey) === '' || $endpoint === null || $reference === null) {
            return ['success' => false, 'updated' => false, 'message' => 'The provider configuration or message reference is missing or invalid.', 'retry_later' => true];
        }

        $checkId = $this->beginStatusCheck($delivery);

        try {
            $response = Http::acceptJson()
                ->withBasicAuth($secretKey, '')
                ->connectTimeout(5)
                ->timeout(20)
                ->withoutRedirecting()
                ->get($endpoint.'/'.rawurlencode($reference));
        } catch (ConnectionException $exception) {
            $this->finishStatusCheck($delivery, $checkId, 'connection_error');
            Log::warning('UniSMS status lookup failed.', [
                'delivery_id' => $delivery->id,
                'exception' => class_basename($exception),
            ]);

            return ['success' => false, 'updated' => false, 'message' => 'UniSMS status lookup failed; the previous status was retained.', 'retry_later' => true];
        }

        $providerMessage = $response->json('message');

        if ($response->status() !== 200) {
            $this->finishStatusCheck($delivery, $checkId, 'http_error', $response->status(), providerReason: $this->lookupErrorDetails($delivery, $response));
            Log::warning('UniSMS status lookup failed.', [
                'delivery_id' => $delivery->id,
                'http_status' => $response->status(),
            ]);

            $message = match ($response->status()) {
                401 => 'UniSMS authentication failed; check the configured credentials.',
                404 => 'UniSMS could not find a message reference.',
                429 => 'UniSMS rate limit reached; try checking again later.',
                default => 'UniSMS status lookup is temporarily unavailable.',
            };

            return [
                'success' => false,
                'updated' => false,
                'message' => $message.' The previous status was retained.',
                'retry_later' => in_array($response->status(), [401, 429], true) || $response->serverError(),
            ];
        }

        $updated = is_array($providerMessage)
            ? $this->updateDeliveryStatus($delivery, $providerMessage, $response->status())
            : null;

        if ($updated === null) {
            $matchingMessage = is_array($providerMessage)
                && $this->sanitizeMessageId($providerMessage['reference_id'] ?? null) === $reference;
            $this->finishStatusCheck(
                $delivery,
                $checkId,
                'invalid_response',
                $response->status(),
                providerReason: $matchingMessage ? $this->providerReason($delivery, $providerMessage) : null
            );
            Log::warning('UniSMS status lookup could not be verified.', [
                'delivery_id' => $delivery->id,
                'http_status' => $response->status(),
            ]);

            return ['success' => false, 'updated' => false, 'message' => 'UniSMS did not return a verifiable message status; the previous status was retained.', 'retry_later' => false];
        }

        $this->finishStatusCheck(
            $delivery,
            $checkId,
            $updated ? 'success' : 'skipped',
            $response->status(),
            $providerMessage['status'],
            $this->providerReason($delivery, $providerMessage)
        );

        return ['success' => true, 'updated' => $updated, 'message' => $updated ? 'UniSMS status updated.' : 'The delivery changed before the status could be applied.', 'retry_later' => false];
    }

    private function beginStatusCheck(AnnouncementSmsDelivery $delivery): int
    {
        return DB::transaction(function () use ($delivery): int {
            $checkedAt = now();
            $checkId = DB::table('announcement_sms_status_checks')->insertGetId([
                'announcement_sms_delivery_id' => $delivery->id,
                'checked_at' => $checkedAt,
                'result' => 'in_progress',
            ]);

            AnnouncementSmsDelivery::query()
                ->whereKey($delivery->id)
                ->where('provider_reference', $delivery->provider_reference)
                ->update([
                    'status_check_attempted_at' => $checkedAt,
                    'status_check_result' => 'in_progress',
                    'status_lookup_http_status' => null,
                ]);

            return $checkId;
        });
    }

    private function finishStatusCheck(AnnouncementSmsDelivery $delivery, int $checkId, string $result, ?int $httpStatus = null, ?string $providerStatus = null, ?string $providerReason = null): void
    {
        DB::transaction(function () use ($delivery, $checkId, $result, $httpStatus, $providerStatus, $providerReason): void {
            DB::table('announcement_sms_status_checks')->where('id', $checkId)->update([
                'result' => $result,
                'http_status' => $httpStatus,
                'provider_status' => $providerStatus,
                'provider_reason' => $providerReason,
            ]);
            AnnouncementSmsDelivery::query()
                ->whereKey($delivery->id)
                ->where('provider_reference', $delivery->provider_reference)
                ->update([
                    'status_check_result' => $result,
                    'status_lookup_http_status' => $httpStatus,
                ]);
        });
    }

    /**
     * @param  array<string, mixed>  $providerMessage
     */
    public function updateDeliveryStatus(AnnouncementSmsDelivery $delivery, array $providerMessage, ?int $httpStatus = null): ?bool
    {
        $reference = $this->sanitizeMessageId($providerMessage['reference_id'] ?? null);
        $providerStatus = $providerMessage['status'] ?? null;

        if ($reference === null || $reference !== $delivery->provider_reference
            || ! is_string($providerStatus)
            || ! in_array($providerStatus, ['pending', 'retrying', 'sent', 'failed'], true)) {
            return null;
        }

        $status = match ($providerStatus) {
            'pending', 'retrying' => 'Pending',
            'failed' => 'Failed',
            'sent' => 'Unknown',
        };
        $failureReason = null;

        if ($providerStatus === 'failed') {
            $failureReason = 'UniSMS reported this message as failed.';
            $reason = $this->providerReason($delivery, $providerMessage);

            if ($reason !== null) {
                $failureReason .= ' '.$reason;
            }
        }

        $updates = [
            'status' => $status,
            'provider_status' => $providerStatus,
            'status_checked_at' => now(),
            'failure_reason' => $failureReason,
        ];

        if ($httpStatus !== null) {
            $updates['status_lookup_http_status'] = $httpStatus;
        }

        $query = AnnouncementSmsDelivery::query()
            ->whereKey($delivery->id)
            ->where('provider_reference', $reference)
            ->where('status', $delivery->status)
            ->where('provider_status', $delivery->provider_status)
            ->where('status_checked_at', $delivery->status_checked_at)
            ->whereNotIn('status', ['Failed', 'Delivered']);

        if (in_array($providerStatus, ['pending', 'retrying'], true)) {
            $query->where(function ($query) {
                $query->whereNull('provider_status')
                    ->orWhereNotIn('provider_status', ['sent', 'failed']);
            });
        }

        return $query->update($updates) > 0;
    }

    private function lookupErrorDetails(AnnouncementSmsDelivery $delivery, Response $response): ?string
    {
        $body = $response->json();
        if (! is_array($body)) {
            return null;
        }

        $code = $body['code'] ?? $body['error_code'] ?? (is_array($body['error'] ?? null) ? ($body['error']['code'] ?? null) : null);
        $secret = (string) config('services.unisms.secret_key');
        $webhookSecret = (string) config('services.unisms.webhook_secret');
        $details = [];
        if ((is_string($code) || is_int($code))
            && preg_match('/\A[A-Za-z0-9._-]{1,64}\z/', (string) $code) === 1
            && ($secret === '' || (! str_contains((string) $code, $secret) && ! str_contains((string) $code, base64_encode($secret.':'))))
            && ($webhookSecret === '' || ! str_contains((string) $code, $webhookSecret))) {
            $details[] = 'Provider code: '.$code;
        }

        $providerMessage = is_array($body['message'] ?? null) ? $body['message'] : $body;
        $reason = $this->providerReason($delivery, $providerMessage)
            ?? $this->extractProviderMessage(
                $body,
                $secret,
                (string) $delivery->contact_number,
                is_string($providerMessage['recipient'] ?? null) ? $providerMessage['recipient'] : '',
                is_string($providerMessage['content'] ?? null) ? $providerMessage['content'] : '',
                (string) config('services.unisms.sender_id')
            );
        if ($reason !== null) {
            $details[] = $reason;
        }

        return $details === [] ? null : mb_substr(implode(' | ', $details), 0, 500);
    }

    /**
     * @param  array<string, mixed>  $providerMessage
     */
    private function providerReason(AnnouncementSmsDelivery $delivery, array $providerMessage): ?string
    {
        $reason = $providerMessage['fail_reason'] ?? null;

        if (! is_string($reason) || trim($reason) === '') {
            return null;
        }

        $safeReason = $this->sanitizeProviderMessage(
            $reason,
            (string) config('services.unisms.secret_key'),
            (string) $delivery->contact_number,
            is_string($providerMessage['recipient'] ?? null) ? $providerMessage['recipient'] : '',
            is_string($providerMessage['content'] ?? null) ? $providerMessage['content'] : '',
            (string) config('services.unisms.sender_id')
        );

        return $safeReason !== '' ? $safeReason : null;
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
            || $response->status() === 408
            || $response->successful();

        if ($outcomeUncertain) {
            $failureMessage .= ' Provider acceptance is uncertain; check UniSMS activity before retrying to avoid a duplicate message.';
        }

        Log::warning('UniSMS did not confirm message acceptance.', [
            'delivery_id' => $deliveryId,
            'requested_at' => $requestedAt,
            'endpoint_path' => parse_url($endpoint, PHP_URL_PATH),
            'http_status' => $response->status(),
            'response_is_json' => $responseIsJson,
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
            $details = "UniSMS did not confirm the request (HTTP {$httpStatus}";

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
            $secretKey !== '' ? base64_encode($secretKey.':') : '',
            (string) config('services.unisms.webhook_secret'),
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
            '/\b(Bearer|Basic)\s+[A-Za-z0-9+\/._=-]+/i',
            '$1 [redacted]',
            $safeMessage
        ) ?? '[provider message redacted]';
        $safeMessage = preg_replace(
            '/\b(secret(?:[_-]?key)?|api[_-]?key|(?:access|webhook)[_-]?token|webhook[_-]?secret[_-]?key|password|authorization|phone_number|recipient|content|message|sender_id)\s*[:=]\s*[^\s&,;]+/i',
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

    public function isValidReference(mixed $reference): bool
    {
        return $this->sanitizeMessageId($reference) !== null;
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

    /**
     * @return array{
     *     available: false,
     *     sms_credits: null,
     *     status: null,
     *     message: string
     * }
     */
    private function unavailableBalance(string $message): array
    {
        return [
            'available' => false,
            'sms_credits' => null,
            'status' => null,
            'message' => $message,
        ];
    }
}
