<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([ProductionSeeder::class, ActorSeeder::class, MovieSeeder::class]);
        $actors = Actor::all();
        $movies = Movie::all();

        // Attach actors to movies
        foreach ($movies as $movie) {
            $actorsIds = $actors->random(rand(1, 2))->pluck('id')->toArray();
            $movie->actors()->attach($actorsIds);
        }
    }
}
