<?php
include_once "config.php";
$response = null;
if (!empty($_POST)) {
    if (isset($_POST['password1x']) && isset($_POST['password2x']) && isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birthdate']) && isset($_POST['phonenumber']) && isset($_POST['idcardNumber']) && isset($_POST['licensecardNumber']) && isset($_POST['licensecardPlace'])) {
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
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = Alert($messages[17], 'error');
            $error = true;
        }
        if (strlen($password1x) < 8 || strlen($password2x) < 8 || $password1x !== $password2x) {
            $response = Alert($messages[2], 'error');
            $error = true;
        }
        if (strlen($firstname) < 3 || strlen($licensecardPlace) < 3 || strlen($lastname) < 3) {
            $response = Alert($messages[3], 'error');
            $error = true;
        }
        if (strlen($phonenumber) < 8 || strlen($licensecardNumber) < 8 || strlen($idcardNumber) < 8) {
            $response = Alert($messages[4], 'error');
            $error = true;
        }
        $diff = date_diff(date_create($birthdate), date_create());
        if($diff->y < 16 || $diff->y > 99){
            $response = Alert($messages[5], 'error');
            $error = true;
        }

        if (!$error) {
            $username = UserSystem::getUsernameFromEmail($email);
            $reg_data = UserSystem::tryRegister($username, $password1x, $firstname, $lastname, $birthdate, $email, $phonenumber, $idcardNumber, $licensecardNumber, $licensecardPlace);
            if ($reg_data != "Sikeres regisztráció.") {
                $response = Alert($reg_data, 'error');
            } else
                $response = Alert($reg_data, 'success');
        }
        echo $response;
    }
}
else
    redirection('index.php');
