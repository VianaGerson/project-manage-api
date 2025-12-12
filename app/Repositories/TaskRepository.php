<?php
namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function toggleCompleted(Task $task): Task
    {
        $task->completed = !$task->completed;
        $task->save();
        return $task;
    }

    /**
     * @param Task $task
     * @return void
     */
    public function delete(Task $task): void
    {
        $task->delete();
    }
}