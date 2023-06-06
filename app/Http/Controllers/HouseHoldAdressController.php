<?php

namespace App\Http\Controllers;

use App\Models\HouseHoldAdress;
use Illuminate\Http\Request;

class HouseHoldAdressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HouseHoldAdress::all();
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

        return HouseHoldAdress::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return HouseHoldAdress::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $householdadress = HouseHoldAdress::find($id);
        $householdadress->update($request->all());
        return $householdadress;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return HouseHoldAdress::destroy($id);
    }

    /**
     * Search the specified address from storage.
     */
    public function search(string $householdTypeId)
    {
        return HouseHoldAdress::where('householdTypeId', 'like', '%'.$householdTypeId.'%')->get();
    }
}
