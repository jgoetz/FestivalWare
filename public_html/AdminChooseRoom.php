<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
--><html>
<head>

<title>FestivalWare Festival Administration: Select Room for Printing </title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>

<body bgcolor="BBBBBB" leftmargin="15" onLoad="self.focus();document.frmAdminPointsEnter.txtRecordNum.focus()">
<?php include('../php/TableStart.php'); ?>
<?php

	$database = $_SESSION['DatabaseName'];
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$type = $_GET['type'];
	if ($type == 1)
	{
		$type = 'Rating Sheets';
		echo "<form name=\"frmAdminChooseRoom\" method=\"post\" action=\"AdminPrintRatingSheets.php\" onSubmit=\"return checkReqEntries(this)\">";
	}
	else if($type == 2)
	{
		$type = 'Certificates';
		echo "<form name=\"frmAdminChooseRoom\" method=\"post\" action=\"AdminPrintCertificates.php\" onSubmit=\"return checkReqEntries(this)\">";
	}
?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="left" valign="top"> 
            <td> 
			 <br><h2>Site Administration <br>
              Print <?php echo $type ?>: Select Room</h2>
            <p><br>
                Print <?php echo $type ?> for room: 
                <select name="selRoom" tabindex="2">
                  <option value="-1">Please select a room</option>
	<?php
			$sql = "SELECT * FROM Rooms";
			$roomsResult = mysql_query($sql, $selconn) or die(mysql_error());
			while ($roomRow = mysql_fetch_array($roomsResult))
			{
				echo "  <option value=\"$roomRow[RoomID]\">$roomRow[RoomDescription]</option><br>";
			}
	?>
                </select>
              </p>Please enter the range of starting times in 24 hour format ("military" time)<br>
			  (this just means to add 12 to any hour after noon; for example, 4:35 PM would be 16:35). <br>
			  This will print <?php echo $type ?> for all students scheduled to perform between these times (inclusive).
              <p>Print <?php echo $type ?> starting at : <input name="txtStartTime" type="text"> (example: 12:34)</p>
              <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Through : <input name="txtEndTime" type="text">
                <br>
              </p>
              <p>
                <input name="btnSubmit" type="submit" value="Submit" tabindex="3">
              </p>
              <p><input name="btnBackToAdmin" type="button" value="Back to Administration" onClick="location='Administration.php'"></p>
	  </form>

    </td>
  </tr>
</table>
<?php include('../php/TableEnd.php'); ?>

</body>


</html>
