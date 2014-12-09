<?php
/*
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/
	session_start();
	$_SESSION['LoginMessage'] = "$_SESSION[AuthUserName] has logged out";
	if ($_SESSION['AuthorizationType'] == "Studio")
	{
		unset($_SESSION['StudioName']);
		unset($_SESSION['StudioID']);
		unset($_SESSION['StudioEmail']);
	}
	elseif($_SESSION['AuthorizationType'] == "Admin")
	{
		unset($_SESSION['AdminJob']);
		unset($_SESSION['OrganizerID']);
	}
	unset($_SESSION['AuthorizationType']);
	unset($_SESSION['AuthenticatedUser']);
	unset($_SESSION['AuthUserIPAddress']);
	unset($_SESSION['AuthUserName']);
	unset($_SESSION['OrganizationID']);
	unset($_SESSION['DatabaseName']);
	unset($_SESSION['OrganizationName']);
	unset($_SESSION['AuthUserEmail']);

	session_write_close();	
	header("Location: http://www.festivalware.net/index.php");
	exit();

?>
	