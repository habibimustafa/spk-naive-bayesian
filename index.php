<?php
session_start();	/** Memulai Session. */ 
define('MILA', 'Ayu Milati Nur Azizah');

// Connect to Database
include "db.php";

if(!isset($_SESSION['mila_user_mail']) || !isset($_SESSION['mila_user_pass'])) 
{ 
	if(!isset($_GET["login"])){
		include "mila-user.php";
	}else{
		include "mila-login.php";
	}
} else { 
	if(!isset($_GET["logout"])){
		include "mila-dashboard.php";
	}else{
		include "mila-logout.php";
	}
}