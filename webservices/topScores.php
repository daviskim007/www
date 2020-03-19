<?php
/* Create a new web service which will give us all the high score from the players table.
   This web service will not be taking any parameters because everything will be accessed publicly.
   No need for it to retrieve session from the main.js file and we can start writing our SQL statement right away.
*/

include "connection.php";

// What we need in PLAYERS table will be the name , the surname , the high score display and the Facebook_id
$sql_score = ("Select name, surname, highscore_display, Facebook_id FROM PLAYERS ORDER BY highscore_milli ASC LIMIT 25");
$sql_result = mysqli_query($con, $sql_score);
// Have the rank of each user. Create a variable and put it as one to start with and in a while loop we can just send

$rank = 1;

while ($row = mysqli_fetch_assoc($sql_result)) {
    //send the result as an object
    $profile_picture = "https://graph.facebook.com/".$row['Facebook_id'].'/picture';
    $fullname = $row['name']." ".$row['surname'];
    $result[] = array(
        // in the array that we're returning we will have the rank
        'rank' => $rank,
        // will have user picture
        'userPic' => $profile_picture,
        // return the contact name
        'fullname' => $fullname,
        // display the time that the user has spent on the game
        'time' => $row['highscore_display']
    );

    $rank = $rank+1;

}

echo json_encode($result);
