<?php

namespace App\Http\Controllers;

use App\Repositories\PlayerRepository;
use Illuminate\Http\Request;
use Exception;

class PlayerController extends Controller
{

    public function __construct(private PlayerRepository $repository)
    {
    }

    public function all()
    {
        try {

            $players = $this->repository->getAll();

            return response()->json($players, 200); 
        } catch (Exception $ex) {
            return response()->json(['message' => 'Bad Request'], 400);
        }
    }

    public function find($id)
    {
        try {
            
            $player = $this->repository->find($id);

            return response()->json($player, 200);
        } catch (Exception $ex) {
            return response()->json(['message' => 'Bad Request'], 400);
        }
    }

    public function create(Request $request)
    {
        
        try {
            $this->repository->create($request->all());

            return response()->json(['message' => 'Success'], 201);
        } catch (Exception $ex) {
            return response()->json(['message' => 'Bad Request'], 400);
        }
    }
    
    public function update($id, Request $request)
    {
        try {
            $this->repository->update($id, $request->all());

            return response()->json(['message' => 'Success'], 200);
        } catch (Exception $ex) {
            return response()->json(['message' => 'Bad Request'], 400);
        }
    }    

    public function delete($id)
    {
        try {

            $this->repository->delete($id);

            return response()->json(['message' => 'No Content'], 204);
        } catch (Exception $ex) {
            return response()->json(['message' => 'Bad Request'], 400);
        }
    }    
}
