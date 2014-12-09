<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Student Registration Results</title>
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
<?php				
	$studentFullName = ucwords($_POST["reqFirstName"]) . " " 
						. ucwords($_POST["optMiddleName"]) . " " 
						. ucwords($_POST["reqLastName"]);
						
	function ExitStatement($strError, $fullName)
	{
		$strNameError = "<br><br> Student $fullName is already registered.";
		$strLookupError = "<br><br> Student $fullName may already be registered by another studio. Please contact the festival organizer to clear up this problem.";
		$strGenericError = $strError . "<br><br> This is a generic error. Please contact the website administrator with the details of your error.";
		
		$pos = strpos ($strError, "key 2");
		if (!( $pos === false ))
			return $strNameError;
		$pos = strpos($strError, "Lookup match");
		if (!( $pos === false ))
			return $strLookupError;
		return $strGenericError;	
	}
	if(isset($_SESSION['StudentID']))
		session_unregister("StudentID");
	if(isset($_SESSION['StudentName']))
		session_unregister("StudentName");

	$database = $_SESSION['DatabaseName'];

	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());

	// test if student already exists in database
	// OK , what are the chances that the lastname and the first THREE characters
	//  of the firstname will match and the names NOT be the same? Well, it happened, so 
	// I added birthdate as a search function too.  
	$birthdate = $_POST['reqBirthdate'];
	$pattern = "/(\d{1,2})-(\d{1,2})-(\d{4})/";
	$replace = "\$3-\$1-\$2";
	$birthdate = preg_replace($pattern, $replace, $birthdate);
	$subFirstName = substr($_POST['reqFirstName'], 0, 3); 
	$sql = "Select * FROM Students WHERE StudentLastName = '$_POST[reqLastName]' AND StudentFirstName LIKE '$subFirstName%' AND Birthdate = '$birthdate'";

	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	if(mysql_num_rows($result) > 0) {
		$row = mysql_fetch_array($result);

		$sql = "SELECT * FROM Studios WHERE StudioID = $row[StudentStudioID]";
		$result = mysql_query($sql, $selconn) or die(mysql_error());
		$studioRow = mysql_fetch_array($result);
		
		print "<h3 align=\"center\"><font color=\"#FF00FF\">";
		print "<br>$studentFullName is already entered";
		print "<br>for Studio $studioRow[StudioName] ($studioRow[StudioFirstName] $studioRow[StudioLastName]).";
		print "<br>Use <em>Reassign Student</em> to tranfer the student to another studio.";
		print "<br><input name=\"btnGoBack\" type=\"button\"  onClick=\"window.location='Administration.php'\" value=\"Back to Festival Administration\">";
		print "</font></h3><br></td></tr>";
	}
	else {
	// if rowcount is 0, continue
	$sql = "insert into Students values (
			'', now(),'" . 
			ucwords(addslashes($_POST['reqFirstName'])) . "','" . 
			ucwords(addslashes($_POST['optMiddleName'])) . "','" .
			ucwords(addslashes($_POST['reqLastName'])) . "','" . 
			addslashes($_POST['optStudentEmail']) . "','" .
			$_POST['reqSelStudio'] . "','" . 
			ucwords(addslashes($_POST['reqStreetAddress'])) . "','" .
			ucwords(addslashes($_POST['reqCity'])) . "','" .
			ucwords(addslashes($_POST['reqState'])) . "','" .
			addslashes($_POST['reqZip']) . "','" . 
			addslashes($_POST['reqPhoneNumber']) . "','" . 
			$birthdate . "','" .
			ucwords(addslashes($_POST['reqParentsName'])) . "','" .
			addslashes($_POST['reqParentsPhone']) . "','" . 
			$_POST['rdoMonitor'] . "')";

	$result = mysql_query ($sql, $addconn) or die(ExitStatement(mysql_error(), $studentFullName));
	mysql_close($addconn);
	mysql_close($selconn);
	
	print "<p align=\"center\"><font size=\"+1\">You have successfully ADDED $studentFullName.<br>";
	print "We will send a confirmation email to the <br>";
	print "email address you provided. If you don't <br>";
	print "get your confirmation within 24 hours, please <br>";
	print "contact us.</font></p></td></tr>";
	
	$recipient = $_SESSION['AuthUserEmail'];
	
	$subject = "Festival Student ADDITION completed for " . $studentFullName;
	$mailheaders = "From: registrar (registrar@festivalware.net)\n";
	$mailheaders .= "Reply-to: $recipient";
	$msg = "Thank you $_SESSION[AuthUserName] for registering $studentFullName. \n";
	$msg .= "The following information was recorded in our database for you.\n";
	$msg .= "If this information isn't correct please contact your festival organizer!\n\n";
	$msg .= "\tStudent's first name = $_POST[reqFirstName]\n";
	$msg .= "\tStudent's middle name = $_POST[optMiddleName]\n";
	$msg .= "\tStudent's last name = $_POST[reqLastName]\n";
	$msg .= "\tStudent's street address is: $_POST[reqStreetAddress]\n";
	$msg .= "\tStudent's birthdate is: $_POST[reqBirthdate]\n";
	$msg .= "\tStudent's phone number is: $_POST[reqPhoneNumber]\n";
	$msg .= "\tParent's name is: $_POST[reqParentsName]\n";
	$msg .= "\tParent's phone number is: $_POST[reqParentsPhone]\n";

	mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to responder");

	//$recipient = "bessettec@cox.net";
	//$msg .= "\n\n\n\tVerification sent to $_SESSION[StudioEmail]";

	//mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to organizer");

	// OK, why am I getting the studentID from the database? 
	 //commenting out this next section until I figure out what I was doing...and why!!
/*	$sql = "select StudentID from Students where FirstName = '$_POST[reqFirstName]' and MiddleName = '$_POST[optMiddleName]' and LastName = '$_POST[reqLastName]' and Phone='$_POST[reqPhoneNumber]'";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$_SESSION['StudentID'] = $row['StudentID'];
	$_SESSION['StudentName'] = $studentFullName;
*/
} //end else if student not yet registered
?>
	<tr><td><font size="+1">
            <table width="100%" border="1">
              <tr> 
                <td width="44%" align="center">Click below to go back to the Administration Page</td>
                <td width="12%">&nbsp;</td>
                <td width="44%" align="center">Click below to log out</td>
              </tr>
              <tr> 
                <td align="center"> 
              		<input name="btnGoBack" type="button"  onClick="window.location='Administration.php'" value="Back to Festival Administration">
                  </td>
                <td>&nbsp; </td>
                <td align="center"> 
	                <input name="btnLogout" type="button"  onClick="window.location='Logout.php'" id="Logout" value="Log Out">
                  </td>
              </tr>
            </table></font>
	</td>
  </tr>
</table>	
<?php include('../php/TableEnd.php'); ?>

</body>
</html>
