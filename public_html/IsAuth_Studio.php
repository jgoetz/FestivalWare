<?php
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/

	session_start();	
	$loginScript = "http://www.festivalware.net/index.php";
	$notAuthenticated = ! (isset($_SESSION['AuthenticatedUser']) && ($_SESSION['AuthorizationType'] == "Studio") );
	$notLoginIP = isset($_SESSION["AuthUserIPAddress"]) &&
					($_SESSION["AuthUserIPAddress"] != $_SERVER['REMOTE_ADDR']);
	
	if($notAuthenticated)
	{
		$_SESSION['LoginMessage'] = "You have not been authorized to access " . 
			$_SERVER['REQUEST_URI'] . "<br>Please log in...";
		header("Location: " . $loginScript); 
		exit;
	}
	else if ($notLoginIP)
	{
		$_SESSION['LoginMessage'] = "You have not been authorized to access " . 
			$_SERVER['REQUEST_URI'] . " from " . $_SERVER['REMOTE_ADDR']
			. "<br>Please log in...";
		header("location: " . $loginScript);
		exit;
	}
 ?>
