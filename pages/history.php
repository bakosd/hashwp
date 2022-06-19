<?php
require_once "config.php";
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
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/dashboard.css">
    <link rel="stylesheet" href="../styles/admin_tables.css">
    <link rel="stylesheet" href="../styles/cards.css">
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
    <table id='customers' class='display' style='width:100%'>
        <h2 style='overflow: hidden'>Rendeléseim</h2><hr>
        <thead><tr>
            <th>Azonosító</th>
            <th>Jármű</th>
            <th>Átvétel ideje</th>
            <th>Átvétel helye</th>
            <th>Átadás ideje</th>
            <th>Átadás helye</th>
            <th>Extrák</th>
            <th>Összeg</th>
            <th>Megrendelve</th>
            <th>Állapot</th>
            <th>Értékelés</th>
        </tr></thead><tbody>";
$session = new Session();
$query = new SQLQuery("SELECT CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate )AS carname, o.carID, o.ordersID, o.rentStartdate, o.rentEnddate, CONCAT(p.address,', ', p.city) as place_pick, CONCAT(pp.address,', ', pp.city) as place_drop, r.rating as rating, o.rentHomeplace, o.orderdate, o.extras, o.price, o.status FROM orders o INNER JOIN cars c on o.carID = c.carsID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID LEFT JOIN places p on o.rentStartplaceID = p.placesID LEFT JOIN places pp on o.rentEndplaceID = pp.placesID LEFT JOIN ratings r on o.carID = r.carID AND o.userID = r.userID WHERE o.userID = :userID GROUP BY o.ordersID ORDER BY o.ordersID DESC;", [':userID'=>$session->get('userID')]);

/*        echo "<pre>";
var_dump($query->getResult());
echo "</pre>";*/

