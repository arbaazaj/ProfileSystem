<?php

require './conn.php';

if(isset($_POST['Login'])) {
    
    $Uname = $_POST['username'];
    $Pass = $_POST['password'];
    
    $result = $conn->query("select * from users where username='$Uname' AND password='$Pass'");
    
    $row = $result->fetch_array(MYSQLI_BOTH);
    
    session_start();
    
    $_SESSION['username'] = $row['username'];
    
    header("location: index.php");
}

?>