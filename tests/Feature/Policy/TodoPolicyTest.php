<?php

namespace Tests\Feature\Policy;

use App\Models\Todo;
use App\Models\User;

use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

class TodoPolicyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPolicyExample(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $user = User::where('email', '=', 'terry@localhost')->firstOrFail();
        self::assertNotNull($user, );
        Log::info(json_encode($user));
        Auth::login($user);

        $todo = Todo::first();
        self::assertTrue(Gate::allows("view", $todo));
        self::assertTrue(Gate::allows("update", $todo));
        self::assertTrue(Gate::allows("delete", $todo));
        self::assertTrue(Gate::allows("create", Todo::class));
    }
}
