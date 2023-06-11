<?php

namespace App\Http\Controllers;

use App\Models\AdministrativeHierachy;
use Illuminate\Http\Request;

class AdministrativeHierachyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $administrativeHierarchies = AdministrativeHierachy::all();
        return response()->json($administrativeHierarchies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('administrative-hierarchies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'hierarchy_name' => 'required',
            'code' => 'required',
            // Add validation rules for other fields
        ]);

        $administrativeHierarchy = AdministrativeHierachy::create($validatedData);

        return redirect()->route('administrative-hierarchies.show', $administrativeHierarchy->id)
            ->with('success', 'Administrative hierarchy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $administrativehierarchy = AdministrativeHierachy::findOrFail($id);
        return $administrativehierarchy;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $administrativeHierarchy = AdministrativeHierachy::findOrFail($id);
        return view('administrative-hierarchies.edit', compact('administrativeHierarchy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'hierarchy_name' => 'required',
            'code' => 'required',
            // Add validation rules for other fields
        ]);

        $administrativeHierarchy = AdministrativeHierachy::findOrFail($id);
        $administrativeHierarchy->update($validatedData);

        return redirect()->route('administrative-hierarchies.show', $administrativeHierarchy->id)
            ->with('success', 'Administrative hierarchy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdministrativeHierachy $administrativeHierachy)
    {
        //
    }
}
