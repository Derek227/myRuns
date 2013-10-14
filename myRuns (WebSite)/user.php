<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>User Page</title></head>
<body>
<?php
	if (!isset($_SESSION["uid"]))
	{
		die("You must <a href='login.php'>login</a> to see this page.<br>");
	}
	$uid = $_SESSION["uid"];
	$username = $_SESSION["username"];
	$teamName = $_SESSION["teamName"];
	$teamID = $_SESSION["teamID"];
	$head = $_SESSION["header"] . "<br>";
	echo $head . "<br>";
	
	echo "<h1> $username profile page </h1><br>
		Team: $teamName <br>
		<a href='changeTeam.php'>Change Team</a><br>
		<a href='changePassword.php'>Change Password</a><br>
	";
?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
</html>