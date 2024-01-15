<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'name' => 'Em espera',
        ]);

        Status::create([
            'name' => 'Ativo',
        ]);

        Status::create([
            'name' => 'Desligado',
        ]);
    }
}
