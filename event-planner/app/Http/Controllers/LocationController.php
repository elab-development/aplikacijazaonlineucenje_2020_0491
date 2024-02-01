<?php

namespace App\Http\Controllers;

use App\Http\Resources\Location\LocationCollection;
use App\Http\Resources\Location\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return response()->json(new LocationCollection($locations));
    }

    public function indexPaginate()
    {
        $locations = Location::all();
        $locations = Location::paginate(2);
        return response()->json(new LocationCollection($locations));
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
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'capacity' => 'required|integer|between:100,100000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $location = Location::create([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'capacity' => $request->capacity,
        ]);

        return response()->json([
            'Location created' => new LocationResource($location)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($location_id)
    {
        $location = Location::find($location_id);
        if (is_null($location)) {
            return response()->json('Location not found', 404);
        }
        return response()->json(new LocationResource($location));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'capacity' => 'required|integer|between:100,100000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $location->name = $request->name;
        $location->city = $request->city;
        $location->address = $request->address;
        $location->capacity = $request->capacity;

        $location->save();

        return response()->json([
            'Location updated' => new LocationResource($location)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return response()->json('Location deleted');
    }
}
