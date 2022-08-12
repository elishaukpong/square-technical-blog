<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
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
        try{
            $this->call(UserSeeder::class);
            $this->call(PostSeeder::class);
        }catch(Exception $e) {}

    }
}
