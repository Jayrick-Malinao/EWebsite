<?php

namespace App\Http\Controllers;

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

        $validated = $request->validateWithBag('updateProfile', [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$user->id}"],
        ]);

        $user->update($validated);

        return back()->with('success', 'Your profile has been updated.');
    }

    /**
     * Change the logged-in administrator's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Your password has been changed.');
    }
}