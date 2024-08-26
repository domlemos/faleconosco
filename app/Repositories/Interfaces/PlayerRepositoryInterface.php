<?php

namespace App\Repositories\Interfaces;

use App\Models\Player;
use Illuminate\Support\Collection;

interface PlayerRepositoryInterface
{
    public function getAll(): Collection;
    public function find($id): Player;
    public function create(array $data);
    public function update($id, array $data): bool;
    public function delete($id): void;
}
