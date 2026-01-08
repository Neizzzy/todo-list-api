<?php

namespace App\Services;

use App\DTOs\TaskDto;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskService
{
    public function getAllTasks(): Collection
    {
        return Task::all();
    }

    public function createTask(TaskDto $taskDto): Task
    {
        return Task::create($taskDto->toArray());
    }

    public function updateTask(TaskDto $taskDto, Task $task): Task
    {
        $task->update($taskDto->toArray());
        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }
}
