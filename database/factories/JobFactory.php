<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;
use App\Models\User;
use App\Models\Company;
use App\Models\Location;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'salary' => fake()->numberBetween(800, 5000),
            'job_type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract']),
            'remote' => fake()->boolean(),
            'requirements' => fake()->paragraph(),
            'benefits' => fake()->paragraph(),

            'user_id' => User::inRandomOrder()->first()->id,
            'company_id' => Company::inRandomOrder()->first()->id,
            'location_id' => Location::inRandomOrder()->first()->id,
        ];
    }
}
