<?php
require_once "config.php";
$carID = 0;
$query = null;
$result = null;
var_dump($_POST);
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
    $title_str = "";
    $car_full_name = "";
    $car_banner = "";
    if ($carID > 0 && !empty($result)) {
        $car_full_name = "$result->manufacturer $result->carname $result->releasedate";
        $title_str = "$car_full_name - ";
        $car_banner = "$result->releasedate $result->manufacturer $result->carname";
    }
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script><link rel="icon" type="image/x-icon" href="../images/icons/logo-100.png"><link rel="stylesheet" href="../styles/global.css"><link rel="stylesheet" href="../styles/order.css"><link rel="stylesheet" href="../styles/navbar.css"><link rel="stylesheet" href="../styles/index.css"><link rel="stylesheet" href="../styles/cards.css"><link rel="stylesheet" href="../styles/car.css"><meta name="viewport" content="width=device-width,height=device-heightinitial-scale=1"><link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    '."<title> $title_str rendelés Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";

    require_once "navigation.php";

    if(!empty($carID) && !empty($result)) {
        $discount = number_format((double)$result->price - ((double)$result->price * (double)$result->discount / 100), 2);

        /*<div class="position-relative m-4">
  <div class="progress" style="height: 1px;">
    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
  <button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">1</button>
  <button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">2</button>
  <button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">3</button>
</div>*/
        echo "<main style='margin-top: 4.5rem'>
        <div class='container'>
       ";

        echo "<div class='col-12 progress border mb-5' style='height: 1.25rem !important;border: 2px solid black !important;'>";
        $page = null;
        $page = 1;
        $succ = 0;
        $is_success = $succ == 1 ? "bg-success" : "bg-danger";
        if ($page >= 1) echo "<div class='progress-bar bg-success' role='progressbar' style='width: 35%; border-right: 2px solid black' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>1/4</div>";
        if ($page >= 2) echo "<div class='progress-bar bg-success' role='progressbar' style='width: 35%; border-right: 2px solid black' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>2/4</div>";
        if ($page >= 3) echo "<div class='progress-bar bg-success' role='progressbar' style='width: 15%; border-right: 2px solid black' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>3/4</div>";
        if ($page == 4) echo "<div class='progress-bar $is_success' role='progressbar' style='width: 15%;' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>4/4</div>";
        echo "</div>";
        $session = new Session();
        $pick = $session->get('temp_rent_start');
        $drop = $session->get('temp_rent_end');

        $query = new SQLQuery("SELECT concat(city, ', ', address) as city1, concat(city, ', ', address) as city2 FROM places ORDER BY placesID", []);
        $pick_drop_place = $query->getResult();
        if(isset($page)) {
            if ($page != 4) { //PAGE1 || PAGE2 || PAGE3
                echo "<div class='row d-flex gap-4'><div class='col-lg-5 col-sm-12 p-2 d-flex flex-column gap-5 align-items-center'><div class='carousel w-100'><div class='slider-img' style='border-radius: .5rem .5rem 0 0'><img src='../images/cars/$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png' class='d-block w-75 mx-auto' alt='$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png'></div><div class='text'><div><img src='../images/manufacturers/$result->manufacturer.png' width='45px' class='px-1' alt='$result->manufacturer icon'>&nbsp;<b>$result->carname</b>&nbsp;<span>$result->engine $result->releasedate</span></div><div class='action-price'><span>Napi díj:</span>&nbsp;<span class='price'><b>$result->price €</b></span></div></div></div>";
                if ($page != 3) { // PAGE1 || PAGE2
                    echo "<div class='rate-price-buttons w-100 d-flex align-items-center flex-column gap-3'><div class='d-flex justify-content-around w-100 align-items-center'><form id='order-page1-check' name='date-check-form' class='d-flex flex-column gap-2'><div class='p-1 w-100'><label for='pick-date' class='user-select-none'>Átvétel ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='pick-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='pick-date' name='pick-date' value='$pick'></div></div><div class='p-1 w-100'><label for='drop-date' class='user-select-none'>Leadás ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='drop-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='drop-date' name='drop-date' value='$drop'></div></div><input type='hidden' name='car' value='$carID'></form><button type='submit' form='order-form1-check' id='submit-order-check-btn' name='submit-order-check' class='button px-3 d-flex justify-content-center align-items-center gap-2'>Frissítés<i class='fa-solid fa-angle-right'></i></button></div></div></div><div class='col-lg-6 col-sm-12 mx-auto'><div class='row d-flex flex-column gap-3 px-1'>";
                    if ($page != 2) { // PAGE1
                        echo "<h2 class='w-100'>Extra szolgáltatások</h2>";
                        $query = new SQLQuery("SELECT * from order_extras", []);
                        $order_extras = $query->getResult();
                        foreach ($order_extras as $extra)
                            echo "<div class='w-100 link d-flex justify-content-between align-items-center gap-1' ><div class='specs-img'><img src='../images/icons/carspecs/engine.png' alt='engine'></div><span class='car-specs text-align-right'><b>$extra->name</b></span><span class='car-specs'><b>$extra->price</b></span><input form='order-page1' class='button' type='checkbox' value='$extra->orderextrasID'></div>";

                        echo "<button type='submit' form='order-page1' id='order-page1-btn' name='order-page1' class='button px-3 d-flex justify-content-center align-items-center gap-2'>Tovább<i class='fa-solid fa-angle-right'></i></button>";
                    } else { // PAGE2
                        echo "<h2 class='w-100'>Átvétel típusa</h2>
<div class='d-flex flex-column gap-4'>
<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='1'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Átvételi pont</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' data-droppush-content='1'>
    <div class='d-flex gap-2 flex-column my-4 justify-content-center align-items-center'>
        <div class='w-75'>" . dropdownButton('Átvételi pont', 'city1', $pick_drop_place, "", false) . "</div>
        <div class='w-75'>" . dropdownButton('Leadási pont', 'city2', $pick_drop_place, "", false) . "</div>
    </div>
    <button type='submit' form='order-page2' id='order-page2-btn' name='order-page2' class='button px-3 d-flex justify-content-center align-items-center gap-2 w-75 mx-auto'>Tovább<i class='fa-solid fa-angle-right'></i></button>
</div></div>
";
                        echo "
<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='2'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Házhozszállítás</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' data-droppush-content='2'>
            <div class='w-75 mx-auto py-4'><div>
            <label for='city'>Város</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-city'></i>
                            <input id='city' name='city' type='text' value=''>
                        </div>
                    </div>
                </div></div>
                <div><label for='zipcode'>Irányítószám</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-7'></i>
                            <input id='zipcode' name='zipcode' type='text' value=''>
                        </div>
                    </div>
                </div></div>

                <div><label for='street'>Utca</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-signs-post'></i>
                            <input id='street' name='street' type='text' value=''>
                        </div>
                    </div>
                </div></div>
                <div><label for='house'>Házszám</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-house'></i>
                            <input id='house' name='house' type='text' value=''>
                        </div>
                    </div>
                </div></div></div>
<button type='submit' form='order-page2' id='order-page2-btn' name='order-page2' class='button px-3 d-flex justify-content-center align-items-center gap-2 w-75 mx-auto'>Tovább<i class='fa-solid fa-angle-right'></i></button>
";
                    }
                    echo "</div></div></div>";
                } else { // PAGE3
                    echo "<div class='col-lg-6 col-sm-12 mx-auto'><div class='row d-flex flex-column gap-3 px-1'></div></div></div><div class='col row' style='gap: 4rem 0 !important;'>
<div class='col-lg-4 col-sm-12 d-flex flex-column gap-5'>
    <div class='row d-flex flex-column gap-2 px-2'>
        <h5 class='text-center' >Bérlés információi</h5>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Átvétel ideje:</b><span>$pick</span></div>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Leadás ideje:</b><span>$drop</span></div>
        <hr class='my-2'>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Össz. bérlés ideje:</b><span>10 nap és 8 óra</span></div>
    </div>
    <div class='row d-flex flex-column gap-2 px-2'>
        <h5 class='text-center' >Átvétel információi</h5>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Átvétel helye:</b><span>Szabadka</span></div>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Leadás helye:</b><span>Szabadka</span></div>
    </div>
</div>
<div class='col-lg-4 col-sm-12 d-flex flex-column gap-2 px-2'>
 <h5 class='text-center'>Kiválasztott extrák</h5>
<div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-around flex-wrap gap-2'><b>Kirendelt sofőr</b></span></div>
</div>
<div class='col-lg-4 col-sm-12 d-flex flex-column gap-2 px-2'>
 <h5 class='text-center'>Fizetendő összeg</h5>
    <div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>1x Kirendelt sofőr</b><span>21.99 €</span></span></div>
    <div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>10 nap és 8 óra</b><span>89.99 €</span></span></div>
    <div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>1x WiFi készülék</b><span>4.99 €</span></span></div>
    <hr class='m-5'>
    <div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>Összesítve: </b><span>124.99 €</span></span></div>
</div>
<div class='row my-5'><button type='submit' form='order-page3' id='order-page3-btn' name='order-page3' class='button px-3 d-flex justify-content-center align-items-center gap-2 w-75 mx-auto'>Rendelés véglegesítése<i class='fa-solid fa-angle-right'></i></button></div>
</div>
";
                }
            } else { //PAGE4
                if($succ == 1)
                    echo "<div class='row d-flex gap-4 justify-content-center'><h2 class='w-100 text-center'>Gratulálunk, sikeres rendelés!</h2><div class='col-lg-6 col-sm-12 p-2 d-flex flex-column gap-5 align-items-center '><div class='carousel w-100 justify-content-center'><div class='slider-img' style='border-radius: .5rem'><img src='../images/cars/$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png' class='d-block w-75 mx-auto' alt='$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png'></div></div></div><p class='text-center'>Sikeresen megrendelte a <b>$car_full_name</b> járművet!<br>A rendelés adataival elküldtünk egy emailt. <br> Mikor egy alkalmazottunk jóváhagyja a rendelést, egy újabb emailt fog kapni!</p>";
                else
                    echo "<div class='row d-flex gap-4 justify-content-center'><h2 class='w-100 text-center'>Sajnáljuk, nem sikerült a rendelés!</h2><p class='w-auto mx-auto text-left'>Lehetséges opciók: <br>- A járművet a rendelés folyamán valaki más megrendelte!<br>- A rendelést nem sikerült rögzíteni a szerverünkre. <br>- A bevitt adatok nem voltak megfelelőek!</p><br><b class='text-center'>Ha ön szerint más probléma akadt, lépjen velünk kapcsolatba!</b><br><span class='text-center'>support@hash.com</span>";



            }
        }
        //if page1 || page2
              //


        echo "
            <div></div>
           <form id='order-page1' method='post'></form>
           <form id='order-page2' method='post'></form>
           <form id='order-page3' method='post'></form>
        </div>
</main>";
                //order-page1-check
    }
    else
        echo "<main></main>";


    require_once "footer.php";


    echo '<script src="../scripts/button-events.js"></script><script src="../scripts/events.js"></script><script src="../scripts/ajax.js"></script></body></html>';



