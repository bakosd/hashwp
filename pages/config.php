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

//$register_form = '<form name="register" id="nav-register-form" method="post" action="register.php"><div class="modal-body"><div class="d-flex flex-column gap-2 px-2"><label for="email">E-mail cím <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-at"></i> <input type="text" name="email" id="email" placeholder="Email cím"></div><div class="loader loader-bad"></div></div><label for="password1x">Jelszó <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password1x" id="password1x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="password2x">Jelszó újra <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password2x" id="password2x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="lastname">Vezeték név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="lastname" id="lastname" placeholder="Vezeték név"></div><div class="loader loader-bad"></div></div><label for="firstname">Kereszt név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="firstname" id="firstname" placeholder="Kereszt név"></div><div class="loader loader-bad"></div></div><label for="birthdate">Születésnap <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-cake-candles"></i> <input type="date" name="birthdate" id="birthdate"></div><div class="loader loader-bad"></div></div><label for="phonenumber">Telefonszám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-phone"></i> <input type="text" name="phonenumber" id="phonenumber" placeholder="Telefonszám"></div><div class="loader loader-bad"></div></div><label for="idcardNumber">Személyi/útlevél szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-id-card"></i> <input type="text" name="idcardNumber" id="idcardNumber" placeholder="Személyi/útlevél szám"></div><div class="loader loader-bad"></div></div><label for="licensecardNumber">Vezetői engedély szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-address-card"></i> <input type="text" name="licensecardNumber" id="licensecardNumber" placeholder="Vezetői engedély szám"></div><div class="loader loader-bad"></div></div><label for="licensecardPlace">Kiadási helye <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-map"></i> <input type="text" name="licensecardPlace" id="licensecardPlace" placeholder="Vezetői engedély kiadási helye"></div><div class="loader loader-bad"></div></div></div></div><div class="modal-footer d-flex gap-2"><button type="button" class="button-2 px-2 d-flex justify-content-center align-items-center gap-2" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i>Mégsem</button> <button type="submit" name="register_submit" class="button px-2 d-flex justify-content-center align-items-center gap-2"><i class="fa-solid fa-circle-check"></i>Regisztráció</button></div></form>';
$register_form = '<form name="register" id="nav-register-form" method="post" action="register.php"><div class="modal-body"><div class="d-flex flex-column gap-2 px-2"><label for="email">E-mail cím <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-at"></i> <input type="text" name="email" id="email" placeholder="Email cím"></div><div class="loader loader-bad"></div></div><label for="password1x">Jelszó <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password1x" id="password1x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="password2x">Jelszó újra <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-lock"></i> <input type="password" name="password2x" id="password2x" placeholder="Jelszó"></div><div class="loader loader-bad"></div></div><label for="lastname">Vezeték név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="lastname" id="lastname" placeholder="Vezeték név"></div><div class="loader loader-bad"></div></div><label for="firstname">Kereszt név <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-signature"></i> <input type="text" name="firstname" id="firstname" placeholder="Kereszt név"></div><div class="loader loader-bad"></div></div><label for="birthdate">Születésnap <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-cake-candles"></i> <input type="date" name="birthdate" id="birthdate"></div><div class="loader loader-bad"></div></div><label for="phonenumber">Telefonszám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-phone"></i> <input type="text" name="phonenumber" id="phonenumber" placeholder="Telefonszám"></div><div class="loader loader-bad"></div></div><label for="idcardNumber">Személyi/útlevél szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-id-card"></i> <input type="text" name="idcardNumber" id="idcardNumber" placeholder="Személyi/útlevél szám"></div><div class="loader loader-bad"></div></div><label for="licensecardNumber">Vezetői engedély szám <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-address-card"></i> <input type="text" name="licensecardNumber" id="licensecardNumber" placeholder="Vezetői engedély szám"></div><div class="loader loader-bad"></div></div><label for="licensecardPlace">Kiadási helye <span class="text-danger">*<span class="err"></span></span></label><div class="d-flex align-items-center"><div class="d-flex align-items-center gap-1 input-with-icon m-1 w-100"><i class="px-2 fa-solid fa-map"></i> <input type="text" name="licensecardPlace" id="licensecardPlace" placeholder="Vezetői engedély kiadási helye"></div><div class="loader loader-bad"></div></div></div></div></form>';

