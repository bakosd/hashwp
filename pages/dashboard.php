<?php
require_once "config.php";
$session = new Session();
if (!empty($session->get('userID'))) {
    $userID = $session->get('userID');
    $query = new SQLQuery("SELECT phonenumber, birthdate, idcardNumber, licensecardNumber, licensecardPlace FROM users WHERE usersID = :usersID LIMIT 1", [':usersID' => $session->get("userID")]);
    $result = $query->getResult()[0];

    echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script><script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script><link rel='icon' type='image/x-icon' href='../images/icons/logo-100.png'><link rel='stylesheet' href='../styles/global.css'><link rel='stylesheet' href='../styles/navbar.css'><link rel='stylesheet' href='../styles/car.css'><link rel='stylesheet' href='../styles/dashboard.css'><link rel='stylesheet' href='../styles/cards.css'><meta name='viewport' content='width=device-width,height=device-heightinitial-scale=1'><link rel='stylesheet' href='https://unpkg.com/swiper/swiper-bundle.min.css'><title>Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";

    require_once "navigation.php";

    echo "<main class='container' style='margin-top: 4.5rem'><div class='row mb-5'><h2 style='font-weight: normal'>Üdv a kezelőfelületen <b>".$session->get('firstname')."</b>!</h2></div><div class='row'>
<div class='col-lg-4 col-md-6 col-sm-12 p-4 d-flex align-items-center flex-column gap-4'><img id='user-image' class='w-100 rounded-image' src='";
    if ($session->get('avatar') != null && $session->get('avatar') != '')
        echo "data:image/jpeg;base64," . base64_encode($session->get('avatar'));
    else
        echo "../images/icons/user-default.png";
    echo "' alt='user-avatar'>";

    $password_change_modal_content = "<form id='rpassword' class='d-flex flex-column align-items-center px-4 py-4 gap-3' method='post' action='recovery.php'>
    <div class='px-1 py-1'>
        <label for='rpassword-o' class='user-select-none'>Jelenlegi jelszó</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-lock'></i>
            <input type='password' id='passwordO' name='passwordO' minlength='8' placeholder='Jelenlegi jelszó' autocomplete='false'>
        </div>
    </div>
    <div class='px-1 py-1'>
        <label for='rpassword1' class='user-select-none'>Új jelszó</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-lock'></i>
            <input type='password' id='rpassword1' name='rpassword1' minlength='8' placeholder='Új jelszó' autocomplete='false'>
        </div>
    </div>
    <div class='px-1 py-1'>
        <label for='rpassword2' class='user-select-none'>Új jelszó megerősítése</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-lock'></i>
            <input type='password' id='rpassword2' name='rpassword2' minlength='8' placeholder='Új jelszó megerősítése' autocomplete='false'>
        </div>
    </div>
    <input type='hidden' name='token' value='".UserSystem::createToken(16)."'>
</form>";
    $unsubscribe_modal_content = "<p class='p-2'>Biztos le szeretne íratkozni a <b>hírlevelünk</b>-ről?<br> Ha leíratkozik fog több értesítést kapni a legújabb akcióinkról.</p>";
    $password_change_modal = new Modal("password-change", "Jelszó változtatás", $password_change_modal_content, [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Mégsem'], ['name'=>'password-change-submit', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Megváltoztatás', 'form'=>'rpassword']]);
    $password_change_modal = $password_change_modal->getModal();
    $unsubscribe_modal = new Modal("unsubscribe", "Hírlevél leíratkozás", $unsubscribe_modal_content, [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Mégsem'], ['name'=>'password-change-submit', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Leíratkozás', 'form'=>'unsubscribe']]);
    $unsubscribe_modal = $unsubscribe_modal->getModal();


    echo "<div class='mt-2'>
                <label for='avatar'>Profilkép megváltoztatása</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon input-with-icon2 m-1 w-100'>
                            <i class='px-2 fa-solid fa-file-image'></i>
                            <input type='file' form='image-submit' name='avatar' id='avatar' accept='image/jpeg, image/png'>
                        </div>
                    </div>
                    <button type='submit' class='button' form='image-submit' id='avatar-btn'><i class='fa-solid fa-floppy-disk fa-cloud-arrow-up'></i></button>
                </div>
                <p class='w-100 my-3'><b>Figyelem!</b> A kép mérete maximum <b>3MB</b> lehet, csak is kizárlólag <b>.JPG</b> vagy <b>.PNG</b> kiterjesztésű, szélessége egyezzen meg a magassággal! (Pl: 512*512px)!</p>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-12 p-4 d-flex align-items-center flex-column gap-4'>
            <div>
                <label for='lastname'>Vezetéknév</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-signature'></i>
                            <input id='lastname' type='text' value='".$session->get('lastname')."' disabled>
                        </div>
                    </div>
                    <button class='button' id='lastname-btn' data-d-btn='true' data-d='lastname'><i class='fa-lg fa-solid fa-floppy-disk fa-wrench'></i></button>
                </div>
            </div>
            <div>
                <label for='firstname'>Keresztnév</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-signature'></i>
                            <input id='firstname' type='text' value='".$session->get('firstname')."' disabled>
                        </div>
                    </div>
                    <button class='button' id='firstname-btn' data-d-btn='true' data-d='firstname'><i class='fa-lg fa-solid fa-floppy-disk fa-wrench'></i></button>
                </div>
            </div>
            <div>
                <label for='phonenumber'>Telefonszám</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-phone'></i>
                            <input id='phonenumber' type='text' value='$result->phonenumber' disabled>
                        </div>
                    </div>
                    <button class='button' id='phonenumber-btn' data-d-btn='true' data-d='phonenumber'><i class='fa-lg fa-solid fa-floppy-disk fa-wrench'></i></button>
                </div>
            </div>

            <div>
                <label for='birthdate'>Születésnap</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-cake-candles'></i>
                            <input id='birthdate' type='text' value='$result->birthdate' disabled>
                        </div>
                    </div>
                    <button class='button' id='birthdate-btn' data-d-btn='true' data-d='birthdate'><i class='fa-lg fa-solid fa-floppy-disk fa-wrench'></i></button>
                </div>
            </div>
            <button data-bs-toggle='modal' data-bs-target='#password-change-modal' class='w-100 button d-flex align-items-center justify-content-center gap-2'><i class='fa-solid fa-lock'></i>Jelszó változtatás</button>
        </div>

        <div class='col-lg-4 col-md-6 col-sm-12 p-4 d-flex align-items-center flex-column gap-4'>

            <div>
                <label for='idcardNumber'>Személyi/Útlevél szám</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-id-card'></i>
                            <input id='idcardNumber' type='text' value='$result->idcardNumber' disabled>
                        </div>
                    </div>
                    <button class='button' id='idcardNumber-btn' data-d-btn='true' data-d='idcardNumber'><i class='fa-lg fa-solid fa-floppy-disk fa-wrench'></i></button>
                </div>
            </div>
            <div>
                <label for='licensecardNumber'>Vezetői engedély szám</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-address-card'></i>
                            <input id='licensecardNumber' type='text' value='$result->licensecardNumber' disabled>
                        </div>
                    </div>
                    <button class='button' id='licensecardNumber-btn' data-d-btn='true' data-d='licensecardNumber'><i class='fa-lg fa-solid fa-floppy-disk fa-wrench'></i></button>
                </div>
            </div>
            <div>
                <label for='licensecardPlace'>Vezetői engedély kiadási helye</label>
                <div class='d-flex gap-1'>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-map'></i>
                            <input id='licensecardPlace' type='text' value='$result->licensecardPlace' disabled>
                        </div>
                    </div>
                    <button class='button' id='licensecardPlace-btn' data-d-btn='true' data-d='licensecardPlace'><i class='fa-lg fa-solid fa-floppy-disk fa-wrench'></i></button>
                </div>
            </div>
            <button data-bs-toggle='modal' data-bs-target='#unsubscribe-modal' class='w-100 button d-flex align-items-center justify-content-center gap-2 my-3'><i class='fa-solid fa-paper-plane'></i>Leíratkozás a hírlevélről</button>
            <button form='logout' class='w-100 button d-flex align-items-center justify-content-center gap-2'><i class='fa-solid fa-right-from-bracket'></i>Kijelentkezés</button>
            <form name='logout' id='logout' action='logout.php' method='post'></form>
            <form name='unsubscribe' id='unsubscribe' action='recovery.php' method='post'><input type='hidden' name='subscribe' value='-1'></form>
            <form name='image-submit' id='image-submit' method='post'></form>
            $password_change_modal
            $unsubscribe_modal
        </div>

    </div>
</main>";

    $modal_msg = "<div class='m-2 p-2 text-center'><span id='update-alert'></span></div>";
    $modal_message = new Modal("message", "Értesítés", $modal_msg, [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Bezárás']]);
    echo $modal_message->getModal();
    require_once "footer.php";

    echo '<script src="../scripts/button-events.js"></script><script src="../scripts/events.js"></script><script src="../scripts/ajax.js"></script></body></html>';
}else
    redirection("index.php");

