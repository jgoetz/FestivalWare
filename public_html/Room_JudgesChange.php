<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Change Room Break Information</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="frmChangeRoomInfo" onSubmit="return checkReqEntries(this)" action="Room_BreaksUpdateDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr align="left" valign="top">
	<td width="50%">&nbsp;</td><td width="50%">&nbsp;</td>
	</tr>
	 <tr><td colspan="2" align="center"> <h2>Change Break Information </h2></td></tr>
  <tr> 
	<td align="center" colspan="2">&nbsp;</td>
  </tr>	
<?php
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];

	// GET and sanitize the room ID 
	$breakID = $_GET['roombreakid'];

	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM RoomBreaks WHERE RoomBreakID='$breakID'";
	$result = mysql_query($sql, $selconn) or die(mysql_error());	
	$row = mysql_fetch_array($result);
?>

<tr><td colspan="2"><input type="hidden" name="hdnBreakID" value="<?php print $breakID; ?>"></td></tr>
<tr><td colspan="2"  align="center">Enter new break description: 
	<input type="text" maxlength="40" size="40" name="txtBreakDescr" value="<?php print $row['BreakDescription']; ?>"></td></tr>
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
	<td align="center" ><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Room_BreaksMain.php'"></td>
</tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
