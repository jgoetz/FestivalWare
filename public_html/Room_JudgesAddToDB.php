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
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// sanitize the POST strings
	$roomID = $_POST['reqSelRoom'];
	$startTime = $_POST['reqSelStartHour'] . ":" . $_POST['reqSelStartMins'] . ":00";
	$endTime = $_POST['reqSelEndHour'] . ":" . $_POST['reqSelEndMins'] . ":00";


// lookup the judging levels assigned for this room/time period,
// and ensure this judge can handle that level
	$sql = "SELECT * FROM RoomUse WHERE FestivalID=$festivalID AND RoomID=$roomID AND 
			StartTime <= '$startTime' AND EndTime >= '$endTime'";
	$useResult = mysql_query($sql, $selconn) or die(mysql_error());
	$useRow = mysql_fetch_array($useResult); // can't be more than one!
	
	$sql = "SELECT * FROM Studios WHERE StudioID = '$_POST[reqSelStudio]'";
	$studioResult = mysql_query($sql, $selconn) or die(mysql_error());
	$studioRow = mysql_fetch_array($studioResult); // better be only one here, too
	
	// if studios level doesn't fall into range given by room, print error and return to setup page
	
	// ***************** pause here, go and fix the studio registration page with skilllevels!!!!
	// need min & max skill levels for each studio. Get rid of the hard-coded list of skill levels
	
	
	$useResult = mysql_query($sql, $selconn) or die(mysql_error());
	$useRow = mysql_fetch_array($useResult); // can't be more than one!
	
	// build the string
	$sql = "insert into RoomJudge values (
						'',  
						'$festivalID', 
						'" . $_POST['reqSelRoom'] . "', 
						'$startTime',
						'$endTime', 
						'" . $_POST['reqSelStudio'] .  "')";
						
$result = mysql_query($sql, $addconn) or die(mysql_error());
	mysql_close($addconn);

	header("Location: Room_BreaksMain.php");
?>
