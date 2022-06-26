<?php
 echo '<!DOCTYPE html>
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
<body>';
 require_once "navigation.php";

echo "<div id='header-wrap' class='container-fluid position-relative'><img id='image-bg' class='w-100 user-select-none' src='images/bg-image.jpg' alt='bg'><div id='wrap-header-content' class='d-flex position-absolute top-0 w-100 h-100 px-1 align-items-center justify-content-evenly gap-2'><div id='header-text-content'><h6 class='user-select-none '>Hash.</h6><p class='user-select-none '>Az idő pénz. Béreljen gyorsan és egyszerűen.</p></div><div id='header-card' class='p-2 d-flex justify-content-center'>
<form id='search' action='cars.php' method='post' class='d-flex justify-content-center flex-column align-items-center gap-2 container-fluid'><div class='p-1 w-100'><label for='pick-date' class='user-select-none'>Átvétel ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='pick-date' class='px-2 fa-solid fa-calendar'></label>
<input type='datetime-local' id='pick-date' name='pick-date'></div></div><div class='p-1 w-100'><label for='drop-date' class='user-select-none'>Leadás ideje</label><div class='submit-input input-with-icon d-flex align-items-center w-100'><label for='drop-date' class='px-2 fa-solid fa-calendar'></label>
<input type='datetime-local' id='drop-date' name='drop-date'></div></div> <div class='p-1 w-100'>";

$bq = new SQLQuery("SELECT DISTINCT bodywork FROM cars", []); $bodywork_array = $bq->getResult();
echo dropdownButton('Karosszéria', 'bodywork', $bodywork_array, 'icons/carspecs/bodywork');



    echo "</div><div class='p-1 d-flex flex-column justify-content-center align-items-center w-100 slider-outer-wrap'><label class='px-1 text-left user-select-none w-100'>Bérleti ár</label><div class='d-flex justify-content-center p-1 gap-2 w-100 num-input'><div class='submit-input input-with-icon d-flex align-items-center min'><label for='min1' class='pe-3 fa-solid fa-circle-minus'></label><input class='ms-1 w-50' type='number' id='min1' name='min' value='0' min='0' max='400' disabled></div><div class='submit-input input-with-icon d-flex align-items-center max'><label for='max1' class='pe-3 fa-solid fa-circle-plus'></label><input class='ms-1 w-50' type='number' id='max1' name='max' value='500' min='100' max='500' disabled></div></div><div class='slider position-relative w-100'><div class='slider-bg w-100 position-absolute'></div><div class='slider-progress position-absolute'></div><input type='hidden' name='gap' value='200'><div class='slider-input w-100'><input class='w-100 position-absolute' name='min' type='range' min='0' max='400' value='0' step='1'><input class='w-100 position-absolute' name='max' type='range' min='100' max='500' value='500' step='1'></div></div></div><div class='p-1 w-100'><input class='button w-100' type='submit' name='search-submit' value='Járművek listázása'></div></form></div></div></div><main class='container'><div class='row'><h2>Heti akciós járművek</h2></div><div class='row gap-3' style='margin-bottom: 4.5rem;'>";

//    echo cardBig('carousel-item', null, 'discount ASC');
    echo cardBig('carousel-item', array(["data"=>"discount", "op"=>" > ", "val"=>"0"],["data"=>"status", "op"=>" = ", "val"=>"0"]), 'discount DESC');
    echo cardBig("carousel", array(["data"=>"discount", "op"=>" > ", "val"=>"0"],["data"=>"status", "op"=>" = ", "val"=>"0"]), 'discount DESC', 1);
    echo "</div><div class='row' style='margin-top: 2rem;'><h2>Legjobb értékelésű járművek</h2></div>";
    echo cardSmall();

    echo "<script src='https://unpkg.com/swiper/swiper-bundle.min.js'></script></main>";

    require_once "footer.php";

if (isset($_GET['message'])){
    require_once "config.php";
    $count = !empty($_GET['count'])? ' ('.$_GET['count'].' db)' : "";
    $modal_msg = "<div class='m-2 p-2 text-center'>".$messages[$_GET['message']]."$count</div>";
    $modal_message = new Modal("message", "Értesítés", $modal_msg, [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Bezárás']]);
    $modal_message->showModal();
    echo "<script>window.history.replaceState({}, '','../pages/index.php');</script>";
}
echo "<script src='scripts/button-events.js'></script><script src='scripts/events.js'></script><script src='scripts/auto-swipe.js'></script></body></html>";
