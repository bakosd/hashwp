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
        birthdate: 'Minimum 16 év kötelező!',
        phonenumber: 'Nem megfelelő!',
        idcardNumber: 'Minimum 8 karakter!',
        licensecardNumber: 'Minimum 8 karakter!',
        licensecardPlace: 'Minimum 3 karakter!'
    }
    $('#nav-register-form').on('submit', function (e) {
        e.preventDefault();
        if (checkData()) {
            $(this).load('register.php',{
                email: variable_array['email'].val(),
                password1x: variable_array['password1x'].val(),
                password2x: variable_array['password2x'].val(),
                firstname: variable_array['firstname'].val(),
                lastname: variable_array['lastname'].val(),
                birthdate: variable_array['birthdate'].val(),
                phonenumber: variable_array['phonenumber'].val(),
                idcardNumber: variable_array['idcardNumber'].val(),
                licensecardNumber: variable_array['licensecardNumber'].val(),
                licensecardPlace: variable_array['licensecardPlace'].val()

            });
        }
    });
    variable_array['password1x'].on('input', function (){passwordCheck(variable_array['password1x'], variable_array['password2x'])});
    variable_array['password2x'].on('input', function (){passwordCheck(variable_array['password2x'], variable_array['password1x'])});
    variable_array['lastname'].on('input', function (){checkInputLength(variable_array['lastname'],3)});
    variable_array['firstname'].on('input', function (){checkInputLength(variable_array['firstname'],3)});
    variable_array['phonenumber'].on('input', function (){checkInputLength(variable_array['phonenumber'],7)});
    variable_array['idcardNumber'].on('input', function (){checkInputLength(variable_array['idcardNumber'],8)});
    variable_array['licensecardNumber'].on('input', function (){checkInputLength(variable_array['licensecardNumber'],8)});
    variable_array['licensecardPlace'].on('input', function (){checkInputLength(variable_array['licensecardPlace'],3)});
    variable_array['email'].on('input', function (){validateEmail(variable_array['email'])});
    variable_array['birthdate'].on('input', function (){checkDate(variable_array['birthdate'])});

    function setLabelText(variable, mess = null){
        let f = function (m) {variable_array[variable].parent().parent().prev('label[for='+variable+']').find('.err').text(m).show().fadeOut( fadeOutTime );}
        if(mess != null)
            f(mess);
        else{
            f('');
        }
    }
    var checkData = function (){
        let returnValue = true;
        for (const Key in validArray) {
            if(validArray[Key] === false){
                returnValue = false;
                variable_array[Key].parent().addClass('invalid-data');
                setLabelText(Key, errorMessages[Key]);
            }
        }
        return returnValue;
    }

    function checkInputLength (input,_length){
        let spinner = input.parent().next('.loader');
        if((input.val().length >= _length)) {
            if (input.parent().hasClass('invalid-data'))
                input.parent().removeClass('invalid-data');
            if (spinner.hasClass('loader-bad'))
                spinner.removeClass('loader-bad');
            spinner.addClass('loader-ok');
            validArray[input.attr('id')] = true;
            setLabelText(input.attr('id'));
        }
        else{
            if(spinner.hasClass('loader-ok'))
                spinner.removeClass('loader-ok');
            spinner.addClass('loader-bad');
            validArray[input.attr('id')] = false;
        }
    }

    function passwordCheck(input1, input2){
        let spinner1 = input1.parent().next('.loader');
        let spinner2 = input2.parent().next('.loader');
        if(input1.val() !== input2.val() || input1.val().length < 8 || input2.val().length < 8){
            if(spinner1.hasClass('loader-ok'))
                spinner1.removeClass('loader-ok');
            spinner1.addClass('loader-bad');
            if(spinner2.hasClass('loader-ok'))
                spinner2.removeClass('loader-ok');
            spinner2.addClass('loader-bad');
            validArray[input1.attr('id')] = false;
            validArray[input2.attr('id')] = false;
        }
        else{
            if(input1.parent().hasClass('invalid-data'))
                input1.parent().removeClass('invalid-data');
            if(spinner1.hasClass('loader-bad'))
                spinner1.removeClass('loader-bad');
            spinner1.addClass('loader-ok');

            if(input2.parent().hasClass('invalid-data'))
                input2.parent().removeClass('invalid-data');
            if(spinner2.hasClass('loader-bad'))
                spinner2.removeClass('loader-bad');
            spinner2.addClass('loader-ok');
            validArray[input1.attr('id')] = true;
            validArray[input2.attr('id')] = true;
            setLabelText(input1.attr('id'));
            setLabelText(input2.attr('id'));
        }
    }

    function validateInput(input, regex){
        // TODO: csinálni egy szűrést, hogy csak betűt/számot tartalmazhasson az adott mező.
    }
    function validateEmail(input){
        let spinner = input.parent().next('.loader');
        if(input.val().match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
            if(input.parent().hasClass('invalid-data'))
                input.parent().removeClass('invalid-data');
            if(spinner.hasClass('loader-bad'))
                spinner.removeClass('loader-bad');
            spinner.addClass('loader-ok');
            validArray[input.attr('id')] = true;
            setLabelText(input.attr('id'));
        }
        else{
            if(spinner.hasClass('loader-ok'))
                spinner.removeClass('loader-ok');
            spinner.addClass('loader-bad');
            validArray[input.attr('id')] = false;
        }
    }

    function checkDate(input){
        let spinner = input.parent().next('.loader');
        var given = new Date (input.val()).getFullYear();
        var now = (new Date).getFullYear();
        if(given <= now-16){
            if(input.parent().hasClass('invalid-data'))
                input.parent().removeClass('invalid-data');
            if(spinner.hasClass('loader-bad'))
                spinner.removeClass('loader-bad');
            spinner.addClass('loader-ok');
            validArray[input.attr('id')] = true;
            setLabelText(input.attr('id'));
        }
        else{
            if(spinner.hasClass('loader-ok'))
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

    $('#login-form').on('submit', function (e) {
        e.preventDefault();
        if (user.val().length > 0 && password.val().length >= 8) {
            $(this).load('login.php',{
                user: user.val(),
                password: password.val()
            });
        }
    });
    /*
    * ha sikerült a bejelentkezés
    * */

    /*$(document).ready(function () {
        function reload() {
            $("#content").load("notification.php");
        }
        setTimeOut(reload, seconds*1000)
    });*/

});




