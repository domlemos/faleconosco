<?php

namespace App\Repositories\Interfaces;

use App\Models\EventDay;
use Illuminate\Support\Collection;

interface EventDayRepositoryInterface
{
    public function getAll(): Collection;
    public function find($id): EventDay;
    public function create(array $data);
    public function update($id, array $data): bool;
    public function delete($id): void;
}
