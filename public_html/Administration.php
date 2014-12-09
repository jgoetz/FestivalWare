<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>

<title>FestivalWare Organizer's Administration Page</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>

<body bgcolor="FFFFFF" leftmargin="15" >

<?php include('../php/TableStart.php'); ?>
<!-- main page area here -->
<form name="frmSiteAdmin" method="post" action="">

<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
	<tr><td width="33%">&nbsp;</td><td width="34%">&nbsp;</td><td width="33%">&nbsp;</td></tr>
	<tr><td colspan="4" align="center"><h2>Organizer's Administration Page</h2></td></tr>
	<tr><td colspan="4" align="center"><h3>Your current Organizer Job Titles are: </h3></td></tr>
	<tr><td colspan="4" align="center"><font color="#008000">
<?php 
	$matches = $_SESSION['AdminJob']; 
	$jobTitles = "";
	foreach ($matches as $key => $value)
	{
		if($value == true)
		{
			$jobTitles .= $key . ":";
			print "$key<br>";
		}
	}
?> 
    </font><h3><a href="Logout.php">Logout</a></h3>
			 
</td></tr>
<tr><td colspan="4">

<?php
	$database = $_SESSION['DatabaseName'];
				
	$conn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $conn) or die(mysql_error());
?>

	  <table width="100%" border="1">
		<tr><th colspan="4" align="center">Festival Organizer only</th></tr>
		<tr>
		  <td width="25%" align="center" bgcolor="#AAFFAA"> <strong><font size="+1"> 
			  Student <br>
			  Administration </font></strong></td>
		  <td width="25%" align="center" bgcolor="#66CC33"> <strong><font size="+1"> 
			  Performance <br>
			  Administration</font></strong></td>
		  <td width="25%" align="center" bgcolor="#339900"> <strong><font size="+1"> 
			  Studio <br>
			  Administration </font></strong></td>
		  <td width="25%" align="center" bgcolor="#006600"> <strong><font size="+1"> 
			  Festival<br>
			  Administration </font></strong></td>
		</tr>
		<tr> 
		  <td height="60" align="center" bgcolor="#AAFFAA"> <p align="center"> 
			  <input name="btnEnterNewStudent" type="button" id="btnEnterNewStudent"  value="Enter New Student" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminEnterStudent.php')">
			</p></td>
		  <td height="60" align="center" bgcolor="#66CC33">  
			  <input name="btnEnterPerf" type="button" id="btnEnterPerf"   value="Enter New Performance " onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminPerfEnterNew.php')">
			</td>
		  <td height="60" align="center" bgcolor="#339900">  
			  <input name="btnEnterStudio" type="button" id="btnEnterStudio"   value="Enter New Studio" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminStudioEnterNew.php')">
			</td>
		  <td height="60" align="center" bgcolor="#006600"><input name="btnEditEventList" type="button" value="Edit Event List" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminEditEvents.php')"></td>
		</tr>
		<tr> 
		  <td height="60" align="center" bgcolor="#AAFFAA">  
			  <input name="btnChangeStudent" type="button" id="btnChangeStudent"   value="Change Student Info" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminStudentLookup.php')">
			</td>
		  <td height="60" align="center" bgcolor="#66CC33">  
			  <input name="btnChangePerf" type="button" disabled id="btnChangePerf"   value="Change Performance Info" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminPerfChange.php')">
			</td>
		  <td height="60" align="center" bgcolor="#339900">  
			  <input name="btnChangeStudio" type="button" id="btnChangeStudio"   value="Change Studio Info" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminStudioChange.php')">
			</td>
		  <td height="60" align="center" bgcolor="#006600"><input name="btn" type="button"  value="Edit Skill Levels" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'SkillLevelsEdit.php')"></td>
		</tr>
		<tr>
		  <td height="144" align="center" bgcolor="#AAFFAA"><input name="btnDeleteStudent" type="button" disabled id="btnDeleteStudent2"   value="Delete Existing Student" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminStudentDelete.php')"></td>
		  <td height="144" align="center" bgcolor="#66CC33"><input name="btnDeletePerformance" type="button" disabled id="btnDeletePerformance2"  value="Delete Existing Performance" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminPerformanceDelete.php')"></td>
		  <td height="144" align="center" bgcolor="#339900"><input name="btnDeleteStudio" type="button"  disabled id="btnDeleteStudio2"  value="Delete Existing Studio" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminStudioDelete.php')"></td>
		  <td height="144" align="center" bgcolor="#006600"><p>
		    <input name="btnAddNewRoom" type="button" id="btnAddNewRoom6" value="Add, Change, or Delete Rooms"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Facilities Organizer', 'RoomAdmin.php')">
		  </p>
		    <p>
		      <input name="btnBreaks" type="button" id="btnBreaks" value="Add, Change, or Delete Breaks"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Facilities Organizer', 'Room_BreaksMain.php')">
		    </p>
		    <p>
		      <input name="btnUsage" type="button" id="btnUsage" value="Add, Change, or Delete Use Entries"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Facilities Organizer', 'Room_UseMain.php')">
