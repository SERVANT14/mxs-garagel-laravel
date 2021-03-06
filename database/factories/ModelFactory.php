<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'is_admin' => false,
    ];
});

$factory->state(App\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'is_admin' => true,
    ];
});

$factory->define(App\Services\Tracks\Models\Track::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'download_links' => ['link' => 'http://forum.mxsimulator.com', 'description' => 'HD'],
        'released_on' => \Carbon\Carbon::yesterday(),
        'creator_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'category_id' => function () {
            $name = collect(['Motocross', 'Supercross'], 1)->random();
            $existingCategory = \App\Services\Tracks\Models\TrackCategory::where('name', $name)->first();

            return $existingCategory ?: factory(\App\Services\Tracks\Models\TrackCategory::class)
                ->create()
                ->id;
        },
        'download_links' => json_encode([
            ['link' => 'http://example.com', 'description' => 'Ultra Resolution']
        ]),
    ];
});

$factory->define(App\Services\Tracks\Models\TrackCategory::class, function (Faker\Generator $faker) {
    return ['name' => $faker->name];
});
