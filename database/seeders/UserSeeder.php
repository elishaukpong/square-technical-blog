<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::whereEmail('admin@blog.com')->doesntExist()){
            User::factory()->admin()->create();
        }
    }
}
