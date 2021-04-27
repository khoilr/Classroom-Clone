<?php
require('./conn.php');
require("./cookie.php");
if (isset($_SESSION['email']))
    header("Location: home.php");
if (isset($_POST['password']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $statement = $conn->prepare("UPDATE account SET password = ? WHERE email = ?");
    $statement->bind_param('ss', $hash, $email);
    if (!$statement->execute())
        die(json_encode(array("code" => -2, "message" => "Can't reset password")));
    echo json_encode(array("code" => 1, "message" => "Your password has been updated, directing to login page..."));
    $statement  = $conn->prepare("UPDATE account SET token = null, token_expire_time = null WHERE email = ?");
    $statement->bind_param('s', $email);
    if (!$statement->execute())
        die(json_encode(array("code" => -2, "message" => "Can't reset password")));
    exit;
}

if (!empty($_GET["token"])) {
    $token = $_GET['token'];
    $statement = $conn->prepare("SELECT * FROM account WHERE token = ?");
    $statement->bind_param('s', $token);
    if (!$statement->execute())
        die(json_encode(array("code" => -1, "message" => "Can't execute")));
    $result = $statement->get_result();
    $resetPassword = $result->fetch_assoc();
} else
    header("Location: login.php");
?>
<html lang="en">

<head>
    <?php
    require("./HTMLHeader.php")
    ?>
    <title>Reset password</title>
</head>

<body>
    <div class="container">
        <?php require("./BeforeLoginHeader.php") ?>
        <div class="row d-flex justify-content-center">
            <!--Forgot password-->
            <div class="col-lg-6 col-md-8 col-12">
                <?php
                $currentDate = date("Y-m-d H:i:s");
                $expireTime = $resetPassword['token_expire_time'];
                $email = $resetPassword['email'];
                if (($expireTime < $currentDate) || ($result->num_rows == 0)) {
                ?>
                    <!-- hết hạn -->
                    <div class="form-group invalid-input-field thin-field d-block m-auto">
                        <p class="invalid-input">This link is expired</p>
                    </div>
                <?php
                } else { ?>
                    <!-- còn hạn -->
                    <form action="" method="post" class="rounded border p-3" id="reset">

                        <div class="form-group">
                            <h2 class="title">Reset password</h2>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" name="password" id="passwordRegistry" autocomplete="new-password">
                            <label for="passwordRegistry">Password</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="confirmPassword" autocomplete="new-password">
                            <label for="confirmPassword">Confirm password</label>
                        </div>
                        <div class="form-group invalid-input-field">
                            <p class="invalid-input" id='invalid-password'></p>
                        </div>
                        <div class="form-group success-create-field">
                            <p class="success-create"></p>
                        </div>
                        <input type="hidden" name="email" value=<?php echo $email ?>>
                        <button type="submit" class="btn btn-primary">Reset password</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>