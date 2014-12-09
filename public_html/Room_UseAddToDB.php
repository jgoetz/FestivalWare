<?php include("IsAuth_Admin.php");
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/

	session_start();	
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];
				
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());

	// sanitize the POST strings
	$startTime = $_POST['reqSelStartHour'] . ":" . $_POST['reqSelStartMins'] . ":00";
	$endTime = $_POST['reqSelEndHour'] . ":" . $_POST['reqSelEndMins'] . ":00";
	$roomID = $_POST['reqSelRoom'];
	$minSkill = $_POST['reqSelMinSkill'];
	$maxSkill = $_POST['reqSelMaxSkill'];
	$useDescription = $_POST['txtUseDescr'];
	// build the string
	$sql = "insert into RoomUse values (
						'',  
						'$festivalID', 
						'$roomID', 
						'$startTime',
						'$endTime', 
						'$minSkill',
						'$maxSkill',
						'$useDescription')";
						
$result = mysql_query($sql, $addconn) or die(mysql_error());
	mysql_close($addconn);

	header("Location: Room_UseMain.php");
?>
