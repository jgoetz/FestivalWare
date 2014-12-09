<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
-->
<html>
<head>
<title>FestivalWare Studio Registration</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
</head>

<script src="RollOvers.js"></script>

<script language="JavaScript">

</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<?php
	$tempconn = mysql_connect ("localhost","festival_mainAll","hy58*dfa") or die(mysql_error()); 
	mysql_select_db("festival_main", $tempconn) or die(mysql_error());

	$sql = "Select * from Organizations";
	$result = mysql_query($sql, $tempconn) or die(mysql_error());

?>
<form  method="post" name="StudioRegistration" onSubmit="return checkReqEntries(this)" action="StudioAddToDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" background="img/lightbrown.jpg">
  <tr>
    <td><div align="right"></div></td>
    <td>&nbsp;</td>
  </tr>

	<tr><td colspan="2"><h2 align="center">Studio Registration Page</h2></td></tr>
	<tr><td colspan="2"><div align="center"><span style="text-transform: uppercase"><font face="Geneva, Arial, Helvetica, sans-serif" size="2">Required  entries in <font color="#ff0000">Red</font> </font></span></div></td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
		<td align="right"><font color="#ff0000">Enter your organization ID number:</font></td>
		<td>
          <input name="reqTxtOrgID" type="text" id="reqTxtOrgID" size="10" maxlength="8" title="Organization Code">
