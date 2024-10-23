<?php

namespace Tests\Feature\Providers;

use App\Models\Contact;
use App\Models\User;

use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

class GateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGateExample(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::where('email','terry@localhost')->first();
        self::assertNotNull($user, );
        Log::info(json_encode($user, JSON_PRETTY_PRINT));

        Auth::login($user);

        $contact = Contact::where('email','test@localhost')->first();
        self::assertNotNull($contact, );
        Log::info(json_encode($contact, JSON_PRETTY_PRINT));
        
        self::assertTrue(Gate::allows("get-contact", $contact));
        self::assertTrue(Gate::allows("update-contact", $contact));
        self::assertTrue(Gate::allows("delete-contact", $contact));

        $user2 = User::where('email','andrew@localhost')->first();
        self::assertNotNull($user2, );
        Log::info(json_encode($user2, JSON_PRETTY_PRINT));

        Auth::login($user2);

        self::assertFalse(Gate::allows("get-contact", $contact));
        self::assertFalse(Gate::allows("update-contact", $contact));
        self::assertFalse(Gate::allows("delete-contact", $contact));
    }
}