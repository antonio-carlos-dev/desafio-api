<?php

namespace Database\Seeders;

use App\Models\Column;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $columns = [
            [
                'project_id' => 1,
                'name' => 'Aguardando',
                'order' => 1 ,
                'time' => '01:00:00',
            ],
            [
                'project_id' => 1,
                'name' => 'Em Andamento',
                'order' => 2 ,
                'time' => '01:00:00',
            ],
            [
                'project_id' => 1,
                'name' => 'Pendência',
                'order' => 3 ,
                'time' => '03:00:00',
            ],
            [
                'project_id' => 1,
                'name' => 'Finalizado',
                'order' => 4 ,
                'time' => '01:00:00',
            ],
            [
                'project_id' => 1,
                'name' => 'outros',
                'order' => 5 ,
                'time' => '01:00:00',
            ],
        ];

        foreach($columns as $column ) {
            Column::create($column);
        }
    }
}
