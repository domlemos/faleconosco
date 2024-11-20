<?php

namespace App\Http\Controllers;

use App\Services\AuthServiceSanctum;
use App\Exceptions\LoginException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthSanctumController extends Controller
{
    public function __construct(private AuthServiceSanctum $authService)
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

            return response(['token' => $token], 200);
        } catch (LoginException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function logout(Request $request): Response
    {
        try {

            $this->authService->logout($request);
        } catch (LoginException $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }

        return response(null, 200);
    }

    public function forgotPassword(Request $request): Response
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $this->authService->forgotpassword($request->email);

            return response(null, 200);
        } catch (ValidationException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function resetPassword(Request $request): Response
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required|confirmed'
            ]);

            $this->authService->resetpassword($request->email, $request->token, $request->password);

            return response(null, 200);
        } catch (ValidationException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

}
