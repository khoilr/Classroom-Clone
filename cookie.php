<?php

if (isset($_COOKIE['remember'])) {
    $cookie = $_COOKIE['remember'];
    list($email, $token, $mac) = explode(':', $cookie);
    if (!hash_equals(hash_hmac('sha256', $email . ':' . $token, SECRET_KEY), $mac))
        return false;
    $statement = $conn->prepare("SELECT * FROM cookie WHERE email = ?");
    $statement->bind_param('s', $email);
    if (!$statement->execute())
        die(json_encode(array("code" => -4, "message" => "Can't query from cookie'")));
    $result = $statement->get_result();
    $account = $result->fetch_assoc();
    $AccountToken = $account['token'];
    if (hash_equals($AccountToken, $token)) {
        header('Location: home.php');
    }
} 
    // header("Location: login.php");
// if(isset($_POST['cookie']) && $_POST['cookie']=='remove') {
//     $cookie = $_POST['cookie'];
//     echo $cookie;
// }