<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=charset=iso-8859-1">
<meta name=Generator content="text/html; charset=iso-8859-1">
<title>FestivalWare Festival Statistics</title>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:large; }
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:medium;}
body  {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: medium; font-color:black }
th {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: medium; font-color:blue; font-style:bold}
tr {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: medium;}
td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: medium;}
-->
</style>
</head>

<body>
<?php include('../php/TableStart.php'); ?>
<!-- main page area here -->

<h1>FestivalWare 2004 Class Participation Statistics</h1>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	
	$sql = "SELECT EventName, ClassDescription, Count( History.ClassID ) AS Quantity 
			FROM History, Classes, Events
			WHERE History.EventID = Events.EventID 
			AND History.ClassID = Classes.ClassID 
			AND History.Year=2004
			AND History.Points != 0
			GROUP BY History.EventID, History.ClassID
			ORDER BY EventName, History.ClassID";
	$classResult = mysql_query($sql, $selconn) or die(mysql_error());
	
	$sql = "SELECT ClassDescription, Count( MusicianshipHistory.ClassID ) AS Quantity 
			FROM MusicianshipHistory, Classes
			WHERE MusicianshipHistory.ClassID = Classes.ClassID
			AND MusicianshipHistory.Year=2004
			AND MusicianshipHistory.Points != 0
			GROUP BY MusicianshipHistory.ClassID
			ORDER BY MusicianshipHistory.ClassID";
	$musicResult = mysql_query($sql, $selconn) or die(mysql_error());
	
	echo "<table border=\"1px\"><tr><th>Event Name</th><th>Class Description</th><th align=\"center\">Count</th></tr>";
	while($row = mysql_fetch_array($classResult))
	{
		echo"<tr><td>$row[EventName]</td><td>$row[ClassDescription]</td><td align=\"center\">$row[Quantity]</td></tr>";
	}
	while ($row = mysql_fetch_array($musicResult))
	{
		echo "<tr><td>Musicianship Theory</td><td>$row[ClassDescription]</td><td align=\"center\">$row[Quantity]</td></tr>";
	}
	
	echo "</table>";
?>
<?php include('../php/TableEnd.php'); ?>

</body>
</html>
