<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserGroupSeeder::class,
            UserSeeder::class,
            SchoolStageSeeder::class,
            SchoolLevelSeeder::class,
            StudentSeeder::class,
            StudentBillTypeSeeder::class,
        ]);
    }
}
