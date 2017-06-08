<?php
	//periksa apakah user telah login atau memiliki session 
	if(!isset($_SESSION['mila_user_mail']) || !isset($_SESSION['mila_user_pass']))
	{
		?><script>location.href='./';</script><?php
	}
	else
	{
		unset($_SESSION);
		session_destroy();
		?><script>location.href='./';</script><?php
	}