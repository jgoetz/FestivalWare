<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Add New Festival Organizer </title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js">
</script>
<body bgcolor="FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../php/TableStart.php'); ?>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());

?>
	<form name="frmChangeFestivalOrganizer" action="OrganizerAddToDB.php" method="post" onSubmit="return checkReqEntries(this)">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr align="left" valign="top"> 
            <td> <br><h3 align="center">
                <font face="arial,helvetica,sans-serif"> Add New Organizer</font></h3>

	  <table width="73%" border="1px" align="center" bgcolor="#CCFFFF">
		<tr> 
		  <td width="50%" align="right">Organizer's First name</td>
		  <td align="left"><input type="text" maxlength="15" name="reqOrgFirstName" value="" title="Organizer's First Name"></td>
		</tr>
		<tr> 
		  <td align="right"><p>Organizer's Last name</p></td>
		  <td align="left"><input type="text" maxlength="20" name="reqOrgLastName" value="" title="Organizer's Last Name"></td>
		</tr>
		<tr> 
		  <td align="right">Organizer's LoginID</td>
		  <td align="left"><input type="text" maxlength="15" name="reqOrgLoginID" value="" title="Organizer's Login ID"></td>
		</tr>
		<tr> 
		  <td align="right">Organizer's Password<br>
			Reenter Organizer's Password </td>
		  <td align="left"><input type="password" maxlength="20" name="reqOrgPwd1" value="" title="Organizer's Password">
			<br>
			<input type="password" maxlength="20" name="reqOrgPwd2" value="" title="Password copy">
		  </td>
		</tr>
		<tr> 
		  <td align="right">Organizer's Email</td>
		  <td align="left"><input type="text" maxlength="50" name="reqOrgEmail" value="" title="Organizer's Email"></td>
		</tr>
		<tr> 
		  <td align="right">Organizer's Phone</td>
		  <td align="left"><input type="text" maxlength="12" name="reqOrgPhone" value="" title="Organizer's Phone"></td>
		</tr>
		<tr> 
		  <td align="right">Organizer's Address</td>
		  <td align="left"><input type="text" maxlength="50" name="reqOrgAddress" value="" title="Organizer's Street Address"></td>
		</tr>
		<tr> 
		  <td align="right">Organizer's City</td>
		  <td align="left"><input type="text" maxlength="25" name="reqOrgCity" value="" title="Organizer's City"></td>
		</tr>
		<tr> 
		  <td align="right">Organizer's State</td>
		  <td align="left"><input type="text" maxlength="2" name="reqOrgState" value="" title="Organizer's State"></td>
		</tr>
		<tr> 
		  <td align="right">Organizer's Zipcode</td>
		  <td align="left"><input type="text" maxlength="5" name="reqOrgZip" value="" title="Organizer's Zip Code"></td>
		</tr>
		<tr> 
		  <td align="center" colspan="2">
			  <input name="btnSubmit" type="submit" id="btnSubmit" value="Submit">  
			   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="btnCancel" type="button" id="btnCancel" value="Back to Coordinator's Action Page" onClick="location='CoordinatorSelector.php'">
			</td>
		</tr>
	  </table>
	  </tr>
	</table>
	</form>
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
