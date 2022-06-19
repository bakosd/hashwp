<?php
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script><script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script><link rel='icon' type='image/x-icon' href='../images/icons/logo-100.png'><link rel='stylesheet' href='../styles/global.css'><link rel='stylesheet' href='../styles/navbar.css'><link rel='stylesheet' href='../styles/index.css'><link rel='stylesheet' href='../styles/cards.css'><link rel='stylesheet' href='../styles/car.css'><meta name='viewport' content='width=device-width,height=device-heightinitial-scale=1'><link rel='stylesheet' href='https://unpkg.com/swiper/swiper-bundle.min.css'><title>Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";
    require_once "navigation.php";

    $destinations = "";
    $query = new SQLQuery("SELECT * from places", []);
    $result = $query->getResult();
    if(!empty($result)) {
        foreach ($result as $item) {

            $place_full_name = $item->city .''.$item->placesID;
            $images_count = count(glob("../images/offices/$place_full_name/*.jpg"));
            if ($images_count > 0) {
                $images = "";
                for ($i = 1; $i < $images_count; $i++) {
                    $i == 1 ? $images .= "<div class='carousel-item active'>" : $images .= "<div class='carousel-item'>";
                    $images .= "<div class='slider-img'><img src='../images/offices/$place_full_name/$i.jpg' class='d-block w-100 mx-auto' alt='$place_full_name - kep#$i'></div></div>";
                }
            } else
                $images = "<div class='carousel-item active'><div class='slider-img'><img src='../images/cars/default.jpg' class='d-block w-100 mx-auto' alt='default-image'></div></div>";

            $destinations .= "<div class='d-flex row' style='margin-top: 4.5rem'>
<div class='col-12 d-flex align-items-center gap-2 mb-4'><div class='manufacturer-logo d-flex align-items-center'><img src='../images/icons/map.png' alt='map-icon' style='width: 45px;' class='p-1'></div>
            <h2>" . $item->city . "i átvételi pont</h2></div>
            <div class='col width-270 col-lg-6 col-sm-12'>
            <div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel'>
                <div class='carousel-inner'>$images</div>
                <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='prev'>
                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Previous</span>
                </button>
                <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='next'>
                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Next</span>
                </button>
            </div>
        </div>
        <div class='col-lg-6 col-sm-12 p-3 d-flex flex-column gap-2'>
            <h3 class='w-100 text-italic text-center'>Átvételi pont adatok</h3>
            <div class='d-flex gap-2 align-items-center flex-wrap link car-specs-wrap' style='width: 100% !important;'>
                <div class='specs-img d-flex align-items-center justify-content-center'><img src='../images/icons/map.png' alt='google-map'></div>
                <b class='user-select-none'>Iroda címe:</b>
                <span>$item->address, $item->city</span>
            </div>
            <div class='d-flex gap-2 align-items-center flex-wrap link car-specs-wrap' style='width: 100% !important;'>
                <div class='specs-img d-flex align-items-center justify-content-center'><img src='../images/icons/phone.png' alt='phone'></div>
                <b class='user-select-none'>Telefonszám:</b>
                <span>$item->phone</span>
            </div>
            <div class='d-flex gap-2 align-items-center flex-wrap link car-specs-wrap' style='width: 100% !important;'>
                <div class='specs-img d-flex align-items-center justify-content-center'><img src='../images/icons/email.png' alt='phone'></div>
                <b class='user-select-none'>E-mail:</b>
                <span>$item->email</span>
            </div>
            <div class='d-flex gap-2 flex-wrap link car-specs-wrap' style='width: 100% !important;'>
                <div class='specs-img d-flex align-items-center justify-content-center'><img src='../images/icons/busines_time.png' alt='busines_time'></div>
                <b class='user-select-none '>Nyitvatartás:</b>
                <div class='d-flex flex-column'>
                    <span>-Hétköznap: $item->workday</span>
                    <span>-Hétvégén: $item->weekend</span>
                </div>
            </div>
            <a href='tel:$item->phone' class='button my-4 text-center d-flex align-items-center justify-content-center'>Iroda hívása</a>
        </div>
    </div>";
        }
    }






echo "<main class='container'>$destinations";

    echo "</main><script src='../scripts/button-events.js'></script><script src='../scripts/events.js'></script><script src='../scripts/auto-swipe.js'></script></body></html>";
require_once "footer.php";