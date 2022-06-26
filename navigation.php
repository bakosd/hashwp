<?php
$currentFile = basename($_SERVER['SCRIPT_FILENAME']);
require_once "config.php";
$session = new Session();

if ($session->get('userID') && time() > $session->get('logged')){
    $session->clear();
    redirection('index.php?message=14');
}
else
    $session->set('logged', time()+3600);

    echo "<nav id='navbar' class='navbar navbar-expand-xl position-fixed fixed-top'>
    <button id='nav-toggle'
            class='button position-absolute me-3 mt-3 top-0 end-0 align-items-center justify-content-center d-none' onclick='toggleNav()'><i class='fa-solid fa-bars'></i></button>
    <div id='navToggle' class='container-fluid d-flex user-select-none '>";
    if(empty($session->get('edit')))
    {
        $session->set('edit', 0);
    }

if ($session->get('level') >= 2 && $session->get('edit') == 1) { //NEM KELL A $session->exists('admin') rész mivel a get-ben checkelem hogy létezik-e xd
            if($currentFile == "index.php")
            {
                $session->set('edit', 0);
                echo "<script>$('#navbar').load(location.href + ' #navbar');</script>";
            }

            echo "
            <a id='logo-wrap' href='index.php'>
                <div id='logo' class='navbar-brand d-flex align-items-center mx-2 my-1'>
                    <img class='user-select-none' src='images/icons/logo-100.png' alt='logo'>
                    <span class='fw-bold fs-6'>Hash.</span>
                </div>
            </a>";
            echo "<div class='d-flex flex-nowrap align-items-center justify-content-between gap-2 navbar-nav px-1 py-1'>
                <a href='admin_index.php' class='nav-item d-flex align-items-center link ";
            if ($currentFile == "admin_index.php") echo "active-page";
            echo "'><i class='me-1 fa-solid fa-house'></i><span>Áttekintés</span></a>";

            if ($session->get('level') > 2) {
                echo "<a href='cars.php' class='nav-item d-flex align-items-center link ";
                if ($currentFile == "cars.php") echo "active-page";
                echo "'><i class='me-1 fa-solid fa-car'></i><span>Járművek</span></a>
                    <a href='destinations.php' class='nav-item d-flex align-items-center link ";
                if ($currentFile == "destinations.php") echo "active-page";
                echo "'><i class='me-1 fa-solid fa-location-dot'></i><span>Átvételi pontok</span></a>";
                echo "<a href='admin_newsletter.php' class='nav-item d-flex align-items-center link ";
                if ($currentFile == "admin_newsletter.php") echo "active-page";

                echo "'><i class='me-1 fa-solid fa-newspaper'></i><span>Hírlevél</span></a>";
            }
                   echo "<a href='admin_users.php' class='nav-item d-flex align-items-center link ";
                if ($currentFile == "admin_users.php") echo "active-page";

            echo "'><i class='me-1 fa-solid fa-users'></i><span>Fiókok</span></a>
                </div>"; 
            echo "<div id='search-wrap' class='d-flex flex-nowrap align-items-center gap-2 px-1 py-1'>";
        }
        else
        {
            if($currentFile == "admin_index.php" || $currentFile == "admin_users.php")
            {
                if($session->get('level') >= 2){
                    $session->set('edit', 1);
                    echo "<script>$('#navbar').load(location.href + ' #navbar');</script>";
                }
                else{
                    header('Location: index.php');
                }
            }
            echo "
            <a id='logo-wrap' href='index.php'>
                <div id='logo' class='navbar-brand d-flex align-items-center mx-2 my-1'>
                    <img class='user-select-none' src='images/icons/logo-100.png' alt='logo'>
                    <span class='fw-bold fs-6'>Hash.</span>
                </div>
            </a>";
            echo "<div class='d-flex flex-nowrap align-items-center justify-content-between gap-2 navbar-nav px-1 py-1'>
                <a href='index.php' class='nav-item d-flex align-items-center link ";
            if ($currentFile == "index.php") echo "active-page";
            echo "'><i class='me-1 fa-solid fa-house'></i><span>Kezdőoldal</span></a>
                    <a href='cars.php' class='nav-item d-flex align-items-center link ";
            if ($currentFile == "cars.php" || $currentFile == "car.php") echo "active-page";
            echo " '><i class='me-1 fa-solid fa-car'></i><span>Járművek</span></a>
                    <a href='destinations.php' class='nav-item d-flex align-items-center link ";
            if ($currentFile == "destinations.php") echo "active-page";
            echo "'><i class='me-1 fa-solid fa-location-dot'></i><span>Átvételi pontok</span></a>
                    <a href='contact.php' class='nav-item d-flex align-items-center link ";
            if ($currentFile == "contact.php") echo "active-page";
            echo "'><i class='me-1 fa-solid fa-comment'></i><span>Kapcsolat</span></a>
                </div>"; 
                
            echo "<div id='search-wrap' class='d-flex flex-nowrap align-items-center gap-2 px-1 py-1'>
            <div id='search-bar' class='input-with-icon nav-item'>
                <form class='d-flex align-items-center flex-nowrap'>
                    <label for='search-input' class='text-center mx-2 fa-solid fa-magnifying-glass'></label>
                    <input name='search-input' id='search-input' form='search' type='search' aria-label='Search' placeholder='Keresés..'>
                </form>
            </div>";
        }
