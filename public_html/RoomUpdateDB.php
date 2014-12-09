<?php include("IsAuth_Admin.php");
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/
	session_start();	
	$database = $_SESSION['DatabaseName'];				
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());
	
	// get the POST data and sanitize it
	$roomID = $_POST['hdnRoomID'];
	$festivalID = $_SESSION['FestivalID'];
	$roomDescr = $_POST['txtRoomDescription'];

	$sql = "Update Festival_Rooms SET RoomDescription = '$roomDescr' WHERE FestivalID='$festivalID' AND RoomID='$roomID'";

	$result = mysql_query ($sql, $updateconn) or die(mysql_error());
	mysql_close($updateconn);
				
	header("Location: RoomAdmin.php");
?>