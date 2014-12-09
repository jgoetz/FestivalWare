<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
<title>FestivalWare Demo Festival Administration: Print Student Information</title>
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
function fixInput($inputStr)
{
	$fixedStr = preg_replace("/([;<>\?\^\*\|`&\$!#\(\)\[\]\{\}:\"\=])/", "", $inputStr);
	return $fixedStr;
}

	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

// get the POST data from the Choices form
// checkbox array :   col 1=is box checked  col2 = sql part col 3 = header row part
	$checkboxes = array(
	1 => array( 1=> fixInput($_POST['chkStudentID']), 	2=> "StudentID", 				3=>"Student Number" ), 				
	2 => array( 1=> fixInput($_POST['chkTimeStamp']), 	2=>  "StudentTimeStamp", 	3=>"Time Entered"),
	3 => array( 1=> fixInput($_POST['chkFirstName']),  	2=> "StudentFirstName", 	3=>"First Name"),
	4 => array( 1=> fixInput($_POST['chkMiddleName']),  2=> "StudentMiddleName",	3=>"Middle Name"),
	5 => array( 1=> fixInput($_POST['chkLastName']),  	2=> "StudentLastName", 		3=>"Last Name"),
	6 => array( 1=> fixInput($_POST['chkStudentEmail']),2=> "StudentEmail", 		3=>"Email"),
	7 => array( 1=> fixInput($_POST['chkStudioID']),  	2=> "StudentStudioID", 		3=>"Studio Number"),
	8 => array( 1=> fixInput($_POST['chkStudioName']),  2=> "StudioName", 			3=>"Studio Name"),
	9 => array( 1=> fixInput($_POST['chkTeacherName']), 2=> "StudioFirstName, StudioLastName", 3=>"Teacher Name"),
	10 => array( 1=> fixInput($_POST['chkStreetAddr']), 2=> "StudentAddr",		 	3=>"Street Address"),
	11 => array( 1=> fixInput($_POST['chkCity']),  		2=> "StudentCity", 			3=>"City"),
	12 => array( 1=> fixInput($_POST['chkState']),  	2=> "StudentState", 		3=>"State"),
	13 => array( 1=> fixInput($_POST['chkZip']),  		2=> "StudentZip", 			3=>"Zip Code"),
	14 => array( 1=> fixInput($_POST['chkPhone']),  	2=> "StudentPhone", 		3=>"Phone"),
	15 => array( 1=> fixInput($_POST['chkBirthdate']),  2=> "Birthdate", 			3=>"Birthdate"),
	16 => array( 1=> fixInput($_POST['chkParentName']), 2=> "ParentName",			3=>"Parents Name"),
	17 => array( 1=> fixInput($_POST['chkParentPhone']),2=> "ParentPhone",			3=>"Parents Phone"),
	18 => array( 1=> fixInput($_POST['chkMonitor']), 	2=> "Monitor", 				3=>"Monitor(Y/N)")
	); // end checkbox array

	$selectionArray = array (
	1 => array( 1=> $_POST['selStudentID'], 	2=> "StudentID", 			3=> fixInput($_POST['txtStudentID'])),		
	2 => array( 1=> $_POST['selFirstName'], 	2=> "StudentFirstName", 	3=> fixInput($_POST['txtFirstName'])),		
	3 => array( 1=> $_POST['selMiddleName'], 	2=> "StudentMiddleName", 	3=> fixInput($_POST['txtMiddleName'])),		
	4 => array( 1=> $_POST['selLastName'], 		2=> "StudentLastName", 		3=> fixInput($_POST['txtLastName'])),		
	5 => array( 1=> $_POST['selEmail'], 		2=> "StudentEmail",			3=> fixInput($_POST['txtEmail'])),		
	6 => array( 1=> $_POST['selStudioID'], 		2=> "StudentStudioID", 		3=> fixInput($_POST['txtStudioID'])),		
	7 => array( 1=> $_POST['selTeachersName'], 	2=> "StudioLastName", 		3=> fixInput($_POST['txtTeachersName'])),		
	8 => array( 1=> $_POST['selStreet_Addr'], 	2=> "StudentAddr", 			3=> fixInput($_POST['txtStreet_Addr'])),		
	9 => array( 1=> $_POST['selCity'], 			2=> "StudentCity", 			3=> fixInput($_POST['txtCity'])),		
	10 => array( 1=> $_POST['selState'], 		2=> "StudentState", 		3=> fixInput($_POST['txtState'])),		
	11 => array( 1=> $_POST['selZipCode'], 		2=> "StudentZip", 			3=> fixInput($_POST['txtZipCode'])),		
	12 => array( 1=> $_POST['selStudentPhone'], 2=> "StudentPhone", 		3=> fixInput($_POST['txtStudentPhone'])),		
	13 => array( 1=> $_POST['selBirthdate'], 	2=> "Students.Birthdate",3=> fixInput($_POST['txtBirthdate'])),		
	14 => array( 1=> $_POST['selParentsName'], 	2=> "ParentName", 			3=> fixInput($_POST['txtParentsName'])),		
	15 => array( 1=> $_POST['selParentsPhone'], 2=> "ParentPhone", 			3=> fixInput($_POST['txtParentsPhone'])),		
	16 => array( 1=> $_POST['selMonitor'], 		2=> "Monitor", 				3=> fixInput($_POST['selMonitor'])),		
	17 => array( 1=> $_POST['selYear'], 		2=> "Year", 				3=> fixInput($_POST['selYear']))		
	);

	$sqlFrom = " FROM Students,Studios";
		
	$sortEmpty = 1;
	if($_POST['selSortOrder1'] != 0)
	{
		if($sortEmpty == 1)
		{
			$sortEmpty = 0;
			$sqlSort = " ORDER BY " . fixInput($_POST['selSortOrder1']);
		}
		else
			$sqlSort = "," . fixInput($_POST['selSortOrder1']);
	}
	if($_POST['selSortOrder2'] != 0)	
		if($sortEmpty == 1)
		{
			$sortEmpty = 0;
			$sqlSort = " ORDER BY " . fixInput($_POST['selSortOrder2']);
		}
		else
			$sqlSort = "," . fixInput($_POST['selSortOrder2']);
	
	if($_POST['selSortOrder3'] != 0)	
		if($sortEmpty == 1)
		{
			$sortEmpty = 0;
			$sqlSort = " ORDER BY " . fixInput($_POST['selSortOrder3']);
		}
		else
			$sqlSort = "," . fixInput($_POST['selSortOrder3']);
	
	if($_POST['selSortOrder4'] != 0)	
		if($sortEmpty == 1)
		{
			$sortEmpty = 0;
			$sqlSort = " ORDER BY " . fixInput($_POST['selSortOrder4']);
		}
		else
			$sqlSort = "," . fixInput($_POST['selSortOrder4']);


	// now build the sql query 
	$sqlSelect = "";
	$empty = true;
	for($count = 1; $count <=18; $count++)
	{	
		if($checkboxes[$count][1] == 'True')
			if($empty == true)
			{
				$sqlSelect .= "SELECT " . $checkboxes[$count][2];
				$empty = false;
			}
			else
				$sqlSelect .= "," . $checkboxes[$count][2];
	}
	if($sqlSelect == "") 
		$sqlSelect = "SELECT * ";
		
	$sqlWhere = "";
	$empty = 1;
	for($count = 1; $count <=17; $count++)
	{	
		if($selectionArray[$count][1] != '0')
		{
			if($empty == 1)
			{
				$empty = 0;
				$sqlWhere = " WHERE ";
			}
			else
			{
				$sqlWhere .= " AND ";
			}
			$sqlWhere .= $selectionArray[$count][2]; // field name
			switch ($selectionArray[$count][1]) // add comparison operator
			{
				case "LT": $sqlWhere .= " < "; break;
				case "LE": $sqlWhere .= " <= "; break;
				case "GT": $sqlWhere .= " > "; break;
				case "GE": $sqlWhere .= " >= "; break;
				case "EQ": $sqlWhere .= " = "; break;
				case "NE": $sqlWhere .= " != "; break;
				case "like": $sqlWhere .= " LIKE "; break;
			}
			$sqlWhere .= "'" . $selectionArray[$count][3] . "'"; // add the limit value
		}
	}
	
	$sql = $sqlSelect . $sqlFrom . $sqlWhere . $sqlSort . "LIMIT 100";
	$studioResult = mysql_query($sql, $selconn) or die(mysql_error());
	
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 1.0 Transitional//EN\">";
	echo "<html>";
	echo "<head>";
	echo "<title>Student Data</title>";
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
	// set up table header row
	for($count = 1; $count <=18; $count++)
	{	
		if($checkboxes[$count][1] == 'True')
			echo "<th>" . $checkboxes[$count][3] . "</th>";
	}
	echo "</tr>";
	
	while ($studioRow = mysql_fetch_array($studioResult))
	{
		// for each row retrieved, output each field.
		echo "<tr>";
		for($count = 1; $count <=18; $count++)
		{	
			if($checkboxes[$count][1] == 'True')
				echo "<td>" . $studioRow['$checkboxes[$count][2]'] ."</td>";
		}
		 echo "</tr>";
	} // end while not out of students
	echo "</table>";
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
