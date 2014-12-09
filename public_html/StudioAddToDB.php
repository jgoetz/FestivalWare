<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Studio Registration Accepted</title>
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
	$allOK = true;  // setup for error checking	
	$orgID = $_POST['reqTxtOrgID'];
// connect to the main DB, get the Org. database
	$tempconn = mysql_connect ("localhost","festival_mainAll","hy58*dfa") or die(mysql_error()); 
	mysql_select_db("festival_main", $tempconn) or die(mysql_error());

	$sql = "Select * from Organizations WHERE OrganizationID = $orgID";
	$result = mysql_query($sql, $tempconn) or die(mysql_error());
	
	if(mysql_num_rows($result) != 1) 
	{
		print "<br><br><h2 align=\"center\"><font color=\"FF0000\">Sorry, that organization code doesn't seem to be in our records.</font> </h2>";
		print "<br> <h3 align=\"center\">Please contact your organization's Coordinator to get the correct organization code.</h3>";
		print "<br><br><h3 align=\"center\"><input type=\"button\" name=\"btnBack\" value=\"FestivalWare Home\" onClick=\"location='index.php'\"></h3>";		
		$allOK = false;
	}
	else // org ID is OK, so test other stuff
	{
		$organizationRow = mysql_fetch_array($result);
		$database = $organizationRow['DatabaseName'];
		$orgName = $organizationRow['OrganizationName'];
						
		$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
		mysql_select_db($database, $addconn) or die(mysql_error());
		$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
		mysql_select_db($database, $selconn) or die(mysql_error());
	
		$sql = "SELECT * FROM Studios WHERE StudioName = '$_POST[reqStudioName]'";
		$studioNameResult = mysql_query($sql, $selconn) or die(mysql_error());
	
		if(mysql_num_rows($studioNameResult) != 0) 
		{
			print "<br><br><h2 align=\"center\"><font color=\"FF0000\">Sorry, your studio name has already been taken. </font></h2>";
			print "<br> <h3 align=\"center\">Please click your browser's Back button, and try a different studio name!</h3>";
			$allOK = false;
		}
		$sql = "SELECT * FROM Studios WHERE LoginID = '$_POST[reqLoginID]'";
		$studioLoginResult = mysql_query($sql, $selconn) or die(mysql_error());
		
		if(mysql_num_rows($studioLoginResult) != 0) 
		{
			print "<br><br><h2 align=\"center\"><font color=\"FF0000\">Sorry, your Login ID has already been taken.</font> </h2>";
			print "<br> <h3 align=\"center\">Please click your browser's Back button, and try a different login ID!</h3>";
			$allOK = false;
		}
	} // end else org number is OK

	if ($allOK == true)	
	{	
		$salt = substr($_POST['reqLoginID'], 0, 2);
		$passwd = crypt($_POST['reqPassword1'], $salt);

		$piano =  ($_POST['chkPiano'] == 'Y') ? 'Y':'N';
		$woodwinds =  ($_POST['chkWoodwinds'] == 'Y') ? 'Y':'N';
		$voice =  ($_POST['chkVoice'] == 'Y') ? 'Y':'N';
		$brass =  ($_POST['chkBrass'] == 'Y') ? 'Y':'N';
		$strings =  ($_POST['chkStrings'] == 'Y') ? 'Y':'N';
		$musicianship =  ($_POST['chkMusicianship'] == 'Y') ? 'Y':'N';
		$other =  ($_POST['chkOther'] == 'Y') ? 'Y':'N';
		
		$sql = "insert into Studios values (
				NULL, 
				now(), 
				'$_POST[reqFirstName]', 
				'$_POST[reqLastName]', 
				'$_POST[reqEmail]',
				'$_POST[reqLoginID]',
				'$passwd',
				'$_POST[reqStudioName]', 
				'$_POST[reqStreetAddress]', 
				'$_POST[reqCity]', 
				'$_POST[reqSelState]', 
				'$_POST[reqZip]', 
				'$_POST[reqPhoneNumber]',
				'$_POST[txtCellPhone]', 
				'$piano', 
				'$voice', 
				'$woodwinds', 
				'$strings', 
				'$brass',
				'$musicianship', 
				'$other', 
				'E',
				'N',
				'$_POST[DMTAMember]',
				'N')";
				
		$result = mysql_query ($sql, $addconn) or die(mysql_error());
	// look up new studio number, then add the password to the password database before leaving
		$sql = "SELECT * FROM Studios WHERE LoginID='$_POST[reqLoginID]'";
		$result = mysql_query($sql, $selconn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$studioNum = $row['StudioID'];
		$sql = "INSERT INTO Passwords VALUES ($studioNum, '$_POST[reqPassword1]')";
		$result = mysql_query($sql, $addconn) or die(mysql_error());
		
		mysql_close($selconn);	
		mysql_close($addconn);
		print "<h2 align=\"center\">You have successfully added your studio.<br>";
		print "We will send a confirmation email to the <br>";
		print "email address you provided. If you don't <br>";
		print "get your confirmation within 24 hours, please<br>";
		print "contact your organization's FestivalWare coordinator.</h2>";
		
		$recipient = $_POST['reqEmail'];
		$subject = "FestivalWare Studio Registration completed";
		$mailheaders = "From: festivalware.net (register@festivalware.net)\n";
		$mailheaders .= "Reply-to: $_POST[reqEmail]";
		$msg = "Thank you $_POST[reqFirstName] $_POST[reqLastName] for registering. \n";
		$msg .= "The following information was recorded in our database for you.\n";
		$msg .= "If this information isn't correct please contact us!\n\n";
		$msg .= "\tYour Login ID = $_POST[reqLoginID]\n";
		$msg .= "\tYour Password = $_POST[reqPassword1]\n";
		$msg .= "\tYour studio name is: $_POST[reqStudioName]\n";
		$msg .= "\tYour street address is: $_POST[reqStreetAddress]\n";
		$msg .= "\tYour phone number is: $_POST[reqPhoneNumber]\n";
		if ($_POST['DMTAMember'] === 'Y' )
		{	$msg .= "\tYou belong to an NMTA local chapter\n";}
		else
		{	$msg .= "\tYou don't belong to an NMTA local chapter\n";}
		mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to responder");
		$recipient = "registration@festivalware.net";
		$subject = "$_POST[reqFirstName] $_POST[reqLastName] Studio Registration OK";
		$msg .= "\n\n\n\tVerification sent to $_POST[reqEmail]";
		mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to festivalware");			
	} // end if AllOK
	
?>
		 </td>
        </tr>
 </table>	
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
