<!DOCTYPE html>
<html>
<body>
<?php	
		if (!$_POST["fromAndroid"])
		{
			die("This page is for use with android only.<br>Please login via <a href='login.php'> this page </a> for web access.<br>");
		}
		$username = $_POST["un"];
		$password = $_POST["pw"];
		$con = mysqli_connect("mysql15.000webhost.com", "a4069015_derek22", "Dolphins0", "a4069015_users");
		if (mysqli_connect_errno($con))
		{
			echo "<error>1</error>";	// Could not connect to database
		}
		else
		{
			$result = mysqli_query($con, "SELECT * FROM users WHERE `password` = '$password' AND `userName` = '$username'");
			$numrows = mysqli_num_rows($result);
			if ($numrows == 0)
			{
				echo "<error>2</error>";	// Username or password incorrect
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
					echo "<error>0</error><uid>$uid</uid><unit>$unit</unit><teamID>$teamID</teamID><teamName>$teamName</teamName>";
				}
				else
				{
					echo "<error>3</error>";	// General error
				}
			}
			mysqli_close($con);
		}
?>
</body>
</html>