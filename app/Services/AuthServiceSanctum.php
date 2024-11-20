<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Exceptions\LoginException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\Interfaces\AuthMethods;

class AuthServiceSanctum implements AuthMethods
{
    public function attempt(string $email, string $password): string
    {
            $user = User::where('email', $email)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $user->createToken($user->email)->plainTextToken;
    }

    /**
     * @throws LoginException
     */
    public function logout(Request $request): void
    {

        $user = $request->user();
         if($user && !$request->user()->currentAccessToken()) {
                throw new LoginException('User is not logged in');
         }

         $request->user()->currentAccessToken()->delete();
    }

    public function forgotPassword(string $email): void
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['The provided email is incorrect.'],
            ]);
        }

        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::send('emails.forgotpassword', ['token' => $token], function($message) use ($email) {
            $message->to($email);
            $message->subject('Reset Password');
        });
    }

    public function resetPassword(string $token, string $email, string $password): void
    {
        $passwordReset = DB::table('password_resets')->where([
            ['token', $token],
            ['email', $email],
        ])->first();

        if (! $passwordReset) {
            throw ValidationException::withMessages([
                'email' => ['Invalid password reset token.'],
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['No user found with this email address.'],
            ]);
        }

        $user->password = Hash::make($password);
        $user->save();

        DB::table('password_resets')->where('email', $email)->delete();
    }

}
