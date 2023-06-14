<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\HouseHoldVoiding;
use Illuminate\Http\Request;

class HouseHoldVoidingController extends Controller
{
    public function searchAndVoidAHouseHold(Request $request)
    {


        try {
            $request->validate([
                'house_hold_id' => 'required|integer',
                'reason_for_voiding' => 'required|string',
                'date_voided' => 'required|date',
                'voided_by_id' => 'required|integer',
                'is_voided_approval_status' => 'required|boolean',
            ]);

            $householdExists = HouseHold::where('id', $request->house_hold_id)->exists();
            if (!$householdExists) {
                return response()->json(
                    [
                        'message' => 'Household does not exist',
                    ],
                    404
                );
            }

            $voidedHouseHold = HouseHoldVoiding::create([
                'house_hold_id' => $request->house_hold_id,
                'reason_for_voiding' => $request->reason_for_voiding,
                'date_voided' => $request->date_voided,
                'voided_by_id' => $request->voided_by_id,
                'is_voided_approval_status' => false
            ]);

            return response()->json(
                [
                    'success' => true,
                    'data' => $voidedHouseHold,
                    'message' => 'Household Voiding Approval Request sent',
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to void household',
                    'error' => $e->getMessage(),
                    'success' => false
                ],
                500
            );
        }
    }

    public function approveHouseVoiding(Request $request)
    {
        try {

            $request->validate(
                [
                    'voided_house_hold_id' => 'required|integer',
                    'voiding_approved_by_id' => 'required|integer',
                ]
            );

            $householdBeingVoidedExists = HouseHoldVoiding::where('id', $request->voided_house_hold_id)->exists();

            if (!$householdBeingVoidedExists) {
                return response()->json(
                    [
                        'message' => 'The household does not exist',
                    ],
                    404
                );
            }

            $voidedHouseHold = HouseHoldVoiding::where('id', $request->voided_house_hold_id)->first();
            $voidedHouseHold->voiding_approved_by_id = $request->voiding_approved_by_id;
            $voidedHouseHold->is_voided_approval_status = true;
            $voidedHouseHold->save();

            //update the is_muted inside the household table
            $household = HouseHold::where('id', $voidedHouseHold->house_hold_id)->first();
            $household->is_voided = true;
            $household->save();

            return response()->json(
                [
                    'success' => true,
                    'data' => $voidedHouseHold,
                    'message' => 'Household Muting Approved',
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to approve household voiding',
                    'error' => $e->getMessage(),
                    'success' => false
                ],
                500
            );
        }
    }

    public function getAllVoidedHouseHolds()
    {
        try {
            $voidedHouseHolds = HouseHoldVoiding::all();

            return response()->json(
                [
                    'success' => true,
                    'data' => $voidedHouseHolds,
                    'message' => 'All voided households',
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to get all voided households',
                    'error' => $e->getMessage(),
                    'success' => false
                ],
                500
            );
        }
    }
}
