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
$session = new Session();
if (isset($_POST['pick-date']) && isset($_POST['drop-date']) && !empty($carID)){
//    if ($)
    $drop = null; $pick = null;
    if (isset($_POST['pick-date'])) {
        $pick = $_POST['pick-date'];
        $session->set('temp_rent_start', $pick);
    }
    if (isset($_POST['drop-date'])){
        $drop = $_POST['drop-date'];
        $session->set('temp_rent_end', $drop);
    }
    $q = new SQLQuery("SELECT rentStartdate, rentEnddate, status FROM orders where carID = :carID", [":carID"=>$carID]);
    $res = $q->getResult();
    $is_available = "available";
    foreach ($res as $item)
        if( (($item->rentStartdate <= $drop) && ($item->rentEnddate >= $pick)))
            $is_available = "not-available";
    exit($is_available);
}

    $title_str = "";
    $car_full_name = "";
    if ($carID > 0 && !empty($result)) {
        $car_full_name = "$result->manufacturer $result->carname $result->releasedate";
        $title_str = "$car_full_name - ";
    }
echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script><link rel="icon" type="image/x-icon" href="images/icons/logo-100.png"><link rel="stylesheet" href="styles/global.css"><link rel="stylesheet" href="styles/navbar.css"><link rel="stylesheet" href="styles/index.css"><link rel="stylesheet" href="styles/cards.css"><link rel="stylesheet" href="styles/car.css"><meta name="viewport" content="width=device-width,height=device-heightinitial-scale=1"><link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
' ."<title> $title_str Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";

    require_once "navigation.php";
