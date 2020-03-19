<?php

include "connection.php";

$millisec = $_POST['millisec'];
$session = $_POST['session'];
$time = $_POST['time'];
$token = $_POST['token'];

$sql = "UPDATE SESSIONS SET time_millisecond = '$millisec', time_display = '$time' WHERE session = '$session'";
    if(!mysqli_query($GLOBALS['con'],$sql)){

        die("Error in query: ".mysqli_error($con));
        }
    else{
    // Update on the players table
        if($token){
            try {
            // Returns a Facebook , FacebookResponse object
            $response = $fb->get('/me?fields=id,first_name, last_name, email', $token);
            $get_data = $response->getDecodedBody();
            $fb_id = $get_data['id'];
            /* what we need to do is to get the time in millisecond again from the seesion table, as well as a display time
            so that we can insert it in the players table*/
            //  This is a sql statement
            $sqlScore = ("Select * FROM SESSIONS WHERE session = '$session'");
            $sql_result_score = mysqli_query($con, $sqlScore);
            // Need more visible here
            $row = mysqli_fetch_assoc($sql_result_score);
            //  Recuperate the core time and call the variable score_time
            $score_time = $row['time_millisecond'];
            $time = $row['time_display'];
            $sql_chk = mysqli_query($con, "Select * FROM PLAYERS WHERE Facebook_id = '$fb_id'");
            $row = mysqli_fetch_assoc($sql_chk);
            $highest_score_time = $row['highscore_milli'];
            $highscore_display_time = $row['highscore_display'];
            //Make the Verification. If the score time is less than the highest score time, set the high score.
            if ($score_time < $highest_score_time){
                $highest_score_time = $score_time;
                $highscore_display_time = $time;
            // Set the variable for the display name.
            }

            //update my SQL statement in a variable
            $sql_update = "UPDATE PLAYERS SET highscore_milli = '$highest_score_time', highscore_display = '$highscore_display_time' WHERE Facebook_id = '$fb_id'";

            //run our SQL statement here and if it's not okay an error message will be displayed.
            if(!mysqli_query($con, $sql_update)){
            // the message that is being returned from the error
                die('Error in update query: '.mysqli_connect_error());
            }


            // echo fb_id;
            /*
            $sql = "INSERT INTO SESSIONS (session, facebook_id, time_millisecond) VALUES ('$session','$fb_id',0)";
            if(!mysqli_query($GLOBALS['con'],$sql)){

                die("Error in query: ".mysqli_error($con));
                }else{

                    $result[] = array(
                        'data' => $session

                    );
                    echo json_encode($result);


                }
    */
        } 	catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } 	catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }


        }
    }