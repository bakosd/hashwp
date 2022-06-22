<?php
require_once "config.php";
$session = new Session();
if ($session->get('userID') > 0){
if (isset($_POST) && isset($_POST['favorite'])) {
    $returnValue = "error";
    $queryS = new SQLQuery("SELECT favoritesID FROM favorites WHERE carID = :carID AND userID = :userID LIMIT 1", [':carID' => $_POST['favorite'], ':userID'=>$session->get('userID')]);
    if ($queryS->getResult() != null) {
        $favoriteID = $queryS->getResult()[0]->favoritesID;
        $query = new SQLQuery("DELETE FROM favorites WHERE favoritesID = :favoriteID", [':favoriteID' => $favoriteID]);
        if ($query->getDbq()->rowCount() > 0) {
            $returnValue = "delete";
        }
    } else {
        $query = new SQLQuery("INSERT INTO favorites (userID, carID) VALUES (:userID, :carID)", [':userID' => $session->get('userID'), ':carID' => $_POST['favorite']]);
        $returnValue = "insert";
    }
    exit($returnValue);
}

//<button class='mx-2 button-favorite' id='favorite_button' data-favorite='$result->carsID'><i class='fa-solid fa-heart' $is_favorited></i></button>
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
    <table id='favorites' class='display' style='width:100%'>
        <h2 style='overflow: hidden'>Kedvenceim</h2><hr>
        <thead><tr>
            <th class='text-center'>Jármű</th>
            <th class='text-center'>Állapot</th>
        </tr></thead><tbody>";
$queryS = new SQLQuery("SELECT carID, CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate) as carname FROM favorites INNER JOIN cars c on favorites.carID = c.carsID INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID WHERE userID = :userID", [':userID'=>$session->get('userID')]);
foreach ($queryS->getResult() as $value){
    $fav_query = new SQLQuery("SELECT favoritesID FROM favorites WHERE carID=:carID AND userID = :userID LIMIT 1", [':carID'=>$value->carID, ':userID'=>$session->get('userID')]);
    $is_favorited = ($fav_query->getResult() != null)? "style='color: var(--col-nosucc)'" : '';
echo "<tr>
            <td class='text-center'>$value->carname</td>
            <td class='d-flex justify-content-center align-items-center gap-1 flex-column'><button class='mx-2 button-favorite' id='favorite_button' data-favorite='$value->carID'><i class='px-2 fa-solid fa-heart' $is_favorited></i></button></td>
        </tr>";
}

echo "</tbody>
    </table>
</main>";
require_once "footer.php";
    echo "<script src='../scripts/admin_dataTable.js'></script>
<script src='../scripts/button-events.js'></script>
<script src='../scripts/events.js'></script>
<script src='../scripts/ajax.js'></script>
</body>
</html>";
}
else redirection('index.php');