if(!empty($carID) && !empty($result)) {
    $discounted = "";
    $stars = "";

    if($result->discount > 0) $discounted = "<small><del>Már napi&nbsp;<b>".number_format((double)$result->price - ((double)$result->price * (double)$result->discount / 100), 2)." €</b></del></small>";

    $stars = $result->rating != null ? generateStars($result->rating) : generateStars(5);

    $total_rating = $result->total_rating != 0 ? $result->total_rating : 1;

    if ($result->status == 1 || $result->servisdistance < 500) $available = "<span class='not-available d-flex align-items-center justify-content-center gap-1 my-5'><i class='fa-solid fa-wrench'></i>Ismeretlen ideig nem elérhető! (Szervíz)</span>";
    else {
        $pick = $session->get('temp_rent_start');
        $drop = $session->get('temp_rent_end');
        $available = "<form id='date-check-form' name='date-check-form' class='d-flex flex-column gap-2 col-lg-6 col-sm-12'><div class='p-1 w-100'><label for='pick-date' class='user-select-none'>Átvétel ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='pick-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='pick-date' name='pick-date' value='$pick'></div></div><div class='p-1 w-100'><label for='drop-date' class='user-select-none'>Leadás ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='drop-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='drop-date' name='drop-date' value='$drop'></div></div><input type='hidden' name='car' value='$carID'></form><button type='submit' form='date-check-form' id='submit-data-order-btn' name='submit-date-check' class='button px-3 d-flex justify-content-center align-items-center gap-2 mt-5 mb-3 col-lg-3 col-sm-12'>Tovább<i class='fa-solid fa-angle-right'></i></button>";
    }
    if(!empty($result->extras)){
        $extras = "<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='1'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Jármű felszereltségei</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' data-droppush-content='1'>";
        $extras_array = (array)json_decode($result->extras)[0];
        foreach ($extras_array as $key=>$value)
            $extras .= "<div class='col car-specs-wrap link d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/$key.png' alt='$key icon'></div><span class='car-specs'><b>$value</b></span></div>";
        $extras .= "</div></div>";
    }
    else $extras = "<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down visually-hidden'></i><h5 class='w-100 my-auto link car-specs-wrap'>Nincs extra felszereltség.</h5></div></div>";

    $car_full_name_folder = "$result->carsID $result->releasedate $result->manufacturer $result->carname";
    $images_count = count(glob("images/cars/$result->manufacturer/$car_full_name_folder/*.jpg"));
    if ($images_count > 0){
        $images = "";
        $imgpath="";
        for ($i = 1; $i < $images_count; $i++){
            $i == 1 ? $images .= "<div class='carousel-item active'>" : $images .="<div class='carousel-item'>";
            $images .= "<div class='slider-img'><img src='images/cars/$result->manufacturer/$car_full_name_folder/$i.jpg' class='d-block w-100 mx-auto' alt='$car_full_name - kep#$i'></div></div>";
        }
    }else{
        $images = "<div class='carousel-item active'><div class='slider-img'><img src='images/cars/default.jpg' class='d-block w-100 mx-auto' alt='default-image'></div></div>";
    }
    ///////////////////////////////////////////////////////////////////////
    $carID=$_GET['car'];
    $editSQL = new SQLQuery("SELECT * FROM cars WHERE carsID = $carID",[]);
    $editresult = $editSQL->getResult();

    foreach($editresult as $item)
    {
        $manufacturer = $item->manufacturerID;
        $modell = $item->carname;
        $engine = $item->engine;   
        $gear = $item->gearbox;
        $fuel = $item->fuel;
        $horsepower = $item->horsepower;
        $seats = $item->seats;
        $doors = $item->doors;
        $bodywork = $item->bodywork; 
        $year = $item->releasedate; 
        $distance = $item->distance; 
        $servisdistance = $item->servisdistance; 
        $consumption = $item->consumption; 
        $emission = $item->emissions; 
        $airconditioner = $item->airconditioner; 
        $status = $item->status; 
        $equipment = $item->extras;
    }

    $priceSQL = new SQLQuery("SELECT * FROM prices WHERE carID = $carID",[]);
    $priceresult = $priceSQL->getResult();

    foreach($priceresult as $p)
    {
        $dicount = $p->discount;
        $price = $p->price;
    }
    //////////////////////////////////////////////////////////////////////

    if ($session->get('userID')) {
        $fav_query = new SQLQuery("SELECT favoritesID FROM favorites WHERE carID=:carID AND userID = :userID LIMIT 1", [':carID' => $result->carsID, ':userID' => $session->get('userID')]);
        $is_favorited = ($fav_query->getResult() != null) ? "style='color: var(--col-nosucc)'" : '';
        $favorite_button = "<button class='mx-2 button-favorite' id='favorite_button' data-favorite='$result->carsID'><i class='fa-solid fa-heart' $is_favorited></i></button>";
    }
    else
        $favorite_button = "";

    echo "<main class='container'><div class='navigation-header row d-flex justify-content-center align-items-center gap-2'><div class='col'><h2 class='col d-flex gap-2 align-items-center' style='overflow: hidden'><div class='manufacturer-logo d-flex align-items-center'><img src='images/manufacturers/$result->manufacturer.png' alt='$result->manufacturer logo' style='width: 45px' class='px-1'></div><span class='car-title'><span>$result->manufacturer</span>&nbsp;$result->carname&nbsp;<i>$result->releasedate</i></span>$favorite_button</h2><div class='row gap-3 mt-5' style='margin-bottom: 10rem'><div class='col width-270 d-flex flex-column align-items-center gap-4'><div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel'><div class='carousel-inner'>$images</div><button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='prev'><span class='carousel-control-prev-icon' aria-hidden='true'></span> <span class='visually-hidden'>Previous</span></button> <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='next'><span class='carousel-control-next-icon' aria-hidden='true'></span> <span class='visually-hidden'>Next</span></button></div><div class='rate-price-buttons w-100 d-flex align-items-center flex-column gap-3'><div class='rate-price w-100 justify-content-around'><div class='d-flex flex-column gap-1'>$discounted <span>Már napi&nbsp;<b>$result->price €</b></span></div><div class='rate'>$stars&nbsp;($total_rating)</div></div><div class='d-flex justify-content-around w-100 align-items-center row'>$available</div></div></div><div class='col width-270 user-select-none'><!--SPECIFIKÁCIÓ RÉSZ--><h3 class='w-100 text-center mb-4'><div>Jármű specifikációk"; if($session->get('level')==3 && $session->get('edit') == 1) { echo "<button class='mt-4' id='modalopen' data-bs-toggle='modal' data-bs-target='#newcar-modal'>Szerkesztés</button>"; } echo "</div></h3><div class='row d-flex flex-wrap justify-content-start align-items-center gap-2 px-3'><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/engine.png' alt='engine'></div><span class='car-specs'><b>Motor:&nbsp;</b>$result->engine</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/horsepower.png' alt='horsepower'></div><span class='car-specs'><b>Teljesítmény:&nbsp;</b>$result->horsepower lóerő</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/gear.png' alt='gearbox'></div><span class='car-specs'><b>Váltó:&nbsp;</b>" .$result->gearbox. "ű</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/fuel.png' alt='fuel'></div><span class='car-specs'><b>Üzemanyag:&nbsp;</b>$result->fuel</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/doors.png' alt='doors'></div><span class='car-specs'><b>Ajtók száma:&nbsp;</b>$result->doors</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/seats.png' alt='seats'></div><span class='car-specs'><b>Ülések száma:&nbsp;</b>$result->seats</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/airconditioner.png' alt='airconditioner'></div><span class='car-specs'><b>Klíma:&nbsp;</b>$result->airconditioner</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/emissions.png' alt='emissions'></div><span class='car-specs'><b>Emisszió</b><small style='font-size: .725em'>(CO<sup>2</sup>)</small><b>:&nbsp;</b>$result->emissions</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/years/$result->releasedate.png' alt='$result->releasedate'></div><span class='car-specs'><b>Évjárat:&nbsp;</b>$result->releasedate</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='../images/icons/carspecs/bodywork/$result->bodywork.png' alt='bodywork'></div><span class='car-specs'><b>Karosszéria:&nbsp;</b>$result->bodywork</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/odometer.png' alt='distance'></div><span class='car-specs'><b>Megtett út:&nbsp;</b>" .number_format($result->distance, 0, '.', '.'). " km</span></div><div class='col link car-specs-wrap d-flex justify-content-start align-items-center gap-2'><div class='specs-img'><img src='images/icons/carspecs/consumption.png' alt='consumption'></div><span class='car-specs'><b>Fogyasztás:&nbsp;</b>" .$result->consumption."l/100km</span></div></div>$extras</div></div>" . cardSmall('comments', $carID) . "<!-- Swiper JS --><script src='https://unpkg.com/swiper/swiper-bundle.min.js'></script></div></div></main>";
}
else
    echo "<main></main>";

    require_once "footer.php";

    echo '<script src="scripts/button-events.js"></script><script src="scripts/events.js"></script><script src="scripts/auto-swipe.js"></script><script src="scripts/ajax.js"></script></body></html>';


    $manufacturers="";
    $sql = new SQLQuery("SELECT * FROM manufactures",[]);
    $result = $sql -> getResult();
    
    foreach($result as $manufacture)
    {
        $selected = "";
        if($manufacture->manufacturesID == $manufacturer)
        {
            $selected = "selected";
            $originalName = $carID." ".$year." ".$manufacture->name." ".$modell;
            $manName = $manufacture->name;
        }
            $manufacturers .= "<option $selected value=".$manufacture->manufacturesID.">".$manufacture->name."</option>";  
    }
    $gas="";
    $fuels = array ('Benzin', 'Dízel', 'Elektromos', 'Hybrid');
    foreach($fuels as $f)
    {
        $selected = "";
        if($f == $fuel)
        {
            $selected = "selected"; 
        }
        $gas .= "<option $selected value=".$f.">".$f."</option>";
    }
    $aircondition="";
    $airconditioners = array ('Nincs', 'Manuális', 'Automata', 'Kétzónás');
    foreach($airconditioners as $air)
    {
        $selected = "";
        if($air == $airconditioner)
        {
            $selected = "selected"; 
        }
        $aircondition .= "<option $selected value=".$air.">".$air."</option>";
    }
    $bwork="";
    $bodyworks = array ('Szedan', 'Kabrio', 'Limuzin', 'Coupe', 'Hatchback', 'Kombi', 'SUV', 'Terepjaro');
    foreach($bodyworks as $body)
    {
        $selected = "";
        if($body == $bodywork)
        {
            $selected = "selected"; 
        }
        $bwork .= "<option $selected value=".$body.">".$body."</option>";
    }
