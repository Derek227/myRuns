<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>myRuns Home</title></head>
<body>
<?php

if (!isset($_SESSION["username"]))
{
	echo "You must <a href='login.php'>login</a> to view this page.<br>";
}
else
{
	$page = "<table cellpadding=3 cellspacing=3 border=1>
	<tr><td>Username: <a href='user.php'>" . $_SESSION["username"] . "</a> </td><td>Team: <a href='myTeam.php'>" . $_SESSION["teamName"] . "</a></td><td><a href='logout.php' >Logout</a></td></tr>
	<tr><td><a href='homepage.php'>Home</a></td><td><a href='addRun.php'>Add Run</a></td><td><a href='viewRuns.php'>View Runs</a></td></tr>
	</table>";
	$_SESSION["header"] = $page;
	$uid = $_SESSION["uid"];
	echo $page;
	
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

	$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
	if (mysqli_connect_errno($con))
	{
		die( "Error, could not connect to database.");
	}
	$myQuery = "SELECT * FROM runs WHERE `runnerID` = '$uid' AND `date` >= '$week_start'";
	$result = mysqli_query($con, $myQuery);
	$weekDist = 0.0;
	if (mysqli_num_rows($result))
	{
		$weekDist = 0.0;
		while ($row = mysqli_fetch_array($result))
		{
			$weekDist = $weekDist + $row["distance"];
		}
	}
	if (!$_SESSION["unit"])
	{
		$weekDist = round($weekDist / 1.609, 2);
	}
	else
	{
		$weekDist = round($weekDist, 2);
	}
	if (!$_SESSION["teamID"])
	{
		$teamTotalDist = 0;
		$teamAvgDist = 0;
	}
	else
	{
		$teamID = $_SESSION["teamID"];
		$teamMembers = 0;
		mysqli_free_result($result);
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
		$teamAvgDist = round($teamTotalDist / $teamMembers,2);
	}
	echo "<br><h1>Welcome to myRuns!</h1><br> Your distance this week is: " . $weekDist;
	if ($_SESSION["unit"])
	{
		echo " km.<br>";
	}
	else
	{
		echo " mi.<br>";
	}
	echo "Your team's distance this week is: " . $teamTotalDist;
	if ($_SESSION["unit"])
	{
		echo " km.<br>";
	}
	else
	{
		echo " mi.<br>";
	}
	echo "That is " . $teamAvgDist;
	if ($_SESSION["unit"])
	{
		echo " km per person.<br>";
	}
	else
	{
		echo " mi per person.<br>";
	}
	mysqli_close($con);
}
?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
<br><br>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0067623987475115";
/* myRunsBottom */
google_ad_slot = "3619841514";
google_ad_width = 234;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</html>