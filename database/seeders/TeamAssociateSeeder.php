<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamAssociateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = Team::find(1);
        foreach(User::all() as $user )
        {
            $team->users()->attach($user->id);
        }
    }
}
