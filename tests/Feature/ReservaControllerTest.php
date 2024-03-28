<?php

namespace Tests\Controllers;

use App\Models\evenement;
use App\Models\reservation;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;

class ReservaControllerTests extends TestCase
{

    public function testIndexReturnsDataInValidFormat()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->json('get', 'api/dataReservations')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'reservations' => [
                        '*' => [
                            'id',
                            'evenement_id',
                            'statut',

                        ]
                    ]
                ]
            );
    }
    public function testUpdateReserveReturnsCorrectData()
    {
        $user = user::factory()->create();
        $event = evenement::create([
            "title" => "for azbxsxale",
            "type" => "mosa3axsxsdate",
            "date" => "2024/11/12",
            "description" => "najm3o zbila",
            "localisation" => "asfi massira school",
            "competence" => "mota9af,zabal",
            "userId" => $user->id
        ]);
        $Resrv = reservation::create(
            [
                'evenement_id' => $event->id

            ]
        );


        $payload = [
            'Newstatut' => 'accepted',

        ];

        $this->actingAs($user, 'api')
            ->json('put', "api/updateStatut/$Resrv->id", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'message' => 'Reservation status updated successfully',
                'statut' => 'success',
            ]);
    }
}
