<?php
$currentFile = basename($_SERVER['SCRIPT_FILENAME']);
require_once "config.php";
$session = new Session();
$session->set('admin', 0);

if ($session->get('userID') && time() > $session->get('logged')){
    $session->clear();
    redirection('index.php?log=13');
}
else
    $session->set('logged', time()+3600);

echo "<nav id='navbar' class='navbar navbar-expand-xl position-fixed fixed-top'>
    <button id='nav-toggle'
            class='button position-absolute me-3 mt-3 top-0 end-0 align-items-center justify-content-center d-none' onclick='toggleNav()'><i class='fa-solid fa-bars'></i></button>
    <div id='navToggle' class='container-fluid d-flex user-select-none '>
        <a id='logo-wrap' href='index.php'>
            <div id='logo' class='navbar-brand d-flex align-items-center mx-2 my-1'>
                <img class='user-select-none' src='../images/icons/logo-100.png' alt='logo'>
                <span class='fw-bold fs-6'>Hash.</span>
            </div>
        </a>";
if ($session->get('admin') == 1) { //NEM KELL A $session->exists('admin') rész mivel a get-ben checkelem hogy létezik-e xd
    echo "<div class='d-flex flex-nowrap align-items-center justify-content-between gap-2 navbar-nav px-1 py-1'>
            <a href='index.php' class='nav-item d-flex align-items-center link ";
    if ($currentFile == "index.php") echo "";
    echo "'><i class='me-1 fa-solid fa-house'></i><span>Kezdőoldal</span></a>
            <a href='cars.php' class='nav-item d-flex align-items-center link ";
    if ($currentFile == "cars.php" || $currentFile == "car.php") echo "";
    echo " '><i class='me-1 fa-solid fa-car'></i><span>Járművek</span></a>
            <a href='destinations.php' class='nav-item d-flex align-items-center link ";
    if ($currentFile == "destinations.php") echo "";
    echo "'><i class='me-1 fa-solid fa-location-dot'></i><span>Átvételi pontok</span></a>
            <a href='contact.php' class='nav-item d-flex align-items-center link ";
    if ($currentFile == "contact.php") echo "";
    echo "'><i class='me-1 fa-solid fa-comment'></i><span>Kapcsolat</span></a>
        </div>";
} else {
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
}
echo "<div id='search-wrap' class='d-flex flex-nowrap align-items-center gap-2 px-1 py-1'>
            <div id='search-bar' class='input-with-icon nav-item'>
                <form class='d-flex align-items-center flex-nowrap'>
                    <label for='search-input' class='text-center mx-2 fa-solid fa-magnifying-glass'></label>
                    <input name='search-input' id='search-input' type='search' aria-label='Search' placeholder='Keresés..'>
                </form>
            </div>";
if ($currentFile == "cars.php") {
    echo "<button id='search-options' class='button nav-item d-flex align-items-center justify-content-center' onclick='toggleSubmenu(1)'><i class='fa-solid fa-sliders'></i></button>";
}
echo "</div>
        <div id='nav-right' class='d-flex flex-nowrap align-items-center justify-content-center gap-2 px-1 py-1'>
            <button id='theme-changer' class='button nav-item d-flex align-items-center justify-content-center'><i class='fa-solid fa-moon'></i></button>";

if ($currentFile != "activate.php" && !$session->exists('username'))
    echo "<script src='../scripts/login-register.js'></script><button id='login-button' class='button nav-item d-flex align-items-center justify-content-center px-3' onclick='toggleSubmenu(3)'><i class='me-1 fa-solid fa-user'></i>Belépés</button>";

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
    <div id='wrap-to-top' class='d-flex align-items-center justify-content-between gap-5 px-3'>
        <div id='sub-menu-text' class='fs-5'></div>
        <button id='close-sub-menu' onclick='toggleSubmenu(0)' class='button d-flex align-items-center justify-content-center'><i class='fa-solid fa-xmark'></i></button>
    </div>
    <div id='sub-menu-content'>";
