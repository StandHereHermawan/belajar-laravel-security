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

    public function testLogin(): void
    {
        self::seed([UserSeeder::class,]);

        $this->get('/users/login?email=terry@localhost&password=rahasia@12')
        ->assertRedirect("/users/current");

        $this->get('/users/login?email=wrong&password=wrong')
        ->assertSeeText("Wrong Credentials");
    }

    public function testCurrent(): void
    {
        self::seed([UserSeeder::class,]);

        $this->get('/users/current')
            ->assertSeeText("Hello Guest.");

        $user = \App\Models\User::where("email", "terry@localhost")->first();
        $this->actingAs($user)
            ->get('/users/current')
            ->assertSeeText("Hello Terry In Paris!");

        Log::info(json_encode($user, JSON_PRETTY_PRINT));
    }

    public function testRedirectFromCurrent(): void
    {
        self::seed([UserSeeder::class,]);

        $this->get('/users/current')
            ->assertStatus(302)
            ->assertRedirect("login");

        $user = \App\Models\User::where("email","terry@localhost")->first();
        $this->actingAs($user)
            ->get('/users/current')
            ->assertSeeText("Hello Terry In Paris!");
        
    }
}
