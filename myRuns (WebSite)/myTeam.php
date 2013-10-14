<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>My Team Page</title></head>
<body>
<?php
	if (!isset($_SESSION["uid"]))
	{
		die("You must <a href='login.php'>login</a> to see this page.<br>");
	}
	$uid = $_SESSION["uid"];
	$username = $_SESSION["username"];
	$head = $_SESSION["header"] . "<br>";
	echo $head;
	if (!$_SESSION["teamID"])
	{
		die("You are not on a team, <a href='changeTeam.php'>join one</a> for this page to be useful.<br>");
	}
	
	$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
	if (mysqli_connect_errno($con))
	{
		die( "Error, could not connect to database.");
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

	
	$teamID = $_SESSION["teamID"];
	$teamMembers = 0;
	$myQuery = "SELECT id FROM users WHERE `teamID` = '$teamID'";
	$result = mysqli_query($con, $myQuery);
	$teamMembers = mysqli_num_rows($result);
	mysqli_free_result($result);
	$myQuery = "SELECT distance FROM users, runs WHERE `teamID` = '$teamID' AND users.id=runs.runnerID AND runs.date >= '$week_start'";
	$teamTotalDist = 0.0;
	$teamAvgDist = 0.0;
	$result = mysqli_query($con, $myQuery);
	if (mysqli_num_rows)
	{
		while ($row = mysqli_fetch_array($result))
		{
			$teamTotalDist = $teamTotalDist + $row["distance"];
		}
	}
	if (!$_SESSION["unit"])
	{
		$teamTotalDist = round($teamTotalDist / 1.609,2);
	}
	else
	{
		$teamTotalDist = round($teamTotalDist,2);
	}
	$page="
	<h1>Team " . $_SESSION["teamName"] . " homepage</h1><br>
	Current members: $teamMembers <br>
	Weekly distance: $teamTotalDist";
	if ($_SESSION["unit"])
	{
		$page = $page . " km<br>";
	}
	else
	{
		$page = $page . " mi<br>";
	}
	$page = $page . "<a href='teamMembers.php'>View Members</a><br>";
	$page = $page . "<br><br>Want to join a different team? <a href='changeTeam.php'>Click here</a><br>";
	
	echo $page;
	mysqli_close($con);
?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
</html>