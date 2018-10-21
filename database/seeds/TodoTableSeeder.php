<?php

use Illuminate\Database\Seeder;
use App\Todo;

class TodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $todo = factory(Todo::class)->create();
        $todo2 = factory(Todo::class)->create();
        $todo2->status = 'done';
        $todo2->save();
    }
}

