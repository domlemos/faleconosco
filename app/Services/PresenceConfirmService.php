<?php

namespace App\Services;

use App\Repositories\EventDayRepository;

class PresenceConfirmService
{
    public function __construct(      
        private EventDayRepository $eventDayRepository,
    )
    {
    }

    public function presenceConfirm($id, array $data)
    {
        $event = $this->eventDayRepository->find($id);        
        
        return $event->players()->attach($data);
    }

    public function cancelAttenance($id, array $data)
    {
        $event = $this->eventDayRepository->find($id);
        
        return $event->players()->detach($data);
    }
}
