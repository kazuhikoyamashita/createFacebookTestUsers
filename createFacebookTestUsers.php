<?php
require_once('./curlPost.php');

define(APP_ID, '');
define(APP_SECRET, '');

try {
    $clientId = APP_ID;
    $clientSecret = APP_SECRET;

    if (empty($clientId) || empty($clientSecret)) {
        throw new Exception("Error: Failed to get app id or secret key.");
    }

    // GET ACCESS TOKEN
    $url = 'https://graph.facebook.com/oauth/access_token';
    $params = array('client_id' => $clientId, 'client_secret' => $clientSecret, 'grant_type' => 'client_credentials');
    $accessToken = curlPost($url, $params);
    if ($accessToken == false) {
        throw new Exception("Error: Failed to get access token.");
    }
    $accessToken = str_replace("access_token=", "", $accessToken);
    
    // CREATE TEST USERS
    $url = 'https://graph.facebook.com/' . $clientId . '/accounts/test-users';
    $params = array('installed' => 'true', 'permissions' => 'read_stream', 'method' => 'post', 'access_token' => $accessToken);
    $json = curlPost($url, $params);
    if ($json == false) {
        throw new Exception("Error: Failed to create test users.");
    }
    $testUsers = json_decode($json);

    echo "login_url: " . $testUsers->login_url . "\n";
    echo "email: " . $testUsers->email . "\n";
    echo "password: " . $testUsers->password . "\n";

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

