<?php $accountInfo = getAccountByEmail($_SESSION['email']); ?>
<nav class="navbar navbar-expand-lg navbar-light mb-3">
    <a class="navbar-brand title" href="http://localhost/Assignments/DoAnCuoiKi/">Classroom</a>
    <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php
            switch ($accountInfo['role']) {
                case 'student':
                    echo
                        '<li class="nav-item mt-1 mb-1">
                                    <form action="" id="request-teacher" class="m-0">
                                        <input type="hidden" name="email-request" value=' . $_SESSION["email"] . ' >
                                        <button type="submit" class="btn-class btn btn-student d-flex mr-3">
                                            <i><img src="./images/BecomeTeacher.png" alt=""></i>
                                            Become a teacher
                                        </button>
                                    </form>
                                </li>';
                    break;
                case 'pending':
                    echo
                        '<li class="nav-item mt-1 mb-1">
                                    <button class="btn-class btn btn-student d-flex mr-3 justify-content-center" disabled>
                                        <i><img src="./images/BecomeTeacher.png" alt=""></i>
                                        Request sent
                                    </button>
                                </li>';
                    break;
                default:
                    echo
                        '<li class="nav-item mt-1 mb-1">
                                    <button class="btn-class btn btn-primary d-flex mr-3 justify-content-center" data-toggle="modal" data-target="#create-new-class-modal">
                                        <i><img src="./images/add.png" alt=""></i>
                                        Create new class
                                    </button> 
                                </li>';
                    break;
            }
            ?>
            <li class="nav-item mt-1 mb-1 d-flex">
                <button class=" btn-class btn btn-primary d-flex justify-content-center" data-toggle="modal" data-target="#join-class-modal">
                    <i><img src="./images/participation.png" alt=""></i>
                    Join by class code
                </button> </li>
        </ul>
        <div class="btn btn-primary avatar header-avatar position-relative mt-1">
            <img src="<?php setAvatarByRole($_SESSION['email']) ?>" alt="">

        </div>
        <div class="infoCollapse">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?= $accountInfo['full_name']; ?></li>
                <?= $accountInfo['role'] == 'admin' ? '<li class="list-group-item d-flex change-page" id="go-to-admin">
                        <a href="./admin.php" class="w-100 d-flex">
                            <i><img src="./images/management.png" alt=""></i>Go to admin page
                            </a>
                        </li>' : "" ?>
                <li class="list-group-item d-flex change-page" id="logout">
                    <i><img src="./images/logout.png" alt=""></i>Log out
                </li>
            </ul>
        </div>

    </div>

</nav>
<!-- Create class modal -->
<div class="modal fade" id="create-new-class-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create new class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-class" enctype="multipart/form-data">
                    <div class=" form-group">
                        <input type="text" class="form-control create-class-input" id="class-name" name="className">
                        <label for="class-name">Class name</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control create-class-input" id="course-name" name="courseName">
                        <label for="course-name">Course name</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control create-class-input" id="room" name="room">
                        <label for="room">Room</label>
                    </div>
                    <div class="form-group ">
                        <input type="file" class="form-control create-class-input" id="class-image" name="classImage" accept="image/*"> <label for="class-image">Class image</label>
                    </div>
                    <div class="form-group invalid-input-field">
                        <p class='invalid-input blank-input'></p>
                    </div>
                    <input type="hidden" name="hiddenTeacher" value="<?= $_SESSION['email'] ?>">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary ml-auto d-block ">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Join class modal -->
<div class="modal fade" id="join-class-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Join class by class code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="join-class">
                    <div class="form-group">
                        <input type="text" class="form-control join-class-input" id="classCode" name="classCode">
                        <label for="classCode">Class code</label>
                    </div>
                    <div class="form-group invalid-input-field">
                        <p class='invalid-input invalid-code'></p>
                        <p class='invalid-input blank-input'></p>
                    </div>
                    <input type="hidden" name="hiddenStudent" value="<?= $_SESSION['email'] ?>">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary ml-auto d-block ">Join</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>