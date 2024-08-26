<?php

namespace App\Repositories;

use App\Models\Team;
use App\Repositories\Interfaces\TeamRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class TeamRepository implements TeamRepositoryInterface
{
    public function __construct(private Team $model)
    {
        
    }    

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Team
    {   
        return $this->model->create($data);
    }

    public function find($id): Team
    {
        $team = $this->model->find($id);

        if(!$team) {
            throw new Exception('Registro não encontrado', 400);
        }

        return $team;
    }

    public function update($id, $data): bool
    {
        $team = $this->find($id);

        return $team->update($data);
    }

    public function delete($id): void
    {
        $team = $this->find($id);        

        $team->delete();
    }

    public function getPlayersByTeamId($id): Collection
    {
        $team = $this->find($id);        

        return $team->players;
    }
}
