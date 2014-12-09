<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Room Administration</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="frmAddRoom" onSubmit="return checkReqEntries(this)" action="RoomAddToDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr align="left" valign="top">
	<td width="50%">&nbsp;</td><td width="50%">&nbsp;</td>
	</tr>
	 
	 <tr><td colspan="2" align="center"> <h2>Add, Change, or Delete Festival Rooms</h2></td></tr>
	<tr>
	  <td colspan="2" align="center">&nbsp;</td>
	</tr>
	<tr><td align="center" colspan="2"><h3>Existing Rooms</h3></td></td></tr>
	<tr><td align="center" colspan="2">&nbsp;</td></td></tr>

<?php
	$database = $_SESSION['DatabaseName'];
	$festivalID = $_SESSION['FestivalID'];

	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM Festival_Rooms WHERE FestivalID = $festivalID";
	$festRowsResult = mysql_query($sql, $selconn) or die(mysql_error());
		
	// print existing rooms
	while($row = mysql_fetch_array($festRowsResult))
	{
		print "<tr><td align=\"center\">$row[RoomDescription]</td><td><input type=\"button\" name=\"btnChange\" value=\"Change\" onClick=\"location='RoomChange.php?roomid=$row[RoomID]'\"><input type=\"button\" name=\"btnDelete\" value=\"Delete\" onClick=\"location='RoomDelete.php?roomid=$row[RoomID]'\"></td></tr>";
	}

?>
		
	</tr>
	<tr><td align="center" colspan="2">&nbsp;</td></td></tr>
	<tr><td align="center" colspan="2">Enter new room description: <input type="text" name="txtRoomDescr" maxlength="50" size="40"></td></tr>
	<tr>
	  <td align="center" colspan="2">Hint: If your festival is being held in more than one location, <br>
	    include the location's building name or number with the room description<br>
		<br></td></td></tr>
  <tr> 
	<td align="center"><input type="submit" name="Submit" value="Save"></td>
	<td align="center"><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Administration.php'"></td>
  </tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
