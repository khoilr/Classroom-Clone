$(document).ready(function () {
    const invalidBorder = "2px #cc3300 solid";
    const border = "#86a8e7 solid 1px";
    let password = "";
    function inValidPasswordBorder() {
        $("#passwordRegistry").css("border", invalidBorder);
        $("#confirmPassword").css("border", invalidBorder);
    }
    function validPasswordBorder() {
        $("#passwordRegistry").css("border", border);
        $("#confirmPassword").css("border", border);
    }
    function displayInvalid() {
        $(".invalid-input-field").css("display", "block");
    }

    function nonDisplayInvalid() {
        $(".invalid-input-field").css("display", "none");
    }
    function checkInputFilled() {
        $(".form-control").each(function (index, element) {
            if ($(this).attr("id") != "passwordRegistry" || $(this).attr("id") != "confirmPassword") {
                console.log($(this).attr("name"));
                if ($(this).val().trim() == "") {
                    displayInvalid();
                    $(".blank-input").html("Input field could not be blank");
                    $(this).css("border", invalidBorder);
                }
            }
        });
    }
    function passwordCheck() {
        let passwordInvalidMessage = $("#invalid-password");
        const notMatch = "Password does not match";
        const lessThan6 = "Password must contain at least 6 characters";
        $("#passwordRegistry").focusout(function (e) {
            if (password.length < 6) {
                displayInvalid();
                passwordInvalidMessage.html(lessThan6);
                inValidPasswordBorder();
            }
        });
        $("#passwordRegistry").keyup(function (e) {
            password = $(this).val();
            if (password.length >= 6) {
                if ($("#confirmPassword").val() == "") {
                    passwordInvalidMessage.html("");
                    validPasswordBorder();
                }
                if ($("#confirmPassword").val() != password) {
                    passwordInvalidMessage.html(notMatch);
                    inValidPasswordBorder();
                    displayInvalid();
                }
            }
        });
        $("#confirmPassword").keyup(function (e) {
            let confirm = $(this).val();
            if (password.length >= 6) {
                if (confirm != password) {
                    passwordInvalidMessage.html(notMatch);
                    inValidPasswordBorder();
                } else {
                    passwordInvalidMessage.html("");
                    validPasswordBorder();
                    invalidField();
                }
            } else {
                passwordInvalidMessage.html(lessThan6);
                inValidPasswordBorder();
            }
        });
    }
    function timeOut(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    passwordCheck();
    $(".form-control").each(function (index, element) {
        const elementValue = $(element).val().trim();
        if (elementValue != "") $(this).addClass("filledInput");
    });
    /*************************
     * General 
    *************************/
    $('input:file').change(function (e) {
        let filePath = $(this).val();
        if (filePath != '')
            $(this).addClass("filledInput");
        invalidField();
    })

    $(".form-control").focusout(function (e) {
        // console.log(this.val());
        // console.log(this.val().trim());
        if ($(this).attr("type") == "file")
            return;
        if ($(this).attr('name') == "student-comment")
            return;
        if ($(this).hasClass("classwork-input"))
            return;
        if ($(this).attr('name') == "student-email")
            return;
        if ($(this).val().trim() == "" /*&& $(this).parent().parent().prop("id") != "new-class" && $(this).parent().parent().prop("id") != "join-class"*/) {
            $(this).css("border", invalidBorder);
            $(".blank-input").html("Input field could not be blank")
            displayInvalid();
        }
        else
            $(".blank-input").html("");
        invalidField();
    });
    $('.select-role').change(function (e) {
        e.preventDefault();
        let dataInput = $(this).parent().serializeArray();
        dataInput.push({ 'name': 'action', 'value': 'change-role' })
        console.log(dataInput);
        $.post("admin.php", dataInput,
            function (data, status) {
                // console.log(data);
            },
            "json"
        );
    });
    // function haveInvalid() {
    //     let haveInvalid = true;
    //     $(".invalid-input").toArray().forEach(element => {
    //         if ($(element).html() != "") {
    //             haveInvalid = false;
    //             console.log($(element).html())
    //         }
    //     });
    //     if (haveInvalid)
    //         nonDisplayInvalid();
    // }
    function invalidField() {
        bar = true;
        let invalid = $('.invalid-input');
        invalid.toArray().forEach(element => {
            if ($(element).html() != "")
                bar = false;
        });
        if (bar)
            nonDisplayInvalid();
    }
    $(".form-control").focus(function (e) {
        $(this).css("border", border);
    });
    $(".form-control").keyup(function (e) {
        // let inputArray = $(".form-control").toArray();
        // inputArray.forEach(element => {
        // });
        $(".blank-input").html('');
        invalidField();
        $(this).css("border", border);
        let a = $(this).val();
        a = a.trim();
        a != "" ? $(this).addClass("filledInput") : $(this).removeClass("filledInput");
    });
    /*************************
     * Registry
    *************************/
    $("#userNameRegistry").focusout(function (e) {
        let user = $(this).val();
        $.post("isUserRegistered.php",
            { user: user },
            function (data, status) {
                if (data > 0) {
                    $("#invalid-user").html("This user name is already registered");
                    $("#userNameRegistry").css("border", invalidBorder);
                    displayInvalid();
                }
                else {
                    $("#invalid-user").html("");
                    invalidField();
                }
            }
        );
    });
    $("#emailRegistry").focusout(function (e) {
        // Check email is already registered with Ajax
        let email = $(this).val();
        if (email.includes("@") && email.includes(".")) {
            $.post("isEmailRegistered.php",
                { email: email },
                function (data, status) {
                    if (data > 0) {
                        $("#invalid-email").html("This email is already registered");
                        $("#emailRegistry").css("border", invalidBorder);
                        displayInvalid();
                    }
                    else {
                        $("#invalid-email").html("");
                        invalidField();
                    }
                }
            );
        }
        else {
            $("#invalid-email").html("An email must contain @ and .");
            $(this).css("border", invalidBorder);
            displayInvalid();
        }
    });
    $("#emailRegistry").focus(function (e) {
        $("#invalid-email").html("");
        invalidField();
    });
    $('#phoneNumber').focusout(function (e) {
        let phone = $(this).val().trim();
        if (!isNaN(phone)) {
            if (phone.length != 10) {
                displayInvalid();
                $(this).css("border", invalidBorder);
                $('#invalid-phone').html("The length of the phone number should be 10");
                if (phone[0] != 0) {
                    $('#invalid-phone').html("Phone number must be start with 0");
                }
            }
            else {
                $("#invalid-phone").html("");
                invalidField();
            }
        }
        else {
            displayInvalid();
            $(this).css("border", invalidBorder);
            $('#invalid-phone').html("Incorrect phone number format");
        }
    });
    $('#phoneNumber').focus(function (e) {
        $("#invalid-phone").html("");
        invalidField();
    });
    $("#registryForm").submit(function (e) {
        e.preventDefault();
        // function allow() {
        //     allow = true;
        //     let invalid = $('.invalid-input');
        //     invalid.toArray().forEach(element => {
        //         if ($(element).html() != "")
        //             allow = false;
        //     });
        //     return allow;
        // }
        checkInputFilled();
        if (allow()) {
            let dataInput = $(this).serializeArray();
            $.post("registry.php", dataInput,
                async function (data, status) {
                    if (data['code'] == 1) {
                        $(".success-create-field").css("display", "block");
                        $(".success-create").html(data['message']);
                        await timeOut(3000);
                        window.location = './login.php';
                    }
                },
                "json"
            );
        }
    });
    /*************************
     * Login
    *************************/
    $("#loginForm").submit(function (e) {
        e.preventDefault();
        function error(message) {
            displayInvalid();
            $(".invalid-input").html(message);
        }
        let dataInput = $(this).serializeArray();
        let email = $('#emailLogin').val().trim();
        if (!email.includes("@") || !email.includes(".")) {
            error("Email format is not correct");
            if (email.length == 0) {
                error("No email entry");
                $("#emailLogin").css("border", invalidBorder);
            }
            $("#emailLogin").css("border", invalidBorder);
        }
        else
            $.post(
                "login.php",
                dataInput,
                function (data, status) {
                    switch (data['code']) {
                        case 1:
                            window.location = "./home.php";
                            break;
                        case -2:
                            $("#emailLogin").css("border", invalidBorder);
                            error(data['message']);
                            break;
                        case -3:
                            error(data['message']);
                            $("#passwordLogin").css("border", invalidBorder);
                            break;
                        default:
                            error("Unknown error, please try again later");
                    }
                },
                'json'
            );
    });
    /*************************
     * Forgot password
    *************************/
    $("#forgot").submit(function (e) {
        e.preventDefault();
        function error(message) {
            displayInvalid();
            $(".invalid-input").html(message);
        }
        $(".success-create-field").css("display", "none");
        let email = $(this).serializeArray()[0]['value'];
        if (!email.includes("@") || !email.includes(".")) {
            error("Email format is not correct");
            if (email.length == 0) {
                error("No email entry"); F
                $("#emailForgot").css("border", invalidBorder);
            }
            $("#emailForgot").css("border", invalidBorder);
        }
        else {
            error("");
            nonDisplayInvalid();
            $.post(
                "forgot.php",
                { email: email },
                function (data, status) {
                    switch (data['code']) {
                        case 1:
                            $(".success-create-field").css("display", "block");
                            $(".success-create").html(data['message']);
                            break;
                        case -2:
                            $("#emailForgot").css("border", invalidBorder);
                            error(data['message']);
                            break;
                        default:
                            $("#emailForgot").css("border", invalidBorder);
                            error(data["Unknown error"]);
                            break;
                        // case -2:
                        //     error(data['message']);
                        //     $("#passwordLogin").css("border", invalidBorder);
                        //     break;
                        // default:
                        //     error("Unknown error, please try again later");
                    }
                },
                'json'
            );
        }
    });
    /*************************
    * Reset password
    *************************/
    $("#reset").submit(function (e) {
        e.preventDefault();
        // function allow() {
        //     allow = true;
        //     let invalid = $('.invalid-input');
        //     invalid.toArray().forEach(element => {
        //         if ($(element).html() != "")
        //             allow = false;
        //     });
        //     return allow;
        // }
        checkInputFilled();
        if (allow()) {
            let dataInput = $(this).serializeArray();
            $.post("reset.php", dataInput,
                async function (data, status) {
                    if (data['code'] == 1) {
                        $(".success-create-field").css("display", "block");
                        $(".success-create").html(data['message']);
                        await timeOut(3000);
                        window.location = './login.php';
                    }
                },
                "json"
            );
        }
        $(".form-control").each(function (index, element) {
            if ($(this).val().trim() == "") {
                displayInvalid();
                $(this).css("border", invalidBorder);
                $('.invalid-input').html("No password entry");
            }
        });
        passwordCheck();
    });
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus');
    });
    // $(".header-avatar").click(function (e) {
    //     e.preventDefault();
    //     let info = $(".infoCollapse");
    //     if ($(info).width() == 0)
    //         showInfo(info);
    //     else
    //         hideInfo(info);

    // });
    $(document).on('click', '.header-avatar', function (e) {
        e.preventDefault();
        let info = $(".infoCollapse");
        if ($(info).width() == 0)
            showInfo(info);
        else
            hideInfo(info);
    })
    function showInfo(info) {
        $(info).css("width", "1000px");
        let width = $(info).children()[0].scrollWidth;
        let parentWidth = $(info).parent().width();
        if (width < 320)
            width = 320;
        if (width > parentWidth)
            width = parentWidth;
        $(info).css("width", width);
    }
    function hideInfo(info) {
        $(info).css("width", "0");
    }

    $('.infoCollapse').click(function (e) {
        // e.preventDefault();
        e.stopPropagation();
    });
    $("#logout").click(function (e) {
        e.preventDefault();
        $.post("logout.php", { action: "logout" },
            function (data, status) {
                if (data['code'] == 1)
                    window.location = "./login.php";
            }, 'json'
        );
    });
    $('.modal').on('hidden.bs.modal', function () {
        // do something…
        // e.preventDefault();
        $('.invalid-input').html('');
        invalidField();
        $('.form-control').css("border", border);
    });
    /**************************
     * Request to become teacher
     **************************/
    $("#request-teacher").submit(function (e) {
        e.preventDefault();
        let dataInput = $(this).serializeArray();
        $.post("RequestTeacher.php", dataInput,
            function (data, status) {
                if (data['code'] == 1)
                    toastNotification(data['message']);
                $('ul.navbar-nav').load(document.URL + ' ul.navbar-nav');
            },
            "json"
        );
    });
    async function toastNotification(message) {
        $('.toast-notification').css("display", "block");
        await timeOut(500);
        $(".toast-notification .success-create").html(message);
        $('.toast-notification').css("transform", "translateY(128px)");
        await timeOut(3000);
        $('.toast-notification').css("transform", "translateY(0)");
        await timeOut(500);
        $(".toast-notification .success-create").html('');
        $('.toast-notification').css("display", "none");
    }
    function allow() {
        let allow = true;
        $('.invalid-input').toArray().forEach(element => {
            if ($(element).html() != "")
                allow = false;
        });
        return allow;
    }
    /**************************
     * Create new class
     **************************/
    $(document).on('submit', '#new-class', function (e) {
        e.preventDefault();
        $(".create-class-input").toArray().forEach(element => {
            if ($(element).val().trim() == '') {
                $(element).css("border", invalidBorder);
                $("#new-class .blank-input").html("Input field could not be blank");
                displayInvalid();
            }
        });
        if (allow()) {
            let dataInput = new FormData(this);
            $.ajax({
                url: 'CreateClass.php',
                type: 'post',
                data: dataInput,
                contentType: false,
                processData: false,
                success: function (response) {
                    response = JSON.parse(response);
                    if (response['code'] == 1) {
                        $("#new-class .create-class-input").toArray().forEach(element => {
                            $(element).val('');
                            $(element).removeClass('filledInput');
                        });
                        $('button.close').click();
                        $('.modal-backdrop').remove();
                        $('.your-class').load(document.URL + ' .your-class');
                        toastNotification(response['message']);
                    }
                },
            });
        }
    });
    /**************************
     * Join class
     **************************/
    $("#join-class .join-class-input").keyup(function (e) {
        $("#join-class .invalid-code").html('');
        invalidField();
    });
    $("#join-class").submit(function (e) {
        e.preventDefault();
        $(".join-class-input").toArray().forEach(element => {
            if ($(element).val().trim() == '') {
                $(element).css("border", invalidBorder);
                $("#join-class .blank-input").html("Input field could not be blank");
                displayInvalid();
            }
        });
        if (allow()) {
            let dataInput = $(this).serializeArray();
            console.log(dataInput);
            $.post("JoinClass.php", dataInput,
                function (data, status) {
                    console.log(data);
                    if (data['code'] == 1) {
                        $('.your-attendance').load(document.URL + ' .your-attendance');
                        $(".join-class-input").toArray().forEach(element => {
                            $(element).val('');
                            $(element).removeClass('filledInput');
                        });
                        $("button.close").click();
                        $('.modal-backdrop').remove();
                        toastNotification(data['message']);
                    }
                    else {
                        $("#join-class .invalid-code").html(data['message']);
                        $("#join-class .join-class-input").css('border', invalidBorder);
                        displayInvalid();
                    }


                },
                "json"
            );
        }
    });
    $(".remove-people").click(function (e) {
        e.preventDefault();
        let foo = $(this);
        let email = $(this).parent().children('.people-email').html().trim();
        console.log(email);
        $.post("admin.php", {
            email: email,
            action: "remove-people"
        },
            function (data, status) {
                console.log(data);
                if (data['code'] == 1) {
                    let currentIndex = $(foo).siblings('.people-index').html();
                    $(foo).parent().nextAll().children(".people-index").toArray().forEach(element => {
                        $(element).html(currentIndex++);
                    });
                    $(foo).parent().remove();
                    $('.admin-table').load(document.URL + ' .admin-table');
                }
            },
            "json"
        );
    });
    $(".remove-class-in-admin").click(function (e) {
        e.preventDefault();
        $('#confirm-remove').modal('show');
        let foo = $(this);
        let code = $(this).attr('code');
        $("button#remove").click(function (e) {
            $('#confirm-remove').modal('hide');
            $.post("RemoveClass.php", {
                code: code,
            },
                function (data, status) {
                    if (data) {
                        let currentIndex = $(foo).siblings('.class-index').html();
                        $(foo).parent().nextAll().children(".class-index").toArray().forEach(element => {
                            $(element).html(currentIndex++);
                        });
                        $(foo).parent().remove();
                    }
                },
                "json"
            );
        });
        $("button#nah").click(function (e) {
            e.preventDefault();
            $('#confirm-remove').modal('hide');
        });
    });
    $('.remove-class-in-class').click(function (e) {
        e.preventDefault();
        let code = $(this).attr('code');
        $("button#remove").click(function (e) {
            $('#confirm-remove').modal('hide');
            $.post("RemoveClass.php", {
                code: code,
            },
                function (data, status) {
                    if (data) {
                        window.location = './home.php';
                    }
                },
                "json"
            );
        });
        $("button#nah").click(function (e) {
            e.preventDefault();
            $('#confirm-remove').modal('hide');
        });
    });
    $('.admin-edit-class-input').keyup(function (e) {
        let edit = '';
        let value = $(this).val();
        console.log(value);
        let code = $(this).attr('code');
        console.log(value);
        if ($(this).hasClass('class-name'))
            edit = 'class_name';
        if ($(this).hasClass('course-name'))
            edit = 'course_name';
        if ($(this).hasClass('room'))
            edit = 'room';
        $.post("EditClass.php", {
            edit: edit,
            value: value,
            code: code,
            from: "admin",
        },
            function (data, status) {
                console.log(data);
            },
            "json"
        );

    });
    $(document).on('submit', '#edit-class', function (e) {
        e.preventDefault();
        $(".edit-class-input").toArray().forEach(element => {
            if ($(element).val().trim() == '') {
                $(element).css("border", invalidBorder);
                $("#edit-class .blank-input").html("Input field could not be blank");
                displayInvalid();
            }
        });
        if (allow()) {
            let dataInput = $(this).serializeArray();
            dataInput.push({ 'name': 'from', 'value': 'teacher' })

            $.post("EditClass.php", dataInput,
                function (data, status) {
                    if (data['code'] == 1) {
                        console.log("Khoicute");
                        $("button.close").click();
                        $('.info-class').load(document.URL + ' .info-class');
                        toastNotification(data['message']);
                    }
                },
                "json"
            );
        }
    });
    // $('.remove-classwork').click(function (e) { 
    //     e.preventDefault();
    //     let code = $(this).attr("code");
    //     let foo = $(this);
    //     console.log("Hihi");
    //     console.log(code);
    //     $.post("RemoveClasswork.php", {
    //         code: code,
    //         action: "remove-classwork"
    //     },
    //         function (data, status) {
    //             console.log(data);
    //             if (data['code'] == 1) {
    //                 let currentIndex = $(foo).siblings('.classwork-index').html();
    //                 $(foo).parent().nextAll().children(".classwork-index").toArray().forEach(element => {
    //                     $(element).html(currentIndex++);
    //                 });
    //                 $(foo).parent().remove();
    //                 // $(".classwork-table").load(document.URL + " .classwork-table");
    //             }
    //         },
    //         "json"
    //     );
    // });
    $(document).on('click', '.remove-classwork', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let code = $(this).parent().parent().attr("code");
        console.log(code);
        $.post("RemoveClasswork.php", {
            code: code,
        },
            function (data, status) {
                console.log(data);
                if (data['code'] == 1) {
                    // let currentIndex = $(foo).siblings('.classwork-index').html();
                    // $(foo).parent().nextAll().children(".classwork-index").toArray().forEach(element => {
                    //     $(element).html(currentIndex++);
                    // });
                    // $(foo).parent().remove();
                    $(".classwork-table").load(document.URL + " .classwork-table");
                }
            },
            "json"
        );
    });
    $(document).on('click', '.edit-classwork', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let code = $(this).parent().parent().attr('code');
        let title = $(this).attr('title');
        let description = $(this).attr('description');
        $("#classwork-title-edit").val(title);
        $("#classwork-title-edit").addClass('filledInput');
        $("#description-edit").val(description);
        description != '' ? $("#description-edit").addClass('filledInput') : '';
        $("#classwork-code").val(code);
    });
    $(document).on('submit', '.edit-classwork-form', function (e) {
        e.preventDefault();
        let title = $("#classwork-title-edit");
        if (title.val().trim() == "") {
            displayInvalid();
            $('.blank-input').html("Title couldn't be blank");
            $(title).css('border', invalidBorder);
        } else {
            let dataInput = $(this).serializeArray();
            console.log(dataInput);
            $.post("EditClasswork.php", dataInput,
                function (data, status) {
                    if (data) {
                        $("button.close").click();
                        $(".modal-backdrop").remove();
                        $(".classwork-table").load(document.URL + " .classwork-table");
                    }
                },
                "json"
            );
        }
    });
    $(document).on('click', '.classwork-row', function (e) {
        e.preventDefault();
        let code = $(this).attr("code");
        console.log(code);
        window.location = './classwork.php?code=' + code;
    })
    $(document).on('click', '.remove-student', function (e) {
        e.preventDefault();
        let code = $(this).parent().parent().attr("code");
        let email = $(this).attr("email");
        $.post("RemoveStudent.php", {
            code: code,
            email: email
        },
            function (data, status) {
                console.log(data);
                if (data['code'] == 1)
                    $(".student-table").load(document.URL + " .student-table");
            },
            "json"
        );
    })
    $(".nav-class a").click(function (e) {
        $('.nav-class li').toArray().forEach(element => {
            $(element).removeClass('active');
        });
        $(this).parent().addClass("active");

    });
    $(document).on('submit', '#comment', function (e) {
        e.preventDefault();
        if ($('input[name = "student-comment"]').val().trim() == '')
            return;
        let dataInput = $(this).serializeArray();
        $.post("PostComment.php", dataInput,
            function (data, status,) {
                console.log(data);
                if (data) {
                    $('input[name = "student-comment"]').empty();
                    $(".classwork-comment").load(document.URL + ' .classwork-comment');
                }
            }
        );

    });
    // $("#comment").submit(function (e) {
    //     e.preventDefault();
    //     if ($('input[name = "student-comment"]').val().trim() == '')
    //         return;
    //     let dataInput = $(this).serializeArray();
    //     $.post("PostComment.php", dataInput,
    //         function (data, status,) {
    //             console.log(data);
    //             if (data) {
    //                 $('input[name = "student-comment"]').empty();
    //                 $(".classwork-comment").load(document.URL + ' .classwork-comment');
    //             }
    //         }
    //     );

    // });
    $('textarea.form-control').keyup(function (e) {
        let scrollHeight = this.scrollHeight;
        if (scrollHeight > 160)
            scrollHeight = 160;
        console.log(scrollHeight);
        $(this).css('height', scrollHeight);
    });
    $(document).on('click', '.real-class', function (e) {
        code = $(this).attr('code');
        console.log(code);
        window.location = "./class.php?code=" + code;
    });
    $(document).on('click', '.result-item', function (e) {
        code = $(this).attr('code');
        window.location = "./class.php?code=" + code;
    });
    $(document).on('click', '.classwork-item', function (e) {
        e.preventDefault();
        e.stopPropagation();
        code = $(this).attr('code');
        window.location = "./classwork.php?code=" + code;
    });
    $("#add-classwork").submit(function (e) {
        e.preventDefault();
        let title = $("#classwork-title");
        if (title.val().trim() == "") {
            displayInvalid();
            $('.blank-input').html("Title couldn't be blank");
            $(title).css('border', invalidBorder);
        } else {
            let dataInput = new FormData(this);
            $.ajax({
                url: 'AddClasswork.php',
                type: 'post',
                data: dataInput,
                contentType: false,
                processData: false,
                success: function (response) {
                    response = JSON.parse(response);
                    if (response['code'] == 1) {
                        $("#add-classwork .classwork-input").toArray().forEach(element => {
                            $(element).val('');
                            $(element).removeClass('filledInput');
                        });
                        $("button.close").click();
                        $('.modal-backdrop').remove();
                        toastNotification(response['message']);
                        $('.classwork-table').load(document.URL + ' .classwork-table');
                    }
                }
            });
        }

    });
    $("#add-student").submit(function (e) {
        e.preventDefault();
        let foo = $("#student-email");
        let email = $(foo).val().trim();
        if (!email.includes('@') || !email.includes('.')) {
            $('.blank-input').html("An email must contain @ and .");
            $(foo).css('border', invalidBorder);
            displayInvalid();
            if (email == '')
                $('.blank-input').html("Please entry your student email");
        }
        else {
            let inputData = $(this).serializeArray();
            $.post("AddStudent.php", inputData,
                function (data, status) {
                    if (data['code'] == 1) {
                        $("button.close").click();
                        $(".modal-backdrop").remove();
                        toastNotification(data['message']);
                        $(".student-table").load(document.URL + ' .student-table');
                    }
                    else {
                        $(foo).css('border', invalidBorder);
                        $(".add-student-error").html(data['message']);
                        displayInvalid();
                    }
                },
                "json"
            );
        }
    });
    $('.class-course').click(function (e) {
        // e.preventDefault();
        // let link = 'http://localhost/assignments/doancuoiki/class.php?code=' + $(this).attr('code');
        // console.log($(this).attr('code'));
        window.location = "./class.php?code=" + $(this).attr('code');
    });

    $(document).on('keypress', ".search-input", function (e) {
        let resultList = $(".result-list");
        resultList.empty();
        $(resultList).addClass('d-block');
        let key = $(this).val().trim();
        let email = $(this).attr('email');
        $.post("SearchClass.php", {
            key: key, email: email
        },
            function (data, status) {
                console.log(data);
                data.forEach(element => {
                    resultList.append('<li class="list-group-item result-item" code=' + element['class-code'] + '>' + element['class-name'] + '</li>')
                });
            },
            "json"
        );
    });
    $(window).click(function (e) {
        let info = $('.infoCollapse');
        if ($(info).width() != 0)
            hideInfo(info);
        let resultList = $(".result-list");
        $(resultList).removeClass('d-block');
    });
    $(document).on('click', '.btn-approve', function (e) {
        e.preventDefault();
        let code = $(this).attr('code');
        let email = $(this).attr('email');
        let status = $(this).html();
        $.post("UpdateStatus.php", {
            code: code,
            email: email,
            status: status
        },
            function (data, status) {
                if (data['code'] == 1) {
                    $('.your-attendance').load(document.URL + ' .your-attendance');
                    $('.student-table').load(document.URL + ' .student-table');
                    toastNotification(data['message']);
                }
            },
            "json"
        );
    })
    $(document).on('click', '.remove-comment', function (e) {
        e.preventDefault();
        let code = $(this).attr('code');
        $.post("RemoveComment.php", { code: code },
            function (data, status) {
                if (data['code'] == 1) {
                    toastNotification(data['message']);
                    $(".classwork-comment").load(document.URL + ' .classwork-comment');
                }
            },
            "json"
        );
    })
});
