<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Request;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestsSeeder extends Seeder
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

            Request::factory()->create([
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id
            ]);
        }

    }
}