foreach ($query->getResult() as $value){
    $pick_place = $value->place_pick;
    $drop_place = $value->place_drop;
    if(isset($value->rentHomeplace)){
        $pick_place = $value->rentHomeplace;
        if (!isset($value->place_drop))
            $drop_place = $value->rentHomeplace;
    }

    if (isset($value->rating) && $value->status == 4) {
        $link = "onclick=\"window.location.href='car.php?car=$value->carID'\"";
        $rating = "<button class='button px-2' $link>Megtekint</button><br><span>" . generateStars($value->rating) . "</span>";
    } else {
        if ($value->status == 3) {
            $rating = "<button class='button px-2' data-bs-toggle='modal' data-bs-target='#rating_$value->ordersID-modal'>Értékelés</button>";
            $rating_modal = "<form id='#rating_$value->ordersID-form'></form>
    <div class='d-flex flex-column align-items-center m-4 gap-3 justify-content-center'><div class='px-1 py-1'>
        <label for='comment-title' class='user-select-none'>Hozzászólás címe</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-heading'></i>
            <input type='text' id='comment-title' name='comment-title' minlength='8' placeholder='Hozzászólás címe' autocomplete='false'>
        </div>
    </div>
    <div class='px-1 py-1'>
        <label for='comment-body' class='user-select-none'>Hozzászólás szövege</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-message'></i>
            <textarea id='comment-body' name='comment-body' minlength='8' placeholder='Hozzászólás szövege' autocomplete='false'></textarea>
        </div>
    </div>
    <div class='px-1 py-1'>
        <label for='rpassword2' class='user-select-none'>Jármű értékelése</label>
        <div class='d-flex gap-4 justify-content-center align-items-center'>
        ";
            for ($i = 1; $i <= 5; $i += 0.5){
                if ($i == 5)
                    $rating_modal.= "<div class='d-flex flex-column align-items-center justify-contetn-center'><input class='ratings' type='radio' name='rating' id='radio_$i' value='$i' checked><label class='form-check-label' for='radio_$i'>$i</label></div>";
                else
                    $rating_modal.= "<div class='d-flex flex-column align-items-center justify-contetn-center'><input class='ratings' type='radio' name='rating' id='radio_$i' value='$i'><label class='form-check-label' for='radio_$i'>$i</label></div>";
            }
            $rating_modal.= "
        </div>
    </div></div>";
            /*<input class='d-none' type='radio' name='rating' id='r1' value='1'>
<label for='r1'><i class='fa-solid fa-star'></i></label>

<input class='d-none' type='radio' name='rating' id='r1.5' value='1.5'>
<label for='r1.5'><i class='fa-regular fa-star-half'></i></i></label>

<input class='d-none' type='radio' name='rating' id='r2' value='2'>
<label for='r2'><i class='fa-solid fa-star'></i></label>

<input class='d-none' type='radio' name='rating' id='r2.5' value='2.5'>
<label for='r2.5'><i class='fa-regular fa-star-half'></i></i></label>

<input class='d-none' type='radio' name='rating' id='r3' value='3'>
<label for='r3'><i class='fa-solid fa-star'></i></label>

<input class='d-none' type='radio' name='rating' id='r.5' value='3.5'>
<label for='r3.5'><i class='fa-regular fa-star-half'></i></i></label>

<input class='d-none' type='radio' name='rating' id='r4' value='4'>
<label for='r4'><i class='fa-solid fa-star'></i></label>

<input class='d-none' type='radio' name='rating' id='r4.5' value='4.5'>
<label for='r4.5'><i class='fa-regular fa-star-half'></i></i></label>

<input class='d-none' type='radio' name='rating' id='r5' value='5'>
<label for='r5'><i class='fa-solid fa-star'></i></label>*/
            $modal = new Modal("rating_$value->ordersID", "#$value->carname értékelése", $rating_modal, [['name' => 'dismiss', 'type' => 'button', 'icon' => 'fa-circle-xmark', 'text' => 'Kilépés'], ['name'=>'rating_submit', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Értékelem', 'form'=>"#rating_$value->ordersID-form"]]);
            echo $modal->getModal();
        }else
            $rating = "-";
    }

    $extras_array = json_decode($value->extras);
    if (isset($extras_array) && !empty($extras_array)) {
        $extras = "<div class='d-flex flex-column gap-1 align-items-center'>";
        foreach ($extras_array as $item){
            $q = new SQLQuery("SELECT name, price FROM order_extras WHERE orderextrasID = :id", [':id'=>$item]);
            $res = $q->getResult()[0];
            $extras .= "<div class='w-100 d-flex gap-2 justify-content-center align-items-center'><span class='col-5'><b>Extra: </b>$res->name</span><span class='col-5'><b>Ára: </b>$res->price</span></div>";
        }
        $extras .= "</div>";
        $modal = new Modal("extras_$value->ordersID", "#$value->ordersID rendelés értékelése",$extras, [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Kilépés']]);
        echo $modal->getModal();
        $extras = "<button class='button px-2' data-bs-toggle='modal' data-bs-target='#extras_$value->ordersID-modal'>Megtekint</button>";
    } else {
        $extras = "Nincs extra.";
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
    else if ($value->status == 4)
        $status = "<span class='text-muted'>Lezárva</span>";


    echo "<tr>
            <td>$value->ordersID</td>
            <td>$value->carname</td>
            <td>$value->rentStartdate</td>
            <td>$pick_place</td>
            <td>$value->rentEnddate</td>
            <td>$drop_place</td>
            <td>$extras</td>
            <td>$value->price</td>
            <td>$value->orderdate</td>
            <td>$status</td>          
            <td class='d-flex justify-content-center align-items-center gap-1 flex-column'>$rating</td>
        </tr>";
}

        echo "</tbody>
    </table>
</main>";
require_once "footer.php";
?>
<script src="../scripts/admin_dataTable.js"></script>
<script src="../scripts/button-events.js"></script>
<script src="../scripts/events.js"></script>
</body>
</html>
