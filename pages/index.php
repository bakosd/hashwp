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
<div id="header-wrap" class="container-fluid position-relative">
    <img id="image-bg" class="w-100 user-select-none" src="../images/bg-image.jpg" alt="bg">
    <div id="wrap-header-content" class="d-flex position-absolute top-0 w-100 h-100 px-1 align-items-center justify-content-evenly gap-2">
        <div id="header-text-content" class="">
            <h6 class="user-select-none ">Hash.</h6>
            <p class="user-select-none ">Az idő pénz. Béreljen gyorsan és egyszerűen.</p>
        </div>
        <div id="header-card" class="p-2 d-flex justify-content-center">
            <form action="" class="d-flex justify-content-center flex-column align-items-center gap-2 container-fluid">
                <div class="p-1 w-100">
                    <label for="pick-date" class="user-select-none">Átvétel ideje</label>
                    <div class="submit-input input-with-icon d-flex align-items-center w-100">
                        <label for="pick-date" class="px-2 fa-solid fa-calendar"></label>
                        <input type="datetime-local" id="pick-date" name="pick-date"> <!--value="<?php echo date("Y-m-d");?>"-->
                    </div>
                </div>
                <div class="p-1 w-100">
                    <label for="drop-date" class="user-select-none">Leadás ideje</label>
                    <div class="submit-input input-with-icon d-flex align-items-center w-100">
                        <label for="drop-date" class="px-2 fa-solid fa-calendar"></label>
                        <input type="datetime-local" id="drop-date" name="drop-date">
                    </div>
                </div>
                <div class="p-1 w-100">
                    <label for="droplist-hr-toggle" class="user-select-none">Jármű kategóriák</label>
                    <button type="button" id="droplist-hr-toggle" onclick="dropdownList('droplist-hr', 'droplist-hr-toggle')" class="position-relative submit-input input-with-icon d-flex align-items-center position-relative droplist-button">
                        <span id="droplist-hr-toggle-text" class="droplist-toggle-text">Nincs kiválasztott</span>
                        <i class="me-2 position-absolute end-0 fa-solid fa-angle-down"></i>
                    </button>
                    <div id="droplist-hr" class="droplist droplist-multiselect d-flex flex-column gap-1 p-1 justify-content-center align-items-center d-none">
                        <input class="d-none droplist-checkbox" type="checkbox" id="dlhr-cat-1" name="droplist-hr" value="Városi">
                        <input class="d-none droplist-checkbox" type="checkbox" id="dlhr-cat-2" name="droplist-hr" value="Elektromos">
                        <input class="d-none droplist-checkbox" type="checkbox" id="dlhr-cat-3" name="droplist-hr" value="Szedán">
                        <input class="d-none droplist-checkbox" type="checkbox" id="dlhr-cat-4" name="droplist-hr" value="Terepjáró">
                        <input class="d-none droplist-checkbox" type="checkbox" id="dlhr-cat-5" name="droplist-hr" value="Limuzin">
                        <input class="d-none droplist-checkbox" type="checkbox" id="dlhr-cat-6" name="droplist-hr" value="Kabrió">
                        <label for="dlhr-cat-1"
                               class="category-checkbox d-flex px-2 align-items-center gap-1 user-select-none"><img
                                src="../images/icons/carspecs/bodywork/city.png" alt="city"><span>Városi</span></label>
                        <label for="dlhr-cat-2"
                               class="category-checkbox d-flex px-2 align-items-center gap-1 user-select-none"><img
                                src="../images/icons/carspecs/bodywork/electric.png" alt="electric"><span>Elektromos</span></label>
                        <label for="dlhr-cat-3"
                               class="category-checkbox d-flex px-2 align-items-center gap-1 user-select-none"><img
                                src="../images/icons/carspecs/bodywork/sedan.png" alt="sedan"><span>Szedán</span></label>
                        <label for="dlhr-cat-4"
                               class="category-checkbox d-flex px-2 align-items-center gap-1 user-select-none"><img
                                src="../images/icons/carspecs/bodywork/jeep.png" alt="jeep"><span>Terepjáró</span></label>
                        <label for="dlhr-cat-5"
                               class="category-checkbox d-flex px-2 align-items-center gap-1 user-select-none"><img
                                src="../images/icons/carspecs/bodywork/limousine.png" alt="limousine"><span>Limuzin</span></label>
                        <label for="dlhr-cat-6"
                               class="category-checkbox d-flex px-2 align-items-center gap-1 user-select-none"><img
                                src="../images/icons/carspecs/bodywork/convertible.png" alt="convertible"><span>Kabrió</span></label>
                    </div>
                </div>
                <div class="p-1 d-flex flex-column justify-content-center align-items-center w-100 slider-outer-wrap">
                    <label class="px-1 text-left user-select-none w-100">Bérleti ár</label>
                    <div class="d-flex justify-content-center p-1 gap-2 w-100 num-input">
                        <div class="submit-input input-with-icon d-flex align-items-center min">
                            <label for="min1" class="pe-3 fa-solid fa-circle-minus"></label>
                            <input class="ms-1 w-50" type="number" id="min1" name="min" value="0" min="0" max="400" disabled>
                        </div>
                        <div class="submit-input input-with-icon d-flex align-items-center max">
                            <label for="max1" class="pe-3 fa-solid fa-circle-plus"></label>
                            <input class="ms-1 w-50" type="number" id="max1" name="max" value="500" min="100" max="500" disabled>
                        </div>
                    </div>
                    <div class="slider position-relative w-100">
                        <div class="slider-bg w-100 position-absolute"></div>
                        <div class="slider-progress position-absolute"></div>
                        <input type="hidden" name="gap" value="200">
                        <div class="slider-input w-100">
                            <input class="w-100 position-absolute" name="min" type="range" min="0" max="400" value="0" step="1">
                            <input class="w-100 position-absolute" name="max" type="range" min="100" max="500" value="500" step="1">
                        </div>
                    </div>
                </div>
                <div class="p-1 w-100">
                    <input class="button w-100" type="submit" name="login-submit" value="Járművek listázása">
                </div>
            </form>
        </div>
    </div>

