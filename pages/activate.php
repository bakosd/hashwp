<?php
require_once "config.php";
$token = trim($_GET['token']);


if (!empty($token) AND strlen($token) === 40) { //if token 40 then it's user activation
    if(UserSystem::tryActivate($token))
        redirection('index.php?act=6');
    else
        redirection('index.php?act=7');
}elseif (!empty($token) AND strlen($token) === 50){ //if token 50 it's password recovery.
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/icons/logo-100.png">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/cards.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>';
    include_once "navigation.php";
    echo '<main class="container">
<form id="rpassword" class="d-flex flex-column align-items-center px-4 py-4 gap-3" method="post" action="recovery.php">
    <div class="px-1 py-1">
        <label for="rpassword1" class="user-select-none">Új jelszó</label>
        <div class="login-input input-with-icon d-flex align-items-center">
            <i class="px-2 fa-solid fa-lock"></i>
            <input type="password" id="rpassword1" name="rpassword1" minlength="8" placeholder="Új jelszó" autocomplete="false">
        </div>
    </div>
    <div class="px-1 py-1">
        <label for="rpassword1" class="user-select-none">Új jelszó megerősítése</label>
        <div class="login-input input-with-icon d-flex align-items-center">
            <i class="px-2 fa-solid fa-lock"></i>
            <input type="password" id="rpassword2" name="rpassword2" minlength="8" placeholder="Új jelszó megerősítése" autocomplete="false">
        </div>
    </div>
    <input type="hidden" name="token" value="'.$token.'">
    <input class="button px-4" type="submit" name="recovery-submit" value="Jelszó visszaállítása">
</form>
<div id="alert-box" class="alert alert-info alert-dismissible fade show m-3 d-none" role="alert">
    <span id="info"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
</body>
</main>
<script src="../scripts/button-events.js"></script>
<script src="../scripts/events.js"></script>
<script>
window.addEventListener("load", function() {
    if(typeof document.getElementById("rpassword") != null) {
        document.getElementById("rpassword").addEventListener("submit", function (e) {
            e.preventDefault();
            if (checkData()) this.submit();
        });
    }
});
function checkData(){
    let returnValue = true;
    const info = document.getElementById("info");
    if(document.getElementById("rpassword1").value !== document.getElementById("rpassword2").value){
        info.innerHTML = "'.$messages[2].'";
        returnValue = false;
    }
    if(document.getElementById("rpassword1").value.length < 8 || document.getElementById("rpassword2").value.length < 8){
        info.innerHTML = "'.$messages[4].'";
        returnValue = false;
    }
    if(!returnValue)
        document.getElementById("alert-box").classList.toggle("d-block");
    return returnValue;
}
</script>
</html>';
}
?>
