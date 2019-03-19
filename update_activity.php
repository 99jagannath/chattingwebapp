<?php
include('db.php');
session_start();
$user_id = $_SESSION['user_id'];
date_default_timezone_set('Asia/Calcutta');
$last_activity = date('d:m:y h:i:s A');
$query = "SELECT * FROM login_details WHERE user_id = '$user_id'";
$stmt = $db->prepare($query);
$stmt->execute();
if($stmt->rowCount() >0)
{
  $query1 = "UPDATE login_details SET last_activity = '$last_activity' WHERE user_id = '$user_id'";
}
else
{
	$query1 = "INSERT INTO login_details (user_id,last_activity) VALUES ('$user_id','$last_activity')"; 
}
$stmt1 = $db->prepare($query1);
$stmt1->execute();
?>
