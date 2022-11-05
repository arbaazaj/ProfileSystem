<?php
require './conn.php';
session_start();
if (!isset($_SESSION['ID'])) {
    header("location: login.php");
}

if (isset($_POST['btnBack'])) {
    unset($_SESSION['ID']);
    session_destroy();
    header("location: login.php");
}

if (isset($_POST['btnBuy'])) {
    header("location: buysubscription.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Subscription Removed</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="admin_css.css" />
	<script src="jquery-3.1.0.min.js"></script>
	<script src="script.js"></script>
	<script>
	    function redirect() {
		window.location = "buysubscription.php";
	    }
	</script>
    </head>
    <body>
	<?php
	if (isset($_SESSION['expire'])) {
	    echo $_SESSION['expire'];
	}
	?>
	<form action="" method="post">
	    <input id="btnLogin" type="submit" name="btnBack" value="Return" />
	    <input id="btnLogin" type="submit" onclick="redirect()" name="btnBuy" value="Buy Now" />
	</form>
    </body>
</html>
