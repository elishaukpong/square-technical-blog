<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Post::factory(10)->create([
            'user_id' => User::firstOrFail()->id
        ]);
    }
}
