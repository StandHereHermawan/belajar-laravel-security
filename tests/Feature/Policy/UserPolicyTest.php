<?php

namespace Tests\Feature\Policy;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegistrationGuest(): void
    {
        self::assertTrue(Gate::allows("create", User::class));
    }

    public function testRegistrationUser(): void
    {
        $this->seed([UserSeeder::class]);
        $user = User::where('email', '=', 'terry@localhost')->firstOrFail();
        Auth::login($user);

        self::assertFalse(Gate::allows("create", User::class));
    }
}
