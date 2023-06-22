<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\HouseHoldAdress;
use App\Models\HouseHoldMembership;
use App\Models\HouseholdMemberType;
use App\Models\HouseHoldPersonDetails;
use App\Models\HouseHoldType;
use App\Models\PersonContacts;
use App\Models\PersonIdentificationType;
use App\Models\PersonNextOfKin;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HouseHoldPersonDetailsController extends Controller
{
    public function registerNewHouseHoldPerson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'middleName' => 'required|string',
            'lastName' => 'required|string',
            'nupi_number' => 'nullable|string',
            'dateOfBirth' => 'required|date',
            'gender' => 'required|string',
            'country' => 'required|string',
            'countyOfBirth' => 'required|string',
            'residence' => 'required|array',
            'residence.county' => 'required|string',
            'residence.sub_county' => 'required|string',
            'residence.ward' => 'required|string',
            'residence.village' => 'required|string',
            'contact' => 'required|array',
            'contact.primary_phone' => 'required|string',
            'contact.secondary_phone' => 'nullable|string',
            'contact.email' => 'nullable|email',
            'next_of_kin' => 'required|array',
            'next_of_kin.name' => 'required|string',
            'next_of_kin.relationship' => 'required|string',
            'next_of_kin.residence' => 'required|string',
            'identification' => 'required|array',
            'identification.identification_type' => 'required|string',
            'identification.identification_number' => 'required|string',
            'household_member_type_id' => 'required|integer',
            'is_alive' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            return DB::transaction(function () use ($request) {
                $residence = Residence::create($request->residence);

                $contact = PersonContacts::create($request->contact);

                $nextOfKinContact = PersonContacts::create($request->next_of_kin['contact']);

                $nextOfKin = PersonNextOfKin::create([
                    'name' => $request->next_of_kin['name'],
                    'relationship' => $request->next_of_kin['relationship'],
                    'residence' => $request->next_of_kin['residence'],
                    'contact_id' => $nextOfKinContact->id,
                ]);

                $identification = PersonIdentificationType::create($request->identification);

                $householdMemberType = HouseholdMemberType::findOrFail($request->household_member_type_id);

                $houseHoldMember = HouseHoldPersonDetails::create([
                    'firstName' => $request->firstName,
                    'middleName' => $request->middleName,
                    'lastName' => $request->lastName,
                    'nupi_number' => $request->nupi_number,
                    'dateOfBirth' => $request->dateOfBirth,
                    'gender' => $request->gender,
                    'country' => $request->country,
                    'countyOfBirth' => $request->countyOfBirth,
                    'residence_id' => $residence->id,
                    'person_contact_id' => $contact->id,
                    'person_next_of_kin_id' => $nextOfKin->id,
                    'person_identifications_id' => $identification->id,
                    'is_alive' => $request->is_alive,
                    'household_member_type_id' => $householdMemberType->id,
                ]);

                // $houseHoldMembership = HouseHoldMembership::create([
                //     'household_person_details_id' => $houseHoldMember->id,
                //     'household_member_type_id' => $householdMemberType->id,
                //     'household_id' => $request->household_id,
                // ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Household person registered successfully',
                    'data' => $houseHoldMember,
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while registering a new household person',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getHouseHoldPersonDetails($id)
    {
        try {
            $houseHoldPersonDetails = HouseHoldPersonDetails::where('id', $id)->first();
            if (!$houseHoldPersonDetails) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Household person not found'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Household person details retrieved successfully',
                'data' => $houseHoldPersonDetails
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occured while retrieving household person details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllHouseHoldPersons()
    {
        try {
            $houseHoldPersons = HouseHoldPersonDetails::with('residence',  'personContact', 'personNextOfKin', 'personIdentification')->get();

            if ($houseHoldPersons->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Household persons not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Household persons retrieved successfully',
                'data' => $houseHoldPersons
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving household persons',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateHouseHoldpersonDetails(Request $request, $id)
    {
        try {
            $request->validate([
                'firstName' => 'required|string',
                'middleName' => 'required|string',
                'lastName' => 'required|string',
                'dateOfBirth' => 'required|date',
                'gender' => 'required|string',
                'country' => 'required|string',
                'countyOfBirth' => 'required|string',
                'residence' => 'required|array',
                'residence.county' => 'required|string',
                'residence.sub_county' => 'required|string',
                'residence.ward' => 'required|string',
                'residence.village' => 'required|string',
                'contact' => 'required|array',
                'contact.primary_phone' => 'required|string',
                'contact.secondary_phone' => 'nullable|string',
                'contact.email' => 'nullable|email',
                'next_of_kin' => 'required|array',
                'next_of_kin.name' => 'required|string',
                'next_of_kin.relationship' => 'required|string',
                'next_of_kin.residence' => 'required|string',
                'identification' => 'required|array',
                'identification.identification_type' => 'required|string',
                'identification.identification_number' => 'required|string',
                'household_membership' => 'required|array',
                'household_membership.household_membership_name' => 'required|string',
                'is_alive' => 'required|boolean'
            ]);

            $residence = Residence::create([
                'county' => $request->residence['county'],
                'sub_county' => $request->residence['sub_county'],
                'ward' => $request->residence['ward'],
                'village' => $request->residence['village']
            ]);

            $contact = PersonContacts::create([
                'primary_phone' => $request->contact['primary_phone'],
                'secondary_phone' => $request->contact['secondary_phone'],
                'email' => $request->contact['email']
            ]);

            $nextOfKinContact = PersonContacts::create([
                'primary_phone' => $request->next_of_kin['contact']['primary_phone'],
                'secondary_phone' => $request->next_of_kin['contact']['secondary_phone'],
                'email' => $request->next_of_kin['contact']['email']
            ]);

            $nextOfKin = PersonNextOfKin::create([
                'name' => $request->next_of_kin['name'],
                'relationship' => $request->next_of_kin['relationship'],
                'residence' => $request->next_of_kin['residence'],
                'contact_id' => $nextOfKinContact->id
            ]);

            $identification = PersonIdentificationType::create([
                'identification_type' => $request->identification['identification_type'],
                'identification_number' => $request->identification['identification_number']
            ]);

            $householdMemberShipType = HouseHoldMembership::create([
                'household_membership_name' => $request->household_membership['household_membership_name']
            ]);



            $houseHoldMember = HouseHoldPersonDetails::find($id);

            if (!$houseHoldMember) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Household person not found'
                ], 404);
            }

            $houseHoldMember->update([
                'first_name' => $request->input('firstName'),
                'middle_name' => $request->input('middleName'),
                'last_name' => $request->input('lastName'),
                'dateOfBirth' => $request->input('dateOfBirth'),
                'gender' => $request->input('gender'),
                'country' => $request->input('country'),
                'county_of_birth' => $request->input('countyOfBirth'),
                'residence_id' => $residence->id,
                'contact_id' => $contact->id,
                'next_of_kin_id' => $nextOfKin->id,
                'identification_id' => $identification->id,
                'is_alive' => $request->input('is_alive'),
                'household_membership_id' => $householdMemberShipType->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Household person updated successfully',
                'data' => $houseHoldMember
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating household person details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
