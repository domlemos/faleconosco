<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Services\AuthSanctumService;
use App\Exceptions\LoginException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthSanctumController extends Controller
{
    public function __construct(private AuthSanctumService $authService)
    {
    }

    public function login(Request $request): Response
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'The email field is required',
                'email.email' => 'The email field must be a valid email',
                'password.required' => 'The password field is required'
            ]);

            $sessionData = $this->authService->attempt($request->email, $request->password);

            return response(['data' => collect($sessionData)], 200);
        } catch (LoginException $ex) {
            return response(['data' => [ 'error' => $ex->getMessage()]], 422);
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

    public function resetPasswordView($email, $token): View | Response
    {
        try {

            $this->authService->checkToken($email, $token);

            return view('emails.reset-password', ['token' => $token, 'email' => $email]);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    public function resetPassword(Request $request): Response
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required'
            ]);

            $this->authService->resetpassword($request->token, $request->email, $request->password);

            return response(null, 200);
        } catch (AuthException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function preflight(Request $request)
    {

        $this->authService->checkTokenToPreflight($request->token);


        return response(true, 200);
    }

}
