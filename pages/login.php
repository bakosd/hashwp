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
                //echo $operation;
            } else
                echo $operation;
        } else {
            echo "Hibás adat hossz..";
        }
    } else
        echo "Üres adatok..";
}else
    echo "<script>console.log('no data on submit')</script>";
?>