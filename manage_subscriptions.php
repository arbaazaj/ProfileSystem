<?php
require './conn.php';
session_start();

if (!isset($_SESSION['ID'])) {
    header("location: admin.php");
}

if(isset($_REQUEST['remSubscriberID'])) {
    $RemSubId = $_REQUEST['remSubscriberID'];
    $q = "Update users set Subscription = 'Dead' where ID = '$RemSubId'";
        if ($conn->query($q)) {
	?>
	<script>alert("User Subscription Removed.");</script>
	<?php
	$location = "http://localhost/ProfileSystem/manage_subscriptions.php";
	echo '<meta http-equiv="refresh" content="0;URL=' . $location . '">';
    }
}

if(isset($_REQUEST['extSubscriberID'])) {
    $ExtSubId = $_REQUEST['extSubscriberID'];
    $q = "Update users set Subscription = 'Extended' where ID = '$ExtSubId'";
        if ($conn->query($q)) {
	?>
	<script>alert("User Subscription Extended.");</script>
	<?php
	$location = "http://localhost/ProfileSystem/manage_subscriptions.php";
	echo '<meta http-equiv="refresh" content="0;URL=' . $location . '">';
    }
}

$FetchUsers = $conn->query("Select * from users");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - Subscriptions</title>
	<link rel="stylesheet" type="text/css" href="admin_css.css" />
    </head>
    <body>
	<div class="admin-container" style="height: fit-content;">
	    <div class="admin-menu">
		<nav>
		    <ul>
			<li><a href="admin_home.php">Home</a></li>
			<li><a href="manage_users.php">Manage Users</a></li>
			<li  class="admin-active"><a href="#">Subscriptions</a></li>
			<li><a href="#">Menu 4</a></li>
		    </ul>
	    </div>
	    <div class="user-details">
		<table>
		    <tr>
			<th>Sr No.</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Username</th>
			<th>Date of Registration</th>
			<th>Subscription</th>
			<th>User Account Status</th>
			<th>Manage User</th>
		    </tr>
		    <?php
		    $sr = 1;
		    while ($r = $FetchUsers->fetch_array(MYSQLI_BOTH)) {
			?>
    		    <tr align="center">
    			<td><?php echo $sr; ?></td>
    			<td><?php echo $r['FirstName']; ?></td>
    			<td><?php echo $r['LastName']; ?></td>
    			<td><?php echo $r['Username']; ?></td>
    			<td><?php echo $r['TIMESTAMP']; ?></td>
			<td><?php echo $r['Subscription']; ?></td>
    			<td><?php echo $r['Status']; ?></td>
			<td>
			    <a href="manage_subscriptions.php?remSubscriberID=<?php echo $r['ID']; ?>" /><input class="admin-login-button" type="button" value="Remove Subscription" /><br />
			    <a href="manage_subscriptions.php?extSubscriberID=<?php echo $r['ID']; ?>" /><input class="admin-login-button" type="button" value="Extend Subscription" />
			</td>
			
    		    </tr>
			<?php
			$sr++;
		    }
		    ?>
		</table>
	    </div>
	</div>
    </body>
</html>
