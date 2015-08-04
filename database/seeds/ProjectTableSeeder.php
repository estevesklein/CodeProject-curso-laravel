<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apagar todos os registro da tabela
        //\CodeProject\Entities\Project::truncate();
        // criar 10 registros na tabela
        factory(\CodeProject\Entities\Project::class, 10)->create();
    }
}