//////////////////////////////////////////////////////////////////////////////////

    $content = "<div class='p-3'><form id='updatecar' method='post' action='car_action.php'><div class='form-group'><label>Gyártó</label><select name='manufacturer'>" .$manufacturers."</select></div><div class='form-group'><label>Modell</label><input type='text' name='modell' value='".$modell."'></div><div class='form-group'><label>Motor</label><input type='text' name='motor' value='".$engine."'></div><div class='form-group'><label>Teljesítmény</label><input type='number' name='horsepower' value='".$horsepower."'></div><div class='form-group'><label>Váltó</label><input type='text' name='gear' value='".$gear."'></div><div class='form-group'><label>Üzemagyag</label><select name='fuel'>".$gas."</select></div><div class='form-group'><label>Ajtók száma</label><input type='number' name='doors' value='".$doors."'></div><div class='form-group'><label>Ülések száma</label><input type='number' name='seats' value='".$seats."'></div><div class='form-group'><label>Klíma</label><select name='airconditioner'>".$aircondition."</select></div><div class='form-group'><label>Emisszió</label><input type='number' name='emission' value='".$emission."'></div><div class='form-group'><label>Évjárat</label><input type='number' name='year' value='".$year."'></div><div class='form-group'><label>Karosszéria</label><select name='bodywork'>".$bwork."</select></div><div class='form-group'><label>Megtett út</label><input type='number' name='distance' value='".$distance."'></div><div class='form-group'><label>Szervít</label><input type='number' value='".$servisdistance."' name='servisdistance'></div><div class='form-group'><label>Fogyasztás</label><input type='number' name='consumtions' step='0.1' value='".$consumption."'></div><div class='form-group'><label>Felszereltség</label><div class='multi-selector'><div class='select-field'><input class='input-selector' type='text' placeholder='Felszereltség' disabled><span class='down-arrow'><i class='fa-solid fa-angle-down'></i></span></div><div class='list'><div class='item'><input type='checkbox' name='gps' id='gps'><label for='gps'>GPS</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='hook' id='hook'><label for='hook'>Vonóhorog</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='parkingasistant' id='parkingasistant'><label for='parkingasistant'>Parkolókamera</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='roof' id='roof'><label for='roof'>Tetőcsomagtartó</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='seatheater' id='seatheater'><label for='seatheater'>Ülésfűtés</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='tempomat' id='tempomat'><label for='tempomat'>Tempomat</label></div></div></div></div><div class='form-group'><label>Ár</label><input type='number' name='price' step='0.01' value='".$price."'></div><div class='form-group'><label>Kedvezmény(%)</label><input type='number' name='discount' value='".$dicount."'><input type='hidden' name='carID' value='".$carID."'><input type='hidden' name='originalName' value='".$originalName."'><input type='hidden' name='originalmanname' value='".$manName."'></div></form></div>";
    
    $modal = new Modal("newcar", "Jármű szerkesztés", $content, [['name'=>'delete_car', 'type'=>'submit', 'icon'=>'fa-circle-xmark', 'text'=>'Törlés', 'form'=>'updatecar'], ['name'=>'edit_car', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Hozzáad', 'form'=>'updatecar']]);
    echo $modal->getModal();


    echo 
    "<script>
    document.querySelector('.select-field').addEventListener('click',function(){
        document.querySelector('.list').classList.toggle('show');
    });
    </script>";
