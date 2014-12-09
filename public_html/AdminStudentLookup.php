<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Student Lookup</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form  method="post" name="StudentLookup" action="AdminStudentListMatches.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" background="img/lightbrown.jpg">
	<tr align="left" valign="top"> 
		<td> 
		 <br><h2>FestivalWare Administration Student Lookup Page</h2>
			 			
			<?php if (isset($_SESSION['StudentID'])) session_unregister("StudentID");?>
			<?php if (isset($_SESSION['StudentName'])) session_unregister("StudentName");?>
			
	<p> 
	  <font size="+1">Enter as much information as you have. <br>
		The more information, the better the chance of finding the right student.
	  </font> 
	</p>
	<p><font size="+1">Select a Studio: </font> 
		<select name="SelStudio" title="Select Studio">
						<option value="-1">Select a Studio</option>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM Studios";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{
		print "<option value=\"$row[StudioID]\">$row[StudioName] ($row[StudioFirstName] $row[StudioLastName])</option>";
	}	
?>
	</select>
	</p>
	<p><font size="+1">Student Number: </font> 
	  <input maxlength="6" size="8" name="StudentID" description="Student Number"/>
	</p>
	<p><font size="+1">Student's First Name: </font> 
	  <input maxlength="30" size="30" name="FirstName" description="First Name"/>
	</p>
	<p><font size="+1">Student's Middle Name: </font> 
	  <input  maxlength="30" size="30" name="MiddleName" description="Middle Name"/>
	</p>
	<p><font size="+1">Student's Last Name: </font> 
	  <input  maxlength="50" size="30" name="LastName" description="Last Name"/>
	  <br>
	</p>
	<p align="center"> 
	  <font size="+1">Click here to find student(s) that match your selections: </font><br>
	  <input name="submit" type="submit" value="Look up students"/> 
	</p>         
		</td>
        </tr>
      </table>
	  </form>
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
