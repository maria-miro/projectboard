<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Project;


class UserTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function has_projects()
    {
    	$user = User::factory()->create();

    	$this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function has_accessible_projects()
    {
        $user = User::factory()->create();

        $ownProject = Project::factory()->create(['owner_id' => $user->id]);

        $project1 = Project::factory()->create();
        $project2 = Project::factory()->create();
        $project1->invite($user);

        $this->assertTrue($user->accessibleProjects()->contains($ownProject));
        $this->assertTrue($user->accessibleProjects()->contains($project1));
        $this->assertFalse($user->accessibleProjects()->contains($project2));


    }


}
