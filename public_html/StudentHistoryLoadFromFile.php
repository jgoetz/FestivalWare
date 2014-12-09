<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Demo Festival Student Lookup Page</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>

<body leftmargin="0" topmargin="0"><div align=left> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
    <td width=200 valign="top" background="img/cellbg19133.gif"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td><img src="img/Reflections.jpg" name="im4" width="200" height="180" border="0"></td>
        </tr>
        <tr>
            <td><a href="demoindex.php"  onclick="return true" onMouseOver="swapon1()" onMouseOut="swapoff1()"><img src="img/home.jpg" width ="180" height="28" border="0" name="img1"></a></td>
		</tr>
        <tr>
            <td><a href="Contact.php"  onClick="return true" onMouseOver="swapon2()" onMouseOut="swapoff2()"><img src="img/ContactUs.jpg" width="180" height="28" border="0" name="img2"></a></td>
        </tr>
        <tr>
            <td><a href="FAQ.html"  onclick="return true" onMouseOver="swapon3()" onMouseOut="swapoff3()"><img src="img/FAQ.jpg" width="180" height="28" border="0" name="img3"></a> </td>
        </tr>
        <tr>
            <td><a href="CommDesc.html"  onclick="return true" onMouseOver="swapon4()" onMouseOut="swapoff4()"><img src="img/CommDesc.jpg" width="180" height="28" border="0" name="img4"></a> </td>
        </tr>
        <tr>
            <td><a href="StudioAdmin.php"  onclick="return true" onMouseOver="swapon5()" onMouseOut="swapoff5()"><img src="img/RegStudio.jpg" width="180" height="28" border="0" name="img5"></a> </td>
        </tr>
        <tr>
            <td><a href="StudioAdmin.php"  onclick="return true" onMouseOver="swapon6()" onMouseOut="swapoff6()"><img src="img/StudioAdmin.jpg" width="180" height="28" border="0" name="img6"></a> </td>
        </tr>
        <tr>
            <td><a href="StudioAdmin.php"  onclick="return true" onMouseOver="swapon7()" onMouseOut="swapoff7()"><img src="img/SchedPerf.jpg" width="180" height="28" border="0" name="img7"></a> </td>
        </tr>  
        <tr>
            <td><a href="Timeline.html"  onclick="return true" onMouseOver="swapon8()" onMouseOut="swapoff8()"><img src="img/Timeline.jpg" width="180" height="28" border="0" name="img8"></a> </td>
        </tr>
      </table>
    </td>
	
    <td valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
        <tr align="right" valign="top"> 
          <td><img src="img/compname1.jpg" width="572" height="49" name="im1"></td>
        </tr>
        <tr align="left" valign="top"> 
            <td> 
			  <br>
			  <br>
              <h2>Student History Load from file Page</h2>
                
              <h3>
			    You are currently logged in as: 
              	 <font color="#008000"><?php print $_SESSION["StudioName"]; ?> </font>
              	<a href="Logout.php">Logout</a> 
			  </h3>
<font size="=1">
<?php
	$database = $_SESSION['DatabaseName'];
				
	$conn = mysql_connect ( "localhost","festival_updater","y0mu75d") or die(mysql_error()); 
	mysql_select_db($database, $conn) or die(mysql_error());
			
// open file History.cvs
	
	$rowcount = 0;
	$addcount = 0;
	$skipcount = 0;
	$handle = fopen ("history.csv","r");
