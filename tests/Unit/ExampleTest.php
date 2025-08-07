<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function testOtpGeneration()
    {
        $user = User::factory()->create();

        $response = $this->post('/send-otp', ['email' => $user->email]);

        $response->assertRedirect(route('verify.otp'));

        $this->assertEquals('OTP sent successfully!', session('message'));
        $this->assertEquals($user->email, session('email'));
        $this->assertNotNull(session('otp'));
    }
}
