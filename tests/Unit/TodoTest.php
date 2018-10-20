<?php

namespace Tests\Unit\Todos;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;

use App\Repositories\TodoRepository;

use App\Todo;


class TodoTest extends TestCase
{

    use WithFaker;


    /**
     * Test proper errors are thrown when missing required data
     *
     * @return void
     */
    public function testErrorWhenMissingData() {
        $this->expectException(QueryException::class);

        $todo = new TodoRepository(new Todo);
        $test = $todo->create([]);
    }

    /**
     * Create a Todo
     *
     * @return void
     */
    public function testCreateTodo() {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
        ];

        $todo = new TodoRepository(new Todo);
        $test = $todo->create($data);

        $this->assertInstanceOf(Todo::class, $test);
        $this->assertEquals($data['name'], $test->name);
        $this->assertEquals($data['description'], $test->description);
        $this->assertEquals('new', $test->status);
    }

    /**
     * Update a Todo
     *
     * @return void
     */
    public function testUpdateTodo() {

        $todo = factory(Todo::class)->create();

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'due_date' => $this->faker->date,
            'status'=>'done',
        ];

        $todoRepository = new TodoRepository($todo);
        $test = $todoRepository->update($data);
        $this->assertTrue($test);
    }

    /**
     * Find a Todo
     *
     * @return void
     */
    public function testFindTodo() {
        $todo = factory(Todo::class)->create();
        $todoRepository = new TodoRepository($todo);

        $test = $todoRepository->find($todo->id);
        $this->assertInstanceOf(Todo::class, $test);
        $this->assertEquals($todo->name, $test->name);
        $this->assertEquals($todo->description, $test->description);
        $this->assertEquals('new', $test->status);

    }

    /**
     * Test Finding Multiple Todos
     *
     * @return void
     */
    public function testFindAllTodos() {
        $todo1 = factory(Todo::class)->create();
        $todo2 = factory(Todo::class)->create();
        $todo3 = factory(Todo::class)->create();

        $todoRepository= new TodoRepository(new Todo);
        $todos = $todoRepository->findAll();
        foreach($todos AS $test) {
            $this->assertInstanceOf(Todo::class, $test);
        }
    }

    /**
     * (soft) Delete of Todo
     *
     * @return void
     */
    public function testDeleteTodo() {
        $todo = factory(Todo::class)->create();
        $todoRepository = new TodoRepository($todo);
        $todoRepository->delete();

        $this->assertSoftDeleted('todos', [
            'id'=> $todo->id,
        ]);

    }

}
