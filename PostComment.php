<?php
require("./AllFunction.php");
$classworkCode = $_POST['classwork'];
$email = $_POST['email'];
$content = $_POST['student-comment'];
$commentCode = $classworkCode . '_' . generate(6);
if (postComment($commentCode, $classworkCode, $email, $content))
    echo true;
