<?php
require './conn.php';
global $conn;

if (isset($_POST['Login'])) {

    $Uname = $_POST['username'];
    $Pass = $_POST['password'];

    $sql = "Select * from users where Username='$Uname'";

    $result = $conn->query($sql);
    $row = $result->fetch_array();

    if ($Uname == $row['Username']) {
        if (password_verify($Pass, $row['Password'])) {
            session_start();

            $_SESSION["ID"] = $row['ID'];
            $_SESSION["Username"] = $row['Username'];
            $_SESSION["FirstName"] = $row['FirstName'];
            $_SESSION["LastName"] = $row['LastName'];
            $_SESSION["Pic"] = $row['ProfileExt'];
            header("location: index.php");
        } else {
            $_SESSION['msgUserError'] = '<h2 style="color: red;">Password not matched!</h2>';
        }
    } else {
        $_SESSION['msgUserError'] = '<h2 style="color: red;">User not found!</h2>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!--<link rel="stylesheet" type="text/css" href="w3.css" />-->
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<div class="top-nav center">
    <nav>
        <ul>
            <li class="active"><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
</div>
<div id="container">
    <label id="lblLogin">Login Here</label>
    <div id="msg">
        <?php
        if (isset($_SESSION['msgUserError'])) {
            echo $_SESSION['msgUserError'];
            unset($_SESSION['msgUserError']);
        }
        ?>
    </div>
    <div id="loginForm">
        <form action="" method="post">
            <input id="userName" type="text" name="username" title="Enter Username" placeholder="Username"
                   autofocus required/><br/>
            <input id="pass" type="password" name="password" title="Enter Password" placeholder="Password"
                   required/><br/>
            <input id="btnLogin" type="submit" name="Login" value="Login"/>
        </form>
    </div>
</div>
</body>
</html>
