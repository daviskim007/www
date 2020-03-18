<?php

include "connection.php";

$token = $_POST{'token'};
$fb_id = "";

if($token){
    try {
    // Returns a Facebook , FacebookResponse object
        $response = $fb->get('/me?fields=id,name', $token);
        $get_data = $response->getDecodedBody();
        $fb_id = $get_data['id'];
        echo $fb_id;

    } 	catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } 	catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
}else{

}

$user = $response->getGraphUser();	

echo 'Name: ' . $user['name'];
