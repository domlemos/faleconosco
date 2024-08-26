<?php

namespace App\Repositories;

use App\Models\EventDay;
use App\Repositories\Interfaces\EventDayRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class EventDayRepository implements EventDayRepositoryInterface
{
    public function __construct(private EventDay $model)
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

    public function find($id): EventDay
    {
        $eventDay = $this->model->find($id);

        if(!$eventDay) {
            throw new Exception('Registro não encontrado', 400);
        }

        return $eventDay;
    }

    public function update($id, $data): bool
    {
        $eventDay = $this->find($id);

        return $eventDay->update($data);
    }

    public function delete($id): void
    {
        $eventDay = $this->find($id);        

        $eventDay->delete();
    }   

    public function findPlayersByEventId($id)
    {   
        $event = $this->model->find($id);

        return $event->players()->get();
    }
}
