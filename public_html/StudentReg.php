<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Student Registration</title>
<meta name=title content="">
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
	// lookup student registration start,end dates; check against current date
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// get the festival specific dates, etc.
	$sql = "SELECT * FROM Festivals";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	
	$FestivalsRow = mysql_fetch_array($result);

	// now get the festival's date, and convert to English
	$festivalDate = $FestivalsRow['EventDate'];
	$sql = "SELECT UNIX_TIMESTAMP('$festivalDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$dateString = date("l, F d, Y", $dateRow['MyTimeSt']);
	
	// now get student registration start date, and convert to English
	$festivalDate = $FestivalsRow['StudentRegStart'];
	$sql = "SELECT UNIX_TIMESTAMP('$festivalDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$startString = date("l, F d, Y", $dateRow['MyTimeSt']);
	
	// now get student registration end date, and convert to English
	$festivalDate = $FestivalsRow['StudentRegEnd'];
	$sql = "SELECT UNIX_TIMESTAMP('$festivalDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$endString = date("l, F d, Y", $dateRow['MyTimeSt']);


 	$today = date("Y-m-d");
	// if today is before registration starts, or after registration ends, serve "no reg today" page
	// if today is after the festival is over, just send them back
	if ($festivalDate < $today)
	{
?>
		<p><font face="arial,helvetica,sans-serif"> 
		<h2>*******Your festival was held on <?php print $dateString; ?></h2></font></p>
		
		<h3> <strong>Thanks for visiting the student registration page!</strong> </h3>
		<p>Hope to see you again!</p>
		<input type="button" name="btnBackToStudioAdmin" onClick="location='StudioAdmin.php'" value="Back to Studio Administration">
<?php
		
	}
	else if($today < $FestivalsRow['StudentRegStart'])
	{
?>
		<p><font face="arial,helvetica,sans-serif"> 
		<h2>**********Your festival will be held on <?php print $dateString; ?></h2></font></p>
		
		<h3> <strong>Thanks for visiting the student registration page!</strong> </h3>
		
		<p>Student registration will be available beginning
		<font size="+1"> <?php print $startString; ?> </font></p>
		<p>and will close on 
		<font size="+1"><?php print $endString; ?></font></p>

		<p>Please visit then to register your students!</p>
		<p><font face="Arial"> Please see our <a href="FAQ.html">FAQ page 
		</a>for answers to your questions.<br>
		If you have a question that isn't answered there, <br>
		contact your festival organizer for more information. 
		</font></p>
		<p>&nbsp;</p>
		<input type="button" name="btnBackToStudioAdmin" onClick="location='StudioAdmin.php'" value="Back to Studio Administration">

<?php
	}
	else if ($FestivalsRow['StudentRegEnd'] < $today) 
	{
?>
		<p><font face="arial,helvetica,sans-serif"> 
		<h2>**********Your festival will be held on <?php print $dateString; ?></h2></font></p>
		
		<h3> <strong>Thanks for visiting the student registration page!</strong> </h3>
		
		<p>Sorry, Student registration is no longer available for this festival.
		<p><font face="Arial"> Please see our <a href="FAQ.html">FAQ page 
		</a>for answers to your questions.<br>
		If you have a question that isn't answered there, <br>
		contact your festival organizer for more information. 
		</font></p>
		<p>&nbsp;</p>
		<input type="button" name="btnBackToStudioAdmin" onClick="location='StudioAdmin.php'" value="Back to Studio Administration">
<?php
	}
	else // today is in date range
	{
?>
		 <h2 align="center">New Student Registration Page</h2>
		  <span style="text-transform: uppercase">
		  	<font face="Geneva, Arial, Helvetica, sans-serif" size="2"> 
			Required entries in <font size="+1" color="#ff0000">Red</font>
			</font> 
		  </span>
<form  method="post" name="StudentRegistration" onSubmit="return checkReqEntries(this)" action="StudentAddToDB.php">
<table border="0">
<tr>
	<td align="right" width="50%"><font size="+1" color="#ff0000">Student's First Name: </font> </td>
	<td width="50%"><input type="text" maxlength="30" size="30" name="reqFirstName" title="First Name"/></td>
</tr>
<tr>
	<td align="right"> <font size="+1" color="#ff0000">Student's Middle Name: </font> </td>
	<td>  <input type="text" maxlength="30" size="30" name="optMiddleName" title="Middle Name"></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Student's Last Name: </font> </td>
	<td> <input type="text" maxlength="50" size="30" name="reqLastName" title="Last Name"/></td>
</tr>
<tr>
	<td align="right"><font size="+1">Student's Email: </font> </td>
	<td> <input type="text" maxlength="50" size="30" name="optStudentEmail" title="Student Email"/></td>
</tr>
<tr>
	<td colspan="2" align="center">
	<font size="2">Please use the parent's email if student doesn't have an email address</font><br></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Student's street address</font>: </td>
	<td><input type="text" maxlength="75" size="50" name="reqStreetAddress" title="Street Address"/></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Student's City</font>: </td>
	<td><input type="text" maxlength="25" size="25" name="reqCity" value="Las Vegas" title="City"/></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Student's State</font>: </td>
	<td><select  size="1" name="reqState" title="State">
		<option>AL</option><option>AK</option><option>AZ</option><option>AR</option><option>CA</option><option>CO</option><option>CT</option><option>DE</option><option>DC</option><option>FL</option><option>GA</option><option>HI</option><option>ID</option><option>IL</option><option>IN</option><option>IA</option><option>KS</option><option>KY</option><option>LA</option><option>ME</option><option>MD</option><option>MA</option><option>MI</option><option>MN</option><option>MS</option><option>MO</option><option>MT</option><option>NE</option><option selected>NV</option><option>NH</option><option>NJ</option><option>NM</option><option>NY</option><option>NC</option><option>ND</option><option>OH</option><option>OK</option><option>OR</option><option>PA</option><option>PR</option><option>RI</option><option>SC</option><option>SD</option><option>TN</option><option>TX</option><option>UT</option><option>VT</option><option>VA</option><option>WA</option><option>WV</option><option>WI</option><option>WY</option></select>
	</td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Student's Zip code</font>: </td>
	<td><input type="text" maxlength="5" size="7" name="reqZip" title="Zip Code" numeric="true"/></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Student's Phone number</font>: 
	<td><input type="text" maxlength="15" size="15" name="reqPhoneNumber" title="Student's Phone Number" phone="true"/></td>
</tr>
<tr>
	<td colspan="2" align="center"><font size="2">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font><br></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Student's Birthdate</font> 
	<td><input type="text" maxlength="15" size="15" name="reqBirthdate" title="Birthdate" date="true"/></td>
</tr>
<tr>
	<td align="center" colspan="2"><font size="-1">(Please enter in the form MM-DD-YYYY)</font><br></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Parent's full name</font>: </td>
	<td><input type="text" maxlength="30" size="30" name="reqParentsName" title="Parent's Full Name"/></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Parent's phone number</font> </td>
	<td><input type="text" maxlength="12" size="15" name="reqParentsPhone" title="Parent's Phone Number" phone="true"/></td>
</tr>
<tr>
	<td align="center" colspan="2">
	<font size="-1">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font><br></td>
</tr>
<tr>
	<td align="right"><font size="+1" color="#ff0000">Is student willing to be a monitor on festival day?</font></td>
	<td align="left"><label><input type="radio" name="rdoMonitor" value="Y">Yes</label>
		<label><input type="radio" name="rdoMonitor"  value="N" checked>No</label>
	</td>
</tr>
<tr><td colspan="2" align="center">
   <table width="80%" border="1">
	  <tr> 
		<td width="44%"> <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">Click 
			below to register the student and return to the Studio 
			Administration Page </font></div></td>
		<td width="12%">&nbsp;</td>
		<td width="44%"> <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">Click 
			below to return to the Studio Administration page without 
			registering the student</font></div></td>
	  </tr>
	  <tr> 
		<td height="62"> 
		  <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
			<input name="btnRegisterStudent" type="submit" value="Register student">
			</font></div></td>
		<td> </td>
		<td> <div align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
			<input name="btnStudioAdmin" type="button" id="btnStudioAdmin" onClick="window.location='StudioAdmin.php'" value="Back to Studio Administration">
			</font></div></td>
	  </tr>
	</table>
</td></tr>
<tr><td><input type="hidden" name="hdnStudioName" value="<?php print $_SESSION['StudioName']?>" title="Studio Name">
</td><td><input type="hidden" name="hdnStudioID" value="<?php print $_SESSION['StudioID']?>" title="Studio ID">
</td></tr>
</table>              
</form>

<?php
} // end else section
?>
    </td>
  </tr>
</table>
<?php include('../php/TableEnd.php'); ?>

</body>
</html>