<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $genres = Genre::all();

        return response()->json([
            'data' => $genres,
            'message' => 'Available genres retrieved successfully.',
        ]);
    }
}
