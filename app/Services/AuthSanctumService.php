<?php

namespace App\Services;

use App\Exceptions\AuthException;
use App\Models\SessionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Exceptions\LoginException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\Interfaces\AuthMethods;
use Illuminate\Http\Response;

class AuthSanctumService implements AuthMethods
{
    public function attempt(string $email, string $password): SessionData
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($user->email, [$user->type])->plainTextToken;

        return new SessionData($token, $user->name, $user->type);
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

        $checkExists = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if ($checkExists) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
        }

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::send('emails.forgotpassword', ['token' => $token, 'email' => $email], function($message) use ($email) {
            $message->to($email);
            $message->subject('Reset Password');
        });
    }

    /**
     * @throws AuthException
     */
    public function resetPassword(string $token, string $email, string $password): void
    {
        $this->checkToken($email, $token);

        $user = User::where('email', $email)->first();

        if (! $user) {
            throw new AuthException();
        }

        $user->password = Hash::make($password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }

    /**
     * @throws AuthException
     */
    public function checkToken($email, $token): Object
    {
        $result = DB::table('password_reset_tokens')
            ->where('email', '=', $email)
            ->where('token', '=', $token)
            ->first();

        if(!$result) {
            throw new AuthException('Bad Request');
        }

        return $result;
    }

    public function checkTokenToPreflight(): Response
    {
        return response(true, 200);
    }
}
