<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Update Student Information Results</title>
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
	  <td> <br>
<?php
	// unregister student name; we'll reset it later
	if(isset($_SESSION['StudentName']))
		unset($_SESSION['StudentName']);

	$studentFullName = ucwords(addslashes($_POST['FirstName'])) . " " 
						. ucwords(addslashes($_POST['MiddleName'])) . " " 
						. ucwords(addslashes($_POST['LastName']));

	$database = $_SESSION['DatabaseName'];
				
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());

	$birthdate = $_POST['Birthdate'];
	$pattern = "/(\d{1,2})-(\d{1,2})-(\d{4})/";
	$replace = "\$3-\$1-\$2";
	$birthdate = preg_replace($pattern, $replace, $birthdate);

	$sql = "update Students set
			StudentFirstName = '" . ucwords(addslashes($_POST['FirstName'])) ."', 
			StudentMiddleName = '" . ucwords(addslashes($_POST['MiddleName'])). "',
			StudentLastName = '" . ucwords(addslashes($_POST['LastName'])). "', 
			StudentEmail = '$_POST[StudentEmail]',
			StudentStudioID = '" . $_SESSION['StudioID'] ."', 
			StudentAddr = '" . ucwords(addslashes($_POST['StreetAddress'])). "', 
			StudentCity = '" . ucwords(addslashes($_POST['City'])). "', 
			StudentState = '$_POST[State]', 
			StudentZip = '$_POST[Zip]', 
			StudentPhone = '$_POST[PhoneNumber]',
			Birthdate = '$birthdate', 
			ParentName = '" . ucwords(addslashes($_POST['ParentsName']))."',
			ParentPhone = '$_POST[ParentsPhone]',
			Monitor = '$_POST[Monitor]'
			where StudentID = '" . $_SESSION['StudentID'] . "'";

	$result = mysql_query ($sql, $updateconn) or die(mysql_error());
	mysql_close($updateconn);
	
	session_register("StudentName");
	$StudentName = $studentFullName;

	print "<p class=\"msoNormal\"><font size=\"+1\">You have successfully UPDATED ";
	print "<font color=\"#008000\"><strong>$studentFullName.<br></strong></font>";
	$recipient = "";
	$recipient = $_SESSION["StudioEmail"];
	$subject = "LV Jr Festival Student UPDATE completed for " . $studentFullName;
	$mailheaders = "From: lvjrfest.org (lvjuniorfestival@hotmail.com)\n";
	$mailheaders .= "Reply-to: $recipient";
	$msg = "Thank you $_SESSION[StudioName] for registering $studentFullName. \n";
	$msg .= "The following information was recorded in our database for you.\n";
	$msg .= "If this information isn't correct please contact us!\n\n";
	$msg .= "\tStudent's first name = $_POST[FirstName]\n";
	$msg .= "\tStudent's middle name = $_POST[MiddleName]\n";
	$msg .= "\tStudent's last name = $_POST[LastName]\n";
	$msg .= "\tStudent's street address is: $_POST[StreetAddress]\n";
	$msg .= "\tStudent's birthdate is: $_POST[Birthdate]\n";
	$msg .= "\tStudent's phone number is: $_POST[PhoneNumber]\n";
	$msg .= "\tParent's name is: $_POST[ParentsName]\n";
	$msg .= "\tParent's phone number is: $_POST[ParentsPhone]\n";

	mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to responder");
	$recipient = "bessettec@cox.net";
	$subject = $studentFullName . "UPDATE OK";
	$msg .= "\n\n\n\tVerification sent to $_SESSION[StudioEmail]";
	mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to organizer");

?>
	   <table width="80%" border="1">
		<tr> 
		  <td width="44%">
			<div align="center"> <font size="+1">Click below to <font face="Verdana, Arial, Helvetica, sans-serif">return 
			  to the Studio Administration Page</font></font></div>
		  </td>
		  <td width="12%">&nbsp;</td>
		  <td width="44%">
			<div align="center">
			  <font size="+1">Click below to exit
			  </font>
			</div>
		  </td>
		</tr>
		<tr> 
		  <td>
			<div align="center"> 
			  <input name="btnStudioAdmin" type="button" id="btnStudioAdmin" onClick="window.location='StudioAdmin.php'" value="Back to Studio Administration">
			</div></td>
		  <td> </td>
		  <td>
			<div align="center">
			  <input name="btnLogout" type="button" id="btnLogout" onClick="window.location='Logout.php'" value="Log Out">
			</div>
		  </td>
		</tr>
	  </table>

 	</td>
  </tr>
 </table>	
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
