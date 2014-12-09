<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Deletion Complete</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js">
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="img/lightbrown.jpg">
        <tr align="left" valign="top"> 
          <td> <br>
            <h2>Performance - Delete Results Page</h2>
<?php				
	$database = $_SESSION['DatabaseName'];
	
	$delconn = mysql_connect ( "localhost","festival_deleter","by34wyb") or die(mysql_error()); 
	mysql_select_db($database, $delconn) or die(mysql_error());

	if($_POST['hdnEnsembleID'] != NULL){ // an ensemble set of records
		$sql = "DELETE FROM History WHERE EnsembleID = $_POST[hdnEnsembleID]";
		$result = mysql_query ($sql, $delconn) or die(mysql_error());
		mysql_close($delconn);
	}
	else{	// just a solo record
		$sql = "DELETE FROM History WHERE HistoryID = $_POST[hdnHistoryID]";
		$result = mysql_query ($sql, $delconn) or die(mysql_error());
		mysql_close($delconn);
	}
?>
            <p><font size="+1"><strong>You have successfully deleted the performance(s). 
              </strong></font><br>
            </p>
            <table width="50%" border="1">
              <tr>
                <td width="34%"><div align="center"><font size="+1">Click below 
                    to select a different performance</font></div></td>
                <td width="100%"> <div align="center"> <font size="+1">Click below 
                    to go back to the Studio Administration Page </font> </div></td>
              </tr>
              <tr>
                <td><input type="button" name="btnSelectOther" value="Select another Performance" onClick="window.location='PerfLookup.php'"> 
                </td>
                <td> <div align="center"> 
                    <input type="button" name="btnStudioAdmin" value="Back to Studio Administration" onClick="window.location='StudioAdmin.php'">
                  </div></td>
              </tr>
            </table>
            </td>
        </tr>
      </table> 
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
