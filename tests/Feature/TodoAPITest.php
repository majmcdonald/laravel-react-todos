<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Todo;

class TodoAPITest extends TestCase
{
    
    use WithFaker;


    /**
     * View a Single Todo
     *
     * @return void
     */
    public function testViewTodo()
    {
        $todo = factory(Todo::class)->create();
        $response = $this->json('GET', '/api/todo/'.$todo->id);

        $response
            ->assertStatus(200)
            ->assertJson([
            'data' => [ 
                'id' => $todo->id,
                'name' => $todo->name,
                'description' => $todo->description,
            ]]);
    }

    /**
     * Create a new Todo using the API
     *
     * @return void
     */
    public function testCreateTodo()
    {
        $data = [
            'name' => $this->faker->word,
        ];

        $response = $this->json('POST', '/api/todo', $data);

        $response
            ->assertStatus(201)
            ->assertJson([
            'data' => [ 
                'name' => $data['name'],
            ]]);
    }

    /**
     * List all the todos using the API
     *
     * @return void
     */
    public function testListTodos()
    {
        $todo = factory(Todo::class)->create();
        $response = $this->json('GET', '/api/todo');
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }

    /**
     * Edit a Todo using the API
     *
     * @return void
     */
    public function testEditTodo()
    {
        $todo = factory(Todo::class)->create();
        $data = [
            'name' => $this->faker->word,
            'status' => 'done',
            'due_date'=>'2018/01/01',
        ];

        $response = $this->json('PUT', '/api/todo', $data);
        $response
            ->assertStatus(200)
            ->assertJson([
            'data' => [ 
                'name' => $data['name'],
                'status' => $data['status'],
                'due_date' => $data['due_date'],
            ]]);
    }

    /**
     * Delete a Todo using the API
     *
     * @return void
     */
    public function testDeleteTodo()
    {
        $todo = factory(Todo::class)->create();
        $response = $this->json('DELETE', '/api/todo'.$todo->id);
        $response
            ->assertStatus(204);
    }

    /**
     * Verify we get an error when trying to view a Todo that doesn't exist
     *
     * @return void
     */
    public function testErrorViewingInvalidTodo()
    {
        $response = $this->json('GET', '/api/todo/0');
        $response
            ->assertStatus(400);
    }

    /**
     * Verify we get an error when trying to set an invalid status
     *
     * @return void
     */
    public function testErrorUpdateInvalidStatus()
    {
        $todo = factory(Todo::class)->create();
        $data = [
            'name' => $this->faker->word,
            'status' => 'out to lunch'
        ];

        $response = $this->json('PUT', '/api/todo/'.$todo->id, $data);
        $response
            ->assertStatus(422);
    }

    /**
     * Verify we get an error when trying to create a todo without required fields
     *
     * @return void
     */
    public function testErrorCreateWithFieldsMissing()
    {
        $response = $this->json('POST', '/api/todo', []);
        $response
            ->assertStatus(422);
    }
}
