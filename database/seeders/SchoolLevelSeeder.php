<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SchoolLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        SchoolLevel::truncate();
        Schema::enableForeignKeyConstraints();

        

        DB::beginTransaction();
        SchoolLevel::insert([
            'id' => 1,
            'stage_id' => 1,
            'name' => 'TA A',
            'level' => 1,
        ]);

        SchoolLevel::insert([
            'id' => 2,
            'stage_id' => 1,
            'name' => 'TA B',
            'level' => 2,
        ]);

        $nextId = 3;
        for ($i = 1; $i <= 6; $i++, $nextId++) {
            SchoolLevel::insert([
                'id' => $nextId,
                'stage_id' => 2,
                'name' => 'Kelas ' . $i,
                'level' => $i,
            ]); 
        }

        for ($i = 1; $i <= 6; $i++, $nextId++) {
            SchoolLevel::insert([
                'id' => $nextId,
                'stage_id' => 3,
                'name' => 'Kelas ' . $i,
                'level' => $i,
            ]); 
        }
        DB::commit();
    }
}
