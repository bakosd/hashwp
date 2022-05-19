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

<footer>
    <div class="container px-4">
        <div class="row">
            <div class="col">
                <span><b>Hash.</b></span><br>
                <div style="font-size: .85rem; font-weight: lighter;">Béreljen gyorsan és egyszerűen!</div>
                    <div class="d-flex flex-column gap-1 py-3">
                        <small>Jovana Mikića 28, <b>Subotica</b></small>
                        <small><i class="fa-solid fa-phone"></i>&nbsp;+381 66 255 255</small>
                    </div>
            </div>

            <div class="col">
                <div class="footer-nav">
                    <b>Navigáció</b>
                    <ul>
                        <li><a href="index.php">Kezdőoldal</a></li>
                        <li><a href="cars.php">Járművek</a></li>
                        <li><a href="destinations.php">Átvételi pontok</a></li>
                        <li><a href="contacts.html">Kapcsolat</a></li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <b>Kövess minket</b>
                <ul>
                    <li><a target="_blank" href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i>Instagram</a></li>
                    <li><a target="_blank" href="https://www.facebook.com/"><i class="fa-brands fa-facebook-f"></i>Facebook</a></li>
                    <li><a target="_blank" href="https://www.youtube.com/"><i class="fa-brands fa-youtube"></i></i>Youtube</a></li>
                    <li><a target="_blank" href="https://www.twitter.com/"><i class="fa-brands fa-twitter"></i></i>Twitter</a></li>
                </ul>
            </div>

            <div class="col">
                <b>Legyél naprakész!</b>
                <div class="newletter">
                    <span>Íratkozz fel hírlevelűnkre, hogy ne<br> maradj le legfrissebb akcióinkról!<br></span>
                    <button class="button px-3">Feliratkozom</button>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <b>Hash</b> &copy; 2022 Minden jog fenntartva

    </div>
</footer>

    <script src="../scripts/button-events.js"></script>
    <script src="../scripts/events.js"></script>
    <script src="../scripts/auto-swipe.js"></script>

</body>
</html>