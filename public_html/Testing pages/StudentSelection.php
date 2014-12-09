<?php include("../IsAuth_Studio.php");?>
<!-- This page is part of the Junior Festival Website
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Demo Festival Student Selection</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="../RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<font face="Arial, Helvetica, sans-serif" size="+1">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
    <td width=200 valign="top" background="../img/cellbg19133.gif"><!--#include virtual="/Navigation.shtml" --></td>
    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr align="right" valign="top"> 
          <td><img src="../img/compname1.jpg" width="572" height="49" name="im1"></td>
        </tr>
        <tr align="left" valign="top"> 
          <td background="../img/smblue_paper.gif"> <br>
            <font size="5" face="Verdana, Arial, Helvetica, sans-serif"> <br>
            <br>
			<p align="center"><font face="Georgia, Times New Roman, Times, serif" size="4"> 
			  <strong>Student Registration Page <br />
				for DMTA FestivalWare 2004</strong></font></p>

			<p><font size="+1" style="bold">You are currently logged in as: 
				<?php print $_SESSION["studioName"]; ?> 
			  </font> </p>
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
            <br>
            <br>
            </font> </td>
        </tr>
      </table> 
	</td>
  </tr>
  <tr>
    <td valign="top" background="../img/cellbg19133.gif">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>	

</font>
</body>
</html>
