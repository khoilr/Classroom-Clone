<?php
require("./AllFunction.php");
$code = $_POST['code'];
$email = $_POST['email'];
$status = $_POST['status'];
switch ($status) {
    case 'Accept':
        if (updateAttendanceStatus($code, $email, 'current'))
            echo json_encode(array('code' => 1, 'message' => 'Joined class'));
        break;
    case 'Decline':
        if (removeStudent($email, $code))
            echo json_encode(array('code' => 1, 'message' => 'Student removed'));

        break;
}
