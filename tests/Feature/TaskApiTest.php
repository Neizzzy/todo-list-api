<?php

use App\DTOs\TaskDto;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function testApiReturnTasks(): void
    {
        $tasks = Task::factory()->count(3)->create();

        $exceptedResource = TaskResource::collection($tasks);
        $exceptedJson = $exceptedResource->response()->getData(true);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);

        $response->assertJson($exceptedJson);
    }

    public function testApiCreateTask()
    {
        $data = new TaskDto('title', 'description', 'status');

        $response = $this->postJson('/api/tasks', $data->toArray());

        $response->assertStatus(201);

        $response->assertJsonFragment($data->toArray());
    }

    public function testApiTaskRequiredValidation()
    {
        $data = new TaskDto('', '', '');

        $response = $this->postJson('/api/tasks', $data->toArray());

        $response->assertStatus(422);

        $this->assertDatabaseEmpty('tasks');
    }

    public function testApiTaskUniqueValidation()
    {
        $task = Task::factory()->create();

        $data = new TaskDto($task->title, '', 'status');

        $response = $this->postJson('/api/tasks', $data->toArray());

        $response->assertStatus(422);

        $this->assertDatabaseCount('tasks', 1);
    }

    public function testApiReturnTask()
    {
        $task = Task::factory()->create();

        $exceptedResource = new TaskResource($task);
        $exceptedJson = $exceptedResource->response()->getData(true);

        $response = $this->getJson("/api/tasks/$task->id");

        $response->assertStatus(200);

        $response->assertJson($exceptedJson);
    }

    public function testApiUpdateTask()
    {
        $task = Task::factory()->create();
        $data = new TaskDto("$task->title upd", "$task->description upd", "$task->status upd");

        $response = $this->putJson("/api/tasks/$task->id", $data->toArray());

        $response->assertStatus(200);

        $response->assertJsonFragment($data->toArray());

        $this->assertDatabaseHas('tasks', $data->toArray());
    }

    public function testApiDeleteTask()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/$task->id");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', $task->toArray());
    }

    public function testApiNotExistedTask()
    {
        $response = $this->getJson('/api/tasks/9');

        $response->assertStatus(404);
    }
}
