<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Response;

class BoardController extends Controller
{
    public function index() {
        $boards = Board::query()->get();

        return response()->json([
            'success' => true,
            'date' => $boards
        ], Response::HTTP_OK);
    }
}
