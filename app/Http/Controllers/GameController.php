<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Franchise;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['franchise', 'genres', 'images'])->get();

        return response()->json([
            'message' => 'ყველა თამაში წარმატებით ჩაიტვირთა.',
            'data' => $games,
        ], 200);
    }

    public function show(Game $game)
    {
        return response()->json($game->load(['images', 'genres', 'reviews']));
    }

    public function store(StoreGameRequest $request)
    {
        $user = auth()->user();

        if (!$user->isDeveloper()) {
            return response()->json(['message' => 'მხოლოდ დეველოპერებს შეუძლიათ თამაშის დამატება.'], 403);
        }

        $validated = $request->validated();


        $franchise = Franchise::find($validated['franchise_id']);
        if (!$franchise || $franchise->developer_id !== $user->developer->id) {
            return response()->json(['message' => 'ფრენჩაიზის დამატების უფლება არ გაქვთ.'], 403);
        }

        $game = Game::create($validated);

        return response()->json([
            'message' => 'თამაში წარმატებით შეიქმნა.',
            'data' => $game,
        ], 201);
    }

    public function update(UpdateGameRequest $request, Game $game)
    {
        $user = auth()->user();
        if (!$user->isDeveloper()) {
            return response()->json(['message' => 'მხოლოდ დეველოპერებს შეუძლიათ თამაშის განახლება.'], 403);
        }

        $validated = $request->validated();

        $franchise = $game->franchise;
        if (!$franchise || $franchise->developer_id !== $user->developer->id) {
            return response()->json(['message' => 'ამ თამაშის განახლების უფლება არ გაქვთ.'], 403);
        }

        $game->update($validated);

        return response()->json([
            'message' => 'თამაში წარმატებით განახლდა.',
            'data' => $game,
        ], 200);
    }

    public function destroy(Game $game)
    {

        $user = auth()->user();
        if (!$user->isDeveloper()) {
            return response()->json(['message' => 'მხოლოდ დეველოპერებს შეუძლიათ თამაშის წაშლა.'], 403);
        }


        $franchise = $game->franchise;
        if (!$franchise || $franchise->developer_id !== $user->developer->id) {
            return response()->json(['message' => 'ამ თამაშის წაშლის უფლება არ გაქვთ.'], 403);
        }

        $game->delete();

        return response()->json([
            'message' => 'თამაში წარმატებით წაიშალა.',
        ], 200);
    }
}
