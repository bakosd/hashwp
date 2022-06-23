<?php
define('HASH_MAIL', 'hash_support@gmail.hu');
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

spl_autoload_register("auto_loader", true);

$messages = [
    0 => 'Nem sikerült a művelet!',
    1 => 'Nem megfelelő formátum!',
    2 => 'A jelszavak nem egyeznek vagy nem elég hosszúak.!',
    3 => 'Vezetéknév/Keresztnév/Kiadási hely minimum 3 karakter!',
    4 => 'Telefon/Személyi/Engedély szám minimum 8 karakter!',
    5 => 'A megengedett kor min 16, max 99 lehet!',
    6 => 'Sikeresen aktiválásra került a felhasználói fiók!',
    7 => 'Nem sikerült aktiválni a fiókot, mivel lejárt!',
    8 => 'Amennyiben létező e-mail, akkor <br>elküldtük a megerősítő kódot!',
    9 => 'Nem sikerült a kiküldenünk a kódot!',
    10 => 'Sikeresen visszaállítottad a fiókod!',
    11 => 'Hiba történt a kijelentkezés során!',
    12 => 'Lejárt a munkamenet! Jelentkezz be újra.',
    13 => 'Nem sikerült a visszaállítani a jelszavad!',
    14 => 'Lejárt a munkamenet! Jelentkezz be újra!',
    15 => 'Sikeresen feliratkoztál a hírlevélre!',
    16 => 'Sikeresen leíratkoztál a hírlevélről!',
    17 => 'Nem megfelelő e-mail formátum!',
    18 => 'Nem sikerült elküldeni-e az üzenetet!',
    19 => 'Sikeresen elküldte az üzenetet a csapatunknak!',
    20 => 'Sikeresen körbeküldte a hírlevelet!',
    21 => 'Nem sikerült körbeküldeni a hírlevelet!',
];

$input_names_arr = ['lastname' => 'Vezetéknév', 'firstname' => 'Keresztnév', 'phonenumber' => 'Telefonszám', 'birthdate' => 'Születésnap', 'idcardNumber' => 'Személyi/Útlevél szám', 'licensecardNumber' => 'Vezetői engedély szám', 'licensecardPlace' => 'Vezetői engedély kiadási helye', 'avatar' => 'Profilkép'];

/**
 * @param $message *Something to display
 * @param string $type *error, warning, success
 */
