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
        try {
            // Fetch all person next of kins
            $personNextOfKins = PersonNextOfKin::all();
            return response()->json($personNextOfKins);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error fetching person next of kins',
                'error' => $th->getMessage()
            ], 500);
        }
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
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required',
                'relationship' => 'required',
                'residence_id' => 'required',
                'contact_id' => 'required',
            ]);

            // Create a person next of kin
            $personNextOfKin = PersonNextOfKin::create($validatedData);

            return response()->json($personNextOfKin);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error creating person next of kin',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Fetch the person next of kin
            $personNextOfKin = PersonNextOfKin::findOrFail($id);
            return response()->json($personNextOfKin);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error fetching person next of kin',
                'error' => $th->getMessage()
            ], 500);
        } 
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
    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required',
                'relationship' => 'required',
                'residence_id' => 'required',
                'contact_id' => 'required',
            ]);

            // Update the person next of kin
            $personNextOfKin = PersonNextOfKin::findOrFail($id);
            $personNextOfKin->update($validatedData);

            return response()->json([
                'data' => $personNextOfKin,
                'message' => 'Person next of kin updated successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error updating person next of kin',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Fetch the person next of kin
            $personNextOfKin = PersonNextOfKin::findOrFail($id);

            // Delete the person next of kin
            $personNextOfKin->delete();

            return response()->json([
                'message' => 'Person next of kin deleted successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error deleting person next of kin',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
