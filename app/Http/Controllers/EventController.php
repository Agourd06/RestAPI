<?php

namespace App\Http\Controllers;

use App\Models\evenement;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class EventController extends Controller
{
    
    /**
* @OA\Post(
     *     path="/api/storeEvent",
     *     summary="Add New Event",
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Event title",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Event type",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Event date",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Event description",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="localisation",
     *         in="query",
     *         description="Event localisation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="competence",
     *         in="query",
     *         description="Event competence",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="query",
     *         description="Event organizer",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User created successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/dataEvents",
     *     summary="Get Events Details",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearer_token":{}}}
     * )
     */
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
