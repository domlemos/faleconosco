<?php

namespace App\Services;

use App\Repositories\TeamRepository;

class BuildTeamService
{
    public function __construct(
        private TeamRepository $teamRepository,
        private DrawTeamsService $drawTeamsService,
    )
    {
    }

    public function addToTeam($id, array $data)
    {
        $team = $this->teamRepository->find($id);
        
        return $team->players()->attach($data);
    }

    public function removeFromTeam($id, array $data)
    {
        $team = $this->teamRepository->find($id);        
        
        return $team->players()->detach($data);
    }

    public function createTeamsWithPlayers($playerByTeam, $eventId)
    {
        $teams = collect($this->drawTeamsService->drawTeams($playerByTeam, $eventId));

        $teams->each(function($playersTeam) use ($eventId) {
            $team = $this->teamRepository->create([
                'name' =>  'time',
                'rating' => $playersTeam->avg('rating'),
                'event_id' => $eventId,
            ]);
            
            $this->addToTeam($team->id, $playersTeam->pluck('id')->toArray());
        });
    }
}
