<?php

include('db.php');
$to_user_id = $_POST['to_user_id'];
$from_user_id = $_POST['from_user_id'];
$timestamp = $_POST['timestamp'];
$chart_message = $_POST['chart_message'];
 $query = "INSERT INTO chart_message(to_user_id,from_user_id,chart_message,timestamp) VALUES ('".$to_user_id."','".$from_user_id."','".$chart_message."','".$timestamp."')";
 $smtp = $db->prepare($query);
 $result =  $smtp->execute();
// $result =  $smtp->execute(
//     array(

//     	':to_user_id' => $to_user_id, 
//          ':from_user_id' => $from_user_id,
//          ':chart_message' => $chart_message,
//          ':timestamp' => $timestamp


//          )

//  );
if($result)
{
	echo "success";
	

}
else
{
	echo "fail";
	
}

 
?>