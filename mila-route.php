<?php 
/* no direct access */ 
// (isset($_SESSION['mila_user_mail']) || isset($_SESSION['mila_user_pass'])) or die ( 'Restricted access' );

if(isset($_POST['target'])){
	$target = strtolower(trim($_POST['target']));
	$target = str_replace(".","",$target);
	$target = str_replace(" ","-",$target);
	$view 	= (isset($_POST['view']))?$_POST['view']:null;
	$id 	= (isset($_POST['id']))?$_POST['id']:null;
	
	include "functions.php";
	// include "phplatex.php";
	// include "Tex2png.php";
	if(isset($target) && file_exists("page-".$target.".php")){
		include "db.php";
		include "page-".$target.".php";
	}else{
		echo "<h2>Page Not Found!</h2>page-".$target.".php";
	}
}