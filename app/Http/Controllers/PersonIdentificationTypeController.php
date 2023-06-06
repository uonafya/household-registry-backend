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
        //
        // Retrieve all person identification types
        $personIdentificationTypes = PersonIdentificationType::all();

        return response()->json($personIdentificationTypes);
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

          // Validate the request data
          $validatedData = $request->validate([
            'identification_type' => 'required',
            'identification_number' => 'required',
        ]);

        // Create a new person identification type
        $personIdentificationType = PersonIdentificationType::create($validatedData);

        return response()->json($personIdentificationType, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonIdentificationType $personIdentificationType)
    {
        //
        // Retrieve a specific person identification type
        return response()->json($personIdentificationType);
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
    public function update(Request $request, PersonIdentificationType $personIdentificationType)
    {
        //

        // Validate the request data
        $validatedData = $request->validate([
            'identification_type' => 'required',
            'identification_number' => 'required',
        ]);

        // Update the person identification type
        $personIdentificationType->update($validatedData);

        return response()->json($personIdentificationType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonIdentificationType $personIdentificationType)
    {
        //

        // Delete the person identification type
        $personIdentificationType->delete();

        return response()->json(null, 204);
    }
}
