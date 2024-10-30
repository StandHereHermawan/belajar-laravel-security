<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthorizableTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testAuthorizableExample(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::where('email', '=', 'terry@localhost')->firstOrFail();
        Auth::login($user);

        $todo = Todo::first();
        self::assertTrue($user->can("view", $todo), );
        self::assertTrue($user->can("update", $todo), );
        self::assertTrue($user->can("delete", $todo), );
        self::assertTrue($user->can("create", Todo::class), );
    }
}
