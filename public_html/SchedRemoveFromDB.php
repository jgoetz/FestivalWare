<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Remove Performance Results</title>
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
	  <td> <br>

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

// OK, the info needed is in the room and time values. Lookup the historyID for the 
// room/time indicated, then delete the RoomTimeStudent records that correspond to that historyID.
	$timeInt = $_GET['timeInt'];
	$roomID = $_GET['roomID'];
	$timeStamp = ConvertTimeInt($timeInt);
	
// assemble and execute the SQL statement to check for required time in the requested room

	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	$delconn = mysql_connect ( "localhost","festival_deleter","by34wyb") or die(mysql_error()); 
	mysql_select_db($database, $delconn) or die(mysql_error());
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());

	$sql = "Select * from RoomTimePerformance WHERE RoomID = $roomID and StartTime = '$timeStamp';";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
		
	while($row = mysql_fetch_array($result))
	{
		$performanceNum = $row['HistoryID'];
		// remove the RoomTimePerformance record
		$sql = "Delete from RoomTimePerformance where HistoryID = $performanceNum;";
		$delresult = mysql_query ($sql, $delconn) or die(mysql_error());
		// unset the scheduled flag for the history record
		if($row['Type'] == 'S')
		{
			$sql = "Update History set Scheduled = 'N' where HistoryID = $performanceNum;";
			$updateresult = mysql_query ($sql, $updateconn) or die(mysql_error());
			// get the student's name so we can display a nice response
			$sql = "Select StudentFirstName,StudentLastName from History, Students where History.StudentID = Students.StudentID and HistoryID = $performanceNum;";
			$nameresult = mysql_query($sql, $selconn) or die(mysql_error());
			$row = mysql_fetch_array($nameresult);
			echo "<br>You have successfully removed the performance for $row[StudentFirstName] $row[StudentLastName] from the schedule.<br><br>";
		}
		else // it's an ensemble performance
		{
			$sql = "Update EnsembleHistory set Scheduled = 'N' where EnsembleID = $performanceNum;";
			$updateresult = mysql_query ($sql, $updateconn) or die(mysql_error());
			// get the student's name so we can display a nice response
			$sql = "SELECT * FROM EnsembleHistory WHERE EnsembleID = $performanceNum;";
			$selresult = mysql_query($sql, $selconn) or die(mysql_error());
			$row = mysql_fetch_array($selresult);
			$student = array(1 => $row['Student1ID'], 2 => $row['Student2ID'], 3 => $row['Student3ID'], 4 => $row['Student4ID']);
			$names = "";
			for($i = 1; $i <= 4; $i++)
			{
				if($student[$i] != NULL)
				{
					$sql = "SELECT * FROM Students WHERE StudentID = $student[$i]";
					$resStudent = mysql_query($sql, $selconn) or die(mysql_error());
					$studentInfo = mysql_fetch_array($resStudent);
					if ($names != "")
						$names .= "/";
					$names .= $studentInfo['StudentFirstName'] . " " . $studentInfo['StudentLastName'];
				}
			}
			echo "<br>You have successfully removed the ensemble performance for $names from the schedule.<br><br>";
		}
	}
	
	// unregister any unnecessary session variables

?>
            <table width="100%" border="1">
              <tr> 
                <td width="33%"> <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
					Click below to schedule another student</font></div></td>
                <td width="34%"><div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
					Click below to return to the schedule page </font></div></td>
                <td width="33%"> <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
					Click below to log out </font> </div></td>
              </tr>
              <tr> 
                <td> <div align="center"> 
              		<input name="btnGoToSchedulePage" type="button"  onClick="window.location='SchedDisplayStudents.php'" value="Schedule Another Student">
                  </div></td>
                <td>  <div align="center"> 
              		<input name="btnViewSchedule" type="button"  onClick="window.location='SchedViewSchedule.php'" value="View the Schedule">
                  </div>
				</td>
                <td> <div align="center"> 
	                <input name="btnLogout" type="button"  onClick="window.location='Logout.php'" id="Logout" value="Log Out">
                  </div></td>
              </tr>
            </table>
		</form>
 		</td>
        </tr>
      </table> 
<?php include('../php/TableEnd.php'); ?>

</body>
</html>
