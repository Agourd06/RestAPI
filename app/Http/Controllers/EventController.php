<?php

namespace App\Http\Controllers;

use App\Models\evenement;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class EventController extends Controller
{
    public function store(Request $request)
    {

        $events = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'date' => 'required',
            'description' => 'required',
            'localisation' => 'required',
            'competence' => 'required',
            'userId' => '',
        ]);
        $user =  JWTAuth::user();
        $events['userId'] = $user->id;
        $event = evenement::create($events);

        return response()->json([
            'statut' => 'success',
            'message' => 'Created Sucessfully',
            'events' => $event,
        ], 200);
    }
    public function index(Request $request)
    {

        $user =  JWTAuth::user();
        if ($user->role === 'organisateur') {
            $events =   evenement::where('userId', $user->id)->get();
        }
        if ($user->role === 'benevole') {
            $query = evenement::query();

            if ($request->filled('fillterEvent')) {
                $query->where('title', $request->input('fillterEvent'));
            }
            
            $events = $query->get();
            
        }
        return response()->json([
            'statut' => 'success',
            'events' => $events,

        ], 200);
    }
}
