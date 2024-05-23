<?php

namespace Database\Seeders;

use App\Models\SchoolStage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SchoolStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        SchoolStage::truncate();
        Schema::enableForeignKeyConstraints();

        DB::beginTransaction();
        SchoolStage::insert(['id' => 1, 'name' => 'TA', 'stage' => 0]);
        SchoolStage::insert(['id' => 2, 'name' => 'Baniin', 'stage' => 1]);
        SchoolStage::insert(['id' => 3, 'name' => 'Banaat', 'stage' => 1]);
        DB::commit();
    }
}
