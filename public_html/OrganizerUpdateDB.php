<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Organizer Information Changed</title>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr align="left" valign="top"> 
          <td> 
			 <br><h2>Organizer Information Changed</h2>
		  </td>
		</tr>
		<tr><td>
   <?php
	$database = $_SESSION['DatabaseName'];
				
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());
	$updateconn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $updateconn) or die(mysql_error());

			    $salt = substr($_POST['reqOrgLoginID'], 0, 2);
				$passwd = crypt($_POST['reqOrgPwd1'], $salt);

				$sql = "UPDATE Organizers SET 
						OrganizerFirstName = '" . addslashes($_POST['reqOrgFirstName']) ."', 
						OrganizerLastName = '" . addslashes($_POST['reqOrgLastName']). "', 
						OrganizerLoginID = '" . addslashes($_POST['reqOrgLoginID']). "',
						OrganizerPassword = '" . $passwd . "',
						OrganizerEmail = '" . addslashes($_POST['reqOrgEmail']). "',
						OrganizerPhone = '" . addslashes($_POST['reqOrgPhone']). "', 
						OrganizerAddress = '" . addslashes($_POST['reqOrgAddress']). "', 
						OrganizerCity = '" . addslashes($_POST['reqOrgCity']). "', 
						OrganizerState = '" . addslashes($_POST['reqOrgState']). "', 
						OrganizerZip = '" . addslashes($_POST['reqOrgZip']). "'  
						where OrganizerID = '" . $_POST['reqOrgID'] . "'";  

				$result = mysql_query ($sql, $updateconn) or die(mysql_error());
			   // if you reach this point, you have entered the record. 
			   
			   mysql_close($addconn);
		?>
		  
			<p align="center"> 
			<font face="Georgia, Times New Roman, Times, serif" size="+1"> 
            <strong>
			  <br />
              <br />
              Congratulations! <br>
              You have successfully updated <br>
              <font color="#0066FF"><?php print $_POST['reqOrgFirstName'] . " " . $_POST['reqOrgLastName']; ?></font><br>
			  In the Organizer's List.<br>
			   Click below to return to the Coordinator's Action page: 
			  </strong>
			  </font>
 		</td></tr>
		<tr><td align="center"><input type="button" name="btnBack" value="Coordinator's Action Page" onClick="location='CoordinatorSelector.php'"></td></tr>
      </table> 
	</td>
  </tr>
</table>	

<?php include('../php/TableEnd.php'); ?>
</body>
</html>