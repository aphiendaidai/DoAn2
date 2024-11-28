<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\JobFactory;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        // \App\Models\Category::factory()->count(5)->create();        
        // \App\Models\JobType::factory()->count(5)->create();
     
        JobFactory::new()->count(25)->create();

        // \App\Models\Job::factory(25)->create();
        // \App\Models\Category::factory(10)->create();
        // \App\Models\JobType::factory(5)->create();
    }
}
