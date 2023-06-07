<?php

namespace App\Http\Controllers;

use App\Models\HouseHoldAdress;
use Illuminate\Http\Request;

class HouseHoldAdressController extends Controller
{
    /**
     * GET request - Get a listing of all the household addresses.
     */
    public function index()
    {
        try {
            $householdadress = HouseHoldAdress::all();
            // If the household addresses are found, return them as a json response
            return response()->json($householdadress);
        } catch (\Exception $e) {
            // If the household addresses are not found, return an error response
            return response()->json(['message' => 'Failed to fetch household addresses'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // POST request...create a household address
            $householdadress = HouseHoldAdress::create($request->all());
            return response()->json($householdadress, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create household address'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id)
    {
        try {
            // Fetch single household address by id---GET
            $householdadress = HouseHoldAdress::findOrFail($id);
            // If the household address is found, return it as a json response
            return response()->json([
                'data' => $householdadress,
                'message' => 'Household address retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            // If the household address is not found, return an error response
            return response()->json(['message' => 'Household address not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // PUT request...update a household address
            $householdadress = HouseHoldAdress::findOrFail($id);
            $householdadress->update($request->all());
            return response()->json($householdadress, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update household address'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // DELETE request...delete a household address
            $householdadress = HouseHoldAdress::findOrFail($id);
            $householdadress->delete();
            return response()->json(['message' => 'Household address deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete household address'], 500);
        }
    }

    /**
     * Search the specified address from storage.
     */
    public function search(string $household_type_id)
    {
        try {
            // GET request...search a household address
            $householdadress = HouseHoldAdress::where('household_type_id','like', '%' . $household_type_id . '%')->get();
            return response()->json($householdadress, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to search household address'], 500);
        }
    }
}
