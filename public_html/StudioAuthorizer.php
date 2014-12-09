<?php
/* 
	This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/	
	session_start();	
	
	$orgCode = addslashes($_POST['reqOrgCode']);
	$festCode = addslashes($_POST['reqFestivalCode']);
	$userID = addslashes($_POST['reqLoginID']); 
	$password = $_POST['reqPwd1'];

	$salt = substr($userID,0,2);
	$Passwd = crypt($password, $salt);

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
	
// now connect to the organization's database
	$selconn = mysql_connect ("localhost","festival_chooser","pan!h+4") or die(mysql_error()); 
	mysql_select_db($database, $selconn) or die(mysql_error());

	// find the festival the user chose
	$sql = "SELECT * from Festivals WHERE FestivalID=$festCode";
	$result = mysql_query($sql, $selconn) or die(mysql_error());
	if(mysql_num_rows($result) != 1)
	{
		$_SESSION['LoginMessage'] = "Festival doesn't exist... please try again";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}
	$festivalRow = mysql_fetch_array($result);

	$sql = "select Password, StudioName, StudioID, StudioEmail, IsLegit from Studios where LoginID  = '$userID'";
	$result = mysql_query ($sql, $selconn) or die(mysql_error());
	if(mysql_num_rows($result) != 1)
	{
		$_SESSION['LoginMessage'] = "Could not log you in (error 2)... please try again";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}

	$studioRow = mysql_fetch_array($result);
	if($studioRow['IsLegit'] == 'N')
	{
		$_SESSION['LoginMessage']  = "Could not log you in (error 4). Please contact the festival coordinator to fix this issue.";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}
	
	if($studioRow['Password'] != $Passwd)
	{
		$_SESSION['LoginMessage'] = "Could not log you in (error 5)... please try again";
		header("Location: http://www.festivalware.net/index.php");
		exit();
	}
	$_SESSION['AuthorizationType'] = "Studio";
	$_SESSION['AuthenticatedUser'] = $userID;
	$_SESSION['AuthUserIPAddress'] = $_SERVER['REMOTE_ADDR']; 
	$_SESSION['AuthUserName'] = $studioRow['StudioName'];
	$_SESSION['AuthUserEmail'] = $studioRow['StudioEmail'];
	$_SESSION['OrganizationID'] = $orgCode;
	$_SESSION['OrganizationName'] = $organizationRow['OrganizationName'];
	$_SESSION['DatabaseName'] = $database;
	$_SESSION['FestivalID'] = $festCode;
	$_SESSION['FestivalName'] = $festivalRow['FestivalName'];
	$_SESSION['StudioID'] = $studioRow['StudioID'];

	header("Location: http://www.festivalware.net/StudioAdmin.php");

	mysql_close($selconn);	

 ?>
