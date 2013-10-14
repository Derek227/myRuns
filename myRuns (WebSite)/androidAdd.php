<!DOCTYPE html>
<html>
<head><title>Add Run ANDROID</title></head>
<body>
<?php
if (!$_POST["fromAndroid"])
{
	die("Error: This page is for android use only.");
}
else
{
	$uid = $_POST["uid"];
	$date = getDate();
		try
		{
			$distance = floatval($_POST["dist"]);
			$distance = $distance * floatval($_POST["unit"]);
			if (!$distance)
			{
				die("<error>1</error>"); // Could not read distance
			}
			if (strlen($_POST["time"]) > 5)
			{
				list ($hr, $min, $sec) = explode(":", $_POST["time"]);
			}
			else
			{
				$hr = 0;
				list ($min, $sec) = explode(":", $_POST["time"]);	
			}	
			$time = intval($hr) * 3600 + intval($min) * 60 + intval($sec);
			if (!$time)
			{
				die("<error>2</error>");	// Unable to read time
			}
			$date = $_POST["rYear"] . $_POST["rMon"] . $_POST["rDay"];

		} catch (Exception $e) {
			die( "<error>5</error>");
		}
		$myQuery = "INSERT INTO runs (runnerID, distance, time, date) VALUES ('$uid', '$distance', '$time', '$date')";
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			die( "<error>3</error>");	// Could not connect to database
		}
		$result = mysqli_query($con, $myQuery);
		if (!$result)
		{
			die("<error>4</error>");	// SQL Error
		}
		echo "<error>0</error>";
		mysqli_close($con);
}
?>
</body> 
</html>