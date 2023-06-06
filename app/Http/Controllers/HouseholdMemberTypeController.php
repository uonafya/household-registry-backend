<?php

namespace App\Http\Controllers;

use App\Models\HouseholdMemberType;
use Illuminate\Http\Request;

class HouseholdMemberTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HouseholdMemberType::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'household_membership_type_id' => 'required',
            'household_membership_name' => 'required'
        ]);

        return HouseholdMemberType::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return HouseholdMemberType::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hh_member_type = HouseholdMemberType::find($id);
        $hh_member_type->update($request->all());
        return $hh_member_type;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return HouseholdMemberType::destroy($id);
    }

    /**
     * Search the specified HH member type from storage.
     */
    public function search(string $household_membership_name)
    {
        return HouseholdMemberType::where('household_membership_name', 'like', '%'.$household_membership_name.'%')->get();
    }
}
