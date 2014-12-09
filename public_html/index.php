<?php session_start(); ?>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
<tr><td colspan="3"><h1>Welcome to FestivalWare!</h1></td></tr>
<tr><td colspan="3"><p>FestivalWare is a complete solution for your music festival or event. We provide the following web-based services:</p></td></tr>
<tr><td>&nbsp;</td><td>Online registration, scheduling, and tracking of Festivals and Events</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>Detatiled administrative control of your event</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>Studio Registration</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>Performer Registration</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>Performance Scheduling</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>Performance Reports and Schedule Printing</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>Awards and Certificates Printing</td><td>&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3" align="center">
<?php
	if($_SESSION['AuthorizationType'] == "Coordinator")
		print "<input name=\"btnCoordAdminPage\" type=\"button\" value=\"Coordinator's Administration Page\" onClick=\"location='CoordinatorSelector.php'\">";
	elseif($_SESSION['AuthorizationType'] == "Admin")
		print "<input name=\"btnAdminPage\" type=\"button\" value=\"Organizer's Administration Page\" onClick=\"location='Administration.php'\">";
	elseif($_SESSION['AuthorizationType'] == "Studio")
		print "<input name=\"btnStudioAdminPage\" type=\"button\" value=\"Studio Administration Page\" onClick=\"location='StudioAdmin.php'\">";
?>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3" align="center">&nbsp;</td>
</tr>
<tr><td colspan="3" align="center"><input name="btnStudioReg" type="button" value="Click here to register your studio" onClick="location='StudioReg.php'"></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>

</table>

<?php include('../php/TableEnd.php'); ?>

</body>
</html>
