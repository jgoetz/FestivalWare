<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Administration Change Student Information</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>

<script language="JavaScript">
<!--
function checkSpecial(which)
{
	if( checkReqEntries(which) == true)
	{
		if(document.frmStudentRegistration.hdnStudentsStudioID.value != 
			 document.frmStudentRegistration.hdnMyStudioID.value)
		{
			return confirm("Continuing will register the student for 2004 with your studio. \nAre you sure you want to continue?");
		}
		return true;
	}
	return false;
}
-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form  method="post" name="frmStudentRegistration" onSubmit="return checkReqEntries(this)" action="AdminStudentUpdateDB.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="img/lightbrown.jpg">
        <tr align="left" valign="top"> 
            <td colspan="2" align="center"> 
			<h2>Modify Student Information Page</h2>
			</td></tr>
		<tr><td colspan="2" align="center">
 			<h3>Please check and correct the following information. </h3>
		</td></tr>
		<tr><td colspan="2" align="center"><span style="text-transform: uppercase">
			<font face="Geneva, Arial, Helvetica, sans-serif" size="2">
			Required entries in <font size="+1" color="#ff0000">Red</font> </font></span>
		</td></tr>

<?php 

// The StudentID session variable was unregistered in StudentListAllMatches. 
// Re-register it now, and place the POST value of the select object
// into the session variable.
	$_SESSION['StudentID'] = $_POST['reqSelChooseStudent'];

// lookup student by studentID, get all info and show in form

	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

$sql = "select * from Students where StudentID = '" . $_SESSION['StudentID'] . "'";
$result = mysql_query ($sql, $selconn) or die(mysql_error());

$row = mysql_fetch_array($result);
?>

<tr><td width="50%" align="right">Studio ID: </td><td width="50%"><input type="text" readonly="true" name="txtStudentsStudioID" value="<?php print $row['StudentStudioID']; ?>" title="Students Studio ID"></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's First Name: </font> </td>
	<td><input maxlength="30" size="30" name="FirstName" description="First Name" value="<?php print  $row['StudentFirstName'] ; ?>"/></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's Middle Name: </font> </td>
	<td><input  maxlength="30" size="30" name="MiddleName" description="Middle Name"  value="<?php print  $row['StudentMiddleName'] ; ?>"/></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's Last Name: </font> </td>
	<td><input  maxlength="50" size="30" name="LastName" description="Last Name" value="<?php print  $row['StudentLastName'] ; ?>"/></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's Email: </font></td>
	<td><input  maxlength="50" size="30" name="StudentEmail" value="<?php print  $row['StudentEmail']; ?>" optional="true" description="Student Email" email="true"/><br></td>
</tr>
<tr><td colspan="2" align="center"> <font size="-1">Please use the parent's email if student doesn't have an email address</font></td>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's street address</font>: </td>
	<td><input maxlength="75" size="50" name="StreetAddress" description="Street Address" value="<?php print  $row['StudentAddr'] ; ?>"/></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's City</font>: </td>
	<td><input maxlength="25" size="25" name="City" description="City" value="<?php print  $row['StudentCity'] ; ?>"/></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's State</font>: </td>
	<td><select  size="1" name="State" description="State" >

<?php 
$states = array("AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX","UT","VT","VA","WA","WV","WI","WY");
foreach ($states as $st)
{
	if($st == $row['StudentState'])
		print "<option selected>";
	else
		print "<option>";
	echo $st . "</option>";
}
?>

  </select></td></tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's Zip code</font>: </td>
	<td><input maxlength="5" size="7" name="Zip" description="Zip Code" numeric="true" value="<?php print  $row['StudentZip'] ; ?>"/></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's Phone number</font>: </td>
	<td><input   maxlength="12" size="15" name="PhoneNumber" description="Student's Phone Number" phone="true" value="<?php print  $row['StudentPhone'] ; ?>"/></td>
</tr>
<tr><td colspan="2" align="center"><font size="2">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font></td></tr>


<?php 
	$birthdate = $row['Birthdate'];
	if(strlen($birthdate) > 0)
	{
		$pattern = "/(\d{4})-(\d{1,2})-(\d{1,2})/";
		$replace = "\$2-\$3-\$1";
		$birthdate = preg_replace($pattern, $replace, $birthdate);
	}
?>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Student's Birthdate</font>: </td>
	<td><input  maxlength="15" size="15" name="Birthdate" description="Birthdate" date="true" value="<?php print  $birthdate; ?>"/></td>
</tr>
<tr><td colspan="2" align="center"><font size="2">(Please enter in the form MM-DD-YYYY)</font></td></tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Parent's full name</font>: </td>
	<td><input maxlength="30" size="30" name="ParentsName" description="Parent's Full Name" value="<?php print  $row['ParentName']; ?>"/></p></td>
</tr>
<tr><td align="right" height="30"><font size="+1" color="#ff0000">Parent's phone number</font>: </td>
	<td><input maxlength="12" size="15" name="ParentsPhone" description="Parent's Phone Number" phone="true" value="<?php print  $row['ParentPhone']; ?>"/></td>
</tr>
<tr><td colspan="2" align="center"><font size="2">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font></td></tr>

<tr><td align="right" height="30"><font size="+1" color="#ff0000">Is student willing to be a monitor on festival day?</font></td>
<td align="left">  
  				
	<?php 
	if($row['Monitor'] == 'Y')
		print "<label><input type=\"radio\" name=\"Monitor\" value=\"Y\" checked>";
	else
		print "<label><input type=\"radio\" name=\"Monitor\" value=\"Y\">";
	?>
					Yes</label>
					
	
	<?php 
	if($row['Monitor'] == 'N')
		print "<label><input type=\"radio\" name=\"Monitor\"  value=\"N\" checked>";
	else
		print "<label><input type=\"radio\" name=\"Monitor\"  value=\"N\">";
	?>
				No</label>
</td>
		</tr>

<?php
	mysql_close($selconn);
?>
<tr><td colspan="2">

           <table width="100%" border="1">
                <tr> 
                  <td width="44%">
				  	<div align="center"> <font size="+1">Make any changes to the 
                      above information, then click below</font> </div>
                  </td>
                  <td width="12%">&nbsp;</td>
                  <td width="44%">
				    <div align="center"> 
						<font size="+1">Click below to return to the Studio Administration Page
						</font> 
					</div>
				  </td>
                </tr>
                <tr> 
                  <td>
				    <div align="center"> 
                      <input type="submit" name="UpdateInfo" value="Update Student Information" >
                    </div></td>
                  <td> </td>
                  <td>
				    <div align="center">
				  	  <input type="button" name="StartOver" value="Studio Administration" onClick="window.location='StudioAdmin.php'">
                    </div>
				  </td>
                </tr>
              </table>
</td></tr>
</table>
            </form>

<?php include('../php/TableEnd.php'); ?>
</body>
</html>
