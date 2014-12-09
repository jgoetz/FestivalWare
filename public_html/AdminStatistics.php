<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=charset=iso-8859-1">
<meta name=Generator content="text/html; charset=iso-8859-1">
<title>FestivalWare Demo Festival Administration: Festival Statistics</title>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:large; }
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:medium;}
body  {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: medium; font-color: }
-->
</style>
</head>



<body lang=EN-US bgcolor="#CCFFFF">

<h1>FestivalWare 2004 Statistics</h1>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// number of registered students
	$sql = "SELECT COUNT(*) AS Total FROM RegisteredStudents";
	$studentResult = mysql_query($sql, $selconn) or die(mysql_error());
	$row = mysql_fetch_array($studentResult);
	$registeredStudents = $row['Total'];
	
	// total number of solos registered
	$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID IS NULL";
	$soloResult	= mysql_query($sql, $selconn) or die(mysql_error());
	$soloRow = mysql_fetch_array($soloResult);
	$soloCount = $soloRow['Total'];

	// total number of solos noshows
	$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID IS NULL AND Points=0";
	$soloResult	= mysql_query($sql, $selconn) or die(mysql_error());
	$soloRow = mysql_fetch_array($soloResult);
	$soloNoShowCount = $soloRow['Total'];

		// total number of solos superiors
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID IS NULL AND Points=5";
		$soloResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$soloRow = mysql_fetch_array($soloResult);
		$soloSuperiorCount = $soloRow['Total'];
		// total number of solos excellents
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID IS NULL AND Points=4";
		$soloResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$soloRow = mysql_fetch_array($soloResult);
		$soloExcellentCount = $soloRow['Total'];
		// total number of solos very goods
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID IS NULL AND Points=3";
		$soloResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$soloRow = mysql_fetch_array($soloResult);
		$soloVeryGoodCount = $soloRow['Total'];
		// total number of solos goods
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID IS NULL AND Points=2";
		$soloResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$soloRow = mysql_fetch_array($soloResult);
		$soloGoodCount = $soloRow['Total'];
		// total number of solos needs improvement
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID IS NULL AND Points=1";
		$soloResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$soloRow = mysql_fetch_array($soloResult);
		$soloNICount = $soloRow['Total'];

	// total number of ensembles registered
	$sql = "SELECT COUNT(*) AS Total FROM EnsembleHistory WHERE Year=2004";
	$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
	$ensembleRow = mysql_fetch_array($ensembleResult);
	$ensembleCount = $ensembleRow['Total'];

	// total number of ensembles no-shows
	$sql = "SELECT COUNT(*) AS Total FROM EnsembleHistory WHERE Year=2004 AND Points=0";
	$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
	$ensembleRow = mysql_fetch_array($ensembleResult);
	$ensembleNoShowCount = $ensembleRow['Total'];
		// total number of ensemble superiors
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID>0 AND Points=5";
		$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$ensembleRow = mysql_fetch_array($ensembleResult);
		$ensembleSuperiorCount = $ensembleRow['Total'];
		// total number of ensemble excellents
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID>0 AND Points=4";
		$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$ensembleRow = mysql_fetch_array($ensembleResult);
		$ensembleExcellentCount = $ensembleRow['Total'];
		// total number of ensemble very goods
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID>0 AND Points=3";
		$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$ensembleRow = mysql_fetch_array($ensembleResult);
		$ensembleVeryGoodCount = $ensembleRow['Total'];
		// total number of ensemble goods
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID>0 AND Points=2";
		$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$ensembleRow = mysql_fetch_array($ensembleResult);
		$ensembleGoodCount = $ensembleRow['Total'];
		// total number of ensemble needs improvement
		$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID>0 AND Points=1";
		$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$ensembleRow = mysql_fetch_array($ensembleResult);
		$ensembleNICount = $ensembleRow['Total'];

	// total number of ensemble students registered
	$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID > 0";
	$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
	$ensembleRow = mysql_fetch_array($ensembleResult);
	$ensembleStudentCount = $ensembleRow['Total'];
	
	// number of ensemble student no-shows
	$sql = "SELECT COUNT(*) AS Total FROM History WHERE Year=2004 AND EnsembleID > 0 AND Points=0";
	$ensembleResult	= mysql_query($sql, $selconn) or die(mysql_error());
	$ensembleRow = mysql_fetch_array($ensembleResult);
	$ensembleStudentNoShowCount = $ensembleRow['Total'];
	
	// total number of musicianship students registered
	$sql = "SELECT COUNT(*) AS Total FROM MusicianshipHistory WHERE Year=2004";
	$musicResult = mysql_query($sql, $selconn) or die(mysql_error());
	$musicRow = mysql_fetch_array($musicResult);
	$musicCount = $musicRow['Total'];
		// total number of musicianship superiors
		$sql = "SELECT COUNT(*) AS Total FROM MusicianshipHistory WHERE Year=2004 AND Points=5";
		$musicResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$musicRow = mysql_fetch_array($musicResult);
		$musicSuperiorCount = $musicRow['Total'];
		// total number of musicianship excellents
		$sql = "SELECT COUNT(*) AS Total FROM MusicianshipHistory WHERE Year=2004 AND Points=4";
		$musicResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$musicRow = mysql_fetch_array($musicResult);
		$musicExcellentCount = $musicRow['Total'];
		// total number of musicianship very goods
		$sql = "SELECT COUNT(*) AS Total FROM MusicianshipHistory WHERE Year=2004 AND Points=3";
		$musicResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$musicRow = mysql_fetch_array($musicResult);
		$musicVeryGoodCount = $musicRow['Total'];
		// total number of musicianship goods
		$sql = "SELECT COUNT(*) AS Total FROM MusicianshipHistory WHERE Year=2004 AND Points=2";
		$musicResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$musicRow = mysql_fetch_array($musicResult);
		$musicGoodCount = $musicRow['Total'];
		// total number of musicianship needs improvement
		$sql = "SELECT COUNT(*) AS Total FROM MusicianshipHistory WHERE Year=2004 AND Points=1";
		$musicResult	= mysql_query($sql, $selconn) or die(mysql_error());
		$musicRow = mysql_fetch_array($musicResult);
		$musicNICount = $musicRow['Total'];

	
	// number of musicianship student no-shows
	$sql = "SELECT COUNT(*) AS Total FROM MusicianshipHistory WHERE Year=2004 AND Points=0";
	$musicResult = mysql_query($sql, $selconn) or die(mysql_error());
	$musicRow = mysql_fetch_array($musicResult);
	$musicNoShowCount = $musicRow['Total'];
	
	// number of students actually participating 
	$sql = "SELECT COUNT(Distinct StudentID) AS Total FROM History WHERE Year=2004 AND Points>0";
	$historyResult = mysql_query($sql, $selconn) or die(mysql_error());
	$historyRow = mysql_fetch_array($historyResult);
	$historyCount = $historyRow['Total'];
	
	// total number of history records...
	$sql = "SELECT COUNT(*) AS TotalRecs FROM History WHERE Year=2004";
	$totalRegResult = mysql_query($sql, $selconn) or die(mysql_error());
	$totalRegRow = mysql_fetch_array($totalRegResult);
	$totalRecords = $totalRegRow['TotalRecs'];
