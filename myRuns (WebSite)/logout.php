<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head><title>Logout page</title></head>
<body>
<?php
session_destroy();
?>
You have been logged out.<br>
<a href='login.php'> Click here </a> to log back in!
</body>
</html>