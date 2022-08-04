<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:1|max:250',
            'board' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $taskId = Task::query()->insertGetId([
            'title' => $request->get('title'),
            'board_id' => $request->get('board')
        ]);
        $task = Task::query()->where('id', '=', $taskId)->first();

        if (!empty($task)) {
            return response()->json([
                'success' => true,
                'data' => $task
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'data' => $task
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:boards,id',
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $tasks = Task::query()
            ->where('board_id', '=', $request->get('id'))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ], Response::HTTP_OK);
    }

    public function all()
    {
        $boards = Board::query()->get()->toArray();

        for ($i = 0; $i < count($boards); $i++) {
            $tasks = Task::query()
                ->where('board_id', '=', $boards[$i]["id"])
                ->orderBy('status')
                ->get()
                ->toArray();

            $boards[$i]["tasks"] = $tasks;
            $boards[$i]["count"] = count($tasks);
        }

        return response()->json([
            'success' => true,
            'data' => $boards
        ], Response::HTTP_OK);
    }

    public
    function done(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Task::query()->where('id', '=', $request->get('id'))->update([
            'status' => 1
        ]);

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    public
    function undone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Task::query()->where('id', '=', $request->get('id'))->update([
            'status' => 0
        ]);

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    public
    function moveToUrgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $board = Board::query()->where('name', '=', 'Urgent')->first();

        $task = Task::query()->where('id', '=', $request->get('id'))->update([
            'board_id' => $board->id
        ]);

        return response()->json(['success' => true, 'data' => $task], Response::HTTP_OK);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Task::query()->where('id', '=', $request->get('id'))->delete();

        return response()->json(['success' => true], Response::HTTP_OK);
    }
}
