<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/icons/logo-100.png">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/cards.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>
<?php
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
        <select name='order_by' id='order_by' class='select px-2 my-4'>
            <option value='discount'>Legnagyobb akció</option>
            <option value='asc'>Ár Legkisebb -> Legnagyobb</option>
            <option value='desc'>Ár Legnagyobb -> Legkisebb</option>
        </select>
    </div>
    <div class='row gap-3' id='cars' style='margin-bottom: 4.5rem;'>
    <?php
        echo cardBig('carousel', $search_options_array);
    ?>
    </div>

</main>



    <script src='../scripts/button-events.js'></script>
    <script src='../scripts/events.js'></script>


</body>
<?php
require_once "footer.php";
?>
</html>