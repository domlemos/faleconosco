<?php

namespace App\Services;

use App\Exceptions\DivisionByZeroDrawException;
use App\Exceptions\InsufficientNumberOfPlayersException;
use App\Exceptions\MaximumPlayersException;
use App\Repositories\EventDayRepository;
use Illuminate\Support\Collection;
use App\Models\Player;

class DrawTeamsService
{  

    public function __construct(private EventDayRepository $eventDayRepository)
    {
    }

    public function drawTeams($playersByTeam, $eventId)
    {
        $matchPlayers = $this->eventDayRepository->findPlayersByEventId($eventId);

        return $this->buildTeam($matchPlayers, $playersByTeam);
    }

    public function buildTeam(Collection $matchPlayers, $playersByTeam)
    {

        if(!$playersByTeam) {
            throw new DivisionByZeroDrawException();
        }

        $totalCompleteTeams = floor($matchPlayers->count() / $playersByTeam);

        if ($totalCompleteTeams < 2) {
            throw new InsufficientNumberOfPlayersException();
        }                

        return $this->filteredTeams($matchPlayers, $playersByTeam);
    }

    private function filteredTeams($matchPlayers, $playersByTeam): array
    { 
        
        if ($playersByTeam > 6) {
            throw new MaximumPlayersException();
        }

        return $this->splitTeams($matchPlayers, $playersByTeam);
    }

    private function createTeamsByChunk(int $chunk): array
    {
        $collections = [];
        if($chunk > 3) $chunk = 3;

        for ($i = 0; $i < $chunk; $i++) {            
            $collections[] = collect();
        }
        
        return $collections;
    }

    private function splitTeams(Collection $matchPlayers, int $playersByTeam): array
    {
         // Cria times de acordo com a quantidade de jogadores por time informada
         $totalPlayersByTeam = ceil($matchPlayers->count() / $playersByTeam);
         $teams = $this->createTeamsByChunk($totalPlayersByTeam);        
         
         if(count($teams) < 2) {
             throw new DivisionByZeroDrawException();
         } 
         
         $currentTeam = 0;
         $choosedPlayers = collect();        
         // ordena por rating e pela existência de goleiros
         $players = $matchPlayers->sortByDesc('rating')->sortByDesc('goalkeeper');        
         /* Ordena jogadores dos mais fortes para os mais fracos
            e distribui entre dois times alternadamente a fim de garantir equilibrio  */
         foreach ($players as $player) {

            // Define os goleiros 
            if (!$teams[$currentTeam]->where('goalkeeper', true)->count() && $player->goalkeeper) {
                $teams[$currentTeam]->push($player->toArray());
                $choosedPlayers->push($player->toArray());
            }
             //define jogadores de linha
             if ($teams[$currentTeam]->count() < $playersByTeam && !$player->goalkeeper) {
                $teams[$currentTeam]->push($player->toArray());
                $choosedPlayers->push($player->toArray());
             }

             if ($currentTeam < 1) {
                 $currentTeam++;                
             } else {
                 $currentTeam = 0;
             }            
         }
         // jogadores restantes
         $teams[count($teams) - 1] = $matchPlayers->whereNotIn('id', $choosedPlayers->pluck('id'))->values();

         return $teams;
    }
}
