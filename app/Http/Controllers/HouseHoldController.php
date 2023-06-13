<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\HouseHoldType;
use App\Models\HouseHoldAdress;
use App\Models\HouseHoldPersonDetails;
use App\Models\PersonContacts;
use App\Models\PersonIdentificationType;
use App\Models\PersonNextOfKin;
use App\Models\Residence;
use Illuminate\Http\Request;

class HouseHoldController extends Controller
{
 

    public function saveHouseHoldAndAtleastOnePerson(Request $request)
    {
        $request->validate([
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
            'household_persons.*.lastName' => 'required|string',
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

                //save next of kin contact
                $nextOfKinContact=PersonContacts::create([
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
                    'lastName' => $memberData['lastName'],
                    'dateOfBirth' => $memberData['dateOfBirth'],
                    'gender' => $memberData['gender'],
                    'country' => $memberData['country'],
                    'countyOfBirth' => $memberData['countyOfBirth'],
                    'residence_id' => $residence->id,
                    'person_contact_id' => $contact->id,
                    'person_next_of_kin_id' => $nextOfKin->id,
                    'person_identifications_id' => $identification->id,
                    'is_alive' => $memberData['is_alive'],
                    'household_id' => $household->id,
                ]);

                $household->household_persons()->save($member);
            }
        }

        return response()->json($household, 201);
    }
}