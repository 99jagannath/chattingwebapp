
<?php
$message = "";
 include('db.php');
 session_start();
 if(isset($_SESSION['user_name']))
 	header('location:index.php');
 if(isset($_POST['login']))
 {
 	$query = "select * from user where user_name = :user_name";
 	$stmt = $db->prepare($query);
 	$stmt->execute(

    array(
      ':user_name' => $_POST['user_name']
    )
 	);
 	$row = $stmt->rowCount();
 	if($row>0)
 	{
 		$result= $stmt->fetch();
 		
 		if($result['user_name']==$_POST['user_name'])
 		{
 			if($result['user_password']==$_POST['user_password'])
 			{
              $_SESSION['user_name'] = $_POST['user_name'];
 		      $_SESSION['user_id'] = $result['user_id'];
            $q = "update user set status = '1' where user_name = :user_name";
           $s = $db->prepare($q);
           $s->execute(

         array(
            ':user_name' => $_POST['user_name']
           )
          );
           
             header('location:index.php');
 			}
 			else
 			{
 				$message = 'invalid password';
 			}
 		}
 		else
 		{
 			$message = 'invalid username';
 		} 
 	}
 	else
 	{
 		$message = 'invalid username';
 		header('location:login.php');
 	}
 }
 		
?>

<!DOCTYPE html>
<html>
<head>
	<title>whatsup nitr</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
 <div class="container">
 	<br/>
 	<h1 style="text-align: center">NITR WHATSUP</h1>
 	<div class="panel panel-default">
 		<br/>
 		<div class="panel panel-heading">
 			<br/>
 			 <h2 style="text-align: center;">login to your account</h2>
 		</div>
 		<div class="panel panel-body" align="center">
 			<form method="post" class="form">
 				<p class="text-danger"><?=$message?></p>
 				<div class="form-group" >
 					<label>username</label>
 					<input type="text" name="user_name" placeholder="Enter your username" class="forrm-control" required="true">
 				</div>
 				
 				<div class="form-group">
 					<label>password</label>
 					<input type="password" name="user_password" placeholder="Enter your password" class="forrm-control" required="true">
 				</div>
 				<div class="form-group">
 					<input type="reset" value="reset" class="btn btn-default">
 					<input type="submit" value="login" class="btn btn-primary" name="login">
 				</div>
 			</form>
 		</div>
 	</div>
 </div>
</body>
</html>