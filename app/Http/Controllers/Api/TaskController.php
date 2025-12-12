<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function indexDifficulties()
    {
        $difficulties = $this->taskService->getAllDifficulties();
        return response()->json($difficulties);
    }

    public function storeTask(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'difficulty_id' => 'required|exists:difficulties,id',
        ]);

        $task = $this->taskService->createTask($data);
        return response()->json($task, 201);
    }

    public function toggleTask(Task $task)
    {
        $updatedTask = $this->taskService->toggleTaskCompletion($task);
        return response()->json($updatedTask);
    }

    public function destroyTask(Task $task)
    {
        $this->taskService->deleteTask($task);
        return response()->json(null, 204);
    }
}
