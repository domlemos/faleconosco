<?php

namespace App\Http\Controllers;

use App\Services\DrawTeamsService;
use App\Repositories\EventDayRepository;
use Exception;
use App\Exceptions\DivisionByZeroDrawException;
use App\Exceptions\InsufficientNumberOfPlayersException;
use App\Exceptions\MaximumPlayersException;
use App\Services\PresenceConfirmService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private DrawTeamsService $drawTeamsService,
        private EventDayRepository $repository,
        private PresenceConfirmService $presenceConfirmService,
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

    public function create(Request $request)
    {
        
        try {
            $this->repository->create($request->all());

            return response()->json(['message' => 'Success'], 201);
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

    public function drawTeams($playersByTeam, $id)
    {
        
        try {
            $data = $this->drawTeamsService->drawTeams($playersByTeam, $id);

            return response()->json($data , 200);
        } catch (DivisionByZeroDrawException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (InsufficientNumberOfPlayersException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (InsufficientNumberOfPlayersException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (MaximumPlayersException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function presenceConfirm($id, Request $request)
    {   
        try {
            $this->presenceConfirmService->presenceConfirm($id, $request->all());

            return response()->json(['message' => 'Success'], 201);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    public function cancelAttenance($id, Request $request)
    {   
        try {
            $this->presenceConfirmService->cancelAttenance($id, $request->all());

            return response()->json(['message' => 'Success'], 201);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }    

    public function findPlayersByEventId($id)
    {   
        try {
            $players = $this->repository->findPlayersByEventId($id);

            return response()->json($players, 200);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }
}
