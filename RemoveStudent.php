<?php
require("./AllFunction.php");
$email = $_POST['email'];
$code = $_POST['code'];
if (removeStudent($email, $code))
    echo json_encode(array("code" => 1, "message" => "Remove student successfully"));
