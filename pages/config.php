<?php
function redirection($url)
{
    header("Location:$url");
    exit();
}

function auto_loader($className)
{
//    $file = strtolower($className) . ".php"; // person.php
    $file = $className . ".php"; // Session.php, User.php ...
    if (is_file($file)) {
        require_once $file;
    }
}

spl_autoload_register("auto_loader",true);

$messages = [
    0 => 'Nem megfelelő e-mail formátum!',
    1 => 'Nem megfelelő formátum!',
    2 => 'A jelszavak nem egyeznek vagy nem elég hosszúak.!',
    3 => 'Vezetéknév/Keresztnév/Kiadási hely minimum 3 karakter!',
    4 => 'Telefon/Személyi/Engedély szám minimum 8 karakter!',
    5 => 'A megengedett kor min 16, max 99 lehet!',
    6 => 'Sikeresen aktiválásra került a felhasználói fiók!',
    7 => 'Nem sikerült aktiválni a fiókot, mivel lejárt!',
    8 => 'Amennyiben létező e-mail, akkor <br>elküldtük a megerősítő kódot!',
    9 => 'Nem sikerült a kiküldenünk a kódot!',
    10=> 'Sikeresen visszaállítottad a fiókod!',
    11=> 'Hiba történt a kijelentkezés során!',
    12=> 'Lejárt a munkamenet! Jelentkezz be újra.'
];

/**
 * @param $message *Something to display
 * @param string $type *error, warning, success
 */
function Alert($message, string $type = 'warning'):string{

    if ($type == 'error') {
        $color = 'alert-danger';
        $type = "Hiba!";
    }
    elseif ('success') {
        $color = 'alert-success';
        $type = "Siker!";
    }
    else {
        $color = 'alert-warning';
        $type = "Figyelmeztetés!";
    }

    return '<div class="alert d-flex align-items-center gap-2 '.$color.' alert-dismissible fade show m-0" role="alert"><span class="p-0"><strong>'.$type.'</strong><br>'.$message.'</span><button type="button" class="close btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}

$register_form = '<form name="register" id="nav-register-form" method="post" action="register.php"><div class="modal-body"><div class="d-flex flex-column gap-2 px-2"><label for="email">E-mail cím <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-at"></i> <input type="text" name="email" id="email" placeholder="Email cím"></div><div class="loader loader-bad"></div></div><label for="password1x">Jelszó <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password1x" id="password1x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="password2x">Jelszó újra <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password2x" id="password2x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="lastname">Vezeték név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="lastname" id="lastname" placeholder="Vezeték név"></div><div class="loader loader-bad"></div></div><label for="firstname">Kereszt név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="firstname" id="firstname" placeholder="Kereszt név"></div><div class="loader loader-bad"></div></div><label for="birthdate">Születésnap <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-cake-candles"></i> <input type="date" name="birthdate" id="birthdate"></div><div class="loader loader-bad"></div></div><label for="phonenumber">Telefonszám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-phone"></i> <input type="text" name="phonenumber" id="phonenumber" placeholder="Telefonszám"></div><div class="loader loader-bad"></div></div><label for="idcardNumber">Személyi/útlevél szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-id-card"></i> <input type="text" name="idcardNumber" id="idcardNumber" placeholder="Személyi/útlevél szám"></div><div class="loader loader-bad"></div></div><label for="licensecardNumber">Vezetői engedély szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-address-card"></i> <input type="text" name="licensecardNumber" id="licensecardNumber" placeholder="Vezetői engedély szám"></div><div class="loader loader-bad"></div></div><label for="licensecardPlace">Kiadási helye <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-map"></i> <input type="text" name="licensecardPlace" id="licensecardPlace" placeholder="Vezetői engedély kiadási helye"></div><div class="loader loader-bad"></div></div></div></div><div class="modal-footer d-flex gap-2"><button type="button" class="button-2 px-2 d-flex justify-content-center align-items-center gap-2" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i>Mégsem</button> <button type="submit" name="register_submit" class="button px-2 d-flex justify-content-center align-items-center gap-2"><i class="fa-solid fa-circle-check"></i>Regisztráció</button></div></form>';