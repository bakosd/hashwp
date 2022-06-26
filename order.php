<?php
require_once "config.php";
$session = new Session();
if(!empty($session->get('userID')) && !empty($_GET['car'])) {
$temp = tryGetResultToOrderPage();
$carID = $temp[0];
$result = $temp[1];
    if (isset($_POST['pick-date']) && isset($_POST['drop-date']) && !empty($carID)) {
        $drop = null;
        $pick = null;
        if (isset($_POST['pick-date'])) {
            $pick = $_POST['pick-date'];
            $session->set('temp_rent_start', $pick);
        }
        if (isset($_POST['drop-date'])) {
            $drop = $_POST['drop-date'];
            $session->set('temp_rent_end', $drop);
        }
        $q = new SQLQuery("SELECT rentStartdate, rentEnddate, status FROM orders where carID = :carID", [":carID" => $carID]);
        $res = $q->getResult();
        $is_available = "available";
        foreach ($res as $item)
            if ((($item->rentStartdate <= $drop) && ($item->rentEnddate >= $pick)))
                $is_available = "not-available";
        exit($is_available);
    }
    $car_full_name = $temp[2];
    $car_banner = $temp[3];
    $title_str = empty($car_full_name) ? "" : $title_str = "$car_full_name - ";
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script><link rel="icon" type="image/x-icon" href="images/icons/logo-100.png"><link rel="stylesheet" href="styles/global.css"><link rel="stylesheet" href="styles/order.css"><link rel="stylesheet" href="styles/navbar.css"><link rel="stylesheet" href="styles/index.css"><link rel="stylesheet" href="styles/cards.css"><link rel="stylesheet" href="styles/car.css"><meta name="viewport" content="width=device-width,height=device-heightinitial-scale=1"><link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    ' . "<title> $title_str rendelés Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";

    require_once "navigation.php";
    if (!empty($carID) && !empty($result)) {
        $discount = number_format((double)$result->price - ((double)$result->price * (double)$result->discount / 100), 2);

        echo "<main style='margin-top: 4.5rem'>
       <div class='container'><div id='progress-bar' class='col-12 progress border mb-5' style='height: 1.25rem !important;border: 2px solid black !important;'><div class='progress-bar bg-success' role='progressbar' style='width: 35%; border-right: 2px solid black' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>1/4</div></div></div>
        <div class='container' id='container-data'>
       ";
        $pick = $session->get('temp_rent_start');
        $drop = $session->get('temp_rent_end');

        echo "<div class='row d-flex gap-4'><div class='col-lg-5 col-sm-12 p-2 d-flex flex-column gap-5 align-items-center'><div class='carousel w-100'><div class='slider-img' style='border-radius: .5rem .5rem 0 0'><img src='../images/cars/$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png' class='d-block w-75 mx-auto' alt='$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png'></div><div class='text'><div><img src='../images/manufacturers/$result->manufacturer.png' width='45px' class='px-1' alt='$result->manufacturer icon'>&nbsp;<b>$result->carname</b>&nbsp;<span>$result->engine $result->releasedate</span></div><div class='action-price'><span>Napi díj:</span>&nbsp;<span class='price'><b>$result->price €</b></span></div></div></div><div class='rate-price-buttons w-100 d-flex align-items-center flex-column gap-3'><div class='d-flex justify-content-around w-100 align-items-center'><form id='date-check' name='date-check' class='d-flex flex-column gap-2'><div class='p-1 w-100'><label for='pick-date' class='user-select-none'>Átvétel ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='pick-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='pick-date' name='pick-date' value='$pick'></div></div><div class='p-1 w-100'><label for='drop-date' class='user-select-none'>Leadás ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='drop-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='drop-date' name='drop-date' value='$drop'></div></div><input type='hidden' name='car' value='$carID'></form><button type='submit' form='date-check' class='button px-3 d-flex justify-content-center align-items-center gap-2'>Frissítés<i class='fa-solid fa-angle-right'></i></button></div></div></div><div class='col-lg-6 col-sm-12 mx-auto'><div class='row d-flex flex-column gap-3 px-1'><h2 class='w-100'>Extra szolgáltatások</h2>";


        $query = new SQLQuery("SELECT * from order_extras", []);
        $order_extras = $query->getResult();
        foreach ($order_extras as $extra)
            echo "<div class='w-100 link d-flex justify-content-between align-items-center gap-1' ><div class='specs-img'><img src='../images/icons/carspecs/extras/$extra->orderextrasID.png' alt='engine'></div><span class='car-specs text-align-right'><b>$extra->name</b></span><span class='car-specs'><b>$extra->price</b></span><input form='order-page1' class='button selectedextras' name='selectedextras[]' type='checkbox' value='$extra->orderextrasID'></div>";
        echo "<button type='submit' form='order-page1' id='order-page1-btn' class='button px-3 d-flex justify-content-center align-items-center gap-2'>Tovább<i class='fa-solid fa-angle-right'></i></button>";

        echo "<div>
            
</div>
        </div>
</main>
<form id='order-page1'><input name='car' type='hidden' value='$carID'><input name='next' type='hidden' value='2'></form><form id='order-page2'><input name='car' type='hidden' value='$carID'><input name='next' type='hidden' value='3'></form><form id='order-page3'><input name='car' type='hidden' value='$carID'><input name='next' type='hidden' value='4'></form>";
    } else
        echo "<main></main>";


    require_once "footer.php";


    echo '<script src="scripts/button-events.js"></script><script src="scripts/events.js"></script><script src="scripts/ajax.js"></script></body></html>';
}
else {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script><link rel="icon" type="image/x-icon" href="images/icons/logo-100.png"><link rel="stylesheet" href="styles/global.css"><link rel="stylesheet" href="styles/order.css"><link rel="stylesheet" href="styles/navbar.css"><link rel="stylesheet" href="styles/index.css"><link rel="stylesheet" href="styles/cards.css"><link rel="stylesheet" href="styles/car.css"><meta name="viewport" content="width=device-width,height=device-heightinitial-scale=1"><link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"><title>Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>';
    require_once "navigation.php";
    echo "<main class='container' style='margin-top: 4.5rem'><div class='text-center text-danger'>HIBA! Jelentkezz be a rendelés megkezdéséhez!</div></main>". '<script src="scripts/button-events.js"></script><script src="scripts/events.js"></script><script src="scripts/ajax.js"></script></body></html>';
    require_once "footer.php";
}


