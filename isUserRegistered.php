<?php
require_once("./conn.php");
$user = $_POST['user'];
$statement = $conn->prepare("SELECT * FROM account WHERE user = ?");
$statement->bind_param('s', $user);
// if(!$statement->execute())
//     die("Query error");
$statement->execute();
$result = $statement->get_result();
echo $result->num_rows;