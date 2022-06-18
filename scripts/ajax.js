$(document).ready(function () {
    const fadeOutTime = 15000;
    const variable_array = {
        email: $('#email'),
        password1x: $('#password1x'),
        password2x: $('#password2x'),
        firstname: $('#firstname'),
        lastname: $('#lastname'),
        birthdate: $('#birthdate'),
        phonenumber: $('#phonenumber'),
        idcardNumber: $('#idcardNumber'),
        licensecardNumber: $('#licensecardNumber'),
        licensecardPlace: $('#licensecardPlace')
    }
    const validArray = {
        email: false,
        password1x: false,
        password2x: false,
        firstname: false,
        lastname: false,
        birthdate: false,
        phonenumber: false,
        idcardNumber: false,
        licensecardNumber: false,
        licensecardPlace: false
    }
    const errorMessages = {
        email: 'Nem megfelelő formátum!',
        password1x: 'Nem megfelelő!',
        password2x: 'Nem megfelelő!',
        firstname: 'Minimum 3 karakter!',
        lastname: 'Minimum 3 karakter!',
        birthdate: 'A megengedett kor min 16, max 99 lehet!',
        phonenumber: 'Nem megfelelő!',
        idcardNumber: 'Minimum 8 karakter!',
        licensecardNumber: 'Minimum 8 karakter!',
        licensecardPlace: 'Minimum 3 karakter!'
    }
    $('#nav-register-form').on('submit', function (e) {

        e.preventDefault();
        if (checkData()) {
            $.ajax({
                type: "POST",
                url: 'register.php',
                cache: false,
                data: $(this).serialize(),
                dataType: 'html',
                success: function (data) {
                    $('#reg-result').html(data);
                    $('#register-modal').animate({scrollTop: 0}, 400);
                },
            });
        }
    });
    variable_array['password1x'].on('input', function () {
        passwordCheck(variable_array['password1x'], variable_array['password2x'])
    });
    variable_array['password2x'].on('input', function () {
        passwordCheck(variable_array['password2x'], variable_array['password1x'])
    });
    variable_array['lastname'].on('input', function () {
        checkInputLength(variable_array['lastname'], 3)
    });
    variable_array['firstname'].on('input', function () {
        checkInputLength(variable_array['firstname'], 3)
    });
    variable_array['phonenumber'].on('input', function () {
        checkInputLength(variable_array['phonenumber'], 7)
    });
    variable_array['idcardNumber'].on('input', function () {
        checkInputLength(variable_array['idcardNumber'], 8)
    });
    variable_array['licensecardNumber'].on('input', function () {
        checkInputLength(variable_array['licensecardNumber'], 8)
    });
    variable_array['licensecardPlace'].on('input', function () {
        checkInputLength(variable_array['licensecardPlace'], 3)
    });
    variable_array['email'].on('input', function () {
        validateEmail(variable_array['email'])
    });
    variable_array['birthdate'].on('input', function () {
        checkDate (variable_array['birthdate'])
    });

    function setLabelText(variable, mess = null) {
        let f = function (m) {
            variable_array[variable].parent().parent().prev('label[for=' + variable + ']').find('.err').text(m).show().fadeOut(fadeOutTime);
        }
        if (mess != null)
            f(mess);
        else {
            f('');
        }
    }

    var checkData = function () {
        let returnValue = true;
        for (const Key in validArray) {
            if (validArray[Key] === false) {
                returnValue = false;
                variable_array[Key].parent().addClass('invalid-data');
                setLabelText(Key, errorMessages[Key]);
            }
        }
        return returnValue;
    }

    function checkInputLength(input, _length) {
        let spinner = input.parent().next('.loader');
        if ((input.val().length >= _length)) {
            if (input.parent().hasClass('invalid-data'))
                input.parent().removeClass('invalid-data');
            if (spinner.hasClass('loader-bad'))
                spinner.removeClass('loader-bad');
            spinner.addClass('loader-ok');
            validArray[input.attr('id')] = true;
            setLabelText(input.attr('id'));
        } else {
            if (spinner.hasClass('loader-ok'))
                spinner.removeClass('loader-ok');
            spinner.addClass('loader-bad');
            validArray[input.attr('id')] = false;
        }
    }

    function passwordCheck(input1, input2) {
        let spinner1 = input1.parent().next('.loader');
        let spinner2 = input2.parent().next('.loader');
        if (input1.val() !== input2.val() || input1.val().length < 8 || input2.val().length < 8) {
            if (spinner1.hasClass('loader-ok'))
                spinner1.removeClass('loader-ok');
            spinner1.addClass('loader-bad');
            if (spinner2.hasClass('loader-ok'))
                spinner2.removeClass('loader-ok');
            spinner2.addClass('loader-bad');
            validArray[input1.attr('id')] = false;
            validArray[input2.attr('id')] = false;
        } else {
            if (input1.parent().hasClass('invalid-data'))
                input1.parent().removeClass('invalid-data');
            if (spinner1.hasClass('loader-bad'))
                spinner1.removeClass('loader-bad');
            spinner1.addClass('loader-ok');

            if (input2.parent().hasClass('invalid-data'))
                input2.parent().removeClass('invalid-data');
            if (spinner2.hasClass('loader-bad'))
                spinner2.removeClass('loader-bad');
            spinner2.addClass('loader-ok');
            validArray[input1.attr('id')] = true;
            validArray[input2.attr('id')] = true;
            setLabelText(input1.attr('id'));
            setLabelText(input2.attr('id'));
        }
    }

    function validateInput(input, regex) {
        // TODO: csinálni egy szűrést, hogy csak betűt/számot tartalmazhasson az adott mező.
    }

    function validateEmail(input) {
        let spinner = input.parent().next('.loader');
        if (input.val().match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            if (input.parent().hasClass('invalid-data'))
                input.parent().removeClass('invalid-data');
            if (spinner.hasClass('loader-bad'))
                spinner.removeClass('loader-bad');
            spinner.addClass('loader-ok');
            validArray[input.attr('id')] = true;
            setLabelText(input.attr('id'));
        } else {
            if (spinner.hasClass('loader-ok'))
                spinner.removeClass('loader-ok');
            spinner.addClass('loader-bad');
            validArray[input.attr('id')] = false;
        }
    }

    function checkDate(input) {
        let spinner = input.parent().next('.loader');
        var given = new Date(input.val()).getFullYear();
        var now = (new Date).getFullYear();
        if (given <= now - 16 && given >= now - 80) {
            if (input.parent().hasClass('invalid-data'))
                input.parent().removeClass('invalid-data');
            if (spinner.hasClass('loader-bad'))
                spinner.removeClass('loader-bad');
            spinner.addClass('loader-ok');
            validArray[input.attr('id')] = true;
            setLabelText(input.attr('id'));
        } else {
            if (spinner.hasClass('loader-ok'))
                spinner.removeClass('loader-ok');
            spinner.addClass('loader-bad');
            validArray[input.attr('id')] = false;
        }
    }

    /*
    *
    * LOGIN ->>
    *
    * */
    const user = $('#user-name-log');
    const password = $('#user-password-log');

    $('#login-form').submit(function (e) {
        e.preventDefault();
        if (user.val() != "" && password.val() != "" && user.val().length > 0 && password.val().length >= 8) {
            $(this).load('login.php', {
                user: user.val(),
                password: password.val()
            });
        } else {
            Alert($(this), 'Nem megfelelő adatok!', 'error');
        }
    });
    /*
    * ha sikerült a bejelentkezés
    * */

    var Alert = function (e, message, type) {
        if (type === 'error') {
            color = 'alert-danger';
            type = "Hiba!";
        } else if (type === 'success') {
            color = 'alert-success';
            type = "Siker!";
        } else {
            color = 'alert-warning';
            type = "Figyelmeztetés!";
        }
        $(e).prepend('<div class="alert d-flex align-items-center justify-content-between gap-2 ' + color + ' alert-dismissible fade show" role="alert"><span class="p-0"><strong>' + type + '</strong>&nbsp;' + message + '</span><button type="button" class="close button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    $('#date-check-form').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (checkDateCheck($(this))) {
            $.ajax({
                type: "POST",
                url: 'car.php',
                cache: false,
                data: $(this).serialize(),
                dataType: 'html',
                success: function (data) {
                    if (data === "available") {
                        Alert2($("#date-check-form").parent().parent(), 'Foglalható az intervallum közt!', 'success');
                        $("#date-check-form").parent().parent().prepend("<form id='order-form' method='get' action='order.php'><input type='hidden' name='car' value='" + $("#date-check-form :input[name='car']").val() + "'></form>");
                        $("#date-check-form").fadeOut("slow", function () {
                            $(this).remove();
                        });
                        $('#submit-data-order-btn').attr('form', 'order-form').attr('name', '').html('Foglalás megkezdése <i class=\'fa-solid fa-angle-right\'></i>');
                    }
                    if (data === "not-available")
                        Alert2($("#date-check-form").parent().parent(), 'Sajnos a kiválasztott intervallumban foglalt!', 'error');
                },
            });
        }
    });

    function checkDateCheck(e) {
        let date_start_input = $('#' + e.attr("id") + ' #pick-date');
        let date_end_input = $('#' + e.attr("id") + ' #drop-date');
        let date_start = new Date(date_start_input.val());
        let date_end = new Date(date_end_input.val());
        let today = new Date();
        let month = new Date();
        month.setMonth(month.getMonth() + 1);
        let plus12h = date_start;
        plus12h.setHours(plus12h.getHours() + 12);

        if (date_start >= today && date_start <= month && date_start <= date_end && date_end > plus12h && date_start.getDay() != 0 && date_end.getDay() != 0) {
            return true;
        } else {
            if (date_start.getDay() == 0 || date_end.getDay() == 0)
                Alert2(e.parent().parent(), 'Vasárnap nem dolgozunk!', 'error');
            else if (date_end < plus12h)
                Alert2(e.parent().parent(), 'Minimum bérlés 12 óra!', 'error');
            else
                Alert2(e.parent().parent(), 'Nem megfelelő adatok!', 'error');
        }
    }

    var Alert2 = function (e, message, type) {
        if (type === 'error') {
            color = 'alert-danger';
            type = "Hiba!";
        } else if (type === 'success') {
            color = 'alert-success';
            type = "Siker!";
        } else {
            color = 'alert-warning';
            type = "Figyelmeztetés!";
        }
        $(e).append('<div class="alert d-flex align-items-center justify-content-between gap-2 ' + color + ' alert-dismissible fade show w-100" role="alert"><span class="p-0"><strong>' + type + '</strong>&nbsp;' + message + '</span><button type="button" class="close button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    var clickedButton = false;
    $("button[data-d-btn='true']").click(function () {
        let icon = $(this).find('i');
        let input = $(this).parent().find('input');
        let label = $(this).parent().parent().find('label');
        if(!clickedButton){
            icon.toggleClass('fa-wrench');
            label.append('<span class="text-danger">&nbsp; - Szerkesztés alatt!</span>');
            label.find('span').hide().fadeIn("slow", function (){$(this).show()});
            input.prop("disabled", false);
            clickedButton = $(this).attr('id');
        }else if(clickedButton === $(this).attr('id')){
            if(validateInput(input)){
                let value = input.val();
                $.ajax({
                    type: "POST",
                    url: 'dashboard.php',
                    cache: false,
                    data: input.attr('id') +"="+ value,
                    dataType: 'text',
                    success: function (data) {
                        setTimeout(function(){
                            window.location.reload();
                        }, 3000);
                        $('#update-alert').html(data);
                        $('#message-modal').modal('show');
                    },
                    error: function (data) {
                        $('#update-alert').html("Ismeretlen hiba.");
                        $('#message-modal').modal('show');
                    }
                });
            }
            icon.toggleClass('fa-wrench');
            label.find('span').fadeOut("slow",function (){$(this).remove()});
            clickedButton = false;
        } else {
            $('#update-alert').html("Már van egy másik adat szerkesztés alatt.");
            $('#message-modal').modal('show');
        }

        function validateInput(input, _length = 3){
            let error = false;
            if(input.attr('id') === 'birthdate'){
                var given = new Date(input.val()).getFullYear();
                var now = (new Date).getFullYear();
                if (!(given <= now - 16 && given >= now - 80))
                    error = true;
            }else{
                console.log(input.val());
                if(!(input.val().length >= _length))
                    error = true;
            }
            if(error){
                let msg = "Az adat nem megfelelő! Minimum "+_length+" karakter!";
                if(input.attr('id') === 'birthdate') msg = "Nem megfelelő születési év! Min. 16 év!";
                $('#update-alert').html(msg);
                $('#message-modal').modal('show');
                return false;
            }
            else
                return true;
        }
    });
    $('#image-submit').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: 'dashboard.php',
                cache: false,
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                    $('#update-alert').html(data);
                    $('#message-modal').modal('show');
                },
                error: function (data) {
                    $('#update-alert').html("Ismeretlen hiba.");
                    $('#message-modal').modal('show');
                }
            });
    });


    $("#avatar").change(function (e) {
        let file, img, _URL = window.URL || window.webkitURL, errorMsg="";
        if ((file = this.files[0])) {
            img = new Image();
            var objectUrl = _URL.createObjectURL(file);
            img.onload = function () {
                if(img.width !== img.height)
                    errorMsg += "A kép dimenziói nem egyenlőek. ( "+img.width+"px * "+img.height+"px )";
                if(file.size > 3145728)
                    errorMsg += "<br>A kép mérete túl nagy. ( "+Math.floor(file.size/1024/1000)+"MB )";
                if(errorMsg.length > 0) {
                    $('#update-alert').html(errorMsg);
                    $('#message-modal').modal('show');
                }
                _URL.revokeObjectURL(objectUrl);
            };
            img.src = objectUrl;
        }
    });

    $("#order-page1").on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        nextPage(e, $(this));
    });

    $("#order-page2").on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        nextPage(e, $(this));
    });

    $("#order-page3").on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        nextPage(e, $(this));
    });

    $("#date-check").on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (checkDateCheck($(this))) {
            nextPage(e, $(this));
        }
    });
    function nextPage(e, form, datecheck) {
        $.ajax({
            type: "POST",
            url: 'order_operation.php',
            cache: false,
            data: form.serialize(),
            dataType: 'html',
            success: function (data) {
                if (data === "available")
                    Alert2($("#date-check").parent().parent(), 'Foglalható az intervallum közt!', 'success');
                if (data === "not-available")
                    Alert2($("#date-check").parent().parent(), 'Sajnos a kiválasztott intervallumban foglalt!', 'error');
                if (data !== "error" && data !== "available" && data !== "not-available") {
                    let json = JSON.parse(data);
                    $('#progress-bar').fadeOut("fast", function () {
                        $(this).fadeIn("slow", function () {
                            $(this).html(json[0]);
                        });
                    });

                    $('#container-data').fadeOut("fast", function () {
                        $(this).html("");
                        $(this).fadeIn("slow", function () {
                            $(this).html(json[1]);
                            pushButtonsInit();
                            dropDownAbsolute();
                        });

                    });

                }
            },
            error: function (data) {
                console.log("error: " + data);
            }
        });
    }
});


