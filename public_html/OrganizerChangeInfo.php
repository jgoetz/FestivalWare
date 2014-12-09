<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare: Change Festival Organizer Info</title>
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

?>

	<form name="frmChangeFestivalOrganizer" action="OrganizerUpdateDB.php" method="post" onSubmit="return checkReqEntries(this)">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="left" valign="top"> 
            <td> 
              <h3 align="center"><br><font face="arial,helvetica,sans-serif"> Change Festival Organizer Information </font></h3>

<?php
	// get the organizer and festival data passed via GET
	// note that festival ID may not be filled in; it all depends whether the user had
	// selected a festival or was creating a new one. We need this info so if they cancel,
	// we can send them back to the proper page.
	$orgID = $_GET['oid'];
	$festID = $_GET['fid'];
	$sql = "SELECT * FROM Organizers WHERE OrganizerID=$orgID";

	$result = mysql_query($sql, $selconn) or die(mysql_error());
	
	if (mysql_num_rows($result) != 1)
	{
		// print error message
		print "you have entered an incorrect value, or there is an error";
		// quit this page (go back to festival admin)
		print "<input type=\"button\" name=\"btnBack\" value=\"Back to Festival Administration\" onClick-\"location='FestivalAdmin.php'\">";
	}
	else
		$row = mysql_fetch_array($result);

?>
		<input type="hidden" name="reqOrgID" value="<?php print $orgID; ?>">

              <table width="73%" border="1px" align="center" bgcolor="#CCFFFF">
                <tr> 
                  <td width="50%" align="right">Organizer's First name</td>
                  <td align="left"><input type="text" maxlength="15" name="reqOrgFirstName" value="<?php print $row['OrganizerFirstName']?>" title="Organizer's First Name"></td>
                </tr>
                <tr> 
                  <td align="right"><p>Organizer's Last name</p></td>
                  <td align="left"><input type="text" maxlength="20" name="reqOrgLastName" value="<?php print $row['OrganizerLastName']?>" title="Organizer's Last Name"></td>
                </tr>
                <tr> 
                  <td align="right">Organizer's LoginID</td>
                  <td align="left"><input type="text" maxlength="15" name="reqOrgLoginID" value="<?php print $row['OrganizerLoginID']?>" title="Organizer's Login ID"></td>
                </tr>
                <tr> 
                  <td align="right"><p>Organizer's Password<br>Reenter Organizer's Password</p>
                    </td>
                  <td align="left"><input type="password" maxlength="20" name="reqOrgPwd1" value="" title="Organizer's Password">
                    <br>
                    	<input type="password" maxlength="20" name="reqOrgPwd2" value="" title="Password copy"> 
                  </td>
                </tr>
                <tr> 
                  <td align="right">Organizer's Email</td>
                  <td align="left"><input type="text" maxlength="50" name="reqOrgEmail" value="<?php print $row['OrganizerEmail']?>" title="Organizer's Email"></td>
                </tr>
                <tr> 
                  <td align="right">Organizer's Phone</td>
                  <td align="left"><input type="text" maxlength="12" name="reqOrgPhone" value="<?php print $row['OrganizerPhone']?>" title="Organizer's Phone"></td>
                </tr>
                <tr> 
                  <td align="right">Organizer's Address</td>
                  <td align="left"><input type="text" maxlength="50" name="reqOrgAddress" value="<?php print $row['OrganizerAddress']?>" title="Organizer's Street Address"></td>
                </tr>
                <tr> 
                  <td align="right">Organizer's City</td>
                  <td align="left"><input type="text" maxlength="25" name="reqOrgCity" value="<?php print $row['OrganizerCity']?>" title="Organizer's City"></td>
                </tr>
                <tr> 
                  <td align="right">Organizer's State</td>
                  <td align="left"><input type="text" maxlength="2" name="reqOrgState" value="<?php print $row['OrganizerState']?>" title="Organizer's State"></td>
                </tr>
                <tr> 
                  <td align="right">Organizer's Zipcode</td>
                  <td align="left"><input type="text" maxlength="5" name="reqOrgZip" value="<?php print $row['OrganizerZip']?>" title="Organizer's Zip Code"></td>
                </tr>
                <tr> 
                  <td colspan="2" align="center">
                      <input name="btnSubmit" type="submit" id="btnSubmit" value="Submit">  
					   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  		  <input type="button" name="back" value="Back to Coordinator's Action Page" onClick="location='CoordinatorSelector.php'">
                    </td>
                </tr>
              </table>
          </tr>
        </table>
		</form>
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
