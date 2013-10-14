<!DOCTYPE html>
<?php
if (session_id() == '') 
{	
	session_start();
}
 ?>
<html>
<head><title>Login Page</title></head>
<body>
<?php
	$form=
	"
	<form action='login.php' method='post'>
		Username: <input type='text' name='uName'><br>
		Password: <input type='password' name='pWord'><br>
		<input type='submit' name='btnSubmit'>
	</form>
	<br>Don't have an account yet?  <a href='newAccount.php'> Click here</a> to make one!<br>
	";
	
	if (!$_POST["btnSubmit"])
	{
		echo "$form";
	}
	else
	{
		$username = $_POST["uName"];
		$password = $_POST["pWord"];
		if (strpos($username, "'") || strpos($password, "'"))
		{
			die("\"'\" is not allowed in username or password fields.");
		}
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			echo "Error, could not connect to database.";
		}
		else
		{
			$result = mysqli_query($con, "SELECT * FROM users WHERE `password` = '$password' AND `userName` = '$username'");
			$numrows = mysqli_num_rows($result);
			if ($numrows == 0)
			{
				echo "Username or password is incorrect.<br> $form";
			}
			else
			{
				$row = mysqli_fetch_assoc($result);
				$uid = $row['id'];
				$unit = $row["unit"];
				$teamID = $row["teamID"];
				mysqli_free_result($result);
				$result = mysqli_query($con, "SELECT * FROM teams WHERE `id` = '$teamID'");
				if (mysqli_num_rows($result))
				{
					$row = mysqli_fetch_assoc($result);
					$teamName = $row["Name"];
				}
				else
				{
					$teamName = "ERROR";
				}
				if ($uid > 0)
				{
					echo "User: <b>$username </b> was successfully logged in! <a href='homepage.php'>Click here</a> to go to the member homepage.";
					$_SESSION["username"] = $username;
					$_SESSION["uid"] = $uid;	
					$_SESSION["unit"] = $unit;	
					$_SESSION["teamID"] = $teamID;
					$_SESSION["teamName"] = $teamName;
				}
				else
				{
					echo "Error reading the database, please try again.<br> $form";
				}
			}
			mysqli_close($con);
		}
	}
?>
</body>
</html>