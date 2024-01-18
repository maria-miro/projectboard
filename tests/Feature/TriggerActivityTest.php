<?php

namespace Tests\Feature;

use  Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_project', $activity->description);
            $this->assertEquals(null, $activity->changes);

        });
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();

        $originalTitle = $project->title;

        $project->update(['title' => 'changed']);


        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) use($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'changed']
            ];

            $this->assertEquals($expected, $activity->changes);

        });
        


    }

    /** @test */
    public function creating_a_new_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOF(Task::class, $activity->subject);
        });
        

    }

    /** @test */
    public function completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->complete();

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOF(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create([]);

        $project->tasks[0]->complete();
        $project->tasks[0]->incomplete();

        $this->assertCount(4 , $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('incompleted_task', $activity->description);
            $this->assertInstanceOF(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3 , $project->activity);
        $this->assertEquals('deleted_task', $project->activity->last()->description);

    }
}
