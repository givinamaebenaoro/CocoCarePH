<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class FacebookController extends Controller
{
    public function callback(Request $request)
    {
        $authorizationCode = $request->query('code');

        if ($authorizationCode) {
            $accessToken = $this->getAccessToken($authorizationCode);
            if ($accessToken) {
                // Proceed with using the access token
                return response()->json(['access_token' => $accessToken]);
            } else {
                // Handle error in obtaining access token
                return response()->json(['error' => 'Failed to get access token.'], 500);
            }
        } else {
            // Handle missing authorization code
            return response()->json(['error' => 'Authorization code is missing.'], 400);
        }
    }

    private function getAccessToken($authorizationCode)
    {
        $client = new Client();

        try {
            $response = $client->post('https://graph.facebook.com/v3.3/oauth/access_token', [
                'form_params' => [
                    'client_id' => env('FACEBOOK_APP_ID'),
                    'client_secret' => env('FACEBOOK_APP_SECRET'),
                    'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
                    'code' => $authorizationCode
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['access_token'];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = json_decode($response->getBody(), true);

            // Log or handle the error appropriately
            error_log('Facebook OAuth error: ' . $responseBody['error']['message']);
            return null;
        }
    }

    public function loginWithFacebook()
    {
        $facebookUrl = 'https://www.facebook.com/v3.3/dialog/oauth?' . http_build_query([
            'client_id' => env('FACEBOOK_APP_ID'),
            'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'email', // Add other scopes as needed
        ]);

        return redirect()->away($facebookUrl);
    }
}
