<?php

namespace App\Http\Controllers;

use App\Http\Resources\Event\EventCollection;
use App\Models\Event;
use App\Models\Performer;
use Illuminate\Http\Request;

class PerformerEventController extends Controller
{
    public function index($performer_id)
    {
        $performer = Performer::find($performer_id);
        if (is_null($performer)) {
            return response()->json('Performer not found', 404);
        }

        $events = Event::get()->where('performer_id', $performer_id);
        if (is_null($events)) {
            return response()->json('Events not found', 404);
        }

        return response()->json([
            'performer' => $performer->name,
            'events' => new EventCollection($events)
        ]);
    }
}
