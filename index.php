<?php
session_start();
if(!isset($_SESSION['user_name']))
{
	header('location:login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>whatsup nitr</title>

  <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
  	
  <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
</head>
<body>
 <div class="container">
 	<br/>
 	<h1 style="text-align: center">NITR WHATSUP</h1>
 	<div class="panel panel-default">
 		<br/>
 		<div class="panel panel-heading">
 			<br/>
 			 <h2 style="text-align: center;">wellcome <?=$_SESSION['user_name']; ?></h2>
 		</div>
 		<div class="panel panel-body" align="center">
 			<p style="text-align: center;">
 			<a href="logout.php" class="btn btn-success pull-right">logout</a></p>
 			<br />
 			<div class="table-responsive">
 				<h4 align="center">Online User</h4>
 				<br/>
 				<div class="container" id='user_details'></div>
 			  </div>
        <div id="user_model_details">
          
        </div>
 		</div>
 	</div>
 </div>
</body>
<script type="text/javascript">
	$(document).ready(function(){
		alert('hii');
      fetch_user();
		 setInterval(function(){
     update_activity();
  fetch_user();
  update_chat_history_data();
 }, 900);
		

 function fetch_user()
 {
  $.ajax({
   url:"fetch_users.php",
   method:"POST",
   success:function(data){
    $('#user_details').html(data);
   }
  })
 }
 
 function make_chat_dialog_box(to_user_id,to_user_name)
 {
  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
  modal_content +='<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px; backgroung-color:#FFEFD5;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += fetch_user_chat_history(to_user_id);
  modal_content +='</div>';
  modal_content +='<div class="form-group">';
  modal_content +='<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chart_message" data-touserid="'+to_user_id+'">';
  modal_content +='</textarea>';
  modal_content +='</div>';
  modal_content +='<div class="form-group" align="right">';
  modal_content +='<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat" data-touserid="'+to_user_id+'" data-tousername="'+to_user_name+'" >Send</button>';
  modal_content +='</div>';
  modal_content +='</div>'; 
  $('#user_model_details').html(modal_content);
 }


   $(document).on('click', '.start_chat', function(){
  
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  
  make_chat_dialog_box(to_user_id, to_user_name);
  $("#user_dialog_"+to_user_id).dialog({
   autoOpen:false,
   width:400
  });
  $('#user_dialog_'+to_user_id).dialog('open');
 
  $(document).on('focusin', '.chart_message', function(){
 
     $('#type_notify_'+to_user_id).html("typing....");
   });
  $(document).on('focusout', '.chart_message', function(){
    
   }); 

 });




    $(document).on('click', '.send_chat', function(){
  
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  
   var from_user_id = '<?=$_SESSION['user_id']; ?>';
  var from_user_name = '<?=$_SESSION['user_name']; ?>';
  <?php
    date_default_timezone_set('Asia/Calcutta');
 
  ?>
  var time = '<?= date('d:m:y h:i:s A');?>';

  var message = $('#chat_message_'+to_user_id).val();

 
  
  $.ajax({
     type:'POST',
     url:'chat_insert.php',
     data:{'to_user_id':to_user_id,'from_user_id':from_user_id,'timestamp':time,'chart_message':message},
     success:function(data){
    
     }

  });
  
 

 });

    function fetch_user_chat_history(user_id)
    {
       var from_user_id = '<?=$_SESSION['user_id']; ?>';
       var to_user_id = user_id;
       $.ajax({
        type:'POST',
        url:'user_chart_history.php',
        data:{'from_user_id':from_user_id,'to_user_id':user_id},
        success:function(data)
        {
          $('#chat_history_'+to_user_id).html(data);
        }
       });
    } 
function update_chat_history_data()
   {
  $('.chat_history').each(function(){
   var to_user_id = $(this).data('touserid');
   fetch_user_chat_history(to_user_id);
  });
 }
 function update_activity()
 {
  $.ajax({
    type:'POST',
    url:'update_activity.php',
    success:function(data)
    {
      
    }
  });
 }

	});
</script>
</html>