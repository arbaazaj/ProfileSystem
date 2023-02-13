<?php

require './conn.php';

session_start();

if (isset($_POST['Login'])) {

    $Uname = $_POST['username'];
    $Pass = $_POST['password'];

    if (isset($conn)) {
        $result = $conn->prepare("Select * FROM users WHERE username='$Uname' AND password='$Pass'");
        $result->bind_param('s', $Uname, $Pass);
        $result->execute();
        $result->store_result();

        if ($result->num_rows > 0) {
            $result->bind_result($Uname, $Pass);
            $result->fetch();

            $_SESSION['username'] = $Uname;
            header("location: index.php");
        }
        $result->close();
    }
}