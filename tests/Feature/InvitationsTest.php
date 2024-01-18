<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\User;
use Facades\Tests\Setup\ProjectFactory;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function nonowners_may_not_invite_users()
    {
        $project = ProjectFactory::create();

        $invitee = User::factory()->create();

        $nonower = User::factory()->create();

        $this->actingAs($nonower)
            ->post($project->path() . '/invitations', [
                'email' => $invitee->email,
            ])
            ->assertForbidden();

        $project->invite($nonower);

        $this->actingAs($nonower)
            ->post($project->path() . '/invitations', [
                'email' => $invitee->email,
            ])
            ->assertForbidden();

    }


    /** @test */
    public function a_project_can_invite_a_user()
    {

//        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $invitee = User::factory()->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => $invitee->email,
            ])
            ->assertRedirect($project->path());

            $this->assertTrue($project->members->contains($invitee));

    }

    /** @test */
    public function invited_users_may_update_projects()
   {
        $project = ProjectFactory::create();

        $project->invite($invitee = User::factory()->create());

        $this->actingAs($invitee)
            ->post(action('ProjectTaskController@store', $project), $task =['body' => 'New task']);

        $this->assertDatabaseHas('tasks', $task);
    }

    /** @test */
    public function the_invited_email_must_be_a_valid_account()
    {
        $project = ProjectFactory::create();


        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'notauser@email.com',
            ])
            ->assertSessionHasErrors('email', null, 'invitations');
    }
}
