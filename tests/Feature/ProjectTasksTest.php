<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Models\Task;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_task()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Task Test'])
        ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Task Test']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_task()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = ProjectFactory::withTasks(1)
            ->create();

        $this->patch($project->tasks[0]->path(), [
                'body' => 'Changed Task body',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed Task body']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        // $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        
        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Task Test']);

        $this->get($project->path())->assertSee('Task Test');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'Changed Task body',
            ])->assertRedirect($project->path());

        $this->get($project->path())->assertSee('Changed Task body');

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed Task body',
        ]);
    }

        /** @test */
        public function a_task_can_be_completed()
        {
            $this->withoutExceptionHandling();

            $project = ProjectFactory::withTasks(1)
                ->create();

            $this->actingAs($project->owner)
                ->patch($project->tasks[0]->path(), [
                    'body' => 'Changed Task body',
                    'completed' => true,
            ])->assertRedirect($project->path());


            $this->assertDatabaseHas('tasks', [
                'completed' => true,
            ]);
        }

        /** @test */
        public function a_task_can_be_incompleted()
        {
            $this->withoutExceptionHandling();

            $project = ProjectFactory::withTasks(1)
                ->create();

            $this->actingAs($project->owner)
                ->patch($project->tasks[0]->path(), [
                    'body' => 'Changed Task body',
                    'completed' => true,
            ]);

            $this->actingAs($project->owner)
                ->patch($project->tasks[0]->path(), [
                    'body' => 'Changed Task body',
                    'completed' => false,
            ]);

            $this->assertDatabaseHas('tasks', [
                'completed' => false,
            ]);
        }


        /** @test */
        public function a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        
        $attributes = Task::factory('')->raw(['body' => '', 'project_id' => $project->id]);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');

        $task = $project->addTask('Task body');

        $this->patch($task->path(), ['body' => ''])->assertSessionHasErrors('body');
    }

}
