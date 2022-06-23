<?php
require_once "config.php";
$session = new Session();

if (isset($_POST) && isset($_POST['operation'])) {
    if (!empty($_POST['carID']) && !empty($_POST['orderID']) && !empty($_POST['userID']) && !empty($_POST['employeeID'])) {
        $returnValue = "";
        $operation = $_POST['operation'];
        $carID = trim($_POST['carID']);
        $orderID = trim($_POST['orderID']);
        $userID = trim($_POST['userID']);
        $employeeID = trim($_POST['employeeID']);
        if ($operation == 4 || $operation == 5) { //APPROVE COMMENT (Komment elfogadás->lezárás)
            $query_order = new SQLQuery("UPDATE orders SET status = 5, code = '' WHERE ordersID = :orderID AND carID = :carID AND userID = :userID AND status >= 4", [':orderID' => $orderID, ':carID' => $carID, ':userID' => $userID]);
            $query_rating = new SQLQuery("UPDATE ratings SET approved = :approved WHERE orderID = :orderID AND carID = :carID AND userID = :userID", [':approved'=>$_POST['comment_approved'], ':orderID' => $orderID, ':carID' => $carID, ':userID' => $userID]);
            if ($query_rating->getDbq()->rowCount() > 0)
                $returnValue = "success4";
            else
                $returnValue = "error4";

        }
        switch ($operation) {
            case -2:
                { //DENIED RENT -> status -1
                    $query = new SQLQuery("UPDATE orders SET status = -1 WHERE ordersID = :orderID AND carID = :carID AND userID = :userID AND status > -1", [':orderID' => $orderID, ':carID' => $carID, ':userID' => $userID]);
                    if ($query->getDbq()->rowCount() > 0) {
                        $userData_query = new SQLQuery("SELECT email, lastname as lname, firstname as fname FROM users WHERE usersID = :userID LIMIT 1", [':userID' => $userID]);
                        $userData = $userData_query->getResult()[0];
                        $car_query = new SQLQuery("SELECT CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate )AS carname FROM orders INNER JOIN cars c on orders.carID = c.carsID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID WHERE ordersID = :orderID", [':orderID'=>$orderID]);
                        $car = $car_query->getResult()[0];
                        if (!empty($userData)) {
                            if (UserSystem::sendEmail("order_denied", $userData->email, $userData->fname, $userData->lname, null, null, $car->carname, $orderID))
                                $returnValue = "success-2";
                            else
                                $returnValue = "error-2-1";
                        } else
                            $returnValue = "error-2-2";
                    } else
                        $returnValue = "error-2";
                }
                break;
            case 0:
                { //UPDATE THE DATA FOR THE ORDER
                    if (!empty($_POST['pick_date']) && !empty($_POST['drop_date']) && !empty($_POST['selectedCarID'])) {
                        $query = new SQLQuery("SELECT carID, rentStartdate, rentEnddate, rentStartplaceID as place_pick, rentEndplaceID as place_drop, rentHomeplace, extras FROM orders WHERE ordersID = :orderID AND carID = :carID AND userID = :userID LIMIT 1", [':orderID' => $orderID, ':carID' => $carID, ':userID' => $userID]);
                        $result = $query->getResult()[0];
                        if ($result != null) {
                            $pick_date = date('Y-m-d H:i', strtotime($_POST['pick_date']));
                            $drop_date = date('Y-m-d H:i', strtotime($_POST['drop_date']));
                            $selectedCarID = $_POST['selectedCarID'];
                            $pick_place = $result->place_pick;
                            $drop_place = $result->place_drop;
                            if (isset($result->rentHomeplace)) {
                                $pick_place = $result->rentHomeplace;
                                if (!isset($result->place_drop))
                                    $drop_place = $result->rentHomeplace;
                            }
                            $query_string1 = "";
                            $query_string2 = "";
                            $query_array = [];
                            $_extras = !empty($_POST['extras']) ? $_extras = json_encode([$_POST['extras']]) : '[]';
                            $array_data = ['carID' => (int)$selectedCarID, 'rentStartdate' => $pick_date, 'rentStartplaceID' => $pick_place, 'rentEndplaceID' => (int)$drop_place, 'rentHomeplace' => $pick_place, 'extras' => $_extras];
                           /* foreach ($array_data as $key => $value) {
                                if ($value != $result->$key) {
                                    $query_string1 .= $key . ", ";
                                    $query_string2 .= ":" . $key;
                                    $query_array[$key] = $value;
                                }
                            }*/
                            {
                                $result = json_decode(json_encode($result), true);
                                foreach ($array_data as $key => $value) {
                                    if (isset($result[$key])) {
                                        if ($value != (array)$result[$key]) {
                                            $query_string1 .= $key . " = :$key, ";
                                            $query_array[$key] = $value;
                                        }
                                    }
                                }
                                $query_string1 = preg_replace('/, $/', '', $query_string1);
                                $query_string2 = preg_replace('/, $/', '', $query_string2);
                            }
                            if (strlen($query_string1) > 0) {
                                $query = new SQLQuery("UPDATE orders SET $query_string1 WHERE ordersID = $orderID AND carID = $carID AND userID = $userID", $query_array);
                                ob_start();
                                var_dump($query);
                                error_log(ob_get_clean());
                                if ($query->getDbq()->rowCount() > 0) {
                                    $returnValue = "success0";
                                } else
                                    $returnValue = "error0-1";
                            } else
                                $returnValue = "error0-2";
                        } else
                            $returnValue = "error0-3";
                    } else
                        $returnValue = "error0";
                }
                break;
            case 1:
                { //USER PICKED UP THE CAR
                    $query = new SQLQuery("UPDATE orders SET status = 2 WHERE ordersID = :orderID AND carID = :carID AND userID = :userID AND status = 1", [':orderID' => $orderID, ':carID' => $carID, ':userID' => $userID]);
                    if ($query->getDbq()->rowCount() > 0) {
                        $returnValue = "success1";
                    } else
                        $returnValue = "error1";
                }
                break;
            case 2:
                { //REPORT
                    if (isset($_POST['comment']) && isset($_POST['damages']) && !empty($_POST['traveled_distance'])) {

                        $query = new SQLQuery("UPDATE orders SET status = 3 WHERE ordersID = :orderID AND carID = :carID AND userID = :userID AND status = 2", [':orderID' => $orderID, ':carID' => $carID, ':userID' => $userID]);
                        $traveledDistance = 0;
                        $car_query = new SQLQuery("SELECT distance, servisdistance FROM cars WHERE carsID = :carID LIMIT 1", [':carID' => $carID]);
                        $serviceNeeded = null;
                        if ($car_query->getResult()[0] != null) {
                            $traveledDistance = (int)$_POST['traveled_distance'] - (int)$car_query->getResult()[0]->distance;
                            if ($car_query->getResult()[0]->servisdistance <= 500){
                                $serviceNeeded = ", status = 1 ";
                            }
                        }

                        if ($query->getDbq()->rowCount() > 0) {
                            $query_insert = new SQLQuery('INSERT INTO reports (carID, userID, orderID, employeeID, traveledDistance, damage, comment) VALUES (:carID, :userID, :orderID, :employeeID, :traveledDistance, :damage, :comment)', [':carID' => $carID, ':userID' => $userID, ':orderID' => $orderID, ':employeeID' => $employeeID, ':traveledDistance' => $traveledDistance, ':damage' => $_POST['damages'], ':comment' => $_POST['comment']]);
                            if ($query_insert->lastInsertId > 0) {
                                $car_query = new SQLQuery("UPDATE cars SET distance = distance + :distance, servisdistance = servisdistance - :distance, status = (CASE WHEN servisdistance - :distance <= 500 THEN 1 ELSE status END) WHERE carsID = :carID", [':distance' => $traveledDistance, ':carID' => $carID]);
                                $userData_query = new SQLQuery("SELECT email, lastname as lname, firstname as fname FROM users WHERE usersID = :userID LIMIT 1", [':userID' => $userID]);
                                $userData = $userData_query->getResult()[0];
                                $order_query = new SQLQuery("SELECT CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate )AS carname, code FROM orders INNER JOIN cars c on orders.carID = c.carsID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID WHERE ordersID = :orderID", [':orderID'=>$orderID]);
                                $order_Code = $order_query->getResult()[0];
                                if (!empty($userData))
                                    if (UserSystem::sendEmail("order_archived", $userData->email, $userData->fname, $userData->lname, null, null, $order_Code->carname, $orderID, $order_Code->code))
                                        $returnValue = "success2";
                                    else
                                        $returnValue = "error2-1";
                                else
                                    $returnValue = "error2-2";
                            } else
                                $returnValue = "error2-3";
                        } else
                            $returnValue = "error2-4";
                    } else
                        $returnValue = "error2";
                }
                break;
            case 10:
                { //APPROVE(ELFOGADÁS)
                    $generated_Code = generateNumbersToken();
                    $query = new SQLQuery("UPDATE orders SET status = 1, code = :code WHERE ordersID = :orderID AND carID = :carID AND userID = :userID AND status = 0", [':code'=>$generated_Code,':orderID' => $orderID, ':carID' => $carID, ':userID' => $userID]);
                    if ($query->getDbq()->rowCount() > 0) {
                        $userData_query = new SQLQuery("SELECT email, lastname as lname, firstname as fname FROM users WHERE usersID = :userID LIMIT 1", [':userID' => $userID]);
                        $userData = $userData_query->getResult()[0];
                        $car_query = new SQLQuery("SELECT CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate )AS carname FROM orders INNER JOIN cars c on orders.carID = c.carsID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID WHERE ordersID = :orderID", [':orderID'=>$orderID]);
                        $car = $car_query->getResult()[0];
                        if (!empty($userData)) {
                            if (UserSystem::sendEmail("order_approved", $userData->email, $userData->fname, $userData->lname, null, null, $car->carname, $carID, $generated_Code))
                                $returnValue = "success5";
                            else
                                $returnValue = "error5-1";
                        } else
                            $returnValue = "error5-2";
                    } else
                        $returnValue = "error5";
                }
                break;
        }
        exit($returnValue);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/icons/logo-100.png">
    <link rel="stylesheet" href="../styles/admin_index.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/cards.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>

    <!--Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <!--Chart-->
    <!--JSON-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!--JSON-->

    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>
<?php
require_once "navigation.php";
$query = new SQLQuery("SELECT COUNT(*) as orders FROM orders WHERE MONTH(orderdate) = MONTH(CURRENT_DATE)", []);
$total_orders = $query->getResult()[0];
$query = new SQLQuery("SELECT COUNT(*) as cars FROM cars ORDER BY carsID", []);
$total_cars = $query->getResult()[0];
$query = new SQLQuery("SELECT SUM(price) as total FROM orders WHERE YEAR(orderdate) = YEAR(current_date);", []);
$total_income = $query->getResult()[0];
$query = new SQLQuery("SELECT COUNT(*) as employees FROM users WHERE level = 2 ORDER BY usersID;", []);
$total_employee = $query->getResult()[0];
        echo "<div class='container d-flex flex-column gap-5' style='margin-top: 3rem'>
    <div class='flex-wrap'>
        <div class='cards'>
            <p>Új rendelések</p>
            <h4>$total_orders->orders</h4>
            <p style='color: #999898;'>Elmult 30 nap</p>
        </div>

        <div class='cards'>
            <p>Alkalmazottak</p>
            <h4>$total_employee->employees</h4>
            <p style='color: #999898;'>Jelenleg</p>
        </div>

        <div class='cards'>
            <p>Autók</p>
            <h4>$total_cars->cars</h4>
            <p style='color: #999898;'>Jelenleg</p>
        </div>

        <div class='cards'>
            <p>Bevétel</p>
            <h4>$total_income->total €</h4>
            <p style='color: #999898;'>Utolsó 1 év</p>
        </div>
    </div>

    <div class='graphBox'>
        <div class='box'>
            <canvas id='barChart'></canvas>
        </div>
        <div class='box'>
            <canvas id='myChart'></canvas>
        </div>
    </div>

    <div class='orders' id='orders'>
    <table id='history' class='display' style='width:100%'>
                <h2 style='overflow: hidden'>Rendelések</h2><hr>
                <thead><tr>
                    <th class='text-center'>ID</th>
                    <th class='text-center'>Jármű</th>
                    <th class='text-center'>Felh.</th>
                    <th class='text-center'>Átvétel ideje</th>
                    <th class='text-center'>Átvétel helye</th>
                    <th class='text-center'>Átadás ideje</th>
                    <th class='text-center'>Átadás helye</th>
                    <th class='text-center'>Extrák</th>
                    <th class='text-center'>Összeg</th>
                    <th class='text-center'>Megrendelve</th>
                    <th class='text-center'>Állapot</th>
                    <th class='text-center'>Művelet</th>
                </tr></thead><tbody id='history-body'>";

        $query = new SQLQuery("SELECT CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate )AS carname, CONCAT('#',u.usersID, ' ', u.lastname, ' ', u.firstname)AS usersname, o.carID, o.ordersID, o.userID, o.rentStartdate, o.rentEnddate, o.code, CONCAT(p.address,', ', p.city) as place_pick, CONCAT(pp.address,', ', pp.city) as place_drop, r.rating as rating, r.approved as rating_approved, o.rentHomeplace, o.orderdate, o.extras, o.price, o.status FROM orders o INNER JOIN cars c on o.carID = c.carsID INNER JOIN users u on u.usersID = o.userID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID LEFT JOIN places p on o.rentStartplaceID = p.placesID LEFT JOIN places pp on o.rentEndplaceID = pp.placesID LEFT JOIN ratings r on o.carID = r.carID AND o.userID = r.userID AND o.ordersID = r.orderID GROUP BY o.ordersID ORDER BY o.ordersID DESC;", []);
        foreach ($query->getResult() as $value) {
            $pick_place = $value->place_pick;
            $drop_place = $value->place_drop;
            if (isset($value->rentHomeplace)) {
                $pick_place = $value->rentHomeplace;
                if (!isset($value->place_drop))
                    $drop_place = $value->rentHomeplace;
            }
            $date1 = new DateTime($value->rentStartdate);
            $date2 = new DateTime();
            $date_diff = (array)date_diff($date1, $date2);
            if ($value->status != null) {
                if ($value->status == 0 || $value->status == 1 || $value->status == 2 || $value->status >= 3) {
                    $cars_query = new SQLQuery("SELECT CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate )AS carname, c.carsID FROM cars c INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID", []);
                    $cars = $cars_query->getResult();
                    $extras_query = new SQLQuery("SELECT COUNT(*) as count, name, orderextrasID FROM order_extras GROUP BY orderextrasID", []);
                    $extras = $extras_query->getResult();
                    $comment_query = new SQLQuery("SELECT * FROM ratings WHERE orderID = :orderID AND carID = :carID AND userID = :userID LIMIT 1", [':orderID' => $value->ordersID, ':carID' => $value->carID, ':userID' => $value->userID]);
                    $comment = $comment_query->getResult();
                    $operation = "<button class='button p-2 d-flex justify-content-center align-items-center' data-bs-toggle='modal' data-bs-target='#operation_$value->ordersID-modal'><i class='fa-solid fa-wrench'></i></button>";
                    $operation_modal = "<form method='post' id='operation_$value->ordersID-form' data-operation='1' class='d-none'><input type='hidden' name='carID' value='$value->carID'><input type='hidden' name='orderID' value='$value->ordersID'><input type='hidden' name='userID' value='$value->userID'><input type='hidden' name='employeeID' value='" . $session->get('userID') . "'></form>";

                    if ($value->status == 0) {
                        $operation_modal .= "<div class='d-flex flex-column align-items-center m-4 gap-3 justify-content-center'><div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center w-100'><div class='w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='$value->ordersID'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Adatok szerkesztése</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' style='background-color: var(--col2)' data-droppush-content='$value->ordersID'><div class='w-100 p-1'><label for='carname' class='user-select-none'>Jármű</label><select id='carname' name='selectedCarID' form='operation_$value->ordersID-form' class='select w-100'>";
                        foreach ($cars as $car) {
                            $selected = "";
                            if ($car->carname == $value->carname) {
                                $selected = "selected";
                            }
                            $operation_modal .= "<option $selected value='$car->carsID'>$car->carname</option>";
                        }
                        $operation_modal .= "</select></div><div class='px-1 py-1'><label for='pick_date' class='user-select-none'>Átvétel ideje</label><div class='login-input input-with-icon d-flex align-items-center'><i class='px-2 fa-solid fa-calendar'></i><input type='datetime-local' id='pick_date' name='pick_date' form='operation_$value->ordersID-form' autocomplete='false' value='$value->rentStartdate'></div></div><div class='px-1 py-1'><label for='drop_date' class='user-select-none'>Leadás ideje</label><div class='login-input input-with-icon d-flex align-items-center'><i class='px-2 fa-solid fa-calendar'></i><input type='datetime-local' id='drop_date' name='drop_date' form='operation_$value->ordersID-form' autocomplete='false' value='$value->rentEnddate'</div></div><div class='px-1 py-1'><label for='pick_place' class='user-select-none'>Átvétel helye</label><div class='login-input input-with-icon d-flex align-items-center'><i class='px-2 fa-solid fa-map'></i><input type='text' id='pick_place' name='pick_place' form='operation_$value->ordersID-form' autocomplete='false' placeholder='Átvétel helye(ID vagy Házcím)' value='$pick_place'></div></div><div class='px-1 py-1'><label for='drop_place' class='user-select-none'>Leadás helye</label><div class='login-input input-with-icon d-flex align-items-center'><i class='px-2 fa-solid fa-map'></i><input type='text' id='drop_place' name='drop_place' form='operation_$value->ordersID-form' autocomplete='false' placeholder='Leadás helye(ID vagy Üres-> ház)' value='$drop_place'></div></div><div class='w-100 px-1 py-1' style='overflow-y: hidden !important;'><label for='extras' class='user-select-none'>Extrák</label><select multiple id='extras' size='16' name='extras' form='operation_$value->ordersID-form' class='select w-100' style='scrollbar-width: none;'>";
                        foreach ($extras as $extra) {
                            $selected = "";
                            if (in_array($extra->orderextrasID, json_decode($value->extras))) {
                                $selected = "selected";
                            }
                            $operation_modal .= "<option $selected value='$extra->orderextrasID' class='p-2 my-2'>$extra->name</option>";
                        }
                        $operation_modal .= "</select></div><input type='hidden' name='operation' form='operation_$value->ordersID-form' value='" . $value->status . "' class='d-none'><button type='submit' form='operation_$value->ordersID-form' class='button w-100 p-2 my-4'>Adatok frissítése</button></div>
                      </div>
                      <div class='p-2'>
                        <form method='post' data-deco='1' id='decline_$value->ordersID-form' class='d-none'><input type='hidden' name='carID' value='$value->carID'><input type='hidden' name='orderID' value='$value->ordersID'><input type='hidden' name='userID' value='$value->userID'><input type='hidden' name='employeeID' value='" . $session->get('userID') . "'><input type='hidden' name='operation' value='-2'></form>
                        <form method='post' data-appo='1' id='approve_$value->ordersID-form' class='d-none'><input type='hidden' name='carID' value='$value->carID'><input type='hidden' name='orderID' value='$value->ordersID'><input type='hidden' name='userID' value='$value->userID'><input type='hidden' name='employeeID' value='" . $session->get('userID') . "'><input type='hidden' name='operation' value='10'></form>
                        <button type='submit' form='approve_$value->ordersID-form' class='button w-100 p-2'>Rendelés elfogadása</button>
                        <button type='submit' form='decline_$value->ordersID-form' class='button-2 w-100 p-2'>Rendelés elutasítása</button>
                      </div>
                      </div>
                      </div>";
                    } else if ($value->status == 1)
                        $operation_modal .= "<div class='p-2 my-4 w-75 mx-auto'><input type='hidden' name='operation' form='operation_$value->ordersID-form' value='" . $value->status . "' class='d-none'><div class='p-2 w-100 fs-4 text-center'>Átvételi kód: <b>$value->code</b></div><button type='submit' form='operation_$value->ordersID-form'  class='button w-100 p-2'>Járművet átvette a megrendelő</button></div>";

                    else if ($value->status == 2) {
                        $car_query = new SQLQuery("SELECT distance, servisdistance FROM cars WHERE carsID = :carID LIMIT 1", [':carID' => $value->carID]);
                        $car = $car_query->getResult()[0];
                        $operation_modal .= "<div class='p-2 w-100 fs-4 text-center'>Átvételi kód: <b>$value->code</b></div><div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center w-100'><div class='w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='$value->ordersID'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i><h5 class='w-100 my-auto link car-specs-wrap'>Jelentés leadása</h5></div><div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' style='background-color: var(--col2)' data-droppush-content='$value->ordersID-3'><div class='p-2 w-100 fs-5 text-center'>Kilóméteróra előző állása: <b>$car->distance</b> km</div><div class='p-2 w-100 fs-5 text-center'>Szervíz mérő állása: <b>".(int)($car->servisdistance-500)."</b> km múlva<br>(Ebből még vonja ki a jelenlegit!)</div><div class='px-1 py-1'><label for='traveled_distance' class='user-select-none'>Kilóméteróra állása</label><div class='login-input input-with-icon d-flex align-items-center'><i class='px-2 fa-solid fa-gauge-high'></i><input type='text' id='traveled_distance' name='traveled_distance' form='operation_$value->ordersID-form' autocomplete='false' placeholder='Kilóméteróra állása'></div></div><div class='px-1 py-1'><label for='damages' class='user-select-none'>Talált hibák, törések</label><div class='login-input input-with-icon d-flex align-items-center'><i class='px-2 fa-solid fa-triangle-exclamation'></i><textarea id='damages' name='damages' form='operation_$value->ordersID-form' autocomplete='false' placeholder='Üres->nincs hiba' class='w-100'></textarea></div></div><div class='px-1 py-1'><label for='comment' class='user-select-none'>Megjegyzések</label><div class='login-input input-with-icon d-flex align-items-center'><i class='px-2 fa-solid fa-message'></i><textarea id='comment' name='comment' form='operation_$value->ordersID-form' autocomplete='false' placeholder='Üres->Nincs megjegyzés'  class='w-100'></textarea></div></div><input type='hidden' name='operation' form='operation_$value->ordersID-form' value='" . $value->status . "' class='d-none'><button type='submit' form='operation_$value->ordersID-form'  class='button w-100 p-2'>Jelentés leadása</button></div></div>";
                    }
                    else if ($value->status >= 3) {
                        if ($comment != null) {
                            $comment = $comment[0];
$operation_modal .= "<div class='dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center w-100'>
	<div class='w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative' data-droppush-btn='$value->ordersID'><i class='dropdown-push-arrow position-absolute fa-solid fa-angle-down'></i>
		<h5 class='w-100 my-auto link car-specs-wrap'>Komment megtekintése</h5>
	</div>
	<div class='dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none' style='background-color: var(--col2)' data-droppush-content='$value->ordersID-3'>";
if ($value->rating_approved == 0)
    $operation_modal .= "<div class='text-danger fs-4'>Feldolgozatlan!</div>";
else
    if ($value->rating_approved > 0)
        $operation_modal .= "<div class='text-success fs-4'>Elfogadva!</div>";
    else
        $operation_modal .= "<div class='text-danger fs-4'>Elutasítva!</div>";
$operation_modal .="<div class='d-flex flex-column'><b>Jármű</b><span>$value->carname</span></div>
		<div class='d-flex flex-column'><b>Felhasználó</b><span>$value->usersname</span></div>
		<div class='d-flex flex-column'><b>Komment címe</b><span style='line-break: anywhere'>$comment->commentTitle</span></div>
		<div class='d-flex flex-column'><b>Komment szövege</b><span style='line-break: anywhere'>$comment->comment</span></div>
		<div class='d-flex flex-column'><b>Értékelés</b><span>" . generateStars($comment->rating) . "</span></div><br>
	</div>
	<div class='p-1 d-flex justify-content-between w-100 gap-2'>
		<div class='d-flex flex-column align-items-center justify-contetn-center px-1'><label class='form-check-label button-2 p-2 d-flex align-items-center' for='radio_1_$value->ordersID'>Komment elutasítása</label><input class='ratings' type='radio' name='comment_approved' id='radio_1_$value->ordersID' form='operation_$value->ordersID-form' value='-1'></div>
		<div class='d-flex flex-column align-items-center justify-contetn-center px-1'><label class='form-check-label button p-2 d-flex align-items-center' for='radio_2_$value->ordersID'>Komment elfogadása</label><input class='ratings' type='radio' name='comment_approved' id='radio_2_$value->ordersID' form='operation_$value->ordersID-form' value='1' checked></div>
	</div>
</div>
<div class='m-3 px-2'><input type='hidden' name='operation' form='operation_$value->ordersID-form' value='" . $value->status . "' class='d-none'><button type='submit' form='operation_$value->ordersID-form' class='button w-100 p-2'>Rendelés lezárása</button></div>";                        } else
                            $operation_modal .= "<h5 class='p-1 w-100 text-center'>Még nincs komment!</h5>";
                    }
                    $modal = new Modal("operation_$value->ordersID", "$value->usersname #$value->ordersID megrendelése", $operation_modal, [['name' => 'dismiss', 'type' => 'button', 'icon' => 'fa-circle-xmark', 'text' => 'Bezárás']]);
                    echo $modal->getModal() . "</div>";
                } else
                    $operation = "<div style='line-height: 4; !important;'>-</div>";
            } else
                $operation = "<div style='line-height: 4; !important;'>-</div>";

///////////////////////////////////////////////////////////////////////////////////////////////////////
            $extras_array = json_decode($value->extras);
            if (isset($extras_array) && !empty($extras_array)) {
                $extras = "<div class='d-flex flex-column gap-1 align-items-center'>";
                foreach ($extras_array as $item) {
                    $q = new SQLQuery("SELECT name, price FROM order_extras WHERE orderextrasID = :id", [':id' => $item]);
                    $res = $q->getResult()[0];
                    $extras .= "<div class='w-100 d-flex gap-2 justify-content-center align-items-center'><span class='col-5'><b>Extra: </b>$res->name</span><span class='col-5'><b>Ára: </b>$res->price</span></div>";
                }
                $extras .= "</div>";
                $modal = new Modal("extras_$value->ordersID", "#$value->ordersID rendelés értékelése", $extras, [['name' => 'dismiss', 'type' => 'button', 'icon' => 'fa-circle-xmark', 'text' => 'Kilépés']]);
                echo $modal->getModal();
                $extras = "<button class='button p-2 d-flex justify-content-center align-items-center' data-bs-toggle='modal' data-bs-target='#extras_$value->ordersID-modal'><i class='fa-solid fa-expand'></i></button>";
            } else {
                $extras = "<div style='line-height: 4; !important;'>-</div>";
            }

            $status = "<span class='text-muted'>Feldolgozatlan</span>";

            if ($value->status == 1)
                $status = "<span class='text-success'>Elfogadva</span>";
            else if ($value->status == -1)
                $status = "<span class='text-danger'>Elutasítva</span>";
            else if ($value->status == -2)
                $status = "<span class='text-warn'>Lemondva</span>";
            else if ($value->status == 2)
                $status = "<span class='text-primary'>Aktív</span>";
            else if ($value->status == 3)
                $status = "<span class='text-info'>Véget ért</span>";
            else if ($value->status >= 4)
                if ($value->rating_approved == 0)
                    $status = "<span class='text-warning'>Lezárás<br>szükséges</span>";
                else {
                    $rating_approved = $value->rating_approved > 0 ? "<span class='text-success'>Komm. elfogadva</span>" : "<span class='text-danger'>Komm. elutasítva</span>";
                    $status = "<span class='text-muted'>Lezárva<br>$rating_approved</span>";
                }



            echo "<tr>
                    <td class='text-center'>$value->ordersID</td>
                    <td class='text-center'>$value->carname</td>
                    <td class='text-center'>$value->usersname</td>
                    <td class='text-center'>$value->rentStartdate</td>
                    <td class='text-center'>$pick_place</td>
                    <td class='text-center'>$value->rentEnddate</td>
                    <td class='text-center'>$drop_place</td>
                    <td class='d-flex align-items-center justify-content-center'>$extras</td>
                    <td class='text-center'>$value->price</td>
                    <td class='text-center'>$value->orderdate</td>
                    <td class='text-center'>$status</td>
                    <td class='d-flex align-items-center justify-content-center'>$operation</td>
                </tr>";
        }

        echo "</tbody></table></div>
<div class='orders'>
            <table id='cars' class='display' style='width:100%'>
                <h2 style='overflow: hidden'>Járművek</h2><hr>
                <thead><tr>
                    <th class='text-center'>ID</th>
                    <th class='text-center'>Gyártó</th>
                    <th class='text-center'>Jármű</th>
                    <th class='text-center'>Motor</th>
                    <th class='text-center'>Váltó</th>
                    <th class='text-center'>Lóerő</th>
                    <th class='text-center'>Üzemanyag</th>
                    <th class='text-center'>Ajtók</th>
                    <th class='text-center'>Ülések</th>
                    <th class='text-center'>Karosszéria</th>
                    <th class='text-center'>Kiadás</th>
                    <th class='text-center'>Napi ár</th>
                    <th class='text-center'>Akciós ár</th>
                    <th class='text-center'>Értékelés</th>
                    <th class='text-center'>Öszz. megrendelés</th>
                    <th class='text-center'>Kilóméteróra állása [km]</th>
                    <th class='text-center'>Következő szervíz [km]</th>
                    <th class='text-center'>Állapot</th>
                    <th class='text-center'>Megtekint</th>
                </tr></thead><tbody id='history-body'>";
            $query = new SQLQuery("SELECT cars.carsID, cars.carname, cars.engine, REPLACE(cars.gearbox, ' sebesség', '') as gearbox, cars.fuel, cars.horsepower, cars.seats, cars.doors, cars.bodywork, cars.releasedate, cars.distance, cars.servisdistance, cars.status, m.name as manufacturer, p.price, ROUND(p.price - (p.price * p.discount / 100),2) as discount, ROUND(AVG(r.rating),2) as total_rating, COUNT(o.ordersID) as total_order FROM cars INNER JOIN manufactures m on cars.manufacturerID = m.manufacturesID LEFT JOIN prices p on cars.carsID = p.carID LEFT JOIN ratings r on cars.carsID = r.carID LEFT JOIN orders o on cars.carsID = o.carID GROUP BY cars.carsID;",[]);
            $result = $query->getResult();
            if ($result != null){
                foreach ($result as $item){
                    $link = "onclick = \"window.location.href='car.php?car=$item->carsID'\"";
                    $stars = !empty($item->total_rating) ? generateStars($item->total_rating) : "<span class='text-center'>Még nincs<br>értékelés!</span>";
                    $operation = "<button class='button px-2' $link>Megtekint</button>";
                    $status = $item->status == 0 ? "<span class='text-success'>Aktív</span>" : "<span class='text-danger'>Szervíz allatt</span>";
                    echo "<tr>
                    <td class='text-center'>$item->carsID</td>
                    <td class='text-center'>$item->manufacturer</td>
                    <td class='text-center'>$item->carname</td>
                    <td class='text-center'>$item->engine</td>
                    <td class='text-center'>$item->gearbox</td>
                    <td class='text-center'>$item->horsepower</td>
                    <td class='text-center'>$item->fuel</td>
                    <td class='text-center'>$item->doors</td>
                    <td class='text-center'>$item->seats</td>
                    <td class='text-center'>$item->bodywork</td>
                    <td class='text-center'>$item->releasedate</td>
                    <td class='text-center'>$item->price</td>
                    <td class='text-center'>$item->discount</td>
                    <td class='text-center'>$stars</td>
                    <td class='text-center'>$item->total_order</td>
                    <td class='text-center'>$item->distance</td>
                    <td class='text-center'>$item->servisdistance</td>
                    <td class='text-center'>$status</td>
                    <td class='d-flex align-items-center justify-content-center'>$operation</td>
                </tr>";
                }
            }
$array_fuels_count = [0,0,0,0];
$array_orders_count = [];
$query = new SQLQuery("SELECT MONTH(orderdate) as month, COUNT(MONTH(orderdate)) as count FROM orders GROUP BY MONTH(orderdate) ORDER BY orderdate", []);
$result = $query->getResult();
$i = 0;
$months = ['Jan', 'Feb', 'Márc', 'Ápr', 'Máj', 'Jun', 'Jul', 'Agu', 'Szep', 'Okt', 'Nov', 'Dec'];
foreach ($result as $value)
    $array_orders_count[$i++] = [$months[$value->month], $value->count];
$query = new SQLQuery("SELECT c.fuel, COUNT(c.fuel) as count FROM orders INNER JOIN cars c on orders.carID = c.carsID GROUP BY c.fuel;", []);
$result = $query->getResult();
$i = 0;
foreach ($result as $value)
    $array_fuels_count[$i++] = $value->count;

echo "        </tbody>
        </table></div>
        <div class='orders mb-5'>
        <table id='reports' class='display' style='width:100%'>
                <h2 style='overflow: hidden'>Jelentések</h2><hr>
                <thead><tr>
                    <th class='text-center'>ID</th>
                    <th class='text-center'>Jármű</th>
                    <th class='text-center'>Felhasználó</th>
                    <th class='text-center'>Alkalmazott</th>
                    <th class='text-center'>Hibák/törések</th>
                    <th class='text-center'>Hozzászólás</th>
                    <th class='text-center'>Megtett út</th>
                    <th class='text-center'>Jelentés/jármű leadva</th>
        </tr></thead><tbody>";
$query = new SQLQuery("SELECT reportsID, created, traveledDistance, damage, comment, e.username as employee, u.username as user, CONCAT(m.name, ' ',c.carname, ' ', c.engine, ' ', c.releasedate) as carname  FROM reports r LEFT JOIN cars c on r.carID = c.carsID LEFT JOIN users u on r.userID = u.usersID LEFT JOIN users e on r.employeeID = e.usersID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID",[]);
$result = $query->getResult();
if ($result != null){
    foreach ($result as $item){
        echo "<tr><td class='text-center'>$item->reportsID</td>
              <td class='text-center'>$item->carname</td>
              <td class='text-center'>$item->user</td>
              <td class='text-center'>$item->employee</td>
              <td class='text-center'>$item->damage</td>
              <td class='text-center'>$item->comment</td>
              <td class='text-center'>$item->traveledDistance</td>
              <td class='text-center'>$item->created</td></tr>";
    }}
echo "</tbody>
        </table>
        <div>
</div>
    </div>
</div>
</div>

<script>var array1 = '".json_encode($array_fuels_count)."'; var array2 = '".json_encode($array_orders_count)."'</script>
<script src='../scripts/admin_graph.js'></script>
<script src='../scripts/admin_dataTable.js'></script>
<script src='../scripts/button-events.js'></script>
<script src='../scripts/events.js'></script>
<script src='../scripts/ajax.js'></script>

</body>
</html>";
