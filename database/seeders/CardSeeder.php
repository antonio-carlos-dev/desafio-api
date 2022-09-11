<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cards = [
            [
                'name' => 'CRIAR MIGRATION',
                'description' => 'Usar a branch main, fazer pull, após isso...',
                'estimated_date' => now()->addDay(10),
                'order' => 1 ,
                'tag' => 'DESENVOLVIMENTO',
            ],
            [
                'name' => 'LANÇAR NOTAS',
                'description' => 'Usar a branch main, fazer pull, após isso...',
                'estimated_date' => now()->addDay(9),
                'order' => 2 ,
                'tag' => 'FINANCEIRO',
            ],
            [
                'name' => 'LISTAGEM DE CLIENTES',
                'description' => 'Usar a branch main, fazer pull, após isso...',
                'estimated_date' => now()->subMinute(25),
                'order' => 3 ,
                'tag' => 'UX | UI',
            ],
            [
                'name' => 'AUTENTICAÇÃO',
                'description' => 'Usar a branch main, fazer pull, após isso...',
                'estimated_date' => now()->addDay(10),
                'order' => 4 ,
                'tag' => 'DESENVOLVIMENTO',
            ],
            [
                'name' => 'LAYOUT',
                'description' => 'Usar a branch main, fazer pull, após isso...',
                'estimated_date' => now()->subDay(2),
                'order' => 5 ,
                'tag' => 'UX | UI',
            ],
            [
                'name' => 'TESTES UNITÁRIOS',
                'description' => 'Usar a branch main, fazer pull, após isso...',
                'estimated_date' => now()->addDay(10),
                'order' => 6 ,
                'tag' => 'DESENVOLVIMENTO',
            ]
        ];

        foreach ( Column::orderBy('order')->get() as $column ) {
            foreach ($cards as $card ) {
                $card['column_id'] = $column->id;
                Card::create($card);
            }
        }
    }
}
