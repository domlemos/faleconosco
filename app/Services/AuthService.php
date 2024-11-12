<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function attempt(string $email, string $password): string
    {
            $user = User::where('email', $email)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $user->createToken('umnome')->plainTextToken;
    }
}
