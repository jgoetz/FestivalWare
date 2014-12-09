<?php include("IsAuth_Admin.php");
function fixInput($inputStr)
{
	$fixedStr = preg_replace("/([;<>\?\^\*\|`&\$!#\(\)\[\]\{\}:\"\=])/", "", $inputStr);
	return $fixedStr;
}

	$database = $_SESSION['DatabaseName'];			
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$performID = fixInput($_POST['reqPerformanceNum']);
	$points = fixInput($_POST['reqSelPoints']);
	$type = fixInput($_POST['reqSelType']);

//if event is solo performance
	if ($type == 'Solo')
	{
		$selsql="SELECT * FROM History WHERE HistoryID=$performID;";
		$updatesql="UPDATE History SET Points = $points WHERE HistoryID=$performID;";
	}
	else if ($type == 'Ensemble')
	{
		$selsql="SELECT * FROM EnsembleHistory WHERE EnsembleID=$performID;";
		$updatesql="UPDATE EnsembleHistory SET Points = $points WHERE EnsembleID=$performID;";
	}
	$result = mysql_query($selsql, $selconn) or die(mysql_error());
	
	// if there's more or less than 1, serious error (entered # wrong?)
	if(mysql_num_rows($result) != 1)
	{
		echo "<p>Error! Did you enter the performance number correctly?";
		echo "<input name=\"btnReturn\" value=\"Back to Point Entry\" type=\"button\" onClick=\"location='AdminPointsEnter.php'\"></p>";	
	}
	else	// there's only one entry... update it (works for either solo or ensemble row)
	{
		$row= mysql_fetch_array($result);
		$updateResult = mysql_query($updatesql, $updateconn) or die(mysql_error());
		// update records in history that correspond to the ensemble participants
		if($type == 'Ensemble')
		{
			// $row will have the ensemble row
			$students = array(1 => $row['Student1ID'], 2 => $row['Student2ID'], 3 => $row['Student3ID'], 4 => $row['Student4ID']);
			$studios= array(1 => $row['Studio1ID'], 2 => $row['Studio2ID'], 3 => $row['Studio3ID'], 4 => $row['Studio4ID']);
			for($i = 1; $i <= 4; $i++)
			{
				if($students[$i] != NULL)
				{
					$sql = "UPDATE History SET Points=$points WHERE Year=2004 AND StudentID='$students[$i]' and StudioID='$studios[$i]' and EventID='$row[EventID]' and ClassID='$row[ClassID]'";
					$hopeThisWorks = mysql_query($sql, $updateconn) or die(mysql_error());
				}
			}
		} // end if ensemble
		if($row['Points'] != 0 )
		{
			echo ("<p> Entry #$performID already had $row[Points] points. Changing to $points points. Hope you don't mind!");
			echo ("<input name=\"btnReturn\" value=\"Back to Point Entry\" type=\"button\" onClick=\"location='AdminPointsEnter.php'\"></p>");	
		}
		else
			header("Location: AdminPointsEnter.php");
	}
?>

<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
