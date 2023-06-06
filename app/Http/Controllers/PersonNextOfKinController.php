<?php

namespace App\Http\Controllers;

use App\Models\PersonNextOfKin;
use Illuminate\Http\Request;

class PersonNextOfKinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // retrieves all the PersonNextOfKin records and returns a view to display them

        $nextOfKin = PersonNextOfKin::all();
        return response()->json($nextOfKin);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //  returns a view to create a new PersonNextOfKin

        return view('person-next-of-kin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  creation of a new PersonNextOfKin record based on the form submission

        $data = $request->validate([
            'name' => 'required',
            'relationship' => 'required',
            'residence' => 'required',
            'contact_id' => 'required',
        ]);

        PersonNextOfKin::create($data);

        return redirect()->route('person-next-of-kin.index')
            ->with('success', 'Next of kin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // retrieves and displays a specific PersonNextOfKin record


        // Fetch single personnextofkin by id
        
        $personNextOfKin = PersonNextOfKin::findOrFail($id);
        return response()->json($personNextOfKin); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonNextOfKin $personNextOfKin)
    {
        // returns a view to edit an existing PersonNextOfKin record.

        return view('person-next-of-kin.edit', compact('personNextOfKin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonNextOfKin $personNextOfKin)
    {
        //  handles the updating of an existing PersonNextOfKin record based on the form submission.

        $data = $request->validate([
            'name' => 'required',
            'relationship' => 'required',
            'residence' => 'required',
            'contact_id' => 'required',
        ]);

        $personNextOfKin->update($data);

        return redirect()->route('person-next-of-kin.index')
            ->with('success', 'Next of kin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonNextOfKin $personNextOfKin)
    {
        //  deletion of a specific PersonNextOfKin record.
    }
}
