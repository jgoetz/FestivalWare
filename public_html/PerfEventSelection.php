<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Event Selection</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
        <tr align="left" valign="top"> 
          <td> <br>			
			<h2>Performance Registration - Event Selection Page </h2>

	<form method="post" name ="EventSelection" onSubmit="return checkReqEntries(this)" action="PerfClassSelection.php">
	  <p>Select the Event for this performance:
	    <select name="reqSelEvent" title="Select Event">
	        <option value="-1">Please Select an Event</option>
            <?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "select EventID, EventName from Events where EventOn = 'Y'";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$name = $row['EventName'];
		$ID = $row['EventID'];
		echo "\n\t<option value=\"$ID\"> " . $name . "</option>";
	}
?>
	        </select>
    <?php
	mysql_close($selconn);
?>
            </p>
	  <p> Note: if your event isn't listed, please contact your Festival Organizer!</p>  
            <table width="100%" border="1">
              <tr> 
                <td width="44%" align="center"> Click below to select the class
                  for this event</td>
                <td width="12%">&nbsp;</td>
                <td width="44%">Click below to go back to the Studio Administration Page</td>
              </tr>
              <tr> 
                <td align="center"><input type="submit" name="ClassSelection" value="Go to Next Step"></td>
                <td>&nbsp; </td>
                <td align="center"><input type="button" name="btnStudioAdmin" value="Back to Studio Administration" onClick="window.location='StudioAdmin.php'"></td>
              </tr>
            </table></form>
</table>
<?php include('../php/TableEnd.php'); ?>

</body>
</html>
