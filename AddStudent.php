<?php
require("./AllFunction.php");
$student = $_POST['student-email'];
$teacher = $_POST['teacher'];
$classCode = $_POST['class-code'];
// echo $student;
// echo $teacher;
// echo $classCode;
if ($student == $teacher)
    die(json_encode(array("code" => -1, "message" => "You are teacher of this class")));
if (!isAccountExist($student))
    die(json_encode(array("code" => -2, "message" => "Account not found")));
$attendances = getAttendancesByStudent($student);
while ($foo = $attendances->fetch_assoc())
    if ($foo['class_code'] == $classCode) {
        if (isPendingParticipate($email, $code))
            die(json_encode(array('code' => -5, 'message' => "Pending for student approve")));
        die(json_encode(array("code" => -3, "message" => "This student is already attendance")));
    }
$pending = 'student-pending';
if (joinClass($student, $classCode, $pending))
    echo json_encode(array("code" => 1, "message" => "Waiting your student accept your invitation"));
else echo "hihi";
