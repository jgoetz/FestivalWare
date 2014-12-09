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
	$roomDescription = $_POST['txtRoomDescr'];
	$startTime = $_POST['reqSelStartHour'] . ":" . $_POST['reqSelStartMins'] . ":00";
	$endTime = $_POST['reqSelEndHour'] . ":" . $_POST['reqSelEndMins'] . ":00";

	// build the string
	$sql = "insert into RoomBreaks values (
						'',  
						'$festivalID', 
						'" . $_POST['reqSelRoom'] . "', 
						'$startTime',
						'$endTime', 
						'" . $_POST['txtBreakDescr'] .  "')";
						
$result = mysql_query($sql, $addconn) or die(mysql_error());
	mysql_close($addconn);

	header("Location: Room_BreaksMain.php");
?>
