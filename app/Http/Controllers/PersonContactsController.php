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
        //
        $personContacts = PersonContacts::all();
        return response()->json($personContacts);
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
        $personContacts = PersonContacts::create($request->all());
        return response()->json($personContacts, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
        $personContacts = PersonContacts::findOrFail($id);
        return response()->json($personContacts);
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
        //

        $personContacts = PersonContacts::findOrFail($id);
        $personContacts->update($request->all());
        return response()->json($personContacts);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        $personContacts = PersonContacts::findOrFail($id);
        $personContacts->delete();
        return response()->json(null, 204);
    }
}
