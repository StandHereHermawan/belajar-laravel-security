<?php

namespace Tests\Feature\Providers;

use Database\Seeders\UserSeeder;
use Tests\TestCase;

class SimpleUserProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUserProviderExample(): void
    {
        self::seed(UserSeeder::class);

        self::get('/simple-api/users/current', [
            "Accept" => "application/json",
        ])->assertStatus(401);

        self::get('/simple-api/users/current', [
            "API-Key" => "sample-token-terry",
        ])->assertSeeText("Hello");
    }
}
