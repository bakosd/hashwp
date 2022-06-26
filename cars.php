<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="images/icons/logo-100.png">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/cards.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>
<?php
    include "config.php";
    require_once "navigation.php";

    $search_options_array = null;
    $arr_key = 0;
    if (isset($_POST)) {
        if(isset($_POST['min']) && isset($_POST['max'])){
            $search_options_array[$arr_key++] = ["data"=>"p.price", "op"=>" > ", "val"=>$_POST['min']];
            $search_options_array[$arr_key++] = ["data"=>"p.price", "op"=>" < ", "val"=>$_POST['max']];
        }
        if (isset($_POST['manufacturer']))
            foreach ($_POST['manufacturer'] as $key => $value)
                $search_options_array[$arr_key++] = ["data"=>"ms.name", "op"=>" LIKE ", "val"=>$value];
        if (isset($_POST['bodywork']))
            foreach ($_POST['bodywork'] as $key => $value)
                $search_options_array[$arr_key++] = ["data"=>"bodywork", "op"=>" LIKE ", "val"=>$value];
        if (isset($_POST['seats']))
            foreach ($_POST['seats'] as $key => $value)
                $search_options_array[$arr_key++] = ["data"=>"seats", "op"=>" LIKE ", "val"=>$value];
        if (isset($_POST['fuel']))
            foreach ($_POST['fuel'] as $key => $value)
                $search_options_array[$arr_key++] = ["data"=>"fuel", "op"=>" LIKE ", "val"=>$value];
        if (isset($_POST['gearbox']))
            foreach ($_POST['gearbox'] as $key => $value)
                $search_options_array[$arr_key++] = ["data"=>"gearbox", "op"=>" LIKE ", "val"=>$value];
    }
?>
<main class='container'>

    <div class='row' style='margin-top: 4.5rem'>
        <h2>Jármű kinálatok</h2>
        <select name='order_by' id='order_by' class='select px-2 my-4 mx-2'>
            <option value='discount'>Legnagyobb akció</option>
            <option value='asc'>Ár Legkisebb -> Legnagyobb</option>
            <option value='desc'>Ár Legnagyobb -> Legkisebb</option>
        </select>
    </div>
    <div class='row gap-3' id='cars' style='margin-bottom: 4.5rem;'>
    <?php
    $session = new Session();
        if($session->get('level') == 3 && $session->get('edit')==1)
        {
            echo '<div class="col width-270">
                <div class="carousel h-100">
                    <button id="modalopen" data-bs-toggle="modal" data-bs-target="#newcar-modal">
                        <p style="font-size: 8rem; text-align: center; margin:0">+</p>
                        <span>Jármű hozzáadas</span>
                    </button>
            </div>';
        }
            echo cardBig('carousel', $search_options_array);
    ?>
    </div>

</main>

<?php
        $asd="";
        $sql = new SQLQuery("SELECT * FROM manufactures",[]);
        $asd = "";
        $result = $sql -> getResult();
        foreach($result as $manufacture)
        {
            $asd .= "<option value=".$manufacture->manufacturesID.">".$manufacture->name."</option>";
        $content = "<div class='p-3'><form id='newcar' method='post' action='car_action.php' enctype='multipart/form-data'><div class='form-group'><label>Gyártó</label><select name='manufacturer'>" .$asd."</select></div><div class='form-group'><label>Modell</label><input type='text' name='modell' minlenght='2'></div><div class='form-group'><label>Motor</label><input type='text' name='motor' minlenght='2'></div><div class='form-group'><label>Teljesítmény</label><input type='number' name='horsepower' minlenght='1'></div><div class='form-group'><label>Váltó</label><input type='text' name='gear' minlenght='2'></div><div class='form-group'><label>Üzemagyag</label><select name='fuel'><option value='Benzin'>Benzin</option><option value='Dízel'>Dízel</option><option value='Hybrid'>Hybrid</option><option value='Elektromos'>Elektromos</option></select></div><div class='form-group'><label>Ajtók száma</label><input type='number' name='doors' minlenght='1' maxlenght='2'></div><div class='form-group'><label>Ülések száma</label><input type='number' name='seats' minlenght='1' maxlenght='2'></div><div class='form-group'><label>Klíma</label><select name='airconditioner'><option value='Nincs'>Nincs</option><option value='Manuális'>Manuális</option><option value='Automata'>Automata</option><option value='Kétzónás'>Kétzónás</option></select></div><div class='form-group'><label>Emisszió</label><input type='number' name='emission' minlenght='1' maxlenght='4'></div><div class='form-group'><label>Évjárat</label><input type='number' name='year' minlenght='4' maxlenght='4'></div><div class='form-group'><label>Karosszéria</label><select name='bodywork'><option value='Szedan'>Szedan</option><option value='Kabrio'>Kabrio</option><option value='Limuzin'>Limuzin</option><option value='Coupe'>Coupe</option><option value='Hatchback'>Hatchback</option><option value='Kombi'>Kombi</option><option value='SUV'>SUV</option><option value='Terepjaro'>Terepjaro</option></select></div><div class='form-group'><label>Megtett út</label><input type='number' name='distance' minlenght='1'></div><div class='form-group'><label>Szervít</label><input type='number' value='15000' name='servisdistance' minlenght='1'></div><div class='form-group'><label>Fogyasztás</label><input type='number' name='consumtions' step='0.1' minlenght='1'></div><div class='form-group'><label>Felszereltség</label><div class='multi-selector'><div class='select-field'><input class='input-selector' type='text' placeholder='Felszereltség' disabled><span class='down-arrow'><i class='fa-solid fa-angle-down'></i></span></div><div class='list'><div class='item'><input type='checkbox' name='gps' id='gps'><label for='gps'>GPS</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='hook' id='hook'><label for='hook'>Vonóhorog</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='parkingasistant' id='parkingasistant'><label for='parkingasistant'>Parkolókamera</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='roof' id='roof'><label for='roof'>Tetőcsomagtartó</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='seatheater' id='seatheater'><label for='seatheater'>Ülésfűtés</label></div><hr style='margin: 10px 0'><div class='item'><input type='checkbox' name='tempomat' id='tempomat'><label for='tempomat'>Tempomat</label></div></div></div></div><div class='form-group'><label>Képek hozzáadás</label><input type='file' name='image[]' multiple></div><div class='form-group'><label>Indexkép hozzáadás</label><input type='file' name='indexp'></div><div class='form-group'><label>Ár</label><input type='number' name='price' step='0.1' minlenght='1'></div><div class='form-group'><label>Kedvezmény(%)</label><input type='number' name='discount' minlenght='1'></div></form></div>";
        }
        $modal = new Modal("newcar", "Jármű hozzáadás", $content, [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Mégsem'], ['name'=>'upload_car', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Hozzáad', 'form'=>'newcar']]);
        echo $modal->getModal();
    ?>

    <script>
        document.querySelector('.select-field').addEventListener('click',function(){
            document.querySelector('.list').classList.toggle('show');
        });
    </script>

    <script src='scripts/button-events.js'></script>
    <script src='scripts/events.js'></script>


</body>
<?php
require_once 'footer.php';
?>

</html>