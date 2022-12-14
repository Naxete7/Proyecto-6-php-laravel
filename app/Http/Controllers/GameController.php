<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class GameController extends Controller
{
    public function createAGame(Request $request)
    {

        try {

            $userId = auth()->user()->id;
            $name = $request->input('name');
           
            $newGame= new Game();
            $newGame->name=$name;
            $newGame->userId=$userId;
            $newGame->save();

                return response()->json([
                    'success' => true,
                    'message' => "Game created"
                ], 201);
            } catch (\Throwable $th) {
            return response([
                'success' => false,
                'message' => "the game could not be created => " . $th->getMessage(),
            ], 500);
        }
    }


    public function getAllGames()
    {
        try {
            $games = Game::query()->get();
            return response()->json([
                'success' => true,
                'message' => 'Games retrieved',
                'data' => $games
            ]);
        } catch (\Throwable $th) {
            Log::error("Error retrieving games: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Could not retrieve games'
            ], 500);
        }
    }

    public function getGameByName($name)
    {
        try {
            $game = Game::where('name', $name)->get();

            return response()->json([
                'success' => true,
                'message' => 'Game retrieved',
                'data' => $game
            ]);
        } catch (\Throwable $th) {
            

            return response()->json([
                'success' => true,
                'message' => 'Could not retrieve game' . $th->getMessage()
            ], 500);
        }
    }

        public function updatedGame(Request $request, $id)
        {

    try{
            $userId = auth()->user()->id;
            
            $game = Game::find($userId);
            $game->name = $request->input('name');

            $game->save();
            
            return response([
                'success' => true,
                'message' => 'Game update successfully.'
            ], 200);
    }catch(\Throwable $th){

        return response()->json([
            'succes'=>false,
            'message'=>'The game could not updated'  . $th->getMessage()
        ],500);
    }

        }


    public function deleteGameByName($name)
    {
        try {
            $game = Game::where('name', $name)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Game deleted',
                
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => true,
                'message' => 'Could not delete game'
            ], 500);
        }
    }
}
