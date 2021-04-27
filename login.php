<?php
require("./AllFunction.php");
require("./cookie.php");
if(isset($_SESSION['email']))
    header("Location: home.php");
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(!isAccountExist($email))
        die(json_encode(array("code" => -2, "message" => "This email hasn't registered yet.")));
    $account = getAccountByEmail($email);
    if (!password_verify($password, $account['password']))
        die(json_encode(array("code" => -3, "message" => "Incorrect password")));
    echo json_encode(array("code" => 1, "message" => "Login successfully"));
    $_SESSION['email'] = $email;
    if (isset($_POST['remember'])) {
        $token = md5(uniqid($email, true));
        $statement = $conn->prepare("SELECT * FROM cookie WHERE email = ?");
        $statement->bind_param('s', $email);
        if (!$statement->execute())
            die(json_encode(array("code" => -4, "message" => "Can't query from cookie'")));
        $result = $statement->get_result();
        if ($result->num_rows == 0) {
            $statement = $conn->prepare("INSERT INTO cookie (token,email) VALUES (?, ?)");
            $statement->bind_param('ss', $token, $email);
            if (!$statement->execute())
                die(json_encode(array("code" => -5, "message" => "Can't store cookie token to database")));
        } else {
            $statement = $conn->prepare("UPDATE cookie SET token = ? WHERE email = ?");
            $statement->bind_param('ss', $token, $email);
            if (!$statement->execute())
                die(json_encode(array("code" => -5, "message" => "Can't store cookie token to database")));
        }
        $cookie = $email . ':' . $token;
        $mac = hash_hmac('sha256', $cookie, SECRET_KEY);
        $cookie .= ':' . $mac;
        setcookie('remember', $cookie);
    }
    exit;
}
?>
<html lang="en">

<head>
    <?php require("./HTMLHeader.php")?>
<title>Login</title>
</head>

<body>
    <div class="container">
        <?php require("./BeforeLoginHeader.php") ?>

        <div class="row d-flex justify-content-center">
            <!--Login-->
            <div class="col-lg-6 col-md-8 col-12">
                <form action="login.php" method="post" class="rounded border p-3" id="loginForm">
                    <div class="form-group">
                        <h2 class="title">Login</h2>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="emailLogin" name="email">
                        <label for="emailLogin">Email</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="passwordLogin" name="password">
                        <label for="passwordLogin">Password</label>
                    </div>
                    <div class="form-group position-relative d-table">
                        <input type="checkbox" class="d-none" id="remember" name="remember">
                        <label class="checkbox m-0" for="remember">Remember me</label>
                    </div>
                    <div class="form-group invalid-input-field">
                        <p class="invalid-input"></p>
                    </div>
                    <div class='d-flex'>
                        <button type="submit" class="btn btn-primary float-left mr-3">Login</button>
                        <p class="align-self-center m-0">Not have an account yet? <a href="registry.php">Registry
                                here</a></p>
                    </div>
                </form>
                <div>
                    <a href="forgot.php" class="text-secondary">Forgot your password</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>