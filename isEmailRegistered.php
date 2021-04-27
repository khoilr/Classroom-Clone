<?php
require("./conn.php");
$email = $_POST['email'];
$sql = "SELECT * FROM account WHERE email = ?";
$statement = $conn->prepare($sql);
$statement->bind_param('s', $email);
if (!$statement->execute())
    die("Query error");
$result = $statement->get_result();
echo $result->num_rows;
// if (isset($_POST['email']))
//     echo "Khôi cute";
// else
//     echo "Quyên cute";
