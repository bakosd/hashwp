<?php
require_once "config.php";
if(isset($_POST['user']) && isset($_POST['password'])) {
    $user = trim($_POST['user']);
    $password = trim($_POST['password']);
    if (!empty($user) && !empty($password)) {
        if (strlen($user) > 3 && strlen($password) >= 8) {
            $operation = UserSystem::tryLogin($user, $password);
            if ($operation == "Sikeresen bejelentkeztél!") {
                echo '<script> $(document).ready(function () {  setTimeout(function (){location.reload();}, 50)} ); </script>';
            } else
                echo Alert($operation, 'error');
        } else {
            echo Alert("Hibás adat hossz..", 'error');
        }
    } else
        echo Alert("Üres mezők..", 'error');
}else
    echo Alert("Üres mezők..", 'error');
?>