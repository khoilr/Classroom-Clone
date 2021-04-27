<?php
require("./AllFunction.php");
$code = $_POST['code'];
if (removeComment($code))
    echo json_encode(array("code" => 1, "message" => "Remove comment successfully"));
