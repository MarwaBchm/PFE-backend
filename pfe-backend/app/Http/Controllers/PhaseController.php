<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $phases = Phase::all();
        return response()->json($phases);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'starting_date' => 'required|date',
            'ending_date' => 'required|date|after:starting_date',
            'for_professor' => 'boolean',
            'for_student' => 'boolean',
            'for_responsible' => 'boolean',
            'for_company' => 'boolean',
        ]);

        $phase = Phase::create($request->all());

        return response()->json($phase, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Phase $phase)
    {
        return response()->json($phase);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Phase $phase)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'starting_date' => 'sometimes|date',
            'ending_date' => 'sometimes|date|after:starting_date',
            'for_professor' => 'sometimes|boolean',
            'for_student' => 'sometimes|boolean',
            'for_responsible' => 'sometimes|boolean',
            'for_company' => 'sometimes|boolean',
        ]);

        $phase->update($request->all());

        return response()->json($phase);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Phase $phase)
    {
        $phase->delete();

        return response()->json(null, 204);
    }
}
