<?php
require("./AllFunction.php");
$code = $_POST['code'];
if (removeClass($code))
    echo true;
