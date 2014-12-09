<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Scheduling Results</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js">
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" background="img/lightbrown.jpg">
        <tr align="left" valign="top"> 
          <td> 
<?php
// function ConvertTimeInt: converts a time integer (hhmm) to timestamp string
// input: $timeInt is the time integer (first digits are the hour, last two digits are minutes)
// output: returns a string of the form hh:mm:ss
// side effects: none
function ConvertTimeInt($timeInt)
{	
	$minutes = $timeInt % 100; 
	$hours = ($timeInt - $minutes) / 100 ;
	if($hours < 10) $hours = "0" . $hours;
	if($minutes < 10) $minutes = "0" . $minutes;
	return "$hours:$minutes:00";
}

// OK, most of the info needed is in session variables. The only thing we got from the 
// previous schedule page is the time and room number. If there is enough space in the schedule
// for the required time, insert a new history record for each of the time slots. 
// When finished, return to the student selection page so teacher can pick another student to register.

// first, get time and room number from the GET data, and any other info from session vars
	$timeInt = $_GET['timeInt'];
	$roomID = $_GET['roomID'];
	$performanceType = $_GET['perfType'];

	$timeRequired = $_SESSION["TimeRequired"];
	$performanceNum = $_SESSION["PerformanceID"]; 

// assemble and execute the SQL statement to check for required time in the requested room
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());
	
