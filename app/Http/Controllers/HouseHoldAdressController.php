<?php

namespace App\Http\Controllers;

use App\Models\HouseHoldAddress;
use Illuminate\Http\Request;

class HouseHoldAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HouseHoldAddress::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'householdTypeId' => 'required',
            'areaTypeId' => 'required',
            'areaName' => 'required',
            'areaCode' => 'required',
            'parentAreaId' => 'required'
        ]);

        return HouseHoldAddress::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return HouseHoldAddress::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $HouseHoldAddress = HouseHoldAddress::find($id);
        $HouseHoldAddress->update($request->all());
        return $HouseHoldAddress;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return HouseHoldAddress::destroy($id);
    }

    /**
     * Search the specified address from storage.
     */
    public function search(string $householdTypeId)
    {
        return HouseHoldAddress::where('householdTypeId', 'like', '%'.$householdTypeId.'%')->get();
    }
}
