<?php

namespace App\Http\Controllers;

use App\Http\Resources\Event\EventCollection;
use App\Http\Resources\Event\EventResource;
use App\Models\Event;
use App\Models\Location;
use App\Models\Performer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(new EventCollection($events));
    }

    public function indexPaginate()
    {
        $events = Event::all();
        $events = Event::paginate(2);
        return response()->json(new EventCollection($events));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required|string|max:255',
            'date' =>  'required|date',
            'tickets' =>  'required|integer|between:10,100000',
            'performer_id' =>  'required|integer|max:255',
            'location_id' =>  'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $performer = Performer::find($request->performer_id);
        if (is_null($performer)) {
            return response()->json('Performer not found', 404);
        }

        $location = Location::find($request->location_id);
        if (is_null($location)) {
            return response()->json('Location not found', 404);
        }

        if ($request->tickets > $location->capacity) {
            return response()->json('Number of tickets is bigger than capacity of the location');
        }

        $event = Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'tickets' => $request->tickets,
            'performer_id' => $request->performer_id,
            'location_id' => $request->location_id,
        ]);

        return response()->json([
            'Event created' => new EventResource($event)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($event_id)
    {
        $event = Event::find($event_id);
        if (is_null($event)) {
            return response()->json('Event not found', 404);
        }
        return response()->json(new EventResource($event));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required|string|max:255',
            'date' =>  'required|date',
            'tickets' =>  'required|integer|between:10,100000',
            'performer_id' =>  'required|integer|max:255',
            'location_id' =>  'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $performer = Performer::find($request->performer_id);
        if (is_null($performer)) {
            return response()->json('Performer not found', 404);
        }

        $location = Location::find($request->location_id);
        if (is_null($location)) {
            return response()->json('Location not found', 404);
        }

        if ($request->tickets > $location->capacity) {
            return response()->json('Number of tickets is bigger than capacity of the location');
        }

        $event->name = $request->name;
        $event->date = $request->date;
        $event->tickets = $request->tickets;
        $event->performer_id = $request->performer_id;
        $event->location_id = $request->location_id;

        $event->save();

        return response()->json([
            'Event updated' => new EventResource($event)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json('Event deleted');
    }
}
