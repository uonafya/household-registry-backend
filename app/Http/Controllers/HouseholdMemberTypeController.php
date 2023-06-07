<?php

namespace App\Http\Controllers;

use App\Models\HouseholdMemberType;
use Illuminate\Http\Request;

class HouseholdMemberTypeController extends Controller
{
    /**
     * GET request - a listing of the member types.
     */
    public function index()
    {
        try {
            $householdmembertype = HouseholdMemberType::all();
            return response()->json($householdmembertype);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch household member types'], 500);
        }
    }

    /**
     * POST request - Store a newly created member type.
     */
    public function store(Request $request)
    {

        try {
            $householdmembertype = HouseholdMemberType::create($request->all());
            return response()->json($householdmembertype, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create household member type'], 500);
        }
    }

    /**
     * GET request - Fetch the specified member type.
     */
    public function show($id)
    {
        try {
            $householdmembertype = HouseholdMemberType::findOrFail($id);
            // If the member type is found, return it as a json response
            return response()->json([
                'data' => $householdmembertype,
                'message' => 'Household member type retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Household member type not found'], 404);
        }
    }

    /**
     * PUT request - Update the specified member type in db.
     */
    public function update(Request $request, string $id)
    {
        try {
            $householdmembertype = HouseholdMemberType::findOrFail($id);
            $householdmembertype->update($request->all());
            return response()->json($householdmembertype, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update household member type'], 500);
        }
    }

    /**
     * DELETE request - Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $householdmembertype = HouseholdMemberType::findOrFail($id);
            $householdmembertype->delete();
            return response()->json(['message' => 'Household member type deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete household member type'], 500);
        }
    }

    /**
     * GET request - Search the specified HH member type from storage.
     */
    public function search(string $household_membership_name)
    {
        try {
            $householdmembertype = HouseholdMemberType::where('household_membership_name', 'like', '%' . $household_membership_name . '%')->get();
            return response()->json($householdmembertype, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to search household member type'], 500);
        }
    }
}
