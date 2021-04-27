<?php
require("./conn.php");
require("./AllFunction.php");

$className = $_POST['className'];
$courseName = $_POST['courseName'];
$room = $_POST['room'];
$teacher  = $_POST['hiddenTeacher'];

$allClasses = getAll('classroom');
$allClassesCode = array();
while ($foo = $allClasses->fetch_assoc())
    array_push($allClassesCode, $foo['class_code']);

do {
    $code = generate(6);
} while (in_array($code, $allClassesCode));

$fileExtension = end(explode('.', $_FILES['classImage']['name']));
$fileName = $code . '.' . $fileExtension;
$targetFile = "./classroom/$code/$fileName";
if (!is_dir("./classroom/$code")) {
    mkdir("./classroom/$code", 0700, true);
}
if (!move_uploaded_file($_FILES['classImage']['tmp_name'], $targetFile))
    die(json_encode(array('code' => -2, "message" => "Can't upload file")));
$statement = $conn->prepare("INSERT INTO classroom (class_code, class_name, course_name, teacher, class_image, room) VALUES (?, ?, ?, ?, ?, ?)");
$statement->bind_param("ssssss", $code, $className, $courseName, $teacher, $targetFile, $room);
if (!$statement->execute()) {
    error_log($statement);
    die(json_encode(array("code" => -3, "message" => "Can't query from database")));
}
echo json_encode(array("code" => 1, 'message' => 'Create class successfully'));
// $statement = $conn->prepare("INSERT INTO classroom (class_name, course_name, teacher, room, class_image");

// Array ( [className] => efhuiwe [courseName] => rioejgio [room] => 0502 [hiddenTeacher] => khoile2239@gmail.com )
// Array ( [classImage] => Array ( [name] => Screenshot (124).png [type] => image/png [tmp_name] => /tmp/phpEZyL13 [error] => 0 [size] => 450873 ) )