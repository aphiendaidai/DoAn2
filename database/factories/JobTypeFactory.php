<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 */
class JobTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
           // 'name'=> $this->faker->name(),
           'name' => $this->faker->jobTitle(),
           'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
