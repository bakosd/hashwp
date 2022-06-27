<?php
require_once "config.php";
if (!empty($_POST)) {
    $temp = tryGetResultToOrderPage();
    $carID = $temp[0];
    $result = $temp[1];
    $session = new Session();
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
    $page = 0;
    $succ = 0;
    $car_full_name = $temp[2];
    $data = null;
    $pick_place = "";
    $drop_place = "";
    $pick_deliver_needed = false;
    $drop_deliver_needed = false;


    if (isset($_POST)) {
        $data[0] = "";
        $data[1] = "";
        if (isset($_POST['selectedextras'])) {
            $selectedExtras = null;
            foreach ($_POST['selectedextras'] as $key => $value) {
                $selectedExtras[$key] = $value;
                $session->set('temp_selected_extras', $selectedExtras);
            }
        } else if ($_POST['next'] == "2") $session->remove('temp_selected_extras');
        if (isset($_POST['next'])) {
            if ($_POST['next'] == "2")
                $page = 2;
            if ($_POST['next'] == "3")
                $page = 3;
            if ($_POST['next'] == "4")
                $page = 4;
        }
        if ($_POST['next'] == 3) {
            if ((isset($_POST['city1']) && isset($_POST['city2'])) || (isset($_POST['city']) && isset($_POST['zipcode']) && isset($_POST['street']) && isset($_POST['house']) && isset($_POST['city3']))) {
                if (isset($_POST['city1']) && isset($_POST['city2'])) {
                    $pick_place = $_POST['city1'][0];
                    $drop_place = $_POST['city2'][0];
                }
                if (isset($_POST['city']) && isset($_POST['zipcode']) && isset($_POST['street']) && isset($_POST['house']) && isset($_POST['city3'])) {
                    $pick_place = $_POST['street'] . " " . $_POST['house'] . ", " . $_POST['city'] . ", " . $_POST['zipcode'];
                    $pick_deliver_needed = true;
                    if (isset($_POST['city3']) && $_POST['city3'][0] == "Az átvételi pont adatai") $drop_deliver_needed = true;
                    isset($_POST['city3']) && $_POST['city3'][0] != "Az átvételi pont adatai" ? $drop_place = $_POST['city3'][0] : $drop_place = $_POST['street'] . " " . $_POST['house'] . ", " . $_POST['city'] . ", " . $_POST['zipcode'];
                }
            } else
                exit('error2');
        }
        if ($_POST['next'] == 4) {
            if (isset($_POST['pick_place']) && isset($_POST['drop_place']) && !empty($session->get('temp_rent_start')) && !empty($session->get('temp_rent_end')) && !empty($session->get('temp_rent_price'))) {
                $drop_placeHome = "";
                $selected_extras = [];
                if (!empty($session->get('temp_selected_extras')))
                    $selected_extras = $session->get('temp_selected_extras');
                $selected_extras = json_encode($selected_extras);
                $query = new SQLQuery("SELECT placesID FROM places WHERE CONCAT(address, ', ', city) = :place LIMIT 1", [':place' => $_POST['pick_place']]);
                if (!empty($query->getResult())) {
                    $pick_placeID = $query->getResult()[0];
                    $pick_placeID = $pick_placeID->placesID;
                } else
                    $pick_placeHome = $_POST['pick_place'];

                $query = new SQLQuery("SELECT placesID FROM places WHERE CONCAT(address, ', ', city) = :place LIMIT 1", [':place' => $_POST['drop_place']]);
                if (!empty($query->getResult())) {
                    $drop_placeID = $query->getResult()[0];
                    $drop_placeID = $drop_placeID->placesID;
                } else
                    $drop_placeHome = $_POST['drop_place'];
                if (isset($pick_placeID) && isset($drop_placeID) && $pick_placeID > 0 && $drop_placeID > 0) {
                    $query = new SQLQuery("INSERT INTO orders (userID, carID, rentStartdate, rentEnddate, rentStartplaceID, rentEndplaceID, price, extras) VALUES (:userID, :carID, :rentStartdate, :rentEnddate, :rentStartplaceID, :rentEndplaceID, :price, :extras)", [':userID' => (int)$session->get('userID'), ':carID' => (int)$carID, ':rentStartdate' => $session->get('temp_rent_start'), ':rentEnddate' => $session->get('temp_rent_end'), ':rentStartplaceID' => (int)$pick_placeID, ':rentEndplaceID' => (int)$drop_placeID, ':price' => $session->get('temp_rent_price'), ':extras' => $selected_extras]);
                    if ($query->getDbq()->rowCount() > 0) {
                        if (UserSystem::sendEmail('order', $session->get('email'), $session->get('firstname'), $session->get('lastname'), null, null, $car_full_name, $query->lastInsertId))
                            $succ = 1;
                    }
                } elseif (isset($drop_placeHome) && !isset($pick_placeID) && !isset($drop_placeID)) {
                    $query = new SQLQuery("INSERT INTO orders (userID, carID, rentStartdate, rentEnddate, rentHomeplace, price, extras) VALUES (:userID, :carID, :rentStartdate, :rentEnddate, :rentHomeplace, :price, :extras)", [':userID' => (int)$session->get('userID'), ':carID' => (int)$carID, ':rentStartdate' => $session->get('temp_rent_start'), ':rentEnddate' => $session->get('temp_rent_end'), ':rentHomeplace' => $pick_placeHome, ':price' => $session->get('temp_rent_price'), ':extras' => $selected_extras]);
                    if ($query->getDbq()->rowCount() > 0) {
                        if (UserSystem::sendEmail('order', $session->get('email'), $session->get('firstname'), $session->get('lastname'), null, null, $car_full_name, $query->lastInsertId))
                            $succ = 1;
                    }
                } elseif (isset($drop_placeHome) && isset($drop_placeID) && $drop_placeID > 0) {
                    $query = new SQLQuery("INSERT INTO orders (userID, carID, rentStartdate, rentEnddate, rentHomeplace, rentEndplaceID, price, extras) VALUES (:userID, :carID, :rentStartdate, :rentEnddate, :rentHomeplace, :rentEndplaceID,  :price, :extras)", [':userID' => (int)$session->get('userID'), ':carID' => (int)$carID, ':rentStartdate' => $session->get('temp_rent_start'), ':rentEnddate' => $session->get('temp_rent_end'), ':rentHomeplace' => $pick_placeHome, ':rentEndplaceID' => $drop_placeID, ':price' => $session->get('temp_rent_price'), ':extras' => $selected_extras]);
                    if ($query->getDbq()->rowCount() > 0) {
                        if (UserSystem::sendEmail('order', $session->get('email'), $session->get('firstname'), $session->get('lastname'), null, null, $car_full_name, $query->lastInsertId))
                            $succ = 1;
                    }
                }
            }

        }


        $is_success = $succ == 1 ? "bg-success" : "bg-danger";
        $data[0] .= "<div class='progress-bar bg-success' role='progressbar' style='width: 35%; border-right: 2px solid black' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>1/4</div>";
        if ($page >= 2) $data[0] .= "<div id='prog_1' class='progress-bar bg-success' role='progressbar' style='width: 35%; border-right: 2px solid black' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>2/4</div>";
        if ($page >= 3) $data[0] .= "<div id='prog_2'class='progress-bar bg-success' role='progressbar' style='width: 15%; border-right: 2px solid black' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>3/4</div>";
        if ($page == 4) $data[0] .= "<div id='prog_3' class='progress-bar $is_success' role='progressbar' style='width: 15%;' aria-valuenow='30' aria-valuemin='10' aria-valuemax='100'>4/4</div>";

        $query = new SQLQuery("SELECT concat(address, ', ', city) as city1, concat(address, ', ', city) as city2, concat(address, ', ', city) as city3 FROM places ORDER BY placesID", []);
        $pick_drop_place = $query->getResult();
        $pick = $session->get('temp_rent_start');
        $drop = $session->get('temp_rent_end');
        if ($page != 4) { //PAGE1 || PAGE2 || PAGE3
            $data[1] .= "<div class='row d-flex gap-4'><div class='col-lg-5 col-sm-12 p-2 d-flex flex-column gap-5 align-items-center'><div class='carousel w-100'><div class='slider-img' style='border-radius: .5rem .5rem 0 0'><img src='../images/cars/$result->manufacturer/$result->carsID $result->releasedate $result->manufacturer $result->carname.png' class='d-block w-75 mx-auto' alt='$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png'></div><div class='text'><div><img src='../images/manufacturers/$result->manufacturer.png' width='45px' class='px-1' alt='$result->manufacturer icon'>&nbsp;<b>$result->carname</b>&nbsp;<span>$result->engine $result->releasedate</span></div><div class='action-price'><span>Napi díj:</span>&nbsp;<span class='price'><b>$result->price €</b></span></div></div></div>";
            if ($page != 3) { // PAGE1 || PAGE2
                $data[1] .= "<div class='rate-price-buttons w-100 d-flex align-items-center flex-column gap-3'><div class='d-flex justify-content-around w-100 align-items-center'><form id='date-check' name='date-check' class='d-flex flex-column gap-2'><div class='p-1 w-100'><label for='pick-date' class='user-select-none'>Átvétel ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='pick-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='pick-date' name='pick-date' value='$pick'></div></div><div class='p-1 w-100'><label for='drop-date' class='user-select-none'>Leadás ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='drop-date' class='px-2 fa-solid fa-calendar'></label><input type='datetime-local' id='drop-date' name='drop-date' value='$drop'></div></div><input type='hidden' name='car' value='$carID'></form><button type='submit' form='date-check' class='button px-3 d-flex justify-content-center align-items-center gap-2'>Frissítés<i class='fa-solid fa-angle-right'></i></button></div></div></div><div class='col-lg-6 col-sm-12 mx-auto'><div class='row d-flex flex-column gap-3 px-1'>";
                if ($page != 2) { // PAGE1
                    $data[1] .= "<h2 class='w-100'>Extra szolgáltatások</h2>";
                    $query = new SQLQuery("SELECT * from order_extras", []);
                    $order_extras = $query->getResult();
                    foreach ($order_extras as $extra)
                        $data[1] .= "<div class='w-100 link d-flex justify-content-between align-items-center gap-1' ><div class='specs-img'><img src='../images/icons/carspecs/extras/$extra->orderextrasID.png' alt='engine'></div><span class='car-specs text-align-right'><b>$extra->name</b></span><span class='car-specs'><b>$extra->price</b></span><form id='order-page1'><input form='order-page1' class='button selectedextras' name='selectedextras[]' type='checkbox' value='$extra->orderextrasID'></form></div>";

                    $data[1] .= "<button type='submit' form='order-page1' id='order-page1-btn' class='button px-3 d-flex justify-content-center align-items-center gap-2'>Tovább<i class='fa-solid fa-angle-right'></i></button>";
                } else { // PAGE2
                    $data[1] .= "<h2 class='w-100'>Átvétel típusa</h2>
<div class='d-flex flex-column gap-4'>
<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='1'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Átvételi pont</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' style='background-color: var(--col2);' data-droppush-content='1'>
    <div class='d-flex gap-2 flex-column my-4 justify-content-center align-items-center'>
        <div class='w-100'>" . dropdownButton('Átvételi pont', 'city1', $pick_drop_place, "", false, 'order-page2') . "</div>
        <div class='w-100'>" . dropdownButton('Leadási pont', 'city2', $pick_drop_place, "", false, 'order-page2') . "</div>
    </div>
    <button type='submit' form='order-page2' id='order-page2-btn' class='button px-3 d-flex justify-content-center align-items-center gap-2 w-75 mx-auto'>Tovább<i class='fa-solid fa-angle-right'></i></button>
</div></div>
";
                    array_unshift($pick_drop_place, (object)['city3' => 'Az átvételi pont adatai']);
                    $data[1] .= "
<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center'><div class='row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='2'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Házhozszállítás</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' style='background-color: var(--col2);' data-droppush-content='2'>
            <h5 class='text-center'>Házhozszállítás adatai</h5>
            <div class='w-75 mx-auto py-4'><div>
            <label for='city'>Város</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-city'></i>
                            <input form='order-page2' id='city' name='city' type='text' value=''>
                        </div>
                    </div>
                </div></div>
                <div><label for='zipcode'>Irányítószám</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-7'></i>
                            <input form='order-page2' id='zipcode' name='zipcode' type='text' value=''>
                        </div>
                    </div>
                </div></div>

                <div><label for='street'>Utca</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-signs-post'></i>
                            <input form='order-page2' id='street' name='street' type='text' value=''>
                        </div>
                    </div>
                </div></div>
                <div><label for='house'>Házszám</label>
                <div>
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center gap-1 input-with-icon m-1 w-100'>
                            <i class='px-2 fa-solid fa-house'></i>
                            <input form='order-page2' id='house' name='house' type='text' value=''>
                        </div>
                    </div>
                </div></div></div>
                <h5 class='text-center'>Leadás helye </h5><div class='w-75 mx-auto'>
                " . dropdownButton('Leadási pont', 'city3', $pick_drop_place, "", false, 'order-page2') . "
</div><button type='submit' form='order-page2' id='order-page2-btn' class='button px-3 d-flex justify-content-center align-items-center gap-2 w-75 mx-auto'>Tovább<i class='fa-solid fa-angle-right'></i></button>
";
                }
                $data[1] .= "</div></div></div>";
            } else { // PAGE3
                $d1 = new DateTime($drop, new DateTimeZone('Europe/Belgrade'));
                $d2 = new DateTime($pick, new DateTimeZone('Europe/Belgrade'));
                $full_rent = $d1->diff($d2)->format('%d nap, %h óra');
                $time = ($d1->diff($d2)->h / 24) + ($d1->diff($d2)->days) + ($d1->diff($d2)->m / 30) + ($d1->diff($d2)->i / 60);
                $rent_price = (double)($result->price * $time);
                if ($d1->diff($d2)->i > 0)
                    $full_rent .= $d1->diff($d2)->format(' és %i perc');
                if ($d1->diff($d2)->days > 30)
                    $full_rent = $d1->diff($d2)->format('%m hónap, %d nap, %h óra és %i perc');
                $drop = $d1->format('Y-m-d H:i');
                $pick = $d2->format('Y-m-d H:i');
                $data[1] .= "<div class='col-lg-6 col-sm-12 mx-auto'><div class='row d-flex flex-column gap-3 px-1'></div></div></div><div class='col row' style='gap: 4rem 0 !important;'>
<div class='col-lg-4 col-sm-12 d-flex flex-column gap-5'>
    <div class='row d-flex flex-column gap-2 px-2'>
        <h5 class='text-center' >Bérlés információi</h5>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Átvétel ideje: $pick</b><span></span></div>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Leadás ideje: $drop</b><span></span></div>
        <hr class='my-2'>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Össz. bérlés ideje:</b><span>$full_rent</span></div>
    </div>
    <div class='row d-flex flex-column gap-2 px-2'>
        <h5 class='text-center' >Átvétel információi</h5>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Átvétel helye:</b><span>$pick_place</span></div>
        <div class='d-flex gap-2 flex-wrap link'><b class='user-select-none'>Leadás helye:</b><span>$drop_place</span></div>
    </div>
</div>
<div class='col-lg-4 col-sm-12 d-flex flex-column gap-2 px-2'>
 <h5 class='text-center'>Kiválasztott extrák</h5>";
                if (!empty($session->get('temp_selected_extras')))
                    foreach ($session->get('temp_selected_extras') as $item) {
                        $query = new SQLQuery("SELECT name FROM order_extras WHERE orderextrasID = :id LIMIT 1", [':id' => $item]);
                        $item = $query->getResult()[0];
                        $data[1] .= "<div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-around flex-wrap gap-2'><b>$item->name</b></span></div>";
                    }
                else
                    $data[1] .= "<div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-around flex-wrap gap-2'><b>Nincs extra.</b></span></div>";
                $rent_price_formated = number_format($rent_price, 2, '.', '');
                $data[1] .= "</div>
<div class='col-lg-4 col-sm-12 d-flex flex-column gap-2 px-2'>
 <h5 class='text-center'>Fizetendő összeg</h5>
 <div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>$full_rent</b><span>$rent_price_formated €</span></span></div>
";

                $total_rent_price = $rent_price;
                if (!empty($session->get('temp_selected_extras')))
                    foreach ($session->get('temp_selected_extras') as $item) {
                        $query = new SQLQuery("SELECT name, price FROM order_extras WHERE orderextrasID = :id LIMIT 1", [':id' => $item]);
                        $item = $query->getResult()[0];
                        $data[1] .= "<div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>1x $item->name</b><span>$item->price €</span></span></div>";
                        $total_rent_price += (double)$item->price;
                    }
                if ($pick_deliver_needed) $total_rent_price += $DELIVERY_PRICE;
                if ($drop_deliver_needed) $total_rent_price += $DELIVERY_PRICE;
                if ($pick_deliver_needed || $drop_deliver_needed) {
                    if ($pick_deliver_needed && $drop_deliver_needed)
                        $data[1] .= "<div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>2x Szállítási költség</b><span>$DELIVERY_PRICE €</span></span></div>";
                    else
                        $data[1] .= "<div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>1x Szállítási költség</b><span>$DELIVERY_PRICE €</span></span></div>";
                }
                $total_rent_price = number_format($total_rent_price, 2, '.', '');

                $data[1] .= "<hr class='m-5'>
    <div class='link w-100 px-2'><span class='user-select-none d-flex justify-content-between flex-wrap gap-2'><b>Összesítve: </b><span>$total_rent_price €</span></span></div>
</div>
<div class='row my-5'><button type='submit' form='order-page3' id='order-page3-btn' name='order-page3' class='button px-3 d-flex justify-content-center align-items-center gap-2 w-75 mx-auto'>Rendelés véglegesítése<i class='fa-solid fa-angle-right'></i></button></div>
</div>

<input form='order-page3' name='drop_place' type='hidden' value='$drop_place'>
<input form='order-page3' name='pick_place' type='hidden' value='$pick_place'>
";
                $session->set('temp_rent_price', $total_rent_price);
            }
        } else { //PAGE4
            if ($succ == 1)
                $data[1] .= "<div class='row d-flex gap-4 justify-content-center'><h2 class='w-100 text-center'>Gratulálunk, sikeres rendelés!</h2><div class='col-lg-6 col-sm-12 p-2 d-flex flex-column gap-5 align-items-center '><div class='carousel w-100 justify-content-center'><div class='slider-img' style='border-radius: .5rem'><img src='../images/cars/$result->manufacturer/$result->carsID $result->releasedate $result->manufacturer $result->carname.png' class='d-block w-75 mx-auto' alt='$result->manufacturer/$result->releasedate $result->manufacturer $result->carname.png'></div></div></div><p class='text-center'>Sikeresen megrendelte a <b>$car_full_name</b> járművet!<br>A rendelés adataival elküldtünk egy emailt. <br> Mikor egy alkalmazottunk jóváhagyja a rendelést, egy újabb emailt fog kapni!</p>";
            else
                $data[1] .= "<div class='row d-flex gap-4 justify-content-center'><h2 class='w-100 text-center'>Sajnáljuk, nem sikerült a rendelés!</h2><p class='w-auto mx-auto text-left'>Lehetséges opciók: <br>- A járművet a rendelés folyamán valaki más megrendelte!<br>- A rendelést nem sikerült rögzíteni a szerverünkre. <br>- A bevitt adatok nem voltak megfelelőek!</p><br><b class='text-center'>Ha ön szerint más probléma akadt, lépjen velünk kapcsolatba!</b><br><span class='text-center'>support@hash.com</span>";


        }
    }

    if (isset($data))
        echo json_encode($data);
    else
        echo "error";
} else
    redirection('index.php');
//sleep(5);