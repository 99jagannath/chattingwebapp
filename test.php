<?php
include('db.php');
$query1 = "SELECT * FROM login_details WHERE user_id = '1' ";
$stmt1 = $db->prepare($query1);
$stmt1->execute();
 	$result1 = $stmt1->fetchAll();
 	echo "<pre>";
 	print_r($result1);
 	foreach ($result1 as $key ) {
 		$last_activity = $key['last_activity'];
 	}
 	date_default_timezone_set('Asia/Calcutta');
 	$time =  date('d:m:y h:i:s A');
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
    	echo "offline";
    }
    else
    {
    	echo "online";
    }
    }
    elseif($date1<$date2)
    {
    	echo "offline";
    }
   


?>
<!DOCTYPE html>
<html>
<head>
	<title>fgf</title>
</head>
<body>
<div class="form-group">
	<textarea class="form-control"></textarea>
</div>
</body>
</html>