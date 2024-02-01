<?php

namespace App\Http\Controllers;

use App\Http\Resources\Event\EventCollection;
use App\Models\Event;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationEventController extends Controller
{
    public function index($location_id)
    {
        $location = Location::find($location_id);
        if (is_null($location)) {
            return response()->json('Location not found', 404);
        }

        $events = Event::get()->where('location_id', $location_id);
        if (is_null($events)) {
            return response()->json('Events not found', 404);
        }

        return response()->json([
            'location' => $location->name,
            'events' => new EventCollection($events)
        ]);
    }
}
