<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|max:250',
            'description' => 'string',
            'board_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $taskId = Task::query()->insertGetId($request->all());
        $task = Task::query()->where('id', '=', $taskId);

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

    public function index() {
        $tasks = Task::query()->get();

        return response()->json([
            'success' => true,
            'date' => $tasks
        ], Response::HTTP_OK);
    }

    public function done(Request $request) {
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

    public function moveToUrgent(Request $request) {
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

    public function delete(Request $request) {
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
