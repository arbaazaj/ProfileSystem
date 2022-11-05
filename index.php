<?php
require './conn.php';
session_start();

if (isset($_SESSION['msgUpdated'])) {
    unset($_SESSION['msgUpdated']);
}
if (!isset($_SESSION['ID'])) {
    header("location: login.php");
}

$id = $_SESSION['ID'];
$fetch = $conn->query("Select * from users where ID= '$id';");
$row = $fetch->fetch_array();

$_SESSION['lockedUsers'] = $row['Status'];
$_SESSION['Subscription'] = $row['Subscription'];

if ($_SESSION['lockedUsers'] == "Locked") {
    header("location: locked.php");
    $_SESSION['lockerr'] = '<h2 style="color: red;">Your Account has been locked by admin, please contact to gain access again.</h2>';
}

if ($_SESSION['Subscription'] == "Dead") {
    header("location: subexp.php");
    $_SESSION['expire'] = "<h2 style='color: red;'>Your Subscription has been removed by Admin. Contact Admin or buy new Subscription.</h2>";
}

if ($_SESSION['Subscription'] == "Extended") {
    $_SESSION['extended'] = "<h3 style='color: green; margin-top: 0;'>Your subscription has been extended by Admin, have fun ☻</h3>";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Welcome <?php echo $_SESSION['Username']; ?></title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="script.js"></script>
    </head>
    <body>
	<div class="top-nav" align="center">
	    <nav>
		<ul>
		    <li class="active"><a href="index.php">Home</a></li>
		    <li><a href="photos.php">Photos</a></li>
		    <li><a href="account.php">Update Profile</a></li>
		    <li><a href="about.php">About</a></li>
		</ul>
	    </nav>
	</div>
        <div id="container" style="height: 400px; border-radius: 0;">
	    <div id="date" style="background-color: #009688; color: whitesmoke; float: right; margin-right: 0; font-size: 23px; margin-top: -10px;">
		<?php
		date_default_timezone_set("Asia/Kolkata");
		echo 'Date: ' . date("d-M-y") . '<br /> Day:' . date("D");
		?>
	    </div>
	    <br />
	    <h2 style="margin-left: 200px;"><?php echo 'Welcome, ' . $_SESSION['FirstName'] . " " . $_SESSION['LastName']; ?></h2>
	<div class="footer" style="margin-top: 33.4%; height: 120px;">
	    <div id="next">
		<?php
		if (isset($_SESSION['extended'])) {
		    echo $_SESSION['extended'];
		    unset($_SESSION['extended']);
		}
		?>
		<input id="btnLogin" type="submit" onclick="logoutRedirect()" name="logout" value="LogOut" />
	    </div>
	</div>
    </div>
</body>
</html>
