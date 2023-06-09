<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\HouseHoldMembership;
use Illuminate\Http\Request;

class HouseHoldMembershipController extends Controller
{
    // search  household first if exist then add member else create household and add member
    public function seachHouseHold(Request $request)
    {

        $houseHoldName = $request->input('household_name');
        $household = HouseHold::where('household_name', $houseHoldName)->first();
        if ($household) {
            return response()->json([
                'message' => 'Household already exist',
                'household' => $household
            ], 200);
        } else {
            return response()->json([
                'message' => 'Household does not exist',
            ], 404);
        }
    }


    public function getHouseholdMembers($householdId)
    {

        $householdMembers = HouseHoldMembership::where('house_hold_id', $householdId)
            ->with('householdPersonDetails')
            ->get()
            ->map(function ($membership) use ($householdId) {
                $memberData = $membership->householdPersonDetails;
                $memberData['house_hold_id'] = $householdId;
                return $memberData;
            });

        return response()->json($householdMembers);
    }
}
