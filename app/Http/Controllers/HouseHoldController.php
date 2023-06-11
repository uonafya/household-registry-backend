<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use Illuminate\Http\Request;

class HouseHoldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // GET request - Get a listing of all the household.
            $household = HouseHold::all();
            // If the household are found, return them as a json response
            return response()->json($household);
        } catch (\Exception $e) {
            // If the household are not found, return an error response
            return response()->json(['message' => 'Failed to fetch household'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // POST request...create a household
            $household = HouseHold::create($request->all());
            return response()->json($household, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create household'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Fetch single household by id---GET
            $household = HouseHold::findOrFail($id);
            // If the household is found, return it as a json response
            return response()->json([
                'data' => $household,
                'message' => 'Household retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            // If the household is not found, return an error response
            return response()->json(['message' => 'Household not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // PUT/PATCH request...update a household
            $household = HouseHold::findOrFail($id);
            $household->update($request->all());
            return response()->json($household, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update household'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // DELETE request...delete a household
            $household = HouseHold::findOrFail($id);
            $household->delete();
            return response()->json(['message' => 'Household deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete household'], 500);
        }
    }

    /**
     * Search for the specified household from storage.
     */
    public function search(string $household_name)
    {
        try {
            // GET request...search for a household
            $household = HouseHold::where('household_name', 'like', '%' . $household_name . '%')->get();
            return response()->json($household, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to search for household'], 500);
        }
    }
}
