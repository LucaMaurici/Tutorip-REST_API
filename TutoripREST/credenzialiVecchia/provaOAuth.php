<?php
require_once ('../../google-api-php-client-2.5.0/src/vendor/autoload.php');
 
$client_id = '687187969312-67m04h3t9qvk9kuplusu7krk5uhsef2a.apps.googleusercontent.com';
$client_secret = 'IJBei-knwiaLTo4wXC4iFs54';
//$redirect_uri = 'redirect url';

// Creiamo il Google client
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
//$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");



// Creiamo l'interfaccia API OAuth2
$service = new Google_Service_Oauth2($client);

$client->setAccessToken($_SESSION['access_token']);
$user = $service->userinfo->get();

echo $user;

?>