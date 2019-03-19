<?php
session_start();
if(!isset($_SESSION['user_name']))
{
	header('location:login.php');
}
include('db.php');
$query = "SELECT * FROM user WHERE user_name != '".$_SESSION['user_name']."' ";

$stmt = $db->prepare($query);

$stmt->execute();
 	$result = $stmt->fetchAll();
 	
 	$output = '<table class="table table-bordered table-striped">
 <tr>
  <td>Username</td>
  <td>Status</td>
  <td>Action</td>
 </tr>
';
date_default_timezone_set('Asia/Calcutta');
 	$time =  date('d:m:y h:i:s A');
foreach($result as $row)
{
	
$query1 = "SELECT * FROM login_details WHERE user_id = '".$row['user_id']."' ";
$stmt1 = $db->prepare($query1);
$stmt1->execute();
 	$result1 = $stmt1->fetchAll();
 	if($stmt1->rowCount())
 	{
 	      foreach ($result1 as $key ) {
 	 $last_activity = $key['last_activity'];
 	}

 	
 	$last_activity_array = explode(' ', $last_activity);
 	$time_array = explode(' ',$time);
 	
   $last_activity_array_part = explode(':', $last_activity_array['1']);
   $time_array_part = explode(':', $time_array['1']);
   if($last_activity_array['2'] == 'PM' && $last_activity_array_part['0']!='12')
   {
    
    $last_activity_array_part['0'] = intval($last_activity_array_part['0'])+12;
   }
   if($time_array['2'] == 'PM' && $time_array_part['0']!='12')
   {
   	$time_array_part['0'] = intval($time_array_part['0'])+12;
   }
    $date1 = strtotime($last_activity_array['0']);
    $date2 = strtotime($time_array['0']);
    if($date1==$date2)
    {
      $last_activity_sec = (3600*intval($last_activity_array_part['0']))+(60*intval($last_activity_array_part['1']))+intval($last_activity_array_part['2'])+5;
    $time_sec = (3600*intval($time_array_part['0']))+(60*intval($time_array_part['1']))+intval($time_array_part['2']);	
    if($last_activity_sec<$time_sec)
    {
    	$status = '<button class="btn btn-danger btn-xs">offline</button>';
    }
    else
    {
    	$status = '<button class="btn btn-success btn-xs">online</button>';
    }
    }
    elseif($date1<$date2)
    {
    	$status = '<button class="btn btn-danger btn-xs">offline</button>';
    }	
 	}
 	else
 	{
 		$status = '<button class="btn btn-danger btn-xs">offline</button>';
 	}
 

	
	
 $output .= '
 <tr>
  <td>'.$row['user_name'].'</td>
  <td>'.$status.'&nbsp;&nbsp;&nbsp;<b class="type_notify_'.$row['user_id'].'"><b> </td>
  <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['user_name'].'" data-fromuserid="'.$_SESSION['user_id'].'" data-fromuser="'.$_SESSION['user_name'].'" data-time = "'.$time.'">Start Chat</button></td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;
?>
