<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=charset=iso-8859-1">
<meta name=Generator content="text/html; charset=iso-8859-1">
<title>FestivalWare Demo Festival Administration: Print Certificates</title>
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
		// get the starting time of the first entry of the performance rec
		$sql = "SELECT StartTime, RoomDescription FROM RoomTimePerformance, Rooms WHERE RoomTimePerformance.RoomID=Rooms.RoomID AND HistoryID= $perfRow[HistoryID] ORDER BY StartTime";
		$roomResult = mysql_query($sql, $selconn) or die(mysql_error());
		$roomRow = mysql_fetch_array($roomResult);
		
		// get the event, class, and student info from the solo or ensemble history record
		if ($perfRow['Type'] == 'S')
		{
			$sql = "SELECT EventName, ClassDescription, StudentFirstName, StudentLastName, StudioName";
			$sql .= " FROM History, Events, Classes, Students, Studios";
			$sql .= " WHERE HistoryID=$perfRow[HistoryID]";
			$sql .= " AND History.EventID=Events.EventID";
			$sql .= " AND History.ClassID=Classes.ClassID ";
			$sql .= " AND History.StudentID=Students.StudentID ";
			$sql .= " AND History.StudioID=Studios.StudioID ";
			$soloResult = mysql_query($sql, $selconn) or die(mysql_error());
			$soloRow = mysql_fetch_array($soloResult);
			
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 1.0 Transitional//EN\">";
			echo "<html>";
			echo "<head>";
			echo "<title>Certificates for FestivalWare Demo Festival</title>";
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
			echo "<style type=\"text/css\">";
			echo "<!--";
			echo ".style1 {font-family: \"Monotype Corsiva\"; font-size: xx-large;}";
			echo ".style2 {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: large;}";
			echo ".style3 {font-size: xx-small}";
			echo "body  {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: small}";
			echo "h3    {font-family: \"Times New Roman\", Times, serif; font-size: small; font-weight: bold}";
			echo "h5    {font-family:  \"Times New Roman\", Times, serif; font-size: xx-small; }";
			echo "h6    {page-break-after:always}";
			echo "-->";
			echo "</style>";
			echo "</head>";
			echo "<body>";
			echo "<table width=\"100%\"  border=\"0\">";
			echo "<tr><td height=\"63\" valign=\"bottom\"><div align=\"center\" class=\"style1\">$soloRow[StudentFirstName] $soloRow[LastName]</div></td></tr>";
			echo "<tr><td><div align=\"center\" class=\"style2\">$soloRow[StudioName] </div></td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td height=\"125\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr><td width=\"30%\">&nbsp;</td><td width=\"70%\"><font color=\"#0099FF\">NEVADA</font></td></tr></table></td></tr>";
			echo "<tr><td height=\"27\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr><td width=\"6%\">&nbsp;</td><td width=\"25%\" align=\"center\">";
			echo "$soloRow[EventName]</td><td width=\"37%\" align=\"center\">$soloRow[ClassDescription]</td><td width=\"25%\" align=\"center\">2004</td><td width=\"6%\">&nbsp;</td>";
			echo "</tr></table></td></tr>";
			echo "<tr><td height=\"55\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr>";
			echo "<td align=\"center\"><img src=\"img/cbgsig.jpg\" width=\"183\" height=\"37\"></td>";
			echo "<td align=\"center\"><img src=\"img/nancysig.jpg\" width=\"183\" height=\"37\"></td>";
			echo "</tr></table></td></tr>";
			echo "<tr><td height=\"75\" valign=\"bottom\" align=\"left\"><div class=\"h5 style3\">$perfRow[Type]$perfRow[HistoryID]/$roomRow[RoomDescription]/$roomRow[StartTime]</div></td></tr></table>";
			echo "<h6>&nbsp;</h6>";
			echo "</body>";
			echo "</html>";
			// output performance number, type, and other data			
		}
		elseif($perfRow['Type'] == 'E') // its an ensemble
		{
			$sql = "SELECT EventName, ClassDescription, Student1ID, Student2ID, Student3ID, Student4ID";
			$sql .= " FROM EnsembleHistory, Events, Classes";
			$sql .= " WHERE EnsembleID=$perfRow[HistoryID]";
			$sql .= " AND EnsembleHistory.EventID=Events.EventID";
			$sql .= " AND EnsembleHistory.ClassID=Classes.ClassID ";			
			$ensembleResult = mysql_query($sql, $selconn) or die(mysql_error());
			$dataRow = mysql_fetch_array($ensembleResult);
			
			$student = array(1 => $dataRow['Student1ID'], 2 => $dataRow['Student2ID'], 3 => $dataRow['Student3ID'], 4 => $dataRow['Student4ID']);
			for($i = 1; $i <= 4; $i++)
			{
				if($student[$i] != NULL)
				{
					$sql = "SELECT StudentFirstName, StudentLastName, StudioName";
					$sql .= " FROM Students, Studios WHERE StudentID = $student[$i] AND Studios.StudioID=StudentStudioID";
					$resStudent = mysql_query($sql, $selconn) or die(mysql_error());
					$studentInfo = mysql_fetch_array($resStudent);
					
					echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 1.0 Transitional//EN\">";
					echo "<html>";
					echo "<head>";
					echo "<title>Certificates for FestivalWare Demo Festival</title>";
					echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
					echo "<style type=\"text/css\">";
					echo "<!--";
					echo ".style1 {font-family: \"Monotype Corsiva\"; font-size: xx-large;}";
					echo ".style2 {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: large;}";
					echo ".style3 {font-size: xx-small}";
					echo "body  {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: small}";
					echo "h3    {font-family: \"Times New Roman\", Times, serif; font-size: small; font-weight: bold}";
					echo "h5    {font-family:  \"Times New Roman\", Times, serif; font-size: xx-small; }";
					echo "h6    {page-break-after:always}";
					echo "-->";
					echo "</style>";
					echo "</head>";
					echo "<body>";
					echo "<table width=\"100%\"  border=\"0\">";
					echo "<tr><td height=\"63\" valign=\"bottom\"><div align=\"center\" class=\"style1\">$studentInfo[StudentFirstName] $studentInfo[StudentLastName]</div></td></tr>";
					echo "<tr><td><div align=\"center\" class=\"style2\">$studentInfo[StudioName] </div></td></tr>";
					echo "<tr><td>&nbsp;</td></tr>";
					echo "<tr><td height=\"125\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr><td width=\"30%\">&nbsp;</td><td width=\"70%\"><font color=\"#0099FF\">NEVADA</font></td></tr></table></td></tr>";
					echo "<tr><td height=\"27\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr><td width=\"6%\">&nbsp;</td><td width=\"25%\" align=\"center\">";
					echo "$dataRow[EventName]</td><td width=\"37%\" align=\"center\">$dataRow[ClassDescription]</td><td width=\"25%\" align=\"center\">2004</td><td width=\"6%\">&nbsp;</td>";
					echo "</tr></table></td></tr>";
					echo "<tr><td height=\"55\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr>";
					echo "<td align=\"center\"><img src=\"/img/cbgsig.jpg\" width=\"183\" height=\"37\"></td>";
					echo "<td align=\"center\"><img src=\"/img/nancysig.jpg\" width=\"183\" height=\"37\"></td>";
					echo "</tr></table></td></tr>";
					echo "<tr><td height=\"75\" valign=\"bottom\" align=\"left\"><div class=\"h5 style3\">$perfRow[Type]$perfRow[HistoryID]/$roomRow[RoomDescription]/$roomRow[StartTime]</div></td></tr></table>";
					echo "<h6>&nbsp;</h6>";
					echo "</body>";
					echo "</html>";
				}
			}
		} // done with the ensemble section
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
