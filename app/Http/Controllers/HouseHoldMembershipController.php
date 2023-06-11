<?php

namespace App\Http\Controllers;

use App\Models\HouseHoldMembership;
use Illuminate\Http\Request;

class HouseHoldMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // GET request - Get a listing of all the household membership.
            $householdmembership = HouseHoldMembership::all();
            // If the household membership are found, return them as a json response
            return response()->json($householdmembership);
        } catch (\Exception $e) {
            // If the household membership are not found, return an error response
            return response()->json(['message' => 'Failed to fetch household membership'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // POST request...create a household membership
            $householdmembership = HouseHoldMembership::create($request->all());
            return response()->json($householdmembership, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create household membership'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Fetch single household membership by id---GET
            $householdmembership = HouseHoldMembership::findOrFail($id);
            // If the household membership is found, return it as a json response
            return response()->json([
                'data' => $householdmembership,
                'message' => 'Household membership retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            // If the household membership is not found, return an error response
            return response()->json(['message' => 'Household membership not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // PUT/PATCH request...update a household membership
            $householdmembership = HouseHoldMembership::findOrFail($id);
            $householdmembership->update($request->all());
            return response()->json($householdmembership, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update household membership'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // DELETE request...delete a household membership
            $householdmembership = HouseHoldMembership::findOrFail($id);
            $householdmembership->delete();
            return response()->json(['message' => 'Household membership deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete household membership'], 500);
        }
    }

    /**
     * Search the specified HH Membership from storage.
     */
    public function search(string $household_person_details_id)
    {
        try {
            // Fetch single household membership by id---GET
            $householdmembership = HouseHoldMembership::where('household_person_details_id','like', '%' . $household_person_details_id . '%')->get();
            // If the household membership is found, return it as a json response
            return response()->json([
                'data' => $householdmembership,
                'message' => 'Household membership retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            // If the household membership is not found, return an error response
            return response()->json(['message' => 'Household membership not found'], 404);
        }
    }
}
