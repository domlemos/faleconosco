<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getAll(): Collection;
    public function find($id): User;
    public function create(array $data);
    public function update($id, array $data): bool;
    public function delete($id): void;
}
