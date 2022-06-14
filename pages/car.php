<?php
require_once "config.php";
$carID = 0;
$query = null;
$result = null;
if (isset($_GET['car']) || isset($_POST['car']))
{
    //HEADER REFRESH TO REMOVE $_GET[] parameter
    //echo "<script>window.history.replaceState({}, '','../pages/car.php');</script>";

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


    $title_str = "";
    $car_full_name = "";
    if ($carID > 0 && !empty($result)) {
        $car_full_name = "$result->manufacturer $result->carname $result->releasedate";
        $title_str = "$car_full_name - ";
    }
echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><link rel="icon" type="image/x-icon" href="../images/icons/logo-100.png"><link rel="stylesheet" href="../styles/global.css"><link rel="stylesheet" href="../styles/navbar.css"><link rel="stylesheet" href="../styles/index.css"><link rel="stylesheet" href="../styles/cards.css"><link rel="stylesheet" href="../styles/car.css"><meta name="viewport" content="width=device-width,height=device-heightinitial-scale=1"><link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
'."<title> $title_str Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";

    require_once "navigation.php";
if(!empty($carID) && !empty($result)) {
    $discounted = "";
    $stars = "";

    if($result->discount > 0) $discounted = "<small><del>Már napi&nbsp;<b>".number_format((double)$result->price - ((double)$result->price * (double)$result->discount / 100), 2)." €</b></del></small>";

    $stars = $result->rating != null ? generateStars($result->rating) : generateStars(5);

    $total_rating = $result->total_rating != 0 ? $result->total_rating : 1;

    if ($result->status == 1 || $result->servisdistance < 500) $available = "<span class='not-available d-flex align-items-center justify-content-center gap-1 my-5'><i class='fa-solid fa-wrench'></i>Ismeretlen ideig nem elérhető! (Szervíz)</span>";
    else $available = "<form id='date-check' name='date-check' class='d-flex flex-column gap-2'><div class='p-1 w-100'><label for='pick-date' class='user-select-none'>Átvétel ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='pick-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='pick-date' name='pick-date'></div></div><div class='p-1 w-100'><label for='drop-date' class='user-select-none'>Leadás ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='drop-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='drop-date' name='drop-date'></div></div></form><button type='submit' form='date-check' name='submit-date-check' class='button px-3 d-flex justify-content-center align-items-center gap-2'>Tovább<i class='fa-solid fa-angle-right'></i></button>";

    if(!empty($result->extras)){
        $extras = "<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='1'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Jármű felszereltségei</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' data-droppush-content='1'>";
        $extras_array = (array)json_decode($result->extras)[0];
        foreach ($extras_array as $key=>$value)
            $extras .= "<div class='col car-specs-wrap link d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/$key.png' alt='$key icon'></div><span class='car-specs'><b>$value</b></span></div>";
        $extras .= "</div></div>";
    }
    else $extras = "<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down visually-hidden'></i><h5 class='w-100 my-auto link car-specs-wrap'>Nincs extra felszereltség.</h5></div></div>";

    $car_full_name_folder = "$result->releasedate $result->manufacturer $result->carname";
    $images_count = count(glob("../images/cars/$result->manufacturer/$car_full_name_folder/*.jpg"));
    if ($images_count > 0){
        $images = "";
        for ($i = 1; $i < $images_count; $i++){
            $i == 1 ? $images .= "<div class='carousel-item active'>" : $images .="<div class='carousel-item'>";
            $images .= "<div class='slider-img'><img src='../images/cars/$result->manufacturer/$car_full_name_folder/$i.jpg' class='d-block w-100 mx-auto' alt='$car_full_name - kep#$i'></div></div>";
        }
    }else
        $images = "<div class='carousel-item active'><div class='slider-img'><img src='../images/cars/default.jpg' class='d-block w-100 mx-auto' alt='default-image'></div></div>";


    echo "<main class='container'><div class='navigation-header row d-flex justify-content-center align-items-center gap-2'><div class='col'><h2 class='col d-flex gap-2 align-items-center' style='overflow: hidden'><div class='manufacturer-logo d-flex align-items-center'><img src='../images/manufacturers/$result->manufacturer.png' alt='$result->manufacturer logo' style='width: 45px' class='px-1'></div><span class='car-title'><span>$result->manufacturer</span>&nbsp;$result->carname&nbsp;<i>$result->releasedate</i></span></h2><div class='row gap-3 mt-5' style='margin-bottom: 10rem'><div class='col width-270 d-flex flex-column align-items-center gap-4'><div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel'><div class='carousel-inner'>$images</div><button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='prev'><span class='carousel-control-prev-icon' aria-hidden='true'></span> <span class='visually-hidden'>Previous</span></button> <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='next'><span class='carousel-control-next-icon' aria-hidden='true'></span> <span class='visually-hidden'>Next</span></button></div><div class='rate-price-buttons w-100 d-flex align-items-center flex-column gap-3'><div class='rate-price w-100 justify-content-around'><div class='d-flex flex-column gap-1'>$discounted <span>Már napi&nbsp;<b>$result->price €</b></span></div><div class='rate'>$stars&nbsp;($total_rating)</div></div><div class='d-flex justify-content-around w-100 align-items-center'>$available</div></div></div><div class='col width-270 user-select-none'><!--SPECIFIKÁCIÓ RÉSZ--><h3 class='w-100 text-center mb-4'>Jármű specifikációk</h3><div class='row d-flex flex-wrap justify-content-start align-items-center gap-2 px-3'><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/engine.png' alt='engine'></div><span class='car-specs'><b>Motor:&nbsp;</b>$result->engine</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/horsepower.png' alt='horsepower'></div><span class='car-specs'><b>Teljesítmény:&nbsp;</b>$result->horsepower lóerő</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/gear.png' alt='gearbox'></div><span class='car-specs'><b>Váltó:&nbsp;</b>".$result->gearbox."ű</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/fuel.png' alt='fuel'></div><span class='car-specs'><b>Üzemanyag:&nbsp;</b>$result->fuel</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/doors.png' alt='doors'></div><span class='car-specs'><b>Ajtók száma:&nbsp;</b>$result->doors</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/seats.png' alt='seats'></div><span class='car-specs'><b>Ülések száma:&nbsp;</b>$result->seats</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/airconditioner.png' alt='airconditioner'></div><span class='car-specs'><b>Klíma:&nbsp;</b>$result->airconditioner</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/emissions.png' alt='emissions'></div><span class='car-specs'><b>Emisszió</b><small style='font-size: .725em'>(CO<sup>2</sup>)</small><b>:&nbsp;</b>$result->emissions</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/years/2016.png' alt='releasedate'></div><span class='car-specs'><b>Évjárat:&nbsp;</b>$result->releasedate</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/bodywork/convertible.png' alt='bodywork'></div><span class='car-specs'><b>Karosszéria:&nbsp;</b>$result->bodywork</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/odometer.png' alt='distance'></div><span class='car-specs'><b>Megtett út:&nbsp;</b>".number_format($result->distance, 0, '.', '.')." km</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/consumption.png' alt='consumption'></div><span class='car-specs'><b>Fogyasztás:&nbsp;</b>".$result->consumption."l/100km</span></div></div>$extras</div></div>" . cardSmall('comments', $carID) . "<!-- Swiper JS --><script src='https://unpkg.com/swiper/swiper-bundle.min.js'></script></div></div></main>";
}
else
    echo "<main></main>";


    require_once "footer.php";


    echo '<script src="../scripts/button-events.js"></script><script src="../scripts/events.js"></script><script src="../scripts/auto-swipe.js"></script></body></html>';
