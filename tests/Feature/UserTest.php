<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_guest_can_register()
    {
        $attributes = [
            'firstname' => 'John',
            'lastname' => 'John',
            'phoneNumber' => '08012345678',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->post(route('register'), $attributes)
            ->assertStatus(201)
            ->assertJson([
                'user' => true,
                'token' => true
            ]);
    }

    /** @test */
    function a_user_can_login()
    {
        create('App\User', [
            'email' => 'john@toptal.com',
            'password' => bcrypt('toptal123'),
        ]);

        $attributes = [
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->post(route('login'), $attributes)
            ->assertStatus(201)
            ->assertJson([
                'user' => true,
                'token' => true
            ]);
    }

    /** @test */
    function a_user_registration_requires_a_firstname()
    {
        $this->publishUser(['firstname' => null])
            ->assertSessionHasErrors('firstname');
    }

    /** @test */
    function a_user_registration_requires_a_lastname()
    {
        $this->publishUser(['lastname' => null])
            ->assertSessionHasErrors('lastname');
    }

    /** @test */
    function a_user_registration_requires_a_phone_number()
    {
        $this->publishUser(['phoneNumber' => null])
            ->assertSessionHasErrors('phoneNumber');
    }

    /** @test */
    function a_user_registration_requires_an_email()
    {
        $this->publishUser(['email' => null])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    function a_user_registration_requires_a_password()
    {
        $this->publishUser(['password' => null])
            ->assertSessionHasErrors('password');
    }

    public function publishUser($overrides = [])
    {
        $this->withExceptionHandling();

        $attributes = make('App\User', $overrides);

        return $this->post(route('register'), $attributes->toArray());
    }
}
