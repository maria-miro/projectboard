<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;

class TaskTest extends TestCase
{
     use RefreshDatabase;

     /** @test */
    public function it_has_a_path()
    {
    	$task = Task::factory()->create();

    	$this->assertEquals('/tasks/' . $task->id, $task->path());
    }

     /** @test */
    public function it_belongs_to_a_project()
    {
    	$task = Task::factory()->create();

    	$this->assertInstanceOf('App\Models\Project', $task->project);
    }

    /** @test */
    public function it_can_be_completed()
    {
        $task = Task::factory()->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);

    }

    /** @test */
    public function it_can_be_incompleted()
    {
        $task = Task::factory()->create(['completed' => true]);

        $this->assertTrue($task->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);

    }

}
