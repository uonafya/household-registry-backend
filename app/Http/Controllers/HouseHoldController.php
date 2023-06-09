<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\HouseholdMemberType;
use App\Models\HouseHoldMigration;
use App\Models\HouseHoldType;
use App\Models\HouseHoldAdress;
use App\Models\HouseHoldMembership;
use App\Models\HouseHoldPersonDetails;
use App\Models\PersonContacts;
use App\Models\PersonIdentificationType;
use App\Models\PersonNextOfKin;
use App\Models\Residence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HouseHoldController extends Controller
{


    public function saveHouseHoldAndAtleastOnePerson(Request $request)
    {
        try {
            $request->validate([
                'household_registered_by_id' => 'nullable|numeric',
                'household_approved_by_id' => 'nullable|numeric',
                'household_name' => 'required|string',
                'household_identifier' => 'required|string',
                'household_type' => 'required|array',
                'household_type.household_type_name' => 'required|string',
                'household_address' => 'required|array',
                'household_address.area_type_id' => 'required|numeric',
                'household_address.area_name' => 'required|string',
                'household_address.area_code' => 'required|string',
                'household_address.parent_area_id' => 'nullable',
                'household_persons' => 'required|array',
                'household_persons.*.firstName' => 'required|string',
                'household_persons.*.middleName' => 'nullable|string',
                'household_persons.*.lastName' => 'required|string',
                'household_persons.*.nupi_number' => 'nullable|string',
                'household_persons.*.dateOfBirth' => 'required|date',
                'household_persons.*.gender' => 'required|string',
                'household_persons.*.country' => 'required|string',
                'household_persons.*.countyOfBirth' => 'required|string',
                'household_persons.*.residence' => 'required|array',
                'household_persons.*.residence.county' => 'required|string',
                'household_persons.*.residence.sub_county' => 'required|string',
                'household_persons.*.residence.ward' => 'required|string',
                'household_persons.*.residence.village' => 'required|string',
                'household_persons.*.contact' => 'required|array',
                'household_persons.*.contact.primary_phone' => 'required|string',
                'household_persons.*.contact.secondary_phone' => 'nullable|string',
                'household_persons.*.contact.email' => 'nullable|email',
                'household_persons.*.next_of_kin' => 'required|array',
                'household_persons.*.next_of_kin.name' => 'required|string',
                'household_persons.*.next_of_kin.relationship' => 'required|string',
                'household_persons.*.next_of_kin.residence' => 'required|string',
                'household_persons.*.identification' => 'required|array',
                'household_persons.*.identification.identification_type' => 'required|string',
                'household_persons.*.identification.identification_number' => 'required|string',
                'household_persons.*.household_member_type_id' => 'required|numeric',
                'household_persons.*.is_alive' => 'required|boolean',
            ]);

            // Create the household type
            $householdType = HouseHoldType::create([
                'household_type_name' => $request->input('household_type.household_type_name'),
            ]);

            // Create the household address
            $householdAddress = HouseHoldAdress::create([
                'household_type_id' => $householdType->id,
                'area_type_id' => $request->input('household_address.area_type_id'),
                'area_name' => $request->input('household_address.area_name'),
                'area_code' => $request->input('household_address.area_code'),
                'parent_area_id' => $request->input('household_address.parent_area_id'),
            ]);

            // Create the household
            $household = HouseHold::create([
                'household_name' => $request->input('household_name'),
                'household_identifier' => $request->input('household_identifier'),
                'household_type_id' => $householdType->id,
                'household_address_id' => $householdAddress->id,
                'household_registered_by_id' => $request->input('household_registered_by_id'),
                'household_approved_by_id' => $request->input('household_approved_by_id'),
            ]);

            // Check if there are any members provided
            if ($request->has('household_persons')) {
                // Create the members and associate them with the household
                foreach ($request->input('household_persons') as $memberData) {
                    $residence = Residence::create([
                        'county' => $memberData['residence']['county'],
                        'sub_county' => $memberData['residence']['sub_county'],
                        'ward' => $memberData['residence']['ward'],
                        'village' => $memberData['residence']['village'],
                    ]);

                    $contact = PersonContacts::create([
                        'primary_phone' => $memberData['contact']['primary_phone'],
                        'secondary_phone' => $memberData['contact']['secondary_phone'],
                        'email' => $memberData['contact']['email'],
                    ]);

                    // Save next of kin contact
                    $nextOfKinContact = PersonContacts::create([
                        'primary_phone' => $memberData['next_of_kin']['contact']['primary_phone'],
                        'secondary_phone' => $memberData['next_of_kin']['contact']['secondary_phone'],
                        'email' => $memberData['next_of_kin']['contact']['email'],
                    ]);

                    $nextOfKin = PersonNextOfKin::create([
                        'name' => $memberData['next_of_kin']['name'],
                        'relationship' => $memberData['next_of_kin']['relationship'],
                        'residence' => $memberData['next_of_kin']['residence'],
                        'contact_id' => $nextOfKinContact->id,
                    ]);

                    $identification = PersonIdentificationType::create([
                        'identification_type' => $memberData['identification']['identification_type'],
                        'identification_number' => $memberData['identification']['identification_number'],
                    ]);


                    $member = HouseHoldPersonDetails::create([
                        'firstName' => $memberData['firstName'],
                        'middleName' => $memberData['middleName'],
                        'lastName' => $memberData['lastName'],
                        'nupi_number' => $memberData['nupi_number'],
                        'dateOfBirth' => $memberData['dateOfBirth'],
                        'gender' => $memberData['gender'],
                        'country' => $memberData['country'],
                        'countyOfBirth' => $memberData['countyOfBirth'],
                        'residence_id' => $residence->id,
                        'person_contact_id' => $contact->id,
                        'person_next_of_kin_id' => $nextOfKin->id,
                        'person_identifications_id' => $identification->id,
                        'household_member_type_id' => $memberData['household_member_type_id'],
                        'is_alive' => $memberData['is_alive'],
                    ]);

                    // $household->household_persons()->save($member);

                    $householdMemberType = HouseholdMemberType::where('id', $memberData['household_member_type_id'])->first();
                    $householdMembership = HouseHoldMembership::create([
                        'household_person_details_id' => $member->id,
                        'household_member_type_id' => $householdMemberType->id,
                        'house_hold_id' => $household->id,
                    ]);

                    // $household->household_memberships()->save($householdMembership);
                }
            }

            return response()->json([
                'message' => 'Household created. Pending approval',
                'household' => $household,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create household!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function approveRegisteredHouseHold(Request $request)
    {
        try {
            $request->validate([
                'house_hold_id' => 'required|integer',
                'approved_by' => 'required|integer',
            ]);

            $household = HouseHold::findOrFail($request->input('house_hold_id'));

            if (!$household) {
                return response()->json([
                    'message' => 'Household not found!',
                ], 404);
            }

            $household->is_household_approved = true;
            $household->household_approved_by_id = $request->input('approved_by');
            $household->save();

            return response()->json([
                'message' => 'Household approved!',
                'household' => $household,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to approve household!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getHouseholdMembers($householdId)
    {
        try {
            $household = HouseHold::findOrFail($householdId);

            if (!$household) {
                return response()->json([
                    'message' => 'Household not found!',
                ], 404);
            }

            $members = $household->household_memberships()->with('householdPersonDetails')->get();

            return response()->json([
                'success' => true,
                'members' => $members,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch household members!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getAllHouseholds(Request $request)
    {
        try {

            $isVoided = $request->input('is_voided');
            $isMuted = $request->input('is_muted');
            $isApproved = $request->input('is_approved');

            $query = HouseHold::query();

            if ($isVoided !== null) {
                $query->where('is_voided', $isVoided);
            }
            if ($isMuted !== null) {
                $query->where('is_muted', $isMuted);
            }
            if ($isApproved !== null) {
                $query->where('is_household_approved', $isApproved);
            }

            $households = $query->get();

            return response()->json([
                'success' => true,
                'households' => $households,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching households',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getApprovedHouseholds($isApproved)
    {
        try {
            $approvedHouseholds = HouseHold::where('is_household_approved', $isApproved)->get();

            return response()->json([
                'success' => true,
                'approved_households' => $approvedHouseholds,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching approved households',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function handleHouseHoldMigration(Request $request)
    {

        try {
            $request->validate([
                'house_hold_id' => 'required|integer',
                'household_name' => 'required|string',
                'old_residence_id' => 'required|integer',
                'new_residence' => 'required|array',
                'new_residence.*.area_type_id' => 'required|integer',
                'new_residence.*.household_type_id' => 'required|integer',
                'new_residence.*.area_name' => 'required|string',
                'new_residence.*.area_code' => 'required|string',
                'new_residence.*.parent_area_id' => 'nullable|integer',
                'reason_for_migration' => 'required|string',
                'initiated_by_chv_id' => 'required|integer',
                'date_of_migration' => 'required|date',
            ]);

            $household = HouseHold::where('id', $request->input('house_hold_id'))->first();

            if (!$household) {
                return response()->json([
                    'success' => false,
                    'message' => 'Household not found',
                ], 404);
            }

            $newHouseHoldAddressData = $request->input('new_residence')[0];


            // Create the household address
            $newHouseholdAddress = HouseHoldAdress::create([
                'household_type_id' => $newHouseHoldAddressData['household_type_id'],
                'area_type_id' => $newHouseHoldAddressData['area_type_id'],
                'area_name' => $newHouseHoldAddressData['area_name'],
                'area_code' => $newHouseHoldAddressData['area_code'],
                'parent_area_id' => $newHouseHoldAddressData['parent_area_id'],
            ]);


            $migrateHouseHold = HouseHoldMigration::create([
                'house_hold_id' => $request->input('house_hold_id'),
                'old_residence_id' => $request->input('old_residence_id'),
                'new_residence_id' => $newHouseholdAddress->id,
                'reason_for_migration' => $request->input('reason_for_migration'),
                'initiated_by_chv_id' => $request->input('initiated_by_chv_id'),
                'date_of_migration' => $request->input('date_of_migration'),
                'is_approved' => false,
            ]);

            if ($migrateHouseHold) {
                return response()->json([
                    'success' => true,
                    'message' => 'Household migration approval sent.',
                    'migrated_household' => $migrateHouseHold,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Household could not be migrated',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Household could not be migrated',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function approveHouseHoldMigration(Request $request)
    {
        try {

            $request->validate([
                'house_hold_id' => 'required|integer',
                'household_approved_by' => 'required|boolean',
            ]);

            $householdMigration = HouseHoldMigration::where('house_hold_id', $request->input('house_hold_id'))->first();

            if (!$householdMigration) {
                return response()->json([
                    'success' => false,
                    'message' => 'Household migration not found',
                ], 404);
            }

            $householdMigration->is_approved = true;
            $householdMigration->approved_by_cha_id = $request->input('household_approved_by');
            $householdMigration->save();

            return response()->json([
                'success' => true,
                'message' => 'Household migration approved',
                'household_migration' => $householdMigration,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Household migration could not be approved',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllMigratedHouseholds()
    {
        try {
            $migratedHouseholds = HouseHoldMigration::all();

            return response()->json([
                'success' => true,
                'migrated_households' => $migratedHouseholds,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed To retrive migrated households',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function getAllPendingMigratedHouseholds()
    {
        try {
            $migratedHouseholds = HouseHoldMigration::where('is_approved', false)->get();

            return response()->json([
                'success' => true,
                'migrated_households' => $migratedHouseholds,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed To retrive migrated households',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function mergeHouseHolds(Request $request)
    {
        try {

            $request->validate([
                'household_id_one' => 'required|integer',
                'household_id_two' => 'required|integer',
                'merging_initaited_by' => 'required|integer',
                'merging_approved_by' => 'required|integer',
            ]);

            //find the two households by id and get there members
            $householdOne = HouseHold::where('id', $request->input('household_id_one'))->first();
            $householdTwo = HouseHold::where('id', $request->input('household_id_two'))->first();

            if (!$householdOne || !$householdTwo) {
                return response()->json([
                    'data' => 'Household Members not found'
                ], 200);
            }

            $householdTwoMembers = $householdTwo->household_memberships;

            foreach ($householdTwoMembers as $membership) {
                $membership->house_hold_id = $householdOne->id;
                $membership->save();
            }
            
            // Void household two
            $householdTwo->delete();

            // Get the updated members of household one
            $householdOneMembers = $householdOne->household_memberships;

            return response()->json([
                'success' => true,
                'data' => [
                    'householdOneMembers' => $householdOneMembers,
                ],
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to merge households',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function mergeHouseHoldsByCreatingNewHousehold(Request $request){
        try {

            $request->validate([
                'household_id_one' => 'required|integer',
                'household_id_two' => 'required|integer',
                'merging_initaited_by' => 'required|integer',
                'merging_approved_by' => 'required|integer',
                'household_registered_by_id' => 'nullable|numeric',
                'household_approved_by_id' => 'nullable|numeric',
                'household_name' => 'required|string',
                'household_identifier' => 'required|string',
                'household_type' => 'required|array',
                'household_type.household_type_name' => 'required|string',
                'household_address' => 'required|array',
                'household_address.area_type_id' => 'required|numeric',
                'household_address.area_name' => 'required|string',
                'household_address.area_code' => 'required|string',
                'household_address.parent_area_id' => 'nullable',
            ]);

             //find the two households by id and get there members
             $householdOne = HouseHold::where('id', $request->input('household_id_one'))->first();
             $householdTwo = HouseHold::where('id', $request->input('household_id_two'))->first();

             if (!$householdOne || !$householdTwo) {
                return response()->json([
                    'data' => 'Household Members not found'
                ], 200);
            }

            //  // Create the household type
            $householdType = HouseHoldType::create([
                'household_type_name' => $request->input('household_type.household_type_name'),
            ]);

            // Create the household address
            $householdAddress = HouseHoldAdress::create([
                'household_type_id' => $householdType->id,
                'area_type_id' => $request->input('household_address.area_type_id'),
                'area_name' => $request->input('household_address.area_name'),
                'area_code' => $request->input('household_address.area_code'),
                'parent_area_id' => $request->input('household_address.parent_area_id'),
            ]);

            // Create the household
            $newHousehold = HouseHold::create([
                'household_name' => $request->input('household_name'),
                'household_identifier' => $request->input('household_identifier'),
                'household_type_id' => $householdType->id,
                'household_address_id' => $householdAddress->id,
                'household_registered_by_id' => $request->input('household_registered_by_id'),
                'household_approved_by_id' => $request->input('household_approved_by_id'),
            ]);

            //get members from both households
            $householdTwoMembers = $householdTwo->household_memberships;
            $householdOneMembers= $householdOne->household_memberships;
           
             foreach($householdOneMembers as $member){
                $member->house_hold_id=$newHousehold->id;
                $member->save();
            }

            foreach ($householdTwoMembers as $membership) {
                $membership->house_hold_id = $newHousehold->id;
                $membership->save();
            }
            
            // Void household two
            $householdTwo->delete();
            $householdOne->delete();

            // Get the updated members of household one
            $newHouseHoldWithMembers = $newHousehold->household_memberships;

            return response()->json([
                'success' => true,
                'data' => [
                    'householdOneMembers' => $newHouseHoldWithMembers,
                ],
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to merge households',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
