<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Scheduling</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script language="JavaScript">

</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<p><font size="+2">Click on a time slot to schedule your student's performance.</font></p>
  <p><font size="+2">Note: For performances requiring more than one five-minute 
    segment, just click the first time slot needed. The performance will automatically 
    be scheduled for the correct length of time.</font></p>
<?php
	// register the selected student and music 
	session_register('PerformanceID');
	
	if(isset($_POST['selPerformance']))
	{
		$_SESSION['PerformanceID'] = $_POST["selPerformance"]; 
		$performanceNum = $_SESSION['PerformanceID'];
	}
	else
		$performanceNum = $_SESSION['PerformanceID'];

	$database = $_SESSION['DatabaseName'];
				
	$conn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $conn) or die(mysql_error());

	// The ID number sent to us may be a History record or an ensemble record.
	$sql = "Select * from History where HistoryID = $performanceNum";
	$historyResult = mysql_query ($sql, $conn) or die(mysql_error());
	$isEnsemble = false;
	$isHistory = false;
	
	if(mysql_num_rows($historyResult) != 0)
	{	
		$isHistory = true;
		$performanceType = 'S';
	}
	else
	{
		$sql = "Select * from EnsembleHistory where EnsembleID = $performanceNum";
		$historyResult = mysql_query ($sql, $conn) or die(mysql_error());
		if(mysql_num_rows($historyResult) != 0)
		{
			$isEnsemble = true;
			$performanceType = 'E';
		}
		else die("There was a generic error with the performance. Please contact the site administrator!");
	}
	
	$historyRow = mysql_fetch_array($historyResult);

	$sql = "Select * from Classes where Classes.ClassID = ". $historyRow['ClassID'];
	$classResult = mysql_query ($sql, $conn) or die(mysql_error());
	$classRow = mysql_fetch_array($classResult);
	if($isHistory) // if it's a history record
	{
		$sql = "Select * from Students where Students.StudentID = " . $historyRow['StudentID'];
		$studentResult = mysql_query ($sql, $conn) or die(mysql_error());
		$studentRow = mysql_fetch_array($studentResult);
	}
	else // it's an ensemble record; generate a string of all names
	{
		// lookup the student's names here
		$student = array(1 => $historyRow['Student1ID'], 2 => $historyRow['Student2ID'], 3 => $historyRow['Student3ID'], 4 => $historyRow['Student4ID']);
		$names = "";
		for($i = 1; $i <= 4; $i++)
		{
			if($student[$i] != NULL)
			{
				$sql = "SELECT * FROM Students WHERE StudentID = $student[$i]";
				$resStudent = mysql_query($sql, $conn) or die(mysql_error());
				$studentInfo = mysql_fetch_array($resStudent);
				if ($names != "")
					$names .= "/";
				$names .= $studentInfo['StudentFirstName'] . " " . $studentInfo['StudentLastName'];
			}
		}
	}
	
	session_register('StudentFullName');
	session_register('StudentID');
	session_register('TimeRequired');
	session_register('RequiredSelection');
	session_register('ChoiceSelection');
	session_register('ClassID');
	session_register('ClassDescription');
	
	if($isHistory)
	{
		$_SESSION["StudentID"] = $historyRow['StudentID'];
		$_SESSION["StudentFullName"] = $studentRow['StudentFirstName'] . " " . $studentRow['StudentMiddleName'] . " " . $studentRow['StudentLastName'];
	}
	else
	{
		$_SESSION["StudentID"] = $historyRow['Student1ID']; // just keep the first one 
		$_SESSION["StudentFullName"] = $names; 
	}
	
	$_SESSION["TimeRequired"] = $historyRow['PerformanceLength'];
	$_SESSION["RequiredSelection"] = $historyRow['RequiredSelection'];
	$_SESSION["ChoiceSelection"] = $historyRow['ChoiceSelection'];
	$_SESSION["ClassID"] = $historyRow['ClassID'];
	$_SESSION["ClassDescription"] = $classRow['ClassDescription'];

