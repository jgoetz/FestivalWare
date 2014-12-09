<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=charset=iso-8859-1">
<meta name=Generator content="text/html; charset=iso-8859-1">
<title>FestivalWare Demo Festival Administration: Print Rating Sheets</title>
</head>
<script src="RollOvers.js"></script>
<body lang=EN-US>

<?php

function fixInput($inputStr)
{
	$fixedStr = preg_replace("/([;<>\?\^\*\|`&\$!#\(\)\[\]\{\}\"\=])/", "", $inputStr);
	return $fixedStr;
}
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$roomID = fixInput($_POST['selRoom']);
	$startTime = fixInput($_POST['txtStartTime']);
	$endTime = fixInput($_POST['txtEndTime']);
	if($startTime == "") $startTime = "08:00:00";
	if ($endTime == "") $endTime = "17:55:00";
	
	// get the performance numbers and types
	$sql = "SELECT DISTINCT HistoryID, Type FROM RoomTimePerformance Where RoomID=$roomID";
	$sql .= " AND StartTime >= '$startTime' AND StartTime <= '$endTime' ORDER BY StartTime DESC";

	$perfResult = mysql_query($sql, $selconn) or die(mysql_error());

	// for each performance
	while ($perfRow = mysql_fetch_array($perfResult)) 
	{
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 1.0 Transitional//EN\">";
		echo "<html>";
		echo "<head>";
		echo "<title>Rating Sheets for FestivalWare Demo Festival</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
		echo "<style type=\"text/css\">";
		echo "<!--";
		echo "body  {font-family: \"Times New Roman\", Times, serif; font-size: small}";
		echo "h3    {font-family:  \"Times New Roman\", Times, serif; font-size: small; font-weight: bold}";
		echo "table {border-width:1px; border-color:#000000; border-style:solid; border-collapse:collapse; border-spacing:0}";
		echo "td    {font-family:  \"Times New Roman\", Times, serif; font-size: x-small}";
		echo "h6  {font-family: \"Times New Roman\", Times, serif; font-size: small; page-break-after:always}";
		echo "-->";
		echo "</style>";

		echo "</head>";
		echo "<body>";
		
		// get the starting time of the first entry of the performance rec
		$sql = "SELECT StartTime, RoomDescription FROM RoomTimePerformance, Rooms WHERE RoomTimePerformance.RoomID=Rooms.RoomID AND HistoryID= $perfRow[HistoryID] ORDER BY StartTime";
		$roomResult = mysql_query($sql, $selconn) or die(mysql_error());
		$roomRow = mysql_fetch_array($roomResult);
		
		// get the event, class, and student info from the solo or ensemble history record
		if ($perfRow['Type'] == 'S')
		{
			$sql = "SELECT EventName, ClassDescription, StudentFirstName, StudentLastName, History.StudioID AS StudioID, ChoiceSelection, RequiredSelection";
			$sql .= " FROM History, Events, Classes, Students";
			$sql .= " WHERE HistoryID=$perfRow[HistoryID]";
			$sql .= " AND History.EventID=Events.EventID";
			$sql .= " AND History.ClassID=Classes.ClassID ";
			$sql .= " AND History.StudentID=Students.StudentID ";
			$soloResult = mysql_query($sql, $selconn) or die(mysql_error());
			$soloRow = mysql_fetch_array($soloResult);
			
			// output performance number, type, and other data
			
			echo "<h3 align=\"center\">NATIONAL FEDERATION OF MUSIC CLUBS<br>NEVADA FEDERATION OF MUSIC CLUBS<br>";
			echo "  <b>Rating Sheet for Junior Festival</b> </h3>";
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">";
			echo "  <tr> ";
			echo "    <td width=\"33%\"><strong>Name: $soloRow[StudentFirstName]  $soloRow[StudentLastName]</strong></td>";
			echo "    <td width=\"34%\"><strong>Room: $roomRow[RoomDescription] Starting Time: $roomRow[StartTime]</strong></td>";
			echo "    <td width=\"33%\"><strong>Teacher ID: $soloRow[StudioID]</strong></td>";
			echo "  </tr>";
			echo "  <tr> ";
			echo "    <td><strong>Performance #: $perfRow[HistoryID]</strong></td>";
			echo "    <td><div align=\"left\"><strong>Event: $soloRow[EventName]</strong></div></td>";
			echo "    <td><strong>Class:$soloRow[ClassDescription]</strong></td>";
			echo "  </tr>";
			echo "</table>";
			echo "<div align=\"center\">REMINDER TO JUDGE:";
			echo "  <font size=\"-1\">Students do NOT compete against each other.&nbsp; Each is rated ";
			echo "  on his own merits as a student and not as a professional performer.&nbsp;";
			echo "  <strong>Please use minus points.</strong> </font></div>";
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
			echo "  <tr> ";
			echo "    <td width=\"50%\"><strong>Required Composition:$soloRow[RequiredSelection]</strong></td>";
			echo "    <td width=\"50%\"><strong>Choice Composition:$soloRow[ChoiceSelection]</strong></td>";
			echo "  </tr>";
			echo "</table>";
		}
		elseif($perfRow['Type'] == 'E') // its an ensemble
		{
			$sql = "SELECT EventName, ClassDescription, ChoiceSelection, RequiredSelection, Student1ID, Student2ID, Student3ID, Student4ID, Studio1ID";
			$sql .= " FROM EnsembleHistory, Events, Classes";
			$sql .= " WHERE EnsembleID=$perfRow[HistoryID]";
			$sql .= " AND EnsembleHistory.EventID=Events.EventID";
			$sql .= " AND EnsembleHistory.ClassID=Classes.ClassID ";			
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

					$names .= $studentInfo['StudentFirstName'] . " " . $studentInfo['StudentLastName']  . " &nbsp; &nbsp ";
				}
			}
			echo "<h3 align=\"center\">NATIONAL FEDERATION OF MUSIC CLUBS<br>NEVADA FEDERATION OF MUSIC CLUBS<br>";
			echo "  <b>Rating Sheet for Junior Festival</b> </h3>";
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">";
			echo "  <tr> ";
			echo "    <td width=\"33%\"><strong>Names: $names</strong></td>";
			echo "    <td width=\"34%\"><strong>Room: $roomRow[RoomDescription] Starting Time: $roomRow[StartTime]</strong></td>";
			echo "    <td width=\"33%\"><strong>Teacher ID: $dataRow[Studio1ID]</strong></td>";
			echo "  </tr>";
			echo "  <tr> ";
			echo "    <td><strong>Performance #: $perfRow[HistoryID]</strong></td>";
			echo "    <td><div align=\"left\"><strong>Event: $dataRow[EventName]</strong></div></td>";
			echo "    <td><strong>Class:$dataRow[ClassDescription]</strong></td>";
			echo "  </tr>";
			echo "</table>";
			echo "<div align=\"center\">REMINDER TO JUDGE:";
			echo "  <font size=\"-1\">Students do NOT compete against each other.&nbsp; Each is rated ";
			echo "  on his own merits as a student and not as a professional performer.&nbsp;";
			echo "  <strong>Please use minus points.</strong> </font></div>";
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
			echo "  <tr> ";
			echo "    <td width=\"50%\"><strong>Required Composition:$dataRow[RequiredSelection]</strong></td>";
			echo "    <td width=\"50%\"><strong>Choice Composition:$dataRow[ChoiceSelection]</strong></td>";
			echo "  </tr>";
			echo "</table>";
		} // done with the ensemble section
		// print the rest of the document
	
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">";
		echo "  <tr> ";
		echo "    <td width=\"30%\"> <div align=\"center\">COMMENTS</div></td>";
		echo "    <td width=\"10%\"><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td width=\"20%\"><div align=\"center\"> ";
		echo "        <p><strong>MEMORY</strong><br>";
		echo "          Secure </p>";
		echo "      </div></td>";
		echo "    <td width=\"10%\"><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td width=\"30%\"><div align=\"center\">COMMENTS</div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td> <div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"><strong>ACCURACY</strong><br>";
		echo "        Knowledge of Music<br>";
		echo "        Notes Fingerings<br>";
		echo "        Phrasing Dynamics<br>";
		echo "        Legato/Staccato<br>";
		echo "        Clarity of Notes</div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td> <div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"><strong>RHYTHM</strong><br>";
		echo "        Continuity<br>";
		echo "        Correct beat/count<br>";
		echo "        Steady tempo</div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td> <div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (10)</font></div></td>";
		echo "    <td><div align=\"center\"><strong>TECHNIQUE</strong><br>";
		echo "        Hand/Pedal position<br>";
		echo "        Balance between hands<br>";
		echo "        Command of touch<br>";
		echo "        Diction Breath Control<br>";
		echo "        Tonguing Bowing<br>";
		echo "        Intonation </div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (10)</font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td> <div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"> ";
		echo "        <p><strong>MUSICIANSHIP</strong><br>";
		echo "          Interpretation/Style<br>";
		echo "          Tone Quality<br>";
		echo "          Articulation<br>";
		echo "          Appropriate tempo</p>";
		echo "      </div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td> <div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"><strong>GENERAL EFFECT</strong><br>";
		echo "        Stage Presence/Poise<br>";
		echo "        Appearance Attitude<br>";
		echo "        Body Position</div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (8)</font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td> <div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (50)</font></div></td>";
		echo "    <td><div align=\"center\"><strong>TOTAL POINTS</strong></div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\">__________<br>";
		echo "        (50)</font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td> <div align=\"center\"> ";
		echo "        <p><font size=\"-2\">91-100 = Superior<br>";
		echo "          81-90 = Excellent<br>";
		echo "          71-80 = Very Good<br>";
		echo "          61-70 = Good<br>";
		echo "          51-60 = Fair<br>";
		echo "          0-50 = No rating</font></p>";
		echo "      </div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\"></font></div></td>";
		echo "    <td><div align=\"center\"> ";
		echo "        <p><strong>COMBINED POINTS</strong></p>";
		echo "        <p>__________<br>";
		echo "          (100) </p>";
		echo "      </div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\"></font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td><div align=\"center\">_________________________</div></td>";
		echo "   <td><div align=\"center\"><font size=\"-2\"></font></div></td>";
		echo "    <td><div align=\"center\"><strong>Recommended for Honors</strong>____</div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\"></font></div></td>";
		echo "    <td><div align=\"center\">_______________________</div></td>";
		echo "  </tr>";
		echo "  <tr> ";
		echo "    <td><div align=\"center\">Rating</div></td>";
		echo "    <td><div align=\"center\"><font size=\"-2\"></font></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\"></div></td>";
		echo "    <td><div align=\"center\">Judge</div></td>";
		echo "  </tr>";
		echo "</table>";
		echo "<h6>&nbsp;</h6>";
	} // end while fetch next performance
?>
<script type="text/javascript" language="javascript1.2">
<!--
if (typeof(window.print) != 'undefined') {
    window.print();
}
//-->
</script>
</body>
</html>