/**
 * @param $type // carousel || carousel-item
 * @param array|null $where // ARRAY-LITERAL ['param':'value..] If u want to generate by specific condition.
 * @param int $limit // INT If u want to limit the generated cards like 10, 1 etc.
 * @return string
 */
function cardBig(string $type = "", array $where = null, string $order_by = null, int $limit = PHP_INT_MAX):string{
    $returnValue = "";
    $order_by = $order_by == null ? '' : ', ' . $order_by;
    $conditions = '';
    if($where != null) {
        $conditions = 'WHERE ';
        foreach ($where as $key => $value) {
            $conditions .= $key . '' . $value;
        }
    }

    $query = new SQLQuery("SELECT ms.name AS manufacturer, carname, engine, releasedate, status, price, discount, carsID FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID) $conditions ORDER BY status ASC, ms.name ASC $order_by LIMIT $limit;", []);
        $result = $query->getResult();
       /* echo "<pre>";
            var_dump($query);
        echo "</pre>";*/
        if($result != null) {
            $returnValue = '<div class="col width-270">';
            $returnValue = $type == "carousel-item" ? $returnValue . '<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel"><div class="carousel-inner">' : $returnValue . '';
            foreach ($result as $item) {
                if ($type == "carousel-item" && $item == $result[0])
                    $returnValue .= '<div class="carousel-item active">';
                else if ($type == "carousel-item")
                    $returnValue .= '<div class="carousel-item">';
                else if ($type == 'carousel' && $item != $result[0])
                    $returnValue .= '</div><div class="col width-270"><div class="carousel">';
                else $returnValue .= '<div class="carousel">';
//                $returnValue .= "<button style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;' onclick='location.href=\"../pages/car.php?car=".$item->manufacturer.$item->carname.$item->releasedate."\"'>";
                $returnValue .= "<button onclick='location.href=\"../pages/car.php?car=".$item->carsID."\"' style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;'>"."<div class='slider-img'><img src='../images/cars/$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png' class='d-block w-75 mx-auto' alt='$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png'></div><div class='text'><div><img src='../images/manufacturers/$item->manufacturer.png' width='45px' class='px-1' alt='$item->manufacturer icon'>&nbsp;<b>$item->carname</b>&nbsp;<span>$item->engine $item->releasedate</span></div><div class='action-price'>";
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
        }else{
            $returnValue .= "<div class='width-270 col'><div class='carousel'><div class='slider-img'><img src='../images/cars/ghost.png' class='d-block mx-auto py-5' alt='ghost.png'><div class='text-center'><div class='text'>Nincs jármű találat.</div></div></div></div></div>";
        }
    return $returnValue;
    //return "";
}

function generateStars(float $rating):string{
    $stars = ['<i class="fa-regular fa-star"></i>', '<i class="fa-solid fa-star-half-stroke"></i>', '<i class="fa-solid fa-star"></i>'];
    $rating = floor($rating * 2) / 2;
    $value = "";
    if($rating == 0)
        $value .= str_repeat($stars[0], 5);
    else if($rating == 5)
        $value .= str_repeat($stars[2], 5);
    else {
        $value .= str_repeat($stars[2], floor($rating));
        if(is_float($rating) && floor($rating) != $rating){
            $value .= $stars[1];
        }
    }
    $value .= str_repeat($stars[0], 5 - $rating);


    return $value;
}

function cardSmall(string $type = "favorites", int $carID = 1):string{
 $returnValue = "<div class='swiper mySwiper' style='padding: .5rem; overflow-x: hidden;'><div class='swiper-wrapper'>";
 if($type == "favorites"){

//     $query = new SQLQuery("SELECT ms.name AS manufacturer, carname, engine, releasedate, p.price, p.discount, AVG(r.rating) as rating FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID INNER JOIN ratings r on cars.carsID = r.carID) WHERE r.rating is not null ORDER BY status ASC, ms.name ASC LIMIT 10;", []);
     $query = new SQLQuery("SELECT carsID, ms.name AS manufacturer, carname, engine, releasedate, p.price, p.discount, AVG(r.rating) as rating FROM (cars INNER JOIN manufactures AS ms ON cars.manufacturerID=ms.manufacturesID INNER JOIN prices p on cars.carsID = p.carID INNER JOIN ratings r on cars.carsID = r.carID) GROUP BY r.carID LIMIT 10;", []);
     $result = $query->getResult();
     if($result != null){
         foreach ($result as $item){
             $discount = number_format((double)$item->price - ((double)$item->price * (double)$item->discount / 100), 2);
             $returnValue .= "<div class='swiper-slide'>"."<button style='width:100%; margin: 0; background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;' onclick='location.href=\"../pages/car.php?car=".$item->carsID."\"'>"."<img src='../images/cars/$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png' alt='$item->manufacturer/$item->releasedate $item->manufacturer $item->carname.png'><div class='card-text'><img src='../images/manufacturers/$item->manufacturer.png' class='p-1' alt='$item->manufacturer icon'>&nbsp;<b>$item->carname</b>&nbsp;<span>$item->engine $item->releasedate</span><div class='rate-price'><span>Már napi&nbsp;<b>$discount €</b></span><div class='rate' style='margin-right: 1rem;'>";
             $returnValue .= generateStars($item->rating);
             $returnValue .= '</div></div></div></button></div>';
         }
     }
     else{
         $returnValue .= "<div class='swiper-slide w-100 position-relative'><img src='../images/cars/ghost.png'  class='py-5' style='width: 100px;' alt='ghost.png'><div class='w-100 text position-absolute'>Nincs értékelés.</div></div>";
     }
 }
 elseif ($type == "comments"){
     $query = new SQLQuery("SELECT CONCAT(u.lastname, ' ', u.firstname) AS name, u.avatar AS avatar, commentTitle, comment, created, likes, dislikes, rating, ratingID FROM ratings INNER JOIN users u on ratings.userID = u.usersID WHERE carID = :carID ORDER BY (likes-dislikes) DESC;", [':carID'=>$carID]);
     $result = $query->getResult();
     if($result != null) {
         foreach ($result as $item) {
             $returnValue.= "<div class='swiper-slide'><div class='comment-card w-100'><div class='comment-header d-flex gap-2'><img id='user-image' src='";
             if($item->avatar != null && $item->avatar != '')
                 $returnValue.= "data:image/jpeg;base64,".base64_encode($item->avatar);
             else
                 $returnValue.= "../images/icons/user-default.png";
             $returnValue .= "' alt='user-avatar'><div class='comment-user-data d-flex flex-column'><span>$item->name</span><small>$item->created</small></div></div><div class='comment-body mt-3'><div class='d-flex justify-content-between align-items-center gap-2'><span class='comment-title d-block text-start'>$item->commentTitle</span><div class='rate d-flex align-items-center'>";
             $returnValue .= generateStars($item->rating);
             $returnValue .= "</div></div><p class='p-2'>$item->comment</p></div><div class='comment-footer d-flex flex-column gap-2 pt-3'><div class='likes d-flex align-items-center gap-4'><form id='comment_update_likes' method='post'></form><div class='likes d-flex gap-2 align-items-center thumbs-myselect'><button class='button-2 like' type='submit' form='comment_update_likes' name='like' value='$item->ratingID'><i class='fa-solid fa-thumbs-up'></i></button><span class='like'>$item->likes</span></div><div class='likes d-flex gap-2 align-items-center'><button class='button-2 dislike' type='submit' form='comment_update_likes' name='dislike' value='$item->ratingID'><i class='fa-solid fa-thumbs-down'></i></button><span class='dislike'>$item->dislikes</span></div></div></div></div></div>";
         }
     }
     else{
         $returnValue .= "<div class='swiper-slide w-100 position-relative'><img src='../images/cars/ghost.png'  class='py-5' style='width: 100px;' alt='ghost.png'><div class='w-100 text position-absolute'>Nincs értékelés.</div></div>";
     }
 }
 $returnValue .= "</div><div class='swiper-button-next'></div><div class='swiper-button-prev'></div></div>";
 return $returnValue;
}