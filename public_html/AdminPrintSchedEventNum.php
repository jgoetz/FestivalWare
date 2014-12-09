<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
--><html>
<head>

<title>FestivalWare Demo Festival Site Administration: Print Schedule by Performance Number</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>

<script language="JavaScript">

function AccessOK (JobTitle, AuthorizedUsers, Page )
{
	if(AuthorizedUsers.indexOf(JobTitle) > 0)
		location.href=Page;
	else
		alert ("Sorry, the " + JobTitle + " isn't allowed to do that!");
}

function checkEntries(which)
{
	if(document.frmAdminPointsEnter.txtRecordNum.value == "") 
	{
		alert("Please enter a performance number!");
		return false;
	}
	if( ! isInteger(document.frmAdminPointsEnter.txtRecordNum.value) )
	{
		alert("Please enter only digits 0-9 in the performance number box!");
		return false;
	}
	
	return true;	
}
</script>
<body bgcolor="FFFFFF" leftmargin="15">
<font face="Arial, Helvetica, sans-serif" size="+1">


			 <br><h2>Site Administration <br>Print Performance #/Student/Studio/Event</h2>
             <h3>You are currently logged in as: 
			   <font color="#008000"><?php print $_SESSION["AdminJob"]; ?> 
               <font size="+1"><a href="Logout.php" tabindex="-1">Logout</a></font>
			   </font>
			 </h3>
<?php
// output the document header 
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 1.0 Transitional//EN\">";
	echo "<html>";
	echo "<head>";
	echo "<title>Schedule by Performance Number for FestivalWare Demo Festival</title>";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
	echo "<style type=\"text/css\">";
	echo "<!--";
	echo "body  {font-family: \"Times New Roman\", Times, serif; font-size: small}";
	echo "h3    {font-family:  \"Times New Roman\", Times, serif; font-size: small; font-weight: bold}";
	echo "table {border-width:1px; border-color:#000000; border-style:solid; border-collapse:collapse; border-spacing:0}";
	echo "td    {font-family:  \"Times New Roman\", Times, serif; border-width:1px; border-color:#000000; border-style:solid; font-size: small}";
	echo "h6  {font-family: \"Times New Roman\", Times, serif; font-size: small; page-break-after:always}";
	echo "-->";
	echo "</style>";

	echo "</head>";
	echo "<body>";

	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

// select each student from the list of registered students

	$sql = "SELECT StudentLastName, StudentFirstName,";
	$sql .= " HistoryID, History.EventID AS 'EventNum', EventName, EnsembleID, StudioFirstName,";
	$sql .= " StudioLastName, Studios.StudioID AS 'StudioID' ";
	$sql .= " FROM RegisteredStudents, Students, Studios, History, Events ";
	$sql .= " WHERE History.EventID=Events.EventID AND RegisteredStudents.StudentID=Students.StudentID";
	$sql .= " AND StudentStudioID=Studios.StudioID AND Students.StudentID=History.StudentID";
	$sql .= " AND Year = 2004 Order by StudentLastName, StudentFirstName";

	$result = mysql_query($sql, $selconn) or die(mysql_error());
	
	echo "<table><tr><th>Perf #</th><th>Student Name</th><th>Teacher Name</th><th>Studio ID</th><th>Event</th></tr>";
	// for each row, format an output row
	$count = 0;
	$studentInfo = array();
	while ($studentRow = mysql_fetch_array($result)) 
	{
		$count++;
		if( $studentRow['EnsembleID'] != NULL)
			$performanceNumber = $studentRow['EnsembleID'];
		else
			$performanceNumber = $studentRow['HistoryID'];
		$studentInfo[$count][1] = $performanceNumber;
		$studentInfo[$count][2] = $studentRow[StudentLastName].",".$studentRow[StudentFirstName];
		$studentInfo[$count][3] = $studentRow[StudioLastName] .",".$studentRow[StudioFirstName];
		$studentInfo[$count][4] = $studentRow[StudioID];
		$studentInfo[$count][5] = $studentRow[EventName];
	}
	// sort the array by performance number...
	sort($studentInfo);
	
	for($outCount = 1; $outCount <= $count; $outCount++)
	{
		if($outCount %50 ==0)
		{
			echo "<tr><th>Perf #</th><th>Student Name</th><th>Teacher Name</th><th>Studio ID</th><th>Event</th></tr>";
		}
		// if row is an ensemble, print the ensemble id rather than the history id
			
		echo "<tr><td>".$studentInfo[$outCount][1]."</td>";
		echo "<td>".$studentInfo[$outCount][2]."</td>";
		echo "<td>".$studentInfo[$outCount][3]."</td>";
		echo "<td align=\"center\">".$studentInfo[$outCount][4]."</td><td>".$studentInfo[$outCount][5]."</td></tr>";
	} // end for each student
	echo "</table>";
?>

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
