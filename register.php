<?php
require './conn.php';
session_start();

if (isset($_POST['Register'])) {

    if (isset($_FILES['regFileSelect'])) {

	$filename = $_FILES['regFileSelect']['name'];
	$temp_filename = $_FILES['regFileSelect']['tmp_name'];
	$filename = preg_replace("#[^a-z0-9.]#i", "", $filename);

	$_SESSION['myfile'] = $filename;
	if (!$temp_filename) {
	    $_SESSION['myfile'] = $filename;
	} else {
	    move_uploaded_file($temp_filename, "images/avatars/$filename");
	}
    }

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $pass = $_POST['password'];
    $age = $_POST['age'];
    $profilePic = $_SESSION['myfile'];
    $about = $_POST['about'];
    $EncryptedPass = password_hash($pass, PASSWORD_BCRYPT, array('cost' => 10));

    $stmt = $conn->query("Insert into users(FirstName, LastName, Username, Password, ProfileExt, About, Age) values('{$fname}', '{$lname}', '{$uname}', '{$EncryptedPass}', '{$profilePic}', '{$about}', '{$age}');");
    
    if ($stmt == true) {
	$_SESSION['msgSuccess'] = '<h2 style="color: green; font-weight: lighter;">Registration Successful. Please Login.</h2>';
    } else {
	$_SESSION['msgFailed'] = '<h2 style="color: red; font-weight: lighter;">Registration Failed!</h2>';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
	
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="script.js"></script>
	
    </head>
    <body>
	<div class="top-nav" style="margin-top: 30px;" align="center">
	    <nav>
		<ul>
		    <li><a href="login.php">Login</a></li>
		    <li class="active"><a href="register.php">Register</a></li>
		</ul>
	    </nav>
	</div>
	<div id="container" style="border-radius: 0; overflow: auto; left: 50.65%; background-image: none; height: 530px;">
	    <div id="msg">
		<?php
		if (isset($_SESSION['msgSuccess'])) {
		    echo $_SESSION['msgSuccess'];
		    unset($_SESSION['msgSuccess']);
		}
		if (isset($_SESSION['msgFailed'])) {
		    echo $_SESSION['msgFailed'];
		    unset($_SESSION['msgFailed']);
		}
		?>
	    </div>
	    <div id="registerForm" align="center">
		<form action="register.php" method="post" enctype="multipart/form-data">
		    <fieldset style="width: 50%; border-color: threedlightshadow; padding: 20px;">
			<legend id="lblLogin" style="margin-bottom: 5px;">Registration Form</legend>
			<input class="inputStyle" id="firstName" type="text" name="fname" title="Please enter First Name" placeholder="First Name" required="true" autofocus="true" /><br />
			<input class="inputStyle" id="lastName" type="text" name="lname" title="Please enter Last Name" placeholder="Last Name" required="true" /><br />
			<input class="inputStyle" id="username" type="text" name="uname" title="Please enter Username" placeholder="Username" required="true" /><br />
			<input class="inputStyle" id="password" type="password" name="password" title="Please enter Password" placeholder="Password" required="true" /><br />
			<input style="width: 10%; margin-right: 142px;" class="inputStyle" title="Please enter Age" id="age" type="number" name="age" placeholder="Age" min="18" max="60" onchange="checkAge()"  required="true" /><br />
			<legend style="margin-right: 85px;">Profile Picture:</legend>
			<input style="width: 38.5%;" class="inputStyle" id="fileSelect" type="file" name="regFileSelect" title="Please select an image file" /><br />
			<legend style="margin-right: 125px;">About Me:</legend>
			<textarea class="inputStyle" rows="3" id="aboutText" name="about" title="Tell us something about yourself" required="true"></textarea><br />
			<input id="btnLogin" type="submit" name="Register" value="Register" />
		    </fieldset>
		</form>
	    </div>
	</div>
    </body>
</html>
