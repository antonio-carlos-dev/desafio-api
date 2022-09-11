<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'name' => 'Tarefas',
            'user_id' => 1,
            'team_id' => 1,
        ]);
    }
}