?>
<p><font style="bold" size="+2">You are scheduling 
	<font color="#008000"><?php print $_SESSION["StudentFullName"]; ?></font><br>
	for <font color="#008000"><?php print $_SESSION["RequiredSelection"]; ?> </font>
	and <font color="#008000"><?php print $_SESSION["ChoiceSelection"]; ?></font><br>
	for class level <font color="#008000"><?php print $_SESSION["ClassDescription"]; ?></font><br>
	(total time: <font color="#008000"><?php print $_SESSION["TimeRequired"]; ?></font> minutes)  
</font></p>
  <table width="80%" border="0">
    <tr> 
      <td width="33%"> <div align="center"> 
          <input name="btnSelectStudent" type="button" id="btnSelectStudent" value="Select A Different Student" onClick="window.location='SchedDisplayStudents.php'">
        </div></td>
      <td width="34%"><div align="center"> 
          <input name="btnStudioAdmin" type="button" id="btnStudioAdmin" value="Back to Studio Administration" onClick="window.location='StudioAdmin.php'">
        </div></td>
      <td width="33%"> <div align="center"> 
          <input name="btnLogout" type="button" id="btnLogout" value="Logout" onClick="window.location='Logout.php'">
        </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>

  <table border='2' cellpadding='1' cellspacing='1' WIDTH='1200' bgcolor='#eeeeee'>

