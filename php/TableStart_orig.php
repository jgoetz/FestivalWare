<script src="RollOvers.js"></script>

<!-- table for the entire screen -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="91F4FF">
  <tr> 
  	<td>
	<!-- Logo Bar -->
	<table height="75" width="100%" bgcolor="91F4FF" border="0px" bordercolor="#0033CC">
		<tr>
			<td>
				<img src="img/LogoFW3.png" height="78" width="350">
			</td>
			<td valign="bottom">
				<a href="index.php">Home</a>
				<a href="Contact.php">Contact Us</a>
				<a href="FWTestimonials.htm">Testimonials</a>
				<a href="FWAbout.htm">About Us</a>
				<a href="FWDemo.htm">Demo FestivalWare</a>
			</td>
		</tr>
	</table><!-- end LogoBar -->
		<!-- start main page area -->
	<table><tr valign="top" bgcolor="91F4FF">

		<!-- NavColumn -->
		<td width="21%">
<?php
// if authenticated admin, teacher, or coordinator 
	if(isset($_SESSION['AuthorizationType']))
	{
?>
<table width="100%" border="0px" bordercolor="#0033CC">
	<tr><td>&nbsp;</td></tr>
	<tr><td align="center">You are logged in as <br>
			<font color="#0000FF"><?php print $_SESSION['AuthUserName']; ?></font>
	</td></tr>
	<tr><td align="center"><font color="#0000CC"><?php print $_SESSION['OrganizationName']; ?></font></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td align="center">If you are not <br><font color="#0000FF"><?php print $_SESSION['AuthUserName']; ?></font>,
			<br> please logout!
	</td></tr>
	<tr><td align="center"><input name="btnLogout" value="Logout" type="button" onClick="location='Logout.php'"></td></tr>
	<tr><td>&nbsp;</td></tr>
<?php 
	// if studio or organizer(admin), print the festival number and info 
	// for the festival they are messing with
	if( ($_SESSION['AuthorizationType'] == 'Studio') || ($_SESSION['AuthorizationType'] == 'Admin') )
	{
		print "<tr><td align=\"center\">You are working with <br>";
		print "<tr><td align=\"center\">festival #$_SESSION[FestivalID]<br>";
		print "<tr><td align=\"center\"><font color=\"#0000FF\">$_SESSION[FestivalName]</font><br></td></tr>";
	}
?>
	<tr height="175"><td>&nbsp;</td></tr>
	<tr><td><font size="-2">Copyright <?php print date("Y"); ?> FestivalWare.Net</font>
	</td></tr>
</table>
<?php
	}
// else, show login windows
	else
	{
	//grab login message, if it's defined
	if(isset($_SESSION['LoginMessage']))
	{
		$msg = "<font color=\"#FF0000\"><strong>" . $_SESSION['LoginMessage'] . "</strong></font>";
		unset($_SESSION['LoginMessage']); // clear it out for the next refresh
	}
	else
		$msg = "<strong>Please Sign In Here</strong>";
?>
<font size="-1">
<table width="100%" border="1px" bordercolor="#0033CC">
	<tr><td width="100%">
		<?php print $msg; ?>
		<form name="frmLogin"  method="post" onSubmit="return checkReqEntries(this)" action="CoordinatorAuthorizer.php">
			<table bgcolor="#00FFFF">
				<tr><td align="left" colspan="2"><strong>Coordinators Sign In</strong></td></tr>
				<tr><td align="left">Organization code </td><td align="left">
					<input type="text" name="reqOrgCode" size="8" maxlength="6" title="Organization Code">
				</td></tr>
				<tr><td align="left">Login ID</td><td align="left">
					<input type="text" name="reqLoginID" size="8"  maxlength="25" title="Login ID">
				</td></tr>
				<tr><td align="left">Password</td><td align="left">
					<input type="password" name="reqPwd1" size="8" maxlength="25" title="Password">
				</td></tr>
				<tr><td align="center" colspan="2">
					<input type="submit" value="Coordinator login">
				</td></tr>
			</table>
		</form>
	</td></tr>
	<tr><td width="100%">
		<form name="frmLogin"  method="post" onSubmit="return checkReqEntries(this)" action="AdminAuthorizer.php">
			<table bgcolor="#00CCFF">
				<tr><td align="left" colspan="2"><strong>Organizers Sign In</strong></td></tr>
				<tr><td align="left">Organization code </td><td align="left">
					<input type="text" name="reqOrgCode" size="8" maxlength="6" title="Organization Code">
				</td></tr>
				<tr><td align="left">Festival code </td><td align="left">
					<input type="text" name="reqFestivalCode" size="8" maxlength="6" title="Festival Code">
				</td></tr>
				<tr><td align="left">Login ID</td><td align="left">
					<input type="text" name="reqLoginID" size="8"  maxlength="25" title="Login ID">
				</td></tr>
				<tr><td align="left">Password</td><td align="left">
					<input type="password" name="reqPwd1" size="8" maxlength="25" title="Password">
				</td></tr>
				<tr><td align="center" colspan="2">
					<input type="submit" value="Organizer login">
				</td></tr>
			</table>
		</form>
	</td></tr>
	<tr><td width="100%">
		<form name="frmLogin"  method="post" onSubmit="return checkReqEntries(this)" action="StudioAuthorizer.php">
			<table bgcolor="#6699FF">
				<tr><td align="left" colspan="2"><strong>Studio/Teachers Sign In</strong></td></tr>
				<tr><td align="left">Organization code </td><td align="left">
					<input type="text" name="reqOrgCode" size="8" maxlength="6" title="Organization Code">
				</td></tr>
				<tr><td align="left">Festival code </td><td align="left">
					<input type="text" name="reqFestivalCode" size="8" maxlength="6" title="Festival Code">
				</td></tr>
				<tr><td align="left">Login ID</td><td align="left">
					<input type="text" name="reqLoginID" size="8"  maxlength="25" title="Login ID">
				</td></tr>
				<tr><td align="left">Password</td><td align="left">
					<input type="password" name="reqPwd1" size="8" maxlength="25" title="Password">
				</td></tr>
				<tr><td align="center" colspan="2">
					<input type="submit" value="Studio login">
				</td></tr>
			</table>
		</form>
	</td></tr>
	<tr><td><font size="-2">Copyright <?php print date("Y"); ?> FestivalWare.Net</font>
	</td></tr>
</table>
</font>
</form>
<?php
	} // end else if not authorized
?>

				</td><!-- end NavColumn -->
				<!-- main page area -->
				<td width="100%" bgcolor="#CCCCCC"> 
<!-- main page goes here... -->