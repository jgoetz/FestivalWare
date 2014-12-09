<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=charset=iso-8859-1">
<meta name=Generator content="text/html; charset=iso-8859-1">
<title>FestivalWare Demo Festival Administration: Print Trophy Points Schedule</title>
</head>

<body lang=EN-US bgcolor="#FFFFFF">

<h1>Student Trophy Points Table</h1>
<p>&nbsp;</p>

<input type="button" name="btnBack" value="Back to Administration" onClick="location='Administration.php'">
<p>&nbsp;</p>

<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT StudentFirstName, StudentLastName, 
	StudentStudioID AS StID, StudioFirstName, StudioLastName, 
	EventName, Sum( Points ) AS Total, EastOrWest
	FROM RegisteredStudents, History, Students, Events, Studios
	WHERE RegisteredStudents.StudentID = History.StudentID 
	AND StudentStudioID=Studios.StudioID
	AND History.StudentID = Students.StudentID 
	AND History.EventID = Events.EventID 
	GROUP BY History.StudentID, History.EventID ORDER BY EastOrWest, StID, Total";
	$studentResult = mysql_query($sql, $selconn) or die(mysql_error());

	print "<table border=\"1px\" cellpadding=\"2\">";
	print "<tr><th>First Name</th><th>Last Name</th><th>Event Name</th><th>Points</th><th>Studio Owner</th><th>East or West?</th></tr>";
	while($row = mysql_fetch_array($studentResult))
	{	
		$temp = $row['Total'];
		if( ($temp == 45) || ($temp== 30) || ($temp==15) )
		{
			print "<tr><td>$row[StudentFirstName]</td> <td>$row[StudentLastName]</td> <td> $row[EventName]</td> <td align=\"center\">$temp</td><td>$row[StudioFirstName] $row[StudioLastName]</td><td align=\"center\">$row[EastOrWest]</td></tr>";
		}
	}
	print "</table>";
?>
<p>&nbsp;</p>

</body>
</html>
