<?php
$sever = "localhost";
$username = "khoilr";
$password = "khoikhoi";
$database = "DoAnCuoiKi";
// Create connection
$conn = new mysqli($sever, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
