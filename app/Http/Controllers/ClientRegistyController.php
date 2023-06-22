<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ClientRegistyController extends Controller
{
    
    public function searchClient($countryCode, $identifierType, $identifier)
    {
        try {
            // Make a request to obtain the token
            $tokenResponse = $this->getToken();
            $accessToken = $tokenResponse['access_token'];

            // Make a request to search for the client
            $client = new Client(['base_uri' => 'https://dhpstagingapi.health.go.ke']);
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

    private function getToken(){
        $client = new Client(['base_uri' => 'https://dhpidentitystagingapi.health.go.ke']);
        $response = $client->post('/connect/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'client_id' => 'partner.test.client',
                'client_secret' => 'partnerTestPwd',
                'scope' => 'DHP.Gateway DHP.Partners',
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
