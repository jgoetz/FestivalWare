<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>Festivalware Demo Festival Administration</title>
<meta name=title content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js">
</script>
<script language="JavaScript">
function ChangeInfo()
{
	var val = document.frmFestivals.selChangeOrganizer.value;
	// redirect to another page...
		location.href="OrganizerChangeInfo.php?oid=" + val;
}
</script>
<body bgcolor="99CC99" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../php/TableStart.php'); ?>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

// get the GET data
	$festivalID = "nothing";
	$existing = false;
	
	// if updating an existing festival (existing = 1)
	// remember the festival ID for other pages
	if ($_GET['existing'] == "y") 
	{
		$existing = true;
		if(isset($_POST['selFestivalID']))
		{
			$_SESSION['FestivalID'] = $_POST['selFestivalID'];
			$festivalID = $_POST['selFestivalID'];
		}
		else // must be from the Organizer's update/add pages
		{
			$festivalID = $_SESSION['FestivalID'];
		}
		$sql = "SELECT * FROM Festivals WHERE FestivalID='$festivalID'";
		$result = mysql_query($sql, $selconn) or die(mysql_error());
		$festivalRow = mysql_fetch_array($result);
	}
	unset($_SESSION['RegisteredFestival'] );

	// get the list of possible organizers for this organization
	 $sql="SELECT * FROM Organizers WHERE OrganizationID='$_SESSION[OrganizationID]' ORDER BY OrganizerLastName";
	 $result = mysql_query($sql, $selconn) or die(mysql_error());
	 // create the associative array here
	 $organizerArray = array();
	 $index = 0;
	 $max = 0;
	 while($row = mysql_fetch_array($result))
	 {
		$organizerArray[$index] = array(1 => $row['OrganizerID'] , 2 => $row['OrganizerFirstName'] . " " . $row['OrganizerLastName']);	
		$index++;
	 }
	 $max = $index; // save the max count of organizers for this organization

	function DateConvertFromDB ( $date)
	{
		$parts = explode("-", $date);
		$day = $parts[2];
		$month = $parts[1];
		$year = $parts[0];
		return "$month-$day-$year";
	}
