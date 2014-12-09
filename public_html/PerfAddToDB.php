<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Registration Completed</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js">
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<?php
  if (! isset($_SESSION['RegisteredPerformance']))
  {
	$database = $_SESSION['DatabaseName'];
	
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// if this is an ensemble (#Participants > 1), create ensembleID
	$ensembleID = "NULL";
	$duplicateStudents = false;
	$studentNames = "";
	if($_SESSION['Participants'] > 1) 
	{
		$done = false;
		do {
			$ensembleID = rand(1, 999999);
			$sql = "SELECT * FROM History WHERE EnsembleID = '$ensembleID'";
			$result = mysql_query($sql, $selconn) or die(mysql_error());
			if(mysql_num_rows($result) == 0)
				$done = true;
		} while (!$done);

		//also check if any of the student id's are duplicated
		$studArray = array();
		for($count=1; $count <= $_SESSION['Participants']; $count++)
			$studArray[$count] = $_POST["reqSelStudent$count"];

		if ($studArray != array_flip(array_flip($studArray))) //Have to end here...
		{
			$duplicateStudents=true;
	 		$message = "<h2>You have entered a student multiple times for an ensemble!<br> Click the Back button to try again</h2><br>(Click OK when you see the POST Data message)";
		}// end if duplicated students

	} // end if #participants > 1
	if($duplicateStudents==false){
		for ($count = 1; $count <= $_SESSION['Participants']; $count++)
		{
			$currentStudentID = "reqSelStudent$count";
			$sql = "insert into History values (
				'', 
				'" . $_SESSION['FestivalID'] . "',
				now(), 
				'" . $_POST[$currentStudentID] . "', 
				'" . $_SESSION['StudioID'] . "', 
				'" . date("Y") . "',
				'" . $_SESSION['EventID'] . "',
				'" . $_SESSION['ClassID'] . "',
				$ensembleID,
				'" . ucwords(addslashes($_POST['reqReqSelection'])) . "', 
				'" . ucwords(addslashes($_POST['reqReqComposer'])) . "', 
				'" . ucwords(addslashes($_POST['reqChoiceSelection'])) . "', 
				'" . ucwords(addslashes($_POST['reqChoiceComposer'])) . "', 
				'"  . $_POST['reqSelTotalTime'] . "',
				'N',
				'" . $_POST['rdoSCJM'] . "', 
				0)";
	
		$result = mysql_query ($sql, $addconn) or die(mysql_error());
	   // if you reach this point, you have entered the record. 
			// lookup student name for email message and screen posting
			$sql = "SELECT * FROM Students WHERE StudentID=$_POST[$currentStudentID]";
			$result = mysql_query($sql, $selconn) or die(mysql_error());
			$studentRow = mysql_fetch_array($result);
			$studentNames .= $studentRow['StudentFirstName'] . " " . $studentRow['StudentLastName'];
			if($_SESSION['Participants'] > 1 && $count < $_SESSION['Participants'])
				$studentNames .= ", ";
			if($count == $_SESSION['Participants'] -1)
				$studentNames .= " and ";
		} //end for each student
		mysql_close($addconn);
		mysql_close($selconn);		
		$_SESSION['RegisteredPerformance'] = $_SESSION['StudentID'] . $_SESSION['EventID'];
	
		$recipient = $_SESSION['StudioEmail'];
		$subject = "Student Registration completed";
		$mailheaders = "From: FestivalWare.net \n";
		$mailheaders .= "Reply-to: $_SESSION[StudioEmail]";
		$msg = "Thank you $_SESSION[StudioName] for registering $studentNames. \n";
		$msg .= "The following information was recorded in our database for you.\n";
		$msg .= "If this information isn't correct please contact us!\n\n";
		$msg .= "\tStudent Event = $_SESSION[EventName]\n";
		$msg .= "\tStudent Class = $_SESSION[ClassDescription]\n";
		if (strcmp($_SESSION['EventName'], "Musicianship Theory") != 0)
		{
			$msg .= "\tRequired Selection: " . ucwords($_POST['txtReqSelection']) . "\n";
			$msg .= "\t\tComposer: " . ucwords($_POST['txtReqComposer']) . "\n";
			$msg .= "\tChoice Selection: " . ucwords($_POST['txtChoiceSelection']) . "\n";
			$msg .= "\t\tComposer: " . ucwords($_POST['txtChoiceComposer']) . "\n";
		
			if($_POST['rdoSCJM'] == 'Y')
			{
				$msg .= "Student is SCJM";
			}
		}
		mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to user");
	
		$recipient = $_SESSION['AuthUserEmail'];
		$msg .= "\n\n\n\tVerification sent to $_SESSION[StudioEmail]";
		mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to organizer");
		
		$message = "Congratulations! <br> You have successfully registered $studentNames for<br>" .
			  "$_SESSION[EventName] in class $_SESSION[ClassDescription]<br /></strong></p>" .
			  "<p align=\"center\">We will send a confirmation to your studio email address. <br>" . 
				"If you don't get your confirmation within 24 hours, please contact your festival organizer!</p>";
		}// end if no duplicated students
	}// end if session test not set yet
	else{	//session test failed; you're trying to enter the same performance twice
		$message =  "<h2>You have already entered that performance</h2>";
	} // end else you're trying to enter the same performance twice
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	 <tr align="left" valign="top"> 
	  <td> 
		 <h2>Performance Addition Completion Page</h2>
	</td>
	<tr><td>
	  
		<font face="Georgia, Times New Roman, Times, serif" size="+1"> 
		<p align="center"> 
		<strong>
		  <br />
		  <br />
			<?php print $message; ?>
			</strong>
		</font>
		</td></tr>
		<tr><td>
		<form name="form1" method="post" action="">
		  <table width="100%" border="1">
			<tr> 
			  <td width="44%" align="center"> Click below to register another performance</td>
			  <td width="12%">&nbsp;</td>
			  <td width="44%" align="center">Click below to return to the Studio Administration page</td>
			</tr>
			<tr> 
			  <td align="center"> 
				  <input name="btnRegAnother" type="button" id="btnRegAnother" onClick="window.location='StudioAdmin.php'" value="Register Another Performance">
				</td>
			  <td> </td>
			  <td align="center">
				  <input name="btnStudioAdmin" type="button" id="btnStudioAdmin" onClick="window.location='StudioAdmin.php'" value="Back to Studio Administration">
			  </td>
			</tr>
		  </table>
		</form> 
	  </td></tr>
  </table> 

<?php include('../php/TableEnd.php'); ?>
</body>
</html>
