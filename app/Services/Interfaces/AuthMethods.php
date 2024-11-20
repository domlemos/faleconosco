<?php

namespace App\Services\Interfaces;
use Illuminate\Http\Request;

interface AuthMethods
{
    public function attempt(string $email, string $password): string;
    public function logout(Request $request): void;
    public function forgotPassword(string $email): void;
    public function resetPassword(string $token, string $email, string $password): void;
}
