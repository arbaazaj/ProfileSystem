<?php
require './conn.php';
session_start();

if(isset($_SESSION['msgUpdated'])) {
    unset($_SESSION['msgUpdated']);
}

if (!isset($_SESSION['ID'])) {
    header("location: login.php");
}

$UserID = $_SESSION['ID'];

if (isset($_SESSION['ID'])) {
    $result = $conn->query("select * from users where ID = '$UserID'");
    $row = $result->fetch_array();

    $Age = $row['Age'];
    $About = $row['About'];
    $ProPic = $row['ProfileExt'];

    $UserRegDate = $row['TIMESTAMP'];
    $MembershipEnds = Date("Y-m-d", strtotime(date("Y-m-d", strtotime($UserRegDate)) . "+ 14 day"));
}
?>
<?php
$id = $_SESSION['ID'];
$fetch = $conn->query("select * from users where ID=$id");
$row = $fetch->fetch_array(MYSQLI_BOTH);

$_SESSION['lockedUsers'] = $row['Status'];
if ($_SESSION['lockedUsers'] == "Locked") {
    header("location: locked.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="script.js"></script>
    </head>
    <body>
	<div class="top-nav" align="center">
	    <nav>
		<ul>
		    <li><a href="index.php">Home</a></li>
		    <li><a href="photos.php">Photos</a></li>
		    <li><a href="account.php">Update Profile</a></li>
		    <li class="active"><a href="about.php">About</a></li>
		</ul>
	    </nav>
	</div>
	<div id="container" style="left: 50.6%;background-image: none;">
	    <h1 id="aboutTitle">About</h1><hr />
	    <?php if (date("Y-m-d") < $MembershipEnds) { ?>
	    <div id="mainSecond" class="memLive"><?php echo 'Membership Details:<br/><hr />Date Of Registration: <br />' . Date("Y-m-d", strtotime(date("Y-m-d", strtotime($UserRegDate)))) . '<br /><hr />' . 'Date Of Expiry: <br />' . $MembershipEnds . '<br /><hr />'; ?>Membership is Live.</div>
	    <?php } else { ?>
	    <div id="mainSecond" class="memExp">Membership is Expired.<?php echo '<br /><hr />' . 'Date Of Expiry: <br />' . $MembershipEnds; ?></div>

	    <?php } ?>
	    <div class="leftContent">
		<header>User Details:
		    <div style="float: right; margin: 0px">
			<img src="images/avatars/<?php echo $ProPic; ?>" width="65px" height="50px;" />
		    </div>
		</header>
		<div class="innerContent">
		    <?php echo 'Name: ' . '<text style="color: black;" />' . $_SESSION['FirstName'] . " " . $_SESSION['LastName']; ?>
		</div>
		<div class="innerContent">
		    <?php echo 'Username: ' . '<text style="color: black;" />' . $_SESSION['Username']; ?>
		</div>
		<div class="innerContent">
		    <?php echo 'Age: ' . '<text style="color: black;" />' . $Age; ?>
		</div>
		<div class="innerContent" style="height: 80px; overflow: auto;">
		    <?php echo 'About: ' . '<text style="color: black;" />' . $About; ?>
		</div>
	    </div>
	    <div class="footer" style="height: 90px;">
		<h3><a href="index.php">Home</a></h3>
	    </div>
	</div>
    </body>
</html>
