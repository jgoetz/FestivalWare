<?php include("IsAuth_Admin.php");
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/
	session_start();	
	$database = $_SESSION['DatabaseName'];				
	$delconn = mysql_connect ( "localhost","festival_deleter","by34wyb") or die(mysql_error()); 
	mysql_select_db($database, $delconn) or die(mysql_error());
	
	// get the POST data and sanitize it
	$roomID = $_POST['hdnRoomID'];
	$festivalID = $_SESSION['FestivalID'];
	$roomDescr = $_POST['txtRoomDescription'];

	$sql = "DELETE FROM Festival_Rooms WHERE FestivalID='$festivalID' AND RoomID='$roomID'";

	$result = mysql_query ($sql, $delconn) or die(mysql_error());
	mysql_close($delconn);
				
	header("Location: RoomAdmin.php");
?>