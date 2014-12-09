<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Demo Festival Home</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js">
</script>
<body bgcolor="FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><div align=left> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
    <td width=200 valign="top" background="img/cellbg19133.gif"> 
      
    </td>
<?php
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

// lookup festival date
	$sql = "SELECT * FROM Festivals";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	
	$FestivalsRow = mysql_fetch_array($result);

	// now get the festival's date, and convert to English
	$festivalDate = $FestivalsRow['EventDate'];
	$sql = "SELECT UNIX_TIMESTAMP('$festivalDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$dateString = date("l, F d, Y", $dateRow['MyTimeSt']);
	 	$today = date("Y-m-d");

	// now get performance registration start date, and convert to English
	$performanceStartDate = $FestivalsRow['PerformanceRegStart'];
	$sql = "SELECT UNIX_TIMESTAMP('$startDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$startString = date("l, F d, Y", $dateRow['MyTimeSt']);
	
	// now get performance registration end date, and convert to English
	$performanceEndDate = $FestivalsRow['PerformanceRegEnd'];
	$sql = "SELECT UNIX_TIMESTAMP('$endDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$endString = date("l, F d, Y", $dateRow['MyTimeSt']);

	// now get studio registration start date, and convert to English
	$studioStartDate = $FestivalsRow['StudioRegStart'];
	$sql = "SELECT UNIX_TIMESTAMP('$startDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$studioStartString = date("l, F d, Y", $dateRow['MyTimeSt']);
	
	// now get studio registration end date, and convert to English
	$studioEndDate = $FestivalsRow['StudioRegEnd'];
	$sql = "SELECT UNIX_TIMESTAMP('$endDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$studioEndString = date("l, F d, Y", $dateRow['MyTimeSt']);

	// now get student registration start date, and convert to English
	$studentStartDate = $FestivalsRow['PerformanceRegStart'];
	$sql = "SELECT UNIX_TIMESTAMP('$startDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$studentStartString = date("l, F d, Y", $dateRow['MyTimeSt']);
	
	// now get student registration end date, and convert to English
	$studentEndDate = $FestivalsRow['PerformanceRegEnd'];
	$sql = "SELECT UNIX_TIMESTAMP('$endDate') AS MyTimeSt";
	$dateResult = mysql_query($sql, $selconn);
	$dateRow = mysql_fetch_array($dateResult);
	$studentEndString = date("l, F d, Y", $dateRow['MyTimeSt']);

	// if today is before registration starts, or after registration ends, serve "no reg today" page
	// if today is after the festival is over, just send them back
	if ($festivalDate < $today)
	{
		$greeting = "Demo Junior Music Festival was held on $dateString ";
	}
	else 
	{
		$greeting = "Demo Junior Music Festival will be held on $dateString ";
	}
?>

    <td valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="right" valign="top"> 
            <td><img src="img/compname1.jpg" width="572" height="49" name="im1"></td>
          </tr>
          <tr align="left" valign="top"> 
            <td> 
              <h3><br><font face="arial,helvetica,sans-serif"> <?php print $greeting; ?> </font></h3>
              <table width="73%" border="0" align="center">
                <tr> 
                  <td><div align="center"> <font size="+2">Want to know how students are graded?</font> <font color="#009900" size="+2"><br>
                      <a href="img/ratingSheet.GIF">Click here for a look at a Rating Sheet</a></font> <br>
                      (if it's a bit fuzzy, click once on the image to enlarge it) </div>
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><font face="arial,helvetica,sans-serif">Welcome! </font>
				  	  <font face="Arial">Please use our site to:</font></td>
                </tr>
                <tr> 
                  <td><ul>
                      <li><?php
					  	if($today < $studioStartDate)
							print "<font face=\"arial,helvetica,sans-serif\">Studio Registration will be available starting $studioStartString</font>";
						else if (($studioStartDate <= $today) && ($today <= $studioEndDate) )
							print "<font face=\"arial,helvetica,sans-serif\"><a href=\"StudioReg.php\">Register your studio</a></font>";
						else if ($studioEndDate < $today)
							Print "<font face=\"arial,helvetica,sans-serif\">Sorry, Studio Registration is closed now!</font>";
                      ?></li>
					  <li><font face="arial,helvetica,sans-serif">
					    <a href="Timeline.html">View the Teacher Timeline</a></font>
					  </li>
                      <li>
					  <?php
					  	if($today < $studentStartDate)
							print "<font face=\"arial,helvetica,sans-serif\">Student Registration will be available starting $studentStartString</font>";
						else if (($studentStartDate <= $today) && ($today <= $studentEndDate) )
							print "<font face=\"arial,helvetica,sans-serif\"><a href=\"StudioAdmin.php\">Register your students</a></font>";
						else if ($studentEndDate < $today)
							Print "<font face=\"arial,helvetica,sans-serif\">Sorry, student registration is closed now!</font>";
                      ?>
					  </li>
                     <li>
					  <?php
					  	if($today < $performanceStartDate)
							print "<font face=\"arial,helvetica,sans-serif\">Performance scheduling will be available starting $performanceStartString</font>";
						else if (($performanceStartDate <= $today) && ($today <= $performanceEndDate) )
							print "<font face=\"arial,helvetica,sans-serif\"><a href=\"StudioAdmin.php\">Schedule your students' performances</a></font>";
						else if ($performanceEndDate < $today)
							Print "<font face=\"arial,helvetica,sans-serif\">Sorry, Performance scheduling is closed now!</font>";
                      ?>
					  </li>

                      <li><font face="arial,helvetica,sans-serif">
					  	<a href="mailto:organizer@festivalware.net">Contact </a>
						the Organizers of this year's FestivalWare</font></li>
                      <li><font face="arial,helvetica,sans-serif"><a href="mailto:goetzj@festivalware.net">Contact</a> 
                        the webmaster for problems with this site</font></li>
                    </ul></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><font face="Arial">Click <a href="http://www.DMTA.org" title="Demo Music Teachers Association">here</a> 
                    to visit the <a href="http://www.DMTA.org">Demo Music 
                    Teachers Association</a> Website</font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><font face="Arial"><font size="2">We are a member of the</font><a href="http://www.mtna.org/home.htm"><font size="2"> 
                    Music Teachers National Assosciation</font></a></font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><font size="2" face="Arial">FestivalWare is held in association 
                    with the <a href="http://www.nfmc-music.org">National Federation 
                    of Music Clubs</a></font></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p><font size="1" face="Arial">Copyright 2003 FestivalWare</font></p></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>

</body>


</html>
