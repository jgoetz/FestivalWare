<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Piece Selection</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<script language="JavaScript">
function clearFields(which)
{
	document.PieceSelection.formAgreeNFMCRules.checked = false;
	document.PieceSelection.formReqSelection.value = "";
	document.PieceSelection.formReqComposer.value = "";
	document.PieceSelection.formChoiceSelection.value = "";
	document.PieceSelection.formChoiceComposer.value = "";
}
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<?php
	$database = $_SESSION['DatabaseName'];
	
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	
	$sql = "select * from Classes where ClassID = $_POST[reqSelClass]";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	$classRow = mysql_fetch_array($result);
	$_SESSION['ClassID'] = $_POST['reqSelClass'];
	$_SESSION['ClassDescription'] = $classRow['ClassDescription'];
	
	// unset the RegisteredPerformance session variable
	// so we can use it to prevent refresh of registration page
	// so we can prevent inserting performance multiple times
	if(isset($_SESSION['RegisteredPerformance']))
		unset($_SESSION['RegisteredPerformance']);
?>
<form name="PieceSelection" method="post" onSubmit="return checkReqEntries(this)" action="PerfAddToDB.php">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
         <tr align="left" valign="top"> 
          <td align="center"> <br>
			<h2>Performance Registration - Piece Selection Page </h2>
			  <font style="bold" size="+2"> 
				You are entering information for event : 
				<font color="#008000"><?php print $_SESSION['EventName']; ?></font> 
		  	  </font>
		  </td></tr>
          <tr><td align="center"> <br>
			  <font style="bold" size="+2"> 
				in class : 
				<font color="#008000"><?php print $_SESSION['ClassDescription']; ?></font> 
		  	  </font>
		  </td></tr>
		  
<?php 
	// Now select the student(s)
	// if event is an ensemble, show the number of students needed
	$sql = "SELECT * FROM Students WHERE StudentStudioID = $_SESSION[StudioID]";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	// build an array
	$studentArray = array();
	$studentCount = 0;
	while($classRow = mysql_fetch_array($result))
	{
		$studentArray[$studentCount] = array($classRow['StudentID'], $classRow['StudentFirstName'], $classRow['StudentMiddleName'], $classRow['StudentLastName']);
		$studentCount++;
	}
	for ($count = 1; $count <= $_SESSION['Participants']; $count++)	
	{
		// print out a student selection drop-down
		print "<tr><td align=\"center\"><font size=\"+1\"><br>Please select student #" . $count . "</font>";
		print "<select name=\"reqSelStudent" . $count . "\" title=\"Select Student #" . $count . "\">";
		print "<option value=\"-1\">Select a Student</option>";
		for($index = 0; $index < $studentCount; $index++)
		{
			print "	<option value=\"" . $studentArray[$index][0] . "\">" 
				. $studentArray[$index][1] . " " 
				. $studentArray[$index][2] . " "
				. $studentArray[$index][3] . "</option>";
		}
		print "</select></td></tr>";
	}
?>

<?php
if (strcmp($_SESSION['EventName'], "Musicianship Theory") != 0)
{
?>
	<tr><td>
	<font size="+1">
	<p>Please enter the required selection: 
	<input name="reqReqSelection" type="text" title="Required Selection" size="50" maxlength="75">
	</p>
	<p>Please enter the composer's name: 
	<input name="reqReqComposer" type="text" title="Required Composer" size="50" maxlength="75">
	</p>
	<p>Please enter the choice selection: 
	<input name="reqChoiceSelection" type="text" title="Choice Selection" size="50" maxlength="75">
	</p>
	<p>Please enter the composer's name: 
	<input name="reqChoiceComposer" type="text" title="Choice Composer" size="50" maxlength="75">
	</p>
	<p>Please indicate if student is SCJM: 
	<input type="radio" name="rdoSCJM" value="Y" > Yes
	<input type="radio" name="rdoSCJM" value="N" CHECKED> No <BR>
	</p>                
	<p>Please estimate the <strong>TOTAL</strong> time to perform <strong>BOTH</strong> 
	pieces : 
	<select name="reqSelTotalTime" title="Total Time">
	<option value="-1">Select Total Time</option>
	<option value="2">2 minutes </option>
	<option value="3">3 minutes </option>
	<option value=" ">4 minutes </option>
	<option value="5">5 minutes </option>
	<option value="6">6 minutes </option>
	<option value="7">7 minutes </option>
	<option value="8">8 minutes </option>
	<option value="9">9 minutes </option>
	<option value="10">10 minutes </option>
	<option value="11">11 minutes </option>
	<option value="12">12 minutes </option>
	<option value="13">13 minutes </option>
	<option value="14">14 minutes </option>
	<option value="15">15 minutes </option>
	</select>
	</p>
	</font>
<?php
}
?>
              <p>&nbsp;</p>
              <p><font size="+1">To register students in an NFMC event, you must 
                agree to follow all of the NFMC rules as posted in the National 
                Federation of Music Clubs Festival Bulletin. Click 
                the check box below to indicate you agree to follow the NFMC Festival 
                bulletin rules:</font></p>
              <p align="center"><font size="+2"> I agree 
                <input type="checkbox" name="reqAgreeRules" value="Y">
                (digital signature)</font></p>
              <div align="center"><font color="#0000FF" size="+1">Note: Clicking 
                any button below will not erase other student entries!</font></div>
              <table width="100%" border="1">
                <tr> 
                  <td width="25%"> <div align="center"> <font size="+1"> <strong>Click 
                      below to submit this performance information</strong> </font> 
                    </div></td>
                  <td width="25%"> <div align="center"> <font size="+1"> <strong>Click 
                      below to reset just this page's information so I can enter 
                      something else</strong></font> </div></td>
                  <td width="25%"> <div align="center"> <font size="+1"> <strong>Click 
                      below to go back to the Studio Administration page</strong></font> 
                      (and not register this performance)</div></td>
                </tr>
                <tr> 
                  <td> <div align="center"> 
                      <input name="btnSubmitPerf" type="submit" id="btnSubmitPerf" value="Submit Performance">
                    </div></td>
                  <td> <div align="center"> 
                      <input type="button" name="Refresh" value="Oops! Clear Just This Page" onClick="clearFields(this)">
                    </div></td>
                  <td> <div align="center"> 
                      <input type="button" name="StartOver" value="Back to Studio Administration" onClick="window.location='StudioAdmin.php'">
                    </div></td>
                </tr>
              </table>
		   
   </td>
  </tr>
</table>	 
</form>
<?php include('../php/TableEnd.php'); ?>

</body>
</html>
