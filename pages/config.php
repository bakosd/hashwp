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

spl_autoload_register("auto_loader", true);

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
    10 => 'Sikeresen visszaállítottad a fiókod!',
    11 => 'Hiba történt a kijelentkezés során!',
    12 => 'Lejárt a munkamenet! Jelentkezz be újra.'
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
    if ($where != null) {
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
        $returnValue = '<div class="col width-270">';
        $returnValue = $type == "carousel-item" ? $returnValue . '<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel"><div class="carousel-inner">' : $returnValue . '';
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

            if ($type == "carousel-item" && $item == $result[0])
                $returnValue .= '<div class="carousel-item active">';
            else if ($type == "carousel-item")
                $returnValue .= '<div class="carousel-item">';
            else if ($type == 'carousel' && $item != $result[0])
                $returnValue .= '</div><div class="col width-270"><div class="carousel">';
            else $returnValue .= '<div class="carousel">';
//                $returnValue .= "<button style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;' onclick='location.href=\"../pages/car.php?car=".$item->manufacturer.$item->carname.$item->releasedate."\"'>";
            $returnValue .= "<button onclick='location.href=\"../pages/car.php?car=" . $item->carsID . "\"' style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;'>" . "<div class='slider-img'><img src='../images/cars/$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png' class='d-block w-75 mx-auto' alt='$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png'></div><div class='text'><div><img src='../images/manufacturers/$item->manufacturer.png' width='45px' class='px-1' alt='$item->manufacturer icon'>&nbsp;<b>$item->carname</b>&nbsp;<span>$item->engine $item->releasedate</span></div><div class='action-price'>";
            if ($item->discount > 0) {
                $discount = number_format((double)$item->price - ((double)$item->price * (double)$item->discount / 100), 2);
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
    $returnValue = "<div class='swiper mySwiper' style='padding: .5rem; overflow-x: hidden;'><div class='swiper-wrapper'>";
    if ($type == "favorites") {

//     $query = new SQLQuery("SELECT ms.name AS manufacturer, carname, engine, releasedate, p.price, p.discount, AVG(r.rating) as rating FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID INNER JOIN ratings r on cars.carsID = r.carID) WHERE r.rating is not null ORDER BY status ASC, ms.name ASC LIMIT 10;", []);
        $query = new SQLQuery("SELECT carsID, ms.name AS manufacturer, carname, engine, releasedate, p.price, p.discount, AVG(r.rating) as rating FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID INNER JOIN ratings r on cars.carsID = r.carID) GROUP BY r.carID LIMIT 10;", []);
        $result = $query->getResult();
        if ($result != null) {
            foreach ($result as $item) {
                $discount = number_format((double)$item->price - ((double)$item->price * (double)$item->discount / 100), 2);
                $returnValue .= "<div class='swiper-slide'>" . "<button style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;' onclick='location.href=\"../pages/car.php?car=" . $item->carsID . "\"'>" . "<img src='../images/cars/$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png' alt='$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png'><div class='card-text'><img src='../images/manufacturers/$item->manufacturer.png' class='p-1' alt='$item->manufacturer icon'>&nbsp;<b>$item->carname</b>&nbsp;<span>$item->engine $item->releasedate</span><div class='rate-price'><span>Már napi&nbsp;<b>$discount €</b></span><div class='rate' style='margin-right: 1rem;'>";
                $returnValue .= generateStars($item->rating);
                $returnValue .= '</div></div></div></button></div>';
            }
        } else {
            $returnValue .= "<div class='swiper-slide w-100 position-relative'><img src='../images/cars/ghost.png'  class='py-5' style='width: 100px;' alt='ghost.png'><div class='w-100 text position-absolute'>Nincs értékelés.</div></div>";
        }
    } elseif ($type == "comments") {
        $query = new SQLQuery("SELECT CONCAT(u.lastname, ' ', u.firstname) AS name, u.avatar AS avatar, commentTitle, comment, created, likes, dislikes, rating, ratingID FROM ratings INNER JOIN users u on ratings.userID = u.usersID WHERE carID = :carID ORDER BY (likes-dislikes) DESC;", [':carID' => $carID]);
        $result = $query->getResult();
        if ($result != null) {
            foreach ($result as $item) {
                $returnValue .= "<div class='swiper-slide'><div class='comment-card w-100'><div class='comment-header d-flex gap-2'><img id='user-image' src='";
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