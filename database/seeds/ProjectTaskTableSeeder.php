<?php

use Illuminate\Database\Seeder;

class ProjectTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apagar todos os registro da tabela
        //\CodeProject\Entities\ProjectTask::truncate();
        // criar 50 registros na tabela
        factory(\CodeProject\Entities\ProjectTask::class, 50)->create();
    }
}