if ($currentFile == "cars.php") {
    echo "<div id='search-options-content' class='justify-content-center align-items-center'>" . "
            <form action='' class='d-flex justify-content-center flex-column align-items-center gap-2 container-fluid px-4 py-4'>
                <div class='d-flex w-100'>
                    <div class='p-1 w-50'>
                        <label for='droplist-1-toggle' class='user-select-none'>Gyártó</label>
                        <button type='button' id='droplist-1-toggle' onclick='dropdownList(\"droplist-1\", \"droplist-1-toggle\")' class='position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button'>
                            <span id='droplist-1-toggle-text' class='droplist-toggle-text'>Nincs kiválasztott</span>
                            <i class='me-2 position-absolute end-0 fa-solid fa-angle-down'></i>
                        </button>
                        <div id='droplist-1' class='droplist d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl1-cat-1' name='droplist-1' value='Audi'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl1-cat-2' name='droplist-1' value='BMW'>
                            <label for='dl1-cat-1'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><img
                                    src='../images/manufacturers/audi.png' alt='city'><span>Audi</span></label>
                            <label for='dl1-cat-2'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><img
                                    src='../images/manufacturers/bmw.png' alt='electric'><span>BMW</span></label>
                        </div>
                    </div>

                    <div class='p-1 w-50'>
                        <label for='droplist-2-toggle' class='user-select-none'>Modellek</label>
                        <button type='button' id='droplist-2-toggle' onclick='dropdownList(\"droplist-2\", \"droplist-2-toggle\")' class='position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button'>
                            <span id='droplist-2-toggle-text' class='droplist-toggle-text'>Nincs kiválasztott</span>
                            <i class='me-2 position-absolute end-0 fa-solid fa-angle-down'></i>
                        </button>
                        <div id='droplist-2' class='droplist droplist-multiselect d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl2-cat-1' name='droplist-2' value='A8'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl2-cat-2' name='droplist-2' value='RS6'>
                            <label for='dl2-cat-1'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>A8</span></label>
                            <label for='dl2-cat-2'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>RS6</span></label>
                        </div>
                    </div>
                </div>
                <div class='d-flex w-100'>
                    <div class='p-1 w-50'>
                        <label for='droplist-3-toggle' class='user-select-none'>Karosszéria</label>
                        <button type='button' id='droplist-3-toggle' onclick='dropdownList(\"droplist-3', \"droplist-3-toggle\")' class='position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button'>
                            <span id='droplist-3-toggle-text' class='droplist-toggle-text'>Nincs kiválasztott</span>
                            <i class='me-2 position-absolute end-0 fa-solid fa-angle-down'></i>
                        </button>
                        <div id='droplist-3' class='droplist droplist-multiselect d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl3-cat-1' name='droplist-3' value='Városi'>

                            <input class='d-none droplist-checkbox' type='checkbox' id='dl3-cat-3' name='droplist-3' value='Szedán'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl3-cat-4' name='droplist-3' value='Terepjáró'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl3-cat-5' name='droplist-3' value='Limuzin'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl3-cat-6' name='droplist-3' value='Kabrió'>
                            <label for='dl3-cat-1'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><img
                                    src='../images/icons/carspecs/bodywork/city.png' alt='city'><span>Városi</span></label>
                            <label for='dl3-cat-3'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><img
                                    src='../images/icons/carspecs/bodywork/sedan.png' alt='sedan'><span>Szedán</span></label>
                            <label for='dl3-cat-4'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><img
                                    src='../images/icons/carspecs/bodywork/jeep.png' alt='jeep'><span>SUV/4x4</span></label>
                            <label for='dl3-cat-5'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><img
                                    src='../images/icons/carspecs/bodywork/limousine.png' alt='limousine'><span>Limuzin</span></label>
                            <label for='dl3-cat-6'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><img
                                    src='../images/icons/carspecs/bodywork/convertible.png' alt='convertible'><span>Kabrió</span></label>
                        </div>
                    </div>
                    <div class='p-1 w-50'>
                        <label for='droplist-4-toggle' class='user-select-none'>Ülések száma</label>
                        <button type='button' id='droplist-4-toggle' onclick='dropdownList(\"droplist-4\", \"droplist-4-toggle\")' class='position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button'>
                            <span id='droplist-4-toggle-text' class='droplist-toggle-text'>Nincs kiválasztott</span>
                            <i class='me-2 position-absolute end-0 fa-solid fa-angle-down'></i>
                        </button>
                        <div id='droplist-4' class='droplist d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl4-cat-1' name='droplist-4' value='2'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl4-cat-2' name='droplist-4' value='4'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl4-cat-3' name='droplist-4' value='5'>
                            <label for='dl4-cat-1'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>2</span></label>
                            <label for='dl4-cat-2'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>4</span></label>
                            <label for='dl4-cat-3'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>5</span></label>
                        </div>
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
                <div class='d-flex w-100 gap-2 justify-content-around'>
                    <div class='d-flex gap-2'>
                        <input type='radio' name='price-time' value='day' id='price-day' checked>
                        <label for='price-day'>Napi</label>
                    </div>
                    <div class='d-flex gap-2'>
                        <input type='radio' name='price-time' value='week' id='price-week'>
                        <label for='price-week'>Heti</label>
                    </div>
                    <div class='d-flex gap-2'>
                        <input type='radio' name='price-time' value='month' id='price-month'>
                        <label for='price-month'>Havi</label>
                    </div>
                </div>
                <div class='d-flex w-100'>
                    <div class='p-1 w-50'>
                        <label for='droplist-5-toggle' class='user-select-none'>Üzemanyag</label>
                        <button type='button' id='droplist-5-toggle' onclick='dropdownList(\"droplist-5\", \"droplist-5-toggle\")' class='position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button'>
                            <span id='droplist-5-toggle-text' class='droplist-toggle-text'>Nincs kiválasztott</span>
                            <i class='me-2 position-absolute end-0 fa-solid fa-angle-down'></i>
                        </button>
                        <div id='droplist-5' class='droplist droplist-multiselect d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl5-cat-1' name='droplist-5' value='Benzin'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl5-cat-2' name='droplist-5' value='Dízel'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl5-cat-3' name='droplist-5' value='Benzin + Gáz'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl5-cat-4' name='droplist-5' value='Áram'>
                            <label for='dl5-cat-1'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>Benzin</span></label>
                            <label for='dl5-cat-2'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>Dízel</span></label>
                            <label for='dl5-cat-3'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>Benzin + Gáz</span></label>
                            <label for='dl5-cat-4'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>Áram</span></label>
                        </div>
                    </div>
                    <div class='p-1 w-50'>
                        <label for='droplist-6-toggle' class='user-select-none'>Váltó típusa</label>
                        <button type='button' id='droplist-6-toggle' onclick='dropdownList(\"droplist-6\", \"droplist-6-toggle\")' class='position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button'>
                            <span id='droplist-6-toggle-text' class='droplist-toggle-text'>Nincs kiválasztott</span>
                            <i class='me-2 position-absolute end-0 fa-solid fa-angle-down'></i>
                        </button>
                        <div id='droplist-6' class='droplist d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl6-cat-1' name='droplist-6' value='Manuális'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl6-cat-2' name='droplist-6' value='Automata'>
                            <input class='d-none droplist-checkbox' type='checkbox' id='dl6-cat-3' name='droplist-6' value='Pillangó'>
                            <label for='dl6-cat-1'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>Manuális</span></label>
                            <label for='dl6-cat-2'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>Automata</span></label>
                            <label for='dl6-cat-3'
                                   class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'><span>Pillangó</span></label>
                        </div>
                    </div>
                </div>
                <div class='p-1 w-100'>
                    <input class='button w-100' type='submit' name='login-submit' value='Keresés'>
                </div>
            </form>
        </div>";
}
require_once "config.php";
if ($session->exists('username') && $session->get('state') > 0){
echo "<!--LOGGED USER-->
        <form name='logout' id='logout' action='logout.php' method='post'></form>
        <div id='user-data-content' class='justify-content-center align-items-center flex-wrap flex-column gap-2'>
            <button id='user-data-link' onclick='' class='button'><img id='user-image' src='";

if($session->get('avatar')!= null && $session->get('avatar') != '')
    echo "data:image/jpeg;base64,".base64_encode($session->get('avatar'));
else
    echo "../images/icons/user-default.png";
            echo "' alt='user-avatar'></button>
            <label id='user-name-sb' class='user-select-none'>".$session->get('lastname')." ".$session->get('firstname');
            if($session->get('level') > 1){
                echo "<i class='ms-2 fa-solid fa-circle-check'></i>";
                }
            echo"</label>
            
            <button id='logout-user' type='submit' form='logout' class='button d-flex align-items-center gap-2 px-3 py-1 mb-2'><i class='fa-solid fa-right-from-bracket'></i><span>Kijelentkezés</span></button>
            <a href='#' class='sub-link d-flex align-items-center link  w-100'><i class='me-1 fa-solid fa-heart'></i><span>Kedvencek</span></a>
            <a href='#' class='sub-link d-flex align-items-center link  w-100'><i class='me-1 fa-solid fa-chart-line'></i><span>Előzmények</span></a>
            <a href='#' class='sub-link d-flex align-items-center link  w-100'><i class='me-1 fa-solid fa-star-half-stroke'></i><span>Értékelések</span></a>
            <a href='#' class='sub-link d-flex align-items-center link  w-100'><i class='me-1 fa-solid fa-user-pen'></i><span>Profilom</span></a>
            <!--<a href='#' class='sub-link d-flex align-items-center link  w-100'><i class='me-1 fa-solid fa-fingerprint'></i><span>Admin felület</span></a>-->
        </div>";
}
else
        echo "<!--NOT LOGGED USER-->
        <div id='login-content' class='justify-content-center align-items-center d-flex flex-column'>
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
</div>
<div class='modal fade' id='register-modal' tabindex='-1' aria-labelledby='register' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div id='reg-modal-content' class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title fw-2' id='register'>Regisztráció</h5>
                                    <button type='button' class='button d-flex justify-content-center align-items-center' data-bs-dismiss='modal' aria-label='Close'><i class='fa-solid fa-xmark'></i></button>
                                </div>
                                <div id='reg-result'></div>
                                $register_form
                            </div>
                        </div>
                    </div>";
?>
