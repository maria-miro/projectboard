<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Models\User;

class ProjectTest extends TestCase
{
    
	use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
    	$project = Project::factory()->create();

    	$this->assertInstanceOf('App\Models\User', $project->owner);

    }

    /** @test */
    public function it_can_add_a_task()
    {
        $project = Project::factory()->create();

        $project->addTask('Task Test');

        $this->assertCount(1, $project->tasks);

    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $project = Project::factory()->create();

        $project->invite($invitee = User::factory()->create());

        $this->assertInstanceOf('App\Models\User', $invitee);

        $this->assertTrue($project->members->contains($invitee));

    }

}
