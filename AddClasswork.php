<?php
require("./AllFunction.php");
$title = $_POST['title'];
$classroomCode = $_POST['class-code'];
$description = !empty($_POST['description']) ? $_POST['description'] : '';
$fileName = $_FILES['classwork-file']['name'];
if (!empty($fileName)) {
    $targetFile = "./classroom/$classroomCode/$fileName";
    if (!is_dir("./classroom/$classroomCode")) {
        mkdir("./classroom/$classroomCode", 0700, true);
    }
    move_uploaded_file($_FILES['classwork-file']['tmp_name'], $targetFile);
}
$classworkCode = $classroomCode . '_' . generate(6);
$statement = $conn->prepare("INSERT INTO classwork (class_code, classwork_code, title, description, file) VALUES (?, ?, ?, ?, ?)");
$statement->bind_param('sssss', $classroomCode, $classworkCode, $title, $description, $targetFile);
if (!$statement->execute())
    die("hihi");
echo json_encode(array("code" => 1, "message" => "Classwork added"));
