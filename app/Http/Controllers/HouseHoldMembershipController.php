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
        return HouseHoldMembership::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'household_person_details_id' => 'required',
            'household_member_type_id' => 'required',
            'household_id' => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $householdmembership = HouseHoldMembership::findOrFail($id);
        return response()->json($householdmembership);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hh_membership = HouseHoldMembership::find($id);
        $hh_membership->update($request->all());
        return $hh_membership;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return HouseHoldMembership::destroy($id);
    }

    /**
     * Search the specified HH Membership from storage.
     */
    public function search(string $household_person_details_id)
    {
        return HouseHoldMembership::where('household_person_details_id',$household_person_details_id)->get();
    }
}
