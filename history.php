<?php
require_once "config.php";
$session = new Session();
if($session->get('userID') > 0){
if (!empty($_POST) && isset($_POST['order-key'])){
    $returnValue = "error";
    if (isset($_POST['comment-title']) && isset($_POST['comment-body']) && isset($_POST['rating']) && isset($_POST['carID']) && isset($_POST['orderID'])) {
        $orderKey = trim($_POST['order-key']);
        $title = trim($_POST['comment-title']);
        $comment = trim($_POST['comment-body']);
        $rating = (float)trim($_POST['rating']);
        $orderID = (int)trim($_POST['orderID']);
        $carID = (int)trim($_POST['carID']);
        if (!empty($title) && !empty($comment) && !empty($rating) && $carID > 0) {
            $query = new SQLQuery("SELECT * FROM orders WHERE ordersID = :orderID AND carID = :carID AND code = :key LIMIT 1", [':orderID' => $orderID, ':carID' => $carID, ':key' => $orderKey]);
            if ($query->getResult() != null) {
                $result = $query->getResult()[0];
                if ($result->status < 4 && $result->code != "0000-0000-0000" && $result->code != "") {
                    $query = new SQLQuery("INSERT INTO ratings (carID, userID, orderID, rating, commentTitle, comment) VALUES (:carID, :userID, :orderID, :rating, :commentTitle, :comment)", [':userID' => $session->get('userID'), ':orderID' => $orderID, ':carID' => $carID, ':rating' => $rating, ':commentTitle' => $title, ':comment' => $comment]);
                    if ((int)$query->lastInsertId > 0) {
                        $query = new SQLQuery("UPDATE orders SET code = '', status = 4 WHERE ordersID = :orderID AND carID = :carID AND code = :key", [':orderID' => $orderID, ':carID' => $carID, ':key' => $orderKey]);
// TODO STATUS4 IF added comment -> STATUS5 IF APPROVED!
//                        $query = new SQLQuery("UPDATE orders SET code = '', status = 4 WHERE ordersID = :orderID AND carID = :carID AND code = :key", [':orderID' => $orderID, ':carID' => $carID, ':key' => $orderKey]);
                        if ($query->getDbq()->rowCount() > 0)
                            $returnValue = "success";
                        else
                            $returnValue = "error5";
                    } else
                        $returnValue = "error4";
                } else
                    $returnValue = "error3";

            } else
                $returnValue = "error2";
        } else
            $returnValue = "error1";
    }

    exit($returnValue);
}
if (!empty($_POST) && isset($_POST['resign_order'])) {
    $returnValue = "error";
    if (isset($_POST['resign_order']) && $_POST['resign_order'] > 0) {
        $query = new SQLQuery("UPDATE orders SET status = -2 WHERE ordersID = :orderID AND userID = :userID", [':orderID' => $_POST['resign_order'], ':userID' => $session->get('userID')]);
        if ($query->getDbq()->rowCount() > 0)
            $returnValue = "success";
        else
            $returnValue = "error";
    }
    exit($returnValue);
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
    <link rel="icon" type="image/x-icon" href="images/icons/logo-100.png">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/admin_tables.css">
    <link rel="stylesheet" href="styles/cards.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>
<?php
require_once "navigation.php";
echo "<main class='container' style='margin-top: 4.5rem'>
    <table id='history' class='display' style='width:100%'>
        <h2 style='overflow: hidden'>Rendeléseim</h2><hr>
        <thead><tr>
            <th class='text-center'>Azonosító</th>
            <th class='text-center'>Jármű</th>
            <th class='text-center'>Átvétel ideje</th>
            <th class='text-center'>Átvétel helye</th>
            <th class='text-center'>Átadás ideje</th>
            <th class='text-center'>Átadás helye</th>
            <th class='text-center'>Extrák</th>
            <th class='text-center'>Összeg</th>
            <th class='text-center'>Megrendelve</th>
            <th class='text-center'>Állapot</th>
            <th class='text-center'>Művelet</th>
        </tr></thead><tbody>";
$session = new Session();
$query = new SQLQuery("SELECT CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate )AS carname, o.carID, o.ordersID, o.rentStartdate, o.rentEnddate, CONCAT(p.address,', ', p.city) as place_pick, CONCAT(pp.address,', ', pp.city) as place_drop, r.rating as rating, r.approved as rating_approved, r.ratingID as ratingID, o.rentHomeplace, o.orderdate, o.extras, o.price, o.status FROM orders o INNER JOIN cars c on o.carID = c.carsID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID LEFT JOIN places p on o.rentStartplaceID = p.placesID LEFT JOIN places pp on o.rentEndplaceID = pp.placesID LEFT JOIN ratings r on o.carID = r.carID AND o.userID = r.userID AND o.ordersID = r.orderID WHERE o.userID = :userID GROUP BY o.ordersID ORDER BY o.ordersID DESC;", [':userID' => $session->get('userID')]);


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
    $canResign = $date_diff['h'] > 4 || $date_diff['days'] > 0 || $date_diff['m'] > 0;

    if (isset($value->rating) && $value->status == 5 && $value->rating_approved == 1) {
        $link = "onclick = \"window.location.href='car.php?car=$value->carID&comment=$value->ratingID'\"";
        $stars = !empty($value->rating) ? generateStars($value->rating) : "";
        $rating = "<button class='button px-2' $link>Megtekint</button><br><span>" . $stars . "</span>";
    } else if ($value->status == 1 && $canResign) {
        $resign_modal = new Modal('resign_' . $value->ordersID, "Rendelés lemondása", "<p class='p-4'>Biztos szeretné lemondani a <b>$value->carname</b> (#$value->ordersID) rendelését?</p>", [['name' => 'resign_submit', 'type' => 'submit', 'icon' => 'fa-circle-check', 'text' => 'Lemondás', 'form' => "resign_$value->ordersID"], ['name' => 'dismiss', 'type' => 'button', 'icon' => 'fa-circle-xmark', 'text' => 'Bezárás']]);
        echo $resign_modal->getModal();
        $rating = "<form id='resign_$value->ordersID' data-resgn='1' class='px-4 d-none'><input type='hidden' name='resign_order' value='$value->ordersID'></form><button class='button px-2' data-bs-toggle='modal' data-bs-target='#resign_$value->ordersID-modal' value='$value->ordersID'>Lemondás</button>";
    } else {
        if ($value->status == 3) {
            $rating = "<button class='button px-2' data-bs-toggle='modal' data-bs-target='#rating_$value->ordersID-modal'>Értékelés</button>";
            $rating_modal = "<form id='rating_$value->ordersID-form' data-rat='1'><input type='hidden' name='carID' value='$value->carID'><input type='hidden' name='orderID' value='$value->ordersID'></form>
    <div class='d-flex flex-column align-items-center m-4 gap-3 justify-content-center'>
    <div class='px-1 py-1'>
        <label for='order-key' class='user-select-none'>E-mailban kapott megerősító kód</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-key'></i>
            <input type='text' id='order-key' name='order-key' form='rating_$value->ordersID-form' data-ordk='rating_$value->ordersID-form' minlength='8' placeholder='1234-1234-1234' autocomplete='false'>
        </div>
    </div><div class='px-1 py-1'>
        <label for='comment-title' class='user-select-none'>Hozzászólás címe</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-heading'></i>
            <input type='text' id='comment-title' name='comment-title' form='rating_$value->ordersID-form' data-ct='rating_$value->ordersID-form' minlength='8' placeholder='Hozzászólás címe' autocomplete='false'>
        </div>
    </div>
    <div class='px-1 py-1'>
        <label for='comment-body' class='user-select-none'>Hozzászólás szövege</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-message'></i>
            <textarea id='comment-body' name='comment-body' form='rating_$value->ordersID-form' data-cb='rating_$value->ordersID-form' minlength='10' placeholder='Hozzászólás szövege' autocomplete='false'></textarea>
        </div>
    </div>
    <div class='px-1 py-1'>
        <label for='rpassword2' class='user-select-none'>Jármű értékelése</label>
        <div class='d-flex gap-4 justify-content-center align-items-center'>
        ";
            for ($i = 1; $i <= 5; $i += 0.5) {
                if ($i == 5)
                    $rating_modal .= "<div class='d-flex flex-column align-items-center justify-contetn-center'><input class='ratings' type='radio' name='rating' id='radio_$i' form='rating_$value->ordersID-form' value='$i' checked><label class='form-check-label' for='radio_$i'>$i</label></div>";
                else
                    $rating_modal .= "<div class='d-flex flex-column align-items-center justify-contetn-center'><input class='ratings' type='radio' name='rating' id='radio_$i' form='rating_$value->ordersID-form' value='$i'><label class='form-check-label' for='radio_$i'>$i</label></div>";
            }
            $rating_modal .= "
        </div>
    </div></div>";
            $modal = new Modal("rating_$value->ordersID", "$value->carname értékelése", $rating_modal, [['name' => 'dismiss', 'type' => 'button', 'icon' => 'fa-circle-xmark', 'text' => 'Kilépés'], ['name' => 'rating_submit', 'type' => 'submit', 'icon' => 'fa-circle-check', 'text' => 'Értékelem', 'form' => "rating_$value->ordersID-form"]]);
            echo $modal->getModal();
        } else
            $rating = "<div style='line-height: 4;'>-</div>";
    }

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
        $extras = "<div style='line-height: 4;'>-</div>";
    }

    $status = "<span class='text-muted'>Feldolgozatlan</span>";

    if ($value->status == 1)
        $status = "<span class='text-success'>Elfogadva</span>";
    else if ($value->status == -1)
        $status = "<span class='text-danger'>Elutasítva</span>";
    else if ($value->status == -2)
        $status = "<span style='color: var(--col7)'>Lemondva</span>";
    else if ($value->status == 2)
        $status = "<span class='text-primary'>Aktív</span>";
    else if ($value->status == 3)
        $status = "<span class='text-info'>Véget ért</span>";
    else if ($value->status >= 4)
        if ($value->rating_approved == 1)
            $status = "<span class='text-muted'>Lezárva</span>";
        else
            $status = "<span class='text-warning'>Megerősítés alatt</span>";


    echo "<tr>
            <td class='text-center'>$value->ordersID</td>
            <td class='text-center' >$value->carname</td>
            <td class='text-center'>$value->rentStartdate</td>
            <td class='text-center'>$pick_place</td>
            <td class='text-center'>$value->rentEnddate</td>
            <td class='text-center'>$drop_place</td>
            <td class='d-flex align-items-center justify-content-center'>$extras</td>
            <td class='text-center'>$value->price</td>
            <td class='text-center'>$value->orderdate</td>
            <td class='text-center'>$status</td>          
            <td class='d-flex justify-content-center align-items-center gap-1 flex-column'>$rating</td>
        </tr>";
}

echo "</tbody>
    </table>
</main>";
require_once "footer.php";
echo "<script src='scripts/admin_dataTable.js'></script>
<script src='scripts/button-events.js'></script>
<script src='scripts/events.js'></script>
<script src='scripts/ajax.js'></script>
</body>
</html>";
}
    else redirection('index.php');
?>

