<?php
require("./conn.php");
require("./AllFunction.php");
$code = $_POST['classCode'];
$email = $_POST['hiddenStudent'];
$classroom = getClassByClassCode($code);
if (!$classroom)
    die(json_encode(array("code" => -2, "message" => "Class not found")));
if ($classroom['teacher'] == $email)
    die(json_encode(array("code" => -3, "message" => "You are teacher of this class")));
if (isParticipated($email, $code)) {
    if (isPendingParticipate($email, $code))
        die(json_encode(array('code' => -5, 'message' => "Pending for your teacher approve")));
    die(json_encode(array('code' => -4, 'message' => "You are already in this class")));
}
$pending = 'teacher-pending';
if (joinClass($email, $code, $pending))
    echo json_encode(array("code" => 1, "message" => "Waiting an approvement from your teacher"));
