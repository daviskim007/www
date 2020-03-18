<?php

include "connection.php";

$token = $_POST{'token'};

try {
// Returns a Facebook , FacebookResponse object
	$response = $fb->get('/me?fields=id,name', $token);
} 	catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} 	catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;		
} 

$user = $response->getGraphUser();	

echo 'Name: ' . $user['name'];
