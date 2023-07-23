<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConnectionsInCommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        for($i=0; $i <=10 ; $i++) {

            $user1 = User::factory()->create();
            $user2 = User::factory()->create();

            Connection::factory()->create([
                'first_user' => $user1->id,
                'second_user' => $user2->id
            ]);
        }
    }
}
