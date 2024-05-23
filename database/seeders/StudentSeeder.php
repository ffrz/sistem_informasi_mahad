<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Student::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = \Faker\Factory::create('id_ID');
        $stages = [1, 2, 3];
        $levels = [
            1 => [1, 2],
            2 => [3, 4, 5, 6, 7, 8],
            3 => [9, 10, 11, 12, 13, 14],
        ];
        DB::beginTransaction();
        for ($i = 1; $i <= 100; $i++) {
            $nis = $faker->numberBetween(2020, 2024) . str_pad($faker->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);
            $stage = $faker->randomElement($stages);
            $level = $faker->randomElement($levels[$stage]);
            $gender = $faker->randomElement(['male', 'female']);
            $gender = $stage == 2 ? 'male' : ($stage == 3 ? 'female' : $gender);
            $fullname = $faker->firstName($gender) . ' ' . $faker->LastName($gender);
            $status = $faker->randomElement([Student::STATUS_ACTIVE, Student::STATUS_GRADUATED]);

            Student::insert([
                'fullname' => $fullname,
                'nis' => $nis,
                'stage_id' => $stage,
                'level_id' => $level,
                'status' => $status,
            ]);
        }
        DB::commit();
    }
}
