<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
<title>FestivalWare Demo Festival Admin: Print Room Schedule</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
<style type="text/css">
<!--
body  {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #ffffff}
h1    {font-family: arial, helvetica, geneva, sans-serif; font-size: large; font-weight: bold}
table {border-width:1px; border-color:#000000; border-style:solid; border-collapse:collapse; border-spacing:0; page-break-after: always}
th    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; font-weight: bold; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}
td    {font-family: arial, helvetica, geneva, sans-serif; font-size: large; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}
//-->
</style>
</head>

<script src="RollOvers.js"></script>

<?php

	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// get the rooms
	// for each room 
	// 	  create new table 
	//    print title & rooms.description
	//    for each time slot
	//		 read history, student & performance data
	// 		 print time
	//		 print student
	//		 print performance type and class
	//		 print newlinw

	$sql = "SELECT * FROM Rooms;";
	$roomsResult = mysql_query($sql, $selconn) or die(mysql_error());
	
	while ($row = mysql_fetch_array($roomsResult))
	{
		echo "<h3 align=\"left\">Student Schedule for Room " . $row['RoomDescription'] . "</h3>";
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
		echo "<tr><th>Start Time</th><th>Student Name</th><th>Event</th><th>Class</th><tr>";
		$sql = "Select * FROM RoomTimePerformance WHERE RoomID = " . $row['RoomID'] . " ORDER BY StartTime";

		$perfList = mysql_query($sql, $selconn) or die(mysql_error());
	
		while ($currPerf = mysql_fetch_array($perfList))
		{
			$starttime =  $currPerf['StartTime'];
			// convert to standard time
			
			// if it's a solo
			if($currPerf['Type'] == 'S')
			{
				$sql = "Select StudentFirstName, StudentLastName,  EventName, ClassDescription ";
				$sql .= " FROM History, Students, Events, Classes";
				$sql .= " WHERE HistoryID=" . $currPerf['HistoryID'];
				$sql .= " AND History.EventID=Events.EventID AND History.ClassID=Classes.ClassID AND ";
				$sql .= " History.StudentID=Students.StudentID";
				$histResult = mysql_query($sql, $selconn) or die(mysql_error());
				
				$dataRow = mysql_fetch_array($histResult);
				echo "<tr><td>" . $starttime . "</td>";
				echo "<td>" . $dataRow['StudentLastName'] . ", " . $dataRow['StudentFirstName'] . "</td>";
				echo "<td>" . $dataRow['EventName'] . "</td>";
				echo "<td>" . $dataRow['ClassDescription'] . "</td><tr>";
			}
			elseif($currPerf['Type'] == 'E')
			{
				$sql = "Select Student1ID, Student2ID, Student3ID, Student4ID, EventName, ClassDescription ";
				$sql .= " FROM EnsembleHistory, Events, Classes";
				$sql .= " WHERE EnsembleID=" . $currPerf['HistoryID'];
				$sql .= " AND EnsembleHistory.EventID=Events.EventID AND EnsembleHistory.ClassID=Classes.ClassID";
				$ensembleResult = mysql_query($sql, $selconn) or die(mysql_error());
				
				$dataRow = mysql_fetch_array($ensembleResult);
				$student = array(1 => $dataRow['Student1ID'], 2 => $dataRow['Student2ID'], 3 => $dataRow['Student3ID'], 4 => $dataRow['Student4ID']);
				$names = "";
				for($i = 1; $i <= 4; $i++)
				{
					if($student[$i] != NULL)
					{
						$sql = "SELECT * FROM Students WHERE StudentID = $student[$i]";
						$resStudent = mysql_query($sql, $selconn) or die(mysql_error());
						$studentInfo = mysql_fetch_array($resStudent);
						if ($names != "")
							$names .= "<br>";
						$names .= $studentInfo['StudentLastName'] . ", " . $studentInfo['StudentFirstName'];
					}
				}
				
				echo "<tr><td>" . $starttime . "</td>";
				echo "<td>" . $names . "</td>";
				echo "<td>" . $dataRow['EventName'] . "</td>";
				echo "<td>" . $dataRow['ClassDescription'] . "</td><tr>";
			}
			// no else; we just skip musicianship
		} // end while for each timeslot for this room
		echo "</table>";	// can I force a page break here? It would be nice!
	} // end while for each room
	
?>



<p><input name="btnBackToAdmin" type="button" value="Back to Administration" onClick="location='Administration.php'"></p>

<p>&nbsp;</p>
<p><font size="1" face="Arial">Copyright 2003-2004 FestivalWare</font></p></td>

<script type="text/javascript" language="javascript1.2">
<!--
if (typeof(window.print) != 'undefined') {
    window.print();
}
//-->
</script>
</body>


</html>
