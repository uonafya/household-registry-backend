<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    
    public function index()
    {
        // GEt request...fetch all residences

        try {
            $residences = Residence::all();
            return response()->json($residences);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch residences'], 500);
        }
    }

 
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        // POST request...create a residence

        try {
            $residence = Residence::create($request->all());
            return response()->json($residence, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create residence'], 500);
        }
    }

   
    public function show(string $id)
    {
        // Fetch single residence by id---GET

        try {
            $residence = Residence::findOrFail($id);
            // If the residence is found, return it as a response
            return response()->json([
                'data' => $residence,
                'message' => 'Residence retrieved successfully',
            ], 200);
        } catch (\Exception $e) {
            // If the residence is not found, return an error response
            return response()->json([
                'message' => 'Residence not found',
            ], 404);
        }
    }

   
    public function edit(Residence $residence)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        // PUT/ PATCH...update a residence
        try {
            // 
            $residence = Residence::findOrFail($id);
            $residence->update($request->all());
            return response()->json($residence);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update residence'], 500);
        }
    }

  
    public function destroy($id)
    {   

        // Delete request...delete a residence

        try {
            $residence = Residence::findOrFail($id);
            $residence->delete();
            return response()->json(['message' => 'Residence deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete residence'], 500);
        }
    }

}

