<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Rfc4122\UuidV7;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            "name" => "Terry In Paris",
            "email" => "terry@localhost",
            "password" => Hash::make("rahasia@12"),
            "token" => UuidV7::uuid7(),
        ]);

        \App\Models\User::create([
            "name" => "Andrew In Paris",
            "email" => "andrew@localhost",
            "password" => Hash::make("rahasia@12"),
            "token" => UuidV7::uuid7(),
        ]);
    }
}
