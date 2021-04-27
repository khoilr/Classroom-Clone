<?php
require("./AllFunction.php");
$title = $_POST['title'];
$description = $_POST['description'];
$classworkCode = $_POST['classwork-code'];
if (updateClasswork($classworkCode, $title, $description))
    echo true;