</p>
		    <p>&nbsp;            </p></td>
		  </tr>
		<tr>
		  <td height="60" align="center" bgcolor="#AAFFAA">&nbsp;</td>
		  <td height="60" align="center" bgcolor="#66CC33"><input name="btnScheViewSchedule" type="button" id="btnScheViewSchedule3" value="View Schedule " onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminViewSchedule.php')"></td>
		  <td height="60" align="center" bgcolor="#339900">&nbsp;</td>
		  <td height="60" align="center" bgcolor="#006600"><input name="btnAssignJudges" type="button" id="btnJudges" value="Add, Change, or Delete Judging Assignments"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'Room_JudgesMain.php')">
		</tr>
		<tr>
		  <td height="60" align="center" bgcolor="#AAFFAA"><strong></strong></td>
		  <td height="60" align="center" bgcolor="#66CC33"><strong>
		    <input name="btnEnterPoints" type="button" id="btnEnterPoints4" value="Enter Points" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Auditing Organizer', 'AdminPointsEnter.php')">
		  </strong></td>
		  <td height="60" align="center" bgcolor="#339900">&nbsp;</td>
		  <td height="60" align="center" bgcolor="#006600"><input name="btnSchedulePerf" type="button" id="btnSchedulePerf7" value="Recital/Performance Scheduling"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminSchedPerf.php')"></td>
		  </tr>
	  </table>
	</td></tr>
