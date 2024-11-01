<?php

namespace Tests\Feature\View;

use App\Models\Todo;
use App\Models\User;

use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Auth;

use Tests\TestCase;

class TodoViewTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testBladeTemplateSecurity(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $user = User::where('email', '=', 'terry@localhost')->firstOrFail();
        Auth::login($user);

        $todos = Todo::query()->get();

        $this->view("bladeTemplate.todos", [
            "todos" => $todos,
        ])
            ->assertDontSeeText("No Edit")
            ->assertSeeText("Edit")
            ->assertDontSeeText("No Delete")
            ->assertSeeText("Delete");
    }

    public function testViewGuest(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $todos = Todo::query()->get();

        $this->view("bladeTemplate.todos", [
            "todos" => $todos,
        ])->assertSeeText("No Edit")
            ->assertSeeText("No Delete");
    }
}
