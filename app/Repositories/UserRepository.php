<?php

namespace App\Repositories;

use App\Models\Player;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class UserRepository implements PlayerRepositoryInterface
{
    public function __construct(private Player $model)
    {

    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): void
    {
        $this->model->create($data);
    }

    public function find($id): Player
    {
        $player = $this->model->find($id);

        if(!$player) {
            throw new Exception('Registro não encontrado', 400);
        }

        return $player;
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
}
