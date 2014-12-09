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
<SCRIPT TYPE="text/javascript">
<!--
function popup(mylink, windowname)
{
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string')
	   href=mylink;
	else
	   href=mylink.href;
	window.open(href, windowname, 'width=600,height=400,scrollbars=yes');
	return false;
}
//-->
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form method="post" name ="frmAddRoomUseEntry" onSubmit="return checkReqEntries(this)" action="Room_UseAddToDB.php">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
<tr align="left" valign="top">
  <td>
	<table width="100%" height="100%">
		<tr><td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>	</tr> 
		<tr> <td colspan="7" align="center"> <h2>Add, Change, or Delete Room Use Information</h2></td></tr>
		<tr> <td colspan="7" align="center">&nbsp;</td> </tr>
		<tr> <td colspan="7" align="center"><input name="btnShowBreaks" type="button" value="Show Break Times" onClick="return popup('Room_BreaksPopup.php', 'Room_Breaks')"></td> 
		</tr>
		<tr> <td colspan="7" align="center">&nbsp;</td> </tr>
		<tr> <td align="center" colspan="7"><h3>Existing Room Use Entries </h3></td></tr>
		<tr> <th align="left">Room:</th>
			 <th align="left">Description:</th>
			 <th align="left">Minimum Skill Level:</th>
			 <th align="left">Maximum Skill Level:</th>
			 <th align="left">Start Time:</th>
			 <th align="left">End Time:</th>
			 <th>&nbsp;</th>
		</tr>

		<?php
			$database = $_SESSION['DatabaseName'];
			$festivalID = $_SESSION['FestivalID'];
		
			$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
			mysql_select_db($database, $selconn) or die(mysql_error());
		
			$sql = "SELECT RoomUseID, RoomDescription, UseDescription, MinSkill, MaxSkill, StartTime, EndTime  FROM RoomUse, Festival_Rooms 
					WHERE Festival_Rooms.FestivalID = $festivalID AND RoomUse.RoomID=Festival_Rooms.RoomID
					ORDER BY Festival_Rooms.RoomID, StartTime";
			$breaksResult = mysql_query($sql, $selconn) or die(mysql_error());
				
			// print existing usage entries
			while($row = mysql_fetch_array($breaksResult))
			{
				print "<tr><td>$row[RoomDescription]</td>";
				print "<td>$row[UseDescription]</td>";
				$sql = "SELECT SkillDescription  FROM SkillLevels WHERE SkillLevelID = $row[MinSkill]";
				$minSkillResult = mysql_query($sql, $selconn) or die(mysql_error());
				$minRow = mysql_fetch_array($minSkillResult);
				$sql = "SELECT SkillDescription  FROM SkillLevels WHERE SkillLevelID = $row[MaxSkill]";
				$maxSkillResult = mysql_query($sql, $selconn) or die(mysql_error());
				$maxRow = mysql_fetch_array($maxSkillResult);

				print "<td>$minRow[SkillDescription]</td><td>$maxRow[SkillDescription]</td>";
				print "<td>$row[StartTime]</td><td>$row[EndTime]</td>";
				print "<td><input type=\"button\" name=\"btnChange\" value=\"Change\" onClick=\"location='Room_UseChange.php?roomuseid=$row[RoomUseID]'\">";
				print "<input type=\"button\" name=\"btnDelete\" value=\"Delete\" onClick=\"location='Room_UseDelete.php?roomuseid=$row[RoomUseID]'\"></td></tr>";
			}
			// set up for entering new room-use entries
			$sql = "SELECT * FROM Festival_Rooms WHERE FestivalID = $festivalID";
			$roomsResult = mysql_query($sql, $selconn) or die(mysql_error());
			$sql = "SELECT * FROM Festival_PerfLevels, SkillLevels WHERE FestivalID = $festivalID AND PerfLevelID=SkillLevelID";
			$skillsResult = mysql_query($sql, $selconn) or die(mysql_error());
			while($skillsRow = mysql_fetch_array($skillsResult))
			{
				$skillsArray [$skillsRow['SkillLevelID']] = $skillsRow['SkillDescription'];
			}
		?>
	</table>
  </td>
</tr>		
<tr>
  <td>
	<table width="100%">
		<tr>  <td colspan="6">&nbsp;</td> </tr>
		<tr>  <td  align="center" colspan="6"><h3>Enter New Use Entry </h3></td> </tr>
		<tr>
		  <th align="left" width="16%">Select room: </th>
		  <th align="left" width="21%">Use Description(optional):</th> 
		  <th align="left" width="18%">Miniumum Skill Level: </th>
		  <th align="left" width="14%">Maximum Skill Level: </th> 
		  <th align="left" width="14%">Start time: </th> 
		  <th align="left" width="17%">End time: </th> 
	 
		</tr>
		<tr>
		  <td><select name="reqSelRoom" title="Select Room">
		    <option value="-1">Select a room</option>
            <?php
				while($roomRow = mysql_fetch_array($roomsResult))
				{
					print "<option value=\"$roomRow[RoomID]\"> $roomRow[RoomDescription]</option>";
				}
			?>
          </select></td>
			<td><input name="txtUseDescr" type="text" title="Description"></td>
			<td><select name="reqSelMinSkill" title="Set Min. Skill">
			  <option value="-1">Set min skill level</option>
              <?php
				foreach ($skillsArray as $level => $descr)
				{
					print "<option value=\"$level\"> $descr</option>";
				}
			?>
            </select></td>
			<td><select name="reqSelMaxSkill" title="Set Max. Skill">
			  <option value="-1">Set max skill level</option>
              <?php
				foreach ($skillsArray as $level => $descr)
				{
					print "<option value=\"$level\"> $descr</option>";
				}
			?>
            </select></td>
	
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
		<tr><td colspan="6">&nbsp;</td></tr>
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
