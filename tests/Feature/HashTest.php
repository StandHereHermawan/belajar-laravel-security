<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class HashTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHash(): void
    {
        $password = "rahasia@12";
        $hash = Hash::make($password);

        $this->assertTrue(Hash::check($password, $hash));
        Log::info(json_encode($hash, JSON_PRETTY_PRINT));
    }
}
