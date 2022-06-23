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
                    $('#register-result').html(data);
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
        checkInputLength(variable_array['phonenumber'], 7, 'number')
    });
    variable_array['idcardNumber'].on('input', function () {
        checkInputLength(variable_array['idcardNumber'], 8, 'number')
    });
    variable_array['licensecardNumber'].on('input', function () {
        checkInputLength(variable_array['licensecardNumber'], 8, 'number')
    });
    variable_array['licensecardPlace'].on('input', function () {
        checkInputLength(variable_array['licensecardPlace'], 3)
    });
    variable_array['email'].on('input', function () {
        validateEmail(variable_array['email'])
    });
    variable_array['birthdate'].on('input', function () {
        checkDate(variable_array['birthdate'])
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

    function checkInputLength(input, _length, regex='') {
        let spinner = input.parent().next('.loader');
        if (regex !== '')
            if (regex === 'number')
                validateInput(input, 'number');
            else
                validateInput(input);
        if ((input.val().length >= _length) && regex) {
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

    function validateInput(input, regex = 'string') {
        if (regex === 'number')
            return /[0-9]+/.test(input.val());
        else
            return /^[a-zA-Z\\s]*$/.test(input.val());
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


    $('#login-form').submit(function (e) {
        const user = $('#user-name-log');
        const password = $('#user-password-log');
        e.preventDefault();
        if (user.val() !== "" && password.val() !== "" && user.val().length >= 3 && password.val().length >= 8) {
            $(this).load('login.php', {
                user: user.val(),
                password: password.val()
            });
        } else {
            Alert($(this), 'Nem megfelelő adatok!', 'error', false);
        }
    });
    /*
    * ha sikerült a bejelentkezés
    * */

    var Alert = function (e, message, type, append = true) {
        let color = "alert-"
        if (type === 'error') {
            color += 'danger';
            type = "Hiba!";
        } else if (type === 'success') {
            color += 'success';
            type = "Siker!";
        } else {
            color += 'warning';
            type = "Figyelmeztetés!";
        }
        let string = "<div class='alert d-flex align-items-center justify-content-between gap-2 "+color+" alert-dismissible fade show col-lg-12 col-sm-12' role='alert'><span class='p-0'><strong>" + type + "</strong>&nbsp;" + message + "</span><button type=\"button\" class=\"close button\" data-bs-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
        if (append)
            $(e).append(string);
        else
            $(e).prepend(string);
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
                    let data1 = $("#date-check-form");
                    let data2 = data1.parent().parent();
                    if (data === "available") {
                        Alert(data2, 'Foglalható az intervallum közt!', 'success');
                        data2.parent().parent().prepend("<form id='order-form' method='get' action='order.php' class='col-lg-7 col-sm-12'><input type='hidden' name='car' value='" + $("#date-check-form :input[name='car']").val() + "'></form>");
                        data1.fadeOut(100, function () {
                            $(this).remove();
                        });
                        $('#submit-data-order-btn').attr('form', 'order-form').attr('name', '').html('Foglalás megkezdése <i class=\'fa-solid fa-angle-right\'></i>').addClass('col-lg-7');
                    }
                    if (data === "not-available")
                        Alert(data2, 'Sajnos a kiválasztott intervallumban foglalt!', 'error');
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

        if (date_start >= today && date_start <= month && date_start <= date_end && date_end > plus12h && date_start.getDay() !== 0 && date_end.getDay() !== 0) {
            return true;
        } else {
            let output_arr;
            let output_obj = e.parent().parent();
            if (date_start.getDay() === 0 || date_end.getDay() === 0)
                output_arr = {0:'Vasárnap nem dolgozunk!', 1:'error'};
            else if (date_end < plus12h)
                output_arr = {0:'Minimum bérlés 12 óra!', 1:'error'};
            else if (date_start > month)
                output_arr = {0:'Maximum egy hónappal tud előrerendelni!', 1:'error'};
            else if (date_start < today)
                output_arr = {0:'A multban nem tud rendelni..', 1: 'error'};
            else
                output_arr = {0:'Nem megfelelő adatok!', 1:'error'}
            Alert(output_obj, output_arr[0], output_arr[1]);
        }
    }


    var clickedButton = false;
    $("button[data-d-btn='true']").click(function () {
        let icon = $(this).find('i');
        let input = $(this).parent().find('input');
        let label = $(this).parent().parent().find('label');
        if (!clickedButton) {
            icon.toggleClass('fa-wrench');
            label.append('<span class="text-danger">&nbsp; - Szerkesztés alatt!</span>');
            label.find('span').hide().fadeIn("slow", function () {
                $(this).show()
            });
            input.prop("disabled", false);
            clickedButton = $(this).attr('id');
        } else if (clickedButton === $(this).attr('id')) {
            if (validateInput(input)) {
                let value = input.val();
                $.ajax({
                    type: "POST",
                    url: 'dashboard.php',
                    cache: false,
                    data: input.attr('id') + "=" + value,
                    dataType: 'text',
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
            }
            icon.toggleClass('fa-wrench');
            label.find('span').fadeOut("slow", function () {
                $(this).remove()
            });
            clickedButton = false;
        } else {
            $('#update-alert').html("Már van egy másik adat szerkesztés alatt.");
            $('#message-modal').modal('show');
        }

        function validateInput(input, _length = 3) {
            let error = false;
            if (input.attr('id') === 'birthdate') {
                var given = new Date(input.val()).getFullYear();
                var now = (new Date).getFullYear();
                if (!(given <= now - 16 && given >= now - 80))
                    error = true;
            } else {
                console.log(input.val());
                if (!(input.val().length >= _length))
                    error = true;
            }
            if (error) {
                let msg = "Az adat nem megfelelő! Minimum " + _length + " karakter!";
                if (input.attr('id') === 'birthdate') msg = "Nem megfelelő születési év! Min. 16 év!";
                $('#update-alert').html(msg);
                $('#message-modal').modal('show');
                return false;
            } else
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
        let file, img, _URL = window.URL || window.webkitURL, errorMsg = "";
        if ((file = this.files[0])) {
            img = new Image();
            var objectUrl = _URL.createObjectURL(file);
            img.onload = function () {
                if (img.width !== img.height)
                    errorMsg += "A kép dimenziói nem egyenlőek. ( " + img.width + "px * " + img.height + "px )";
                if (file.size > 3145728)
                    errorMsg += "<br>A kép mérete túl nagy. ( " + Math.floor(file.size / 1024 / 1000) + "MB )";
                if (errorMsg.length > 0) {
                    $('#update-alert').html(errorMsg);
                    $('#message-modal').modal('show');
                }
                _URL.revokeObjectURL(objectUrl);
            };
            img.src = objectUrl;
        }
    });


    $.each([$("#order-page1"), $("#order-page2"), $("#order-page3"), $("#date-check")], function () {
        $(this).on('submit', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            nextPage(e, $(this));
        });
    });

    function nextPage(e, form) {
        $.ajax({
            type: "POST",
            url: 'order_operation.php',
            cache: false,
            data: form.serialize(),
            dataType: 'html',
            success: function (data) {
                let data1 = $("#date-check").parent().parent();
                if (data === "available")
                    Alert(data1, 'Foglalható az intervallum közt!', 'success');
                if (data === "not-available")
                    Alert(data1, 'Sajnos a kiválasztott intervallumban foglalt!', 'error');
                if (data !== "error" && data !== "available" && data !== "not-available") {
                    let json = JSON.parse(data);

                            let width = json[0].substr(json[0].indexOf('%')-2, 2);
                            let id = json[0].substr(json[0].indexOf('id=')+4, 6);

                    $('#progress-bar').html(json[0]);
                            $('#'+id).animate({
                                width: width+"%"
                            }, 300 );


                    $('#container-data').fadeOut("slow", function () {
                        $(this).fadeIn(1000, function () {
                            $(this).html(json[1]);
                            pushButtonsInit();
                            dropDownAbsolute();
                        });
                        $(this).html(json[1]);
                    });
                }
            },
            error: function (data) {
                console.log("error: " + data);
            }
        });
    }

    $(document).ready(function (){
        var page = window.location.pathname.split("/").pop();
        if (page === 'history.php'){
            addAjaxToRatings();
            addAjaxToResigns();
        }
        if (page === 'admin_index.php'){
            addAjaxOperations();
        }
        $('[data-favorite]').on('click', function (e){
            e.preventDefault();
            e.stopImmediatePropagation();
            let button = $(this);
            $.ajax({
                type: "POST",
                url: 'favorites.php',
                cache: false,
                data: 'favorite='+$(this).data('favorite'),
                dataType: 'text',
                success: function (data) {
                    let icon = button.find('i');
                    if (data === 'insert'){
                        icon.removeClass('fa-heart-broken');
                        icon.addClass('fa-heart fa-beat');
                        icon.css('color','var(--col-nosucc)');
                        setTimeout(function (){icon.removeClass('fa-beat')}, 1000);
                    }
                    if (data === 'delete'){
                        icon.removeClass('fa-heart');
                        icon.addClass('fa-heart-broken fa-beat');
                        icon.css('color','#000');
                        setTimeout(function (){icon.removeClass('fa-beat')}, 1000);
                    }
                }
            });
        });
    });
    function addAjaxToRatings() {
        $('*[data-rat="1"]').each(function () {
            $(this).on('submit', function (e) {
                let form = $(this);
                let resultShower = $(document).find('#' + $(this).attr('id').replace('-form', '-result'));
                e.preventDefault();
                e.stopImmediatePropagation();
                 if ($('*[data-cb="'+$(this).attr('id')+'"]').val().length >= 8 && $('*[data-ct="'+$(this).attr('id')+'"]').val().length >= 8 && $('*[data-ordk="'+$(this).attr('id')+'"]').val().length === 14) {
                     $.ajax({
                         type: "POST",
                         url: 'history.php',
                         cache: false,
                         data: $(this).serialize(),
                         dataType: 'html',
                         success: function (data) {
                             let results = [];
                             if (data === 'success') {
                                 Alert(resultShower, 'Sikeresen hozzáadta az értékelést!'+"<br><div class='text-danger w-100'>3 másodperc múlva újratöltődik az oldal!</div>", 'success');
                                 form.remove();
                                 setTimeout(function () {
                                     window.location.reload();
                                 }, 3000);
                             } else {
                                 let temp;
                                 switch (data) {
                                     case (data === 'error5'):
                                         temp = "Nem sikerült bevinni az adatot!";
                                         break;
                                     case (data === 'error4'):
                                         temp = "Már van értékelés hozzáfűzve a rendeléshez!";
                                         break;
                                     case (data === 'error3' || data === 'error2'):
                                         temp = "Nem megfelelő kód-ot írt be!";
                                         break;
                                     case (data === 'error1'):
                                         temp = "Minden mezőt ki kell tölteni!";
                                         break;
                                     default:
                                         temp = "Valami hiba történt.";
                                 }
                                 Alert(resultShower, temp, 'error')
                             }

                         },
                     });
                 }
                 else
                   Alert(resultShower, 'Nem megfelelő adatok minimum 8 karakter!', 'error');
            });
        });
    }
    function addAjaxToResigns(){
        $('*[data-resgn="1"]').each(function () {
            $(this).on('submit', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let form = $(this);
                $.ajax({
                    type: "POST",
                    url: 'history.php',
                    cache: false,
                    data: $(this).serialize(),
                    dataType: 'html',
                    success: function (data) {
                        let resultShower = $(document).find('#'+form.attr('id') +'-result')
                        let results = [];
                        if (data === 'success')
                            results = ['Sikeresen lemondta a rendelést!', 'success'];
                        else
                            results = ['Nem sikerült lemondani a rendelést!', 'error'];
                        results[0] += "<br><div class='text-danger w-100'>3 másodperc múlva újratöltődik az oldal!</div>"
                        Alert(resultShower, results[0], results[1]);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    }
                });
            });
        });
    }
    function addAjaxOperations(){
        $.each([$('*[data-operation="1"]'), $('*[data-deco="1"]'), $('*[data-appo="1"]')], function () {
            $(this).on('submit', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let form = $(this).attr('id');
                let resultShower = $(document).find('#' + form.replace('-form', '-result').replace('approve', 'operation').replace('decline', 'operation'));
                $.ajax({
                    type: "POST",
                    url: 'admin_index.php',
                    cache: false,
                    data: $(this).serialize(),
                    dataType: 'html',
                    success: function (data) {
                        let results = [];
                        switch (data){
                            case 'success0': results = ['Sikeresen szerkesztette a rendelést!', 'success'];
                                break;
                            case 'error0-1': results = ['Nem sikerült szerkeszteni a rendelést!',  'error'];
                                break;
                            case 'error0-2': results = ['Nem sikerült szerkeszteni a rendelést!<br>(Adatbázis hiba!)', 'error'];
                                break;
                            case 'error0-3': results = ['Nem sikerült szerkeszteni a rendelést, mivel nem található?!', 'error'];
                                break;
                            case 'error0': results = ['Nem sikerült szerkeszteni a rendelést, hibás adatok!!', 'error'];
                                break;
                            case 'success-2': results = ['Sikeresen elutasította a rendelést!', 'success'];
                                break;
                            case 'error-2-1': results = ['Sikeresen elutasította a rendelést!<br>De a felhasználó nem kapott email-t!', 'error'];
                                break;
                            case 'error-2-2': results = ['Sikeresen elutasította a rendelést!<br>De hibásak a felhasználó adatai!', 'error'];
                                break;
                            case 'error-2': results = ['Nem sikerült elutasítani a rendelést!', 'error'];
                                break;
                            case 'success1': results = ['Sikeresen frissítette a rendelés állapotát!', 'success'];
                                break;
                            case 'error1': results = ['Nem sikerült frissíteni a rendelés állapotát!<br>(Adatbázis hiba, vagy már megváltoztak az adatok!)', 'error']
                                break;
                            case 'success2': results = ['Sikeresen leadta a jelentést!', 'success'];
                                break;
                            case 'error2-1': results = ['Rendelés leadva, de emailt nem sikerült elküldeni a felhasználónak!',  'warning'];
                                break;
                            case 'error2-2': results = ['Sikeres rendelés, de valami hiba történt, nem sikerült elküldeni az üzenetet a felhasználónak!',  'warning'];
                                break;
                            case 'error2-3': results = ['Nem sikerült leadni a jelentést!',  'error'];
                                break;
                            case 'error2-4': results = ['Nem sikerült frissíteni a megrendelés állapotát!', 'error'];
                                break;
                            case 'error2': results = ['Hiba, töltse ki a kilóméteróra jelenlegi állását!',  'error'];
                                break;
                            case 'success4': results = ['Sikeresen frissítette a komment állapotát!',  'success'];
                                break;
                            case 'error4': results = ['Nem sikerült frissíteni a komment állapotát!',  'error'];
                                break;
                            case "success5": results = ['Sikeresen elfogadta a rendelést!', 'success'];
                                break;
                            case 'error5-1': results = ['Sikeresen elfogadta a rendelést!<br>De a felhasználó nem kapott email-t!',  'error'];
                                break;
                            case 'error5-2': results = ['Sikeresen elfogadta a rendelést!<br>De hibásak a felhasználó adatai!', 'error'];
                                break;
                            case 'error5': results = ['Nem sikerült elfogadta a rendelést!', 'error'];
                                break;
                            default: results = ['Hiba nem sikerült a művelet!', 'error'];
                        }
                        results[0] += "<br><div class='text-danger w-100'>3 másodperc múlva újratöltődik az oldal!</div>"
                        Alert(resultShower, results[0], results[1]);
                        $(document).find('#' + form.replace('-form', '-modal').replace('approve', 'operation').replace('decline', 'operation')).animate({scrollTop: 0}, 400);
                        setTimeout(function () {
                                window.location.reload();
                        }, 3000);
                    }
                });
            });
        });
    }
    $('#contact-form').on('submit', function (e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let f_name = $('#first_name');
        let l_name = $('#last_name');
        let email = $('#email');
        let message = $('#message');
        let error = false;
        if (!email.val().match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
            error = "Nem megfelelő e-mail formátum!";
        }
        if (validateInput(l_name)) {
            if (l_name.val().length < 3)
                error = "A keresztnév nem megfelelő hosszúságú!";
        } else
                error = "A keresznév nem tartalmazhat csak betűket.";
        if (validateInput(f_name)) {
            if (f_name.val().length < 3)
                error = "A vezetéknév nem megfelelő hosszúságú!";
        } else
            error = "A vezetéknév nem tartalmazhat csak betűket.";
        if (message.val().length < 15)
            error = "A szöveg legyen bár 16 karakter hosszú!";
        Alert($(this), error, 'error');
    });
    $('.modal').on('shown', function () {

        $(this).handleUpdate()


    });
});


