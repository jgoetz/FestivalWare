<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Demo Festival Updated</title>
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
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());
	//$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	//mysql_select_db($database, $selconn) or die(mysql_error());
	
	$sql = "Update Festivals Set
		FestivalName = '" . addslashes($_POST['reqFestivalName']) . "',
		WelcomeMessage = '" . addslashes($_POST['reqWelcome']) . "',
		EventStartDate = '". DateConvert($_POST['reqFestStartDate']) . "',
		EventEndDate = '". DateConvert($_POST['reqFestEndDate']) . "',
		StudioRegStart = '". DateConvert($_POST['reqStudioRegStartDate']) . "',
		StudioRegEnd = '". DateConvert($_POST['reqStudioRegEndDate']) . "',
		StudentRegStart = '". DateConvert($_POST['reqStudentRegStartDate']) . "',
		StudentRegEnd = '". DateConvert($_POST['reqStudentRegEndDate']) . "',
		PerformanceRegStart = '". DateConvert($_POST['reqPerfRegStartDate']) . "',
		PerformanceRegEnd = '". DateConvert($_POST['reqPerfRegEndDate']) . "',
		PerformanceSchedStart = '". DateConvert($_POST['reqPerfSchedStartDate']) . "',
		PerformanceSchedEnd = '". DateConvert($_POST['reqPerfSchedEndDate'])  . "',
		OrganizerID = '" . addslashes($_POST['selOrganizer']) . "',
		AssistantOrganizerID = '" . addslashes($_POST['selAssistantOrganizer']) . "',
		TreasurerOrganizerID = '" . addslashes($_POST['selTreasurerOrganizer']) . "',
		AwardsOrganizerID = '" . addslashes($_POST['selAwardsOrganizer']) . "',
		PhoneOrganizerID = '" . addslashes($_POST['selFoneOrganizer']) . "',
		MailingsOrganizerID = '" . addslashes($_POST['selMailingsOrganizer']) . "',
		MonitorOrganizerID = '" . addslashes($_POST['selMonitorOrganizer']) . "',
		FacilitiesOrganizerID = '" . addslashes($_POST['selFacilitiesOrganizer']) . "',
		JudgingOrganizerID = '" . addslashes($_POST['selJudgingOrganizer']) . "',
		AuditingOrganizerID = '" . addslashes($_POST['selAuditingOrganizer']) . "',
		Format = '" . addslashes($_POST['rdoFormat']) 
		. "' WHERE FestivalID = '$_POST[hdnFestivalID]'";

	$result = mysql_query ($sql, $updateconn) or die(mysql_error());

	// if you reach this point, you have updated the record. 
	// set a session variable so that you can't refresh the page and reenter the same record again
	$_SESSION['RegisteredFestival'] = $_POST['reqOrgID'] . $festivalID;
	mysql_close($updateconn);
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
              You have successfully changed  <br>
              <?php print $_POST['reqFestivalName']; ?> !<br>
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
				$subject = "Festival update completed";
				$mailheaders = "From: Festivalware.net \n";
				$mailheaders .= "Reply-to: $_SESSION[OrganizerEmail]";
				$msg = "Thank you $_SESSION[AuthUserName] for updating festival $_POST[reqFestivalName]. \n";
				$msg .= "The following information was recorded in our database for you.\n";
				$msg .= "If this information isn't correct please contact us!\n\n";
				$msg .= "\tFestival ID = $festivalID\n";
				$msg .= "\tFestival Name = $_POST[reqFestivalName]\n";
				$msg .= "\tWelcome Message = $_POST[reqWelcome]\n";
				$msg .= "\tFestival Start Date: $_POST[reqFestStart]\n";
				$msg .= "\tFestival End Date: $_POST[reqFestEnd]\n";
				$msg .= "\tStudio Registration Start Date:$_POST[reqStudioRegStart]\n";
				$msg .= "\tStudio Registration End Date:$_POST[reqStudioRegEnd]\n";
				$msg .= "\tStudent Registration Start Date:$_POST[reqStudentRegStart]\n";
				$msg .= "\tStudent Registration End Date:$_POST[reqStudentRegEnd]\n";
				$msg .= "\tPerformance Registration Start Date:$_POST[reqPerfRegStart]\n";
				$msg .= "\tPerformance Registration End Date:$_POST[reqPerfRegEnd]\n";
				$msg .= "\tPeformance Scheduling Start Date:$_POST[reqPerfSchedStart]\n";
				$msg .= "\tPerformance Scheduling End Date:$_POST[reqPerfSchedEnd]\n";
				
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
				  <td width="44%" align="center">Click below to return to the Coordinator's Action Page</td>
                  <td width="12%">&nbsp;</td>
                  <td width="44%" align="center">Logout</td>
                </tr>
                <tr><td align="center"> 
                  <input name="btnUpdateAnother" type="button" onClick="window.location='CoordinatorSelector.php'" value="Back to Coordinator's Action Page">
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
