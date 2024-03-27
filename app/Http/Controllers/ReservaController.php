<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ReservaController extends Controller
{

    public function store($id)
    {



        $reservation =  reservation::create([
            'eventId' => $id

        ]);
        return response()->json([
            'statut' => 'success',
            'message' => 'Created Sucessfully',
            'reservation' => $reservation,
        ], 200);
    }

    public function index()
    {
        $user =  JWTAuth::user();

        $reservations = Reservation::where('statut', 'waiting')
            ->whereHas('evenement', function ($query) use ($user) {
                $query->where('userId', $user->id);
            })
            ->get();
        return response()->json([
            'statut' => 'success',
            'reservations' => $reservations,

        ], 200);
    }
    public function updateStatut($id, Request $request)
    {
        $request->validate([
            'Newstatut' => 'required',
        ]);
        reservation::where('id', $id)->update([
            'statut' => $request->Newstatut,
        ]);
        return response()->json([
            'statut' => 'success',
            'message' => 'reseravtion checked successfully',

        ], 200);
    }
}
