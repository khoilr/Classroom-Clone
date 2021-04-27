<?php
require("./AllFunction.php");
if ($_POST['from'] == 'teacher') {
    $code = $_POST['class-code'];
    $className = $_POST['className'];
    $courseName = $_POST['courseName'];
    $room = $_POST['room'];
    if (updateClass('class_name', $code, $className) && updateClass('course_name', $code, $courseName) && updateClass('room', $code, $room))
        echo json_encode(array("code" => 1, "message" => "Class updated successfully"));
} elseif ($_POST['from'] == 'admin') {
    $edit = $_POST['edit'];
    $value = $_POST['value'];
    $code = $_POST['code'];
    if (updateClass($edit, $code, $value))
        echo json_encode(array("code" => 1, "message" => "Class updated successfully"));
}
