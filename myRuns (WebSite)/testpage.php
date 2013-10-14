<!DOCTYPE html>
<html>
<body>
<?php
	$page = "
		<form action='testpage.php' method='post'>
			To: <input type='text' name='txtTo'><br>
			From: <input type='text' name='txtFrom' value='anon@anon.com'><br>
			Subject: <input type='text' name='txtSub'><br>
			Message: <textarea name='message' col='35' row='15'>Enter message here.</textarea><br>
			Password: <input type='text' name='pw'><br>
			<input type='submit' name='btnSubmit'>
		</form>
	";
	
	if (!$_POST["btnSubmit"])
	{
		echo $page;
	}
	else
	{
		if ($_POST["txtTo"] == "" || $_POST["txtFrom"] == "")
		{
			die("You must enter To and From addresses.<br>$page");
		}
		if ($_POST["pw"] != "derekRocks")
		{
			die("Password is incorrect.<br>$page");
		}
		$from = "From:" . $_POST["txtFrom"];
		$to = $_POST["txtTo"];
		$subject = $_POST["txtSub"];
		$message = $_POST["message"];
		mail($to, $subject, $message, $from);
		echo "Message Sent!<br> $page";
	}
?>
</body>
</html>