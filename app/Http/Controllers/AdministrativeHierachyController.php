<?php

namespace App\Http\Controllers;

use App\Models\AdministrativeHierachy;
use Illuminate\Http\Request;

class AdministrativeHierachyController extends Controller
{

    public function index()
    {
        $administrativeHierachies = AdministrativeHierachy::all();
        return response()->json($administrativeHierachies);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'hierarchy_name' => 'required|string',
            'code' => 'required|string',
            'facility' => 'required|string',
            'status' => 'required|string',
            'house_holds' => 'required|string',
            'date_established' => 'required|date',
            'location' => 'required|string',
            'isClosed' => 'required|boolean',
            'isRejected' => 'required|boolean',
            'number_of_chvs' => 'required|string',
        ]);

        $hierarchy = AdministrativeHierachy::create($data);

        return response()->json($hierarchy);
    }

    public function show(AdministrativeHierachy $administrativeHierachy)
    {
        return response()->json($administrativeHierachy);
    }

    public function update(Request $request, AdministrativeHierachy $administrativeHierachy)
    {
        $administrativeHierachy->update($request->all());
        return response()->json($administrativeHierachy);
    }

    public function destroy(AdministrativeHierachy $administrativeHierachy)
    {
        $administrativeHierachy->delete();
        return response()->json(null, 204);
    }
}
