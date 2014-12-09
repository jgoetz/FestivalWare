<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Studio Administration: Set Judging Levels</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<?php
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];
	$studioID = $_SESSION['StudioID'];
	
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// Find existing judging preference, if any. This select should result in zero or one row only
	$sql = "SELECT * FROM StudioJudgingPrefs WHERE FestivalID = $festivalID AND StudioID = $studioID";
	$result = mysql_query($sql, $selconn) or die(mysql_error());
	$row = mysql_fetch_array($result);

	if(mysql_num_rows($result) == 1)
	{
		$minLevel = $row['MinSkillLevel'];
		$maxLevel = $row['MaxSkillLevel'];
	}
	else
	{
		$minLevel = -1;
		$maxLevel = -1;
	}
	// now get the skill levels for the drop down lists
	// select all performance levels for this festival, and their descriptions, and build an array
	// of their IDs and descriptions
	$sql = "SELECT * FROM Festival_PerfLevels, SkillLevels WHERE FestivalID = $festivalID AND PerfLevelID=SkillLevelID";
	$skillsResult = mysql_query($sql, $selconn) or die(mysql_error());
	while($skillsRow = mysql_fetch_array($skillsResult))
	{
		$skillsArray [$skillsRow['SkillLevelID']] = $skillsRow['SkillDescription'];
	}
?>

<form method="post" name ="frmSetJudgingPrefs" onSubmit="return checkReqEntries(this)" action="Studio_SkillsAddtoDB.php">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
<tr align="left" valign="top">
  <td>
	<table width="100%" height="100%">
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr> 
		<tr> <td colspan="2" align="center"> <h2>Set or Change Judging Preferences</h2></td></tr>
		<tr> <td colspan="2" align="center">&nbsp;</td> </tr>
		<tr> <td colspan="2" align="center">&nbsp;</td> </tr>
		<tr> <th align="left">Minimum Skill Level:
		  
		  <select name="reqSelMinSkill" title="Set Min. Skill">
            <option value="-1">Set min skill level</option>
            <?php
				foreach ($skillsArray as $level => $descr)
				{
					if($level == $minLevel) 
						print "<option selected value=\"$level\"> $descr</option>";
					else
						print "<option value=\"$level\"> $descr</option>";
				}
			?>
                    </select></th>
			 <th align="left">Maximum Skill Level:
			   <select name="reqSelMaxSkill" title="Set Max. Skill">
                 <option value="-1">Set max skill level</option>
            <?php
				foreach ($skillsArray as $level => $descr)
				{
					if($level == $maxLevel)
						print "<option selected value=\"$level\"> $descr</option>";
					else
						print "<option value=\"$level\"> $descr</option>";
				}
			?>
		</select></th>
		</tr>

	</table>
  </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
  <td align="center">
	<table width="50%">
		<tr>
		  <td align="center"><input type="submit" name="Submit" value="Save"></td>
		  <td align="center"><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='StudioAdmin.php'"></td>
		</tr>
	</table>
  </td>
</tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
