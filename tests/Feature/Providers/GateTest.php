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

        $user = User::where('email', 'terry@localhost')->first();
        self::assertNotNull($user, );
        Log::info(json_encode($user, JSON_PRETTY_PRINT));

        Auth::login($user);

        $contact = Contact::where('email', 'test@localhost')->first();
        self::assertNotNull($contact, );
        Log::info(json_encode($contact, JSON_PRETTY_PRINT));

        self::assertTrue(Gate::allows("get-contact", $contact));
        self::assertTrue(Gate::allows("update-contact", $contact));
        self::assertTrue(Gate::allows("delete-contact", $contact));

        $user2 = User::where('email', 'andrew@localhost')->first();
        self::assertNotNull($user2, );
        Log::info(json_encode($user2, JSON_PRETTY_PRINT));

        Auth::login($user2);

        self::assertFalse(Gate::allows("get-contact", $contact));
        self::assertFalse(Gate::allows("update-contact", $contact));
        self::assertFalse(Gate::allows("delete-contact", $contact));
    }

    public function testGateFacadeMethod(): void
    {
        self::seed([UserSeeder::class, ContactSeeder::class]);
        # code
        $user = User::where('email', '=', 'terry@localhost')->first();
        self::assertNotNull($user, );
        Log::info(json_encode($user, JSON_PRETTY_PRINT));
        # code
        Auth::login($user);

        $contact = Contact::where('email', '=', 'test@localhost')->first();
        self::assertNotNull($contact, );
        Log::info(json_encode($contact, JSON_PRETTY_PRINT));

        # code
        self::assertTrue(Gate::any(["get-contact", "delete-contact", "update-contact"], $contact));
        self::assertFalse(Gate::none(["get-contact", "delete-contact", "update-contact"], $contact));
    }

    public function testGateAllowsUserNotYetLogin()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::where('email', '=', 'terry@localhost')->first();
        Log::info(json_encode($user, JSON_PRETTY_PRINT));

        $gate = Gate::forUser($user);

        $contact = Contact::where('user_id', '=', $user->id)->first();
        Log::info(json_encode($contact, JSON_PRETTY_PRINT));

        self::assertTrue($gate->allows('get-contact', $contact));
        self::assertTrue($gate->allows("update-contact", $contact));
        self::assertTrue($gate->allows("delete-contact", $contact));
    }

    public function testGateResponse(): void 
    {
        self::seed([UserSeeder::class,ContactSeeder::class,]);
        $user = User::where('email','=','terry@localhost')->first();
        self::assertNotNull($user);
        Log::info(json_encode($user, JSON_PRETTY_PRINT));
        
        Auth::login($user, );

        $response = Gate::inspect("create-contact");
        self::assertNotNull($response);
        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertFalse($response->allowed());
        self::assertEquals("You are not admin.", $response->message());
         # code
    }
}
