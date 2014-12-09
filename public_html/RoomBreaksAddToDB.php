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


	// now get the post data; note that only checked checkboxes will be POSTed
	// sanitize the POST strings
	$roomDescription = $_POST['txtRoomDescr'];

	// build the string
	$sql = "INSERT INTO Festival_Rooms VALUES ('', '$festivalID', '$roomDescription')";
	$result = mysql_query($sql, $addconn) or die(mysql_error());
	mysql_close($addconn);

	header("Location: RoomAdmin.php");
?>
