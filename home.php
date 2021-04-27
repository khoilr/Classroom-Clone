<?php
require("./AllFunction.php");
if (!isset($_SESSION['email']))
    header("Location: login.php");
?>
<html lang="en">

<head>
    <?php
    require("./HTMLHeader.php")
    ?>
    <title>Home</title>
</head>

<body>
    <?php require("./Success.php") ?>
    <div class="container">
        <!--#################################################-->
        <?php require("./header.php"); ?>
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search your class" email=<?= $_SESSION['email'] ?>>
            <ul class="list-group result-list">
                <!-- <li class="list-group-item result-item">Cras justo odio</li>
                    <li class="list-group-item result-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item result-item">Morbi leo risus</li>
                    <li class="list-group-item result-item">Porta ac consectetur ac</li>
                    <li class="list-group-item result-item">Vestibulum at eros</li> -->
            </ul>
        </div>
        <div class="your-class">
            <?php
            $email = $_SESSION['email'];
            $classList = getClassesByTeacher($email);
            if ($classList->num_rows != 0) {
                echo '<h5 class="foo">Your classes</h5>';
                while ($class = $classList->fetch_assoc()) {
                    $classCode = $class['class_code']; ?>
                    <div class="row class-card mb-3">
                        <div class="real-class" code="<?= $classCode ?>">
                            <div class="col-md-3 px-0 class-image-container">
                                <img class="class-image" src=<?= $class['class_image'] ?> alt="Card image cap">
                            </div>
                            <div class="col-md-9 col-12 px-0 info-class-container">
                                <?php require("./InfoClassHeader.php"); ?>
                                <div class="horizontal-line"></div>
                                <?php
                                $classwork = getAllClassworkByClassCode($classCode);
                                if ($classwork->num_rows == 0)
                                    echo "<p class='p-3'>Not thing to work right now</p>";
                                else {
                                ?>
                                    <div class="classwork-container info-class">
                                        <h4 class="info-class-title">Classwork</h4>
                                        <ul class="list-group list-group-flush classwork-list">
                                            <?php
                                            while ($bar = $classwork->fetch_assoc()) {
                                            ?>
                                                <li class="list-group-item classwork-item" code=<?= $bar['classwork_code'] ?>>
                                                    <!-- <a href="https://fb.com" class="d-flex"> -->
                                                    <?= $bar['title'] ?>
                                                    <!-- </a> -->
                                                </li>
                                            <?php
                                            } ?>
                                        </ul>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
        <div class="your-attendance">
            <?php
            $classList = getAttendancesByStudent($email);
            if ($classList->num_rows != 0) {
                echo '<h5 class="foo">Your attendances</h5>';
                while ($foo = $classList->fetch_assoc()) {
                    $classCode = $foo['class_code'];
                    $class = getClassByClassCode($classCode);
            ?>
                    <div class="row class-card mb-3">
                        <div class="real-class" code="<?= $classCode ?>">
                            <div class="col-md-3 px-0 class-image-container">
                                <img class="class-image" src="<?= $class['class_image'] ?>" alt="Card image cap">
                            </div>
                            <div class="col-md-9 col-12 px-0 info-class-container">
                                <?php require("./InfoClassHeader.php"); ?>
                                <div class="horizontal-line"></div>
                                <?php
                                if ($foo['status'] == 'current') {
                                    $classwork = getAllClassworkByClassCode($classCode);
                                    if ($classwork->num_rows == 0)
                                        echo "<p class='p-3'>Not thing to work right now</p>";
                                    else {
                                ?>
                                        <div class="classwork-container info-class">
                                            <h4 class="info-class-title">Classwork</h4>
                                            <ul class="list-group list-group-flush classwork-list">
                                                <?php
                                                while ($bar = $classwork->fetch_assoc()) {
                                                ?>
                                                    <li class="list-group-item classwork-item" code=<?= $bar['classwork_code'] ?>>
                                                        <?= $bar['title'] ?>
                                                    </li>
                                                <?php
                                                } ?>
                                            </ul>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($foo['status'] == 'student-pending') {
                        ?>
                            <div class="disable-class-card">
                                <p class="approve">Join this class?</p>
                                <div class="break"></div>
                                <div class="chosen">
                                    <button class="btn mr-3 btn-approve btn-primary " code="<?= $classCode ?>" email="<?= $_SESSION['email'] ?>">Accept</button>
                                    <button class=" btn btn-approve btn-danger " code="<?= $classCode ?>" email="<?= $_SESSION['email'] ?>">Decline</button>
                                </div>
                            </div>
                        <?php
                        } elseif ($foo['status'] == 'teacher-pending') { ?>
                            <div class="disable-class-card">
                                <p class="approve">Waiting for an approvement from teacher</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>

</html>