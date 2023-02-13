<?php
error_reporting(1);
require './conn.php';

global $conn;

if (isset($_POST['Login'])) {

    $AdminUser = $_POST['uname'];
    $AdminPass = $_POST['pass'];
    $sql = "Select * from admin where Username = '$AdminUser' And Password = '$AdminPass'";

    $res = $conn->query($sql);
    $row = $res->fetch_array();

    if ($AdminPass == $row['Password']) {
        session_start();
        $_SESSION['Username'] = $row['Username'];
        $_SESSION['ID'] = $row['ID'];
        header("location: admin_home.php");
    } else {
        $_SESSION['errMsg'] = '<h2 style="color: red;">Incorrect Username Or Password</h2>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Login</title>
    <link rel="stylesheet" type="text/css" href="admin_css.css"/>
</head>
<body>
<div>
    <div class="errors center">
        <?php
        if (isset($_SESSION['errMsg'])) {
            echo $_SESSION['errMsg'];
        }
        ?>
    </div>
    <div class="admin-login-form center">
        <form class="form-admin-login" action="admin.php" method="post">
            <span><h1>Login</h1></span>
            <input autofocus class="admin-input" name="uname" placeholder="Username" required
                   title="Enter Username" type="text"/><br/>
            <input class="admin-input" name="pass" placeholder="Password" required title="Enter Password"
                   type="password"/><br/>
            <input class="admin-login-button" name="Login" type="submit" value="Login as Admin"/><br/>
            <hr/>
            <span><a title="Not Admin, Click here" href="login.php" target="_blank"></a>• Login as User</span>
        </form>
    </div>
</div>
</body>
</html>
<?php $conn->close(); ?>