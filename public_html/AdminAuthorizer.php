<?php
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/
	session_start();	
	$orgCode = addslashes($_POST['reqOrgCode']);
	$festCode = addslashes($_POST['reqFestivalCode']);
	$userID = addslashes($_POST["reqLoginID"]); 
	$password = $_POST["reqPwd1"];

	$salt = substr($userID,0,2);
	$passwd = crypt($password, $salt);

// connect to the main DB, get the Org. database
	$tempconn = mysql_connect ("localhost","festival_mainAll","hy58*dfa") or die(mysql_error()); 
	mysql_select_db("festival_main", $tempconn) or die(mysql_error());

	$sql = "Select * from Organizations WHERE OrganizationID = $orgCode";
	$result = mysql_query($sql, $tempconn) or die(mysql_error());
	if(mysql_num_rows($result) != 1) 
	{
		$_SESSION['LoginMessage'] = "Could not log you in (error 10)... please try again";
		header("Location: http://www.festivalware.net/index.php");
	}
	$organizationRow = mysql_fetch_array($result);
	$database = $organizationRow['DatabaseName'];
	$orgName = $organizationRow['OrganizationName'];

	$selconn = mysql_connect ("localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

// now connect to the organization's database
	// first lookup the organizer's information
	$sql = "select * from Organizers where OrganizerLoginID = '$userID'";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	if(mysql_num_rows($result) != 1)
	{
		$_SESSION['LoginMessage'] = "Could not log you in(error 21)... please try again";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}

// login count is OK, now check password....
	$organizerRow = mysql_fetch_array($result);
	if($organizerRow['OrganizerPassword'] != $passwd)
	{
		$_SESSION['LoginMessage'] = "Could not log you in (error 23)... please try again";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}

// login OK, password OK, now check if user is an authorized organizer of a festival
	$sql = "SELECT * from Festivals WHERE FestivalID=$festCode";
	$result = mysql_query($sql, $selconn) or die(mysql_error());
	if(mysql_num_rows($result) != 1)
	{
		$_SESSION['LoginMessage'] = "Festival doesn't exist... please try again";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}
	// festival exists, now check if user is registered as one of the organizers
	$festRow = mysql_fetch_array($result);
	
	$matches = array(
		'Festival Organizer' => ($organizerRow['OrganizerID'] == $festRow['OrganizerID']),
		'Assistant Organizer' => ($organizerRow['OrganizerID'] == $festRow['AssistantOrganizerID']),
		'Treasurer' => ($organizerRow['OrganizerID'] == $festRow['TreasurerOrganizerID']),
		'Awards Organizer' => ($organizerRow['OrganizerID'] == $festRow['AwardsOrganizerID']),
		'Phone Organizer' => ($organizerRow['OrganizerID'] == $festRow['HospitalityOrganizerID']),
		'Mailings Organizer' => ($organizerRow['OrganizerID'] == $festRow['SchedulingOrganizerID']),
		'Monitor Organizer' => ($organizerRow['OrganizerID'] == $festRow['MonitorOrganizerID']),
		'Facilities Organizer' => ($organizerRow['OrganizerID'] == $festRow['FacilitiesOrganizerID']),
		'Judging Organizer' => ($organizerRow['OrganizerID'] == $festRow['JudgingOrganizerID']),
		'Auditing Organizer' => ($organizerRow['OrganizerID'] == $festRow['AuditingOrganizerID'])
		);
	$authorized = false;
	foreach ($matches as $key => $value) {
		if ($value == true)
			$authorized = true;
	}
	if ($authorized != true)
	{
		$_SESSION['LoginMessage'] = "Could not log you in (error 24)... please try again";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}
	mysql_close($selconn);	

	$_SESSION['AuthorizationType'] = "Admin";
	$_SESSION['AuthenticatedUser'] = $userID;
	$_SESSION['AuthUserIPAddress'] = $_SERVER['REMOTE_ADDR']; 
	$_SESSION['AuthUserName'] = $organizerRow['OrganizerFirstName'] . " " . $organizerRow['OrganizerLastName'];
	$_SESSION['AuthUserEmail'] = $organizerRow['OrganizerEmail'];
	$_SESSION['OrganizationID'] = $orgCode;
	$_SESSION['OrganizationName'] = $orgName;
	$_SESSION['DatabaseName'] = $database;
	$_SESSION['FestivalID'] = $festCode;
	$_SESSION['FestivalName'] = $festRow['FestivalName'];
	$_SESSION['AdminJob'] = $matches; // note, this is an array!
	$_SESSION['OrganizerID'] = $organizerRow['OrganizerID'];
	session_write_close();
	header("Location: http://www.festivalware.net/Administration.php");
 ?>
