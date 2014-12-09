<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Student Selection</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr align="left" valign="top"> 
	  <td background="img/smblue_paper.gif"> <br>
		<h2>Student Registration Page</h2>

 <?php
				
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "select StudentFirstName, StudentMiddleName, StudentLastName, studentID from Students where 
			StudioID = $_SESSION[studioID]";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	echo "\n<select name=\"MyStudents\" onSelect=\"return GetStudent(MyStudents.value)\">";
	while($row = mysql_fetch_array($result))
	{
		$fullName = $row['studentID'] . ":" . $row['StudentFirstName'] . " " . $row['StudentMiddleName'] . " " . $row['StudentLastName'];
		echo "\n\t<option> $fullName";
	}
	echo "\n</select>";
	

	mysql_close($selconn);
?>
 </td> </tr>
</table>	
<?php include('../php/TableEnd.php'); ?>

</body>
</html>
