<div class="info-class d-flex p-0">
    <div class="class-course" code=<?= $classCode ?>>
        <h2 class='class-name'><?= $class['class_name'] ?></h2>
        <h3 class='course-name '><?= $class['course_name'] ?></h3>
        <h4 class='room'><?= $class['room'] ?></h4>
    </div>
    <div class="teacher-code">
        <h2 class='teacher-name'><?= getAccountByEmail($class['teacher'])['full_name'] ?></h2>
        <h3 class='class-code'><?= $classCode ?></h3>
    </div>
</div>