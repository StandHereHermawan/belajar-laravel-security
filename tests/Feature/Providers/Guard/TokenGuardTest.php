<?php

namespace Tests\Feature\Providers\Guard;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TokenGuardTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGuard(): void
    {
        $this->seed(UserSeeder::class);

        $user = User::where('id', '=', '1')->first();
        self::assertNotNull($user);
        Log::info(json_encode($user, JSON_PRETTY_PRINT));

        $this->get('/api/users/current', [
            "Accept" => "application/json",
        ])->assertStatus(401);

        $this->get('/api/users/current', [
            "API-Key" => $user->token,
        ])->assertSeeText("Hello Terry In Paris!");
    }
}
