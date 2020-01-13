<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_ask_a_token()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('password')
        ]);

        $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ])->assertStatus(200)->assertJsonPath('token_type', 'bearer');
    }

    /** @test */
    public function a_user_can_register()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->raw([
            'password' => 'password'
        ]);

        $this->post('api/auth/register', $user)
        ->assertStatus(201)
        ->assertJsonPath('token_type', 'bearer');
    }
}
