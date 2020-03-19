<?php
function Console_log($data){
    echo "<script>console.log( 'PHP_Console: " . $data . "' );</script>";
}
$testVal = "테스트 데이터";
Console_log($testVal);

error_reporting(E_ALL);
ini_set("display_errors", 1);
Console_log('0');
include "connection.php";
Console_log('00');
$token = $_POST['token'];
Console_log('000');
$session = $_POST['session'];
Console_log('0000');

if($token){
    try {
        // Returns a Facebook , FacebookResponse object
        Console_log('1');
        $response = $fb->get('/me?fields=id,first_name, last_name, email', $token);
        $get_data = $response->getDecodedBody();
        $fb_id = $get_data['id'];
        $first_name = mysqli_real_escape_string($con, $get_data['first_name']);
        $last_name = mysqli_real_escape_string($con, $get_data['last_name']);
        $email = $get_data['email'];
        Console_log('2');
        /* what we need to do is to get the time in millisecond again from the seesion table, as well as a display time
        so that we can insert it in the players table*/
        //  This is a sql statement
        $sqlScore = ("Select * FROM SESSIONS where session = '$session'");
        $sql_result_score = mysqli_query($con, $sqlScore);
        // Need more visible here
        $row = mysqli_fetch_assoc($sql_result_score);
        //  Recuperate the core time and call the variable score_time
        $score_time = $row['time_millisecond'];
        $time = $row['time_display'];

        /*Before inserting into the players table we first need to check whether a record exist with the Facebook id.
        and if it does not exist then we are going to insert the new record. */
        $sql_chk = mysqli_query($con, "Select * FROM PLAYERS WHERE Facebook_id = '$fb_id'");
        // for the result, count the number of rows
        $result = mysqli_num_rows($sql_chk);
        // if the result is equal to one, it means this record already exist and we can just update it, else we need to insert in new record.
        if($result==1){


        }else{
            //define my SQL statement in a variable
            Console_log('0120');
            $sql_insert = "INSERT INTO PLAYERS (Facebook_id, name, surname, email, highscore_milli, highscore_display) VALUES ('$fb_id','$first_name','$last_name','$email','$score_time','$time')";
            //run our SQL statement here and if it's not okay an error message will be displayed.
            if(!mysqli_query($con, $sql_insert)){
                // the message that is being returned from the error
                die('Error in query',mysqli_connect_error());
            }
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
}else{
    console_log('02112000');
    /*
         $sql = "INSERT INTO SESSIONS (session, facebook_id, time_millisecond) VALUES ('$session','',0)";
               if(!mysqli_query($GLOBALS['con'],$sql)){

                   die("Error in query: ".mysqli_error($con));
                   }else{
                       $result[] = array(
                           'data' => $session

                       );
                       echo json_encode($result);


                   }
                   */
}
