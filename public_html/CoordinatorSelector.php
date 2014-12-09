<?php include("IsAuth_Coordinator.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Coordinator's Action Page</title>
<meta name=description content="">
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
	var val = document.frmCoordinatorSelector.selChangeOrganizer.value;
	// redirect to another page...
	location.href="OrganizerChangeInfo.php?oid=" + val;
}
</script>
<body bgcolor="FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<?php
	$database = $_SESSION['DatabaseName'];				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

?>
	<form name="frmCoordinatorSelector" action="FestivalAdmin.php?existing=y" method="post">

	<table width="73%" border="0" align="center">
		<tr><td><h3><font face="arial,helvetica,sans-serif"> FestivalWare Coordinator's Action Page </font></h3></td></tr>
		<tr><td><h3>Organization Name: <?php print $_SESSION['OrganizationName']; ?> </h3></td></tr>
		<tr><td><h3>Coordinator's Name: <?php print $_SESSION['AuthUserName']; ?> 
	  		<input type="button" name="btnLogout" value="Logout" onClick="location='Logout.php'"></h3><br>
	  		(if you are not <?php print $_SESSION['AuthUserName']; ?>, please <a href="Logout.php">log out!</a>) 
		</td></tr>
	</table>

	<table width="85%" border="1px" align="center" bgcolor="#CCFFFF">
		<tr> 
	  		<th width="50%" align="center"><p>Choose a festival and click "Go" to change its information</p></th>
	  		<th align="center">Click below to begin a new festival </th>
		</tr>
		<tr> 
	  		<td align="center"><select name="selFestivalID">
			  <option value="-1">Select a festival</option>
			  <?php
					$sql = "SELECT * FROM Festivals WHERE OrganizationID=$_SESSION[OrganizationID]";							
					$result = mysql_query($sql, $selconn) or die(mysql_error());
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"$row[FestivalID]\">$row[FestivalID] $row[FestivalName]</option>";
					}
				?>
			</select>
			<input type="submit" value="Go" name="btnSubmit"> 
		 </td>
		 <td align="center"><input type="button" name="btnNewFestival" value="New Festival" onClick="location='FestivalAdmin.php?existing=n'"></td>
	    </tr>
		<tr> 
		  <td align="center">&nbsp;</td>
		  <td>&nbsp; </td>
		</tr>
		<tr> 
		  <td align="center">&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <th align="center">Click below to add a new organizer to your list <br>
		  </th>
		  <th>Click below to change the selected organizer's information</th>
		</tr>
		<tr> 
		  <td align="center"><input name="btnNewOrganizer"  type="button" value="Add New Organizer" onClick="location='OrganizerAddNew.php'"></td>
		  <td><select name="selChangeOrganizer">
<?php 
	// get the list of possible organizers for this organization
	$sql="SELECT * FROM Organizers WHERE OrganizationID='$_SESSION[OrganizationID]' ORDER BY OrganizerLastName";
	$result = mysql_query($sql, $selconn) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{
	print "<option value=\"" . $row['OrganizerID'] . "\">" . $row['OrganizerFirstName'] . " " . $row['OrganizerLastName'] . "</option><br>";
	}
?>
		  </select>
		  <input name="btnChangeOrganizer" type="button" value="Change Organizer Info" onClick="ChangeInfo();">
		</td>
	  </tr>
	</table>
</form>

<?php include('../php/TableEnd.php'); ?>
</body>
</html>
