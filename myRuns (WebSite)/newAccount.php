<!DOCTYPE html>
<?php if (session_id == '') session_start(); ?>
<html>
<head><title>New Account</title></head>
<body>
<?php

$form = "<form action='newAccount.php' method='post'>
Desired Username: <input type='text' name='dUName'><br>
Password: <input type='password' name='pw1'><br>
Repeat Password: <input type='password' name='pw2'><br>
Birthday: 
	<select name='bMon'>
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
	<select name='bDay'>
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
	<select name='bYear'>";
	for ($i=2013; $i>=1900; $i--)
	{
		$form = $form . "<option value='" . $i . "'>" . $i . "</option>";
	}
	$form = $form . "</select>";
	
$form = $form . "<br>
First Name: <input type='text' name='fName'><br>
Last Name: <input type='text' name='lName'><br>
Prefered unit: <select name='unit'>
					<option value='0'>mi</option>
					<option value='1'>km</option>
				</select><br>
<input type='submit' name='btnSubmit'>
</form>";


if (!$_POST["btnSubmit"])
{
	echo "$form";
}
else
{
	if ($_POST["dUName"] == "")
	{
		echo "Username is required!<br><br>$form";
	}
	else
	{
		$username = $_POST["dUName"];
		if (strpos($username, "'"))
		{
			die("Username cannot contain \"'\" $form");
		}
		if ($_POST["pw1"] != $_POST["pw2"])
		{
			echo "Passwords must match!<br><br>$form";
		}
		else
		{
			$pw = $_POST["pw1"];
			$username = $_POST["dUName"];
			if (strpos($pw, "'"))
			{
				die("Password cannot contain \"'\" $form");
			}		
			if ($_POST["fName"] == "" || $_POST["lName"] == "")
			{
				echo "Must enter a name. <br><br>$form";
			}
			else
			{
				echo "All is well<br>";
				$firstName = $_POST["fName"];
				$lastName = $_POST["lName"];
				$username = $_POST["dUName"];
				if (strpos($lastName, "'") || strpos($firstName, "'"))
				{
					die("Name cannot contain \"'\" $form");
				}
				$bday = $_POST["bYear"] . $_POST["bMon"] . $_POST["bDay"];
				$unit = intval($_POST["unit"]);
				$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
				if (mysqli_connect_errno($con))
				{
					die( "Error, could not connect to database.");
				}
				$result = mysqli_query($con, "INSERT INTO users (userName, password, birthday, firstName, lastName, unit) VALUES ('$username', '$pw', '$bday', '$firstName', '$lastName', '$unit')");
				if ($result == TRUE)
				{
					echo "User <b>$username</b> was successfully created!<br>";
					echo "<a href = 'login.php' >Click here</a> to login.<br>";
				}
				else
				{
					echo "Error: Could not write to database.";
				}
				mysqli_close($con);
			}
		}
	}
}

 ?>
</body>
<br><br><br>
<!-- START OF HIT COUNTER CODE -->
<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=11"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/11/left.png" alt="Free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Web hosting" src="http://www.counter160.com/images/11/right.png" border="0" align="texttop"></a>
<!-- END OF HIT COUNTER CODE -->
</html>