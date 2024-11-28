<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Job::class;
    public function definition(): array
    {
        return [
           'title' => $this->faker->jobTitle,
            'user_id' => $this->faker->numberBetween(1, 2),
            'job_type_id' => $this->faker->numberBetween(1, 3),
            'category_id' => $this->faker->numberBetween(1, 3),
            'vacancy' => $this->faker->numberBetween(1, 3),
            'salary' => $this->faker->numberBetween(1000, 100000),
            'location' => $this->faker->city,
            'description' => $this->faker->paragraph,
            'experience' => $this->faker->numberBetween(1, 10),
            'company_name' => $this->faker->company,
            'company_location' => $this->faker->city,
            'company_website' => $this->faker->url,
            'keywords' => $this->faker->words(5, true),
            'benefits' => $this->faker->sentence,
            'responsibility' => $this->faker->paragraph,
            'qualifications' => $this->faker->paragraph,
            'status' => $this->faker->numberBetween(0, 1),
            'isFeatured' => $this->faker->numberBetween(0, 1),

        ];
    }
}
