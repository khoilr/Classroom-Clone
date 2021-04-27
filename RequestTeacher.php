<?php
require("./conn.php");
$email = $_POST['email-request'];
$statement = $conn->prepare("UPDATE account SET role = 'pending' WHERE email = ?");
$statement->bind_param('s', $email);
if (!$statement->execute())
    die(json_encode(array("code" => -1, "message" => "Can't query from database")));
echo json_encode(array("code" => 1, "message" => "Your request has been sent, an admin will consider to approve"));
