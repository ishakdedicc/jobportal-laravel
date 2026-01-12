<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantFactory extends Factory
{
    protected $model = Applicant::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'job_id' => Job::inRandomOrder()->value('id') ?? Job::factory(),
            'full_name' => $this->faker->name(),
            'contact_phone' => $this->faker->optional()->phoneNumber(),
            'contact_email' => $this->faker->safeEmail(),
            'message' => $this->faker->optional()->paragraph(),
            'location' => $this->faker->optional()->city(),
            'resume_path' => 'resumes/demo.pdf', 
        ];
    }
}