if ($currentFile == "cars.php" || $currentFile == "car.php") {
    if ($session->get('edit') != 1)
    echo "<button id='search-options' class='button nav-item d-flex align-items-center justify-content-center' onclick='toggleSubmenu(1)'><i class='fa-solid fa-sliders'></i></button>";
}
echo "</div>
        <div id='nav-right' class='d-flex flex-nowrap align-items-center justify-content-center gap-2 px-1 py-1'>
            <button id='theme-changer' class='button nav-item d-flex align-items-center justify-content-center'><i class='fa-solid fa-moon'></i></button>";

if ($currentFile != "activate.php" && !$session->exists('username'))
    echo "<script src='scripts/ajax.js'></script><button id='login-button' class='button nav-item d-flex align-items-center justify-content-center px-3' onclick='toggleSubmenu(3)'><i class='me-1 fa-solid fa-user'></i>Belépés</button>";

if ($session->exists('username') && $session->get('state') > 0) {
    echo "<button id='user-data' onclick='toggleSubmenu(2)' class='button'><img src='";
    if ($session->get('avatar') != null && $session->get('avatar') != '')
        echo "data:image/jpeg;base64,".base64_encode($session->get('avatar'));
    else
        echo "../images/icons/user-default.png";
    echo "' alt='myAvatar'></button>
            <label id='user-name' for='user-data' class='user-select-none d-none'>" . $session->get('lastname') . " " . $session->get('firstname') . "</label>";
}
echo "</div>
    </div>
</nav>
<div id='wrap-nav-height'></div>
<div id='sub-menu' class='align-items-start justify-content-start d-none flex-column'>
    <div id='wrap-to-top' class='d-flex align-items-center justify-content-between gap-2 px-3'>
        <div id='sub-menu-text' class='fs-5'></div>
        <button id='close-sub-menu' onclick='toggleSubmenu(0)' class='button d-flex align-items-center justify-content-center'><i class='fa-solid fa-xmark'></i></button>
    </div>
    <div id='sub-menu-content'>";
