<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public function enviarEmailNoPrimeiroAcesso($user): void
    {
        Mail::send('emails.primeiro-acesso', ['user' => $user], function ($message) use ($user) {
            $message->to($user['email'], $user['name'])->subject('Seja bem-vindo ao sistema YetzDesk');
        });
    }
}
