<?php

namespace Tests\Controllers;

use Illuminate\Http\Response;
use Tests\TestCase;

class ReservaControllerTests extends TestCase
{

    public function testIndexReturnsDataInValidFormat()
    {
        $user = user->factory
        $this->json('get', 'dataReservations')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'evenement_id',
                            'statut',

                        ]
                    ]
                ]
            );
    }
    
}
