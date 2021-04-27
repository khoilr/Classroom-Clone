<?php
if ($_POST['action'] == 'logout') {
    setcookie("remember", "", time() - 3600);
    session_start();
    session_destroy();
    echo json_encode(array("code" => 1, "message" => "Log out successfully"));
}
