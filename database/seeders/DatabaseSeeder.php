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

    public function run(): void
    {
        User::factory(20)->create();

        Company::factory(20)->create();

        Location::factory(20)->create();

        Job::factory(20)->create();
    }
}
