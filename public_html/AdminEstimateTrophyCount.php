<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=charset=iso-8859-1">
<meta name=Generator content="text/html; charset=iso-8859-1">
<title>FestivalWare Estimate Trophy Counts</title>
</head>

<body lang=EN-US bgcolor="#91F4FF">
<?php include('../php/TableStart.php'); ?>
<!-- main page area here -->

<font face="Agency FB, Inkpen2 Special, fantasy, cursive" size="+3">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// get all students that are registered this year
	// History table contains all records for all students, including ensembles
	$sql = "SELECT RegisteredStudents.StudentID, EventName, Sum(Points) As Total";
	$sql .= " FROM RegisteredStudents, History, Events";
	$sql .= " WHERE RegisteredStudents.StudentID = History.StudentID";
	$sql .= " AND Events.EventID = History.EventID";
	$sql .= " GROUP BY History.StudentID, History.EventID";
	$sql .= " HAVING Sum( Points ) = 10 OR Sum( Points ) = 25";
	$studentResult = mysql_query($sql, $selconn) or die(mysql_error());

	print "you have approximately " . mysql_num_rows($studentResult) . " trophies to buy, if all the students get 5s!";
?>
<p align="center">
<input type="button" name="btnBack" value="Back to Administration" onClick="location='Administration.php'">
</p>
</font>
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
