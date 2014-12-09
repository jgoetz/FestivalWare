<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Student Lookup Results</title>
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
            <h2>Student Lookup Results </h2>
            <table width="80%" border="0">
              <tr> 
                <td><font size="+2">The pulldown list below contains students registered to your studio ONLY.</font></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><font size="+1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Find 
                  and select the student you are registering from the list of 
                  students below, then click <font color="#0000FF">Verify Student 
                  Information</font>. </strong></font></td>
              </tr>
            </table>
		</td></tr>
		<tr><td>
<?php		
	// first, unset the student ID session variable
	// need to do this here, because it wasn't working just before
	// registering the new selection from the select list for multiple
	// students returned from the database
	if(isset($_SESSION['StudentID']))
		unset($_SESSION['StudentID']);
	if(isset($_SESSION['StudentName']))
		unset($_SESSION['StudentName']);
		
	$FNameTrim = trim($_POST['FirstName']);
	$MNameTrim = trim($_POST['MiddleName']);
	$LNameTrim = trim($_POST['LastName']);
								
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT StudentFirstName, StudentMiddleName, StudentLastName, " .
		"Birthdate, StudentID, StudioName, StudentStudioID FROM Studios, Students WHERE ";
	$where = "(StudentStudioID = -1 or StudentStudioID = $_SESSION[StudioID]) AND StudentStudioID = Studios.StudioID "; 
	$FNnotEmpty = strlen($FNameTrim ) > 0;
	$MNnotEmpty = strlen($MNameTrim ) > 0;
	$LNnotEmpty = strlen($LNameTrim ) > 0;
	if($FNnotEmpty)
	{
		$where .= " AND StudentFirstName LIKE '$FNameTrim%'";
	}
	if($MNnotEmpty)
	{
		$where .= " AND StudentMiddleName LIKE '$MNameTrim%'";
	}
	if($LNnotEmpty)
	{
		$where .= " AND StudentLastName LIKE '$LNameTrim%'";
	}
	$sql .= $where . " ORDER BY StudentStudioID DESC, StudentLastName ASC"; 

	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	// if row count = 0 then no records found
	//		display msg, button to go back to choice page
	if(mysql_num_rows($result) == 0)
	{
		print " <br><br>Sorry, no students found that match your choices. Please try again!<br><br>";
		echo "<p align=\"center\">";
		echo "<input name=\"BackToLookup\" type=\"button\"  onClick=\"window.location='StudentLookup.php'\" value=\"Back to Lookup Page\">";
		echo "<input name=\"btnStudioAdmin\" type=\"button\"  onClick=\"window.location='StudioAdmin.php'\" value=\"Back to Studio Administration Page\">";
		echo "</p>";
	}
	else{
		// if count of rows > 1 then display select drop-down
		// 		on submit go to studentReg page (so teacher can modify data)
		echo "<form method=\"post\" name =\"frmChooseStudent\"  action=\"StudentChangeInfo.php\" onSubmit=\"return checkReqEntries(this)\">";
		echo "\n<select name=\"reqSelChooseStudent\" id=\"ChooseStudent\">";
		echo "\n\t<option value=\"-1\">Please Select a student</option>";
		while($row = mysql_fetch_array($result))
		{
			$firstname = $row['StudentFirstName'];
			$midname = $row['StudentMiddleName'];
			$lastname = $row['StudentLastName'];
			$birthdate = $row['Birthdate'];
			$studioname = $row['StudioName'];
			if(strlen($birthdate) > 0)
			{
				$pattern = "/(\d{4})-(\d{1,2})-(\d{1,2})/";
				$replace = "\$2-\$3-\$1";
				$birthdate = preg_replace($pattern, $replace, $birthdate);
			}
			else
			{
				$birthdate = "no birthdate";
			}
			$selectLine = $firstname . " " . $midname . " " . $lastname . " (" . $birthdate . ")";
			$ID = $row['StudentID'];
			echo "\n\t<option value=\"$ID\"> " . $selectLine . "</option>";
		}
		echo "\n</select><br><br><br>";
		echo "<table width=\"80%\" border=\"1\">";
		echo "<tr><td width=\"44%\"> <div align=\"center\"> <font size=\"+1\">Click below to go to the next step</font></div></td>";
		echo "<td width=\"12%\">&nbsp;</td><td width=\"44%\"> <div align=\"center\"> <font size=\"+1\">";
		echo "Click below to go back to the Studio Administration Page </font> </div></td>";
		echo "</tr><tr><td> <div align=\"center\"> <font size=\"+1\" face=\"Verdana, Arial, Helvetica, sans-serif\">"; 
		echo "<input name=\"submit\" type=\"submit\" value=\"Verify Student Information\"/>";
		echo "</font> </div></td><td></td><td> <div align=\"center\">"; 
		echo "<input type=\"button\" name=\"btnStudioAdmin\" value=\"Back to Studio Administration Page\" onClick=\"window.location='StudioAdmin.php'\">";
		echo "</div></td></tr></table></form>";
	}
mysql_close($selconn);	
?>
		 </td>
        </tr>
      </table> 
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
