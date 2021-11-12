<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicClientCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCommand(): void
    {
        $this->artisan('passport:public', ['--initial_client' => null]);
        $this->assertDatabaseCount('oauth_clients', 1);
        $this->artisan('passport:public', ['--initial_client' => null]);
        // Should not create a new public client since one already exists.
        $this->assertDatabaseCount('oauth_clients', 1);
    }
}
