<?php
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/
	session_start();
	$orgCode = addslashes($_POST['reqOrgCode']);
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
		session_write_close();
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}
	$organizationRow = mysql_fetch_array($result);
	$database = $organizationRow['DatabaseName'];
	
//	now connect to the organization's database
	$selconn = mysql_connect ("localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	$sql = "select * FROM Organizers WHERE OrganizerLoginID = '$userID'";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	if( mysql_num_rows($result) != 1 ) // not in DB?
	{
		$_SESSION['LoginMessage'] = "Could not log you in (error 11)... please try again";
		session_write_close();
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}
	else	// user found
	{
		$row = mysql_fetch_array($result);
	// if user is not this organization's coordinator, stop now
		if ($organizationRow['CoordinatorID'] != $row['OrganizerID'])
		{
			$_SESSION['LoginMessage'] = "You are not registered as the coordinator for this organization... please try again";
			session_write_close();
			header("Location: http://www.festivalware.net/index.php");
			exit();
		}

		// passwords match?
		if ($row['OrganizerPassword'] != $passwd)
		{
			$_SESSION['LoginMessage'] = "Could not log you in (error 12)... please try again";
			session_write_close();
			header("Location: http://www.festivalware.net/index.php");
			exit();
		}
		$_SESSION['AuthorizationType'] = "Coordinator";
		$_SESSION['AuthenticatedUser'] = $userID;
		$_SESSION['AuthUserIPAddress'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['AuthUserName'] = $row['OrganizerFirstName'] . " " . $row['OrganizerLastName'];
		$_SESSION['OrganizationID'] = $orgCode;
		$_SESSION['DatabaseName'] = $database;
		$_SESSION['OrganizationName'] = $organizationRow['OrganizationName'];
		$_SESSION['AuthUserEmail'] = $row['OrganizerEmail'];
		session_write_close();
		header("Location: http://www.festivalware.net/CoordinatorSelector.php");
		exit();
	}
	mysql_close($selconn);	

 ?>
