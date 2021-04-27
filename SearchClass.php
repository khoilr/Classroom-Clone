<?php
require("./AllFunction.php");
$email = $_POST['email'];
$key = $_POST['key'];
$class = getClassesByTeacher($email);
$result = array();
while ($foo = $class->fetch_assoc())
    if (preg_match("/$key/i", $foo['class_name']) || preg_match("/$key/i", $bar['course_name']) || preg_match("/$foo/i", $bar['room']))
        array_push($result, array("class-code" => $foo['class_code'], "class-name" => $foo['class_name']));
echo json_encode($result);
