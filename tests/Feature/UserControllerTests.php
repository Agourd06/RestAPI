<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTests extends TestCase
{
    public function testUserIsCreatedSuccessfully() {
    
        $payload = [
            'name' => $this->faker->userName,
            'email'  => $this->faker->email,
            'password'      => $this->faker->password,
            'role'      => 'benevole'
        ];
        $this->json('post', 'api/user', $payload)
             ->assertStatus(Response::HTTP_CREATED)
             ->assertJsonStructure(
                 [
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'password',
                         'role',
                         'created_at',
                         
                     ]
                 ]
             );
        $this->assertDatabaseHas('users', $payload);
    }
}
