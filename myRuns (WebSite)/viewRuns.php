<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>View Runs</title></head>
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
	
	$page="
	<h1>$username run list</h1><br>
	<form action='viewRuns.php' method='post'>
		<table cellpadding=1 cellspacing=1>
		<tr>
		<td>Date Range:</td> <td><input type='radio' name='tRange' value='all'>All Time</td>
					<td><input type='radio' name='tRange' value='thisWeek'>This Week</td>
					<td><input type='radio' name='tRange' value='lastWeek'>Last Week</td>
					<td><input type='radio' name='tRange' value='thisMonth'>This Month</td>
					<td><input type='radio' name='tRange' value='lastMonth'>Last Month</td>
					<td><input type='submit' name='btnSubmit'></td>
		</tr>
		</table>
	</form>
	<table cellpadding=2 cellspaceing=2 border=1>
		<tr><td><b>DATE</b></td><td><b>DISTANCE</b></td><td><b>TIME</b></td><td><b>PACE</b></td></tr>";
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			die( "<br>Error, could not connect to database.</table>");
		}
		$totalSec = 0;
		$totalDistance = 0;
		if ($_GET["d"] != NULL)
		{
			echo "Id = " . $_GET["d"] . "<br>";
			$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid AND `id` = " . $_GET["d"];
			$result = mysqli_query($con, $myQuery);
			$rows = mysqli_num_rows($result);
			if ($rows > 0)
			{
				$myQuery = "DELETE FROM runs WHERE `runnerID` = $uid AND `id` = " . $_GET["d"];
				$result = mysqli_query($con, $myQuery);
				if (!$result)
				{
					echo "Error: Could not delete run.<br>";
				}
				else
				{
					echo "Run deleted.<br>";
				}
			}
			else
			{
				echo "Error: Cannot delete run.  You are not the owner of this run. <br>";
			}
		}
		if (!$_POST["btnSubmit"])
		{
			$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid ORDER BY `date` ASC";
		}
		else
		{
			$selectedRange=$_POST["tRange"];
			if ($selectedRange == "all")
			{
				$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid ORDER BY `date` ASC";
			}
			else if ($selectedRange == "thisWeek")
			{
				$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid AND runs.date >= '$week_start' ORDER BY `date` ASC";
			}
			else if ($selectedRange == "lastWeek")
			{
				$week_end = $week_start;
				$week_start = date("Ymd", strtotime($week_end . " -7 days"));
				$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid AND runs.date >= '$week_start' AND runs.date < '$week_end' ORDER BY `date` ASC";
			}
			else if ($selectedRange == "thisMonth")
			{
				$month_start = date("Ym01", time());
				$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid AND runs.date >= '$month_start' ORDER BY `date` ASC";
			}
			else if ($selectedRange == "lastMonth")
			{
				$month_end = date("Ym01", time());
				$month_start = date("Ym01", strtotime($month_end . " - 1 month"));
				$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid AND runs.date >= '$month_start' AND runs.date < '$month_end' ORDER BY `date` ASC";
			}
			else
			{
				$myQuery = "SELECT * FROM runs WHERE `runnerID` = $uid ORDER BY `date` ASC";
			}
		}
		$result = mysqli_query($con, $myQuery);
		while ($row = mysqli_fetch_array($result))
		{
			$date = $row["date"];
			$distance = $row["distance"];
			$rid = $row["id"];
			if (!$_SESSION["unit"])
			{
				$distance = round($distance / 1.609, 2);
			}
			else
			{
				$distance = round($distance, 2);
			}
			$totalDistance = $totalDistance + $distance;
			$timeSec = $row["time"];
			$totalSec = $totalSec + $timeSec;
			$paceSec = round($timeSec / $distance);
			$hr = ($timeSec - ($timeSec % 3600)) / 3600;
			$timeSec = $timeSec - (3600 * $hr);
			$min = ($timeSec - ($timeSec % 60)) / 60;
			$sec = $timeSec % 60;
			$time = "";
			if ($hr)
			{
				$time = $hr . ":";
			}  
			if ($min < 10)
			{
				$time = $time . "0";
			}
			$time = $time . $min . ":";
			if ($sec < 10)
			{
				$time = $time . "0";
			}
			$time = $time . $sec;

			
			$hr = ($paceSec - ($paceSec % 3600)) / 3600;
			$paceSec = $paceSec - (3600 * $hr);
			$min = ($paceSec - ($paceSec % 60)) / 60;
			$sec = $paceSec % 60;
			$pace = "";
			if ($hr)
			{
				$pace = $hr . ":";
			}  
			if ($min < 10)
			{
				$pace = $pace . "0";
			}
			$pace = $pace . $min . ":";
			if ($sec < 10)
			{
				$pace = $pace . "0";
			}
			$pace = $pace . $sec;
			
			//$page = $page . "<tr><td>" . $date . "</td><td>" . $distance . "</td><td>" . $time . "</td><td>" . $pace . "</td></tr>";
			$page = $page . "<tr><td>" . $date . "</td><td>" . $distance . "</td><td>" . $time . "</td><td>" . $pace . "</td><td><a href='viewRuns.php?d=" . $rid . "'>Delete</a></td></tr>";
		}
		if ($totalDistance != 0)
		{
			$paceSec = round($totalSec / $totalDistance);
			$hr = ($totalSec - ($totalSec % 3600)) / 3600;
			$totalSec = $totalSec - (3600 * $hr);
			$min = ($totalSec - ($totalSec % 60)) / 60;
			$sec = $totalSec % 60;
			$time = "";
			if ($hr)
			{
				$time = $hr . ":";
			}  
			if ($min < 10)
			{
				$time = $time . "0";
			}
			$time = $time . $min . ":";
			if ($sec < 10)
			{
				$time = $time . "0";
			}
			$time = $time . $sec;
		
			$hr = ($paceSec - ($paceSec % 3600)) / 3600;
			$paceSec = $paceSec - (3600 * $hr);
			$min = ($paceSec - ($paceSec % 60)) / 60;
			$sec = $paceSec % 60;
			$pace = "";
			if ($hr)
			{
				$pace = $hr . ":";
			}  
			if ($min < 10)
			{
				$pace = $pace . "0";
			}
			$pace = $pace . $min . ":";
			if ($sec < 10)
			{
				$pace = $pace . "0";
			}
			$pace = $pace . $sec;
		}
		else
		{
			$pace = "00:00";
		}
		$page = $page . "<tr><td><b> TOTAL </b></td><td>" . $totalDistance . "</td><td>" . $time . "</td><td>" . $pace . "</td></tr>";
		
	$page = $page . "</table>";
	echo $page;
	mysqli_close($con);
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