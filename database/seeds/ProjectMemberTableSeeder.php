<?php

use Illuminate\Database\Seeder;

class ProjectMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apagar todos os registro da tabela
        //\CodeProject\Entities\ProjectMember::truncate();
        // criar 10 registros na tabela
        factory(\CodeProject\Entities\ProjectMember::class, 10)->create();
    }
}
