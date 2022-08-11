<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(User::whereEmail('admin@blog.com')->doesntExist()){
            User::factory()->admin()->create();
        }

         $this->call(PostSeeder::class);
    }
}
