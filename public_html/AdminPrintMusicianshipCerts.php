<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=charset=iso-8859-1">
<meta name=Generator content="text/html; charset=iso-8859-1">
<title>FestivalWare Demo Festival Administration: Print Musicianship Certificates</title>
</head>
<script src="RollOvers.js"></script>
<body lang=EN-US>

<?php

function fixInput($inputStr)
{
	$fixedStr = preg_replace("/([;<>\?\^\*\|`&\$!#\(\)\[\]\{\}\"\=])/", "", $inputStr);
	return $fixedStr;
}
	$database = $_SESSION['DatabaseName'];
				
	$selconn = mysql_connect ( "localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());
	
	// get the performance numbers and types
	$sql = 
	"SELECT StudentFirstName, StudentLastName, StudioName, ClassDescription
	FROM MusicianshipHistory, Students, Studios, Classes 
	WHERE Year = 2004 AND MusicianshipHistory.StudentID=Students.StudentID 
	AND MusicianshipHistory.StudioID=Studios.StudioID
	AND MusicianshipHistory.ClassID=Classes.ClassID
	ORDER BY StudentLastName";

	$perfResult = mysql_query($sql, $selconn) or die(mysql_error());
	while($mRow = mysql_fetch_array($perfResult))
	{
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 1.0 Transitional//EN\">";
		echo "<html>";
		echo "<head>";
		echo "<title>Certificates for FestivalWare Demo Festival</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
		echo "<style type=\"text/css\">";
		echo "<!--";
		echo ".style1 {font-family: \"Monotype Corsiva\"; font-size: xx-large;}";
		echo ".style2 {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: large;}";
		echo ".style3 {font-size: xx-small}";
		echo "body  {font-family:Verdana, Arial, Helvetica, sans-serif; font-size: small}";
		echo "h3    {font-family: \"Times New Roman\", Times, serif; font-size: small; font-weight: bold}";
		echo "h5    {font-family:  \"Times New Roman\", Times, serif; font-size: xx-small; }";
		echo "h6    {page-break-after:always}";
		echo "-->";
		echo "</style>";
		echo "</head>";
		echo "<body>";
		echo "<table width=\"100%\"  border=\"0\">";
		echo "<tr><td height=\"63\" valign=\"bottom\"><div align=\"center\" class=\"style1\">$mRow[StudentFirstName] $mRow[StudentLastName]</div></td></tr>";
		echo "<tr><td><div align=\"center\" class=\"style2\">$mRow[StudioName] </div></td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr><td height=\"125\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr><td width=\"30%\">&nbsp;</td><td width=\"70%\"><font color=\"#0099FF\">NEVADA</font></td></tr></table></td></tr>";
		echo "<tr><td height=\"27\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr><td width=\"5%\">&nbsp;</td><td width=\"30%\" align=\"center\">";
		echo "Musicianship Theory</td><td width=\"35%\" align=\"center\">$mRow[ClassDescription]</td><td width=\"23%\" align=\"center\">2004</td><td width=\"5%\">&nbsp;</td>";
		echo "</tr></table></td></tr>";
		echo "<tr><td height=\"55\" valign=\"bottom\"><table width=\"100%\" border=\"0\"><tr>";
		echo "<td align=\"center\"><img src=\"img/cbgsig.jpg\" width=\"183\" height=\"37\"></td>";
		echo "<td align=\"center\"><img src=\"img/nancysig.jpg\" width=\"183\" height=\"37\"></td>";
		echo "</tr></table></td></tr>";
		echo "<tr><td height=\"75\" valign=\"bottom\" align=\"left\"><div class=\"h5 style3\">Musicianship/HFA224/8:00</div></td></tr></table>";
		echo "<h6>&nbsp;</h6>";
		echo "</body>";
		echo "</html>";
	} // end while get next musicianship row
?>
<script type="text/javascript" language="javascript1.2">
<!--
if (typeof(window.print) != 'undefined') {
    window.print();
}
//-->
</script>
</body>
</html>
