<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Festival Add New Organizer</title>
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
			 <br><h2>New Organizer Added</h2>
		  </td>
		</tr>
		<tr><td>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$addconn = mysql_connect ( "localhost","festival_adder","ri945mk") or die(mysql_error()); 
	mysql_select_db($database, $addconn) or die(mysql_error());

			    $salt = substr($_POST['reqOrgLoginID'], 0, 2);
				$passwd = crypt($_POST['reqOrgPwd1'], $salt);

				$sql = "insert into Organizers values (
						'',  
						'" . $_SESSION['OrganizationID'] . "', 
						'" . addslashes($_POST['reqOrgFirstName']) . "', 
						'" . addslashes($_POST['reqOrgLastName']) . "',
						'" . addslashes($_POST['reqOrgLoginID']) . "',
						'" . $passwd . "',
						'" . addslashes($_POST['reqOrgEmail']) . "',
						'" . addslashes($_POST['reqOrgPhone']) . "',
						'" . addslashes($_POST['reqOrgAddress']) . "',
						'" . addslashes($_POST['reqOrgCity']) . "',
						'" . addslashes($_POST['reqOrgState']) . "',
						'" . addslashes($_POST['reqOrgZip']) . "')";

				$result = mysql_query ($sql, $addconn) or die(mysql_error());
			   // if you reach this point, you have entered the record. 
			   // **********************
			   //set a session variable so that you can't refresh the page and reenter the same record again
			   
			   mysql_close($addconn);
?>
			<p align="center"> 
			<font face="Georgia, Times New Roman, Times, serif" size="+1"> 
			  <strong>
			  <br><br>
              Congratulations! <br>
              You have successfully added <br />
              <?php print $_POST['reqOrgFirstName'] . " " . $_POST['reqOrgLastName']; ?> 
			  <br> as a new Organizer.
			  <br>
			  Click below to return to the Coordinator's Action Page
			  <input type="button" name="back" value="Back to Coordinator's Action Page" onClick="location='CoordinatorSelector.php'">
			  </strong>
			  </font>
 		</td></tr>
      </table> 

<?php include('../php/TableEnd.php'); ?>

</body>
</html>