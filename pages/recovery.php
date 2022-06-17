<?php
require_once "config.php";

if (!empty($_POST) && !empty($_POST['email'])) {
    $email = $_POST['email'];
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        if(UserSystem::tryRecovery($email))
            echo Alert($messages[8], 'success');
            //echo "<script> $('#recovery-submit').after('<div class=\'mx-auto\'>$messages[8]</div>');</script>";//If email sent.
        else
            echo Alert($messages[9], 'error');
    }
}

if(!empty($_POST) && !empty($_POST['token'])){
    $password1 = $_POST['rpassword1'];
    $password2 = $_POST['rpassword2'];
    $password_old = null;
    if(isset($_POST['passwordO'])) $password_old = $_POST['passwordO'];
    $token = $_POST['token'];
    if (!empty($password1) && !empty($password2) && ($password1 === $password2)){
        if(strlen($token) === 50 || strlen($token) === 16) {
            $success = UserSystem::tryUpdatePassword($password1, $token);
            if(strlen($token) === 16) {
                $success = !empty(trim($password_old)) && strlen(trim($password_old)) >= 8 ? UserSystem::tryUpdatePassword($password1, $token, true, $password_old) : null;
            }
            if ($success)
                redirection('index.php?rec=10');
            else
                redirection("index.php?rec=9");
        }else{
            redirection('index.php?rec=9');
        }
    }else{
        redirection('index.php?rec=9');
    }
}

