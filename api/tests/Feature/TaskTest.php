<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithFaker;

    /**
     * Check if a user can create a task
     *
     * @test
     */
    public function a_user_can_create_a_task()
    {
        $board = Board::query()->where('name',  '=', 'Todos')->first();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'board_id' => $board->id
        ];

        $this->post('/tasks', $attributes);

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /**
     * Check if a user can mark done the task
     *
     * @test
     */
    public function a_user_can_mark_task_done() {
        $task = Task::query()->where('status', '=', 0)->first();

        $attributes = [
            'id' => $task->id
        ];

        $this->patch('/task/done', $attributes);

        $doneTask = Task::query()->where('id', '=', $attributes['id'])->first();

        $this->assertTrue($doneTask->status == 1);
    }

    /**
     * Check if a user can move task to urgent
     *
     * @test
     */
    public function a_user_can_move_to_urgent() {
        $board = Board::query()->where('name', '=', 'Urgent')->first();
        $task = Task::query()->where('board_id', '<>', $board->id)->first();

        $attributes = [
            'id' => $task->id
        ];

        $this->patch('/task/urgent', $attributes);

        $doneTask = Task::query()->where('id', '=', $attributes['id'])->first();

        $this->assertTrue($doneTask->board_id == $board->id);
    }

    /**
     * Check if a user can remove task
     *
     * @test
     */
    public function a_user_can_remove_task() {
        $task = Task::query()->first();

        $attributes = [
            'id' => $task->id
        ];

        $this->delete('/tasks', $attributes);

        $this->assertDatabaseMissing('tasks', $attributes);
    }
}
