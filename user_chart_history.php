<?php
include('db.php');
 $to_user_id = $_POST['to_user_id'];
 $from_user_id = $_POST['from_user_id'];
 $query = "SELECT * FROM chart_message WHERE (to_user_id = '$to_user_id' OR to_user_id = '$from_user_id') AND (from_user_id = '$to_user_id' OR from_user_id = '$from_user_id') ";
 $stmp = $db->prepare($query);
 $stmp->execute();
 $result = $stmp->fetchAll();
 $output = '';
 $output .='<div class="row"><table>';
 foreach($result as $data)
 {
 	
 	if($data['to_user_id']==$to_user_id)
 	{
 		$output .='<div class="row" style="margin-right:5px; margin-left:20%; text-align:right; background-color:#98FB98; max-width: 80%;margin-bottom:10px;right:0;   " >
	<h4>'.$data['chart_message'].'</h4>
   		<p>'.$data['timestamp'].'</p>
</div>';
 		 
 	}
 	else
 	{
 		$output .='<div class="row" style="margin-left:7px; text-align:left; background-color: #FFC0CB; max-width: 80%;margin-bottom:10px;left:0;  " >
	     <h4>'.$data['chart_message'].'</h4>
   		<p>'.$data['timestamp'].'</p>
</div>'; 
 	}

  
 }
 $output .='</table></div>';


 echo $output;

?>
<p style="background-color: white; max-height: 80%;left:0;"></p>

