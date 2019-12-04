<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function has_projects()
    {
    	$user = factory('App\User')->create();

    	$this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function has_accessible_projects()
    {
        $user = factory('App\User')->create();

        $ownProject = factory('App\Project')->create(['owner_id' => $user->id]);

        $project1 = factory('App\Project')->create();
        $project2 = factory('App\Project')->create();
        $project1->invite($user);

        $this->assertTrue($user->accessibleProjects()->contains($ownProject));
        $this->assertTrue($user->accessibleProjects()->contains($project1));
        $this->assertFalse($user->accessibleProjects()->contains($project2));


    }


}
