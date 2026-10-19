<?php

namespace Tests\Feature;

use App\Services\SemaphoreSmsService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SemaphoreSmsTest extends TestCase
{
    public function test_semaphore_configuration_is_loaded_without_sending_sms(): void
    {
        $this->assertNotEmpty(
            config('services.semaphore.base_url'),
            'Semaphore API base URL is missing.'
        );

        $this->assertStringStartsWith(
            'https://',
            config('services.semaphore.base_url')
        );

        $this->assertTrue(
            class_exists(SemaphoreSmsService::class),
            'Semaphore SMS service class was not found.'
        );

        $this->assertNotEmpty(
            config('services.semaphore.api_key'),
            'SEMAPHORE_API_KEY is missing from your .env configuration.'
        );
    }

    public function test_sms_service_handles_a_simulated_successful_response(): void
    {
        config([
            'services.semaphore.api_key' => 'test-api-key',
            'services.semaphore.base_url' => 'https://api.semaphore.co/api/v4',
            'services.semaphore.sender_name' => '',
        ]);

        Http::fake([
            'api.semaphore.co/*' => Http::response([
                [
                    'message_id' => '123456789',
                    'status' => 'Queued',
                ],
            ], 200),
        ]);

        $result = app(SemaphoreSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertTrue($result['success']);
        $this->assertSame('Queued', $result['provider_status']);
        $this->assertSame('123456789', $result['message_id']);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/api/v4/messages')
                && $request['apikey'] === 'test-api-key'
                && $request['number'] === '09171234567'
                && $request['message'] === 'Simulated test message';
        });
    }

    public function test_sms_service_handles_a_simulated_api_error(): void
    {
        config([
            'services.semaphore.api_key' => 'test-api-key',
            'services.semaphore.base_url' => 'https://api.semaphore.co/api/v4',
            'services.semaphore.sender_name' => '',
        ]);

        Http::fake([
            'api.semaphore.co/*' => Http::response([
                'message' => 'Invalid API key',
            ], 401),
        ]);

        $result = app(SemaphoreSmsService::class)->send(
            '09171234567',
            'Simulated test message'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString(
            'Invalid API key',
            $result['message']
        );
    }
}
