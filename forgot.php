<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require("./vendor/autoload.php");
require("./cookie.php");
require("./AllFunction.php");
if (isset($_SESSION['email']))
    header("Location: home.php");
if (isset($_POST['email'])) {
    $email  = $_POST['email'];
    if (!isAccountExist($email))
        die(json_encode(array("code" => -2, "message" => "This email is has not registered")));
    $account = getAccountByEmail($email);
    $expireTokenTime = date('Y-m-d H:i:s', strtotime("+10 min"));
    $token = md5(uniqid($email, true));
    $link = "localhost/Assignments/DoAnCuoiKi/reset.php?token=$token";
    $statement = $conn->prepare("UPDATE account SET token = ?, token_expire_time= ? WHERE email = ?");
    $statement->bind_param('sss', $token, $expireTokenTime, $email);
    if (!$statement->execute())
        die(json_encode(array("code" => -3, "message" => "Can't insert token")));
    /*************************
     * Send reset password email
     *************************/
    $mail = new PHPMailer(true);
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'khoilr730@gmail.com';                  // SMTP username
        $mail->Password   = 'xvzktbynplkjkbja';                     // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('reset_password@classroom.com', 'Reset your Classroom\'s password');
        $mail->addAddress($email, utf8_decode($account['full_name']));     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Reset your password';
        $mail->Body    = "We have just received a request to reset your password<br>
                    This link will expire in 10 minutes. <a href=$link>Click on this link to change your password</a>";
        $mail->AltBody = "We have just received a request to reset your password<br>
                    Click on this link to change your password: $link";
        $mail->send();
        echo json_encode(array("code" => 1, "message" => "An email recovery your password has been sent"));
    } catch (Exception $e) {
        echo json_encode(array("code" => -4, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
    }
    exit;
}
?>
<html lang="en">

<head>
    <?php
    require("./HTMLHeader.php")
    ?>
    <title>Forgot password</title>
</head>

<body>
    <div class="container">
        <?php require("./BeforeLoginHeader.php") ?>

        <div class="row d-flex justify-content-center">
            <!--Forgot password-->
            <div class="col-lg-6 col-md-8 col-12">
                <form action="" method="post" class="rounded border p-3" id="forgot">
                    <div class="form-group">
                        <h2 class="title">Reset password</h2>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="emailForgot" name="emailForgot">
                        <label for="emailForgot">Email</label>
                    </div>
                    <div class="form-group invalid-input-field">
                        <p class="invalid-input"></p>
                    </div>
                    <div class="form-group success-create-field">
                        <p class="success-create"></p>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset password</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>