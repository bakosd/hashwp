<?php
include_once "config.php";
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
    $token = $_POST['token'];
    if (!empty($password1) && !empty($password2) && ($password1 === $password2)){
        if(strlen($token) === 50) {
            if (UserSystem::tryUpdatePassword($password1, $token))
                redirection('index.php?rec=10');
            else
                redirection('index.php?rec=9');
        }else{
            redirection('index.php?rec=9');
        }
    }else{
        redirection('index.php?rec=9');
    }
}

?>
