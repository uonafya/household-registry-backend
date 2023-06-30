<?php

namespace App\Http\Controllers;

use App\Models\HouseholdMemberType;
use App\Models\HouseHoldPersonDetails;
use App\Models\PersonContacts;
use App\Models\PersonIdentificationType;
use App\Models\PersonNextOfKin;
use App\Models\Residence;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientRegistyController extends Controller
{
    private $tokenEndpoint;
    private $searchEndpoint;
    private $clientId;
    private $clientSecret;
    private $scope;
    public function __construct()
    {
        $this->tokenEndpoint = env('CLIENT_REGISTRY_TOKEN_ENDPOINT');
        $this->searchEndpoint = env('CLIENT_REGISTRY_SEARCH_ENDPOINT');
        $this->clientId = env('CLIENT_REGISTRY_CLIENT_ID');
        $this->clientSecret = env('CLIENT_REGISTRY_CLIENT_SECRET');
        $this->scope = env('CLIENT_REGISTRY_SCOPE');
    }


    public function searchClient($countryCode, $identifierType, $identifier)
    {
        try {
            // Make a request to obtain the token
            $tokenResponse = $this->getToken();
            $accessToken = $tokenResponse['access_token'];

            // Make a request to search for the client
            $client = new Client(['base_uri' => $this->searchEndpoint]);
            $response = $client->get("/partners/registry/search/{$countryCode}/{$identifierType}/{$identifier}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            // Handle the response
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

            if ($statusCode === 200) {
                // Client found, process the data
                return response()->json($responseData);
            } elseif ($statusCode === 404) {
                // Client not found
                return response()->json(['message' => 'Client not found'], 404);
            } else {
                // Other error occurred
                return response()->json(['message' => 'Error searching for client'], $statusCode);
            }
        } catch (\Exception $e) {
            // Exception occurred
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    private function getToken()
    {
        $client = new Client(['base_uri' => $this->tokenEndpoint]);
        $response = $client->post('/connect/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => $this->scope,
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
    public function savePersonToClientRegistry(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'middleName' => 'nullable|string',
            'lastName' => 'required|string',
            'dateOfBirth' => 'required|date',
            'maritalStatus' => 'required|string',
            'gender' => 'required|string',
            'occupation' => 'required|string',
            'religion' => 'nullable|string',
            'educationLevel' => 'required|string',
            'country' => 'required|string',
            'countyOfBirth' => 'required|string',
            'isAlive' => 'required|boolean',
            'originFacilityKmflCode' => 'required|string',
            'isOnART' => 'required|boolean',
            'nascopCCCNumber' => 'nullable|string',
            'residence' => 'required|array',
            'residence.county' => 'required|string',
            'residence.subCounty' => 'required|string',
            'residence.ward' => 'required|string',
            'residence.village' => 'required|string',
            'residence.landMark' => 'nullable|string',
            'residence.address' => 'required|string',
            'identifications' => 'required|array',
            'identifications.*.CountryCode' => 'required|string',
            'identifications.*.identificationType' => 'required|string',
            'identifications.*.identificationNumber' => 'required|string',
            'contact.primaryPhone' => 'required|string',
            'contact.secondaryPhone' => 'nullable|string',
            'contact.emailAddress' => 'nullable|email',
            'nextOfKin.name' => 'required|string',
            'nextOfKin.relationship' => 'required|string',
            'nextOfKin.residence' => 'required|string',
            'nextOfKin.contact.primaryPhone' => 'required|string',
            'nextOfKin.contact.secondaryPhone' => 'nullable|string',
            'nextOfKin.contact.emailAddress' => 'nullable|email',
        ]);

        if (!$validatedData) {
            return response()->json(['message' => 'Invalid data'], 400);
        }

        try {
            return DB::transaction(function () use ($request) {
                $tokenResponse = $this->getToken();
                $accessToken = $tokenResponse['access_token'];


                try {
                    $url = $this->searchEndpoint;
                    $headers = [
                        'Authorization: Bearer ' . $accessToken,
                        'Content-Type: application/json',
                    ];
                    $data = json_encode($request->all(), JSON_UNESCAPED_UNICODE);

                    $options = [
                        'http' => [
                            'header' => implode("\r\n", $headers),
                            'method' => 'POST',
                            'content' => $data,
                        ],
                    ];

                    $context = stream_context_create($options);
                    $response = file_get_contents($url, false, $context);
        
                    $statusCode = $http_response_header[0];
                    $responseData = json_decode($response, true);
        

                    if (strpos($statusCode, '200') !== false) {

                        $clientNumber =$responseData['clientNumber'];

                        $residenceFields = [
                            'county' => $request->input('residence.county'),
                            'sub_county' => $request->input('residence.subCounty'),
                            'ward' => $request->input('residence.ward'),
                            'village' => $request->input('residence.village'),
                        ];
                        $residence = Residence::create($residenceFields);
            
                        $contactFields = [
                            'primary_phone' => $request->input('contact.primaryPhone'),
                            'secondary_phone' => $request->input('contact.secondaryPhone'),
                            'email' => $request->input('contact.emailAddress'),
                        ];
                        $contact = PersonContacts::create($contactFields);
            
                        $nextOfKinContact = [
                            'primary_phone' => $request->input('nextOfKin.contact.primaryPhone'),
                            'secondary_phone' => $request->input('nextOfKin.contact.secondaryPhone'),
                            'email' => $request->input('nextOfKin.contact.emailAddress'),
                        ];
            
                        $nextOfKinContact = PersonContacts::create($nextOfKinContact);
            
                        $nextOfKin = PersonNextOfKin::create([
                            'name' => $request->input('nextOfKin.name'),
                            'relationship' => $request->input('nextOfKin.relationship'),
                            'residence' => $request->input('nextOfKin.residence'),
                            'contact_id' => $nextOfKinContact->id,
                        ]);
            
                        $personIdendificationType = [
                            'identification_type' => $request->input('identifications.0.identificationType'),
                            'identification_number' => $request->input('identifications.0.identificationNumber'),
                        ];
            
                        $identification = PersonIdentificationType::create($personIdendificationType);
            
                        $houseHoldMember = HouseHoldPersonDetails::create([
                            'firstName' => $request->input('firstName'),
                            'middleName' => $request->input('middleName'),
                            'lastName' => $request->input('lastName'),
                            'nupi_number' => $clientNumber,
                            'dateOfBirth' => $request->input('dateOfBirth'),
                            'gender' => $request->input('gender'),
                            'country' => $request->input('country'),
                            'countyOfBirth' => $request->input('countyOfBirth'),
                            'residence_id' => $residence->id,
                            'person_contact_id' => $contact->id,
                            'person_next_of_kin_id' => $nextOfKin->id,
                            'person_identifications_id' => $identification->id,
                            'is_alive' => $request->input('isAlive'),
                        ]);
            

                        return response()->json([
                            'success' => true,
                            'message' => 'Household person registered successfully',
                            'data' => [
                                'clientRegistry' => $responseData,
                                'houseHoldMember' => $houseHoldMember,
                            ],
                        ], 201);
                    } else {
                        // Error occurred while saving data in the client registry
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Error saving data in the client registry',
                            'response' => $responseData,
                        ], 500);
                    }
                } catch (\Exception $e) {
                    // Exception occurred while sending data to the client registry
                    return response()->json([
                        'status' => 'error',
                        'message' => 'An error occurred while sending data to the client registry',
                        // get the specific error or object causing the error
                        'error' => $e->getMessage() . ' '  . $e->getLine(),
                    ], 500);
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while registering a new household person',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
