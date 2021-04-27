<?php
require("./AllFunction.php");
$classCode = $_GET['code'];
$email = $_SESSION['email'];
$isTeacher = isTeacher($classCode, $email);
if (!$isTeacher && !isParticipated($email, $classCode))
    header("Location: home.php");
$class = getClassByClassCode($classCode);
$account = getAccountByEmail($_SESSION['email']);
?>
<html lang="en">


<head>
    <?php
    require("./HTMLHeader.php")
    ?>
    <title>Class: <?= $class['class_name'] ?></title>
</head>

<body>
    <?php require("./Success.php") ?>
    <div class="container">
        <?php require("./header.php"); ?>
        <div class="row">
            <!--info-class-header.php-->
            <?php require("./InfoClassHeader.php") ?>
            <?php if ($isTeacher) { ?>
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
                <!-- Edit class modal -->
                <div class="modal fade" id="edit-class-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit this class</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="edit-class">
                                    <div class=" form-group">
                                        <input type="text" class="form-control edit-class-input" id="class-name" name="className" value="<?= $class['class_name'] ?>">
                                        <label for="class-name">Class name</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control edit-class-input" id="course-name" name="courseName" value="<?= $class['course_name'] ?>">
                                        <label for=" course-name">Course name</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control edit-class-input" id="room" name="room" value="<?= $class['room'] ?>">
                                        <label for="room">Room</label>
                                    </div>
                                    <div class="form-group invalid-input-field">
                                        <p class='invalid-input blank-input'></p>
                                    </div>
                                    <input type="hidden" name="class-code" value="<?= $classCode ?>">
                                    <!-- <input type="hidden" name="old-class-name">
                                <input type="hidden" name="old-class-course">
                                <input type="hidden" name="old-room"> -->
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary ml-auto d-block ">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary my-3 mr-3" data-toggle="modal" data-target="#edit-class-modal">
                    Edit this class
                </button>
                <button class="btn btn-danger  my-3 remove-class-in-class" data-toggle="modal" data-target="#confirm-remove" code=<?= $classCode ?>>
                    Delete this class
                </button>
            <?php
            }
            ?>
            <div class="horizontal-line"></div>
        </div>
        <div class="row">
            <ul class="nav nav-tabs nav-class" role="tablist">
                <li role="presentation" class="title active">
                    <a href="#classwork" aria-controls="classwork" role="tab" class="active" data-toggle="tab">Classwork</a>
                </li>
                <li role="presentation" class="title">
                    <a href="#people" aria-controls="people" role="tab" data-toggle="tab">Student</a>
                </li>
            </ul>
            <div class="tab-content w-100">
                <div role="tabpanel" class="tab-pane active" id="classwork">
                    <?php if ($isTeacher) { ?>

                        <button class="btn-class btn btn-primary d-flex mr-3 justify-content-center" data-toggle="modal" data-target="#add-classwork-modal">
                            <i><img src="./images/add.png" alt=""></i>
                            Add classwork
                        </button>
                        <!--Add classwork-->
                        <div class="modal fade" id="add-classwork-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add classwork</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" id="add-classwork" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="text" class="form-control classwork-input" id="classwork-title" name="title">
                                                <label for="classwork-title">Title</label>
                                            </div>
                                            <div class="form-group">
                                                <textarea type="text" class="form-control  classwork-input" id="description" name="description"></textarea>
                                                <label for="description">Description</label>
                                            </div>
                                            <div class="form-group ">
                                                <input type="file" class="form-control classwork-input" id="classwork-file" name="classwork-file">
                                                <label for="classwork-file">Files</label>
                                            </div>
                                            <div class="form-group invalid-input-field">
                                                <p class='invalid-input blank-input'></p>
                                            </div>
                                            <!--Class code-->
                                            <input type="hidden" name="class-code" value="<?= $classCode ?>">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-primary ml-auto d-block">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="classwork-table">
                        <?php
                        $classwork = getAllClassworkByClassCode($classCode);
                        if ($classwork->num_rows == 0) {
                            echo "<p class='mt-3'>No classwork to show</p>";
                        } else {
                            if ($isTeacher) { ?>
                                <table class="teacher-table mt-3">
                                    <tr class="teacher-table-row row-head">
                                        <td class="column-head">Index</td>
                                        <td class="column-head">Classwork</td>
                                        <td class="column-head">Edit</td>
                                        <td class="column-head">Remove</td>
                                    </tr>
                                    <?php

                                    $i = 1;
                                    while ($foo = $classwork->fetch_assoc()) {
                                    ?>
                                        <tr class="teacher-table-row row-body classwork-row" code=<?= $foo['classwork_code'] ?>>
                                            <td class="h6 classwork-index column-body">
                                                <?= $i++ ?>
                                            </td>
                                            <td class="column-body">
                                                <?= $foo['title'] ?>
                                            </td>
                                            <td class="column-body icon-class">
                                                <button class="btn btn-primary edit-classwork" data-toggle="modal" data-target="#edit-classwork-modal" title="<?= $foo['title'] ?>" description="<?= $foo['description'] ?>">
                                                    Edit
                                                </button>
                                            </td>
                                            <td class="column-body icon-class">
                                                <button class="btn btn-danger remove-classwork">Remove</button>
                                            </td>
                                        </tr>

                                    <?php
                                    } ?>
                                </table>
                                <div class="modal fade" id="edit-classwork-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit classwork</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="edit-classwork-form">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control classwork-input" id="classwork-title-edit" name="title">
                                                        <label for="classwork-title-edit">Title</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea type="text" class="form-control classwork-input" id="description-edit" name="description"></textarea>
                                                        <label for="description-edit">Description</label>
                                                    </div>
                                                    <div class="form-group invalid-input-field">
                                                        <p class='invalid-input blank-input'></p>
                                                    </div>
                                                    <!--Classwork code-->
                                                    <input type="hidden" name="classwork-code" id="classwork-code">
                                                    <div class="form-group mb-0">
                                                        <button type="submit" class="btn btn-primary ml-auto d-block">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } else { ?>
                                <ul class="list-group list-group-flush student-list">
                                    <?php
                                    while ($bar = $classwork->fetch_assoc()) {
                                        if ($bar['status'] == current)
                                    ?>
                                        <li class="list-group-item  border-info border  classwork-item" code=<?= $bar['classwork_code'] ?>><?= $bar['title'] ?></li>
                                    <?php
                                    } ?>
                                </ul>
                            <?php
                            } ?>
                        <?php
                        } ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="people">
                    <?php if ($isTeacher) { ?>
                        <button class="btn-class btn btn-primary d-flex mr-3 justify-content-center" data-toggle="modal" data-target="#add-student-modal">
                            <i><img src="./images/add.png" alt=""></i>
                            Add student
                        </button>
                        <!--Add student-->
                        <div class="modal fade" id="add-student-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add student</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post" id="add-student" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="email" class="form-control" id="student-email" name="student-email">
                                                <label for="student-email">Student's email</label>
                                            </div>
                                            <input type="hidden" name="class-code" value=<?= $classCode ?>>
                                            <input type="hidden" name="teacher" value=<?= $_SESSION['email'] ?>>
                                            <div class="form-group invalid-input-field">
                                                <p class='invalid-input blank-input'></p>
                                                <p class='invalid-input add-student-error'></p>
                                            </div>
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-primary ml-auto d-block">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="student-table">
                        <?php
                        $attendances = getStudentsByClassCode($classCode);
                        if ($attendances->num_rows == 0)
                            echo "<p class='mt-3'>No student join your class</p>";
                        else {
                            if ($isTeacher) { ?>
                                <table class="teacher-table mt-3">
                                    <tr class="teacher-table-row row-head">
                                        <td class="column-head">Index</td>
                                        <td class="column-head">Student's name</td>
                                        <td class="column-head">Status</td>
                                        <td class="column-head">Remove</td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    while ($foo = $attendances->fetch_assoc()) {
                                    ?>
                                        <tr class="teacher-table-row row-body" code=<?= $classCode ?>>
                                            <td class="h6 student-index column-body">
                                                <?= $i++ ?>
                                            </td>
                                            <td class="column-body">
                                                <?= getAccountByEmail($foo['email'])['full_name'] ?>
                                            </td>
                                            <td class="column-body status">
                                                <?php if ($foo['status'] == 'teacher-pending') { ?> <div class="chosen">
                                                        <button class="btn mr-3 btn-approve btn-primary" code="<?= $classCode ?>" email="<?= $foo['email'] ?>">Accept</button>
                                                        <button class=" btn btn-approve btn-danger" code="<?= $classCode ?>" email="<?= $foo['email'] ?>">Decline</button>
                                                    </div>
                                                <?php } else
                                                    switch ($foo['status']) {
                                                        case 'current':
                                                            echo "Joined";
                                                            break;

                                                        case 'student-pending':
                                                            echo "Student pending";
                                                            break;
                                                    } ?>
                                            </td>
                                            <td class="column-body icon-class">
                                                <button class="btn btn-danger remove-student" email=<?= getAccountByEmail($foo['email'])['email'] ?>>Remove</button>
                                            </td>
                                        </tr>
                                    <?php }
                                    echo "</table>";
                                } else { ?>
                                    <ul class="list-group list-group-flush student-list">
                                        <?php
                                        while ($bar = $attendances->fetch_assoc()) {
                                        ?>
                                            <li class="list-group-item border-info border">
                                                <img src="<?php setAvatarByRole($bar['email']) ?>" alt="" class="student-avatar">
                                                <p class='student-name'>
                                                    <?= getAccountByEmail($bar['email'])['full_name'] ?>
                                                </p>
                                            </li>
                                        <?php } ?>
                                <?php }
                            } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>