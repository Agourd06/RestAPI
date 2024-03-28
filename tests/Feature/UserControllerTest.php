<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTests extends TestCase
{
    public function testUserIsCreatedSuccessfully()
    {

        $payload = [
            'name' => $this->faker->userName,
            'email'  => $this->faker->email,
            'password'    => '123456789',
            'role'      => 'organisateur'
        ];
        $this->json('post', 'api/register', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'role',
                        'created_at',

                    ]
                ]
            );
        $check = array_filter($payload, fn ($array) => in_array($array, ['name', 'email']));
        $this->assertDatabaseHas('users', $check);
    }
}
