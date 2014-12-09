<?php include("IsAuth_Studio.php");
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/
	session_start();	
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];
	$studioID = $_SESSION['StudioID'];
	
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());

	$minSkill = $_POST['reqSelMinSkill'];
	$maxSkill = $_POST['reqSelMaxSkill'];

	if ($minSkill > $maxSkill)
	{
		// print out error message and back button
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr> <td align="center"> <h2>Oops! </h2></td></tr>
	<tr> <td align="center">Your minimum skill level is greater than your maximum skill level!</td> </tr>
	<tr> <td align="center">Click the Back button to correct your selections</td> </tr>
	<tr> <td align="center"><input type="button" name="btnBack" value="Back" onClick="window.location='Studio_SkillsMain.php'"></td>
</table>

<?php 	
	}
	else	// min and max levels are OK
	{
		// if a skill record already exists, update with this information. Otherwise, create a new record.
		$sql = "SELECT * FROM StudioJudgingPrefs WHERE FestivalID = $festivalID AND StudioID = $studioID";
		$result = mysql_query($sql, $selconn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		
		if(mysql_num_rows($result) == 1)
		{
			$sql = "UPDATE StudioJudgingPrefs SET MinSkillLevel = '$minSkill', MaxSkillLevel = '$maxSkill'
					WHERE JudgingPrefID = $row[JudgingPrefID]";
			$result = mysql_query($sql, $updateconn) or die(mysql_error());
			mysql_close($updateconn);
		}
		else
		{
			$sql = "INSERT INTO StudioJudgingPrefs VALUES (
							'', 
							'$studioID', 
							'$festivalID', 
							'$minSkill',
							'$maxSkill')";	
			$result = mysql_query($sql, $addconn) or die(mysql_error());
			mysql_close($addconn);
		}
	
		header("Location: StudioAdmin.php");
	} // end else min and max levels are OK
?>