<?php	

	$sql = "Select * from Rooms";
	$result = mysql_query ($sql, $conn) or die(mysql_error());
	
	$roomIDInfo = array();  // array of roomIDs from database
	$roomNumInfo = array();	// array of room numbers(descriptions) from database
	$roomCounter = 1;
	$maxRooms = 0;
	while($row = mysql_fetch_array($result))
	{	
		$roomNumInfo[$roomCounter] = $row['RoomDescription'];
		$roomIDInfo[$roomCounter] = $row['RoomID'];
		$roomCounter++;
	}
	$maxRooms = $roomCounter - 1;
	
	// set up schedule, judginglevel, and roomuse arrays
	$schedule = array();
	$judginglevels = array();
	$roomuse = array();
	
	// initialize the arrays
	for($roomCounter = 1; $roomCounter <= $maxRooms; $roomCounter++)
	{
		$roomID = $roomIDInfo[$roomCounter];
		for($timeInt = 800; $timeInt < 1900; $timeInt += 5)
		{
			// if time gets to 60, add 40 to get the next hour
			if($timeInt % 100 == 60)
				$timeInt += 40;
			// record only on-the-hour info for judging and use
			if($timeInt % 100 == 0)
			{
				$judginglevels[$roomID][$timeInt] = 'Any Level';
				$roomuse[$roomID][$timeInt] = 'Any Instrument';
			}
			// add the availability to the schedule
			$schedule[$roomID][$timeInt] = 'Available';	
		}
	}	

	// lookup existing unavailable times FOR SOLO Events ONLY.
	// note that anything in the RoomTimePerformance table is unavailable.
	$sql = "SELECT RoomID, StartTime, HistoryID from RoomTimePerformance WHERE Type = 'S'";
	$result = mysql_query ($sql, $conn) or die(mysql_error());
	
	while($row = mysql_fetch_array($result))
	{
		// check here if studioID matches the RoomTimePerformance studio
		// if so, lookup student name, place on button so teacher can unschedule student
		$roomID = $row['RoomID'];
		$timeStamp = $row['StartTime'];
		$timeInt = ConvertTimeStamp($timeStamp);
		$soloID = $row['HistoryID'];
		
		// get the SOLO name & performance info to show to the teacher on the schedule
		$sql = "Select History.StudioID, EventName, StudentFirstName, StudentLastName, RequiredSelection, ChoiceSelection from Students, History, Events where HistoryID = $soloID and History.StudentID = Students.StudentID and Events.EventID = History.EventID";
		$result2 = mysql_query($sql, $conn) or die(mysql_error());
	
		$studentInfo = mysql_fetch_array($result2);
		$studioID = $studentInfo['StudioID'];
		if ($studioID == $_SESSION['StudioID']) // if student belongs to this studio
		{
			$fullName = $studentInfo['StudentFirstName'] . " " . $studentInfo['StudentLastName'];
			$selections = $studentInfo['EventName'] . "<br>" . $studentInfo['RequiredSelection'] . "<br>" . $studentInfo['ChoiceSelection'];
			$schedule[$roomID][$timeInt] = $fullName . "<br>" . $selections;
		}
		else	// some other student is registered
			$schedule[$roomID][$timeInt] = 'Reserved';
	}
	
	// now look up only ENSEMBLE records from RoomTimePerformance
	$sql = "SELECT RoomID, StartTime, HistoryID from RoomTimePerformance WHERE Type = 'E'";
	$result = mysql_query ($sql, $conn) or die(mysql_error());
	
	while($row = mysql_fetch_array($result))
	{
		// check here if studioID matches the RoomTimePerformance studio
		// if so, lookup student name, place on button so teacher can unschedule student
		$roomID = $row['RoomID'];
		$timeStamp = $row['StartTime'];
		$timeInt = ConvertTimeStamp($timeStamp);

		$ensembleID = $row['HistoryID'];
			// get the name & performance info to show to the teacher on the schedule
			// remember, Studio1 is the studio that registered this ensemble, so should be in control of it.
		$sql = "Select Studio1ID, Student1ID, Student2ID, Student3ID, Student4ID, EventName, RequiredSelection, ChoiceSelection from EnsembleHistory, Events where EnsembleID = $ensembleID and Events.EventID = EnsembleHistory.EventID";
		$result2 = mysql_query($sql, $conn) or die(mysql_error());
	
		$ensembleInfo = mysql_fetch_array($result2);

		$studioID = $ensembleInfo['Studio1ID'];
		if ($studioID == $_SESSION['StudioID']) // if student belongs to this studio
		{
			// lookup the student's names here
			$student = array(1 => $ensembleInfo['Student1ID'], 2 => $ensembleInfo['Student2ID'], 3 => $ensembleInfo['Student3ID'], 4 => $ensembleInfo['Student4ID']);
			$names = "";
			for($i = 1; $i <= 4; $i++)
			{
				if($student[$i] != NULL)
				{
					$sql = "SELECT * FROM Students WHERE StudentID = $student[$i]";
					$resStudent = mysql_query($sql, $conn) or die(mysql_error());
					$studentInfo = mysql_fetch_array($resStudent);
					if ($names != "")
						$names .= "<br>";
					$names .= $studentInfo['StudentFirstName'] . " " . $studentInfo['StudentLastName'];
				}
			}
			$selections = $ensembleInfo['EventName'] . "<br>" . $ensembleInfo['RequiredSelection'] . "<br>" . $ensembleInfo['ChoiceSelection'];
			$schedule[$roomID][$timeInt] = $names . "<br>" . $selections;
		}
		else	// some other student is registered
			$schedule[$roomID][$timeInt] = 'Reserved';
	}

	// now do all the NULL entries (breaks) // note: these should be placed in the RoomTimeBreaks table, not the perf.table.
	// #######################################
	$sql = "SELECT RoomID, StartTime from RoomTimeBreaks";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	
	while($row = mysql_fetch_array($result))
	{
		// check here if studioID matches the RoomTimePerformance studio
		// if so, lookup student name, place on button so teacher can unschedule student
		$roomID = $row['RoomID'];
		$timeStamp = $row['StartTime'];
		$timeInt = ConvertTimeStamp($timeStamp);
		$schedule[$roomID][$timeInt] = 'Reserved';
	}
	

	// look up the judging levels and room usage from the RoomTimeUsage table
	// then fill in the judginglevels chart and room usage chart
	// and mark the schedule chart for this user's judging times
	$sql = "select * from RoomTimeUsage";
	$result = mysql_query ($sql, $conn) or die(mysql_error());
	
	while($row = mysql_fetch_array($result))
	{
		$roomID = $row['RoomID'];
		$timeStamp = $row['StartTime'];
		$timeInt = ConvertTimeStamp($timeStamp);

		// remember the level and room use for each hour
		$judginglevels[$roomID][$timeInt] = $row['Judging_Level'];
		$roomuse[$roomID][$timeInt] = $row['Instrument'];
	}

	// look up the judging times from RoomTimeJudging table
	// and mark the schedule chart for this user's judging times
	$sql = "select * from RoomTimeJudging";
	$result = mysql_query ($sql, $conn) or die(mysql_error());
	
	while($row = mysql_fetch_array($result))
	{
		$roomID = $row['RoomID'];
		$timeStamp = $row['StartTime'];
		$timeInt = ConvertTimeStamp($timeStamp);

	// if the judges id matches the user, mark the schedule 
		if( $row['StudioID'] == $_SESSION['StudioID'])
		{
			for($counter = $timeInt; $counter <= $timeInt + 55; $counter+=5)
			{
				$schedule[$roomID][$counter] = 'Judging';
			}
		}	
	}

		
	ob_start(); 	//begin output buffering; speeds up the display time
	$timeInt = 800;
	while($timeInt <= 1855) // stop at 1855, that is, 6:55 PM
	{
		// print out the row header: room number, level, and use
		if($timeInt %100 == 0)
		{
			echo "<tr align=\"center\" bgcolor=\"#00FF00\"><td></td>";
			for($roomCounter=1;$roomCounter<=$maxRooms;$roomCounter++)
			{
				$roomID = $roomIDInfo[$roomCounter];
				$roomNum = $roomNumInfo[$roomCounter];
				$hr = ($timeInt / 100) % 12;
				if ($hr == 0) $hr = 12;
				echo "<td>Room $roomNum<br>" . $judginglevels[$roomID][$timeInt] . "<br>" . 
					$roomuse[$roomID][$timeInt] . "</td>";
			}
			echo "</tr>";
		}
		$minutes = $timeInt % 100;
		$hour = ($timeInt - $minutes) / 100;
		if ($hour >= 13)  
			$hour -= 12;
		if ($minutes < 10)
			$timeString = $hour . ":0" . $minutes;
		else
			$timeString = $hour . ":" . $minutes;
		if($timeInt < 1200) 
			$timeString .= " AM";
		else
			$timeString .= " PM";
		echo "<tr align=\"center\">	<td>" . $timeString . "</td>\n";
		
		for($roomCounter=1; $roomCounter <= $maxRooms; $roomCounter++)
		{
			$rooms = $roomIDInfo[$roomCounter];
			if($schedule[$rooms][$timeInt] == 'Available')
				echo "<td><input name=\"R$rooms\_$timeInt\" value=\"$timeString\" type=\"button\" onClick=\"window.location='SchedAddToDB.php?roomID=$rooms&timeInt=$timeInt&perfType=$performanceType'\"></td>\n";
			else if (($schedule[$rooms][$timeInt] == 'NotAvail') || ($schedule[$rooms][$timeInt] == 'Reserved'))
				echo "<td bgcolor=\"#AAAAAA\">Reserved</td>";
			else if ($schedule[$rooms][$timeInt] == 'Judging')
				echo "<td bgcolor=\"#FF9999\">Judging</td>";
			else // must be a student of this studio
			{
				echo "<td bgcolor=\"#33CCFF\">" . $schedule[$rooms][$timeInt] . "<br>";
				//echo "<input name=\"R$rooms\_$timeInt\" value=\"Click to remove\" type=\"button\" onClick=\"window.location='SchedRemoveFromDB.php?roomID=$rooms&timeInt=$timeInt'\"></td>\n";
			}
		}
		$timeInt += 5;
		if($timeInt %100 == 60) // end of the hour; add 40 to go to next hour
			$timeInt += 40; 
		echo  "</tr>";
	}
	ob_end_flush(); // end of output buffering; sends output to the requestor

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
</table>
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
