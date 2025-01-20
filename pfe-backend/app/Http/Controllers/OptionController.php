<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $options = Option::all();
        return response()->json(['data' => $options], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'id_responsible' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $option = Option::create($request->all());

        return response()->json(['data' => $option], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Option $option)
    {
        return response()->json(['data' => $option], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Option $option)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'abbreviation' => 'sometimes|string|max:10',
            'id_responsible' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $option->update($request->all());

        return response()->json(['data' => $option], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Option $option)
    {
        $option->delete();
        return response()->json(['message' => 'Option deleted successfully'], 200);
    }
}
