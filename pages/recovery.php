<?php
require_once "config.php";

if(is_array($_FILES) || (!empty($_POST) && (!empty($_POST['lastname']) || !empty($_POST['firstname']) || !empty($_POST['phonenumber']) || !empty($_POST['birthdate']) || !empty($_POST['idcardNumber']) || !empty($_POST['licensecardNumber']) || !empty($_POST['licensecardPlace']) ))){

    $exitVal = "Nem sikerült szerkeszteni az adatot!";
    $arr = null;
    if (isset($_POST['lastname'])) $arr = tryUpdateData("lastname", $_POST['lastname']);
    if (isset($_POST['firstname'])) $arr = tryUpdateData("firstname", $_POST['firstname']);
    if (isset($_POST['phonenumber'])) $arr = tryUpdateData("phonenumber", $_POST['phonenumber']);
    if (isset($_POST['birthdate'])) $arr = tryUpdateData("birthdate", $_POST['birthdate']);
    if (isset($_POST['idcardNumber'])) $arr = tryUpdateData("idcardNumber", $_POST['idcardNumber']);
    if (isset($_POST['licensecardNumber'])) $arr = tryUpdateData("licensecardNumber", $_POST['licensecardNumber']);
    if (isset($_POST['licensecardPlace'])) $arr = tryUpdateData("licensecardPlace", $_POST['licensecardPlace']);
    if (isset($_FILES['avatar'])) {
        if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
            if ($_FILES['avatar']['size'] <= 3145728) {
                $image_info = getimagesize($_FILES["avatar"]["tmp_name"]);
                if ($image_info[0] === $image_info[1]) {
                    $imag = $_FILES['avatar']['tmp_name'];
                    $image = file_get_contents($imag);
                    $arr = tryUpdateData("avatar", $image);
                } else
                    $exitVal = "A kép dimenziói nem megfelelők?!";
            } else
                $exitVal = "A kép mérete több mint 3MB!";
        } else {
            $exitVal = "A képet nem sikerült feltölteni a szerverre.";
        }
    }



    if($arr != null){
        $data_new = "";
        if($arr[0] != "avatar") $data_new = ' Új érték: '.$arr[1];
        $exitVal =  "Sikeresen szerkesztette a ".$input_names_arr[$arr[0]]." adatot!<br>$data_new <br> <span class='text-danger'>Az oldal 3 másodperc múlva újratöltődik!</span>";
    }
    ob_start();
    var_dump($_SESSION);
    error_log(ob_get_clean());
    exit($exitVal);
}
function checkDataLength($data, $len):bool{
    return strlen($data) >= $len;
}
function tryUpdateData($name, $value, $needed_length = 3, $sess = true): ?array
{
    $value = trim($value);
    if(!isset($value) || !checkDataLength($value, $needed_length) || !empty(UserSystem::value($name, true, $value, $sess))) return null; else return [$name, $value];
}
if(!empty($_POST) && !empty($_POST['subscribe'])){
    $is_user = true;
    $session = new Session();
    $user = $session->get('email');
    if(isset($_POST['newsletter-email'])) {$user = filter_var(trim($_POST['newsletter-email']), FILTER_VALIDATE_EMAIL) ? trim($_POST['newsletter-email']) : null; $is_user = false;}
    if($user != null && UserSystem::tryUpdateSubscription($user, $_POST['subscribe'], $is_user))
        redirection("index.php?sub=".$_POST['subscribe']);
    else
        redirection("index.php?sub=0");

    exit();
}

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

