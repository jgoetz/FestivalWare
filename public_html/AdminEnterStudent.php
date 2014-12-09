<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>FestivalWare Home Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="RollOvers.js"></script>
</head>

<body bgcolor="#91F4FF">

<?php include('../php/TableStart.php'); ?>
<!-- main page area here -->

<table background="img/lightbrown.jpg">
  <tr valign="top"><td colspan="2"> <h2 align="center">Festival Administration <br>New Student Entry Page</h2></td></tr>
  <tr><td colspan="2" align="center"> <span style="text-transform: uppercase">
		  	<font face="Geneva, Arial, Helvetica, sans-serif" size="2"> 
			Required entries in <font size="+1" color="#FF0000">Red</font>
			</font> 
		  </span>
  </td></tr>		 
	<tr><td>
		<form  method="post" name="StudentRegistration" onSubmit="return checkReqEntries(this)" action="AdminStudentAddToDB.php">
		<table border="0">
		<tr>
			<td align="right" width="50%">&nbsp;</td>
			<td width="50%">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Select the Studio: </font> </td>
			<td><select name="reqSelStudio" title="Select Studio">
				<option value="-1">Select a Studio</option>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "SELECT * FROM Studios";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{
		print "<option value=\"$row[StudioID]\">$row[StudioName] ($row[StudioFirstName] $row[StudioLastName])</option>";
	}	
?>
			</select>
			</td>
		</tr>
		<tr>
			<td align="right" ><font size="+1" color="#FF0000">Student's First Name: </font> </td>
			<td><input type="text" maxlength="30" size="30" name="reqFirstName" title="First Name"/></td>
		</tr>
		<tr>
			<td align="right"> <font size="+1" color="#FF0000">Student's Middle Name: </font> </td>
			<td>  <input type="text" maxlength="30" size="30" name="optMiddleName" title="Middle Name"></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Student's Last Name: </font> </td>
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
			<td align="right"><font size="+1" color="#FF0000">Student's street address</font>: </td>
			<td><input type="text" maxlength="75" size="50" name="reqStreetAddress" title="Street Address"/></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Student's City</font>: </td>
			<td><input type="text" maxlength="25" size="25" name="reqCity" value="Las Vegas" title="City"/></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Student's State</font>: </td>
			<td><select  size="1" name="reqState" title="State">
				<option>AL</option><option>AK</option><option>AZ</option><option>AR</option><option>CA</option><option>CO</option><option>CT</option><option>DE</option><option>DC</option><option>FL</option><option>GA</option><option>HI</option><option>ID</option><option>IL</option><option>IN</option><option>IA</option><option>KS</option><option>KY</option><option>LA</option><option>ME</option><option>MD</option><option>MA</option><option>MI</option><option>MN</option><option>MS</option><option>MO</option><option>MT</option><option>NE</option><option selected>NV</option><option>NH</option><option>NJ</option><option>NM</option><option>NY</option><option>NC</option><option>ND</option><option>OH</option><option>OK</option><option>OR</option><option>PA</option><option>PR</option><option>RI</option><option>SC</option><option>SD</option><option>TN</option><option>TX</option><option>UT</option><option>VT</option><option>VA</option><option>WA</option><option>WV</option><option>WI</option><option>WY</option></select>
			</td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Student's Zip code</font>: </td>
			<td><input type="text" maxlength="5" size="7" name="reqZip" title="Zip Code" numeric="true"/></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Student's Phone number</font>: 
			<td><input type="text" maxlength="15" size="15" name="reqPhoneNumber" title="Student's Phone Number" phone="true"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><font size="2">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font><br></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Student's Birthdate</font> 
			<td><input type="text" maxlength="15" size="15" name="reqBirthdate" title="Birthdate" date="true"/></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><font size="-1">(Please enter in the form MM-DD-YYYY)</font><br></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Parent's full name</font>: </td>
			<td><input type="text" maxlength="30" size="30" name="reqParentsName" title="Parent's Full Name"/></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Parent's phone number</font> </td>
			<td><input type="text" maxlength="12" size="15" name="reqParentsPhone" title="Parent's Phone Number" phone="true"/></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<font size="-1">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font><br></td>
		</tr>
		<tr>
			<td align="right"><font size="+1" color="#FF0000">Is student willing to be a monitor on festival day?</font></td>
			<td align="left"><label><input type="radio" name="rdoMonitor" value="Y">Yes</label>
				<label><input type="radio" name="rdoMonitor"  value="N" checked>No</label>
			</td>
		</tr>
		<tr><td colspan="2" align="center">
		   <table width="80%" border="1">
			  <tr> 
				<td width="44%" align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">Click 
					below to register the student and return to the Studio 
					Administration Page </font></td>
				<td width="12%">&nbsp;</td>
				<td width="44%" align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">Click 
					below to return to the Festival Administration page without 
					registering the student</font></td>
			  </tr>
			  <tr> 
				<td height="62" align="center"> 
				<font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
					<input name="btnRegisterStudent" type="submit" value="Register student">
				</font></td>
				<td> </td>
				<td align="center"> <font size="+1" face="Verdana, Arial, Helvetica, sans-serif">
					<input name="btnStudioAdmin" type="button" id="btnStudioAdmin" onClick="window.location='Administration.php'" value="Back to Festival Administration">
					</font></td>
			  </tr>
			</table>
		</td></tr>
		</table>              
		</form>
	

    </td>
  </tr>
</table>


<?php include('../php/TableEnd.php'); ?>

</body>
</html>
