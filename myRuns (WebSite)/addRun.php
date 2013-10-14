<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>Add Run</title></head>
<body>
<?php
if (!isset($_SESSION["uid"]))
{
	die("You must <a href='login.php'>Login</a> to view this page.<br>");
}
else
{
	$uid = $_SESSION["uid"];
	$head = $_SESSION["header"] . "<br>";
	$date = getDate();
	$form = "
		<form action='addRun.php' method='post'>
			Run distance: <input type='text' name='dist'><select name='unit'><option value='1.609'> mi </option><option value='1'> km </option></select><br>
			Run time : <input type='text' name='time'><br>
			Run date : 
				<select name='rMon'>
		<option value='01'>JAN</option>
		<option value='02'>FEB</option>
		<option value='03'>MAR</option>
		<option value='04'>APR</option>
		<option value='05'>MAY</option>
		<option value='06'>JUN</option>
		<option value='07'>JUL</option>
		<option value='08'>AUG</option>
		<option value='09'>SEP</option>
		<option value='10'>OCT</option>
		<option value='11'>NOV</option>
		<option value='12'>DEC</option>
	</select>
	<select name='rDay'>
		<option value='01'>1</option>
		<option value='02'>2</option>
		<option value='03'>3</option>
		<option value='04'>4</option>
		<option value='05'>5</option>
		<option value='06'>6</option>
		<option value='07'>7</option>
		<option value='08'>8</option>
		<option value='09'>9</option>
		<option value='10'>10</option>
		<option value='11'>11</option>
		<option value='12'>12</option>
		<option value='13'>13</option>
		<option value='14'>14</option>
		<option value='15'>15</option>
		<option value='16'>16</option>
		<option value='17'>17</option>
		<option value='18'>18</option>
		<option value='19'>19</option>
		<option value='20'>20</option>
		<option value='21'>21</option>
		<option value='22'>22</option>
		<option value='23'>23</option>
		<option value='24'>24</option>
		<option value='25'>25</option>
		<option value='26'>26</option>
		<option value='27'>27</option>
		<option value='28'>28</option>
		<option value='29'>29</option>
		<option value='30'>30</option>
		<option value='31'>31</option>
	</select>
	<select name='rYear'>";
	for ($i=2013; $i>=2000; $i--)
	{
		$form = $form . "<option value='" . $i . "'>" . $i . "</option>";
	}
	$form = $form . "</select>";
	
	$form = $form . "<br>
	<input type='submit' name='btnSubmit'>
		</form>
	";
	
	
	if (!$_POST["btnSubmit"])
	{
		echo $head;
		echo $form;
	}
	else
	{
		try
		{
			$distance = floatval($_POST["dist"]);
			$distance = $distance * floatval($_POST["unit"]);
			if (!$distance)
			{
				die("$head Error: Unable to read distance, please try again.<br>$form");
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
				die("$head Error: Unable to read time, please try again.<br>$form");
			}
			$date = $_POST["rYear"] . $_POST["rMon"] . $_POST["rDay"];

		} catch (Exception $e) {
			die( "$head Error: " . $e->getMessage() . "<br>Please retry.<br>$form");
		}
		$myQuery = "INSERT INTO runs (runnerID, distance, time, date) VALUES ('$uid', '$distance', '$time', '$date')";
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			die( "$head Error, could not connect to database.");
		}
		$result = mysqli_query($con, $myQuery);
		if (!$result)
		{
			die("$head Error: " . mysqli_error() . "<br><a href='addRun.php'>Click here</a> to try again.<BR>");
		}
		echo "$head Run successfully added.<br>";
		mysqli_close($con);
	}
}
?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
</html>