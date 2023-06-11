<?php

namespace App\Http\Controllers;

use App\Models\PersonContacts;
use Illuminate\Http\Request;

class PersonContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // GET request - Get a listing of all the person contacts.
            $personContacts = PersonContacts::all();
            // If the person contacts are found, return them as a json response
            return response()->json($personContacts);
        } catch (\Exception $e) {
            // If the person contacts are not found, return an error response
            return response()->json(['message' => 'Failed to fetch person contacts'], 500);
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
            // POST request...create a person contacts
            $personContacts = PersonContacts::create($request->all());
            return response()->json($personContacts, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create person contacts'], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Fetch single person contacts by id---GET
            $personContacts = PersonContacts::findOrFail($id);
            // If the person contacts is found, return it as a json response
            return response()->json([
                'data' => $personContacts,
                'message' => 'Person contacts retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            // If the person contacts is not found, return an error response
            return response()->json(['message' => 'Person contacts not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonContacts $personContacts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        try {
            // PUT/PATCH request...update a person contacts
            $personContacts = PersonContacts::findOrFail($id);
            $personContacts->update($request->all());
            return response()->json($personContacts, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update person contacts'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // DELETE request...delete a person contacts
            $personContacts = PersonContacts::findOrFail($id);
            $personContacts->delete();
            return response()->json(['message' => 'Person contacts deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete person contacts'], 500);
        }
    }

     /**
     * Search the specified resource from storage.
     */
    public function search($email)
    {
        try {
            // GET request...search a person contacts
            $personContacts = PersonContacts::where('email', 'like', '%' . $email . '%')->get();
            return response()->json($personContacts, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to search person contacts'], 500);
        }
    }
}
