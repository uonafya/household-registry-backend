<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\HouseHoldType;
use App\Models\HouseHoldAddress;
use App\Models\HouseHoldAdress;
use Illuminate\Http\Request;

class HouseHoldController extends Controller
{
    public function index()
    {
        $households = HouseHold::with('householdType', 'householdAddress')->get();
        return response()->json($households);
    }

    public function show($id)
    {
        $household = HouseHold::with('householdType', 'householdAddress')->findOrFail($id);
        return response()->json($household);
    }

    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'household_name' => 'required|string',
        'household_identifier' => 'required|string',
        'household_type' => 'required|array',
        'household_type.household_type_name' => 'required|string',
        'household_address' => 'required|array',
        'household_address.area_type_id' => 'required|numeric',
        'household_address.area_name' => 'required|string',
        'household_address.area_code' => 'required|string',
        'household_address.parent_area_id' => 'nullable',
    ]);

    // Create the household type
    $householdType = HouseHoldType::create([
        'household_type_name' => $request->input('household_type.household_type_name'),
    ]);

    // Create the household address
    $householdAddress = HouseHoldAdress::create([
        'household_type_id' => $householdType->id,
        'area_type_id' => $request->input('household_address.area_type_id'),
        'area_name' => $request->input('household_address.area_name'),
        'area_code' => $request->input('household_address.area_code'),
        'parent_area_id' => $request->input('household_address.parent_area_id'),
    ]);

    // Create the household
    $household = HouseHold::create([
        'household_name' => $request->input('household_name'),
        'household_identifier' => $request->input('household_identifier'),
        'household_type_id' => $householdType->id,
        'household_address_id' => $householdAddress->id,
    ]);

    return response()->json($household, 201);
}

    public function update(Request $request, $id)
    {
        $household = HouseHold::findOrFail($id);

        $request->validate([
            'household_name' => 'required|string',
            'household_identifier' => 'required|string',
            'household_type_id' => 'required|exists:house_hold_types,id',
            'household_address_id' => 'required|exists:house_hold_addresses,id',
        ]);

        // Update the household type
        $householdType = HouseHoldType::findOrFail($household->household_type_id);
        $householdType->update([
            'household_type_name' => $request->input('household_type_name'),
        ]);

        // Update the household address
        $householdAddress = HouseHoldAdress::findOrFail($household->household_address_id);
        $householdAddress->update([
            'household_type_id' => $request->input('household_type_id'),
            'area_type_id' => $request->input('area_type_id'),
            'area_name' => $request->input('area_name'),
            'area_code' => $request->input('area_code'),
            'parent_area_id' => $request->input('parent_area_id'),
        ]);

        // Update the household
        $household->update([
            'household_name' => $request->input('household_name'),
            'household_identifier' => $request->input('household_identifier'),
            'household_type_id' => $householdType->id,
            'household_address_id' => $householdAddress->id,
        ]);

        return response()->json($household);
    }

    public function destroy($id)
    {
        $household = HouseHold::findOrFail($id);
        $household->delete();

        return response()->json(['message' => 'Household deleted successfully']);
    }
}


