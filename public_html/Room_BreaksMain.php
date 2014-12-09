<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Room Breaks Administration</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="frmAddRoomBreak" onSubmit="return checkReqEntries(this)" action="Room_BreaksAddToDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
<tr align="left" valign="top">
  <td>
	<table width="100%">
		<tr><td width="25%">&nbsp;</td><td width="25%">&nbsp;</td><td width="15%">&nbsp;</td><td width="15%">&nbsp;</td><td width="20%">&nbsp;</td>	</tr> 
		<tr> <td colspan="5" align="center"> <h2>Add, Change, or Delete Room Break Times</h2></td></tr>
		<tr> <td colspan="5" align="center">&nbsp;</td> </tr>
		<tr> <td colspan="5" align="center">For convenience, breaks are scheduled in 15 minute increments</td> </tr>
		<tr> <td colspan="5" align="center">&nbsp;</td> </tr>
		<tr> <td align="center" colspan="5"><h3>Existing Breaks</h3></td></tr>
		<tr> <th align="left">Room:</th>
			 <th align="left">Break Description:</th>
			 <th align="left">Start Time:</th>
			 <th align="left">End Time:</th>
			 <th>&nbsp;</th>
		</tr>

		<?php
			$database = $_SESSION['DatabaseName'];
			$festivalID = $_SESSION['FestivalID'];
		
			$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
			mysql_select_db($database, $selconn) or die(mysql_error());
		
			$sql = "SELECT RoomDescription, BreakDescription, StartTime, EndTime, RoomBreakID FROM RoomBreaks, Festival_Rooms 
					WHERE RoomBreaks.FestivalID = $festivalID AND RoomBreaks.RoomID=Festival_Rooms.RoomID
					ORDER BY Festival_Rooms.RoomID, StartTime";
			$breaksResult = mysql_query($sql, $selconn) or die(mysql_error());
				
			// print existing breaks
			while($row = mysql_fetch_array($breaksResult))
			{
				print "<tr><td>$row[RoomDescription]</td>";
				print "<td>$row[BreakDescription]</td>";
				print "<td>$row[StartTime]</td><td>$row[EndTime]</td>";
				print "<td><input type=\"button\" name=\"btnChange\" value=\"Change\" onClick=\"location='Room_BreaksChange.php?roombreakid=$row[RoomBreakID]'\">";
				print "<input type=\"button\" name=\"btnDelete\" value=\"Delete\" onClick=\"location='Room_BreaksDelete.php?roombreakid=$row[RoomBreakID]'\"></td></tr>";
			}
			$sql = "SELECT * FROM Festival_Rooms WHERE FestivalID = $festivalID";
			$roomsResult = mysql_query($sql, $selconn) or die(mysql_error());
		
		?>
	</table>
  </td>
</tr>		
<tr>
  <td>
	<table width="100%">
		<tr>  <td colspan="4">&nbsp;</td> </tr>
		<tr>  <td  align="center" colspan="4"><h3>Enter New Breaks</h3></td> </tr>
		<tr>
		  <th align="left" width="30%">Select room: </th> 
		  <th align="left" width="30%">Enter break description(optional): </th> 
		  <th align="left" width="20%">Start time: </th> 
		  <th align="left" width="20%">End time: </th> 
	 
		</tr>
		<tr>
			<td><select name="reqSelRoom" title="Select Room"><option value="-1">Select a room</option>
			<?php
				while($roomRow = mysql_fetch_array($roomsResult))
				{
					print "<option value=\"$roomRow[RoomID]\"> $roomRow[RoomDescription]</option>";
				}
			?>
			</select>
			</td>
			<td><input type="text" name="txtBreakDescr" maxlength="40" size="40" title="Break Description"></td>
	
			<td><select name="reqSelStartHour" title="Starting Hour">
									<option value="6">6 AM</option>
									<option value="7">7 AM</option>
									<option value="8">8 AM</option>
									<option value="9">9 AM</option>
									<option value="10">10 AM</option>
									<option value="11">11 AM</option>
									<option value="12">12 PM</option>
									<option value="13">1 PM</option>
									<option value="14">2 PM</option>
									<option value="15">3 PM</option>
									<option value="16">4 PM</option>
									<option value="17">5 PM</option>
									<option value="18">6 PM</option>
									<option value="19">7 PM</option>
									<option value="20">8 PM</option>
									<option value="21">9 PM</option>
									<option value="22">10 PM</option>
								</select>
								<select name="reqSelStartMins" title="Starting Minutes">
									<option value="0">:00</option>
									<option value="15">:15</option>
									<option value="30">:30</option>
									<option value="45">:45</option>
								</select> 
			</td>
	
			<td><select name="reqSelEndHour" title="Ending Hour">
									<option value="6">6 AM</option>
									<option value="7">7 AM</option>
									<option value="8">8 AM</option>
									<option value="9">9 AM</option>
									<option value="10">10 AM</option>
									<option value="11">11 AM</option>
									<option value="12">12 PM</option>
									<option value="13">1 PM</option>
									<option value="14">2 PM</option>
									<option value="15">3 PM</option>
									<option value="16">4 PM</option>
									<option value="17">5 PM</option>
									<option value="18">6 PM</option>
									<option value="19">7 PM</option>
									<option value="20">8 PM</option>
									<option value="21">9 PM</option>
									<option value="22">10 PM</option>
								</select>
								<select name="reqSelEndMins" title="Ending Minutes">
									<option value="0">:00</option>
									<option value="15">:15</option>
									<option value="30">:30</option>
									<option value="45">:45</option>
								</select> 
			</td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
	  <tr>
  
	</table>
  </td>
</tr>
<tr>
  <td>
	<table width="100%">
		<tr>
		  <td align="center"><input type="submit" name="Submit" value="Save"></td>
		  <td align="center"><input type="button" name="btnAdmin" value="Cancel" onClick="window.location='Administration.php'"></td>
		</tr>
	</table>
  </td>
</tr>
</table>
</form>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
