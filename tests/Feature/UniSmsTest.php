<?php

namespace Tests\Feature;

use App\Services\UniSmsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class UniSmsTest extends TestCase
{
    public function test_unisms_configuration_loads_without_sending_sms(): void
    {
        Http::preventStrayRequests();

        $this->assertSame(
            'https://unismsapi.com/api',
            config('services.unisms.base_url')
        );
        $this->assertTrue(class_exists(UniSmsService::class));

        config([
            'services.unisms.secret_key' => null,
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        $result = app(UniSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('secret key', $result['message']);

        Http::assertNothingSent();
    }

    public function test_sms_service_sends_json_with_basic_auth_and_a_successful_response(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
            'services.unisms.base_url' => 'https://unismsapi.com/api',
        ]);

        Http::fake([
            'unismsapi.com/api/sms' => Http::response([
                'message' => [
                    'reference_id' => 'msg_test_123',
                    'status' => 'pending',
                    'recipient' => '+639171234567',
                    'sender_id' => 'TEST-SENDER',
                ],
            ], 201),
        ]);

        $result = app(UniSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertTrue($result['success']);
        $this->assertSame('msg_test_123', $result['message_id']);
        $this->assertSame('pending', $result['provider_status']);
        $this->assertSame(201, $result['http_status']);

        Http::assertSent(function ($request): bool {
            return $request->method() === 'POST'
                && $request->url() === 'https://unismsapi.com/api/sms'
                && $request->hasHeader('Content-Type', 'application/json')
                && $request->hasHeader(
                    'Authorization',
                    'Basic '.base64_encode('test-unisms-secret:')
                )
                && $request['recipient'] === '+639171234567'
                && $request['content'] === 'Simulated test message'
                && $request['sender_id'] === 'TEST-SENDER'
                && ! array_key_exists('api_token', $request->data());
        });
    }

    public function test_sms_service_preserves_sanitized_validation_errors(): void
    {
        Http::preventStrayRequests();
        Log::spy();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        Http::fake([
            'unismsapi.com/api/sms' => Http::response([
                'password' => 'provider-private-secret',
                'errors' => [
                    'recipient' => ['Recipient is invalid: +639171234567'],
                    'content' => ['Invalid content: Test secret announcement'],
                ],
            ], 422, [
                'Content-Type' => 'application/json',
            ]),
        ]);

        $result = app(UniSmsService::class)->send(
            '639171234567',
            'Test secret announcement',
            42
        );

        $this->assertFalse($result['success']);
        $this->assertSame(422, $result['http_status']);
        $this->assertFalse($result['outcome_uncertain']);
        $this->assertStringContainsString('Recipient is invalid', $result['message']);
        $this->assertStringNotContainsString('test-unisms-secret', $result['message']);
        $this->assertStringNotContainsString('639171234567', $result['message']);
        $this->assertStringNotContainsString('Test secret announcement', $result['message']);

        Log::shouldHaveReceived('warning')
            ->once()
            ->with(
                'UniSMS did not confirm message acceptance.',
                Mockery::on(function (array $context): bool {
                    $loggedContext = json_encode($context);

                    return $context['delivery_id'] === 42
                        && $context['http_status'] === 422
                        && is_string($loggedContext)
                        && ! str_contains($loggedContext, 'test-unisms-secret')
                        && ! str_contains($loggedContext, 'provider-private-secret')
                        && ! str_contains($loggedContext, '639171234567')
                        && ! str_contains($loggedContext, 'Test secret announcement');
                })
            );
    }

    public function test_unexpected_success_response_is_uncertain_not_accepted(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        Http::fake([
            'unismsapi.com/api/sms' => Http::response([
                'message' => [
                    'reference_id' => 'msg_test_123',
                    'status' => 'pending',
                ],
            ], 200),
        ]);

        $result = app(UniSmsService::class)->send(
            '639171234567',
            'Test message'
        );

        $this->assertFalse($result['success']);
        $this->assertTrue($result['outcome_uncertain']);
        $this->assertStringContainsString('acceptance is uncertain', $result['message']);
    }

    public function test_sms_service_reports_an_empty_response(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        Http::fake([
            'unismsapi.com/api/sms' => Http::response(
                '',
                500,
                ['Content-Type' => 'application/json']
            ),
        ]);

        $result = app(UniSmsService::class)->send(
            '639171234567',
            'Test message'
        );

        $this->assertFalse($result['success']);
        $this->assertSame(500, $result['http_status']);
        $this->assertTrue($result['outcome_uncertain']);
        $this->assertStringContainsString('non-JSON response', $result['message']);
        $this->assertStringContainsString('avoid a duplicate', $result['message']);
    }

    public function test_connection_failure_is_uncertain_without_retrying(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        Http::fake([
            'unismsapi.com/api/sms' => Http::failedConnection(),
        ]);

        $result = app(UniSmsService::class)->send(
            '639171234567',
            'Test message'
        );

        $this->assertFalse($result['success']);
        $this->assertTrue($result['outcome_uncertain']);
        $this->assertStringContainsString('acceptance is unknown', $result['message']);

        Http::assertSentCount(1);
    }

    public function test_http_request_timeout_is_an_uncertain_outcome(): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);
        Http::fake(['unismsapi.com/api/sms' => Http::response(['error' => 'Request timeout'], 408)]);

        $result = app(UniSmsService::class)->send('09171234567', 'Test message');

        $this->assertFalse($result['success']);
        $this->assertTrue($result['outcome_uncertain']);
        $this->assertStringContainsString('acceptance is uncertain', $result['message']);
        Http::assertSentCount(1);
    }

    public function test_sms_service_rejects_missing_sender_id_without_sending(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => '',
        ]);

        $result = app(UniSmsService::class)->send(
            '639171234567',
            'Test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('sender ID', $result['message']);

        Http::assertNothingSent();
    }

    public function test_sms_service_rejects_an_invalid_base_url_without_sending(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
            'services.unisms.base_url' => 'http://example.test/api',
        ]);

        $result = app(UniSmsService::class)->send(
            '639171234567',
            'Test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('base URL is invalid', $result['message']);

        Http::assertNothingSent();
    }

    public function test_sms_service_rejects_an_invalid_mobile_number_without_sending(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        $result = app(UniSmsService::class)->send(
            '0212345678',
            'Simulated test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('valid Philippine mobile', $result['message']);

        Http::assertNothingSent();
    }

    public function test_sms_service_rejects_content_over_the_provider_limit(): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        $result = app(UniSmsService::class)->send('09171234567', str_repeat('a', 671));

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('670', $result['message']);
        Http::assertNothingSent();
    }
}
