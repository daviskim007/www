<?php



include "connection.php";

$millisec = $_POS['millisec'];
$session = $_POST['session'];
$time = $_POST['time'];


$sql = "UPDATE SESSIONS SET time_millisecond = '$millisec', time_display = '$time' WHERE session = '$session'";
    if(!mysqli_query($GLOBALS['con'],$sql)){

        die("Error in query: ".mysqli_error($con));
        }
    else{

       /*
                $result[] = array(
                'data' => $session

            );
            echo json_encode($result);


        */
    }