// ok, test here to see if there is enough time for the performance...
// figure out the times we'll need
// if any of the rows match the times, return an error message
	$ScheduleErrorMsg = "";

	$sql = "SELECT StartTime FROM RoomTimePerformance WHERE RoomID=$roomID;";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
		
	while($row = mysql_fetch_array($result))
	{
		$DBTimeStamp = $row['StartTime'];
		for($i = $timeInt; $i < $timeInt + $timeRequired; $i+=5)
		{
			$timeStamp = ConvertTimeInt($i);
			if($DBTimeStamp == $timeStamp)
				$ScheduleErrorMsg = "there is not enough time before another performance";
		}
	}
	$sql = "SELECT StartTime FROM RoomTimeBreaks WHERE RoomID=$roomID;";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
		
	while($row = mysql_fetch_array($result))
	{
		$DBTimeStamp = $row['StartTime'];
		for($i = $timeInt; $i < $timeInt + $timeRequired; $i+=5)
		{
			$timeStamp = ConvertTimeInt($i);
			if($DBTimeStamp == $timeStamp)
				$ScheduleErrorMsg = "there is not enough time before a reserved time";
		}
	}
	
	/* NOTE: THERE MAY BE A PROBLEM HERE WITH ROOMTIMEUSAGE. THERE MIGHT BE A POSSIBILITY THAT A USER CAN
		CLICK ON A TIME THAT IS BEFORE THEIR JUDGING TIME, AND HAVE THE PERFORMANCE OVERLAP INTO 
		THEIR JUDGING TIME...  the following takes care of this. A judge's time is indicated by the first 
		segment of their time slot; if any of the times for the student overlaps, give an error message.
	*/
	$sql = "SELECT StartTime FROM RoomTimeJudging WHERE RoomID=$roomID AND StudioID = " . $_SESSION['StudioID'] . ";";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$DBTimeStamp = $row['StartTime'];
		for($i = $timeInt; $i < $timeInt + $timeRequired; $i+=5)
		{
			$timeStamp = ConvertTimeInt($i);
			if($DBTimeStamp == $timeStamp)
				$ScheduleErrorMsg = "there is not enough time before your judging schedule";
		}
	}
	
	// check here if the student is in another room at the same time
	if($performanceType == 'S') 		// get the student number(s)
	{
		$sql = "SELECT * FROM History WHERE HistoryID = $performanceNum;";
		$result = mysql_query($sql, $selconn) or die (mysql_error());
		$row = mysql_fetch_array($result);
		$students = array(1 => $row['StudentID'], 2 => NULL, 3 => NULL, 4 => NULL);
	}
	else
	{
		// get the student number(s)
		$sql = "SELECT * FROM EnsembleHistory WHERE EnsembleID = $performanceNum;";
		$result = mysql_query($sql, $selconn) or die (mysql_error());
		$row = mysql_fetch_array($result);
		$students = array(1 => $row['Student1ID'], 2 => $row['Student2ID'], 3 => $row['Student3ID'], 4 => $row['Student4ID']);
	}
	// get all performances at the same time as this one.
	// note that we are checking for the time slot immediately after this performance too, so to give the student
	// time to switch rooms
	$sql = "SELECT * from RoomTimePerformance WHERE StartTime >= '". ConvertTimeInt($timeInt) . "' and StartTime <= '". ConvertTimeInt($timeInt + $timeRequired) ."' AND HistoryID != $performanceNum;";
	$result = mysql_query($sql, $selconn) or die(mysql_error());

	while ($row = mysql_fetch_array($result))
	{
		if($row['Type'] == 'S') // lookup solo history
		{
			$sql = "SELECT StudentID from History WHERE HistoryID = $row[HistoryID];";
			$histRes = mysql_query($sql, $selconn) or die(mysql_error());
			$histRow = mysql_fetch_array($histRes);
			
			for($i = 1; $i <= 4; $i++)
				if (($students[$i] != "") && ($students[$i] == $histRow['StudentID']) )
					$ScheduleErrorMsg = "a student you are registering has a conflict with another solo performance";
		}
		else // lookup ensemble history; remember, RTP still uses HistoryID in place of performanceID!
		{
			$sql = "SELECT Student1ID, Student2ID, Student3ID, Student4ID from EnsembleHistory WHERE EnsembleID = $row[HistoryID];";
			$histRes = mysql_query($sql, $selconn) or die(mysql_error());
			$histRow = mysql_fetch_array($histRes);
			
			for($i = 1; $i <= 4; $i++)
				if( ($students[$i] != NULL) && 
					( 
					  ($students[$i] == $histRow['Student1ID']) || ($students[$i] == $histRow['Student2ID']) ||
					  ($students[$i] == $histRow['Student3ID']) || ($students[$i] == $histRow['Student4ID']) 
					)
				  )
				{
						$ScheduleErrorMsg = "a student you are registering has a conflict with an ensemble performance";
				}
		}
	}

	if ($ScheduleErrorMsg != "")
	{
		$timeStamp = ConvertTimeInt($timeInt); // convert the starting time
		echo "<br><br>Can't schedule this performance starting at $timeStamp because $ScheduleErrorMsg. Click here to go back and try a different time: ";
		echo "<input name=\"btnGoToSchedulePage\" type=\"button\"  onClick=\"window.location='SchedSelectRoomTime.php'\" value=\"Return to Schedule Page\">";
		echo "<br><br>";
		echo "Or choose one of these options:<br><br>";		
	}
	else
	{
	// All times are available, so enter the history records now
	for($i = $timeInt; $i < $timeInt + $timeRequired; $i+=5)
	{
		$timeStamp = ConvertTimeInt($i);
		$sql = "INSERT INTO RoomTimePerformance VALUES ($roomID, '$timeStamp', $performanceNum, '$performanceType');";
		$result = mysql_query ($sql, $addconn) or die(mysql_error());
	}
	// set the history scheduled flag for this record to true.
	if($performanceType == 'S')
	{
		$sql = "Update History set Scheduled = 'Y' WHERE HistoryID = $performanceNum";
		$result = mysql_query ($sql, $updateconn) or die(mysql_error());
	}
	else
	{
		$sql = "Update EnsembleHistory set Scheduled = 'Y' WHERE EnsembleID = $performanceNum";
		$result = mysql_query ($sql, $updateconn) or die(mysql_error());
	}	
	echo "<br>You have successfully added the performance for $_SESSION[StudentFullName]. <br><br>";
	// unregister any unnecessary session variables
	}
	
	
	
		// ConvertTimeStamp: converts a standard unix timestamp (HH:MM:SS DD:MM:YYYY)
	// to an integer where the first digits are the hour and the last two digits are the minutes
	// (that is, return value is hours * 100 + minutes)
	// input: $target is the unix timestamp to convert
	// output: returns an integer equal to hours * 100 + minutes
	// side effects: none
	function ConvertTimeStamp($target)
	{
		$firstColon = strpos($target, ":");
		$hr = substr($target, 0, $firstColon);
		$min = substr($target, $firstColon + 1, 2);
		return $hr * 100 + $min;
	}

?>
			<table width="100%" border="1">
			<tr> 
			<td width="33%"> <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
				Click below to schedule another student</font></div></td>
			<td width="34%"><div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
				Click below to view the schedule </font></div></td>
			<td width="33%"> <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
				Click below to log out </font> </div></td>
			</tr>
			<tr> 
			<td> <div align="center"> 
				<input name="btnGoToSchedulePage" type="button"  onClick="window.location='SchedDisplayStudents.php'" value="Schedule Another Student">
			  </div></td>
			<td><div align="center"> 
				<input name="btnViewSchedule" type="button"  onClick="window.location='SchedViewSchedule.php'" value="View the Schedule">
			</div></td>
			<td> <div align="center"> 
				<input name="btnLogout" type="button"  onClick="window.location='Logout.php'" id="Logout" value="Log Out">
			  </div></td>
			</tr>
			</table></form>
            </td>
        </tr>
      </table> 
<?php include('../php/TableEnd.php'); ?>

</body>
</html>
