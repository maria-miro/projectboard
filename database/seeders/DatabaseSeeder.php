<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$admin = User::find(config('auth.admin_id'));
    	$guest = User::find(config('auth.guest_id'));

        DB::table('projects')->whereIn('owner_id', [$admin->id, $guest->id])->delete();

        $projects = $admin->projects()->createMany($this->projects);



        foreach($projects as $project) {

        	$project->invite($guest);

        	$project->tasks()->createmany($this->tasks[$project->title]);

        }

    }

    private $projects = [
		[
			'title' => 'Moving house',
			'description' => 'What to do before and after moving house',
		],

		[
			'title' => 'Buying a house',
			'description' => 'Where to start when you decided to buy a house',
		],

		[
			'title' => 'Teaching kids to play piano',
			'description' => 'Checklist for starting first piano lessons',
		],
	];

	private $tasks = [
		'Moving house' => [
			['body' => 'Order packing boxes'],
			['body' => 'Declutter'],
			['body' => 'Start packing non-essentials'],
			['body' => 'Hire a moving van'],
			['body' => 'Get your services (gas, electicity, internet etc) switched over to the new place'],
			['body' => 'Arrange to redirect your mail'],
			['body' => 'Update your address in your accounts (banks, online shops, TV license, DVLA)'],
			['body' => 'Register to pay a council tax in new area'],
			['body' => 'Record meter readings at both new and old houses'],
			['body' => 'Register with new local GP surgery'],

		],
		'Buying a house' => [
			['body' => 'Sort out you finances and get advise of a mortgage broker'],
			['body' => 'Choose your area'],
			['body' => 'Go house-hunting'],
			['body' => 'Do some research on the properties you like'],
			['body' => 'Apply for a mortgage'],
			['body' => 'Choose and hire a solicitor'],
			['body' => 'Arrange your own independent survey on the property'],
			['body' => 'Set out a provisional completion date'],
			['body' => 'Exchange contracts'],
			['body' => 'Pay all the outstanding fees on completion'],
			['body' => 'Move in'],
			],
		'Teaching kids to play piano' => [
			['body' => 'Introducing the notes and the musical alphabet'],
			['body' => 'Introducing Piano Fingering'],
			['body' => 'Introducing The Note Family'],
			['body' => 'Finger Strengthening'],
			['body' => 'Exercise playing games'],

			],
	];

}
