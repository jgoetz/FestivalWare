<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Lookup Page</title>
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
            <td> 
			  <br>
              <h2>Performance Lookup Page</h2>
<?php if (isset($_SESSION['HistoryID'])) session_unregister("HistoryID");?>
			
  <form  method="post" name="frmPerformanceLookup"  action="PerfListAllMatches.php">
	<p> <font size="+1">Enter as much information as you have. <br>
	  The more information, the better the chance of finding the right 
	  performance.<br>
	  To get a list of all your students' performances, leave everything 
	  blank. </font></p>
	<p><font size="+1">Student's First Name: </font> 
	  <input maxlength="30" size="30" name="txtFirstName" description="First Name"/>
	</p>
	<p><font size="+1">Student's Middle Name: </font> 
	  <input  maxlength="30" size="30" name="txtMiddleName" description="Middle Name"/>
	</p>
	<p><font size="+1">Student's Last Name: </font> 
      <input  maxlength="50" size="30" name="txtLastName" description="Last Name"/>
    </p>
    <p><font size="+1">Event: </font> 
      <select name="selEventList" size="1">
      <option value="-1">Please Select Event (if known)</option>
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
	mysql_close($selconn);	
?>
	    </select>
	    <br>
	  </p>
	<p align="center"> 
	  <font size="+1">Click here to find performances that match your selections: </font><br>
	  <input name="submit" type="submit" value="Look up Performances"/> 
	</p>
</form>         
		</td>
        </tr>
      </table>
<?php include('../php/TableEnd.php'); ?>

</body>

</html>
