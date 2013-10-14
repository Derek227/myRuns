<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>Team Members</title></head>
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
	
	$page = "<h1>Team members for team $teamName</h1><br>";
	$page = $page . "<table cellspacing=2 cellpadding=2 border=1>
		<tr><td><b>NAME</b></td><td><b>TOTAL DISTANCE</b></td></tr>";
	
	$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
	if (mysqli_connect_errno($con))
	{
		die( "<br>Error, could not connect to database.</table>");
	}
	$m = time();  
	$today =   date('l', $m);  
	$custom_date = strtotime( date('d-m-Y', $m) );   
	if ($today == 'Sunday') 
	{  
   		$week_start = date("Ymd", $m);  
	} 
	else 
	{  
  		$week_start = date('Ymd', strtotime('this week last sunday', $custom_date));  
	} 
	$myQuery = "SELECT users.userName, SUM(runs.distance) FROM users, runs WHERE users.id=runs.runnerID AND users.teamID='$teamID' GROUP BY users.userName ORDER BY SUM(runs.distance) DESC";
	$results = mysqli_query($con, $myQuery);
	if (!mysqli_num_rows($results))
	{
		die("ERROR: Could not read database.");
	}
	while ($row = mysqli_fetch_array($results))
	{
		$distance = $row["SUM(runs.distance)"];
		if (!$_SESSION["unit"])
		{
			$distance = $distance / 1.609;
		}
		$distance = round($distance,2);
		$page = $page . "<tr><td>" . $row["userName"] . "</td><td> $distance </td></tr>";
	}	
	$page = $page . "</table><br>";
	echo $page;	
?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
</html>