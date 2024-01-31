<?php

namespace App\Http\Controllers;

use App\Exports\PerformerExport;
use App\Http\Resources\Performer\PerformerCollection;
use App\Http\Resources\Performer\PerformerResource;
use App\Models\Performer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CSV;

class PerformerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $performers = Performer::all();
        return response()->json(new PerformerCollection($performers));
    }

    public function indexPaginate()
    {
        $performers = Performer::all();
        $performers = Performer::paginate(2);
        return response()->json(new PerformerCollection($performers));
    }

    public function exportCSV()
    {
        return CSV::download(new PerformerExport, 'order-records.csv');
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
            'name' => 'required|string|max:255|unique:performers',
            'performance' => 'required|string|max:255',
            'gender' => 'required|in:male,female'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $performer = Performer::create([
            'name' => $request->name,
            'performance' => $request->performance,
            'gender' => $request->gender,
        ]);

        return response()->json([
            'Performer created' => new PerformerResource($performer)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Performer  $performer
     * @return \Illuminate\Http\Response
     */
    public function show($performer_id)
    {
        $performer = Performer::find($performer_id);
        if (is_null($performer)) {
            return response()->json('Performer not found', 404);
        }
        return response()->json(new PerformerResource($performer));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Performer  $performer
     * @return \Illuminate\Http\Response
     */
    public function edit(Performer $performer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Performer  $performer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Performer $performer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'performance' => 'required|string|max:255',
            'gender' => 'required|in:male,female'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $performer->name = $request->name;
        $performer->performance = $request->performance;
        $performer->gender = $request->gender;

        $performer->save();

        return response()->json([
            'Performer updated' => new PerformerResource($performer)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Performer  $performer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performer $performer)
    {
        $performer->delete();

        return response()->json('Performer deleted');
    }
}
