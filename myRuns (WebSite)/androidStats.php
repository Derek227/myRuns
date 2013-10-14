<!DOCTYPE html>
<html>
<body>
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
			echo "<count>" . $row["COUNT(id)"] . "</count>";
			mysqli_free_result($results);
			$myQuery = "SELECT SUM(distance) FROM runs WHERE `date` >= '$week_start' UNION SELECT SUM(distance) FROM runs";
			$results = mysqli_query($con, $myQuery);
			if (mysqli_num_rows($results))
			{
				$row = mysqli_fetch_array($results);
				echo "<weekly>" . round($row["SUM(distance)"] / 1.609,1) . "</weekly>";
				$row = mysqli_fetch_array($results);
				echo "<total>" . round($row["SUM(distance)"] / 1.609,1) . "</total>";
			}			
		}
?>
</body>
</html>