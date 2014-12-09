<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Room Breaks Popup</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<SCRIPT TYPE="text/javascript">
<!--
window.focus();
//-->
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" background="img/yellow_stucco.gif"> 
	<table width="100%">
		<tr><td width="30%">&nbsp;</td><td width="30%">&nbsp;</td><td width="20%">&nbsp;</td><td width="20%">&nbsp;</td></tr> 
		<tr> <td colspan="4" align="center">&nbsp;</td> </tr>
		<tr> <td colspan="4" align="center">For convenience, breaks are scheduled in 15 minute increments</td> </tr>
		<tr> <td colspan="4" align="center">&nbsp;</td> </tr>
		<tr> <td align="center" colspan="4"><h3>Existing Breaks</h3></td></tr>
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
			}		
		?>
	</table>

</body>
</html>
