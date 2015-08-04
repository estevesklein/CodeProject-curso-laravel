<?php

use Illuminate\Database\Seeder;

class ProjectNoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apagar todos os registro da tabela
        //\CodeProject\Entities\ProjectNote::truncate();
        // criar 10 registros na tabela
        factory(\CodeProject\Entities\ProjectNote::class, 50)->create();
    }
}
