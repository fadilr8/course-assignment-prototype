<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index() {
        $rooms = Room::all();

        $data = [];
        foreach ($rooms as $room) {
            $data = [
                'id' => $room->id,
                'name' => $room->name,
                'courses' => $room->courses
            ];
        }

        return response()->json(compact('data'), 200);
    }

    public function create(Request $request) {
        $room = Room::create([
            'room' => $request->name,
        ]);
        
        $data = [
            'id' => $room->id,
            'name' => $room->room,
            'courses' => $room->courses
        ];

        return response()->json(compact('data'), 200);
    }
}
