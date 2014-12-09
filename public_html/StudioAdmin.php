<?php include("IsAuth_Studio.php");?> <!-- note: includes session_start(); -->
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Studio Action Page</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>
 <script language="JavaScript">
 function CheckAvailable(myarray, yourID)
 {
 	if(myarray.indexOf(yourID) != -1)
		alert("Your fees haven't been received yet. \nPlease contact the Festival Adminstrator.");
	else
 		location.href="SchedDisplayStudents.php";
 }
 function NoLongerAvailable(yourID, destination)
 {
 	if(yourID !=15)
 		alert("Sorry, that function is no longer available. \nPlease contact your oorganization coordinator for more information.");
 	else
		location.href=destination;
 }
</script>
<body bgcolor="FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../php/TableStart.php'); ?>
<?php
	$database = $_SESSION['DatabaseName'];	
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

// build a string of studio numbers that haven't paid fees yet
	$sql = "Select StudioID from Studios WHERE FeesPaid='N';";
	$feesResult=mysql_query($sql, $selconn) or die(mysql_error());
	$studiosnotpaid = "";
	while($row=mysql_fetch_array($feesResult))
	{
		$studiosnotpaid.=$row['StudioID'] . ",";
	}	
	mysql_close($selconn);
?>
	<form name="frmStudioAction" method="post" action="">

	<table width="100%" border="0" align="center">
		<tr><td align="center"><h2> FestivalWare Studio Administration Page</h2></td></tr>
	</table>
	  
	<table width="100%" border="1">
	  <tr>
		<th width="33%" bgcolor="#66CCFF"> <font size="+1"> Student <br>Administration </font></th>
		<th width="34%" bgcolor="#9999FF"> <font size="+1"> Performance<br>Administration* </font></th>
		<th width="33%" bgcolor="#6699FF"> <font size="+1"> Studio <br>Administration </font></th>	
	  </tr>
	<tr> 
	  <td  height="60" bgcolor="#66CCFF" align="center"><input name="btnEnterNewStudent" type="button" id="btnEnterNewStudent" value="Enter New Student" onClick="window.location='StudentReg.php'"></td>
	  <td  height="60" bgcolor="#9999FF" align="center"><input name="btnEnterPerf" type="button" id="btnEnterPerf" value="Enter New Performance " onClick="window.location='PerfEventSelection.php'"></td>
	  <td  height="60" bgcolor="#6699FF" align="center"><input name="btnLookupCosts" type="button" id="btnLookupCosts" value="Look Up Amounts Paid / Due" onClick="NotAvailable()"></td>
	</tr>
	<tr> 
	  <td  height="60" bgcolor="#66CCFF" align="center"><input name="btnLookupStudent" type="button" id="btnLookupStudent" value="Look Up Existing Student" onClick="window.location='StudentLookup.php'"></td>
	  <td  height="60" bgcolor="#9999FF" align="center"><input name="btnLookupPerf" type="button" id="btnLookupPerf" value="Look Up an Existing Performance" onClick="window.location='PerfLookup.php'"></td>
	  <td  height="60" bgcolor="#6699FF" align="center"><input name="btnChangeStudios" type="button" id="btnChangeStudios" value="Change Studio Data" onClick="NotAvailable()"></td>
	<tr> 
	  <td  height="60" bgcolor="#66CCFF" align="center"><input name="btnChangeStudent" type="button" id="btnChangeStudent" value="Change Student Info" onClick="window.location='StudentLookup.php'"></td>
	  <td  height="60" bgcolor="#9999FF" align="center"><input name="btnChangePerf" type="button" id="btnChangePerf" value="Delete an Existing Performance" onClick="window.location='PerfLookup.php'"></td>
	  <td  height="60" bgcolor="#6699FF" align="center"><input name="btnContact" type="button" id="btnContact" value="Contact Us" onClick="window.location='Contact.html'"></td>
	<tr>
	  <td  height="60" bgcolor="#66CCFF" align="center"><input name="btnSchedulePerf" type="button" id="btnSchedulePerf" value="Schedule Performances" onClick="CheckAvailable(<?php print "'$studiosnotpaid', '$_SESSION[StudioID]' "?>)"></td>
	  <td  height="60" bgcolor="#9999FF" align="center"><input name="btnSchedulePerf" type="button" id="btnSchedulePerf" value="Schedule Performances" onClick="CheckAvailable(<?php print "'$studiosnotpaid', '$_SESSION[StudioID]' "?>)"></td>
	  <td  height="60" bgcolor="#6699FF" align="center"><input name="btnJudgingPrefs" type="button" id="btnAddStudio" value="Set/Change Judging Preferences" onClick="window.location='Studio_SkillsMain.php'"></td>
	</tr>
	<tr> 
	  <td  height="60" bgcolor="#66CCFF" align="center">&nbsp;</td>
	  <td  height="60" bgcolor="#9999FF" align="center"><input name="btnViewSchedule" type="button" id="btnViewSchedule" value="View Performance Schedule " onClick="window.location='SchedViewSchedule.php'"></td>
	  <td  height="60" bgcolor="#6699FF" align="center">&nbsp;</td>
	</tr>
	<tr><td colspan="3" align="center"><font size="+1"><strong>*Note: In 
                      order to <em>change</em> <font color="#0066FF">performance </font>information, 
                      you must <em>delete</em> the existing performance then enter 
                      a new performance with the correct information.</strong></font>
	</td></tr>
	</table>
</form>

<?php include('../php/TableEnd.php'); ?>
</body>
</html>
