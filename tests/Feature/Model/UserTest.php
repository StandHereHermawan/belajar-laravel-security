<?php

namespace Tests\Feature\Model;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testAuth(): void
    {
        self::seed(UserSeeder::class);
        $response = Auth::attempt([
            "email" => "terry@localhost",
            "password" => "rahasia@12",
        ], true);
        self::assertTrue($response);

        $user = Auth::user();
        self::assertNotNull($user);
        self::assertEquals("terry@localhost", $user->email);
        Log::info(json_encode($user, JSON_PRETTY_PRINT));
    }
}