?>

       <table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
          <tr align="left" valign="top"> 
            <td> 
              <h3><br><font face="arial,helvetica,sans-serif"> Festival Administration </font></h3>

			<?php
			if ($existing)
			{
				print "<form method=\"post\" name=\"frmFestivals\" onSubmit=\"return checkReqEntries(this)\" action=\"FestivalUpdateDB.php\"><br>";
				print "<input type=\"hidden\" name=\"hdnFestivalID\" value=\"$festivalID\"><br>";
			}
			else
			{
				print "<form method=\"post\" name=\"frmFestivals\" onSubmit=\"return checkReqEntries(this)\" action=\"FestivalAddToDB.php\"><br>";
				print "<input type=\"hidden\" name=\"hdnFestivalID\" value=\"\"><br>";
			}
			?>
                <table width="75%" border="1" align="center" bgcolor="99CCFF">
                  <tr><th><h2>Festival Information</h2><br> 
				  		<?php 
						// lookup previous festival 
							if ($existing)
							{
								print "Change your information below, then click here ";
								print "<input type=\"submit\" name=\"btnUpdate\" value=\"Update\">";
							}
							else
							{
								print "Enter your information below, then click here ";
								print "<input type=\"submit\" name=\"btnSubmit\" value=\"Submit\">";
							}
						?>
					  <input name="btnCancel" type="button" onClick="window.location='CoordinatorSelector.php'" value="Cancel">
					</th></tr>
			<tr><td>
				<table> 
				   <tr>
                    <td align="right">Organization ID: </td>
                    <td> <input name="reqOrgID" type="text" title="Organization ID" value="<?php print $_SESSION['OrganizationID']; ?>" size="8" maxlength="8"  readonly="true"></td>
                  </tr>
                  <tr> 
                    <td align="right">Organization Name:</td>
                     <td><input name="reqOrgName" type="text"title="Organization Name" value="<?php print $_SESSION['OrganizationName']; ?>" size="50" maxlength="50"  readonly="true"></td>
                  </tr>
				  <tr> 
                    <td align="right">Festival Name:</td>
                     <td><input name="reqFestivalName" type="text" title="Festival Name"  tabindex="1" value="<?php if($existing) print "$festivalRow[FestivalName]"; ?>" size="50" maxlength="50" >
					 </td>
                  </tr>
				  <?php 
				  	if($existing)
				   {	
						print "<tr><td align=\"right\">Festival ID:</td>";
						print "<td><input name=\"reqFestivalID\" type=\"text\" title=\"Festival ID\" value=\"$festivalID\" readonly=\"true\">";
						print "</td></tr>";
                   }
				  ?>
				   <tr> 
                    <td align="right">Welcome Message: </td>
                     <td><input name="reqWelcome" type="text" title="Welcome Message"  tabindex="2" value="<?php if($existing) print "$festivalRow[WelcomeMessage]"; ?>" size="55" maxlength="50"></td>
                  </tr>
				</table>
				<table width="100%"><tr><td align="center"><h5>Please enter dates in mm-dd-yyyy format</h5></td></tr></table>
				  <table>
				  <tr> 
                    <td align="right">Festival dates: </td>
                    <td>
					  <table>
						<tr><td align="right">Start date: </td><td align="left"> <input name="reqFestStartDate" type="text"  tabindex="3" title="Festival Start Date"  value="<?php if($existing) print DateConvertFromDB($festivalRow['EventStartDate']); ?>" size="15" maxlength="15"></td></tr>
						<tr><td align="right"> End date:</td> <td align="left"><input name="reqFestEndDate" type="text"  tabindex="4" title="Festival End Date"  value="<?php if($existing) print DateConvertFromDB($festivalRow['EventEndDate']); ?>" size="15" maxlength="15"></td></tr>
                  	  </table>
				  </tr>
				  <tr> 
                    <td align="right">Studio Registration dates: </td>
                    <td>
					  <table>
						<tr><td align="right">Start date: </td><td align="left"> <input name="reqStudioRegStartDate" type="text"  tabindex="5" title="Studio Registration Start Date"  value="<?php if($existing) print DateConvertFromDB($festivalRow['StudioRegStart']); ?>" size="15" maxlength="15">  </td></tr>
						<tr><td align="right">End date: </td><td align="left"> <input name="reqStudioRegEndDate" type="text"  tabindex="6" title="Studio Registration End Date"  value="<?php if($existing) print DateConvertFromDB($festivalRow['StudioRegEnd']); ?>" size="15" maxlength="15"></td></tr>
                  	  </table>
				  </tr>
				  <tr> 
                    <td align="right">Student Registration dates: </td>
                    <td>
					  <table>
						<tr><td align="right">Start date: </td><td align="left"> <input name="reqStudentRegStartDate" type="text"  tabindex="7" title="Student Registration Start Date"  value="<?php if($existing) print DateConvertFromDB($festivalRow['StudentRegStart']); ?>" size="15" maxlength="15"> </td></tr> 
						<tr><td align="right">End date: </td><td align="left"> <input name="reqStudentRegEndDate" type="text"  tabindex="8" title="Student Registration End Date"  value="<?php if($existing) print DateConvertFromDB($festivalRow['StudentRegEnd']); ?>" size="15" maxlength="15"></td></tr>
             	  	  </table>
				  </tr>
 				  <tr> 
                    <td align="right">Performance Registration dates: </td>
                    <td>
					  <table>
						<tr><td align="right">Start date:</td><td align="left">  <input name="reqPerfRegStartDate" type="text"  tabindex="9"  title="Performance Registration Start Date"  value="<?php if($existing) print DateConvertFromDB($festivalRow['PerformanceRegStart']); ?>" size="15" maxlength="15"> </td></tr>
						<tr><td align="right">End date:</td><td align="left">  <input name="reqPerfRegEndDate" type="text"  tabindex="10"  title="Performance Registration End Date" value="<?php if($existing) print DateConvertFromDB($festivalRow['PerformanceRegEnd']); ?>" size="15" maxlength="15"></td></tr>
		           	  </table>
				  </tr>
 				  <tr> 
                    <td align="right">Performance Scheduling dates: </td>
                    <td>
					  <table>
						<tr><td align="right">Start date:</td><td align="left">  <input name="reqPerfSchedStartDate" type="text"  tabindex="11"  title="Performance Scheduling Start Date" value="<?php if($existing) print DateConvertFromDB($festivalRow['PerformanceSchedStart']); ?>" size="15" maxlength="15"></td></tr> 
						<tr><td align="right">End date: </td><td align="left"> <input name="reqPerfSchedEndDate" type="text"  tabindex="12"  title="Performance Scheduling End Date" value="<?php if($existing) print DateConvertFromDB($festivalRow['PerformanceSchedEnd']); ?>" size="15" maxlength="15"></td></tr>
                     </table>
				  </tr>
				</table>
	</td></tr>
	<tr><td>
	<table width="100%">
		<tr><th colspan="2"><h2 align="center">Festival Format</h2></th></tr>
		<tr><td colspan="2"><strong>Select one of the following:</strong></td>
		<tr><td align="right" width="50%">Recital by performance level </td><td align="left" width="50%"><input type="radio" name="rdoFormat" value="Recital_PerfLevel" <?php if($existing and ($festivalRow['Format'] == 'Recital_PerfLevel')) print("checked"); ?>></td></tr>
		<tr><td align="right">Recital by studio </td><td align="left"><input type="radio" name="rdoFormat" value="Recital_Studio" <?php if($existing and ($festivalRow['Format'] == 'Recital_Studio')) print("checked"); ?>></td></tr>
		<tr><td align="right">Recital by student </td><td align="left"><input type="radio" name="rdoFormat" value="Recital_Individual" <?php if($existing and ($festivalRow['Format'] == 'Recital_Individual')) print("checked"); ?>></td></tr>
		<tr><td align="right">Normal (studios schedule students) </td><td align="left"><input type="radio" name="rdoFormat" value="Normal" <?php if($existing and ($festivalRow['Format'] == 'Normal')) print("checked"); ?>></td></tr>
	</table>
	</td></tr>
	<tr><td>
				<tr><th><h2>Festival Job Assignments</h2></th></tr>
                <tr><td><div align="center"><strong>
						The Festival Organizer must not be blank<br>
                      If any other job assignment is not to be filled, or will be filled at a later time, 
					  just leave the name blank. </strong>
				</div></td></tr>
				  <tr>
                    <td align="center">Click here to add a new organizer to your list <br>
                      <input name="btnNewOrganizer"  type="button" value="Add New Organizer" onClick="location='OrganizerAddNew.php'">
					</td></tr>
				  <tr>
                  <td align="center">Click here to change the selected organizer's information <br>
				  <select name="selChangeOrganizer">
					  <?php 
						for($index = 0; $index < $max; $index++)
							print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
					  ?>
				  </select>
                    <input name="btnChangeOrganizer" type="button" value="Change Organizer Info" onClick="ChangeInfo()"></td>
                </tr>
				 <tr><td>
				<table align="center" width="80%">
				  <tr>
				  	<th align="right" width="30%">Festival Organizer</th>
				  	<td align="center" width="30%">
				 	  <select name="selOrganizer" title="Organizer">
					  <?php 
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['OrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  
				  <tr>
				  	<th align="right">Assistant Organizer</th>
				  	<td align="center">
				 	  <select name="selAssistantOrganizer" title="Assistant Organizer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['AssistantOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				  <tr>
				  	<th align="right">Treasurer</th>
				  	<td align="center">
				 	  <select name="selTreasurerOrganizer" title="Treasurer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['TreasurerOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				  <tr>
				  	<th align="right">Awards Organizer</th>
				  	<td align="center">
				 	  <select name="selAwardsOrganizer" title="Awards Organizer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['AwardsOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				  <tr>
				  	    <th align="right">Phone Organizer</th>
				  	<td align="center">
				 	  <select name="selFoneOrganizer" title="Phone Organizer">
					  	<option value="0" title="Phone Organizer">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['PhoneOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				  <tr>
				  	    <th align="right">Mailings Organizer</th>
				  	<td align="center">
				 	  <select name="selMailingsOrganizer" title="Mailings Organizer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['MailingsOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				  <tr>
				  	    <th  align="right">Monitor Organizer</th>
				  	<td  align="center">
				 	  <select name="selMonitorOrganizer" title="Monitor Organizer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['MonitorOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				  <tr>
				  	<th  align="right">Facilities Organizer</th>
				  	<td  align="center">
				 	  <select name="selFacilitiesOrganizer" title="Facilities Organizer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['FacilitiesOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				  <tr>
				  	<th  align="right">Judging Organizer</th>
				  	<td  align="center">
				 	  <select name="selJudgingOrganizer" title="Judging Organizer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['JudgingOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  
				  <tr>
				  	<th  align="right">Auditing Organizer</th>
				  	<td  align="center">
				 	  <select name="selAuditingOrganizer" title="Auditing Organizer">
					  	<option value="0">Not Assigned</option>
					  <?php 
						
						for($index = 0; $index < $max; $index++)
						{
						 	if($existing && ($organizerArray[$index][1] == $festivalRow['AuditingOrganizerID']) )
								print "<option value=\"" . $organizerArray[$index][1] . "\" selected>" . $organizerArray[$index][2] . "</option><br>";
							else
								print "<option value=\"" . $organizerArray[$index][1] . "\">" . $organizerArray[$index][2] . "</option><br>";
						 }						 
					  ?>
					  </select>
					</td>
				 </tr>				  

				</table>
				<p>&nbsp;</p></td></tr>
				<tr><td align="center">
				<?php
					if ($existing)
					{
						print "<input type=\"submit\" name=\"btnUpdate\" title=\"Update Button\" value=\"Update\">";
					}
					else
					{
						print "<input type=\"submit\" name=\"btnSubmit\" title=\"Submit Button\" value=\"Submit\">";
					}
				?>
                <input name="btnCancel" type="button" onClick="window.location='CoordinatorSelector.php'" value="Cancel">

				</td></tr>
                </table>				
				<br>
			  </form>
           </tr>
        </table>
<?php include('../php/TableEnd.php'); ?>

</body>


</html>
