<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->sentence(6),
        'notes' => $faker->sentence(10),
        'owner_id' => factory(App\User::class),
    ];
});
