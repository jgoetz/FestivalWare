<?php include("IsAuth_Admin.php");
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/

	session_start();	
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];
	
	$delconn = mysql_connect ( "localhost","festival_deleter","by34wyb") or die(mysql_error()); 
	mysql_select_db($database, $delconn) or die(mysql_error());
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());

	// first erase all existing event entries for this festival
	$sql = "DELETE FROM Festival_Events WHERE FestivalID='$festivalID'";
	$result = mysql_query($sql, $delconn) or die(mysql_error());
	
	// now get the post data; note that only checked checkboxes will be POSTed
	$eventString = "";
	$events=$_POST['chkBox'];
	foreach ($events as $key => $value )
	{
		// sanitize the value strings; ignore the key strings
		
		// build the event string
		if($eventString == "")
			$eventString = "($festivalID, $value)";
		else
			$eventString .= ",($festivalID, $value)";
	}
	$sql = "INSERT INTO Festival_Events VALUES $eventString";
	$result = mysql_query($sql, $addconn) or die(mysql_error());

	header("Location: Administration.php");

?>
