<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>Change Team</title></head>
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
	$page = "Current team: " . $_SESSION["teamName"] . "<br>";
	$page = $page . "Search for teams: <br><form action='changeTeam.php' method='post'>
		Name: <input type='text' name='teamName'><br>
		Hometown: <input type='text' name='town'><br>
		<input type='submit' name='btnSubmit'></form><br>";
	if (!$_POST["btnSubmit"])
	{
		if (!$_POST["btnJoin"])
		{
			echo $page;
		}
		else
		{
			if ($_POST["teamSel"] == "")
			{
				die("You must select a team.<br>$page");
			}
			$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
			if (mysqli_connect_errno($con))
			{
				die( "Error, could not connect to database.");
			}
			$myQuery = "UPDATE users SET teamID='" . $_POST["teamSel"] . "' WHERE `id`='$uid'";
			$results = mysqli_query($con, $myQuery);
			if (!$results)
			{
				die("ERROR: Could not write to database.");
			}
			$myQuery = "SELECT Name FROM teams WHERE `id`='" . $_POST["teamSel"] . "'";
			$results = mysqli_query($con, $myQuery);
			if (!mysqli_num_rows($results))
			{
				die("Error: Could not read database.");
			}
			$row = mysqli_fetch_assoc($results);
			$teamName = $row["Name"];
			$_SESSION["teamID"] = $_POST["teamSel"];
			$_SESSION["teamName"] = $teamName;
			echo "User $username has joined team $teamName <a href='homepage.php'>Click Here</a> to return to your homepage.";
			mysqli_close($con);
		}
	}
	else
	{
		$page2 = "<br><br>";
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			die( "Error, could not connect to database.");
		}
		$name = $_POST["teamName"];
		$town = $_POST["town"];
		if (strpos($name, "'") || strpos($town, "'"))
		{
			die("Name and hometown cannot contain \"'\" $page");
		}
		$myQuery = "SELECT * FROM teams WHERE `Name` LIKE '%$name%' AND `Hometown` LIKE '%$town%'";
		$result = mysqli_query($con, $myQuery);
		$page2 = $page2 . "Found: " . mysqli_num_rows($result) . " matching teams.<br>";
		$page2 = $page2 . "<b>TEAM NAME || HOMETOWN</b><br>";
		$page2 = $page2 . "<form action='changeTeam.php' method='post'>";
		$page2 = $page2 . "<select name='teamSel' size='8'>";
		while ($row = mysqli_fetch_array($result))
		{
			$page2 = $page2 . "<option value=" . $row["id"] . ">" . $row["Name"] . "  ||  " . $row["Hometown"] . "</option>";
		}
		$page2 = $page2 . "</select><br><input type='submit' name='btnJoin' value='Join'></form><br>";
		$page2 = $page2 . "Don't see a team you like?  <a href='createTeam.php'>Create one!</a><br>";
		echo $page . $page2;
		mysqli_close($con);
	}	
?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
</html>