<?php
require("./conn.php");
function getAccountByEmail($email) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM account WHERE email = ?");
    $statement->bind_param('s', $email);
    if (!$statement->execute())
        die();
    $account = $statement->get_result()->fetch_assoc();
    return $account;
}
function isAccountExist($email) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM account WHERE email = ?");
    $statement->bind_param('s', $email);
    if (!$statement->execute())
        die();
    $account = $statement->get_result();
    return $account->num_rows != 0;
}
function isTeacher($classCode, $teacher) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM classroom WHERE class_code = ? AND teacher = ?");
    $statement->bind_param('ss', $classCode, $teacher);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result->num_rows != 0;
}
function getClassesByTeacher($email) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM classroom WHERE teacher = ?");
    $statement->bind_param('s', $email);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result;
}
function getAttendancesByStudent($email) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM attendance WHERE email = ?");
    $statement->bind_param('s', $email);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result;
}
function isParticipated($email, $code) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM attendance WHERE email = ? AND class_code = ?");
    $statement->bind_param("ss", $email, $code);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result->num_rows != 0;
}
function isPendingParticipate($email, $classCode) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM attendance WHERE email = ? AND class_code = ?");
    $statement->bind_param("ss", $email, $classCode);
    if (!$statement->execute())
        die();
    $result = $statement->get_result()->fetch_assoc();
    $status = $result['status'];
    return $status != 'current';
}
function getClassByClassCode($code) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM classroom WHERE class_code = ?");
    $statement->bind_param('s', $code);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    if ($result->num_rows == 0)
        return false;
    else
        return $result->fetch_assoc();
}
function getAll($getWhat) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM $getWhat");
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result;
}
function getStudentsByClassCode($code) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM attendance WHERE class_code = ?");
    $statement->bind_param('s', $code);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result;
}
function removeClass($code) {
    global $conn;
    $class = getClassByClassCode($code);
    $folder = $class['class_image'];
    $path = explode('/', $folder);
    $path = $path[0] . '/' . $path[1] . '/' . $path[2];
    $obj = scandir($path);
    foreach ($obj as $bar) {
        unlink($path . '/' . $bar);
    }
    rmdir($path);
    $removeClassStatement = $conn->prepare("DELETE FROM classroom WHERE class_code = ?");
    $removeClassStatement->bind_param('s', $code);
    if (!$removeClassStatement->execute())
        return false;
    $removeAttendanceStatement = $conn->prepare("DELETE FROM attendance WHERE class_code = ?");
    $removeAttendanceStatement->bind_param('s', $code);
    if (!$removeAttendanceStatement->execute())
        return false;
    $removeCommentStatement = $conn->prepare("DELETE FROM classwork WHERE class_work = ?");
    $removeCommentStatement->bind_param('s', $code);
    if (!$removeCommentStatement->execute())
        return false;
    $removeCommentStatement = $conn->prepare("DELETE FROM comment WHERE classwork_code LIKE CONCAT(?, '%')");
    $removeCommentStatement->bind_param('s', $code);
    if (!$removeCommentStatement->execute())
        return false;
    return true;
}
function removePeople($email) {
    global $conn;
    $removePeopleStatement = $conn->prepare("DELETE FROM account WHERE email = ?");
    $removePeopleStatement->bind_param('s', $email);
    if (!$removePeopleStatement->execute())
        return false;
    $removeAttendanceStatement = $conn->prepare("DELETE FROM attendance WHERE email = ?");
    $removeAttendanceStatement->bind_param('s', $email);
    $removeCommentStatement = $conn->prepare("DELETE FROM comment WHERE email = ?");
    $removeCommentStatement->bind_param('s', $email);
    if (!$removeCommentStatement->execute())
        return false;
    if (!$removeAttendanceStatement->execute())
        return false;
    return true;
}
function generate($length) {
    $bar = '';
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++)
        $bar .= $characters[rand(0, strlen($characters) - 1)];
    return $bar;
}
function getAllClassworkByClassCode($code) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM classwork WHERE class_code = ?");
    $statement->bind_param('s', $code);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result;
}
function getClassworkByCode($code) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM classwork WHERE classwork_code = ?");
    $statement->bind_param('s', $code);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result;
}
function removeClasswork($code) {
    global $conn;
    $classwork = getClassworkByCode($code)->fetch_assoc();
    unlink($classwork['file']);
    $statement = $conn->prepare("DELETE FROM classwork WHERE classwork_code = ?");
    $statement->bind_param('s', $code);
    if (!$statement->execute())
        return false;
    $removeCommentStatement = $conn->prepare("DELETE FROM comment WHERE classwork_code = ?");
    $removeCommentStatement->bind_param('s', $code);
    if (!$removeCommentStatement->execute())
        return false;
    return true;
}
function removeStudent($email, $code) {
    global $conn;
    $statement = $conn->prepare("DELETE FROM attendance WHERE email = ? and class_code = ?");
    $statement->bind_param('ss', $email, $code);
    if (!$statement->execute())
        return false;
    $removeCommentStatement = $conn->prepare("DELETE FROM comment WHERE email = ?");
    $removeCommentStatement->bind_param('s', $email);
    if (!$removeCommentStatement->execute())
        return false;
    return true;
}
function isClassExist($code) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM classroom WHERE class_code = ?");
    $statement->bind_param('s', $code);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result->num_rows != 0;
}
function joinClass($email, $code, $status) {
    global $conn;
    if (!isClassExist($code))
        return false;
    $statement = $conn->prepare("INSERT INTO attendance (class_code, email, status) VALUES (?, ?, ?)");
    $statement->bind_param('sss', $code, $email, $status);
    if (!$statement->execute())
        return false;
    return true;
}
function isClassworkExist($code) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM classwork WHERE classwork_code = ?");
    $statement->bind_param('s', $code);
    if (!$statement->execute())
        echo "Khoicute";
    $result = $statement->get_result();
    return $result->num_rows != 0;
}
function updateRole($email, $role) {
    global $conn;
    $statement = $conn->prepare("UPDATE account SET role = ? WHERE email = ?");
    $statement->bind_param('ss', $role, $email);
    echo 'hihi';
    if (!$statement->execute())
        die();
    return true;
}
function updateClass($updateWhat, $code, $value) {
    global $conn;
    $statement = $conn->prepare("UPDATE classroom SET $updateWhat = ? WHERE class_code = ?");
    $statement->bind_param('ss', $value, $code);
    if (!$statement->execute())
        die();
    return true;
}
function postComment($commentCode, $classworkCode, $email, $content) {
    global $conn;
    $statement = $conn->prepare("INSERT INTO comment (comment_code, classwork_code, email, content) VALUES (?, ?, ?, ?)");
    $statement->bind_param('ssss', $commentCode, $classworkCode, $email, $content);
    if (!$statement->execute())
        die();
    return true;
}
function getAllCommentsByClassworkCode($classworkCode) {
    global $conn;
    $statement = $conn->prepare("SELECT * FROM comment WHERE classwork_code = ?");
    $statement->bind_param('s', $classworkCode);
    if (!$statement->execute())
        die();
    $result = $statement->get_result();
    return $result;
}
function setAvatarByRole($email) {
    $account = getAccountByEmail($email);
    switch ($account['role']) {
        case 'admin':
            echo "./images/admin.png";
            break;
        case 'student':
        case 'pending':
            echo "./images/student.png";
            break;
        case 'teacher':
            echo "./images/teacher.png";
            break;
    }
}

function updateAttendanceStatus($classCode, $email, $status) {
    global $conn;
    $statement = $conn->prepare("UPDATE attendance SET status = ? WHERE class_code = ? AND email = ?");
    $statement->bind_param('sss', $status, $classCode, $email);
    if (!$statement->execute())
        die();
    return true;
}
function removeComment($commentCode) {
    global $conn;
    $statement = $conn->prepare("DELETE FROM comment WHERE comment_code = ?");
    $statement->bind_param('s', $commentCode);
    if (!$statement->execute())
        die();
    return true;
}
function updateClasswork($classworkCode, $title, $description) {
    global $conn;
    $statement = $conn->prepare("UPDATE classwork SET title = ?, description = ? WHERE classwork_code = ? ");
    $statement->bind_param('sss', $title, $description, $classworkCode);
    if (!$statement->execute())
        die();
    return true;
}
