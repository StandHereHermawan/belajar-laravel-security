<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::where('email','=','terry@localhost')->firstOrFail();
        Log::info(json_encode($user, JSON_PRETTY_PRINT));
        
        $todo = new Todo();
        $todo->title = "Test Todo";
        $todo->description = "Test Todo Description";
        $todo->user_id = $user->id;
        $todo->save();
    }
}
