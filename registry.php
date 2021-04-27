<?php
require('conn.php');
require("./cookie.php");
if (isset($_SESSION['email']))
    header("Location: home.php");
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $user = $_POST['userNameRegistry'];
    $fullName = $_POST['fullName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phone = $_POST['phone'];
    $role = 'student';
    $statement = $conn->prepare("INSERT INTO account (email, user, full_name, password, phone, date_of_birth, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->bind_param('sssssss', $email, $user, $fullName, $hash, $phone, $dateOfBirth, $role);
    if ($statement->execute())
        echo json_encode(array("code" => 1, "message" => "Create account successfully, directing to login page..."));
    exit;
}
?>
<html lang="en">

<head>
    <?php
    require("./HTMLHeader.php") 
    ?>
<title>Registry</title>
</head>

<body>
    <div class="container">
        <?php require("./BeforeLoginHeader.php") ?>
        <div class="row d-flex justify-content-center">
            <!--Registry-->
            <div class="col-lg-6 col-md-8 col-12">
                <form action="" method="post" class="rounded border p-3" id="registryForm">
                    <div class="form-group">
                        <h2 class="title">Registry</h2>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="fullName" name="fullName">
                        <label for="fullName">Full name</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="userNameRegistry" class="form-control" id="userNameRegistry">
                        <label for="userNameRegistry">User name</label>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="emailRegistry" name="email">
                        <label for="emailRegistry">Email</label>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" name="password" id="passwordRegistry" autocomplete="new-password">
                        <label for="passwordRegistry">Password</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirmPassword" autocomplete="new-password">
                        <label for="confirmPassword">Confirm password</label>
                    </div>
                    <div class="form-group">
                        <input type="date" id="dateOfBirth" class="form-control" name="dateOfBirth">
                        <label for="dateOfBirth">Date of birth</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="phoneNumber" class='form-control' name="phone">
                        <label for="phoneNumber">Phone number</label>
                    </div>
                    <div class="form-group invalid-input-field">
                        <p class='invalid-input blank-input'></p>
                        <p class="invalid-input" id="invalid-user"></p>
                        <p class="invalid-input" id="invalid-email"></p>
                        <p class="invalid-input" id='invalid-password'></p>
                        <p class='invalid-input' id="invalid-phone"></p>
                    </div>
                    <div class="form-group success-create-field">
                        <p class="success-create"></p>
                    </div>
                    <div class='d-flex'>
                        <button type="submit" class="btn btn-primary float-left mr-3">Registry</button>
                        <p class="align-self-center m-0">Already have an account? <a href="login.php">Login here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>