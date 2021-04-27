<?php
require("./conn.php");
require("./AllFunction.php");
$classworkCode = $_GET['code'];
$classCode = explode('_', $classworkCode)[0];
if ((!isParticipated($_SESSION['email'], $classCode) && !isTeacher($classCode, $_SESSION['email'])) || !isClassworkExist($classworkCode))
    header("Location: home.php");
$classCode = explode('_', $classworkCode)[0];
$class = getClassByClassCode($classCode);
$classwork = getClassworkByCode($classworkCode)->fetch_assoc();
?>
<html lang="en">

<head>
    <?php
    require("./HTMLHeader.php")
    ?>
    <title>Classwork: <?= $classwork['title'] ?></title>
</head>

<body>
    <?php require("./Success.php") ?>
    <div class="container">
        <?php require("./header.php"); ?>
        <div class="row">
            <!--info-class-header.php-->
            <?php require("./InfoClassHeader.php") ?>
            <div class="horizontal-line"></div>
            <div class="info-class">
                <div class="classwork">
                    <h2 class='info-class-title mt-3'><?= $classwork['title'] ?></h2>
                    <?= !empty($classwork['description']) ? '<p class="classwork-text">' . $classwork['description'] . '</p>' : '' ?>
                    <!-- <p class="classwork-text">Hôm nay thầy bận đi công tác nên lớp chúng ta được nghỉ</p> -->
                </div>
                <?php if (!empty($classwork['file'])) {
                    $filename = end(explode('/', $classwork['file'])); ?>
                    <ul class="list-inline classwork-file-container">
                        <a href="<?= $classwork['file'] ?>" download="<?= $filename ?>">
                            <li class="list-inline-item classwork-file">
                                <h3 class="file-name"><?= $filename ?></h3>
                                <p class="file-size">
                                    <?php
                                    $size = filesize($classwork['file']);
                                    if ($size >= 1073741824) {
                                        $size = number_format($size / 1073741824, 2) . ' GB';
                                    } elseif ($size >= 1048576) {
                                        $size = number_format($size / 1048576, 2) . ' MB';
                                    } elseif ($size >= 1024) {
                                        $size = number_format($size / 1024, 2) . ' KB';
                                    } elseif ($size > 1) {
                                        $size = $size . ' size';
                                    } elseif ($size == 1) {
                                        $size = $size . ' byte';
                                    } else {
                                        $size = '0 size';
                                    }
                                    echo $size ?>
                                </p>
                            </li>
                        </a>
                    </ul>
                <?php
                }
                ?>
                <div class="horizontal-line"></div>
                <div class="classwork-comment info-class">
                    <ul class='list-group'>
                        <?php
                        $comments = getAllCommentsByClassworkCode($classworkCode);
                        if ($comments->num_rows != 0) {
                            while ($foo = $comments->fetch_assoc()) {
                        ?>
                                <li class="list-group-item">
                                    <div class="avatar">
                                        <img src="<?php setAvatarByRole($foo['email']) ?>" alt="" class="comment-avatar">
                                    </div>
                                    <div class="comment-container">
                                        <h3 class="student"><?= getAccountByEmail($foo['email'])['full_name'] ?></h3>
                                        <p class="comment"><?= $foo['content'] ?></p>
                                    </div>
                                    <?php if (isTeacher($classCode, $_SESSION['email'])) { ?>
                                        <div class="remove-comment" code="<?= $foo['comment_code'] ?>">
                                            <img src="./images/remove.png" alt="" srcset="">
                                        </div>
                                    <?php } ?>
                                </li>
                        <?php }
                        } ?>
                        <li class="list-group-item">
                            <div class="avatar">
                                <img src="<?php setAvatarByRole($_SESSION['email']) ?>" alt="" class="comment-avatar">
                            </div>
                            <form action="" id="comment" class="m-0 w-100">
                                <div class="form-group m-0 d-flex">
                                    <input type="text" class="form-control d-inline comment-input" name="student-comment" placeholder="Write your comment">
                                    <input type="hidden" name="classwork" value=<?= $classworkCode ?>>
                                    <input type="hidden" name="email" value=<?= $_SESSION['email'] ?>>
                                    <button type='submit' class="btn btn-comment">
                                        <img src="./images/send.png" alt="">
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>