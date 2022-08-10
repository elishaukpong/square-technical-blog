<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;


class PostTest extends TestCase
{


    public function test_models_can_be_instantiated()
    {
        $user = User::factory()->make();

        // Use model in tests...
    }
}
