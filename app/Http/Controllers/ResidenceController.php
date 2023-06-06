<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $residences = Residence::all();
        return response()->json($residences);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $residence = Residence::create($request->all());
        return response()->json($residence, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Residence $residence)
    {
        //
        return response()->json($residence);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Residence $residence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Residence $residence)
    {
        //
        $residence->update($request->all());
        return response()->json($residence);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Residence $residence)
    {
        //

        $residence->delete();
        return response()->json(null, 204);
    }
}
