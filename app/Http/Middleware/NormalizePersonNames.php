<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NormalizePersonNames
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->request->replace($this->normalizeNameFields($request->request->all()));

        return $next($request);
    }

    /**
     * @param  array<string|int, mixed>  $input
     * @return array<string|int, mixed>
     */
    private function normalizeNameFields(array $input): array
    {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = $this->normalizeNameFields($value);

                continue;
            }

            if (
                is_string($value)
                && in_array($key, [
                    'attended_by',
                    'emergency_contact_name',
                    'first_name',
                    'last_name',
                    'middle_name',
                ], true)
            ) {
                $titleCasedValue = mb_convert_case(trim($value), MB_CASE_TITLE, 'UTF-8');
                $input[$key] = preg_replace_callback(
                    '/(?<=[\'\x{2019}-])\p{L}/u',
                    fn (array $matches): string => mb_strtoupper($matches[0], 'UTF-8'),
                    $titleCasedValue,
                ) ?? $titleCasedValue;
            }
        }

        return $input;
    }
}
