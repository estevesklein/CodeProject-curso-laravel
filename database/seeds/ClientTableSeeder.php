<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apagar todos os registro da tabela
        \CodeProject\Entities\Client::truncate();
        // criar 10 registros na tabela
        factory(\CodeProject\Entities\Client::class, 10)->create();
    }
}
