<?php include("IsAuth_Studio.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Performance Information</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>
<script src="RollOvers.js"></script>
<script language="JavaScript">

function AreYouSure()
{
	return( confirm("Are you sure you want to delete this record?"));
}

</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" background="img/lightbrown.jpg">
        <tr align="left" valign="top"> 
          <td> 
			<h2>Verify Performance Information Page</h2>
            
            <p> 
		  <?php		
			$database = $_SESSION['DatabaseName'];
				
			$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
			mysql_select_db($database, $selconn) or die(mysql_error());

			$sql = "SELECT StudentFirstName, StudentMiddleName, StudentLastName, Birthdate," .
			" EventName, ClassDescription, SCJM, EnsembleID, " .
			"RequiredSelection, RequiredComposer, ChoiceSelection, ChoiceComposer, PerformanceLength " .
			"from Students, History, Events, Classes where HistoryId = $_POST[reqSelChoosePerf] and " .
			"History.EventID = Events.EventID and History.Classid = Classes.ClassID " .
			"and History.StudentID = Students.StudentID";

			$result = mysql_query ($sql, $selconn) or die(mysql_error());
			// if row count = 0 then something's broken... this should never happen

			$row = mysql_fetch_array($result);

			mysql_close($selconn);	
			
			?>
			<font size="+1" face="Arial, Helvetica, sans-serif"><strong>
            <table width="70%" border="1" align="center">
              <tr>
                <td><strong>
				  To change this information, first delete this 
                  performance by clicking the Delete button below, then create 
                  a new performance with the correct information.</strong></td>
              </tr>
			  <tr><td>
<?php
if($row['EnsembleID'] != NULL)
{
	print "<strong><font color=\"FF0000\">This performance is part of an ensemble! Deleting this performance will also delete the other ensemble records!</font></strong>";
}
?>
			  </td></tr>
            
			</table>
			</strong></font>
            <table width="70%" border="1" cellpadding="3" cellspacing="0" align="center">
             <tr> 
                <td width="40%"> <div align="right">First Name</div></td>
                <td width="1%">&nbsp;</td>
                <td width="59%"><?php print $row['StudentFirstName'];?></td>
              </tr>
              <tr> 
                <td><p align="right"> Middle Name</p></td>
                <td>&nbsp;</td>
                <td><?php print $row['StudentMiddleName'];?></td>
              </tr>
              <tr> 
                <td> <div align="right">Last Name</div></td>
                <td>&nbsp;</td>
                <td><?php print $row['StudentLastName'];?></td>
              </tr>
              <tr> 
                <td><p align="right">Birthdate</p></td>
                <td>&nbsp;</td>
                <td><?php print $row['Birthdate'];?></td>
              </tr>
              <tr> 
                <td><div align="right">Event</div></td>
                <td>&nbsp;</td>
                <td><?php print $row['EventName'];?></td>
              </tr>
              <tr> 
                <td><div align="right">Class </div></td>
                <td>&nbsp;</td>
                <td><?php print $row['ClassDescription'];?></td>
              </tr>
              <tr> 
                <td><div align="right">SCJM?</div></td>
                <td>&nbsp;</td>
                <td> 
                  <?php if($row['SCJM'] == 'Y') print "Yes"; else print "No";?>
                </td>
              </tr>
              <tr> 
                <td><div align="right">Required Selection</div></td>
                <td>&nbsp;</td>
                <td>&nbsp;<?php print $row['RequiredSelection'];?></td>
              </tr>
              <tr> 
                <td><div align="right">Required Composer</div></td>
                <td>&nbsp;</td>
                <td>&nbsp;<?php print $row['RequiredComposer'];?></td>
              </tr>
              <tr> 
                <td><div align="right">Choice Selection</div></td>
                <td>&nbsp;</td>
                <td>&nbsp;<?php print $row['ChoiceSelection'];?></td>
              </tr>
              <tr> 
                <td><div align="right">Choice Composer</div></td>
                <td>&nbsp;</td>
                <td>&nbsp;<?php print $row['ChoiceComposer'];?></td>
              </tr>
              <tr> 
                <td><div align="right">Time Required</div></td>
                <td>&nbsp;</td>
                <td>&nbsp;<?php print $row['PerformanceLength'] . " minutes";?></td>
              </tr>
            </table>
            <font size="+1">
			<table width="70%" border="1" align="center">
              <tr> 
                <form name="frmDelete" method="post" action="PerfDeleteComplete.php" onSubmit="return AreYouSure()">
                  <input type="hidden" name="hdnHistoryID" value="<?php print $_POST['reqSelChoosePerf']; ?>">
                  <input type="hidden" name="hdnEnsembleID" value="<?php print $row['EnsembleID']; ?>">
				  <td align="center"><input type="submit" name="btnDelete" value="Delete this Performance"></td>
                  <td><input type="button" name="btnSelectOther" value="Select another Performance" onClick="window.location='PerfLookup.php'"></td>
                  <td align="center"><input type="button" name="btnStudioAdmin" value="Back to Studio Administration" onClick="window.location='StudioAdmin.php'"></td>
                </form>
              </tr>
            </table>
			</font>
    </td>
  </tr>
</table>	

<?php include('../php/TableEnd.php'); ?>
</body>
</html>
