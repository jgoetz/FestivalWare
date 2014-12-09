<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Performance Class Selection</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js">
</script>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<?php
	$_SESSION['EventID'] = $_POST['reqSelEvent'];
	$_SESSION['StudioID'] = $_POST['reqSelStudio'];
	
	$database = $_SESSION['DatabaseName'];
	
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "select * from Events where EventID = $_SESSION[EventID]";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	$eventRow = mysql_fetch_array($result);
	$_SESSION['EventName'] = $eventRow['EventName'];
	$_SESSION['Participants'] = $eventRow['Participants']; 

	$sql = "select * from Studios where StudioID = $_SESSION[StudioID]";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	$studioRow = mysql_fetch_array($result);
	$_SESSION['StudioName'] = $studioRow['StudioName'];	
?>
	<form method="post" name ="ClassSelection" onSubmit="return checkReqEntries(this)" action="AdminPerfPieceSelect.php">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
        <tr align="left" valign="top"> <td colspan="2" align="center">&nbsp; </td></tr> 
		<tr><td colspan="2" align="center"><h2>Performance Registration - Class Selection Page </h2></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
         <tr><td colspan="2" align="center">	<font style="bold" size="+2">
			  You are entering information for Studio 
			  <font color="#008000"><?php print $_SESSION['StudioName']; ?>	</font></font> 
		</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
       <tr><td colspan="2" align="center">	<font style="bold" size="+2">
			  You are entering information for event : 
			  <font color="#008000"><?php print $eventRow['EventName']; ?>
			</font></font>
		</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td align="right">Select the Class for this event: </td>
	<td align="left"><select name="reqSelClass" title="Select a Class">
	<option value="-1">Please select a class for this event</option>
<?php
	$sql = "select ClassDescription, Classes.ClassID from Classes, Events_Classes where EventID = " . $_SESSION['EventID'] . " and Classes.ClassID = Events_Classes.ClassID";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());

	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"$row[ClassID]\"> " . $row['ClassDescription'] . "</option>";
	}
	mysql_close($selconn);
?>
	</select></td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">
	<font size="+1">
	<table width="100%" border="1">
	  <tr> 
		<td width="44%" align="center">Click below to go to the next step</td>
		<td width="12%">&nbsp;</td>
		<td width="44%" align="center">Click below to go back to the Studio Administration Page</td>
	  </tr>
	  <tr> 
		<td align="center"><input name="btnEnterSelections" type="submit" id="btnEnterSelections" value="Go to Next Step" ></td>
		<td>&nbsp; </td>
		<td align="center"> <input name="btnStudioAdmin" type="button" id="btnStudioAdmin" onClick="window.location='StudioAdmin.php'" value="Back to Studio Administration"></td>
	  </tr>
	</table>
	</font>
	</td></tr>
</table> 
</form>

<?php include('../php/TableEnd.php'); ?>
</body>
</html>
