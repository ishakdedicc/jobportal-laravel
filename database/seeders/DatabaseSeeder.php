<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Location;
use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        Company::factory(5)->create();

        Location::factory(5)->create();

        Location::factory(5)->create();

        Job::factory(20)->create();

        $this->call([
            ApplicantSeeder::class,
        ]);
    }
}
