<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Demo Festival Registration Completed</title>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
         <tr align="left" valign="top"> 
          <td > 
			 <h2>Festival Update Completion Page</h2>
		  </td>
		 </tr>

<?php

function DateConvert($date)
{
	$parts = explode("-", $date);
	$day = $parts[1];
	$month = $parts[0];
	$year = $parts[2];
	return "$year-$month-$day";
}

	  if (! isset($_SESSION['RegisteredFestival']))
	  {
		$database = $_SESSION['DatabaseName'];
	
		$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
		mysql_select_db($database, $addconn) or die(mysql_error());
		$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
		mysql_select_db($database, $selconn) or die(mysql_error());
			
// generate a random number for the festival ID
	// verify festivalID isn't in the DB already
		$done = false;
		do {
			$festivalID = rand(1, 999999);
			$sql = "SELECT * FROM Festivals WHERE FestivalID = '$festivalID'";
			$result = mysql_query($sql, $selconn) or die(mysql_error());
			if(mysql_num_rows($result) == 0)
				$done = true;
		} while (!$done);
	
		$sql = "insert into Festivals values (
				'$festivalID',
				'" . addslashes($_POST['reqFestivalName']) . "',
				'" . addslashes($_POST['reqWelcome']) . "',
				'" . addslashes($_POST['reqOrgID']) . "',
				'". DateConvert($_POST['reqFestStartDate']) . "',
				'". DateConvert($_POST['reqFestEndDate']) . "',
				'". DateConvert($_POST['reqStudioRegStartDate']) . "',
				'". DateConvert($_POST['reqStudioRegEndDate']) . "',
				'". DateConvert($_POST['reqStudentRegStartDate']) . "',
				'". DateConvert($_POST['reqStudentRegEndDate']) . "',
				'". DateConvert($_POST['reqPerfRegStartDate']) . "',
				'". DateConvert($_POST['reqPerfRegEndDate']) . "',
				'". DateConvert($_POST['reqPerfSchedStartDate']) . "',
				'". DateConvert($_POST['reqPerfSchedEndDate']) . "', 
				'" . addslashes($_POST['selOrganizer']) . "',
				'" . addslashes($_POST['selAssistantOrganizer']) . "',
				'" . addslashes($_POST['selTreasurerOrganizer']) . "',
				'" . addslashes($_POST['selAwardsOrganizer']) . "',
				'" . addslashes($_POST['selFoneOrganizer']) . "',
				'" . addslashes($_POST['selMailingsOrganizer']) . "',
				'" . addslashes($_POST['selMonitorOrganizer']) . "',
				'" . addslashes($_POST['selFacilitiesOrganizer']) . "',
				'" . addslashes($_POST['selJudgingOrganizer']) . "',
				'" . addslashes($_POST['selAuditingOrganizer']) . "',
				'" . addslashes($_POST['rdoFormat']) . "')";
		
		$result = mysql_query ($sql, $addconn) or die(mysql_error());
	   // if you reach this point, you have entered the record. 
	   // set a session variable so that you can't refresh the page and reenter the same record again
	   $_SESSION['RegisteredFestival'] = $_POST['reqOrgID'] . $festivalID;
	   
	   mysql_close($addconn);
	   
	   // add the administration positions to the assignments table
	 } // end if session test not set yet
?>
	<tr><td>
			<p align="center"> 
			<font face="Georgia, Times New Roman, Times, serif" size="+2"> 
            <strong>
			  <br />
              <br />
              Congratulations! <br>
              You have successfully registered <br>
              <?php print $_POST['reqFestivalName']; ?> as your new festival!<br>
              </strong></font></p>
			  <p align="center"><font size="+1">
			  	We will send a confirmation to your email address. <br>
            	If you don't get your confirmation within 24 hours, please <a href="Contact.php">contact 
            	us!</a>! 
			  </font>
			  </p>
	</td></tr>

				<?php
				$recipient = $_SESSION['OrganizerEmail'];
				$subject = "Festival Registration completed";
				$mailheaders = "From: Festivalware.net \n";
				$mailheaders .= "Reply-to: $_SESSION[OrganizerEmail]";
				$msg = "Thank you $_SESSION[AuthUserName] for registering festival $_POST[reqFestivalName]. \n";
				$msg .= "The following information was recorded in our database for you.\n";
				$msg .= "If this information isn't correct please contact us!\n\n";
				$msg .= "\tFestival ID = $festivalID\n";
				$msg .= "\tFestival Name = $_POST[reqFestivalName]\n";
				$msg .= "\tWelcome Message = $_POST[reqWelcome]\n";
				$msg .= "\tFestival Start Date: $_POST[reqFestStartDate]\n";
				$msg .= "\tFestival End Date: $_POST[reqFestEndDate]\n";
				$msg .= "\tStudio Registration Start Date:$_POST[reqStudioRegStartDate]\n";
				$msg .= "\tStudio Registration End Date:$_POST[reqStudioRegEndDate]\n";
				$msg .= "\tStudent Registration Start Date:$_POST[reqStudentRegStartDate]\n";
				$msg .= "\tStudent Registration End Date:$_POST[reqStudentRegEndDate]\n";
				$msg .= "\tPerformance Registration Start Date:$_POST[reqPerfRegStartDate]\n";
				$msg .= "\tPerformance Registration End Date:$_POST[reqPerfRegEndDate]\n";
				$msg .= "\tPeformance Scheduling Start Date:$_POST[reqPerfSchedStartDate]\n";
				$msg .= "\tPerformance Scheduling End Date:$_POST[reqPerfSchedEndDate]\n";
				
// when going live, uncomment the following line
				mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to organizer");

				$recipient = "registrations@festivalware.net";
				$msg .= "\n\n\n\tVerification sent to $_SESSION[OrganizerEmail]";
// when going live, uncomment the following line
			mail($recipient, $subject, $msg, $mailheaders) or die("Mail error: Sending to festivalware");
			?>
<tr><td>	
 <font size="+1">	
              <table width="100%" border="1">
                <tr> 
                  <td width="44%" align="center">Choose another festival</td>
                  <td width="12%">&nbsp;</td>
                  <td width="44%" align="center"> Logout</td>
                </tr>
                <tr> 
                  <td align="center"> 
                      <input name="btnRegAnother" type="button" onClick="window.location='CoordinatorSelector.php'" value="Back to Festival Chooser Page">
                  </td>
                  <td>&nbsp; </td>
                  <td align="center">
				  	  <input name="btnLogout" type="button" onClick="window.location='Logout.php'" value="Logout">
				  </td>
                </tr>
              </table>
</font> 
          </td></tr>
      </table> 
<?php include('../php/TableEnd.php'); ?>


</body>
</html>