function Alert($message, string $type = 'warning'): string
{

    if ($type == 'error') {
        $color = 'alert-danger';
        $type = "Hiba!";
    } elseif ('success') {
        $color = 'alert-success';
        $type = "Siker!";
    } else {
        $color = 'alert-warning';
        $type = "Figyelmeztetés!";
    }

    return '<div class="alert d-flex align-items-center gap-2 ' . $color . ' alert-dismissible fade show m-0" role="alert"><span class="p-0"><strong>' . $type . '</strong><br>' . $message . '</span><button type="button" class="close btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}

//$register_form = '<form name="register" id="nav-register-form" method="post" action="register.php"><div class="modal-body"><div class="d-flex flex-column gap-2 px-2"><label for="email">E-mail cím <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-at"></i> <input type="text" name="email" id="email" placeholder="Email cím"></div><div class="loader loader-bad"></div></div><label for="password1x">Jelszó <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password1x" id="password1x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="password2x">Jelszó újra <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password2x" id="password2x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="lastname">Vezeték név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="lastname" id="lastname" placeholder="Vezeték név"></div><div class="loader loader-bad"></div></div><label for="firstname">Kereszt név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="firstname" id="firstname" placeholder="Kereszt név"></div><div class="loader loader-bad"></div></div><label for="birthdate">Születésnap <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-cake-candles"></i> <input type="date" name="birthdate" id="birthdate"></div><div class="loader loader-bad"></div></div><label for="phonenumber">Telefonszám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-phone"></i> <input type="text" name="phonenumber" id="phonenumber" placeholder="Telefonszám"></div><div class="loader loader-bad"></div></div><label for="idcardNumber">Személyi/útlevél szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-id-card"></i> <input type="text" name="idcardNumber" id="idcardNumber" placeholder="Személyi/útlevél szám"></div><div class="loader loader-bad"></div></div><label for="licensecardNumber">Vezetői engedély szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-address-card"></i> <input type="text" name="licensecardNumber" id="licensecardNumber" placeholder="Vezetői engedély szám"></div><div class="loader loader-bad"></div></div><label for="licensecardPlace">Kiadási helye <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-map"></i> <input type="text" name="licensecardPlace" id="licensecardPlace" placeholder="Vezetői engedély kiadási helye"></div><div class="loader loader-bad"></div></div></div></div><div class="modal-footer d-flex gap-2"><button type="button" class="button-2 px-2 d-flex justify-content-center align-items-center gap-2" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i>Mégsem</button> <button type="submit" name="register_submit" class="button px-2 d-flex justify-content-center align-items-center gap-2"><i class="fa-solid fa-circle-check"></i>Regisztráció</button></div></form>';
$register_form = '<form name="register" id="nav-register-form" method="post" action="register.php"><div class="modal-body"><div class="d-flex flex-column gap-2 px-2"><label for="email">E-mail cím <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-at"></i> <input type="text" name="email" id="email" placeholder="Email cím"></div><div class="loader loader-bad"></div></div><label for="password1x">Jelszó <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password1x" id="password1x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="password2x">Jelszó újra <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password2x" id="password2x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="lastname">Vezeték név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="lastname" id="lastname" placeholder="Vezeték név"></div><div class="loader loader-bad"></div></div><label for="firstname">Kereszt név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="firstname" id="firstname" placeholder="Kereszt név"></div><div class="loader loader-bad"></div></div><label for="birthdate">Születésnap <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-cake-candles"></i> <input type="date" name="birthdate" id="birthdate"></div><div class="loader loader-bad"></div></div><label for="phonenumber">Telefonszám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-phone"></i> <input type="text" name="phonenumber" id="phonenumber" placeholder="Telefonszám"></div><div class="loader loader-bad"></div></div><label for="idcardNumber">Személyi/útlevél szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-id-card"></i> <input type="text" name="idcardNumber" id="idcardNumber" placeholder="Személyi/útlevél szám"></div><div class="loader loader-bad"></div></div><label for="licensecardNumber">Vezetői engedély szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-address-card"></i> <input type="text" name="licensecardNumber" id="licensecardNumber" placeholder="Vezetői engedély szám"></div><div class="loader loader-bad"></div></div><label for="licensecardPlace">Kiadási helye <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-map"></i> <input type="text" name="licensecardPlace" id="licensecardPlace" placeholder="Vezetői engedély kiadási helye"></div><div class="loader loader-bad"></div></div></div></div></form>';

/**
 * @param $type // carousel || carousel-item
 * @param array|null $where // ARRAY-LITERAL ['param':'value..] If u want to generate by specific condition.
 * @param int $limit // INT If u want to limit the generated cards like 10, 1 etc.
 * @return string
 */

function cardBig(string $type = "", array $where = null, string $order_by = null, int $limit = PHP_INT_MAX): string
{
    $returnValue = "";
    $order_by = $order_by == null ? '' : ', ' . $order_by;
    $conditions = '';
    if ($where != null && !empty($where)) {
        $conditions = 'WHERE ';
        $counter = 0;
        foreach ($where as $value) {
            if (!is_numeric($value['val'])) $value['val'] = "'" . $value['val'] . "'";
            if (count($where) > 1) {

                if (++$counter == count($where)) {
                    $conditions .= $value['data'] . $value['op'] . $value['val'];
                } else {
                    $operation_space = " AND ";
                    if ($value['op'] == " LIKE ")
                        $operation_space = " OR ";
                    $conditions .= $value['data'] . $value['op'] . $value['val'] . $operation_space;

                }
            } else
                $conditions .= $value['data'] . $value['op'] . $value['val'];

        }
    }

    if (isset($_POST['search-input'])) {
        if (strlen(trim($_POST['search-input'])) != 0) {
            $sh_str = trim($_POST['search-input']);
            $search_input = "ms.name LIKE '%$sh_str%' OR carname LIKE '%$sh_str%' OR engine LIKE '%$sh_str%' OR releasedate LIKE '%$sh_str%' OR bodywork LIKE '%$sh_str%' OR fuel LIKE '%$sh_str%'";
            $conditions = strlen($conditions) > 0 ? $conditions . " AND " . $search_input : " WHERE " . $search_input;
        }
    }
    $query = new SQLQuery("SELECT ms.name AS manufacturer, carname, engine, releasedate, cars.status, price, discount, carsID, bodywork, horsepower, seats, doors, fuel, carsID FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID)" . $conditions . " ORDER BY status ASC, ms.name ASC, carname ASC $order_by LIMIT $limit;", []);
    $result = $query->getResult();
/*     echo "<pre>";
         var_dump($_POST);
     echo "</pre>";*/
    if ($result != null) {
        $i = 0;
        foreach ($result as $item) {
            if (isset($_POST['pick-date']) && isset($_POST['drop-date'])) {
                $session = new Session();
                $session->set('temp_rent_start', $_POST['pick-date']);
                $session->set('temp_rent_end', $_POST['drop-date']);
                $q = new SQLQuery("SELECT rentStartdate, rentEnddate, carID FROM orders where carID = :carID", [":carID" => $item->carsID]);
                $res = $q->getResult();
                foreach ($res as $order) {
                    if ((($order->rentStartdate <= $_POST['drop-date']) && ($order->rentEnddate >= $_POST['pick-date']))){
                        $returnValue = "<div>";
                        continue 2;
                    }
                }
            }
            $discount = 0;
            if ($item->discount > 0) {
                $discount = number_format((double)$item->price - ((double)$item->price * (double)$item->discount / 100), 2);
            }
            if ($i++ == 0){
                $returnValue = "<div class='col width-270' data-sort='$item->price' data-discount='$discount'>";
                $returnValue = $type == "carousel-item" ? $returnValue . '<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel"><div class="carousel-inner">' : $returnValue . '';
            }
            if ($type == "carousel-item" && $item == $result[0])
                $returnValue .= "<div class='carousel-item active'>";
            else if ($type == "carousel-item")
                $returnValue .= "<div class='carousel-item'>";
            else if ($type == 'carousel' && $item != $result[0])
                $returnValue .= "</div><div class='col width-270' data-sort='$item->price' data-discount='$discount'><div class='carousel'>";
            else $returnValue .= "<div class='carousel'>";
//                $returnValue .= "<button style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;' onclick='location.href=\"../pages/car.php?car=".$item->manufacturer.$item->carname.$item->releasedate."\"'>";
            $returnValue .= "<button onclick='location.href=\"../pages/car.php?car=" . $item->carsID . "\"' style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;'>" . "<div class='slider-img'><img src='../images/cars/$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png' class='d-block w-75 mx-auto' alt='$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png'></div><div class='text'><div><img src='../images/manufacturers/".strtolower($item->manufacturer).".png' width='45px' class='px-1' alt='$item->manufacturer icon'>&nbsp;<b>$item->carname</b>&nbsp;<span>$item->engine $item->releasedate</span></div><div class='action-price'>";
            if ($item->discount > 0) {
                $returnValue .= "<span>Akciós ár:</span>&nbsp;<span class='price'><b>$discount €</b><del>$item->price €</del></span>";
            } else
                $returnValue .= "<span>Napi ár:</span>&nbsp;<span class='price'><b>$item->price €</b></span>";

            $returnValue .= "</div></div></button></div>";
        }


        if ($type == "carousel-item")
            $returnValue .= '</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button><button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button></div></div>';
        else
            $returnValue .= '</div></div></div>';
    } else {
        $returnValue .= "<div class='width-270 col'><div class='carousel'><div class='slider-img'><img src='../images/cars/ghost.png' class='d-block mx-auto py-5' alt='ghost.png'><div class='text-center'><div class='text'>Nincs jármű találat.</div></div></div></div></div>";
    }
    return $returnValue;
    //return "";
}

function generateStars(float $rating): string
{
    $stars = ['<i class="fa-regular fa-star"></i>', '<i class="fa-solid fa-star-half-stroke"></i>', '<i class="fa-solid fa-star"></i>'];
    $rating = floor($rating * 2) / 2;
    $value = "";
    if ($rating == 0)
        $value .= str_repeat($stars[0], 5);
    else if ($rating == 5)
        $value .= str_repeat($stars[2], 5);
    else {
        $value .= str_repeat($stars[2], floor($rating));
        if (is_float($rating) && floor($rating) != $rating) {
            $value .= $stars[1];
        }
    }
    $value .= str_repeat($stars[0], 5 - $rating);


    return $value;
}

function cardSmall(string $type = "favorites", int $carID = 1): string
{
    $returnValue = "<div class='swiper mySwiper' style='padding: .5rem; overflow-x: hidden !important;'><div class='swiper-wrapper'>";
    if ($type == "favorites") {

//     $query = new SQLQuery("SELECT ms.name AS manufacturer, carname, engine, releasedate, p.price, p.discount, AVG(r.rating) as rating FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID INNER JOIN ratings r on cars.carsID = r.carID) WHERE r.rating is not null ORDER BY status ASC, ms.name ASC LIMIT 10;", []);
        $query = new SQLQuery("SELECT carsID, ms.name AS manufacturer, carname, engine, releasedate, p.price, p.discount, AVG(r.rating) as rating FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID INNER JOIN ratings r on cars.carsID = r.carID) GROUP BY r.carID ORDER BY rating DESC LIMIT 10;", []);
        $result = $query->getResult();
        if ($result != null) {
            foreach ($result as $item) {
                $discount = number_format((double)$item->price - ((double)$item->price * (double)$item->discount / 100), 2);
                $returnValue .= "<div class='swiper-slide'>" . "<button style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;' onclick='location.href=\"../pages/car.php?car=" . $item->carsID . "\"'>" . "<img src='../images/cars/$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png' alt='$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png'><div class='card-text'><img src='../images/manufacturers/".strtolower($item->manufacturer).".png' class='p-1' alt='$item->manufacturer icon'>&nbsp;<b>$item->carname</b>&nbsp;<span>$item->engine $item->releasedate</span><div class='rate-price'><span>Már napi&nbsp;<b>$discount €</b></span><div class='rate' style='margin-right: 1rem;'>";
                $returnValue .= generateStars($item->rating);
                $returnValue .= '</div></div></div></button></div>';
            }
        } else {
            $returnValue .= "<div class='swiper-slide w-100 position-relative'><img src='../images/cars/ghost.png'  class='py-5' style='width: 100px;' alt='ghost.png'><div class='w-100 text position-absolute'>Nincs értékelés.</div></div>";
        }
    } elseif ($type == "comments") {
        $query = new SQLQuery("SELECT CONCAT(u.lastname, ' ', u.firstname) AS name, u.avatar AS avatar, commentTitle, comment, created, rating, ratingID FROM ratings INNER JOIN users u on ratings.userID = u.usersID WHERE carID = :carID AND approved = 1 ORDER BY rating DESC;", [':carID' => $carID]);
        $result = $query->getResult();
        if ($result != null) {
            foreach ($result as $item) {
                $returnValue .= "<div class='swiper-slide' id='comment_$item->ratingID'><div class='comment-card w-100'><div class='comment-header d-flex gap-2'><img id='user-image' src='";
                if ($item->avatar != null && $item->avatar != '')
                    $returnValue .= "data:image/jpeg;base64," . base64_encode($item->avatar);
                else
                    $returnValue .= "../images/icons/user-default.png";
                $returnValue .= "' alt='user-avatar'><div class='comment-user-data d-flex flex-column'><span>$item->name</span><small>$item->created</small></div></div><div class='comment-body mt-3'><div class='d-flex justify-content-between align-items-center gap-2'><span class='comment-title d-block text-start'>$item->commentTitle</span><div class='rate d-flex align-items-center'>";
                $returnValue .= generateStars($item->rating);
                $returnValue .= "</div></div><p class='p-2'>$item->comment</p></div><div class='comment-footer d-flex flex-column gap-2 pt-3'></div></div></div>";
            }
        } else {
            $returnValue .= "<div class='swiper-slide w-100 position-relative'><img src='../images/cars/ghost.png'  class='py-5' style='width: 100px;' alt='ghost.png'><div class='w-100 text position-absolute'>Nincs értékelés.</div></div>";
        }
    }
    $returnValue .= "</div><div class='swiper-button-next'></div><div class='swiper-button-prev'></div></div>";
    return $returnValue;
}


/**
 * @param string $label The label for the droppdown
 * @param string $name MUST BE THE NAME FROM DATABASE!! This will display, and the $_GET/$_POST name
 * @param array|object $dataArray The data that contains, ["Data1", "Data2" ....]
 * @param bool $multiselect If it's true then multiselectable, default = true
 * @return string
 */
function dropdownButton(string $label, string $name, array $dataArray, string $path = "", bool $multiselect = true, string $form = ""): string
{
    $returnValue = "";
    $form = empty($form) ? "" : "form= '$form'";
    $multiselect = !$multiselect ? "" : "droplist-multiselect";
    $returnValue .= "<label for='$name-toggle' class='user-select-none'>$label</label><button type='button' id='$name-toggle' onclick='dropdownList(\"$name\", \"$name-toggle\")' class='position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button'><span id='$name-toggle-text' class='droplist-toggle-text'>Nincs kiválasztott</span><i class='me-2 position-absolute end-0 fa-solid fa-angle-down'></i></button><div id='$name' class='droplist $multiselect d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none'>";
    $i = 0;
    foreach ($dataArray as $key => $value) {
        ++$i;
        $value = $value->$name;
        $image = strlen($path) > 0 ? "<img src='../images/$path/$value.png' alt='$value-kep'>" : "";
        $returnValue .= "<input class='d-none droplist-checkbox' $form type='checkbox' id='$name-cat-$i' data-dl='$name' name='$name" . "[]' value='$value'><label for='$name-cat-$i' class='category-checkbox d-flex px-2 align-items-center gap-1 user-select-none'>$image<span>$value</span></label>";
    }

    $returnValue .= "</div>";
    return $returnValue;
}

function tryGetResultToOrderPage():array{
    $result = null;
    $carID = 0;
    $car_full_name = ""; $car_banner = "";
    if (isset($_GET['car']) || isset($_POST['car'])){
        try{
            if(!empty($_GET['car'])) {
                $carID = (int)$_GET['car'];
                $_POST['car'] = $carID;
            }
            if(!empty($_POST['car']))
                $carID = (int)$_POST['car'];
                $query = new SQLQuery('SELECT carsID, manufacturerID, carname, engine, gearbox, fuel, horsepower, seats, doors, bodywork, releasedate, distance, servisdistance, consumption, emissions, airconditioner, status, extras, name as manufacturer, AVG(r.rating) as rating, COUNT(r.rating) as total_rating, price, discount FROM cars c INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID INNER JOIN prices p on c.carsID = p.carID INNER JOIN ratings r on c.carsID = r.carID WHERE carsID = :carsID LIMIT 1', [':carsID'=>$carID]);
            if($query->getResult() != null)
                $result = $query->getResult()[0];
        }catch (Exception $e){
            error_log("!!SQL!! FATAL ERROR IN SQL: ".$e);
        }
    }
    if ($carID > 0 && !empty($result)) {
        $car_full_name = "$result->manufacturer $result->carname $result->releasedate";
        $car_banner = "$result->releasedate $result->manufacturer $result->carname";
    }
    return [$carID, $result, $car_full_name, $car_banner];
}

function generateNumbersToken():string{
    $rand = rand(1000, 9999);
    $string = $rand . "-";
    $rand = rand(1000, 9999);
    $string .= $rand . "-";
    $rand = rand(1000, 9999);
    $string .= $rand;
    return $string;
}

function getHTMLFormattedMessage($message_type, $lastname, $firstname, $site, $token, $carname, $id, $archive_code):string
{
    $title = "<div style='font-size: 2rem'>Hash.</div style='font-size: 2rem'>";
    $mail_type = [
        'activation' => "Felhasználó aktiváció!",
        'recovery' => "Jelszó visszaállítás!",
        'order' => 'Rendelési információk!',
        'order_approved' => "Rendelés megerősítve!",
        'order_denied' => "Rendelés elutasítva!",
        'order_resigned' => "Rendelés lemondva!",
        'order_archived' => "Rendelés befejezve!",
        'contact'=> "$lastname $firstname üzente",
        'newsletter' => "Hash - hírlevél"
    ];
    $message_array = [
        'activation' => "Üdvözöljük kedves $lastname $firstname!<br><h2>Sikeresen regisztrált az oldalunkra, kérjük erősítenie meg a fiókját!</h2>",
        'recovery' => "Üdvözöljük kedves $lastname $firstname!<br><h2>Sikeresen rögzítettük a jelszó visszaállítási szándékát! <br>Ha nem ön volt, akkor haladéktalanul váltson jelszót!</h2>",
        'order' => "Gratulálunk kedves $lastname $firstname!<br><h2>Sikeresen megrendelte a <b>$carname</b> járművet a(z)  <b>#$id</b> azonosító számon!<br> Kollégáink a rendelés elbírálása után küldenek önnek egy újabb üzenetet, a további adatokkal!</h2>",
        'order_approved' => "Üdvözöljük kedves $lastname $firstname!<br><h2>A(z) <b>$carname</b>, <b>#$id</b> azonosítójú rendelése feldolgozásra került! Az alkalmazottaink elfogadták a rendelést a megadott adatokra! Az átvételkor be kell mutatnia a következő kódot:</h2><center><div style='font-size: x-large'>Kód: <b>$archive_code</b></div></center>",
        'order_denied' => "Üdvözöljük kedves $lastname $firstname!<br><h2>A(z) <b>$carname</b>, <b>#$id</b> azonosítójú rendelése feldolgozásra került! Az alkalmazottaink nem fogadták el a rendelést a megadott adatokra!</h2>",
        'order_resigned' => "Üdvözöljük kedves $lastname $firstname!<br><h2>A(z) <b>$carname</b>, <b>#$id</b> azonosítójú rendelést sikeresen lemondta!",
        'order_archived' => "Üdvözöljük kedves $lastname $firstname!<br><h2>A(z) <b>$carname</b>, <b>#$id</b> azonosítójú rendelése lezárva! <br>Kérjük írjon egy megjegyzést a tapasztalatiról, a járműről!</h2><br><center><div style='font-size: x-large'>Az ehhez szükséges kód: <b>$archive_code</b></div></center>",
        'contact'=> "<b>$token</b><br><hr></hr>Üzenet:<br> $carname",
        'newsletter' => "$token"
    ];
    $buttons_array = [
        'activation' => ["A gombra kattintva (vagy a linkre) aktiválhatja a fiókját!", "Fiók aktiválása"],
        'recovery' => ["A gombra kattintva (vagy a linkre) visszaállíthatja a jelszavát!<br> Ha nem ön volt, akkor haladéktalanul váltson jelszót!", "Jelszó visszaállítása"],
        'order' => ["", ""],
        'order_approved' => ["", ""],
        'order_denied' => ["", ""],
        'order_resigned' => ["", ""],
        'order_archived' => ["", ""],
        'contact' => ["Üzenet küldéséhez $token számára kattintson a gombra!", "Reply küldése"],
        'newsletter'=> ["",""]
    ];

    $title .= $mail_type[$message_type];

    $returnValue = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name='viewport' content='width=device-width'>
    <title>Hash. hash@support.com</title>
    <style>.wrapper{width: 100%;}#outlook a{padding: 0;}body{width: 100% !important; min-width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; Margin: 0; padding: 0; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;}center{width: 100%; min-width: 580px;}a img{border: none;}p{margin: 0 0 0 10px; Margin: 0 0 0 10px;}table{border-spacing: 0; border-collapse: collapse;}td{word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important;}table, tr, td{padding: 0; vertical-align: top; text-align: left;}@media only screen{html{min-height: 100%; background: #f3f3f3;}}table.body{background: #f3f3f3; height: 100%; width: 100%;}table.container{background: #fefefe; width: 580px; margin: 0 auto; Margin: 0 auto; text-align: inherit;}table.row{padding: 0; width: 100%; position: relative;}table.spacer{width: 100%;}table.spacer td{mso-line-height-rule: exactly;}table.container table.row{display: table;}td.columns,td.column,th.columns,th.column{margin: 0 auto; Margin: 0 auto; padding-left: 16px; padding-bottom: 16px;}td.columns .column, td.columns .columns, td.column .column, td.column .columns, th.columns .column, th.columns .columns, th.column .column, th.column .columns{padding-left: 0 !important; padding-right: 0 !important;}td.columns .column center, td.columns .columns center, td.column .column center, td.column .columns center, th.columns .column center, th.columns .columns center, th.column .column center, th.column .columns center{min-width: none !important;}td.columns.last,td.column.last,th.columns.last,th.column.last{padding-right: 16px;}td.columns table:not(.button),td.column table:not(.button),th.columns table:not(.button),th.column table:not(.button){width: 100%;}td.large-1,th.large-1{width: 32.33333px; padding-left: 8px; padding-right: 8px;}td.large-1.first,th.large-1.first{padding-left: 16px;}td.large-1.last,th.large-1.last{padding-right: 16px;}.collapse > tbody > tr > td.large-1,.collapse > tbody > tr > th.large-1{padding-right: 0; padding-left: 0; width: 48.33333px;}.collapse td.large-1.first,.collapse th.large-1.first,.collapse td.large-1.last,.collapse th.large-1.last{width: 56.33333px;}td.large-1 center,th.large-1 center{min-width: 0.33333px;}.body .columns td.large-1,.body .column td.large-1,.body .columns th.large-1,.body .column th.large-1{width: 8.33333%;}td.large-2,th.large-2{width: 80.66667px; padding-left: 8px; padding-right: 8px;}td.large-2.first,th.large-2.first{padding-left: 16px;}td.large-2.last,th.large-2.last{padding-right: 16px;}.collapse > tbody > tr > td.large-2,.collapse > tbody > tr > th.large-2{padding-right: 0; padding-left: 0; width: 96.66667px;}.collapse td.large-2.first,.collapse th.large-2.first,.collapse td.large-2.last,.collapse th.large-2.last{width: 104.66667px;}td.large-2 center,th.large-2 center{min-width: 48.66667px;}.body .columns td.large-2,.body .column td.large-2,.body .columns th.large-2,.body .column th.large-2{width: 16.66667%;}td.large-3,th.large-3{width: 129px; padding-left: 8px; padding-right: 8px;}td.large-3.first,th.large-3.first{padding-left: 16px;}td.large-3.last,th.large-3.last{padding-right: 16px;}.collapse > tbody > tr > td.large-3,.collapse > tbody > tr > th.large-3{padding-right: 0; padding-left: 0; width: 145px;}.collapse td.large-3.first,.collapse th.large-3.first,.collapse td.large-3.last,.collapse th.large-3.last{width: 153px;}td.large-3 center,th.large-3 center{min-width: 97px;}.body .columns td.large-3,.body .column td.large-3,.body .columns th.large-3,.body .column th.large-3{width: 25%;}td.large-4,th.large-4{width: 177.33333px; padding-left: 8px; padding-right: 8px;}td.large-4.first,th.large-4.first{padding-left: 16px;}td.large-4.last,th.large-4.last{padding-right: 16px;}.collapse > tbody > tr > td.large-4,.collapse > tbody > tr > th.large-4{padding-right: 0; padding-left: 0; width: 193.33333px;}.collapse td.large-4.first,.collapse th.large-4.first,.collapse td.large-4.last,.collapse th.large-4.last{width: 201.33333px;}td.large-4 center,th.large-4 center{min-width: 145.33333px;}.body .columns td.large-4,.body .column td.large-4,.body .columns th.large-4,.body .column th.large-4{width: 33.33333%;}td.large-5,th.large-5{width: 225.66667px; padding-left: 8px; padding-right: 8px;}td.large-5.first,th.large-5.first{padding-left: 16px;}td.large-5.last,th.large-5.last{padding-right: 16px;}.collapse > tbody > tr > td.large-5,.collapse > tbody > tr > th.large-5{padding-right: 0; padding-left: 0; width: 241.66667px;}.collapse td.large-5.first,.collapse th.large-5.first,.collapse td.large-5.last,.collapse th.large-5.last{width: 249.66667px;}td.large-5 center,th.large-5 center{min-width: 193.66667px;}.body .columns td.large-5,.body .column td.large-5,.body .columns th.large-5,.body .column th.large-5{width: 41.66667%;}td.large-6,th.large-6{width: 274px; padding-left: 8px; padding-right: 8px;}td.large-6.first,th.large-6.first{padding-left: 16px;}td.large-6.last,th.large-6.last{padding-right: 16px;}.collapse > tbody > tr > td.large-6,.collapse > tbody > tr > th.large-6{padding-right: 0; padding-left: 0; width: 290px;}.collapse td.large-6.first,.collapse th.large-6.first,.collapse td.large-6.last,.collapse th.large-6.last{width: 298px;}td.large-6 center,th.large-6 center{min-width: 242px;}.body .columns td.large-6,.body .column td.large-6,.body .columns th.large-6,.body .column th.large-6{width: 50%;}td.large-7,th.large-7{width: 322.33333px; padding-left: 8px; padding-right: 8px;}td.large-7.first,th.large-7.first{padding-left: 16px;}td.large-7.last,th.large-7.last{padding-right: 16px;}.collapse > tbody > tr > td.large-7,.collapse > tbody > tr > th.large-7{padding-right: 0; padding-left: 0; width: 338.33333px;}.collapse td.large-7.first,.collapse th.large-7.first,.collapse td.large-7.last,.collapse th.large-7.last{width: 346.33333px;}td.large-7 center,th.large-7 center{min-width: 290.33333px;}.body .columns td.large-7,.body .column td.large-7,.body .columns th.large-7,.body .column th.large-7{width: 58.33333%;}td.large-8,th.large-8{width: 370.66667px; padding-left: 8px; padding-right: 8px;}td.large-8.first,th.large-8.first{padding-left: 16px;}td.large-8.last,th.large-8.last{padding-right: 16px;}.collapse > tbody > tr > td.large-8,.collapse > tbody > tr > th.large-8{padding-right: 0; padding-left: 0; width: 386.66667px;}.collapse td.large-8.first,.collapse th.large-8.first,.collapse td.large-8.last,.collapse th.large-8.last{width: 394.66667px;}td.large-8 center,th.large-8 center{min-width: 338.66667px;}.body .columns td.large-8,.body .column td.large-8,.body .columns th.large-8,.body .column th.large-8{width: 66.66667%;}td.large-9,th.large-9{width: 419px; padding-left: 8px; padding-right: 8px;}td.large-9.first,th.large-9.first{padding-left: 16px;}td.large-9.last,th.large-9.last{padding-right: 16px;}.collapse > tbody > tr > td.large-9,.collapse > tbody > tr > th.large-9{padding-right: 0; padding-left: 0; width: 435px;}.collapse td.large-9.first,.collapse th.large-9.first,.collapse td.large-9.last,.collapse th.large-9.last{width: 443px;}td.large-9 center,th.large-9 center{min-width: 387px;}.body .columns td.large-9,.body .column td.large-9,.body .columns th.large-9,.body .column th.large-9{width: 75%;}td.large-10,th.large-10{width: 467.33333px; padding-left: 8px; padding-right: 8px;}td.large-10.first,th.large-10.first{padding-left: 16px;}td.large-10.last,th.large-10.last{padding-right: 16px;}.collapse > tbody > tr > td.large-10,.collapse > tbody > tr > th.large-10{padding-right: 0; padding-left: 0; width: 483.33333px;}.collapse td.large-10.first,.collapse th.large-10.first,.collapse td.large-10.last,.collapse th.large-10.last{width: 491.33333px;}td.large-10 center,th.large-10 center{min-width: 435.33333px;}.body .columns td.large-10,.body .column td.large-10,.body .columns th.large-10,.body .column th.large-10{width: 83.33333%;}td.large-11,th.large-11{width: 515.66667px; padding-left: 8px; padding-right: 8px;}td.large-11.first,th.large-11.first{padding-left: 16px;}td.large-11.last,th.large-11.last{padding-right: 16px;}.collapse > tbody > tr > td.large-11,.collapse > tbody > tr > th.large-11{padding-right: 0; padding-left: 0; width: 531.66667px;}.collapse td.large-11.first,.collapse th.large-11.first,.collapse td.large-11.last,.collapse th.large-11.last{width: 539.66667px;}td.large-11 center,th.large-11 center{min-width: 483.66667px;}.body .columns td.large-11,.body .column td.large-11,.body .columns th.large-11,.body .column th.large-11{width: 91.66667%;}td.large-12,th.large-12{width: 564px; padding-left: 8px; padding-right: 8px;}td.large-12.first,th.large-12.first{padding-left: 16px;}td.large-12.last,th.large-12.last{padding-right: 16px;}.collapse > tbody > tr > td.large-12,.collapse > tbody > tr > th.large-12{padding-right: 0; padding-left: 0; width: 580px;}.collapse td.large-12.first,.collapse th.large-12.first,.collapse td.large-12.last,.collapse th.large-12.last{width: 588px;}td.large-12 center,th.large-12 center{min-width: 532px;}.body .columns td.large-12,.body .column td.large-12,.body .columns th.large-12,.body .column th.large-12{width: 100%;}td.large-offset-1,td.large-offset-1.first,td.large-offset-1.last,th.large-offset-1,th.large-offset-1.first,th.large-offset-1.last{padding-left: 64.33333px;}td.large-offset-2,td.large-offset-2.first,td.large-offset-2.last,th.large-offset-2,th.large-offset-2.first,th.large-offset-2.last{padding-left: 112.66667px;}td.large-offset-3,td.large-offset-3.first,td.large-offset-3.last,th.large-offset-3,th.large-offset-3.first,th.large-offset-3.last{padding-left: 161px;}td.large-offset-4,td.large-offset-4.first,td.large-offset-4.last,th.large-offset-4,th.large-offset-4.first,th.large-offset-4.last{padding-left: 209.33333px;}td.large-offset-5,td.large-offset-5.first,td.large-offset-5.last,th.large-offset-5,th.large-offset-5.first,th.large-offset-5.last{padding-left: 257.66667px;}td.large-offset-6,td.large-offset-6.first,td.large-offset-6.last,th.large-offset-6,th.large-offset-6.first,th.large-offset-6.last{padding-left: 306px;}td.large-offset-7,td.large-offset-7.first,td.large-offset-7.last,th.large-offset-7,th.large-offset-7.first,th.large-offset-7.last{padding-left: 354.33333px;}td.large-offset-8,td.large-offset-8.first,td.large-offset-8.last,th.large-offset-8,th.large-offset-8.first,th.large-offset-8.last{padding-left: 402.66667px;}td.large-offset-9,td.large-offset-9.first,td.large-offset-9.last,th.large-offset-9,th.large-offset-9.first,th.large-offset-9.last{padding-left: 451px;}td.large-offset-10,td.large-offset-10.first,td.large-offset-10.last,th.large-offset-10,th.large-offset-10.first,th.large-offset-10.last{padding-left: 499.33333px;}td.large-offset-11,td.large-offset-11.first,td.large-offset-11.last,th.large-offset-11,th.large-offset-11.first,th.large-offset-11.last{padding-left: 547.66667px;}td.expander,th.expander{visibility: hidden; width: 0; padding: 0 !important;}table.container.radius{border-radius: 0; border-collapse: separate;}.block-grid{width: 100%; max-width: 580px;}.block-grid td{display: inline-block; padding: 8px;}.up-2 td{width: 274px !important;}.up-3 td{width: 177px !important;}.up-4 td{width: 129px !important;}.up-5 td{width: 100px !important;}.up-6 td{width: 80px !important;}.up-7 td{width: 66px !important;}.up-8 td{width: 56px !important;}table.text-center,th.text-center,td.text-center,h1.text-center,h2.text-center,h3.text-center,h4.text-center,h5.text-center,h6.text-center,p.text-center,span.text-center{text-align: center;}table.text-left,th.text-left,td.text-left,h1.text-left,h2.text-left,h3.text-left,h4.text-left,h5.text-left,h6.text-left,p.text-left,span.text-left{text-align: left;}table.text-right,th.text-right,td.text-right,h1.text-right,h2.text-right,h3.text-right,h4.text-right,h5.text-right,h6.text-right,p.text-right,span.text-right{text-align: right;}span.text-center{display: block; width: 100%; text-align: center;}@media only screen and (max-width: 596px){.small-float-center{margin: 0 auto !important; float: none !important; text-align: center !important;}.small-text-center{text-align: center !important;}.small-text-left{text-align: left !important;}.small-text-right{text-align: right !important;}}img.float-left{float: left; text-align: left;}img.float-right{float: right; text-align: right;}img.float-center,img.text-center{margin: 0 auto; Margin: 0 auto; float: none; text-align: center;}table.float-center,td.float-center,th.float-center{margin: 0 auto; Margin: 0 auto; float: none; text-align: center;}.hide-for-large{display: none !important; mso-hide: all; overflow: hidden; max-height: 0; font-size: 0; width: 0; line-height: 0;}@media only screen and (max-width: 596px){.hide-for-large{display: block !important; width: auto !important; overflow: visible !important; max-height: none !important; font-size: inherit !important; line-height: inherit !important;}}table.body table.container .hide-for-large *{mso-hide: all;}@media only screen and (max-width: 596px){table.body table.container .hide-for-large, table.body table.container .row.hide-for-large{display: table !important; width: 100% !important;}}@media only screen and (max-width: 596px){table.body table.container .callout-inner.hide-for-large{display: table-cell !important; width: 100% !important;}}@media only screen and (max-width: 596px){table.body table.container .show-for-large{display: none !important; width: 0; mso-hide: all; overflow: hidden;}}body,table.body,h1,h2,h3,h4,h5,h6,p,td,th,a{color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; padding: 0; margin: 0; Margin: 0; text-align: left; line-height: 1.3;}h1,h2,h3,h4,h5,h6{color: inherit; word-wrap: normal; font-family: Helvetica, Arial, sans-serif; font-weight: normal; margin-bottom: 10px; Margin-bottom: 10px;}h1{font-size: 34px;}h2{font-size: 30px;}h3{font-size: 28px;}h4{font-size: 24px;}h5{font-size: 20px;}h6{font-size: 18px;}body,table.body,p,td,th{font-size: 16px; line-height: 1.3;}p{margin-bottom: 10px; Margin-bottom: 10px;}p.lead{font-size: 20px; line-height: 1.6;}p.subheader{margin-top: 4px; margin-bottom: 8px; Margin-top: 4px; Margin-bottom: 8px; font-weight: normal; line-height: 1.4; color: #8a8a8a;}small{font-size: 80%; color: #cacaca;}a{color: #2199e8; text-decoration: none;}a:hover{color: #147dc2;}a:active{color: #147dc2;}a:visited{color: #2199e8;}h1 a,h1 a:visited,h2 a,h2 a:visited,h3 a,h3 a:visited,h4 a,h4 a:visited,h5 a,h5 a:visited,h6 a,h6 a:visited{color: #2199e8;}pre{background: #f3f3f3; margin: 30px 0; Margin: 30px 0;}pre code{color: #cacaca;}pre code span.callout{color: #8a8a8a; font-weight: bold;}pre code span.callout-strong{color: #ff6908; font-weight: bold;}table.hr{width: 100%;}table.hr th{height: 0; max-width: 580px; border-top: 0; border-right: 0; border-bottom: 1px solid #0a0a0a; border-left: 0; margin: 20px auto; Margin: 20px auto; clear: both;}.stat{font-size: 40px; line-height: 1;}p + .stat{margin-top: -16px; Margin-top: -16px;}span.preheader{display: none !important; visibility: hidden; mso-hide: all !important; font-size: 1px; color: #f3f3f3; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;}table.button{width: auto; margin: 0 0 16px 0; Margin: 0 0 16px 0;}table.button table td{text-align: left; color: #fefefe; background: #2199e8; border: 2px solid #2199e8;}table.button table td a{font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: bold; color: #fefefe; text-decoration: none; display: inline-block; padding: 8px 16px 8px 16px; border: 0 solid #2199e8; border-radius: 3px;}table.button.radius table td{border-radius: 3px; border: none;}table.button.rounded table td{border-radius: 500px; border: none;}table.button:hover table tr td a,table.button:active table tr td a,table.button table tr td a:visited,table.button.tiny:hover table tr td a,table.button.tiny:active table tr td a,table.button.tiny table tr td a:visited,table.button.small:hover table tr td a,table.button.small:active table tr td a,table.button.small table tr td a:visited,table.button.large:hover table tr td a,table.button.large:active table tr td a,table.button.large table tr td a:visited{color: #fefefe;}table.button.tiny table td,table.button.tiny table a{padding: 4px 8px 4px 8px;}table.button.tiny table a{font-size: 10px; font-weight: normal;}table.button.small table td,table.button.small table a{padding: 5px 10px 5px 10px; font-size: 12px;}table.button.large table a{padding: 10px 20px 10px 20px; font-size: 20px;}table.button.expand,table.button.expanded{width: 100% !important;}table.button.expand table, table.button.expanded table{width: 100%;}table.button.expand table a, table.button.expanded table a{text-align: center; width: 100%; padding-left: 0; padding-right: 0;}table.button.expand center, table.button.expanded center{min-width: 0;}table.button:hover table td,table.button:visited table td,table.button:active table td{background: #147dc2; color: #fefefe;}table.button:hover table a,table.button:visited table a,table.button:active table a{border: 0 solid #147dc2;}table.button.secondary table td{background: #777777; color: #fefefe; border: 0px solid #777777;}table.button.secondary table a{color: #fefefe; border: 0 solid #777777;}table.button.secondary:hover table td{background: #919191; color: #fefefe;}table.button.secondary:hover table a{border: 0 solid #919191;}table.button.secondary:hover table td a{color: #fefefe;}table.button.secondary:active table td a{color: #fefefe;}table.button.secondary table td a:visited{color: #fefefe;}table.button.success table td{background: #3adb76; border: 0px solid #3adb76;}table.button.success table a{border: 0 solid #3adb76;}table.button.success:hover table td{background: #23bf5d;}table.button.success:hover table a{border: 0 solid #23bf5d;}table.button.alert table td{background: #ec5840; border: 0px solid #ec5840;}table.button.alert table a{border: 0 solid #ec5840;}table.button.alert:hover table td{background: #e23317;}table.button.alert:hover table a{border: 0 solid #e23317;}table.button.warning table td{background: #ffae00; border: 0px solid #ffae00;}table.button.warning table a{border: 0px solid #ffae00;}table.button.warning:hover table td{background: #cc8b00;}table.button.warning:hover table a{border: 0px solid #cc8b00;}table.callout{margin-bottom: 16px; Margin-bottom: 16px;}th.callout-inner{width: 100%; border: 1px solid #cbcbcb; padding: 10px; background: #fefefe;}th.callout-inner.primary{background: #def0fc; border: 1px solid #444444; color: #0a0a0a;}th.callout-inner.secondary{background: #ebebeb; border: 1px solid #444444; color: #0a0a0a;}th.callout-inner.success{background: #e1faea; border: 1px solid #1b9448; color: #fefefe;}th.callout-inner.warning{background: #fff3d9; border: 1px solid #996800; color: #fefefe;}th.callout-inner.alert{background: #fce6e2; border: 1px solid #b42912; color: #fefefe;}.thumbnail{border: solid 4px #fefefe; box-shadow: 0 0 0 1px rgba(10, 10, 10, 0.2); display: inline-block; line-height: 0; max-width: 100%; transition: box-shadow 200ms ease-out; border-radius: 3px; margin-bottom: 16px;}.thumbnail:hover, .thumbnail:focus{box-shadow: 0 0 6px 1px rgba(33, 153, 232, 0.5);}table.menu{width: 580px;}table.menu td.menu-item, table.menu th.menu-item{padding: 10px; padding-right: 10px;}table.menu td.menu-item a, table.menu th.menu-item a{color: #2199e8;}table.menu.vertical td.menu-item,table.menu.vertical th.menu-item{padding: 10px; padding-right: 0; display: block;}table.menu.vertical td.menu-item a, table.menu.vertical th.menu-item a{width: 100%;}table.menu.vertical td.menu-item table.menu.vertical td.menu-item,table.menu.vertical td.menu-item table.menu.vertical th.menu-item,table.menu.vertical th.menu-item table.menu.vertical td.menu-item,table.menu.vertical th.menu-item table.menu.vertical th.menu-item{padding-left: 10px;}table.menu.text-center a{text-align: center;}.menu[align='center']{width: auto !important;}body.outlook p{display: inline !important;}@media only screen and (max-width: 596px){table.body img{width: auto; height: auto;}table.body center{min-width: 0 !important;}table.body .container{width: 95% !important;}table.body .columns, table.body .column{height: auto !important; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 16px !important; padding-right: 16px !important;}table.body .columns .column, table.body .columns .columns, table.body .column .column, table.body .column .columns{padding-left: 0 !important; padding-right: 0 !important;}table.body .collapse .columns, table.body .collapse .column{padding-left: 0 !important; padding-right: 0 !important;}td.small-1, th.small-1{display: inline-block !important; width: 8.33333% !important;}td.small-2, th.small-2{display: inline-block !important; width: 16.66667% !important;}td.small-3, th.small-3{display: inline-block !important; width: 25% !important;}td.small-4, th.small-4{display: inline-block !important; width: 33.33333% !important;}td.small-5, th.small-5{display: inline-block !important; width: 41.66667% !important;}td.small-6, th.small-6{display: inline-block !important; width: 50% !important;}td.small-7, th.small-7{display: inline-block !important; width: 58.33333% !important;}td.small-8, th.small-8{display: inline-block !important; width: 66.66667% !important;}td.small-9, th.small-9{display: inline-block !important; width: 75% !important;}td.small-10, th.small-10{display: inline-block !important; width: 83.33333% !important;}td.small-11, th.small-11{display: inline-block !important; width: 91.66667% !important;}td.small-12, th.small-12{display: inline-block !important; width: 100% !important;}.columns td.small-12, .column td.small-12, .columns th.small-12, .column th.small-12{display: block !important; width: 100% !important;}table.body td.small-offset-1, table.body th.small-offset-1{margin-left: 8.33333% !important; Margin-left: 8.33333% !important;}table.body td.small-offset-2, table.body th.small-offset-2{margin-left: 16.66667% !important; Margin-left: 16.66667% !important;}table.body td.small-offset-3, table.body th.small-offset-3{margin-left: 25% !important; Margin-left: 25% !important;}table.body td.small-offset-4, table.body th.small-offset-4{margin-left: 33.33333% !important; Margin-left: 33.33333% !important;}table.body td.small-offset-5, table.body th.small-offset-5{margin-left: 41.66667% !important; Margin-left: 41.66667% !important;}table.body td.small-offset-6, table.body th.small-offset-6{margin-left: 50% !important; Margin-left: 50% !important;}table.body td.small-offset-7, table.body th.small-offset-7{margin-left: 58.33333% !important; Margin-left: 58.33333% !important;}table.body td.small-offset-8, table.body th.small-offset-8{margin-left: 66.66667% !important; Margin-left: 66.66667% !important;}table.body td.small-offset-9, table.body th.small-offset-9{margin-left: 75% !important; Margin-left: 75% !important;}table.body td.small-offset-10, table.body th.small-offset-10{margin-left: 83.33333% !important; Margin-left: 83.33333% !important;}table.body td.small-offset-11, table.body th.small-offset-11{margin-left: 91.66667% !important; Margin-left: 91.66667% !important;}table.body table.columns td.expander, table.body table.columns th.expander{display: none !important;}table.body .right-text-pad, table.body .text-pad-right{padding-left: 10px !important;}table.body .left-text-pad, table.body .text-pad-left{padding-right: 10px !important;}table.menu{width: 100% !important;}table.menu td, table.menu th{width: auto !important; display: inline-block !important;}table.menu.vertical td, table.menu.vertical th, table.menu.small-vertical td, table.menu.small-vertical th{display: block !important;}table.menu[align='center']{width: auto !important;}table.button.small-expand, table.button.small-expanded{width: 100% !important;}table.button.small-expand table, table.button.small-expanded table{width: 100%;}table.button.small-expand table a, table.button.small-expanded table a{text-align: center !important; width: 100% !important; padding-left: 0 !important; padding-right: 0 !important;}table.button.small-expand center, table.button.small-expanded center{min-width: 0;}}</style> 
    <style>body, html, .body{background: #f3f3f3 !important;}.header{background: #f3f3f3;}</style>
  </head>

  <body>
    <!-- <style> -->
    <table class='body' data-made-with-foundation=''>
      <tr>
        <td class='float-center' align='center' valign='top'>
          <center data-parsed=''>
            <table class='spacer float-center'>
              <tbody>
                <tr>
                  <td height='16px' style='font-size:16px;line-height:16px;'>&#xA0;</td>
                </tr>
              </tbody>
            </table>
            <table align='center' class='container float-center'>
              <tbody>
                <tr>
                  <td>
                    <table class='row header'>
                      <tbody>
                        <tr>
                          <th class='small-12 large-12 columns first last'>
                            <table>
                              <tr>
                                <th>
                                  <table class='spacer'>
                                    <tbody>
                                      <tr>
                                        <td height='16px' style='font-size:16px;line-height:16px;'>&#xA0;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <h4 class='text-center'>$title</h4> </th>
                                <th class='expander'></th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                    <table class='row'>
                      <tbody>
                        <tr>
                          <th class='small-12 large-12 columns first last'>
                            <table>
                              <tr>
                                <th>
                                  <table class='spacer'>
                                    <tbody>
                                      <tr>
                                        <td height='32px' style='font-size:32px;line-height:32px;'>&#xA0;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <h1 class='text-center'>$message_array[$message_type]</h1>
                                  <table class='spacer'>
                                    <tbody>
                                      <tr>
                                        <td height='16px' style='font-size:16px;line-height:16px;'>&#xA0;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  ";
    if (strlen($buttons_array[$message_type][0]) > 0) {
        $small_message = $buttons_array[$message_type][0];
        $button_message = $buttons_array[$message_type][1];
        if ($message_type === 'contact')
            $button_link = "mailto:$token";
        else
            $button_link = $site . $token;
        $returnValue .= "<p class='text-center'>$small_message</p>
                                  <table class='button large expand'>
                                    <tr>
                                      <td>
                                        <table>
                                          <tr>
                                            <td>
                                              <center data-parsed=''><a href='$button_link' align='center' class='float-center'>$button_message</a></center>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td class='expander'></td>
                                    </tr>
                                  </table>";
    }
    $returnValue .= "
                                </th>
                                <th class='expander'></th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                    <table class='spacer'>
                      <tbody>
                        <tr>
                          <td height='16px' style='font-size:16px;line-height:16px;'>&#xA0;</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </center>
        </td>
      </tr>
    </table>
  </body>

</html>";
    return $returnValue;
}