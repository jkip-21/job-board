<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Jonah Kiptoo',
            'email' => 'kapkory.jonah @example.com',
        ]);

        \App\Models\User::factory(300)->create();
        // make sure all 300 employees are loged in
        $users = \App\Models\User::all()->shuffle();
        // condition to associate a user with an employer
        for($i =0; $i <= 20; $i++){
            \App\Models\Employer::factory()->create([
                'user_id' => $users->pop()->id
            ]);
        }

        $employers = \App\Models\Employer::all();

        for($i=0; $i <100; $i++){
            \App\Models\Job::factory()->create([
                'employer_id' => $employers->random()->id
            ]);
        }
        // User::factory(10)->create();

    }
}