?>
<p class="style1">
  There were <?php print $soloCount; ?> solo performances registered.<br>
  There were <?php print $soloNoShowCount; ?> solo no-shows (zero points).<br>
  There were <?php print $soloCount - $soloNoShowCount; ?> actual solo performances.<br>
  <div class="style2">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $soloSuperiorCount; ?> solo Superior scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $soloExcellentCount; ?> solo Excellent scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $soloVeryGoodCount; ?> solo Very Good scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $soloGoodCount; ?> solo Good scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $soloNICount; ?> solo Needs Improvement scores.<br>
  </div>
 </p>
<p class="style1">
  There were <?php print $ensembleCount; ?> ensembles registered.<br>
  There were <?php print $ensembleNoShowCount; ?> ensemble no-shows (zero points).<br>
  There were <?php print $ensembleCount - $ensembleNoShowCount; ?> actual ensemble performances.<br>
</p>
<p class="style1">
  There were <?php print $ensembleStudentCount; ?> ensemble students registered.<br>
  There were <?php print $ensembleStudentNoShowCount; ?> ensemble student no-shows  (zero points).<br>
  There were <?php print $ensembleStudentCount - $ensembleStudentNoShowCount; ?> actual ensemble students performing.<br>
  <div class="style2">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $ensembleSuperiorCount; ?> ensemble Superior scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $ensembleExcellentCount; ?> ensemble Excellent scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $ensembleVeryGoodCount; ?> ensemble Very Good scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $ensembleGoodCount; ?> ensemble Good scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $ensembleNICount; ?> ensemble Needs Improvement scores.<br>
  </div>
</p>
<p class="style1">
  There were <?php print $musicCount; ?> musicianship tests registered.<br>
  There were <?php print $musicNoShowCount; ?>  musicianship test no-shows (zero points).<br>
  There were <?php print $musicCount - $musicNoShowCount; ?> actual  musicianship tests taken.<br>
  <div class="style2">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $musicSuperiorCount; ?> musicianship Superior scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $musicExcellentCount; ?> musicianship Excellent scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $musicVeryGoodCount; ?> musicianship Very Good scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $musicGoodCount; ?> musicianship Good scores.<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;There were <?php print $musicNICount; ?> musicianship Needs Improvement scores.<br>
  </div>
</p>
<h3>Totals: </h3>
<div class="style1">	
<?php print $registeredStudents; ?> Students registered for <?php print $totalRecords + $musicCount; ?> performances and tests (this is 
the number of entry fees paid).<br>

<br>	
   	<em>Registered</em> performances and tests: <?php print $musicCount + $soloCount + $ensembleCount; ?> <br>
   	<em>No-show</em> performances and tests:<?php print $musicNoShowCount + $soloNoShowCount + $ensembleNoShowCount; ?><br>	
	<em>Actual</em> judged performances and tests:<?php print $musicCount + $soloCount + $ensembleCount - ($musicNoShowCount + $soloNoShowCount + $ensembleNoShowCount); ?><br>
	Number of students participating: <?php print $historyCount; ?><br>
</div>
  <input type="button" name="btnShowClassInfo" value="Show Class Participation Info" onClick="location='AdminClassInfo.php'">

</body>
</html>
