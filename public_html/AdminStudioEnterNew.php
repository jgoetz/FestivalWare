<?php include('IsAuth_Admin.php'); ?>
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<?php include('../php/TableStart.php'); ?>
<form  method="post" name="StudioRegistration" onSubmit="return checkReqEntries(this)" action="AdminStudioAddToDB.php">
<table width="100%" border="0" cellspacing="0" cellpadding="2" height="100%" background="img/lightbrown.jpg">
	<tr valign="top"><td width="50%">&nbsp;</td><td width="50%">&nbsp;</td></tr>
	<tr><td colspan="2" align="center"><h2>Studio Registration Page</h2></td></tr>
	<tr><td colspan="2" align="center"><span style="text-transform: uppercase"><font face="Geneva, Arial, Helvetica, sans-serif" size="2">Required  entries in <font color="#ff0000">Red</font> </font></span></tr></td>
	<tr><td align="right"><font color="#ff0000">Your First Name: </font></td><td><input maxlength="30" size="30" name="reqFirstName" title="First Name"/> </tr></td>
	<tr><td align="right"><font color="#ff0000">Your Last Name: </font></td><td><input  maxlength="50" size="30" name="reqLastName"  title="Last Name"/> </tr></td>
	<tr><td align="right"><font color="#ff0000">Your email address:</font></td><td> <input  maxlength="50" size="50" name="reqEmail"  title="Email Address"/></tr></td>
	<tr><td align="right"><font color="#000000">Check here if you are an DMTA Member:</font></td><td> <input name="DMTAMember" type="checkbox"  title="MTA Member" value="Y"></tr></td>
	<tr><td align="right"><font color="#ff0000">Please select a login ID (5-10 characters, no spaces): </font></td><td><input name="reqLoginID" type="text"  title="Login ID" size="15" maxlength="10"></tr></td>
	<tr><td align="right"><font color="#ff0000">Please select a password (5-10 characters): </font></td><td> <input name="reqPassword1" type="password"  title="Password" size="12" maxlength="10"></tr></td>
	<tr><td align="right"><font color="#ff0000">Please re-enter your password: </font></td><td><input name="reqPassword2" type="password"  title="Reenter Password " size="12" maxlength="10"></tr></td>
	<tr><td align="right"><font color="#ff0000">Studio name:</font></td><td><input maxlength="50" size="40" name="reqStudioName"  title="Studio Name"/> 
	<tr><td colspan="2" align="center"><font size="2">(note: if you don't have a studio name, use &lt;last name&gt; Music Club)</font></tr></td>
	<tr><td align="right"><font color="#ff0000">Studio's street address:</font></td><td> <input maxlength="75" size="50" name="reqStreetAddress"  title="Street Address"/> </tr></td>
	<tr><td align="right"><font color="#ff0000">Studio's City:</font></td><td> <input maxlength="25" size="25" name="reqCity" value="Las Vegas"  title="City"/> </tr></td>
	<tr><td align="right"><font color="#ff0000">Studio's State:</font></td><td> <select  size="1" name="reqSelState"  title="State">
                    <option value="-1"> State </option>
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
                  </select> </tr></td>
	<tr><td align="right"><font color="#ff0000">Studio's Zip code:</font></td><td> <input   maxlength="5" size="7" name="reqZip"  title="Zip Code"/></tr></td>
	<tr><td align="right"><font color="#ff0000">Your Phone number:</font></td><td> <input   maxlength="15" size="15" name="reqPhoneNumber"  title="Phone Number"/>
	<tr><td colspan="2" align="center"><font size="2">(Please enter in the form xxx-xxx-xxxx, including area code and dashes!)</font> </tr></td>
	<tr><td align="right">Second phone number (Cell Phone):</td><td> <input maxlength="15" size="15" name="CelFone"  title="Cell Phone Number"/></tr></td>
	<tr><td align="right"> <font color="#ff0000">Which Committee would you prefer?</font></td><td> 
	  <select size="1" name="reqSelCommitteePreference" type="list" title="Committe Preference">
		<option value="-1" selected>Select a committee</option>
		<option value="Auditing">Auditing</option>
		<option value="Awards">Awards</option>
		<option value="Event">Event</option>
		<option value="Facilities">Facilities</option>
		<option value="Mailings">Mailings</option>
		<option value="Monitors">Monitors</option>
		<option value="Organization">Organization</option>
		<option value="Phone">Phone</option>
		<option value="Hospitality">Hospitality</option>
  </select></tr></td>
  <tr><td colspan="2" align="center">(Note: If your first choice of committee isn't listed above, 
  that means the committee is full. <br> Please select another committee from those listed).
	</td></tr>			

	<tr><td colspan="2" align="center">Please inidcate if you will be registering students for the following areas. <br>
				  If you would like to register students for an area not listed, please contact your Festival Organizer
	</td></tr>
	<tr><td align="right"> <font color="#FF0000">Piano</font> </td><td>
	  <label><input type="radio" value="Y" name="reqPiano" id="PianoY"/>Yes</label>
	  <label><input type="radio" value="N" name="reqPiano" id="PianoN"/>No</label>
	  </td></tr>
	  <tr><td align="right"> <font color="#FF0000">Woodwinds</font></td><td> 
	  <label><input type="radio" value="Y" name="reqWoodwinds" id="WoodWindsY"/>Yes</label>
	  <label><input type="radio" value="N" name="reqWoodwinds" id="WoodWindsN"/>No</label>
	  </td></tr>
	  <tr><td align="right"> <font color="#FF0000">Voice</font></td><td> 
	  <label><input type="radio" value="Y" name="reqVoice" id="VoiceY"/>Yes</label>
	  <label><input type="radio" value="N" name="reqVoice" id="VoiceN"/>No</label>
	  </td></tr>
	  <tr><td align="right"> <font color="#FF0000">Strings</font></td><td> 
	  <label><input type="radio" value="Y" name="reqStrings" id="StringsY"/>Yes</label>
	  <label><input type="radio" value="N" name="reqStrings" id="StringsN"/>No</label>
	  </td></tr>
	  <tr><td align="right"> <font color="#FF0000">Brass</font> </td><td>
	  <label><input type="radio" value="Y" name="reqBrass" id="BrassY"/>Yes</label>
	  <label><input type="radio" value="N" name="reqBrass" id="BrassN"/>No</label>
	  </td></tr>
	  <tr><td align="right"> <font color="#FF0000">Musicianship</font> </td><td>
	  <label><input type="radio" value="Y" name="reqMusicianship" id="MusicianshipY"/>Yes</label>
	  <label><input type="radio" value="N" name="reqMusicianship" id="MusicianshipN"/>No</label>
	</tr></td>
	<tr><td align="center"><font color="#ff0000">Are you located east or west of Las Vegas Blvd (The Strip)?</font></td><td>
		<label><input type="radio" value="E" name="reqEastOrWest" id="EastOrWestE"/> East of The Strip</label> <br>
		<label><input type="radio" value="W" name="reqEastOrWest" id="EastOrWestW"/> West of The Strip</label> 
	</td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr><td align="center"><input name="submit" type="submit" value="Register this Studio" /> </td>
		<td align="center"> <input name="btnStudioAdmin" type="button" id="btnStudioAdmin" onClick="window.location='Administration.php'" value="Back to Festival Administration"></td>
	</tr>
      
</table>

</form>   
<?php include('../php/TableEnd.php'); ?>
</body>
</html>
