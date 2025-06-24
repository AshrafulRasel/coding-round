<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Add a task
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $task = Task::create($data);
        return response()->json($task, 201);
    }

    // Mark task as completed or update is_completed
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->update($request->validated());

        return response()->json($task);
    }

    // Get pending tasks (is_completed = false)
    public function pending(): JsonResponse
    {
        $tasks = Task::where('is_completed', false)->get();
        return response()->json($tasks);
    }
}
