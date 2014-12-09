<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>Festivalware Demo {Template page...replace this text}</title>
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
	  <!--#include virtual="/Navigation.ssi" -->
    </td>
<?php
	$database = $_SESSION['DatabaseName'];
				
//				$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
//				mysql_select_db($database, $selconn) or die(mysql_error());
// uncomment to here

// testing section, comment when going live
//				$selconn = mysql_connect ( "localhost","goetzj","ids98mlk") or die(mysql_error()); 
//				mysql_select_db("test", $selconn) or die(mysql_error());
// comment to here
?>

    <td valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="right" valign="top"> 
            <td><img src="img/compname1.jpg" width="572" height="49" name="im1"></td>
          </tr>
          <tr align="left" valign="top"> 
            <td> 
              <h3><br><font face="arial,helvetica,sans-serif"> Greeting goes here </font></h3>
              <table width="73%" border="0" align="center">
                <tr> 
					<td>&nbsp; fill in information here </td>
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
