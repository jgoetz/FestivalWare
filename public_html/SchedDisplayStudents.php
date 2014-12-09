<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Scheduling Student Selection</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" background="img/lightbrown.jpg">
	<tr align="left" valign="top"> 
	  <td > <h2>Performance Scheduling: Student Selection</h2></td>
	<tr><td>
		<form method="post" name ="frmChooseStudent"  action="SchedSelectRoomTime.php" onSubmit="return checkReqEntries(this)">
	<table><tr><td>
    <?php		
		// first, unset the session variables
		// need to do this here; it doesn't work just before
		// registering the new selection 
		if(isset($_SESSION['PerformanceID']))
			unset($_SESSION['PerformanceID']);
		if(isset($_SESSION['StudentFullName']))
			unset($_SESSION[['StudentFullName']);
		if(isset($_SESSION['StudentID']))
			unset($_SESSION['StudentID']);
		if(isset($_SESSION['TimeRequired']))
			unset($_SESSION['TimeRequired']);
		if(isset($_SESSION['RequiredSelection']))
			unset($_SESSION['RequiredSelection']);
		if(isset($_SESSION['ChoiceSelection']))
			unset($_SERVER['ChoiceSelection']);
		if(isset($_SESSION['ClassID']))
			unset($_SESSION['ClassID']);
		if(isset($_SESSION['ClassDescription']))
			unset($_SESSION['ClassDescription']);
						
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

		$sql = "SELECT HistoryID, Scheduled, StudentFirstName, StudentLastName, 
		RequiredSelection, ChoiceSelection, EventName 
		FROM Students, History, Events WHERE 
			Students.StudentID = History.StudentID 
		AND History.StudioID = $_SESSION[StudioID] 
		AND History.Year = 2004 
		AND History.EventID = Events.EventID 
		AND Scheduled = 'N'";
		$result = mysql_query ($sql, $selconn) or die(mysql_error());
		// for ensembles, we assume the first studio is the one that entered the data...
		$sql = "SELECT * FROM EnsembleHistory WHERE EnsembleHistory.Studio1ID = $_SESSION[StudioID] AND EnsembleHistory.Year = 2004 AND Scheduled = 'N'";
		$result2 = mysql_query ($sql, $selconn) or die(mysql_error());
		// if row count = 0 then no records found
		//		display msg, button to go back to choice page
		if( (mysql_num_rows($result) == 0) && (mysql_num_rows($result2) == 0) )
		{
			print " <br><br>Sorry, You have no students remaining to schedule.<br><br>";
			echo "<p align=\"center\">";
			echo "<input name=\"BackToStudioAdmin\" type=\"button\"  onClick=\"window.location='StudioAdmin.php'\" value=\"Return to Studio Administration\">";
			echo "<input name=\"Logout\" type=\"button\"  onClick=\"window.location='Logout.php'\" value=\"Log out\">";
			echo "</p>";
		}
		else{
			// if count of rows >= 1 then display select drop-down
			echo "\n<select name=\"reqSelPerformance\" title=\"Select Performance\">";
			echo "\n\t<option value=\"-1\">Please select a student and performance</option>";
			while($row = mysql_fetch_array($result))
			{
				$firstName = $row['StudentFirstName'];
				$lastName = $row['StudentLastName'];
				$requiredSelection = $row['RequiredSelection'];
				$choiceSelection = $row['ChoiceSelection'];

				$selectLine = "$row[EventName]: $firstName $lastName: $requiredSelection / $choiceSelection";
				$ID = $row['HistoryID'];
				echo "<option value=\"$ID\"> $selectLine </option>";
			}

			while($row = mysql_fetch_array($result2))
			{
				$student = array(1 => $row['Student1ID'], 2 => $row['Student2ID'], 3 => $row['Student3ID'], 4 => $row['Student4ID']);
				$name = "";
				for($i = 1; $i <= 4; $i++)
				{
					if($student[$i] != NULL)
					{
						$sql = "SELECT * FROM Students WHERE StudentID = $student[$i]";
						$resStudent = mysql_query($sql, $selconn) or die(mysql_error());
						$studentInfo = mysql_fetch_array($resStudent);
						if ($name != "")
							$name .= "/";
						$name .= $studentInfo['StudentFirstName'] . " " . $studentInfo['StudentLastName'];
					}
				}
				$sql = "SELECT * FROM Events WHERE EventID = $row[EventID]";
				$eventResult = mysql_query($sql, $selconn) or die(mysql_error());
				$eventRow = mysql_fetch_array($eventResult);
				
				$requiredSelection = $row['RequiredSelection'];
				$choiceSelection = $row['ChoiceSelection'];
				$selectLine = "$eventRow[EventName] $name : $requiredSelection / $choiceSelection";
				$ID = $row['EnsembleID'];
				echo "\n\t<option value=\"$ID\"> $selectLine </option>";
			}
			echo "\n</select>";
			?>
		</td></tr></table>
		
		<table width="50%" border="0">
		  <tr>
			<td width="60%"><div align="center">Click below to select the room and time</div></td>
			<td width="5%"><div align="center">Click below to view the schedule</div></td>
			<td width="35%"><div align="center">click below to logout</div></td>
		  </tr>
		  <tr>
			<td align="center"><input name="btnGoOn" type="submit" value="Select Room and Time" ></td>  
			<td align="center"><input name="btnViewSchedule" type="button"  onClick="window.location='SchedViewSchedule.php'" value="View the Schedule"></td>
			<td align="center"><input name="btnLogout" type="button" value="Log Out" onClick="location='Logout.php'"></td>
		  </tr>
		</table>

<?php		
		} // end else
		mysql_close($selconn);	
?>
</form>
</td></tr>
</table>	

</body>
</html>
