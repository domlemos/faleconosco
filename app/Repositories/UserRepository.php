<?php

namespace App\Repositories;

use App\Exceptions\UserException;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\UserType;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $model)
    {

    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @throws UserException
     */
    public function create(array $data): void
    {
        try {
            $this->model->create($data);

        } catch (Exception $ex) {
            throw new UserException();
        }
    }

    public function find($id): User
    {
        $user = $this->model->find($id);

        if(!$user) {
            throw new Exception('Registro não encontrado', 400);
        }

        return $user;
    }

    public function update($id, $data): bool
    {
        $player = $this->find($id);

        return $player->update($data);
    }

    public function delete($id): void
    {
        $player = $this->find($id);

        $player->delete();
    }

    public function getUserTypes(): array
    {
         return UserType::getUserTypes();
    }

    public function generatePassword(): string
    {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';

        return substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
    }
}
