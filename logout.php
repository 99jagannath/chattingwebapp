<?php
include('db.php');
session_start();
$q = "update user set status = '0' where user_name = :user_name";
           $s = $db->prepare($q);
           $s->execute(

         array(
            ':user_name' => $_SESSION['user_name']
           )
     );
session_destroy();
header('location:login.php');

?>