if ($currentFile == "cars.php" || $currentFile == "car.php") {
    $bodywork_array = []; $seat_array = []; $fuel_array = []; $gearbox_array = []; $manufacturers_array = [];
    $bq = new SQLQuery("SELECT DISTINCT bodywork FROM cars", []); $bodywork_array = $bq->getResult();
    $bq = new SQLQuery("SELECT DISTINCT seats FROM cars", []); $seat_array = $bq->getResult();
    $bq = new SQLQuery("SELECT DISTINCT fuel FROM cars", []); $fuel_array = $bq->getResult();
    $bq = new SQLQuery("SELECT DISTINCT gearbox FROM cars", []); $gearbox_array = $bq->getResult();
    $bq = new SQLQuery("SELECT name as manufacturer FROM manufactures", []); $manufacturers_array = $bq->getResult();

    echo "<div id='search-options-content' class='justify-content-center align-items-center'>" . "
            <form id='search' action='cars.php' method='post' class='d-flex justify-content-center flex-column align-items-center gap-2 container-fluid px-4 py-4'>
                    <div class='p-1 w-100'>
                        " .dropdownButton('Gyártó', 'manufacturer', $manufacturers_array, 'manufacturers')."
                    </div>
                <div class='d-flex w-100'>
                    <div class='p-1 w-50'>
                        ".dropdownButton('Karosszéria', 'bodywork', $bodywork_array, 'icons/carspecs/bodywork')."
                    </div>
                    <div class='p-1 w-50'>
                        ".dropdownButton('Ülések száma', 'seats', $seat_array)."
                    </div>
                </div>
                <div class='w-100 p-1 d-flex flex-column justify-content-center align-items-center slider-outer-wrap'>
                    <label class='px-1 text-left user-select-none w-100'>Bérleti ár</label>
                    <div class='d-flex justify-content-center p-1 gap-2 w-100 num-input'>
                        <div class='submit-input input-with-icon d-flex align-items-center min'>
                            <label for='min2' class='pe-3 fa-solid fa-circle-minus'></label>
                            <input class='ms-1 w-50' type='number' id='min2' name='min' value='0' min='0' max='400'>
                        </div>
                        <div class='submit-input input-with-icon d-flex align-items-center max'>
                            <label for='max2' class='pe-3 fa-solid fa-circle-plus'></label>
                            <input class='ms-1 w-50' type='number' id='max2' name='max' value='500' min='100' max='500'>
                        </div>
                    </div>
                    <div class='slider position-relative w-100'>
                        <div class='slider-bg w-100 position-absolute'></div>
                        <div class='slider-progress position-absolute'></div>
                        <input type='hidden' name='gap' value='200'>
                        <div class='slider-input w-100'>
                            <input class='w-100 position-absolute' name='min' type='range' min='0' max='400' value='0' step='1'>
                            <input class='w-100 position-absolute' name='max' type='range' min='100' max='500' value='500' step='1'>
                        </div>
                    </div>
                </div>
                <div class='d-flex w-100'>
                    <div class='p-1 w-50'>
                       ".dropdownButton('Üzemanyag', 'fuel', $fuel_array)."
                    </div>
                    <div class='p-1 w-50'>
                        ".dropdownButton('Váltó típusa', 'gearbox', $gearbox_array)."
                    </div>
                </div>
                <div class='p-1 w-100'>
                    <input class='button w-100' type='submit' name='login-submit' value='Keresés'>
                </div>
            </form>
        </div>
       ";
}
require_once "config.php";
if ($session->exists('username') && $session->get('state') > 0){
echo "<!--LOGGED USER-->
        <form name='logout' id='logout' action='logout.php' method='post'></form>
        <div id='user-data-content' class='justify-content-center align-items-center flex-wrap flex-column gap-2'>
            <button type='button' onclick='" .'location.href="dashboard.php";'."' id='user-data-link' class='button'><img id='user-image' src='";

if($session->get('avatar')!= null && $session->get('avatar') != '')
    echo "data:image/jpeg;base64,".base64_encode($session->get('avatar'));
else
    echo "../images/icons/user-default.png";
            echo "' alt='user-avatar'></button>
            <label id='user-name-sb' class='user-select-none'>".$session->get('lastname')." ".$session->get('firstname');
            if($session->get('level') > 1){
                echo "<i class='ms-2 fa-solid fa-circle-check'></i>";
                }
            echo "</label>
            
            <button id='logout-user' type='submit' form='logout' class='button d-flex align-items-center gap-2 px-3 py-1 mb-2'><i class='fa-solid fa-right-from-bracket'></i><span>Kijelentkezés</span></button>
            <a href='dashboard.php' class='sub-link d-flex align-items-center link  w-100 ";
    if ($currentFile == "dashboard.php") echo "active-page"; echo "'><i class='me-1 fa-solid fa-user-pen'></i><span>Profilom</span></a>
            <a href='favorites.php' class='sub-link d-flex align-items-center link w-100 ";
    if ($currentFile == "favorites.php") echo "active-page"; echo "'><i class='me-1 fa-solid fa-heart'></i><span>Kedvenceim</span></a>
            <a href='history.php' class='sub-link d-flex align-items-center link w-100 ";
    if ($currentFile == "history.php") echo "active-page"; echo "'><i class='me-1 fa-solid fa-chart-line'></i><span>Előzmények</span></a>";
            if($session->get('level') >= 2)
            {
                if($session->get('edit') == 0)
                {
                    echo "<a href='admin_index.php' class='sub-link d-flex align-items-center link  w-100'><i class='me-1 fa-solid fa-fingerprint'></i><span>Admin felület</span></a>";
                }
                else
                {
                    echo "<a href='index.php' class='sub-link d-flex align-items-center link  w-100'><i class='me-1 fa-solid fa-house'></i><span>Kezdőoldal</span></a>";
                }
            }

        echo "</div>";
}
else
        echo "<!--NOT LOGGED USER-->
        <div id='login-content' class='justify-content-center align-items-center flex-column'>
        <form class='d-flex flex-column gap-3' name='recovery' id='recovery_form' method='post'></form>
        <form class='d-flex flex-column w-100' id='login-form' name='login-form' method='post'></form>
            <div class='d-flex flex-column px-4 py-4 gap-3 w-100'>
                <div class='px-1 py-1'>
                    <label for='user-name-log' class='user-select-none'>Felhasználónév</label>
                    <div class='login-input input-with-icon d-flex align-items-center'>
                        <i class='px-2 fa-solid fa-user'></i>
                        <input type='text' form='login-form' id='user-name-log' name='user-name-log' maxlength='60' minlength='5' placeholder='Felhasználónév' autocomplete='false'>
                    </div>
                </div>
                <div class='px-1 py-1'>
                    <label for='user-password-log' class='user-select-none'>Jelszó</label>
                    <div class='login-input input-with-icon d-flex align-items-center'>
                        <i class='px-2 fa-solid fa-key'></i>
                        <input type='password' form='login-form' id='user-password-log' name='user-password-log' maxlength='120' minlength='5' placeholder='Jelszó' autocomplete='false'>
                    </div>
                </div>
                <a id='forgot-password' class='user-select-none'>Elfelejtette a jelszavát?</a>
                <hr>
                <input class='button' type='submit' form='login-form' name='login-submit' value='Bejelentkezés'>
                <button id='nav-register-button' type='button' class='button-2' data-bs-toggle='modal' data-bs-target='#register-modal'>Regisztráció</button>
            </div>
        </div>";

    echo "</div>
</div>";
$modal = new Modal(
    'register',
    "Regisztráció",
    $register_form,
    [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Mégsem'],
    ['name'=>'register_submit', 'form'=>'nav-register-form', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Regisztráció']
]);
echo $modal->getModal();
?>
