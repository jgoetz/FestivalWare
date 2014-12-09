<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
<title>FestivalWare Demo Festival Admin: Print Schedule by Studio</title>
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
table {border-width:1px; border-color:#000000; border-style:solid; border-collapse:collapse; border-spacing:0}
th    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; font-weight: bold; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}
td    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}
span  {page-break-after: always}
//-->
</style>
</head>

<script src="RollOvers.js"></script>

<?php

	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// select all studios that have students currently enrolled
	$sql = "Select * FROM Studios ORDER BY StudioLastName";
	$studioResult = mysql_query($sql, $selconn) or die(mysql_error());
	
	while ($studioRow = mysql_fetch_array($studioResult))
	{
		$studioID = $studioRow['StudioID'];
		$sql = "SELECT StartTime, RoomDescription, StudentFirstName, StudentLastName, EventName, ClassDescription";
		$sql .= " FROM RoomTimePerformance, Rooms, History, Students, Events, Classes ";
		$sql .= " WHERE History.HistoryID = RoomTimePerformance.HistoryID AND Type='S' ";
		$sql .= " AND Rooms.RoomID = RoomTimePerformance.RoomID ";
		$sql .= " AND History.StudioID=$studioID";
		$sql .= " AND History.StudentID = Students.StudentID ";
		$sql .= " AND History.EventID = Events.EventID ";
		$sql .= " AND History.ClassID = Classes.ClassID ";
		$sql .= " ORDER BY StudentLastName";

		$soloResult = mysql_query($sql, $selconn) or die(mysql_error());
		
		// ????????  for future reference, how can we get these records in order of student last name?
		$sql = "SELECT DISTINCT *";
		$sql .= " FROM RoomTimePerformance, EnsembleHistory";
		$sql .= " WHERE EnsembleID=RoomTimePerformance.HistoryID";
		$sql .= " AND ( (Studio1ID=$studioID) OR (Studio2ID=$studioID) OR (Studio3ID=$studioID) OR (Studio4ID=$studioID))";

		$ensembleResult = mysql_query($sql, $selconn) or die(mysql_error());

		if( (mysql_num_rows($soloResult) != 0) || (mysql_num_rows($ensembleResult) != 0) )
		{
			echo "<span>"; //start the span thingy here
		}
		
		if (mysql_num_rows($soloResult) != 0)
		{
			echo "<h3 align=\"left\">Student Solos Schedule for " . $studioRow['StudioFirstName'] . " " . $studioRow['StudioLastName'] . "</h3>";
			echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
			echo "<tr><th>Student Name</th><th>Start Time</th><th>Room Number</th><th>Event</th><th>Class</th><tr>";
			while ($studentRow = mysql_fetch_array($soloResult))
			{
				$starttime = $studentRow['StartTime'];
				// convert to normal time from military time
				
				echo "<tr><td>" . $studentRow['StudentFirstName'] . " " . $studentRow['StudentLastName'] . "</td>";
				echo "<td>" . $starttime . "</td>";
				echo "<td>" . $studentRow['RoomDescription'] . "</td>";
				echo "<td>" . $studentRow['EventName'] . "</td>";
				echo "<td>" . $studentRow['ClassDescription'] . "</td><tr>";
			} // end while each solo
			echo "</table>"; // don't force page break yet... may have ensemble data
		} // end if number of solo rows is not zero
		
		 if (mysql_num_rows($ensembleResult) != 0)
		 {
			echo "<h3 align=\"left\">Student Ensembles Schedule for " . $studioRow['StudioFirstName'] . " " . $studioRow['StudioLastName'] . "</h3>";
			echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
			echo "<tr><th>Student Name</th><th>Start Time</th><th>Room Number</th><th>Event</th><th>Class</th><tr>";
			while ($ensembleRow= mysql_fetch_array($ensembleResult))
			{
				// first look up the room description, the event, and the class
				$sql = "SELECT * FROM Classes WHERE ClassID = $ensembleRow[ClassID]";
				$classResult = mysql_query($sql, $selconn) or die(mysql_error());
				$classRow = mysql_fetch_array($classResult);
				
				$sql = "SELECT * FROM Events WHERE EventID = $ensembleRow[EventID]";
				$eventResult = mysql_query($sql, $selconn) or die(mysql_error());
				$eventRow = mysql_fetch_array($eventResult);
				
				$sql = "SELECT * FROM Rooms WHERE RoomID = $ensembleRow[RoomID]";
				$roomResult = mysql_query($sql, $selconn) or die(mysql_error());
				$roomRow = mysql_fetch_array($roomResult);

				// at least one of the students in the current ensemble belongs to this studio
				$students = array(1 => $ensembleRow['Student1ID'], 2 => $ensembleRow['Student2ID'], 3 => $ensembleRow['Student3ID'], 4 => $ensembleRow['Student4ID']);
				$studios = array(1 => $ensembleRow['Studio1ID'], 2 => $ensembleRow['Studio2ID'], 3 => $ensembleRow['Studio3ID'], 4 => $ensembleRow['Studio4ID']);

				for($i = 1; $i <= 4; $i++) // for each of the 4 students
				{
					$names = "";
					if( ($students[$i] != NULL) && ($studios[$i] != NULL) && ($studios[$i] == $studioID) )
					{
						$sql = "SELECT * FROM Students WHERE StudentID = $students[$i]";

						$resStudent = mysql_query($sql, $selconn) or die(mysql_error());
						$studentInfo = mysql_fetch_array($resStudent);
												
						$starttime = $ensembleRow['StartTime'];
						// convert to normal time from military time
						
						echo "<tr><td>" . $studentInfo['StudentFirstName'] . " " . $studentInfo['StudentLastName'] . "</td>";
						echo "<td>" . $starttime . "</td>";
						echo "<td>" . $roomRow['RoomDescription'] . "</td>";
						echo "<td>" . $eventRow['EventName'] . "</td>";
						echo "<td>" . $classRow['ClassDescription'] . "</td><tr>";
					} // end if student and studio not null and the correct studio also
				} // end for each of the 4 students
				
		 	} // end while there are ensemble rows remaining
			echo "</table>";	// close out ensemble table here	
		 } // end if the number of ensemble rows is not zero
		 echo "</span>";  // ok, force a page break here if you can!
		 
	} // end while not out of studios
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
