<?php
	session_start();
	// unset($_SESSION['arraysrc']);
	// $_COOKIE = array();
	session_unset();
	session_destroy();  
?>