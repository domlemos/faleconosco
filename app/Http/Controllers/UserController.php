<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Exceptions\UserException;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository, private UserService $userService)
    {
    }

    public function index(Request $request): Response
    {
        try {

            return response($this->userRepository->getAll(), 200);
        } catch (UserException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function show($id): Response
    {
        try {
            return response($this->userRepository->find($id), 200);
        } catch (UserException $ex) {
            return response($ex->getMessage(), 422);
        }
    }

    public function store(Request $request): Response
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'type' => 'required|in:admin,user',
            ]);

            $passwordToUser = $this->userRepository->generatePassword();

            $request->merge([
                'password' => bcrypt($passwordToUser)
            ]);

            $this->userRepository->create($request->all());

            $emailUserData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $passwordToUser
            ];

            $this->userService->enviarEmailNoPrimeiroAcesso($emailUserData);

            return response(null, 201);

        } catch (UserException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function update($id, Request $request): Response
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'type' => 'required|in:admin,user',
            ]);

            $this->userRepository->update($id, $request->all());

            return response(null, 200);
        } catch (AuthException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function updatePassword($id, Request $request): Response
    {
        try {
            $request->validate([
                'password' => 'required',
            ]);

            $this->userRepository->update($id, $request->all());

            return response(null, 200);
        } catch (AuthException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function destroy($id): Response
    {
        try {

            $this->userRepository->delete($id);
            return response(null, 200);
        } catch (AuthException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }

    public function getTypes()
    {
        try {
            return response()->json(['data' => $this->userRepository->getUserTypes()], 200);
        } catch (AuthException $ex) {
            return response(['error' => $ex->getMessage()], 422);
        }
    }
}
