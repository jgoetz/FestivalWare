<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Delete Room Use Information</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="frmChangeRoomUseInfo" onSubmit="return checkReqEntries(this)" action="Room_UseDeleteFromDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr align="left" valign="top">
	<td width="50%">&nbsp;</td><td width="50%">&nbsp;</td>
	</tr>
	 <tr><td colspan="2" align="center"> <h2>Delete Room Use Information </h2></td></tr>
  <tr> 
	<td align="center" colspan="2">&nbsp;</td>
  </tr>	<tr>
<?php
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];

	// GET and sanitize the room ID 
	$useID = $_GET['roomuseid'];
	
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT RoomDescription, UseDescription, StartTime, EndTime 
			FROM Festival_Rooms, RoomUse WHERE RoomUseID='$useID' 
			AND Festival_Rooms.RoomID=RoomUse.RoomID";
	$result = mysql_query($sql, $selconn) or die(mysql_error());	
	$row = mysql_fetch_array($result);
?>
	<td colspan="2" align="center">Are you sure you want to remove the entry 
		<?php 
			if( $row['UseDescription'] == "") 
			{	print "(no usage description)"; }
			else
			{	print "($row[UseDescription])"; }
	 	?>
		<br>for room <font color="#0066FF"> <?php 	print $row['RoomDescription']; ?> </font>
		<br>starting at <strong><?php print $row['StartTime']; ?></strong> 
		<br>and ending at <strong><?php print $row['EndTime']; ?></strong> 
		<br>from this festival?
	</td></tr>
	<tr><td colspan="2"><input type="hidden" name="hdnRoomUseID" value="<?php print $useID; ?>"></td></tr>
  <tr> 
	<td align="center" ><input type="submit" name="Submit" value="Delete Entry"></td>
	<td align="center" ><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Room_UseMain.php'"></td>
  </tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
