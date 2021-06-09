<?php
$sever = "us-cdbr-east-04.cleardb.com";
$username = "b66e857b169beb";
$password = "d2e29911";
$database = "heroku_7341053d835f019";
// Create connection
$conn = new mysqli($sever, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
