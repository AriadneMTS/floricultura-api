<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colaboradors')->delete();

        // Ações relacionadas a Model Cliente
        DB::table('colaboradors')->insert([
            'nome' => 'Administrador',
            'cpf' => '12364556789',
            'telefone' => '12364892789',
            'funcao_id' => 1,
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@123'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
