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
	$useID = $_POST['hdnUseID'];
	$festivalID = $_SESSION['FestivalID'];
	$useDescr = $_POST['txtUseDescr'];
	$minLevel = $_POST['reqSelMinSkill'];
	$maxLevel = $_POST['reqSelMaxSkill'];
	$startTime = $_POST['reqSelStartHour'] . ":" .  $_POST['reqSelStartMins'] . ":00";
	$endTime = $_POST['reqSelEndHour'] . ":" .  $_POST['reqSelEndMins'] . ":00";
	
	$sql = "Update RoomUse SET UseDescription = '$useDescr', MinSkill = '$minLevel', MaxSkill ='$maxLevel',
			StartTime = '$startTime', EndTime ='$endTime' 
			WHERE RoomUseID='$useID'";

	$result = mysql_query ($sql, $updateconn) or die(mysql_error());
	mysql_close($updateconn);
				
	header("Location: Room_UseMain.php");
?>