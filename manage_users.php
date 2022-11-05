<?php
require './conn.php';
session_start();

if (!isset($_SESSION['ID'])) {
    header("location: admin.php");
}
?>
<?php
if (isset($_REQUEST['lock'])) {
    $LockUser = $_REQUEST['lock'];
    $query = "Update users set Status = 'Locked' where ID = $LockUser";
    if ($conn->query($query)) {
	?>
	<script>alert("User Locked");</script>
	<?php
	$location = "http://localhost/ProfileSystem/manage_users.php";
	echo '<meta http-equiv="refresh" content="0;URL=' . $location . '">';
    }
}
if (isset($_REQUEST['unlock'])) {
    $UnLockUser = $_REQUEST['unlock'];
    $unlockquery = "Update users set Status = 'Active' where ID = $UnLockUser;";
    if ($conn->query($unlockquery)) {
	?>
	<script>alert("User Unlocked");</script>
	<?php
	$location = "http://localhost/ProfileSystem/manage_users.php";
	echo '<meta http-equiv="refresh" content="0;URL=' . $location . '">';
	exit;
    }
}

$FetchUsers = $conn->query("Select * from users");
?>
<?php
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $q = "Delete from users where ID=$id";
    if ($conn->query($q)) {
	?>
	<script>
	    alert("User Successfully Removed.");
	</script>
	<?php
	$location = "http://localhost/ProfileSystem/manage_users.php";
	echo '<meta http-equiv="refresh" content="0;URL=' . $location . '">';
	exit;
    }
}
$FetchUsers = $conn->query("Select * from users");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - Manage Users</title>
	<link rel="stylesheet" type="text/css" href="admin_css.css" />
    </head>
    <body>
	<div class="admin-container" style="height: fit-content;">
	    <div class="admin-menu">
		<nav>
		    <ul>
			<li><a href="admin_home.php">Home</a></li>
			<li class="admin-active"><a href="manage_users.php">Manage Users</a></li>
			<li><a href="manage_subscriptions.php">Subscriptions</a></li>
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
			<th>Password</th>
			<th>Profile Pic</th>
			<th>Age</th>
			<th>About</th>
			<th>Date of Registration</th>
			<th>Manage User</th>
			<th>User Account Status</th>
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
    			<td><?php echo $r['Password']; ?></td>
    			<td><img style="border-style: outset; border-width: 2.5px; width: 80px; height: 80px; position: relative; margin: 2px;" src="images/avatars/<?php echo $r['ProfileExt']; ?>"></td>
    			<td><?php echo $r['Age']; ?></td>
    			<td><?php echo $r['About']; ?></td>
    			<td><?php echo $r['TIMESTAMP']; ?></td>
    			<td>
    			    <a href="manage_users.php?id=<?php echo $r['ID']; ?>" /><input style="position: relative;" class="admin-login-button" type="button" value="Delete" /><br />
    			    <a href="manage_users.php?lock=<?php echo $r['ID']; ?>" /><input style="position: relative;" class="admin-login-button" type="button" value="Lock" /><br />
    			    <a href="manage_users.php?unlock=<?php echo $r['ID']; ?>" /><input style="position: relative;" class="admin-login-button" type="button" value="UnLock" />
    			</td>
    			<td><?php echo $r['Status']; ?></td>
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
