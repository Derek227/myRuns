<!DOCTYPE html>
<html>
<head> <title> Welcome to myRuns.freeiz.com! </title> </head>
<body>
<h1> Welcome to myRuns! </h1>
<h4> by Derek Loftis </h4>
<br><a href='login.php'>Click Here</a> to login.<br>
If you find an error or want to make a suggestion, please email me at <a href='mailto:admin@myruns.freeiz.com'>admin@myruns.freeiz.com</a><br>
<?php
	$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (!mysqli_connect_errno($con))
		{
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
			$myQuery = "SELECT COUNT(id) FROM users";
			$results = mysqli_query($con, $myQuery);
			$row = mysqli_fetch_assoc($results);
			echo "<br><br>We have " . $row["COUNT(id)"] . " users ";
			mysqli_free_result($results);
			$myQuery = "SELECT SUM(distance) FROM runs WHERE `date` >= '$week_start' UNION SELECT SUM(distance) FROM runs";
			$results = mysqli_query($con, $myQuery);
			if (mysqli_num_rows($results))
			{
				$row = mysqli_fetch_array($results);
				echo "who have run " . round($row["SUM(distance)"] / 1.609,1) . " miles this week ";
				$row = mysqli_fetch_array($results);
				echo "and " . round($row["SUM(distance)"] / 1.609,1) . " miles in total.<br>";
			}			
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