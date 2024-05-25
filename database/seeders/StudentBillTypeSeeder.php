<?php

namespace Database\Seeders;

use App\Models\StudentBillType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudentBillTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        StudentBillType::truncate();
        Schema::enableForeignKeyConstraints();

        DB::beginTransaction();
        StudentBillType::insert(['id' => 1, 'name' => 'Infaq Pangkal', 'stage_id' => 1, 'level_id' => null, 'amount' => 1000000]);
        StudentBillType::insert(['id' => 2, 'name' => 'Infaq Pangkal', 'stage_id' => 2, 'level_id' => null, 'amount' => 1200000]);
        StudentBillType::insert(['id' => 3, 'name' => 'Infaq Pangkal', 'stage_id' => 3, 'level_id' => null, 'amount' => 1300000]);
        StudentBillType::insert(['id' => 4, 'name' => 'SPP', 'stage_id' => 1, 'level_id' => null, 'amount' => 250000]);
        StudentBillType::insert(['id' => 5, 'name' => 'SPP', 'stage_id' => 2, 'level_id' => null, 'amount' => 300000]);
        StudentBillType::insert(['id' => 6, 'name' => 'SPP', 'stage_id' => 3, 'level_id' => null, 'amount' => 350000]);
        DB::commit();
    }
}
