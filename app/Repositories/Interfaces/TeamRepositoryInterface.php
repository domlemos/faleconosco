<?php

namespace App\Repositories\Interfaces;

use App\Models\Team;
use Illuminate\Support\Collection;

interface TeamRepositoryInterface
{
    public function getAll(): Collection;
    public function find($id): Team;
    public function create(array $data);
    public function update($id, array $data): bool;
    public function delete($id): void;
}
