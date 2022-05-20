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
?>
<main class="container">

    <div class="row" style="margin-top: 4.5rem">
        <h2>Jármű kinálatok</h2>
    </div>
    <div class="row gap-3" style="margin-bottom: 4.5rem;">
        <div class="col width-270">
            <div class="card">
                <div class="slider-img">
                    <img src="../images/cars/BMW/2014%20BMW%20M5.png" alt="kep" class="d-block w-75 mx-auto">
                </div>
                <div class="text">
                    <div>
                        <img src="../images/manufacturers/bmw.png" width="45px" class="p-1">&nbsp;
                        <b>M5</b>&nbsp;
                        <span>V8T 2014</span>
                    </div>
                    <div class="action-price">
                        <span>Napi ár:</span>&nbsp;<span class="price"><b>45.4$</b><del>69.99$</del></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="col width-270">
            <div class="card">
                <div class="slider-img">
                    <img src="../images/cars/Audi/2015%20Audi%20TTS.png" alt="kep" class="d-block w-75 mx-auto">
                </div>
                <div class="text">
                    <div>
                        <img src="../images/manufacturers/audi.png" width="45px" class="p-1">&nbsp;
                        <b>TTS</b>&nbsp;
                        <span>3.0 TDI 2015</span>
                    </div>
                    <div class="action-price">
                        <span>Napi ár:</span>&nbsp;<span class="price"><b>45.4$</b><del>69.99$</del></span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>

<?php
    require_once "footer.php";
?>

    <script src="../scripts/button-events.js"></script>
    <script src="../scripts/events.js"></script>
    <script src="../scripts/auto-swipe.js"></script>

</body>
</html>