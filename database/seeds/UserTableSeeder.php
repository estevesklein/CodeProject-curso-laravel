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
        // 04.08.2015
        factory(\CodeProject\Entities\User::class)->create([
            'name' => 'Esteves Klein',
            'email' => 'esteves.klein@gmail.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10),
        ]);

        // apagar todos os registro da tabela
        //\CodeProject\Entities\User::truncate();
        // criar 10 registros na tabela
        factory(\CodeProject\Entities\User::class, 10)->create();
    }
}
