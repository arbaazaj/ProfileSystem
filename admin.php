<?php
require './conn.php';

if (isset($_POST['Login'])) {

    $AdminUser = $_POST['uname'];
    $AdminPass = $_POST['pass'];

    $res = $conn->query("Select * from admin where Username = '$AdminUser' And Password = '$AdminPass'");
    $row = $res->fetch_array(MYSQLI_BOTH);

    if ($AdminPass == $row['Password']) {
	session_start();
	$_SESSION['Username'] = $row['Username'];
	$_SESSION['ID'] = $row['ID'];
	header("location: admin_home.php");
    } else {
	$_SESSION['errmsg'] = '<h2 style="color: red;">Incorrect Username Or Password</h2>';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - Login</title>
	<link rel="stylesheet" type="text/css" href="admin_css.css" />
    </head>
    <body>
	<div>
	    <div class="errors" align="center">
		<?php
		if (isset($_SESSION['errmsg'])) {
		    echo $_SESSION['errmsg'];
		}
		?>
	    </div>
	    <div class="admin-login-form" align="center">
		<form class="form-admin-login" action="admin.php" method="post">
		    <span><h1>Login</h1></span>
		    <input class="admin-input" type="text" name="uname" title="Enter Username" placeholder="Username" required="true" autofocus="true"/><br />
		    <input class="admin-input" type="password" name="pass" title="Enter Password" placeholder="Password" required="true" /><br />
		    <input class="admin-login-button" name="Login" type="submit" value="Login as Admin" /><br />
		    <hr />
		    <span><a title="Not Admin, Click here" href="login.php" target="_blank"/>• Login as User</span>
		</form>
	    </div>
	</div>
    </body>
</html>
