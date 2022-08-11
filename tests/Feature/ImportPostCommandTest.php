<?php

namespace Tests\Feature;

use App\Services\BlogImporter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ImportPostCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function test_command_executed_successfully()
    {
        $this->partialMock(BlogImporter::class, function (MockInterface $mock) {
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive('getPosts')
                ->once()
                ->andReturn(collect([]));
        });

        $this->artisan('posts:import')
            ->expectsOutput('Starting importing sequence...')
            ->expectsOutput('Importing sequence completed...')
            ->assertSuccessful();
    }
}
