<?php
require './conn.php';
session_start();

if (!isset($_SESSION['ID'])) {
    header("location: admin.php");
}

$sql = $conn->query("select count(1) from users");
$count = $sql->fetch_array();

$total = $count[0];
if ($total <= 0) {
    $_SESSION['err'] = '<h1 style="text-shadow: 2.5px 3.5px 4.5px #006666; color: darkred;" />No Users Found';
}

if (isset($_POST['AddUser'])) {

    if (isset($_FILES['FileSelect'])) {

	$filename = $_FILES['FileSelect']['name'];
	$temp_filename = $_FILES['FileSelect']['tmp_name'];
	$filename = preg_replace("#[^a-z0-9.]#i", "", $filename);

	$_SESSION['myfile'] = $filename;
	if (!$temp_filename) {
	    die("No File Selected");
	} else {
	    move_uploaded_file($temp_filename, "images/avatars/$filename");
	}
    }

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $age = $_POST['age'];
    $profilePic = $_SESSION['myfile'];
    $about = $_POST['about'];
    $EncryptedPass = password_hash($pass, PASSWORD_BCRYPT, array('cost' => 10));

    $stmt = $conn->query("Insert into users(FirstName, LastName, Username, Password, ProfileExt, About, Age) values('{$fname}', '{$lname}', '{$uname}', '{$EncryptedPass}', '{$profilePic}', '{$about}', '{$age}');");

    if ($stmt == true) {
	$_SESSION['msgSuccess'] = '<h2 style="color: green; font-weight: lighter;">User Added Successfully</h2>';
    } else {
	$_SESSION['msgFailed'] = '<h2 style="color: red; font-weight: lighter;">Adding User Failed</h2>';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - Control Panel</title>
	<link rel="stylesheet" type="text/css" href="admin_css.css" />
	<script src="jquery/jquery-3.1.0.min.js"></script>
	<script src="script.js"></script>
	<script>
	    function check() {
		if (window.location.search.indexOf('currentID') - 1) {
		    document.getElementById("update-modal").style.display = "none";
		} else {
		    document.getElementById("update-modal").style.display = "block";
		}
	    }
	    function cancel() {
		window.location = "admin_home.php";
	    }
	</script>
    </head>
    <body onload="check()">
	<div class="admin-container" align="center">
	    <div class="admin-menu">
		<nav>
		    <ul>
			<li class="admin-active"><a href="admin_home.php">Home</a></li>
			<li><a href="manage_users.php">Manage Users</a></li>
			<li><a href="manage_subscriptions.php">Subscriptions</a></li>
			<li><a href="#">Menu 4</a></li>
		    </ul>
		    <span>
			<ul>
			    <li><a href="admin_logout.php">LogOut</a></li>
			    <li><a href="#">Right Menu 1</a></li>
			</ul>
		    </span>
		</nav>
	    </div>
	    <br />
	    <h1 style="text-shadow: 2.5px 3.5px 4.5px #006666;" align="center">
		<?php
		if (isset($_SESSION['err'])) {
		    echo $_SESSION['err'];
		} else {
		    echo 'Total number of Users: ' . $total;
		}
		if (isset($_SESSION['msgSuccess'])) {
		    echo $_SESSION['msgSuccess'];
		    unset($_SESSION['msgSuccess']);
		}
		if (isset($_SESSION['UserUpdated'])) {
		    echo $_SESSION['UserUpdated'];
		    unset($_SESSION['UserUpdated']);
		}
		?>
	    </h1>
	    <hr />
	    <div class="cards">
		<div class="card-1">
		    <img class="card-1" src="images/img_avatar3.png" />
		    <input onclick="document.getElementById('id01').style.display = 'block'" class="card-button" type="button" name="addUser" value="Add New User" />
		    <div id="id01" class="w3-modal">
			<span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">X</span>
			<div class="w3-modal-content w3-animate-zoom" style="max-width:600px">
			    <div align="center"><br />
				<form method="post" action="" enctype="multipart/form-data">
				    <div class="w3-section">
					<input class="admin-input" type="text" placeholder="First Name" name="fname" required /><br />
					<input class="admin-input" type="text" placeholder="Last Name" name="lname" required /><br />
					<input class="admin-input" type="text" placeholder="Username" name="uname" required /><br />
					<input class="admin-input" type="password" placeholder="Password" name="pass" required><br />
					<input style="margin-left: -146px;" class="admin-input" type="number" min="18" max="60" placeholder="Age" name="age" required /><br />
					<input style="width: 32%; font-size: 14px;" class="admin-input" type="file" name="FileSelect" /><br />
					<textarea style="width: 32%;" class="admin-input" type="text" placeholder="About" name="about" required></textarea><br />
					<input class="admin-login-button" name="AddUser" type="submit" value="Add User"><br />
					<button onclick="document.getElementById('id01').style.display = 'none'" type="button" class="admin-login-button">Cancel</button>
				    </div>
				</form>
			    </div>
			</div>
		    </div>
		</div>
		<div class="card-2">
		    <img class="card-2" src="images/img_avatar3.png" />
		    <input id="update" onclick="document.getElementById('list-users').style.display = 'block'" class="card-button" type="button" name="updateUser" value="Update User" />
		    <div id="list-users" class="w3-modal">
			<span id="close" onclick="document.getElementById('list-users').style.display = 'none'" class="close" title="Close Modal">X</span>
			<div class="w3-modal-content" style="height: 550px;overflow: auto;max-width:600px">
			    <div align="center"><br />
			    </div>
			    <div id="section" class="w3-section">
				<div class="w3-modal-header">
				    <h2>Users List</h2>
				</div>
				<?php
				$fetchData = $conn->query("Select * from users");
				$sr = 1;
				while ($users = $fetchData->fetch_array()) {
				    ?>
    				<ul style="overflow: auto;" title="Click To Update User">
    				    <li class="admin-list-hover"><?php echo $sr; ?></li><br />
    				    <li><?php echo 'First Name: ' . $users['FirstName'] . '<br />' . 'Last Name: ' . $users['LastName']; ?></li>
    				    <ul style="float: right;">
    												 <li><a href="?currentID=<?php echo $users['ID']; ?>"><button style="height: available;" onclick="document.getElementById('list-users').style.display = 'none';
    						document.getElementById('update-modal').style.display = 'block'" id="editUser" class="admin-login-button" type="submit" name="edit-user">Edit</button></a></li>
    				    </ul>
    				</ul>
				    <?php
				    $sr++;
				}
				?>
			    </div>
			</div>
		    </div>
		    <div id="update-modal" class="w3-modal">
			<span onclick="document.getElementById('update-modal').style.display = 'none'" class="close" title="Close Modal">X</span>
			<div class="w3-modal-content w3-animate-zoom" style="max-width: 600px;">
			    <div align="center"><br />
				<form method="post" action="" enctype="multipart/form-data">
				    <div class="w3-section">
					<div class="w3-modal-header">
					    <h2>Update User</h2>
					</div>
					<?php
					if (isset($_REQUEST['currentID'])) {
					    $currID = $_REQUEST['currentID'];
					}
					$upUsers = $conn->query("Select * from users where ID = $currID");
					$selectedUser = $upUsers->fetch_array();
					$currentUserID = $selectedUser['ID'];
					if (isset($_POST['UpdateUser'])) {
					    if (isset($_FILES['FileSelect'])) {
						$file = $_FILES['FileSelect']['name'];
						$temp_file = $_FILES['FileSelect']['tmp_name'];

						$_SESSION['UpdatePic'] = $file;
						if (!$temp_file) {
						    $_SESSION['UpdatePic'] = $selectedUser['ProfileExt'];
						} else {
						    move_uploaded_file($temp_file, "images/avatars/$file");
						}
					    }

					    $UpdateFirstName = $_POST['fname'];
					    $UpdateLastName = $_POST['lname'];
					    $UpdateUsername = $_POST['uname'];
					    $UpdatePassword = $_POST['pass'];
					    $UpdateProPic = $_SESSION['UpdatePic'];
					    $UpdateAge = $_POST['age'];
					    $UpdateAbout = $_POST['about'];
					    if ($UpdatePassword == "" || $UpdatePassword == null) {
						$encPass = $selectedUser['Password'];
					    } else {
						$encPass = password_hash($UpdatePassword, PASSWORD_BCRYPT, array('cost' => 10));
					    }
					    $updateQuery = $conn->query("Update users set FirstName = '{$UpdateFirstName}', LastName = '{$UpdateLastName}', Username = '{$UpdateUsername}', Password = '{$encPass}', ProfileExt = '{$UpdateProPic}', Age = '{$UpdateAge}', About = '{$UpdateAbout}' Where ID = $currentUserID");
					    if ($updateQuery == true) {
						$location = "http://localhost/ProfileSystem/admin_home.php";
						echo '<meta http-equiv="refresh" content="0;URL=' . $location . '">';
						$_SESSION['UserUpdated'] = '<h2 style="color: green;">User Updated Successfully</h2>';
					    } else {
						echo 'Updating Failed';
					    }
					}
					?>
					<input class="admin-input" value="<?php echo $selectedUser['FirstName']; ?>" type="text" placeholder="First Name" name="fname" required /><br />
					<input class="admin-input" value="<?php echo $selectedUser['LastName']; ?>" type="text" placeholder="Last Name" name="lname" required /><br />
					<input class="admin-input" value="<?php echo $selectedUser['Username']; ?>" type="text" placeholder="Username" name="uname" required /><br />
					<input class="admin-input" type="password" placeholder="Password" name="pass" ><br />
					<input style="margin-left: -146px;" value="<?php echo $selectedUser['Age']; ?>" class="admin-input" type="number" min="18" max="60" placeholder="Age" name="age" required /><br />
					<input style="width: 32%; font-size: 14px;" class="admin-input" value="<?php echo $selectedUser['ProfileExt']; ?>" type="file" name="FileSelect" /><br />
					<input style="width: 32%;" class="admin-input" value="<?php echo $selectedUser['About']; ?>" type="text" placeholder="About" name="about" required /><br />
					<input class="admin-login-button" name="UpdateUser" type="submit" value="Update User"><br />
					<button onclick="cancel();
						document.getElementById('update-modal').style.display = 'none'" type="button" name="updateCancel" class="admin-login-button">Cancel</button>
					<?php
					?>
				    </div>
				</form>
			    </div>
			</div>
		    </div>
                </div>
	    </div>
	</div>
    </body>
</html>
