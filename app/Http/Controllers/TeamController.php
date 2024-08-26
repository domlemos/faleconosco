<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Repositories\TeamRepository;
use App\Services\BuildTeamService;

class TeamController extends Controller
{
    public function __construct(
        private TeamRepository $repository,
        private BuildTeamService $buildTeamService,
    )
    {
    }

    public function all()
    {
        try {

            $team = $this->repository->getAll();

            return response()->json($team, 200); 
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    public function find($id)
    {
        try {
            
            $team = $this->repository->find($id);

            return response()->json($team, 200);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    public function playersByTeamId($id)
    {
        try {
            
            $team = $this->repository->getPlayersByTeamId($id); 

            return response()->json($team, 200);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }    
    
    public function update($id, Request $request)
    {
        try {
            $this->repository->update($id, $request->all());

            return response()->json(['message' => 'Success'], 200);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }    

    public function delete($id)
    {
        try {

            $this->repository->delete($id);

            return response()->json(['message' => 'No Content'], 204);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    public function persistTeams(Request $request)
    {
        try {
            
            $this->buildTeamService->createTeamsWithPlayers($request->players_by_team, $request->event_id);

            return response()->json(['message' => 'Success'], 200);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }
}
