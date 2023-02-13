<?php

const host = 'localhost';
const user = 'root';
const password = '';
const database = 'profilesystem';

$conn = mysqli_connect(host, user, password, database);


if (mysqli_connect_error()) {
    die('Connection failed: ' . mysqli_connect_error());
}
