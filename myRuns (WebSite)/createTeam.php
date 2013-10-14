<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>Create Team</title></head>
<body>
<?php
	if (!isset($_SESSION["uid"]))
	{
		die("You must <a href='login.php'>login</a> to see this page.<br>");
	}
	$uid = $_SESSION["uid"];
	$username = $_SESSION["username"];
	$head = $_SESSION["header"] . "<br>";
	echo $head . "<br>";
	$page = "
		<form action='createTeam.php' method='post'>
			Team Name: <input type='text' name='tName'><br>
			Hometown: <input type='text' name='town'><br>
			<input type='submit' name='btnSubmit'>
		</form>
	";
	
	if (!$_POST["btnSubmit"])
	{
		echo $page;
	}
	else
	{
		$teamName = $_POST["tName"];
		$town = $_POST["town"];
		if (strpos($teamName, "'") || strpos($town, "'"))
		{
			die("Name and hometown cannot contain \"'\" $page");
		}
		if ($teamName == "" || $town == "")
		{
			die("You must enter a team name and hometown.<br>$page");
		}
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			die( "Error, could not connect to database.");
		}
		$myQuery = "SELECT id FROM teams WHERE `Name` = '$teamName'";
		$results = mysqli_query($con, $myQuery);
		if (mysqli_num_rows($results))
		{
			die("Team name is all ready in use, please choose another.<br>$page");
		}
		mysqli_free_result($results);
		$myQuery = "INSERT INTO teams (Name, Hometown) VALUES ('$teamName', '$town')";
		$results = mysqli_query($con, $myQuery);
		if (!$results)
		{
			die("ERROR: Unable to write to database.");
		}
		$myQuery = "SELECT id FROM teams WHERE `Name`='$teamName'";
		$results = mysqli_query($con, $myQuery);
		if (!mysqli_num_rows($results))
		{
			die("ERROR: Could not read database.");
		}
		$row = mysqli_fetch_assoc($results);
		$teamID = $row["id"];
		$myQuery = "UPDATE users SET teamID='$teamID' WHERE id='$uid'";
		mysqli_free_result($results);
		$results = mysqli_query($con, $myQuery);
		if (!$results)
		{
			die("ERROR: Could not write to database.");
		}
		echo "Team $teamName created.  User $userName added as first member.<br>";
		$_SESSION["teamID"] = $teamID;
		$_SESSION["teamName"] = $teamName;
	}
?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
</html>