<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Delete Room Break Information</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="frmChangeRoomInfo" onSubmit="return checkReqEntries(this)" action="Room_BreaksDeleteFromDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr align="left" valign="top">
	<td width="50%">&nbsp;</td><td width="50%">&nbsp;</td>
	</tr>
	 <tr><td colspan="2" align="center"> <h2>Delete Break Information </h2></td></tr>
  <tr> 
	<td align="center" colspan="2">&nbsp;</td>
  </tr>	<tr>
<?php
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];

	// GET and sanitize the room ID 
	$breakID = $_GET['roombreakid'];
	
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT RoomDescription, BreakDescription, StartTime, EndTime 
			FROM Festival_Rooms, RoomBreaks WHERE RoomBreakID='$breakID' 
			AND Festival_Rooms.RoomID=RoomBreaks.RoomID";
	$result = mysql_query($sql, $selconn) or die(mysql_error());	
	$row = mysql_fetch_array($result);
?>
	<td colspan="2" align="center">Are you sure you want to remove the break 
		<?php 
			if( $row['BreakDescription'] == "") 
			{	print "(no break description)"; }
			else
			{	print "($row[BreakDescription])"; }
	 	?>
		<br>in room <font color="#0066FF"> <?php 	print $row['RoomDescription']; ?> </font>
		<br>starting at <strong><?php print $row['StartTime']; ?></strong> 
		<br>and ending at <strong><?php print $row['EndTime']; ?></strong> 
		<br>from this festival?
	</td></tr>
	<tr><td colspan="2"><input type="hidden" name="hdnBreakID" value="<?php print $breakID; ?>"></td></tr>
  <tr> 
	<td align="center" ><input type="submit" name="Submit" value="Delete Break"></td>
	<td align="center" ><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Room_BreaksMain.php'"></td>
  </tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
