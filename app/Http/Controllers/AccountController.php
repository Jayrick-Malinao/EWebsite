<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PersonName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Update the logged-in administrator's name and email.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->merge([
            'first_name' => trim((string) $request->input('first_name', '')),
            'middle_name' => trim((string) $request->input('middle_name', '')),
            'last_name' => trim((string) $request->input('last_name', '')),
            'email' => strtolower(trim((string) $request->input('email', ''))),
        ]);

        $validated = $request->validateWithBag('updateProfile', [
            'first_name' => ['required', 'string', 'max:255', new PersonName],
            'middle_name' => ['nullable', 'string', 'max:255', new PersonName],
            'last_name' => ['required', 'string', 'max:255', new PersonName],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$user->id}"],
        ]);

        $user->update([
            'name' => User::makeFullName([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
            ]),
            'email' => $validated['email'],
        ]);

        return back()->with('success', 'Your profile has been updated.');
    }

    /**
     * Change the logged-in administrator's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Your password has been changed.');
    }
}
