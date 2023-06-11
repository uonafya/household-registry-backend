<?php

namespace App\Http\Controllers;

use App\Models\PersonIdentificationType;
use Illuminate\Http\Request;

class PersonIdentificationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch all person identification types
            $personIdentificationTypes = PersonIdentificationType::all();
            return response()->json($personIdentificationTypes);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error fetching person identification types',
                'error' => $th->getMessage()
            ], 500);
        }
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
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'identification_type' => 'required',
                'identification_number' => 'required',
            ]);

            // Create a person identification type
            $personIdentificationType = PersonIdentificationType::create($validatedData);

            return response()->json($personIdentificationType);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error creating person identification type',
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
            // Fetch the person identification type
            $personIdentificationType = PersonIdentificationType::findOrFail($id);
            return response()->json($personIdentificationType);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error fetching person identification type',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonIdentificationType $personIdentificationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Fetch the person identification type
            $personIdentificationType = PersonIdentificationType::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'identification_type' => 'required',
                'identification_number' => 'required',
            ]);

            // Update the person identification type
            $personIdentificationType->update($validatedData);

            return response()->json($personIdentificationType);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error updating person identification type',
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
            // Fetch the person identification type
            $personIdentificationType = PersonIdentificationType::findOrFail($id);

            // Delete the person identification type
            $personIdentificationType->delete();

            return response()->json(['message' => 'Person Identification TypeSS deleted successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error deleting person identification type',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
