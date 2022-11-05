<?php
require './conn.php';
session_start();
if (!isset($_SESSION['ID']) || !isset($_SESSION['lockerr'])) {
    header("location: login.php");
}
?>
<?php
if (isset($_POST['btnBack'])) {
    unset($_SESSION['ID']);
    session_destroy();
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Oops! Locked</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
	<?php
	if (isset($_SESSION['lockerr'])) {
	    echo $_SESSION['lockerr'];
	}
	?>
	<form action="#" method="post">
	    <input id="btnLogin" type="submit" name="btnBack" value="Return" />
	</form>
    </body>
</html>
