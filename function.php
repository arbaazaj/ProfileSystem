<?php

require './conn.php';

function getId($Username) {
    $q = mysqli_query("Select id from users where Username = '$Username'");
    while ($r = mysqli_fetch_array($q)) {
	return $r['ID'];
    }
}

function unsetSession() {
    if (isset($_SESSION['msgUpdated'])) {
	unset($_SESSION['msgUpdated']);
    }
}