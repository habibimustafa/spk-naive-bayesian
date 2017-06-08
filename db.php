<?php
// Connect to Database
define('DB_NAME', 'beasiswa');	// Nama basis data.
define('DB_USER', 'root');		// Nama pengguna
define('DB_PASS', '');	// Kata sandi
define('DB_HOST', 'localhost');	// Nama host
$con=@mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
if(!$con) die ("Fail in Connecting to Database.");
//mysql_select_db(DB_NAME) or die ("Database Not Found.");
