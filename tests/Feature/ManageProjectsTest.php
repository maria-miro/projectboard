<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use Facades\Tests\Setup\ProjectFactory;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    
    /** @test */
    public function guests_cannot_manage_projects()
    {
    	// $this->withoutExceptionHandling();

        $project = Project::factory()->create();

    	$this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');

    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = Project::factory()->raw();

        $this->followingRedirects()->post('/projects', $attributes)
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function tasks_can_be_included_in_a_new_project_creation()
    {
         $this->signIn();

         $attributes = Project::factory()->raw();

         $attributes['tasks'] = [
            ['body' => 'task1'],
            ['body' => 'task2'],
         ];

         $this->post('/projects', $attributes);
         $this->assertCount(2, Project::first()->tasks); 
    }

     /** @test */
    public function empty_tasks_can_not_be_included_in_a_new_project_creation()
    {
        $this->signIn();

         $attributes = Project::factory()->raw();

         $attributes['tasks'] = [
            ['body' => ''],
            ['body' => 'task'],
         ];

         $this->post('/projects', $attributes);
         $this->assertCount(1, Project::first()->tasks); 
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $attributes = [
            'title' => 'Changed title',
            'description' => 'Changed description',
            'notes' => 'Changed notes',
        ];

        $this->get($project->path() . '/edit')->assertOk();
        $this->patch($project->path(), $attributes)->assertRedirect($project->path());



        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
//         $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_guest_cannot_delete_a_project()
    {
//         $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->delete($project->path())->assertRedirect('/login');

        $user = $this->signIn();

        $this->delete($project->path())->assertForbidden();

        $project->invite($user);

        $this->delete($project->path())->assertForbidden();
    }

    /** @test */
    public function a_project_requires_a_title()
    {
    	$this->signIn();

    	$attributes = Project::factory()->raw(['title' => '']);

    	$this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();    	

    	$attributes = Project::factory()->raw(['description' => '']);

    	$this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }



    /** @test */
    public function a_user_can_view_own_project()
    {
    	// $this->withoutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())->create();

    	$this->get($project->path())
    		->assertSee($project->title)
    		->assertSee($project->description);
    }

    /** @test */
    public function a_user_can_view_the_projects_they_are_invited_to_on_a_dashboard()
    {
        // $this->withoutExceptionHandling();

        $project = tap(ProjectFactory::create())->invite( $this->signIn());

        $this->get('/projects')->assertSee($project->title);
    }

    /** @test */
    public function a_user_cannot_view_the_projects_of_others()
    {
    	// $this->withoutExceptionHandling();

        $this->signIn();
    	$project = Project::factory()->create();

    	$this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_cannot_update_the_projects_of_others()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();
        $project = Project::factory()->create();

        $this->patch($project->path())->assertStatus(403);
    }
}
