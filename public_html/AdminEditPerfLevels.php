<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Edit Skill Levels</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="EnterPerfLevels" onSubmit="return checkReqEntries(this)" action="AdminAddPerfLevelsToDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr align="left" valign="top">
	<td width="25%">&nbsp;</td><td width="25%">&nbsp;</td><td width="25%">&nbsp;</td><td width="25%">&nbsp;</td>
	</tr>
	 
	 <tr><td colspan="4" align="center"> <h2>Edit Skill Levels </h2></td></tr>
	<tr>
	  <td colspan="4" align="center">Directions: Click the checkboxes next to the performance skill levels  for your festival.
	  <br> If you need a skill level that isn't listed, contact your Coordinator!</td>
	</tr>
  <tr> 
	<td align="center" colspan="2"><input type="submit" name="Submit" value="Save"></td>
	<td align="center" colspan="2"><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Administration.php'"></td>
  </tr>	<tr>
<?php
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];

	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM SkillLevels";
	$allLevelsResult = mysql_query($sql, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM Festival_PerfLevels WHERE FestivalID = $festivalID";
	$festLevelsResult = mysql_query($sql, $selconn) or die(mysql_error());
	
	$noLevels = false;
	$festivalLevelsArray = array();
	$festLevelsRevArray = array();
	if(mysql_num_rows($festLevelsResult) == 0)
		$noLevels = true;
	else // build the perf. levels array
	{
		$count = 0;
		while($row = mysql_fetch_array($festLevelsResult ))
		{
			$festivalLevelsArray[$count] = $row['PerfLevelID'];
			$count++;
		}
		$festLevelsRevArray = array_flip($festivalLevelsArray);
	}
	$numpercol = ceil(mysql_num_rows($allLevelsResult) / 4); // this could be more precise!

	print "<td><table><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
	$count = 0;
	while($row = mysql_fetch_array($allLevelsResult))
	{
		if( ($noLevels == false) and (array_key_exists($row['PerfLevelID'],$festLevelsRevArray) ) )
			print "<tr><td align=\"right\"><input name=\"chkBox[]\" type=\"checkbox\" value=\"$row[PerfLevelID]\" checked></td><td align=\"left\">$row[SkillDescription]</td></tr>";
		else
			print "<tr><td align=\"right\"><input name=\"chkBox[]\" type=\"checkbox\" value=\"$row[PerfLevelID]\"></td><td align=\"left\">$row[SkillDescription]</td></tr>";

		$count++;
		if($count == $numpercol)
		{
			print "</table></td>";//end current column table
			print "<td><table><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
			$count = 0;
		}
	}
	print "</table></td>";//end current column table

?>
	</tr>
	<tr><td colspan="4">&nbsp;</td></tr>
  <tr> 
	<td align="center" colspan="2"><input type="submit" name="Submit" value="Save"></td>
	<td align="center" colspan="2"><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Administration.php'"></td>
  </tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
