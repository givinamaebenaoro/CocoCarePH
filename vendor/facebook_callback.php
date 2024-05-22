<?php
// Ensure Guzzle is autoloaded
require '../vendor/autoload.php';  // Adjust the path as needed

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

function getAccessToken($authorizationCode) {
    $client = new Client();

    try {
        $response = $client->post('https://graph.facebook.com/v3.3/oauth/access_token', [
            'form_params' => [
                'client_id' => 'your_app_id',
                'client_secret' => 'your_app_secret',
                'redirect_uri' => 'your_redirect_uri',
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

// Example usage
$authorizationCode = $_GET['code'] ?? null;
if ($authorizationCode) {
    $accessToken = getAccessToken($authorizationCode);
    if ($accessToken) {
        // Proceed with using the access token
        echo "Access Token: " . $accessToken;
    } else {
        // Handle error in obtaining access token
        echo "Failed to get access token.";
    }
} else {
    // Handle missing authorization code
    error_log('Authorization code is missing');
    echo "Authorization code is missing.";
}
?>
