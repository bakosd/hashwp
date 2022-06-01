<?php
include_once "config.php";
if (!empty($_POST)) {
    if (isset($_POST['password1x']) && isset($_POST['password2x']) && isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birthdate']) && isset($_POST['phonenumber']) && isset($_POST['idcardNumber']) && isset($_POST['licensecardNumber']) && isset($_POST['licensecardPlace'])){
        $error = false;
        $email = trim($_POST['email']);
        $password1x = trim($_POST['password1x']);
        $password2x = trim($_POST['password2x']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $birthdate = trim($_POST['birthdate']);
        $phonenumber = trim($_POST['phonenumber']);
        $idcardNumber = trim($_POST['idcardNumber']);
        $licensecardNumber = trim($_POST['licensecardNumber']);
        $licensecardPlace = trim($_POST['licensecardPlace']);
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            printError("email", $messages[1]);
            $error = true;
        }
        if(strlen($password1x) < 8 || strlen($password2x) < 8 || $password1x !== $password2x){
            printError("password1x", $messages[2]);
            printError("password2x", $messages[2]);
            $error = true;
        }
        if(strlen($firstname) < 3){
            printError("firstname", $messages[3]);
            $error = true;
        }
        if(strlen($lastname) < 3){
            printError("lastname", $messages[3]);
            $error = true;
        }
        if(strlen($phonenumber) < 8){
            printError("phonenumber", $messages[0]);
            $error = true;
        }
        if(strlen($idcardNumber) < 8){
            printError("idcardNumber", $messages[4]);
            $error = true;
        }
        if(strlen($licensecardNumber) < 8){
            printError("licensecardNumber", $messages[4]);
            $error = true;
        }
        if(strlen($licensecardPlace) < 3){
            printError("licensecardPlace", $messages[3]);
            $error = true;
        }

        if(!$error){
            $username = UserSystem::getUsernameFromEmail($email);
            $reg_data = UserSystem::tryRegister($username, $password1x, $firstname, $lastname, $birthdate, $email, $phonenumber, $idcardNumber, $licensecardNumber, $licensecardPlace);
            echo "<span>$reg_data</span>";
            if($reg_data != "Sikeres regisztráció."){
                if (!empty($register_form)) {
                    echo $register_form;
                }
            }
        }
    }
}

function printError($variable ,$error){
    if (!empty($register_form)) {
        echo $register_form;
    }
    echo '<script>$("#'.$variable.'").parent().parent().prev("label[for="'.$variable.'"]").find(".err").text('.$error.').show().fadeOut( fadeOutTime ); $("#'.$variable.'").parent().addClass("invalid-data");</script>';
}
