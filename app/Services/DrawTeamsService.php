<?php

namespace App\Services;

use App\Exceptions\DivisionByZeroDrawException;
use App\Exceptions\InsufficientNumberOfPlayersException;
use App\Exceptions\MaximumPlayersException;
use App\Repositories\EventDayRepository;
use Illuminate\Support\Collection;

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

    private function filteredTeams($matchPlayers, $playersByTeam)
    {
        
        if ($playersByTeam > 6) {
            throw new MaximumPlayersException();
        }
        
        // Cria times de acordo com a quantidade de jogadores por time informada
        $totalPlayersByTeam = ceil($matchPlayers->count() / $playersByTeam);
        $teams = $this->createTeamsByChunk($totalPlayersByTeam);        
        
        if(count($teams) < 2) {
            throw new DivisionByZeroDrawException();
        }


        // inicia ponteiros
        $currentTeam = 0;
        $choosedPlayers = collect();
        $goalkeepers = $matchPlayers->where('goalkeeper', '=', true);
        // oredena pela existência de goleiros e em seguida por rating para garantir escolha de goleiros, caso existam goleiros confirmados
        $players = $matchPlayers->sortBy('goalkeeper')->sortByDesc('rating');

        /* Ordena jogadores dos mais fortes para os mais fracos
           e distribui entre dois times alternadamente a fim de garantir equilibrio  */
        foreach ($players as $player) {
            //define jogadores de linha
            if (count($teams[$currentTeam]) < $playersByTeam - 1 && !$player->goalkeeper) {
                $teams[$currentTeam]->push($player->toArray());
                $choosedPlayers->push($player->toArray());
            }

            // Define os goleiros
            if (count($teams[$currentTeam]) == $playersByTeam - 1 && $player->goalkeeper && $goalkeepers->count()) {
                $teams[$currentTeam]->push($player);
                $choosedPlayers->push($player);
            }

            // Escolhe jogadores de linha caso não existam goleiros
            if (count($teams[$currentTeam]) == $playersByTeam - 1 
                && !$goalkeepers->count()
                && !$teams[$currentTeam]->whereIn('id', $player->id)->count()) {
                
                $teams[$currentTeam]->push($player);
                $choosedPlayers->push($player);
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

    private function createTeamsByChunk(int $chunk)
    {
        $collections = [];
        if($chunk > 3) $chunk = 3;

        for ($i = 0; $i < $chunk; $i++) {            
            $collections[] = collect();
        }
        
        return $collections;
    }
}
