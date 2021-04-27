<?php
require("./AllFunction.php");
$code = $_POST['code'];
if (removeClasswork($code))
    echo json_encode(array("code" => 1, "message" => "Remove classwork successfully"));