//for each line, parse into pieces
	while ($data = fgetcsv ($handle, 1000, ",")) {
		$rowcount++;
		$StudentLastName = $data[0];
		$StudentFirstName = $data[1];
		$Year = $data[2];
		// skip 3, it's the section, we don't need it
		$Event = $data[4];
		$Class = $data[5];
		$Points = $data[6];
		$Rating = $data[7]; // we'll ignore this, actually.
		$TeacherLastName = $data[8];
		$TeacherFirstName = $data[9];
print "Checking student #$rowcount : <font color = \"#008000\"> $StudentFirstName $StudentLastName</font>" . 
	"  Teacher:<font color = \"#008000\">$TeacherLastName</font> " .
	" Event: <font color = \"#008000\">$Event</font> " .
	" Class:<font color = \"#008000\">$Class </font><br>";
//  lookup firstname, lastname; get studentID
		$StudentFirstName = addslashes($StudentFirstName);
		$StudentLastName = addslashes($StudentLastName);
		$sql = "select StudentID from Students where StudentFirstName = '$StudentFirstName' and StudentLastName = '$StudentLastName'";
		$result = mysql_query ($sql, $conn) or die(mysql_error());
		if(mysql_num_rows($result) > 1) // too many; can't differentiate between them
		{
			print "****Skipping $StudentFirstName $StudentLastName...too many matches for that name already exist. <br>";
			$skipcount++;
			continue; // go on to next student history entry
		}
		else if (mysql_num_rows($result) <= 0) // not here, so enter
		{
			$sql = "insert into Students (StudentID, StudentTimeStamp, StudentFirstName, StudentLastName) values ('', now(), '$StudentFirstName', '$StudentLastName')";
			print ">>>>Adding student...<br>";
			$result = mysql_query ($sql, $conn) or die(mysql_error());
			// now get the student ID you just created
			$sql = "select StudentID from Students where StudentFirstName = '$StudentFirstName' and StudentLastName = '$StudentLastName'";
			$result = mysql_query ($sql, $conn) or die(mysql_error());
		}
   		$row = mysql_fetch_array($result);
		// at this point, $row contains the StudentID
		$StudentID = $row['StudentID'];

//  if teacher name exists
// 		get studioID
//  else 
//		insert teacher as new studio
		$sql = "select StudioID from Studios where StudioFirstName = '$TeacherFirstName' and StudioLastName = '$TeacherLastName'";
		$result = mysql_query ($sql, $conn) or die(mysql_error());
		if(mysql_num_rows($result) > 1) // too many; can't differentiate between them
		{
			print "****Skipping $StudentFirstName $StudentLastName...too many matches for $TeacherFirstName $TeacherLastName already exist. <br>";
			$skipcount++;
			continue; // go on to next student history entry
		}
		else if (mysql_num_rows($result) <= 0) // not here, so enter
		{
			$sql = "insert into Studios (StudioID, StudioTimeStamp, StudioFirstName, StudioLastName, LoginID, StudioName) values ('',now(), '$TeacherFirstName', '$TeacherLastName', '$TeacherLastName', '$TeacherLastName Music Club')";
			print ">>>>Adding $TeacherFirstName $TeacherLastName to Studios<br>";
			$result = mysql_query ($sql, $conn) or die(mysql_error());
			// now get the StudioID you just created
			$sql = "select StudioID from Studios where StudioFirstName = '$TeacherFirstName' and StudioLastName = '$TeacherLastName'";
			$result = mysql_query ($sql, $conn) or die(mysql_error());
		}
   		$row = mysql_fetch_array($result);
		// at this point, $row contains the StudioID
		$StudioID = $row['StudioID'];
		
//  if event exists
//		get eventID
//	else
//		exit with error
		$sql = "select EventID from Events where EventName = '$Event'";
		$result = mysql_query ($sql, $conn) or die(mysql_error());
		if(mysql_num_rows($result) > 1) // too many; can't differentiate between them
		{
			print "****Skipping $StudentFirstName $StudentLastName...too many  matches for $Event already exist. <br>";
			$skipcount++;
			continue; // go on to next student history entry
		}
		else if (mysql_num_rows($result) <= 0) // not here, so enter
		{
			print "****Skipping  $StudentFirstName $StudentLastName for $Event...event does not exist. <br>";
			$skipcount++;
			continue;
		}
		else
		{
   			$row = mysql_fetch_array($result);
			$EventID = $row['EventID'];
		}
		
//	if class exists for event
//		get classID
//	else
//		exit with error
		$sql = "select ClassID from Classes where ClassDescription = '$Class'";
		$result = mysql_query ($sql, $conn) or die(mysql_error());
		if(mysql_num_rows($result) > 1) // too many; can't differentiate between them
		{
			print "****Skipping $StudentFirstName $StudentLastName ...too many matches for $Class already exist. <br>";
			$skipcount++;
			continue; // go on to next student history entry
		}
		else if (mysql_num_rows($result) <= 0) // not here, so enter
		{
			print "****Skipping $StudentFirstName $StudentLastName for $Class...class does not exist. <br>";
			$skipcount++;
			continue;
		}
		else
   		{
			$row = mysql_fetch_array($result);
			$ClassID = $row['ClassID'];
		}	
// validate all other data
		if (($Year < 1980) || ($Year > 2004) )
		{
			print "****Skipping $StudentFirstName $StudentLastName because year $Year is out of range.<br>";
			$skipcount++;
			continue;
		}
		if (($Points < 0) || ($Points > 5) )
		{
			print "****Skipping $StudentFirstName $StudentLastName because $Points Points are out of range.<br>";
			$skipcount++;
			continue;
		}
		
//	build sql statement, enter student history line
		$sql = "Insert into History values ( '', now(), '$StudentID', '$StudioID','$Year','$EventID','$ClassID',NULL,'unknown','unknown', 'unknown','unknown', '$Points')";
print "---->Entering student history record for $StudentFirstName $StudentLastName $Year $Event $Class $Points $Rating<br>"; 
		$addcount++;
		$result = mysql_query ($sql, $conn) or die(mysql_error());

	}//end loop
//close file
fclose ($handle);

print "<br><br><font size=\"+2\" color=\"ff0000\">$rowcount records read. <br>";
print "$addcount History Records added to the database.<br>";
print "$skipcount records skipped<br></font>";
?>
</font>
		</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>

</body>

</html>
