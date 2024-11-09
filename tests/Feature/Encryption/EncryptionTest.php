<?php

namespace Tests\Feature\Encryption;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testEncryptionExample(): void
    {
        $value = "Arief Karditya Hermawan";
        
        $encrypted = Crypt::encryptString($value);
        $decrypted = Crypt::decryptString($encrypted);

        self::assertEquals($value, $decrypted);
         # code
    }
}
