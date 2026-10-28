<?php

namespace App\Http\Middleware;

use App\Support\PhilippineMobileNumberFormatter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NormalizePhilippineMobileNumbers
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->merge(
            $this->normalizePhoneNumbers($request->all())
        );

        return $next($request);
    }

    /**
     * @param  array<string|int, mixed>  $input
     * @return array<string|int, mixed>
     */
    private function normalizePhoneNumbers(array $input): array
    {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = $this->normalizePhoneNumbers($value);

                continue;
            }

            if (
                is_string($value)
                && in_array($key, [
                    'contact_number',
                    'emergency_contact_number',
                    'caregiver_contact',
                    'phone',
                    'phone_number',
                    'mobile_number',
                    'telephone_number',
                ], true)
            ) {
                $input[$key] = $this->normalizeMobileNumber($value);
            }
        }

        return $input;
    }

    private function normalizeMobileNumber(string $value): string
    {
        if (preg_match('/\A\+?63\s*\z/', trim($value)) === 1) {
            return '';
        }

        return PhilippineMobileNumberFormatter::normalize($value);
    }
}
