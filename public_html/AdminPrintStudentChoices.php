<?php include("IsAuth_Admin.php");?>
<!-- This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
--><html>
<head>

<title>FestivalWare Demo Festival Site Administration Page</title>
<meta name=description content="">
<meta name=keywords content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Thu, 1 Jan 1970 01:00:00 GMT">
<style type="text/css">
<!--
body  {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #CCFFFF}
h1    {font-family: arial, helvetica, geneva, sans-serif; font-size: large; font-weight: bold}
h3    {font-family: arial, helvetica, geneva, sans-serif; font-size: medium; font-weight: bold}
th    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; font-weight: bold; color: #000000; background-color: #ffffff; padding:2px}
td    {font-family: arial, helvetica, geneva, sans-serif; font-size: small; color: #000000; background-color: #CCFFFF; padding:2px}
span  {page-break-after: always}
//-->
</style>
</head>

<script src="RollOvers.js"></script>

<body bgcolor="#CCFFFF" leftmargin="15">
<font face="Arial, Helvetica, sans-serif" size="+1">
<form name="frmAdminPrintStudents" method="post" action="AdminPrintStudent.php" onSubmit="return checkReqEntries(this)">

<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
	  <td align="right"><img src="img/compname1.jpg" width="572" height="49" name="im1"></td>
  </tr>
  <tr align="left" valign="top"> 
	  
    <td> <br>
		<h2>Site Administration: Student Printing Choices</h2>
		
        <h3>You are currently logged in as: <font color="#008000"><?php print $_SESSION["AdminJob"]; ?> 
          <font size="+1"><a href="Logout.php" tabindex="-1">Logout</a></font></font></h3>
        <h3 align="center"><font color="#008000"> 
          <input name="btnSubmit" type="submit" value="Submit" tabindex="56" >
          <input type="reset" name="Reset" value="Reset">
          <input name="btnBackToAdmin" type="button" value="Back to Administration" onClick="location='Administration.php'"  tabindex="57">
          </font></h3>
        </td>
  </tr>
  <tr>
	<td>
      <table width="100%" border="1" cellspacing="5" cellpadding="5">
        <tr> 
          <td width="300" valign="top"> <h3>Check the items to print:</h3>
            <table width="100%">
              <tr> 
                <td width="89%"><div align="right">Student ID Number</div></td>
                <td width="11%"><input type="checkbox" name="chkStudentID" value="True" tabindex="1"></td>
              </tr>
              <tr> 
                <td><div align="right">Time Entered</div></td>
                <td><input type="checkbox" name="chkTimeStamp" value="True" tabindex="2"></td>
              </tr>
              <tr> 
                <td><div align="right">First Name</div></td>
                <td><input type="checkbox" name="chkFirstName" value="True"  tabindex="3"></td>
              </tr>
              <tr> 
                <td><div align="right">Middle Name</div></td>
                <td><input type="checkbox" name="chkMiddleName" value="True" tabindex="4"></td>
              </tr>
              <tr> 
                <td><div align="right">Last Name</div></td>
                <td><input type="checkbox" name="chkLastName" value="True" tabindex="5"></td>
              </tr>
              <tr> 
                <td><div align="right">Student's Email</div></td>
                <td><input type="checkbox" name="chkStudentEmail" value="True" tabindex="6"></td>
              </tr>
              <tr> 
                <td><div align="right">Studio ID Number</div></td>
                <td><input type="checkbox" name="chkStudioID" value="True" tabindex="7"></td>
              </tr>
              <tr> 
                <td><div align="right">Studio Name</div></td>
                <td><input type="checkbox" name="chkStudioName" value="True" tabindex="8"></td>
              </tr>
              <tr> 
                <td><div align="right">Studio Owner <br>
                      (Teacher's name)</div></td>
                <td><input type="checkbox" name="chkTeacherName" value="True" tabindex="9"></td>
              </tr>
              <tr> 
                <td><div align="right">Street Address</div></td>
                <td><input type="checkbox" name="chkStreetAddr" value="True" tabindex="10"></td>
              </tr>
              <tr> 
                <td><div align="right">City</div></td>
                <td><input type="checkbox" name="chkCity" value="True" tabindex="11"></td>
              </tr>
              <tr> 
                <td><div align="right">State</div></td>
                <td><input type="checkbox" name="chkState" value="True" tabindex="12"></td>
              </tr>
              <tr> 
                <td><div align="right">Zip Code</div></td>
                <td><input type="checkbox" name="chkZip" value="True" tabindex="13"></td>
              </tr>
              <tr> 
                <td><div align="right">Student's Phone Number</div></td>
                <td><input type="checkbox" name="chkPhone" value="True" tabindex="14"></td>
              </tr>
              <tr> 
                <td><div align="right">Birthdate</div></td>
                <td><input type="checkbox" name="chkBirthdate" value="True" tabindex="15"></td>
              </tr>
              <tr> 
                <td><div align="right">Parents' Name(s)</div></td>
                <td><input type="checkbox" name="chkParentName" value="True" tabindex="16"></td>
              </tr>
              <tr> 
                <td><div align="right">Parent's Phone Number</div></td>
                <td><input type="checkbox" name="chkParentPhone" value="True" tabindex="17"></td>
              </tr>
              <tr> 
                <td><div align="right">Monitor (y/n)</div></td>
                <td><input type="checkbox" name="chkMonitor" value="True" tabindex="18"></td>
              </tr>
            </table></td>
          <td width="400" valign="top"> <h3>Select which students to print:</h3>
            <table width="100%">
              <tr> 
                <td width="34%">Student ID</td>
                <td width="23%"> <select name="selStudentID"  tabindex="19">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select> </td>
                <td width="43%"><input type="text" name="txtStudentID" size="10" maxlength="8" tabindex="20"></td>
              </tr>
              <tr> 
                <td width="34%">Time Entered</td>
                <td width="23%"><select name="selTimeStamp" tabindex="21">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtTimeStamp" size="22" maxlength="20"  tabindex="22"></td>
              </tr>
              <tr> 
                <td width="34%">First Name</td>
                <td width="23%"><select name="selFirstName"  tabindex="23">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtFirstName" size="22" maxlength="30" tabindex="24"></td>
              </tr>
              <tr> 
                <td width="34%">Middle Name</td>
                <td width="23%"><select name="selMiddleName" tabindex="25">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                 </select></td>
                <td width="43%"><input  type="text" name="txtMiddleName" size="22" maxlength="30" tabindex="26"></td>
              </tr>
              <tr> 
                <td width="34%">Last Name</td>
                <td width="23%"><select name="selLastName" tabindex="27">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtLastName" size="22" maxlength="30" tabindex="28"></td>
              </tr>
              <tr> 
                <td width="34%">Student Email</td>
                <td width="23%"><select name="selEmail" tabindex="29">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtEmail" size="22" maxlength="50" tabindex="29"></td>
              </tr>
              <tr> 
                <td width="34%">Studio ID</td>
                <td width="23%"><select name="selStudioID" tabindex="30">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtStudioID" size="22" maxlength="11" tabindex="31"></td>
              </tr>
              <tr> 
                <td width="34%">Teacher's Name</td>
                <td width="23%"><select name="selTeachersName" tabindex="32">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtTeachersName" size="22" maxlength="50" tabindex="33"></td>
              </tr>
              <tr> 
                <td width="34%">Street Address</td>
                <td width="23%"><select name="selStreet_Addr" tabindex="34">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtStreet_Addr" size="22" maxlength="75" tabindex="35"></td>
              </tr>
              <tr> 
                <td width="34%">City</td>
                <td width="23%"><select name="selCity"  tabindex="36">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtCity" size="22" maxlength="25" tabindex="37"></td>
              </tr>
              <tr> 
                <td width="34%">State</td>
                <td width="23%"><select name="selState" tabindex="38">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>				  
                <td width="43%"><select  size="1" name="txtState" tabindex="39">
					<option>AL</option><option>AK</option><option>AZ</option><option>AR</option><option>CA</option><option>CO</option><option>CT</option><option>DE</option><option>DC</option><option>FL</option><option>GA</option><option>HI</option><option>ID</option><option>IL</option><option>IN</option><option>IA</option><option>KS</option><option>KY</option><option>LA</option><option>ME</option><option>MD</option><option>MA</option><option>MI</option><option>MN</option><option>MS</option><option>MO</option><option>MT</option><option>NE</option><option selected>NV</option><option>NH</option><option>NJ</option><option>NM</option><option>NY</option><option>NC</option><option>ND</option><option>OH</option><option>OK</option><option>OR</option><option>PA</option><option>PR</option><option>RI</option><option>SC</option><option>SD</option><option>TN</option><option>TX</option><option>UT</option><option>VT</option><option>VA</option><option>WA</option><option>WV</option><option>WI</option><option>WY</option>
				  </select>
				  </td>
				  </tr>
              <tr> 
                <td width="34%">Zip Code</td>
                <td width="23%"><select name="selZipCode" tabindex="40">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtZipCode" size="10" maxlength="10" tabindex="41"></td>
              </tr>
              <tr> 
                <td width="34%">Student Phone</td>
                <td width="23%"><select name="selStudentPhone"  tabindex="42">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtStudentPhone" size="12" maxlength="12" tabindex="43"></td>
              </tr>
              <tr> 
                <td width="34%">Birthdate</td>
                <td width="23%"><select name="selBirthdate" tabindex="44">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtBirthdate" size="10" maxlength="10" tabindex="45"></td>
              </tr>
              <tr> 
                <td width="34%">Parent's Name</td>
                <td width="23%"><select name="selParentsName" tabindex="46">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtParentsName" size="20" maxlength="50" tabindex="47"></td>
              </tr>
              <tr> 
                <td width="34%">Parent's Phone</td>
                <td width="23%"><select name="selParentsPhone" tabindex="48">
                    <option value="0" selected>&nbsp;</option>
                    <option value="LT">&lt;</option>
                    <option value="LE">&le;</option>
                    <option value="GT">&gt;</option>
                    <option value="GE">&ge;</option>
                    <option value="EQ">=</option>
                    <option value="NE">not =</option>
                    <option value="like">Like</option>
                  </select></td>
                <td width="43%"><input  type="text" name="txtParentsPhone" size="12" maxlength="12" tabindex="49"></td>
              </tr>
              <tr> 
                <td>Monitor</td>
                <td><select name="selMonitor" tabindex="50">
                    <option value="0" selected>&nbsp;</option>
                    <option value="Y"> = Y</option>
                    <option value="N"> = N</option>
                  </select></td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td width="34%">Registered for year</td>
                <td width="23%"><select name="selYear" tabindex="51">
                    <option value="0" selected>&nbsp;</option>
                    <option value="2001"> 2001</option>
                    <option value="2002"> 2002</option>
                    <option value="2003"> 2003</option>
                    <option value="2004"> 2004</option>
                  </select></td>
                <td width="43%">&nbsp;</td>
              </tr>
            </table></td>
		
          <td width="28%" valign="top"> <h3>Choose the sorting order:</h3>
            <table width="100%">
			  <tr>
                <td height="60">First by 
                    <select name="selSortOrder1" tabindex="52">
                      <option value="0">&nbsp;</option>
                      <option value="StudentID">Student ID</option>
                      <option value="TimeStamp">Timestamp</option>
                      <option value="FirstName">First Name</option>
                      <option value="MiddleName">Middle Name</option>
                      <option value="LastName">Last Name</option>
                      <option value="email">Students email address</option>
                      <option value="StudioID">Studio ID</option>
                      <option value="Street_Addr">Students Street Address</option>
                      <option value="City">Students City</option>
                      <option value="State">Students State</option>
                      <option value="Zip">Zip Code</option>
                      <option value="Phone">Students Phone number</option>
                      <option value="Birthdate">Birthdate</option>
                      <option value="ParentName">Parents name</option>
                      <option value="ParentPhone">Parents phone number</option>
                      <option value="Monitor">Monitor status</option>
                    </select>
                  </td></tr>
			  <tr>
                <td height="60">Then by 
                    <select name="selSortOrder2" tabindex="53">
                      <option value="0">&nbsp;</option>
                      <option value="StudentID">Student ID</option>
                      <option value="TimeStamp">Timestamp</option>
                      <option value="FirstName">First Name</option>
                      <option value="MiddleName">Middle Name</option>
                      <option value="LastName">Last Name</option>
                      <option value="email">Students email address</option>
                      <option value="StudioID">Studio ID</option>
                      <option value="Street_Addr">Students Street Address</option>
                      <option value="City">Students City</option>
                      <option value="State">Students State</option>
                      <option value="Zip">Zip Code</option>
                      <option value="Phone">Students Phone number</option>
                      <option value="Birthdate">Birthdate</option>
                      <option value="ParentName">Parents name</option>
                      <option value="ParentPhone">Parents phone number</option>
                      <option value="Monitor">Monitor status</option>
                    </select>
                  </td></tr>
			  <tr>
                <td height="60">Then by 
                    <select name="selSortOrder3" tabindex="54">
                      <option value="0">&nbsp;</option>
                      <option value="StudentID">Student ID</option>
                      <option value="TimeStamp">Timestamp</option>
                      <option value="FirstName">First Name</option>
                      <option value="MiddleName">Middle Name</option>
                      <option value="LastName">Last Name</option>
                      <option value="email">Students email address</option>
                      <option value="StudioID">Studio ID</option>
                      <option value="Street_Addr">Students Street Address</option>
                      <option value="City">Students City</option>
                      <option value="State">Students State</option>
                      <option value="Zip">Zip Code</option>
                      <option value="Phone">Students Phone number</option>
                      <option value="Birthdate">Birthdate</option>
                      <option value="ParentName">Parents name</option>
                      <option value="ParentPhone">Parents phone number</option>
                      <option value="Monitor">Monitor status</option>
                    </select>
                  </td></tr>
			  <tr><td height="60">Then by 
                    <select name="selSortOrder4" tabindex="55">
                      <option value="0">&nbsp;</option>
                      <option value="StudentID">Student ID</option>
                      <option value="TimeStamp">Timestamp</option>
                      <option value="FirstName">First Name</option>
                      <option value="MiddleName">Middle Name</option>
                      <option value="LastName">Last Name</option>
                      <option value="email">Students email address</option>
                      <option value="StudioID">Studio ID</option>
                      <option value="Street_Addr">Students Street Address</option>
                      <option value="City">Students City</option>
                      <option value="State">Students State</option>
                      <option value="Zip">Zip Code</option>
                      <option value="Phone">Students Phone number</option>
                      <option value="Birthdate">Birthdate</option>
                      <option value="ParentName">Parents name</option>
                      <option value="ParentPhone">Parents phone number</option>
                      <option value="Monitor">Monitor status</option>
                  </select>
                  </td></tr>
			</table>
		  </td>
        </tr>
      </table>
	 </td>
  </tr>
	<tr>
      <td> 
        <p>&nbsp; </p>
   </td></tr>
</table>

</form>
	<p>&nbsp;</p>
	<p><font size="1" face="Arial">Copyright 2003-2004 FestivalWare</font></p></td>
</body>
</html>
