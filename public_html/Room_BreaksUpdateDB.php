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
	$breakID = $_POST['hdnBreakID'];
	$festivalID = $_SESSION['FestivalID'];
	$breakDescr = $_POST['txtBreakDescr'];
	$startTime = $_POST['reqSelStartHour'] . ":" .  $_POST['reqSelStartMins'] . ":00";
	$endTime = $_POST['reqSelEndHour'] . ":" .  $_POST['reqSelEndMins'] . ":00";
	
	$sql = "Update RoomBreaks SET BreakDescription = '$breakDescr', 
			StartTime = '$startTime', EndTime ='$endTime' 
			WHERE RoomBreakID='$breakID'";

	$result = mysql_query ($sql, $updateconn) or die(mysql_error());
	mysql_close($updateconn);
				
	header("Location: Room_BreaksMain.php");
?>