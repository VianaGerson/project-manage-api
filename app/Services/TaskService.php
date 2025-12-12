<?php
namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
   * @return Collection
   */
    public function getAllDifficulties()
    {
        return \App\Models\Difficulty::all();
    }

    /**
     * @param array $data
     * @return Task
     */
    public function createTask(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function toggleTaskCompletion(Task $task): Task
    {
        return $this->taskRepository->toggleCompleted($task);
    }

    /**
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task): void
    {
        $this->taskRepository->delete($task);
    }
}