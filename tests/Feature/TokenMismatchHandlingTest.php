<?php

namespace Tests\Feature;

use Tests\TestCase;

class TokenMismatchHandlingTest extends TestCase
{
    public function test_token_mismatch_redirects_to_login_with_message()
    {
        // Define a temporary test route that throws TokenMismatchException
        \Illuminate\Support\Facades\Route::get('/__test-throw-419', function () {
            throw new \Illuminate\Session\TokenMismatchException;
        });

        $response = $this->get('/__test-throw-419');

        $response->assertStatus(419);
        $response->assertSee('Session expired')
                 ->assertSee('Please refresh the page');
    }
}
