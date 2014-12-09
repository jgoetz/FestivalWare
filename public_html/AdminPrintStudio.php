<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
<title>FestivalWare Demo Festival Admin: Print Studio Information</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
<style type="text/css">
<!--
body  {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #ffffff}
h1    {font-family: arial, helvetica, geneva, sans-serif; font-size: large; font-weight: bold}
table {border-width:1px; border-color:#000000; border-style:solid; border-collapse:collapse; border-spacing:0}
th    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; font-weight: bold; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}
td    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}
span  {page-break-after: always}
//-->
</style>
</head>

<script src="RollOvers.js"></script>

<?php

	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// select all studios that have students currently enrolled
	$sql = "Select * FROM Studios, Passwords WHERE Studios.StudioID=Passwords.StudioID ORDER BY LastName";
	$studioResult = mysql_query($sql, $selconn) or die(mysql_error());
	
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 1.0 Transitional//EN\">";
	echo "<html>";
	echo "<head>";
	echo "<title>Studio Data</title>";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
	echo "<style type=\"text/css\">";
	echo "<!--";
	echo "body  {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #ffffff}";
	echo "h1    {font-family: arial, helvetica, geneva, sans-serif; font-size: large; font-weight: bold}";
	echo "table {border-width:1px; border-color:#000000; border-style:solid; border-collapse:collapse; border-spacing:0}";
	echo "th    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; font-weight: bold; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}";
	echo "td    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #ffffff; border-width:1px; border-color:#000000; border-style:solid; padding:2px}";
	echo "span  {page-break-after: always}";
	echo "//-->";
	echo "</style>";

	echo "<table><tr>";
	echo "<th>StudioID</th><th>Last Name</th><th>First Name</th><th>Studio Name</th><th>Login Name</th><th>Email Address</th>";
	echo "<th>Address</th><th>City</th><th>State</th><th>Zip Code</th><th>Phone Number</th><th>Cell Phone Number</th>";
	echo "<th>Is DMTA?</th><th>Is Legit?</th><th>Fees Paid?</th></tr>";
	
	while ($studioRow = mysql_fetch_array($studioResult))
	{
		 echo "<tr><td>$studioRow[StudioID]</td>";
		 echo "<td>$studioRow[StudioLastName]</td>";
		 echo "<td>$studioRow[StudioFirstName]</td>";
		 echo "<td>$studioRow[StudioName]</td>";
		 echo "<td>$studioRow[LoginID]</td>";
		 echo "<td>$studioRow[StudioEmail]</td>";
		 echo "<td>$studioRow[StudioAddr]</td>";
		 echo "<td>$studioRow[StudioCity]</td>";
		 echo "<td>$studioRow[StudioState]</td>";
		 echo "<td>$studioRow[StudioZip]</td>";
		 echo "<td>$studioRow[StudioPhone]</td>";
		 echo "<td>$studioRow[CelPhone]</td>";
		 echo "<td>$studioRow[MTAMember]</td>";
		 echo "<td>$studioRow[IsLegit]</td>";
		 echo "<td>$studioRow[FeesPaid]</td>";
		 echo "</tr>";
	} // end while not out of studios
	echo "</tr></table>";
?>



<p><input name="btnBackToAdmin" type="button" value="Back to Administration" onClick="location='Administration.php'"></p>

<p>&nbsp;</p>
<p><font size="1" face="Arial">Copyright 2003-2004 FestivalWare</font></p></td>

<script type="text/javascript" language="javascript1.2">
<!--
if (typeof(window.print) != 'undefined') {
    window.print();
}
//-->
</script>
</body>


</html>
