<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Class Selection</title>
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
	$database = $_SESSION['DatabaseName'];
	
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "select * from Events where EventID = $_POST[reqSelEvent]";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	$eventRow = mysql_fetch_array($result);
	$_SESSION['EventName'] = $eventRow['EventName'];
	$_SESSION['Participants'] = $eventRow['Participants']; //how many in this group?

	$sql = "select ClassDescription, Classes.ClassID from Classes, Events_Classes where EventID = " . $_SESSION['EventID'] . " and Classes.ClassID = Events_Classes.ClassID";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());

?>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
        <tr align="left" valign="top"> 
          <td> <br>
			<h2>Performance Registration - Class Selection Page </h2>
            <font style="bold" size="+2">
			  You are entering information for event : 
			  <font color="#008000"><?php print $eventRow['EventName']; ?>
			</font></font>

	<form method="post" name ="EventSelection" onSubmit="return checkReqEntries(this)" action="PerfPieceSelect.php">
	Select the Class for this event: 
	<select name="reqSelClass" title="Select a Class">
	<option value="-1">Please select a class for this event</option>
<?php
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"$row[ClassID]\"> " . $row['ClassDescription'] . "</option>";
	}
	mysql_close($selconn);
?>
	</select>
	<p> Note: if your class selection isn't listed, please contact your Festival Organizer! </p>  
	<font size="+1">
	<table width="100%" border="1">
	  <tr> 
		<td width="44%" align="center">Click below to enter selections or register for Musicianship	</td>
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
</form>
</td>
</tr>
</table> 

<?php include('../php/TableEnd.php'); ?>
</body>
</html>
