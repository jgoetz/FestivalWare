<?php include("IsAuth_Admin.php");?>
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

<p>
</p>
<table>
          <tr align="left" valign="top"> 
            <td> 
			 <br><h2>Site Administration <br>Points Entry Page</h2>

	  <form name="frmAdminPointsEnter" method="post" action="AddPointsToDB.php" onSubmit="return checkReqEntries(this)">
		Enter Performance ID Number (from score sheet) 
		<input name="reqPerformanceNum" type="text" size="10" maxlength="6" tabindex="1" onFocus="this.value=''" title="Performance Number">
		<br>
		Select the number of points awarded
		<select name="reqSelPoints" tabindex="2" title="Select Points">
			<option value="5" selected>5</option>
			<option value="4">4</option>
			<option value="3">3</option>
			<option value="2">2</option>
			<option value="1">1</option>
			<option value="0">0</option>
		</select>
		<br>
		<select name="reqSelType" tabindex="3" title="Select Performance Type">
			<option value="Solo" selected>Solo</option>
			<option value="Ensemble">Ensemble</option>
		</select>
		<br>
		<input name="btnSubmit" type="submit" value="Submit" tabindex="3">
		<p><input name="btnBackToAdmin" type="button" value="Back to Administration" onClick="location='Administration.php'"></p>
	  </form>

    </td></tr></table>


<?php include('../php/TableEnd.php'); ?>

</body>
</html>
