<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Employee::class, function (Faker $faker) {
    static $password;

    return [
    	'newbie' => false,
    	'employeeNumber' => str_random(6),
        'firstName' => $faker->firstName,
        'lastName' => $faker->LastName,
        'cName' => $faker->name,
        'location_id' => $faker->randomDigitNotNull,
        'email' => $faker->unique()->safeEmail,
        'hired' => $faker->date(),
        'termination' => $faker->date(),
        'status' => 'active',
    ];
});
