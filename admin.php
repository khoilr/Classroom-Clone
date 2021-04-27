<?php
require("./conn.php");
require("./AllFunction.php");
$accountInfo = getAccountByEmail($_SESSION['email']);
if (!isset($_SESSION['email']))
    header("Location: login.php");
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'remove-people':
            $email = $_POST['email'];
            if (removePeople($email))
                echo json_encode(array("code" => 1, "message" => "Remove account successfully"));
            break;
        case 'change-role':
            $email = $_POST['email'];
            $role = $_POST['role'];
            updateRole($email, $role);
            // echo json_encode(array("code" => 1, "message" => "Change role successfully"));
        default:

            # code...
            break;
    }
    exit;
}
// require("./beforeLogin.php");
?>
<html lang="en">

<head>
    <title>Administrator management</title>
    <?php require("./HTMLHeader.php")?>
</head>

<body>
    <!-- Confirm delete modal -->
    <div class="modal fade" id="confirm-remove" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure want to remove this class?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-block btn-danger" id="remove">Yes</button>
                    <button class="btn btn-block btn-primary" id="nah">No</button>

                </div>
            </div>
        </div>
    </div>
    <?php require("./Success.php") ?>
    <div class="container">
        <div class="admin-header">
            <a class="title" href="./home.php">Classroom</a>
            <div class="btn btn-primary avatar header-avatar position-relative mt-1">
                <img src=<?php
                            switch ($accountInfo['role']) {
                                case 'admin':
                                    echo "./images/admin.png";
                                    break;
                                case 'student':
                                    echo "./images/student.png";
                                    break;
                                case 'teacher':
                                    echo "./images/teacher.png";
                                    break;
                            }
                            ?> alt="">

            </div>
            <div class="infoCollapse">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?= $accountInfo['full_name'] ?></li>
                    <li class="list-group-item d-flex change-page" id="go-to-admin">
                        <a href="./home.php" class="w-100 d-flex">
                            <i><img src="./images/classroom.png" alt=""></i>Go to home page
                        </a>
                    </li>
                    <li class="list-group-item d-flex change-page" id="logout">
                        <i><img src="./images/logout.png" alt=""></i>Log out
                    </li>
                </ul>
            </div>
        </div>
        <div class="row class mb-5">
            <div class="col-12 table-responsive-md">
                <table class="admin-table classList">
                    <tr class="admin-table-title">
                        <th class="title text-center admin-table-title" colspan="7">Classroom</th>
                    </tr>
                    <tr class="row-head">
                        <td class="column-head">Index</td>
                        <td class="column-head">Class name</td>
                        <td class="column-head">Course name</td>
                        <td class="column-head">Class code</td>
                        <td class="column-head">Teacher</td>
                        <td class="column-head">Room</td>
                        <td class="column-head">Remove</td>
                    </tr>
                    <?php
                    $classList = getAll('classroom');
                    $i = 1;
                    while ($personClass = $classList->fetch_assoc()) {
                    ?>
                        <tr class="row-body" code=<?= $personClass['class_code']; ?>>
                            <td class="h5 class-index column-body">
                                <?= $i++ ?>
                            </td>
                            <td class="column-body">
                                <input class="w-100 admin-edit-class-input class-name" type="text" code=<?= $personClass['class_code']; ?> value="<?= $personClass['class_name'] ?>">
                            </td>
                            <td class="column-body">
                                <input class="w-100  admin-edit-class-input course-name" type="text" code=<?= $personClass['class_code']; ?> value="<?= $personClass['course_name'] ?>">
                            </td>
                            <td class="column-body class-code">
                                <?= $personClass['class_code']; ?>
                            </td>
                            <td class="column-body">
                                <?= getAccountByEmail($personClass['teacher'])['full_name'] ?>
                            </td>
                            <td class="column-body">
                                <input class="w-100  admin-edit-class-input room" type="text" code=<?= $personClass['class_code']; ?> value="<?= $personClass['room']; ?>">
                            </td>
                            <td class="column-body icon-class remove-class-in-admin" code=<?= $personClass['class_code']; ?>>
                                <button class="btn btn-danger">Remove</button>
                            </td>

                        </tr>

                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive-md">
                <table class="admin-table">
                    <tr class="admin-table-title">
                        <th class="title text-center admin-table-title" colspan="6">People</th>
                    </tr>
                    <tr class="admin-table-row row-head">
                        <td class="column-head">Index</td>
                        <td class="column-head">Name</td>
                        <td class="column-head">Email</td>
                        <td class="column-head">Phone</td>
                        <td class="column-head">Role</td>
                        <td class="column-head">Date of Birth</td>
                        <!-- <td class="column-head">Remove</td> -->
                    </tr>
                    <?php
                    $people = getAll('account');
                    $i = 1;
                    while ($person = $people->fetch_assoc()) {
                        if ($person['email'] == $_SESSION['email'])
                            continue;
                    ?>
                        <tr class="admin-table-row row-body">

                            <td class="h5 people-index column-body">
                                <?= $i++ ?>
                            </td>
                            <td class="column-body">
                                <?= $person['full_name']; ?>
                            </td>
                            <td class="column-body people-email">
                                <?= $person['email']; ?>
                            </td>
                            <td class="column-body">
                                <?= $person['phone']; ?>
                            </td>
                            <td class="column-body">
                                <form action="" class="change-role m-0">
                                    <input type="hidden" name='email' value=<?= $person['email'] ?>>
                                    <select name='role' class="custom-select select-role">
                                        <option value='student' <?= $person['role'] == 'student' ? 'selected' : '' ?>>Student</option>
                                        <option value="pending" disabled <?= $person['role'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="teacher" <?= $person['role'] == 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                        <option value="admin" <?= $person['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td class="column-body">
                                <?= $person['date_of_birth']; ?>
                            </td>
                            <!-- <td class="column-body icon-class remove-people">
                                <img src="./images/remove.png" alt="">
                            </td> -->
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</body>

</html>