</div>
<main class="container">

    <div class="row">
        <h2>Heti akciós járművek</h2>
    </div>

    <div class="row gap-3" style="margin-bottom: 4.5rem;">
        <div class="col width-270">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="slider-img">
                            <img src="../images/cars/Audi/2016%20Audi%20RS%207.png" class="d-block w-75 mx-auto" alt="...">
                        </div>
                        <div class="text">
                            <div>
                                <img src="../images/manufacturers/audi.png" width="45px" class="px-1">&nbsp;
                                <b>RS6</b>&nbsp;
                                <span>4.0 TFSI 2016</span>
                            </div>
                            <div class="action-price">
                                <span>Akciós ár:</span>&nbsp;<span class="price"><b>55.4$</b><del>69.99$</del></span>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/cars/BMW/2015%20BMW%20M4.png" class="d-block w-75 mx-auto" alt="...">
                        </div>
                        <div class="text">
                            <div>
                                <img src="../images/manufacturers/bmw.png" width="45px" class="p-1">&nbsp;
                                <b>M4</b>&nbsp;
                                <span>3.0 DCT 2015</span>
                            </div>
                            <div class="action-price">
                                <span>Akciós ár:</span>&nbsp;<span class="price"><b>55.4$</b><del>69.99$</del></span>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/cars/Mercedes-Benz/2017%20Mercedes-Benz%20Sprinter%202500.png" class="d-block w-75 mx-auto" alt="...">
                        </div>
                        <div class="text">
                            <div>
                                <img src="../images/manufacturers/mercedes-benz.png" width="45px" class="p-1">&nbsp;
                                <b>Sprinter 2500</b>&nbsp;
                                <span>2.1 TDI 2017</span>
                            </div>
                            <div class="action-price">
                                <span>Akciós ár:</span>&nbsp;<span class="price"><b>55.4$</b><del>69.99$</del></span>
                            </div>
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
                        <span>Akciós ár:</span>&nbsp;<span class="price"><b>45.4$</b><del>69.99$</del></span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 2rem;">
        <h2>Legjobb értékelésű járművek</h2>
    </div>
    <div class="swiper mySwiper" style="padding: .5rem;">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="../images/cars/Ferrari/2015%20Ferrari%20458%20Italia.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/Audi/2015%20Audi%20TTS.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/BMW/2015%20BMW%20X5%20M.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/BMW/2015%20BMW%20M4.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/BMW/2020%20BMW%20i3.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/Mercedes-Benz/2017%20Mercedes-Benz%20Sprinter%202500.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/Ford/2017%20Ford%20Fiesta.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/BMW/2021%20BMW%20330.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/smart/2017%20smart%20ForTwo.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide"><img src="../images/cars/MINI/2022%20MINI%20Countryman.png" alt="car-name">
                <div class="card-text">
                    <img src="../images/manufacturers/bmw.png" class="p-1">&nbsp;
                    <b>Sprinter 2500</b>&nbsp;
                    <span>3.0 DCT 2015</span>

                    <div class="rate-price">
                        <span>Már napi&nbsp;<b>59.99€</b></span>
                        <div class="rate" style="margin-right: 1rem;">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--<div class="swiper-slide"><img src="../images/cars/car2.jpg" alt="car-name"></div>
            <div class="swiper-slide"><img src="../images/cars/car1.jpg" alt="car-name"></div>-->
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


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
                    <button class="button px-3" data-bs-toggle="modal" data-bs-target="#modal1">Feliratkozom</button>
                    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="newsletter" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-2" id="newsletter">Hírlevél</h5>
                                    <button type="button" class="button d-flex justify-content-center align-items-center" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <div class="modal-body">
                                    <p>Ha szeretne információkat kapni a legfrissebb akcióinkról, járműveinkről, az elfogadás gombbal beleegyezik, hogy üzenet küldjünk önnek.
                                    <p><small><i>Bármikor le tud íratkozni, ha mégsem szeretne üzeneteket kapni!</i></small></p></p>
                                </div>
                                <div class="modal-footer d-flex gap-2">
                                    <button type="button" class="button-2 px-2 d-flex justify-content-center align-items-center gap-2" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i>Elutasítás</button>
                                    <button type="button" class="button px-2 d-flex justify-content-center align-items-center gap-2"><i class="fa-solid fa-circle-check"></i>Elfogadás</button>
                                </div>
                            </div>
                        </div>
                    </div>
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