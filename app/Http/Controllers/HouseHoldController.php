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
        return HouseHold::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'household_name' => 'required',
            'household_identifier' => 'required',
            'household_type_id' => 'required',
            'household_address_id' => 'required',
        ]);

        return HouseHold::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return HouseHold::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $household = HouseHold::find($id);
        $household->update($request->all());
        return $household;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return HouseHold::destroy($id);
    }

    /**
     * Search for the specified household from storage.
     */
    public function search(string $household_name)
    {
        return HouseHold::where('household_name', 'like', '%'.$household_name.'%')->get();
    }
}
