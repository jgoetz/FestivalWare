<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Lookup Students</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" background="img/lightbrown.jpg">
	<tr align="left" valign="top"> 
	  <td> 
		<h2>Performance Selection Page</h2>
      </td></tr>
	  <tr><td>
<?php		
	// first, unset the student ID session variable
	// need to do this here, because it wasn't working just before
	// registering the new selection from the select list for multiple
	// students returned from the database
	if(isset($_SESSION['StudentID']))
		session_unregister("StudentID");
	if(isset($_SESSION['StudentName']))
		session_unregister("StudentName");
	
		$database = $_SESSION['DatabaseName'];
				
		$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
		mysql_select_db($database, $selconn) or die(mysql_error());
	
	$sql = "SELECT StudentFirstName, StudentLastName, StudentMiddleName, EventName, HistoryID FROM History, Students, Events " .
			" WHERE History.FestivalID='$_SESSION[FestivalID]' AND History.StudentID=Students.StudentID " .
			" AND History.EventID=Events.EventID AND History.StudioID = " .$_SESSION['StudioID'];
	$where = "";
	// determine what belongs in the where clause
	$FNnotEmpty = strlen(trim($_POST['txtFirstName']) ) > 0;
	$MNnotEmpty = strlen(trim($_POST['txtMiddleName']) ) > 0;
	$LNnotEmpty = strlen(trim($_POST['txtLastName']) ) > 0; 
	$EventNotEmpty = ($_POST['selEventList']) != -1;
	if($FNnotEmpty)
		$where .= " AND StudentFirstName LIKE '" . $_POST['FirstName'] . "%'";

	if($MNnotEmpty)
		$where .= " AND StudentMiddleName LIKE '" . $_POST['MiddleName'] . "%'";

	if($LNnotEmpty)
		$where .= " AND StudentLastName LIKE '" . $_POST['LastName'] . "%'";

	if($EventNotEmpty)
		$where .= " AND History.EventID = " . $_POST['selEventList'];

	$sql .= $where; 

	$soloresult = mysql_query ($sql, $selconn) or die(mysql_error());
	
	
	// if row count = 0 then no records found
	//		display msg, button to go back to choice page
	if(mysql_num_rows($soloresult) == 0)
	{
		print " <br><br>Sorry, no performances found that match your choices. Please try again!<br><br>";
		echo "<p align=\"center\">";
		echo "<input name=\"BackToLookup\" type=\"button\"  onClick=\"window.location='PerfLookup.php'\" value=\"Back to Lookup Page\">";
		echo "<input name=\"StartOver\" type=\"button\"  onClick=\"window.location='StudioAdmin.php'\" value=\"Back to Studio Administration page\">";
		echo "</p>";
	}
	else{
		// if count of rows >= 1 then display select drop-down
		echo "<form method=\"post\" name =\"frmChoosePerf\"  onSubmit=\"return checkReqEntries(this)\" action=\"PerfReviewInfo.php\">";
		echo "\n<select name=\"reqSelChoosePerf\" title=\"Choose Performance\">";
		echo "\n\t<option value=\"-1\">Please Select a Performance</option>";
		while($row = mysql_fetch_array($soloresult))
		{
			$firstname = $row['StudentFirstName'];
			$midname = $row['StudentMiddleName'];
			$lastname = $row['StudentLastName'];
			$event = $row['EventName'];
			$selectLine = $event . ":" . $firstname . " " . $midname . " " . $lastname;
			$ID = $row['HistoryID'];
			echo "\n\t<option value=\"$ID\"> " . $selectLine . "</option>";
		}
		
		echo "\n</select><br><br><br>";
		echo "<table width=\"100%\" border=\"1\">";
		echo "<tr><td width=\"44%\"> <div align=\"center\"> <font size=\"+1\">Click below to review the information for this performance</font></div></td>";
		echo "<td width=\"12%\">&nbsp;</td><td width=\"44%\"> <div align=\"center\"> <font size=\"+1\">";
		echo "Click below to go back to the Studio Administration Page </font> </div></td>";
		echo "</tr><tr><td> <div align=\"center\"> <font size=\"+1\" face=\"Verdana, Arial, Helvetica, sans-serif\">"; 
		echo "<input name=\"submit\" type=\"submit\" value=\"Review this Information\"/>";
		echo "</font> </div></td><td></td><td> <div align=\"center\">"; 
		echo "<input type=\"button\" name=\"btnStudioAdmin\" value=\"Back to Studio Administration\" onClick=\"window.location='StudioAdmin.php'\">";
		echo "</div></td></tr></table>";
		echo "\n</form>";
	}
	mysql_close($selconn);	
?>
		</td>
        </tr>
      </table> 
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
