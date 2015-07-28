<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apagar todos os registro da tabela
        \CodeProject\Entities\User::truncate();
        // criar 10 registros na tabela
        factory(\CodeProject\Entities\User::class, 10)->create();
    }
}
