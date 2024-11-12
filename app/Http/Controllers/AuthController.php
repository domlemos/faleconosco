<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Exceptions\LoginException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(Request $request): Response
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $token = $this->authService->attempt($request->email, $request->password);

            return response(['token' => $token], 201);
        } catch (LoginException $ex) {
            return response(['error' => $ex->getMessage()]);
        }
    }
}
