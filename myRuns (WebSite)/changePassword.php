<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>Change Password</title></head>
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
	
	$page = "<h1> Change password for $username </h1><br>
		<form action='changePassword.php' method='post'>
			Old Password: <input type='password' name='oldPW'><br>
			New Password: <input type='password' name='newPW1'><br>
			New Password (again): <input type='password' name='newPW2'><br>
			<input type='submit' name='btnSubmit'>
		</form>
	";
	
	if (!$_POST["btnSubmit"])
	{
		echo $page;
	}
	else
	{
		$oldPW = $_POST["oldPW"];
		$newPW1 = $_POST["newPW1"];
		$newPW2 = $_POST["newPW2"];
		if (strpos($oldPW, "'") || strpos($newPW1, "'") || strpos($newPW2, "'"))
		{
			die("Passwords cannot contain \"'\" $page");
		}
		if (!($newPW1 == $newPW2))
		{
			die("New passwords must match!<br>$page");
		}
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			die( "<br>Error, could not connect to database.</table>");
		}
		$myQuery = "SELECT id FROM users WHERE `id`='$uid' AND `password`='$oldPW'";
		$results = mysqli_query($con, $myQuery);
		if (!mysqli_num_rows($results))
		{
			die("Old Password is incorrect.<br>$page");
		}
		mysqli_free_result($results);
		$myQuery = "UPDATE users SET password='$newPW1' WHERE `id`='$uid'";
		$results = mysqli_query($con, $myQuery);
		if (!$results)
		{
			die("ERROR: Could not write to database.");
		}
		echo "Password successfully changed.<br>"; 
	}
?>
</body>
</html>