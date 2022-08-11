<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImportPostCommandTest extends TestCase
{

    use DatabaseMigrations;

    public function test_command_executed_successfully()
    {
        $this->artisan('posts:import')
            ->expectsOutput('Starting importing sequence...')
            ->expectsOutput('Importing sequence completed...')
            ->assertSuccessful();
    }
}
