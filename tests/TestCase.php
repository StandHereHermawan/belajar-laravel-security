<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        DB::statement("DELETE FROM todos;");
        DB::statement("ALTER TABLE todos AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM contacts;");
        DB::statement("ALTER TABLE contacts AUTO_INCREMENT = 1;");
        DB::statement("DELETE FROM users;");
        DB::statement("ALTER TABLE users AUTO_INCREMENT = 1;");
    }
}
