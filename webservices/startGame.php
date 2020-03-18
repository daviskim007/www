<?php

include "connection.php";

$token = $_POST{'token'};
$fb_id = "";

// generate-random-alphanumeric-strings-in-php-
// from https://code.tutsplus.com/tutorials/generate-random-alphanumeric-strings-in-php--cms-32132

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

$session = generate_string($permitted_chars, 20);



if($token){
    try {
    // Returns a Facebook , FacebookResponse object
        $response = $fb->get('/me?fields=id,name', $token);
        $get_data = $response->getDecodedBody();
        $fb_id = $get_data['id'];
        echo $fb_id;

        $sql = "INSERT INTO SESSIONS (session, facebook_id, time_millisecond) VALUES ('$session','$fb_id',0)";
        if(!mysqli_query($GLOBALS['con'],$sql)){

            die("Error in query: ".mysqli_error($con));
            }else{
                $result[] = array(
                    'data' => $session

                )
                echo json_encode($result);


            }

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
