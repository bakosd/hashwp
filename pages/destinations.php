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
<!--    <link rel="stylesheet" href="../styles/destinations.css">-->
    <link rel="stylesheet" href="../styles/car.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>
<?php
    require_once "navigation.php";
?>
<main class="container">
    <div class="d-flex row" style="margin-top: 4.5rem">
        <div class="col-12 d-flex align-items-center gap-2 mb-4">
            <div class="manufacturer-logo d-flex align-items-center">
                <img src="../images/icons/map.png" style="width: 45px;" class="p-1">
            </div>
            <h2>Szabadkai átvételi pont</h2>
        </div>
        <div class="col width-270 col-lg-6 col-sm-12">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="slider-img">
                                <img src="../images/offices/Subotica1/1.jpg" class="d-block w-100 mx-auto" alt="...">
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="slider-img">
                                <img src="../images/offices/Subotica1/2.jpg" class="d-block w-100 mx-auto" alt="...">
                            </div>
                        </div>
                        <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/offices/Subotica1/3.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        <div class="col-lg-6 col-sm-12 p-3 d-flex flex-column gap-2">
            <h3 class="w-100 text-italic text-center">Átvételi pont adatok</h3>
            <div class="d-flex gap-2 align-items-center flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/map.png" alt="google-map"></div>
                <b class="user-select-none">Iroda címe:</b>
                <span>Jovana Mikića 28, Szabadka</span>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/phone.png" alt="phone"></div>
                <b class="user-select-none">Telefonszám:</b>
                <span>+381 66 255 255</span>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/email.png" alt="phone"></div>
                <b class="user-select-none">E-mail:</b>
                <span>office@hash.com</span>
            </div>
            <div class="d-flex gap-2 flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/busines_time.png" alt="busines_time"></div>
                <b class="user-select-none ">Nyitvatartás:</b>
                <div class="d-flex flex-column">
                    <span>-Hétköznap: 8:00 - 21:00</span>
                    <span>-Hétvégén: 8:00 - 18:00</span>
                </div>
            </div>
            <button class="button my-4">Iroda hívása</button>
        </div>
    </div>

    <div class="d-flex row" style="margin-top: 4.5rem">
        <div class="col-12 d-flex align-items-center gap-2 mb-4">
            <div class="manufacturer-logo d-flex align-items-center">
                <img src="../images/icons/map.png" style="width: 45px;" class="p-1">
            </div>
            <h2>Topolyai átvételi pont</h2>
        </div>
        <div class="col width-270 col-lg-6 col-sm-12">
            <div id="carouselExampleFade1" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="slider-img">
                            <img src="../images/offices/Subotica1/1.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/offices/Subotica1/2.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/offices/Subotica1/3.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 p-3 d-flex flex-column gap-2">
            <h3 class="w-100 text-italic text-center">Átvételi pont adatok</h3>
            <div class="d-flex gap-2 align-items-center flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/map.png" alt="google-map"></div>
                <b class="user-select-none">Iroda címe:</b>
                <span>Jovana Mikića 28, Szabadka</span>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/phone.png" alt="phone"></div>
                <b class="user-select-none">Telefonszám:</b>
                <span>+381 66 255 255</span>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/email.png" alt="phone"></div>
                <b class="user-select-none">E-mail:</b>
                <span>office@hash.com</span>
            </div>
            <div class="d-flex gap-2 flex-wrap link car-specs-wrap" style="width: 100% !important;">
                <div class="specs-img d-flex align-items-center justify-content-center"><img src="../images/icons/busines_time.png" alt="busines_time"></div>
                <b class="user-select-none ">Nyitvatartás:</b>
                <div class="d-flex flex-column">
                    <span>-Hétköznap: 8:00 - 21:00</span>
                    <span>-Hétvégén: 8:00 - 18:00</span>
                </div>
            </div>
            <button class="button my-4">Iroda hívása</button>

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