<tr><td colspan="4">
	  <p>&nbsp;</p>
	  <table width="100%" border="1">
		<tr><th colspan="4" align="center">Reports</th></tr>
		<tr> 
		  <td width="25%" align="center" bgcolor="#AAFFAA"> <strong><font size="+1"> 
			  Student <br>
			  Reports</font></strong></td>
		  <td width="25%" align="center" bgcolor="#66CC33"> <strong><font size="+1"> 
			  Performance <br>
			  Reports</font></strong></td>
		  <td width="25%" align="center" bgcolor="#339900"> <strong><font size="+1"> 
			  Studio <br>
			  Reports</font></strong></td>
		  <td width="25%" align="center" bgcolor="#006600"><strong><font size="+1">Festival 
			  <br>
			  Reports </font></strong></td>
		</tr>
		<tr> 
		  <td height="60" align="center" bgcolor="#AAFFAA"> <p align="center"> 
			  <input name="btnPrintStudents" type="button" id="btnPrintStudents" value="Print Student Data"  onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Auditing Organizer', 'AdminStudentPrintChoices.php')">
			</p></td>
		  <td height="60" align="center" bgcolor="#66CC33"> 
			  <input name="btnPrintSchedule" type="button" id="btnPrintSchedule" value="Print Schedules by Student" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Facilities Organizer', 'AdminPrintSchedAlpha.php')">
			</td>
		  <td height="60" align="center" bgcolor="#339900">  
			  <input name="btnPrintStudios" type="button" id="btnPrintStudios" value="Print Studio Data"  onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Phone Organizer:Mailings Organizer:Awards Organizer', 'AdminPrintStudio.php')">
			</td>
		  <td height="60" align="center" bgcolor="#006600">  
			  <input name="btnPrintCommittees" type="button" id="btnPrintCommittees" value="Print Committee Lists"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Mailings Organizer', 'AdminPrintCommittee.php')">
			</td>
		</tr>
		<tr> 
		  <td height="60" align="center" bgcolor="#AAFFAA"> 
			  <input name="btnPrintMusicianship" type="button" id="btnPrintMusicianship" value="Print Musicianship Data"  onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Assistant Organizer', 'AdminPrintMusicianship.php')">
			</td>
		  <td height="60" align="center" bgcolor="#66CC33"> 
			  <input name="btnPrintStudioSchedules" type="button" id="btnPrintStudioSchedules" value="Print Schedules by Studio" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Assistant Organizer', 'AdminPrintSchedStudio.php')">
			</td>
		  <td height="60" align="center" bgcolor="#339900">  
			  <input name="btnPrintEastWest" type="button" id="btnPrintEastWest" value="Print East/West List"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Awards Organizer', 'AdminPrintEastWest.php')">
			</td>
		  <td height="60" align="center" bgcolor="#006600">  
			  <input name="btnPrintMonitors" type="button" id="btnPrintMonitors" value="Print Monitors List"    onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Monitor Organizer', 'AdminPrintMonitors.php')">
			</td>
		</tr>
		<tr> 
		  <td height="60" align="center" bgcolor="#AAFFAA"> 
			  <input name="btnPrintCertificates" type="button" id="btnPrintCertificates" value="Print Certificates" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Awards Organizer', 'AdminChooseRoom.php?type=2')">
			</td>
		  <td height="60" align="center" bgcolor="#66CC33">
			  <input name="btnPrintRoomSchedules" type="button" id="btnPrintRoomSchedules" value="Print Schedules by Room" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Facilities Organizer', 'AdminPrintSchedRoom.php')">
			</td>
		  <td height="60" align="center" bgcolor="#339900"> 
                      <input name="btnPrintLabels" disabled type="button" id="btnPrintLabels" value="Print Mailing Labels"  onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Mailings Organizer', 'AdminPrintLabels.php')">
            </td>
		  <td height="60" align="center" bgcolor="#006600"><input name="btnEstimateTrophies" type="button" id="btnEstimateTrophies4" value="Estimate Trophy Count" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Awards Organizer', 'AdminEstimateTrophyCount.php')">  
			</td>
		</tr>
		<tr> 
		  <td height="60" align="center" bgcolor="#AAFFAA">
			  <input name="btnPrintCertificates2" type="button" id="btnPrintCertificates" value="Print Musicianship Certs" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminPrintMusicianshipCerts.php')">
			</td>
		  <td height="60" align="center" bgcolor="#66CC33">
			  <input name="btnPrintRoomSchedules" type="button" id="btnPrintRoomSchedules" value="Print Schedules by Event#" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminPrintSchedEventNum.php')">
			</td>
		  <td height="60" align="center" bgcolor="#339900"><input name="btnLookupCosts" type="button" disabled id="btnLookupCosts2" value="Look Up Amounts Paid / Due"    onClick="NotAvailable()"> </td>
		  <td height="60" align="center" bgcolor="#006600"><input name="btnPrintPointsStudio" type="button" id="btnPrintPointsStudio3" value="Print Trophy Points"  onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer:Awards Organizer', 'AdminPrintTrophyPoints.php')"></td>
		</tr>
		<tr> 
		  <td height="60" align="center" bgcolor="#AAFFAA">  
			  <input name="btnPrintRatingSheets" type="button" id="btnPrintRatingSheets" value="Print Rating Sheets" onClick="AccessOK( '<?php print $jobTitles; ?>', 'Festival Organizer:Assistant Organizer', 'AdminChooseRoom.php?type=1')">
			</td>
		  <td height="60" align="center" bgcolor="#66CC33">&nbsp;  </td>
		  <td height="60" align="center" bgcolor="#339900">&nbsp;</td>
		  <td height="60" align="center" bgcolor="#006600">&nbsp;</td>
		</tr>
	  </table>
</td></tr>
<tr><td colspan="4">
	  <p>&nbsp;</p>
	  </td></tr>
	</table>
	</form>
<?php include('../php/TableEnd.php'); ?>


</body>
</html>
