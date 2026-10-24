<?php

namespace Tests\Feature;

use App\Services\PhilSmsService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PhilSmsTest extends TestCase
{
    public function test_philsms_configuration_loads_without_sending_sms(): void
    {
        Http::preventStrayRequests();

        $this->assertSame(
            'https://app.philsms.com/api/v3',
            config('services.philsms.base_url')
        );

        $this->assertTrue(class_exists(PhilSmsService::class));

        config([
            'services.philsms.api_token' => null,
            'services.philsms.sender_id' => 'EWebsite',
        ]);

        $result = app(PhilSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('API token', $result['message']);

        Http::assertNothingSent();
    }

    public function test_sms_service_handles_a_simulated_successful_response(): void
    {
        config([
            'services.philsms.api_token' => 'test-api-token',
            'services.philsms.sender_id' => 'EWebsite',
            'services.philsms.base_url' => 'https://app.philsms.com/api/v3',
        ]);

        Http::fake([
            'app.philsms.com/api/v3/sms/send' => Http::response([
                'status' => 'success',
                'data' => [
                    [
                        'uid' => 'test-message-123',
                        'status' => 'queued',
                    ],
                ],
            ], 200),
        ]);

        $result = app(PhilSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertTrue($result['success']);
        $this->assertSame('test-message-123', $result['message_id']);
        $this->assertSame('queued', $result['provider_status']);

        Http::assertSent(function ($request): bool {
            return $request->url() ===
                'https://app.philsms.com/api/v3/sms/send'
                && $request->hasHeader(
                    'Authorization',
                    'Bearer test-api-token'
                )
                && $request['recipient'] === '639171234567'
                && $request['sender_id'] === 'EWebsite'
                && $request['type'] === 'plain'
                && $request['message'] === 'Simulated test message';
        });
    }

    public function test_sms_service_handles_a_simulated_api_error(): void
    {
        config([
            'services.philsms.api_token' => 'test-api-token',
            'services.philsms.sender_id' => 'EWebsite',
            'services.philsms.base_url' => 'https://app.philsms.com/api/v3',
        ]);

        Http::fake([
            'app.philsms.com/api/v3/sms/send' => Http::response([
                'status' => 'error',
                'message' => 'Invalid API token',
            ], 401),
        ]);

        $result = app(PhilSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString(
            'Invalid API token',
            $result['message']
        );
    }

    public function test_sms_service_does_not_send_when_token_is_missing(): void
    {
        Http::preventStrayRequests();

        config([
            'services.philsms.api_token' => '',
            'services.philsms.sender_id' => 'EWebsite',
        ]);

        $result = app(PhilSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('API token', $result['message']);

        Http::assertNothingSent();
    }
}