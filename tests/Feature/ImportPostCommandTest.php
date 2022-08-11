<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImportPostCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function test_command_executed_successfully()
    {
        $posts  = Post::factory(4)
                        ->imported()
                        ->make();
        Http::fake([ '*' => Http::response(['data' => $posts])]);

        $this->artisan('posts:import')
            ->expectsOutput('Starting importing sequence...')
            ->expectsOutput('Importing sequence completed...')
            ->assertSuccessful();

        $this->assertDatabaseCount('posts', 4);
    }

    public function test_command_executed_successfully_when_cant_import()
    {

        Http::fake([ '*' => Http::response([''], 500)]);

        $this->artisan('posts:import')
            ->expectsOutput('Starting importing sequence...')
            ->expectsOutput('Importing sequence completed...')
            ->assertSuccessful();

        $this->assertDatabaseCount('posts', 0);

    }
}