</td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr><td><div align="right"><font color="#ff0000">Your First Name: </font></div></td><td><input maxlength="30" size="30" name="reqFirstName" title="First Name"/> </td></tr>
	<tr><td><div align="right"><font color="#ff0000">Your Last Name: </font></div></td><td><input  maxlength="50" size="30" name="reqLastName" title="Last Name"/> </td></tr>
	<tr><td><div align="right"><font color="#ff0000">Your email address:</font></div></td><td><input  maxlength="50" size="50" name="reqEmail" title="Email"/></td></tr>
	<tr><td><div align="right"><font color="#ff0000">Please select a login ID (5-10 characters, no spaces): </font></div></td><td><input name="reqLoginID" type="text" title="LoginID" size="15" maxlength="10"></td></tr>
	<tr><td><div align="right"><font color="#ff0000">Please select a password (5-10 characters): </font></div></td><td> <input name="reqPassword1" type="password" title="Password" size="12" maxlength="10"></td></tr>
	<tr><td><div align="right"><font color="#ff0000">Please re-enter your password: </font></div></td><td><input name="reqPassword2" type="password" title="Password copy" size="12" maxlength="10"></td></tr>
	<tr><td><div align="right"><font color="#ff0000">Studio name</font>:</div></td><td> <input maxlength="50" size="40" name="reqStudioName" title="Studio Name"/> 
	<tr><td colspan="2"><div align="center"><font size="2">(note: if you don't have a studio name, use &lt;last name&gt; Music Club)</font></div></td></tr>
	<tr><td><div align="right"><font color="#ff0000">Studio's street address</font>: </div></td><td><input maxlength="75" size="50" name="reqStreetAddress" title="Street Address"/> </td></tr>
	<tr><td><div align="right"><font color="#ff0000">Studio's City</font>: </div></td><td><input maxlength="25" size="25" name="reqCity" value="Las Vegas" title="City"/> </td></tr>
	<tr><td><div align="right"><font color="#ff0000">Studio's State</font>: </div></td><td><select  size="1" name="reqSelState" title="State">
                    <option value="-1">  </option>
                    <option>AL</option>
                    <option>AK</option>
                    <option>AZ</option>
                    <option>AR</option>
                    <option>CA</option>
                    <option>CO</option>
                    <option>CT</option>
                    <option>DE</option>
                    <option>DC</option>
                    <option>FL</option>
                    <option>GA</option>
                    <option>HI</option>
                    <option>ID</option>
                    <option>IL</option>
                    <option>IN</option>
                    <option>IA</option>
                    <option>KS</option>
                    <option>KY</option>
                    <option>LA</option>
                    <option>ME</option>
                    <option>MD</option>
                    <option>MA</option>
                    <option>MI</option>
                    <option>MN</option>
                    <option>MS</option>
                    <option>MO</option>
                    <option>MT</option>
                    <option>NE</option>
                    <option selected>NV</option>
                    <option>NH</option>
                    <option>NJ</option>
                    <option>NM</option>
                    <option>NY</option>
                    <option>NC</option>
                    <option>ND</option>
                    <option>OH</option>
                    <option>OK</option>
                    <option>OR</option>
                    <option>PA</option>
                    <option>PR</option>
                    <option>RI</option>
                    <option>SC</option>
                    <option>SD</option>
                    <option>TN</option>
                    <option>TX</option>
                    <option>UT</option>
                    <option>VT</option>
                    <option>VA</option>
                    <option>WA</option>
                    <option>WV</option>
                    <option>WI</option>
                    <option>WY</option>
                  </select> </td></tr>
	<tr><td><div align="right"><font color="#ff0000">Studio's Zip code</font>: </div></td><td><input   maxlength="5" size="7" name="reqZip" title="Zip Code"/></td></tr>
	<tr><td><div align="right"><font color="#ff0000">Your Phone number</font>: </div></td><td><input   maxlength="15" size="15" name="reqPhoneNumber" title="Phone Number"/>
	<tr><td colspan="2"><div align="center"><font size="2">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font> </div></td></tr>
	<tr><td><div align="right">Second phone number (Cell Phone): </div></td><td><input name="txtCellPhone" id="txtCellPhone" title="Cell Phone" size="15" maxlength="15"/></td></tr>
	<tr><td> <div align="right"><font color="#ff0000">Which Committee would you prefer?</font></div></td><td> 
	  <select size="1" name="reqSelCommitteePreference" title="Committee Preference">
		<option value="-1" selected>Select a committee  </option>
		<option value="Auditing">Auditing</option>
		<option value="Awards">Awards</option>
		<option value="Event">Event</option>
		<option value="Facilities">Facilities</option>
		<option value="Mailings">Mailings</option>
		<option value="Monitors">Monitors</option>
		<option value="Organization">Organization</option>
		<option value="Phone">Phone</option>
		<option value="Validation">Validation</option>
	  </select>
	</td></tr>
	<tr><td colspan="2"><div align="center">(Note: If your first choice of committee isn't listed above, that means the committee is full. 
          <br> Please select your second choice committee from those listed). </div></td></tr>
	<tr><td><div align="right"></div></td> <td>&nbsp;</td></tr>
	<tr><td colspan="2"><div align="center">Check here if you are an NMTA Member: <input name="DMTAMember" type="checkbox" id="DMTAMember" value="Y" title="NMTA Membership Status"></div></td>  </tr>
	<tr><td><div align="right"></div></td><td>&nbsp;</td></tr>
	<tr><td colspan="2"><div align="center">Please check your subject areas </div></td></tr>
    <tr><td> <div align="right">Piano</div></td><td><input name="chkPiano" type="checkbox" title="Piano" value="Y"></td></tr>
	<tr><td><div align="right">Woodwinds</font> </div></td><td><input name="chkWoodwinds" type="checkbox" title="Woodwinds" value="Y"></td></tr>
	<tr><td><div align="right">Voice</font> </div></td><td><input name="chkVoice" type="checkbox" title="Voice" value="Y"></td></tr>
	<tr><td><div align="right">Strings</font> </div></td><td><input name="chkStrings" type="checkbox" title="Strings" value="Y"></td></tr>
	<tr><td><div align="right">Brass</font> </div></td><td><input name="chkBrass" type="checkbox" title="Brass" value="Y"></td></tr>
	<tr><td><div align="right">Musicianship</font> </div></td><td><input name="chkMusicianship" type="checkbox" id="chkMusicianship" value="Y"></td></tr>
	<tr><td><div align="right">Other</div></td><td><input name="chkOther" type="checkbox" title="Other" value="Y"></td></tr>
	<tr><td><div align="right"></div></td><td>&nbsp;</td></tr>

	<tr><td align="center" colspan="2"><input name="submit" type="submit" value="Please submit my information" /> </td></tr>
      
  </table>

</form>   
</body>
</html>
