<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Change Room Usage Information</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="frmChangeRoomInfo" onSubmit="return checkReqEntries(this)" action="Room_UseUpdateDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr align="left" valign="top">
	<td width="50%">&nbsp;</td><td width="50%">&nbsp;</td>
	</tr>
	 <tr><td colspan="2" align="center"> <h2>Change Room Usage Information </h2></td></tr>
  <tr> 
	<td align="center" colspan="2">&nbsp;</td>
  </tr>	
<?php
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];

	// GET and sanitize the room ID 
	$useID = $_GET['roomuseid'];

	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM RoomUse WHERE RoomUseID='$useID'";
	$result = mysql_query($sql, $selconn) or die(mysql_error());	
	$row = mysql_fetch_array($result);

	$sql = "SELECT * FROM Festival_Rooms WHERE FestivalID = $festivalID";
	$roomsResult = mysql_query($sql, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM Festival_PerfLevels, SkillLevels WHERE FestivalID = $festivalID AND PerfLevelID=SkillLevelID";
	$skillsResult = mysql_query($sql, $selconn) or die(mysql_error());
	while($skillsRow = mysql_fetch_array($skillsResult))
	{
		$skillsArray [$skillsRow['SkillLevelID']] = $skillsRow['SkillDescription'];
	}
?>

<tr><td colspan="2"><input type="hidden" name="hdnUseID" value="<?php print $useID; ?>"></td></tr>
<tr><td colspan="2"  align="center">Enter new room: 
<select name="reqSelRoom" title="Select Room">
		    <option value="-1">Select a room</option>
            <?php
				while($roomRow = mysql_fetch_array($roomsResult))
				{
					print "<option value=\"$roomRow[RoomID]\"";
					if($roomRow['RoomID'] == $row['RoomID'])
					print " selected> $roomRow[RoomDescription]</option>";
					else
						print "> $roomRow[RoomDescription]</option>";
				}
			?>
          </select><tr><td colspan="2"  align="center">Enter new description: 
	<input type="text" maxlength="50" size="50" name="txtUseDescr" value="<?php print $row['UseDescription']; ?>"></td></tr>
<tr><td colspan="2"  align="center">Enter new minimum skill level: 
	<select name="reqSelMinSkill" title="Set Min. Skill">
			  <option value="-1">Set min skill level</option>
              <?php
				foreach ($skillsArray as $level => $descr)
				{
					print "<option value=\"$level\"";
					if($level == $row['MinSkill'])
						print " selected> $descr</option>";
					else
						print "> $descr</option>";
				}
			?>
            </select></td></tr>
<tr><td colspan="2"  align="center">Enter new maximum skill level: 
	<select name="reqSelMaxSkill" title="Set Max. Skill">
			  <option value="-1">Set max skill level</option>
              <?php
				foreach ($skillsArray as $level => $descr)
				{
					print "<option value=\"$level\"";
					if($level == $row['MaxSkill'])
						print " selected> $descr</option>";
					else
						print "> $descr</option>";
				}
			?>
            </select></td></tr>

<tr><td colspan="2" align="center">Enter new start time: <select name="reqSelStartHour">
<?php
	$times = array('6 AM','7 AM','8 AM','9 AM','10 AM','11 AM','12 PM','1 PM','2 PM','3 PM','4 PM','5 PM','6 PM','7 PM','8 PM','9 PM','10 PM');
	$minutes = array(0,15,30,45);
	$startTime = explode(":", $row['StartTime']);
	$endTime = explode(":",$row['EndTime']);
	for($i=6; $i <= 22; $i++)
	{
		print "<option value=\"$i\"";
		if ($startTime[0] == $i) { print "selected"; }
		$temp = $i -6;
		print ">$times[$temp]</option>";
	}
?>								</select>:
								<select name="reqSelStartMins">
<?php
	for($i = 0; $i < 4; $i++)
	{
		print "<option value=\"$minutes[$i]\"";
		if ($startTime[1] == $minutes[$i]) { print "selected"; }
		print ">$minutes[$i]</option>";
	}
?>
								</select></td></tr>
<tr><td colspan="2" align="center">Enter new end time:<select name="reqSelEndHour">
<?php
	for($i=6; $i <= 22; $i++)
	{
		print "<option value=\"$i\"";
		if ($endTime[0] == $i) { print "selected"; }
		$temp = $i - 6;
		print ">$times[$temp]</option>";
	}
?>
								</select>:
								<select name="reqSelEndMins">
<?php
	for($i = 0; $i < 4; $i++)
	{
		print "<option value=\"$minutes[$i]\"";
		if ($endTime[1] == $minutes[$i]) { print "selected"; }
		print ">$minutes[$i]</option>";
	}
?>
								</select> </td></tr>

<tr> 
	<td align="center" ><input type="submit" name="Submit" value="Save"></td>
	<td align="center" ><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Room_UseMain.php'"></td>
</tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
