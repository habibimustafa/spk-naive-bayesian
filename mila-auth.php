<?php
session_start();
if(isset($_POST['email']) && isset($_POST['password']))
{
	include "db.php";
	$mail	= strtolower($_POST['email']);
	$pass	= md5($_POST['password']);
	$sql	= "select * from mila_users where USER_KEY = '$pass' and USER_MAIL = '$mail'";
	$qry	= mysqli_query($con, $sql);
	if($qry && mysqli_num_rows($qry) > 0){
		$mila=mysqli_fetch_array($qry);
		$_SESSION['mila_user_id'] 	= $mila['USER_ID'];
		$_SESSION['mila_user_name'] = $mila['USER_NAME'];
		$_SESSION['mila_user_mail'] = $mila['USER_MAIL'];
		$_SESSION['mila_user_pass'] = $mila['USER_KEY'];
		echo 1;
	}else{
		echo 0;
	}
}
