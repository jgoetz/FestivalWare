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
	$useID = $_POST['hdnRoomUseID'];
	$festivalID = $_SESSION['FestivalID'];

	$sql = "DELETE FROM RoomUse WHERE RoomUseID='$useID'";

	$result = mysql_query ($sql, $delconn) or die(mysql_error());
	mysql_close($delconn);
				
	header("Location: Room_UseMain.php");
?>