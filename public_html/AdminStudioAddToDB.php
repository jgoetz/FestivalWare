<?php include ('IsAuth_Admin.php'); ?>
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
	function ExitStatement($strError)
	{
		$strNameError = "Your studio name is already taken.\n" .
		" Please click your Back button and try a different name.";
		$strLoginIDError = "Your login ID is already taken.\n" .
		" Please click your Back button and try a different loginID.";
		
		$strGenericError = $strError . "\nThis is a generic error. \n".
		"Please contact the website administrator\n" . 
		" with the details of your error.";
		
		$pos = strpos ($strError, "key 2");
		if (!( $pos === false ))
			return $strLoginIDError;
		
		$pos = strpos ($strError, "key 3");
		if (!( $pos === false ))
			return $strNameError;	
		
		return $strGenericError;	
	}
	$database = $_SESSION['DatabaseName'];
				
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$salt = substr($_POST['reqLoginID'], 0, 2);
	$passwd = crypt($_POST['reqPassword1'], $salt);
	
	$sql = "insert into Studios values (
			NULL, 
			now(), 
			'" . addslashes($_POST['reqFirstName']) . "', 
			'" . addslashes ($_POST['reqLastName']) . "', 
			'" . addslashes ($_POST['reqEmail']) . "',
			'" . addslashes ($_POST['reqLoginID']) . "',
			'$passwd',
			'" . addslashes ($_POST['reqStudioName']) . "', 
			'" . addslashes ($_POST['reqStreetAddress']) . "', 
			'" . addslashes ($_POST['reqCity']) . "', 
			'" . addslashes ($_POST['reqState']) . "', 
			'" . addslashes ($_POST['reqZip']) . "', 
			'" . addslashes ($_POST['reqPhoneNumber']) . "',
			'" . addslashes ($_POST['CellPhone']) . "', 
			'" . addslashes ($_POST['reqPiano']) . "', 
			'" . addslashes ($_POST['reqVoice']) . "', 
			'" . addslashes ($_POST['reqWoodwinds']) . "', 
			'" . addslashes ($_POST['reqStrings']) . "', 
			'" . addslashes ($_POST['reqBrass']) . "',
			'" . addslashes ($_POST['reqMusicianship']) . "', 
			'" . addslashes ($_POST['reqCommitteePreference']) . "', 
			'" . addslashes ($_POST['reqJudgingPreference']) . "', 
			'" . addslashes ($_POST['reqEastOrWest']) . "', 
			'N',
			'" . addslashes ($_POST['DMTAMember']) . "',
			'N')";
			
	$result = mysql_query ($sql, $addconn) or die(ExitStatement(mysql_error()));
// look up new studio number, then add the password to the password database before leaving
	$sql = "SELECT * FROM Studios WHERE LoginID='" . addslashes($_POST['reqLoginID'] . "'";
	$result = mysql_query($sql, $selconn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$studioNum = $row['StudioID'];
	$sql = "INSERT INTO Passwords VALUES ($studioNum, '" . addslashes($_POST['reqPassword1']) . "')";
	$result = mysql_query($sql, $addconn) or die(mysql_error());
	
	mysql_close($selconn);	
	mysql_close($addconn);
	print "You have successfully added $_POST[reqStudioName].\n";
	print "We will send a confirmation email to the \n";
	print "email address you provided. If you don't \n";
	print "get your confirmation within 24 hours, please\n";
	print "contact us.";
	
	$recipient = $_POST['reqEmail'];
	$subject = "LV Jr Festival Registration completed";
	$mailheaders = "From: lvjrfest.org (lvjuniorfestival@hotmail.com)\n";
	$mailheaders .= "Reply-to: $_POST[reqEmail]";
	$msg = "Thank you $_POST[reqFirstName] $_POST[reqLastName] for registering. \n";
	$msg .= "The following information was recorded in our database for you.\n";
	$msg .= "If this information isn't correct please contact us!\n\n";
	$msg .= "\tYour Login ID = $_POST[reqLoginID]\n";
	$msg .= "\tYour Password = $_POST[reqPassword1]\n";
	$msg .= "\tYour studio name is: $_POST[reqStudioName]\n";
	$msg .= "\tYour street address is: $_POST[reqStreetAddress]\n";
	$msg .= "\tYour phone number is: $_POST[reqPhoneNumber]\n";
	$msg .= "\tYour committee preference is: $_POST[reqCommitteePreference]\n";
	$msg .= "\tYour judging preference is: $_POST[reqJudgingPreference]\n";
	if ($_POST['reqEastOrWest'] === 'E' )
	{	$msg .= "\tYou live to the East of the strip\n";}
	else
	{	$msg .= "\tYou live to the West of the strip\n";}
	if ($_POST['DMTAMember'] === 'Y' )
	{	$msg .= "\tYou belong to MTA local chapter\n";}
	else
	{	$msg .= "\tYou don't belong to MTA local chapter\n";}
	mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to responder");
/*	$recipient = "bessettec@cox.net";
	$subject = "$_POST[FirstName], $_POST[LastName] Studio Registration OK";
	$msg .= "\n\n\n\tVerification sent to $_POST[reqEmail]";
	mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to organizer");			
*/
?>
		 </td>
        </tr>
		<tr>
		 <td align="center"> <input name="btnAdmin" type="button" onClick="window.location='Administration.php'" value="Back to Festival Administration"></td>
		</tr>
 </table>	
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
