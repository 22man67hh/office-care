<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::firstOrCreate(['tasktype' => 'To Do']);
        Status::firstOrCreate(['tasktype' => 'In Progress']);
        Status::firstOrCreate(['tasktype' => 'Completed']);
        Status::firstOrCreate(['tasktype' => 'On Hold']);
    }
}