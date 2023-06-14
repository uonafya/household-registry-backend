<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\HouseHoldMuting;
use Illuminate\Http\Request;

class HouseHoldMutingController extends Controller
{
    //mute a household

    public function searchAndMuteAHouseHold(Request $request)
    {


        try {
            $request->validate([
                'house_hold_id' => 'required|integer',
                'reason_for_muting' => 'required|string',
                'date_muted' => 'required|date',
                'muted_by_id' => 'required|integer',
                'is_muted_approval_status' => 'required|boolean',
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

            $mutedHouseHold = HouseHoldMuting::create([
                'house_hold_id' => $request->house_hold_id,
                'reason_for_muting' => $request->reason_for_muting,
                'date_muted' => $request->date_muted,
                'muted_by_id' => $request->muted_by_id,
                'is_muted_approval_status' => false
            ]);

            return response()->json(
                [
                    'success' => true,
                    'data' => $mutedHouseHold,
                    'message' => 'Household Muting Approval Request sent',
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to mute household',
                    'error' => $e->getMessage(),
                    'success' => false
                ],
                500
            );
        }
    }

    public function approveHouseHoldMuting(Request $request)
    {
        try {

            $request->validate(
                [
                    'muted_house_hold_id' => 'required|integer',
                    'muting_approved_by_id' => 'required|integer',
                ]
            );

            $householdMutingExists = HouseHoldMuting::where('id', $request->muted_house_hold_id)->exists();

            if (!$householdMutingExists) {
                return response()->json(
                    [
                        'message' => 'The household does not exist',
                    ],
                    404
                );
            }

            $mutedHouseHold = HouseHoldMuting::where('id', $request->muted_house_hold_id)->first();
            $mutedHouseHold->muting_appproved_by_id = $request->muting_approved_by_id;
            $mutedHouseHold->is_muted_approval_status = true;
            $mutedHouseHold->save();

            //update the is_muted inside the household table
            $household = HouseHold::where('id', $mutedHouseHold->house_hold_id)->first();
            $household->is_muted = true;
            $household->save();

            return response()->json(
                [
                    'success' => true,
                    'data' => $mutedHouseHold,
                    'message' => 'Household Muting Approved',
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to approve household muting',
                    'error' => $e->getMessage(),
                    'success' => false
                ],
                500
            );
        }
    }
}
