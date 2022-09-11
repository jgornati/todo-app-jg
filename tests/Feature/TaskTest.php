<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_show_all_tasks()
    {

        $tasks = Task::factory(3)->create();

        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
        $response
            ->assertJson(fn(AssertableJson $json) => $json->has(3)
                ->first(fn($json) => $json->where('id', $tasks[0]->id)
                    ->where('title', $tasks[0]->title)
                    ->etc()
                )
            );

    }

    public function test_should_create_task()
    {

        $task = Task::factory()->make();

        $fakeRequest = ["task" => json_decode($task,true)];

        $response = $this->post('/api/task/store', $fakeRequest);

        $response->assertStatus(201);
        $response->assertJson($task->toArray());

    }

    public function test_should_update_title_task()
    {

        $task = Task::factory()->create();
        $task->title = "Modified";

        $fakeRequest = ["task" => json_decode($task,true)];

        $response = $this->put('/api/task/' . $task->id, $fakeRequest);

        $response->assertStatus(200);
        $response->assertJson($task->toArray());

    }

    public function test_should_update_status_task()
    {

        $task = Task::factory()->create();
        $task->completed = true;

        $fakeRequest = ["task" => json_decode($task,true)];

        $response = $this->put('/api/task/' . $task->id, $fakeRequest);

        $response->assertStatus(200);
        $response->assertJson($task->toArray());

    }

    public function test_should_delete_task()
    {

        $task = Task::factory()->create();

        $fakeRequest = ["task" => json_decode($task,true)];

        $response = $this->delete('/api/task/' . $task->id, $fakeRequest);

        $response->assertStatus(200);
        $response->assertJson($task->toArray());

    }

    public function test_should_delete_all_tasks()
    {
        $tasks = Task::factory(3)->create();

        foreach ($tasks as $task) {
            $task->deleted = true;
        }

        $fakeRequest = ["tasks" => json_decode($tasks,true)];

        $response = $this->post('/api/task', $fakeRequest);

        $response->assertStatus(200);
        $response->assertJson($tasks->toArray());

    }

    public function test_should_delete_selected_tasks()
    {
        $tasks = Task::factory(6)->create();

        $fakeRequest = ["tasks" => $tasks];
        foreach ($tasks as $key => $task) {
            if ($key % 2 === 0)
                $task->deleted = true;
        }

        $response = $this->post('/api/task', $fakeRequest);

        $response->assertStatus(200);
        $response->assertJson($tasks->toArray());
    }

}
