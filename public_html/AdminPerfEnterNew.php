<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Performance Entry</title>
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
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
?>

	<form method="post" name ="EventSelection" onSubmit="return checkReqEntries(this)" action="AdminPerfClassSelect.php">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
        <tr align="left" valign="top"> 
          <td colspan="2" align="center"> <h2>Performance Registration </h2></td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td align="right"> Select A Studio:</td>
	 <td align="left">
	    <select name="reqSelStudio" title="Select Studio">
	        <option value="-1">Please Select a Studio</option>
<?php

	$sql = "SELECT * FROM Studios";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$name = $row['StudioName'] . " (" . $row['StudioFirstName'] . " " . $row['StudioLastName'] . ")";
		$ID = $row['StudioID'];
		echo "\n\t<option value=\"$ID\"> " . $name . "</option>";
	}
?>
	</select></td></tr>

<?php

	$sql = "select EventList FROM Festivals WHERE FestivalID='$_SESSION[FestivalID]'";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	if($row['EventList'] == "")
	{
		print "<tr><td colspan=\"2\">Your Festival Organizer hasn't selected any Events for this festival. Select Events first, then come back to enter Performances. </td></tr>";
        print "<tr><td><input type=\"button\" name=\"btnAdmin\" value=\"Back to Administration\" onClick=\"window.location='Administration.php'\"></td></tr>";
	}
	else
	{
		$festivalEventsArray = explode(":", $row['EventList']);
?>

	<tr><td colspan="2">&nbsp;</td></tr>

	<tr><td align="right">  Select the Event for this performance:</td>
	<td align="left">
	    <select name="reqSelEvent" title="Select Event">
	        <option value="-1">Please Select an Event</option>
<?php

	foreach ($festivalEventsArray as $key => $value )
	{
		$ID = $value;
		$sql = "SELECT * FROM Events WHERE EventID='$ID'";
		$result= mysql_query($sql, $selconn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		
		echo "<option value=\"$ID\"> " . $row['EventName'] . "</option>";
	}
	mysql_close($selconn);
?>
    </select>

	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>

	  <tr> 
		<td align="center"> Click below to select the class for this event</td>
		<td align="center">Click below to go back to the Administration Page</td>
	  </tr>
	  <tr> 
		<td align="center"><input type="submit" name="ClassSelection" value="Go to Next Step"></td>
		<td align="center"><input type="button" name="btnAdmin" value="Back to Administration" onClick="window.location='Administration.php'"></td>
	  </tr>
<?php 
} // end else section
?>
     </table>

</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
