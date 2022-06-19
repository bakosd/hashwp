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
    <div class="navigation-header row d-flex justify-content-center align-items-center gap-2">
    <div class="col">
        <h2 class="col d-flex gap-2 align-items-center" style="overflow: hidden;">
            <div class="manufacturer-logo d-flex align-items-center">
                <img src="../images/manufacturers/audi.png" style="width: 45px;" class="px-1">
            </div>
            <span class="car-title"><span>Audi</span> RS7 <i>2016</i></span>
        </h2>
        <small class="d-inline col">Járművek/Audi/Audi RS7 2016</small>
    <div class="row gap-3 mt-4" style="margin-bottom: 4.5rem;">
        <div class="col width-270 d-flex flex-column align-items-center gap-4 ">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="slider-img">
                            <img src="../images/cars/Audi/2016_Audi_RS7/1.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/cars/Audi/2016_Audi_RS7/2.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/cars/Audi/2016_Audi_RS7/3.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/cars/Audi/2016_Audi_RS7/4.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/cars/Audi/2016_Audi_RS7/5.jpg" class="d-block w-100 mx-auto" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-img">
                            <img src="../images/cars/Audi/2016_Audi_RS7/6.jpg" class="d-block w-100 mx-auto" alt="...">
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
            <div class="rate-price-buttons w-100 d-flex align-items-center flex-column gap-3">
                <div class="rate-price w-100 justify-content-around">
                    <div class="d-flex flex-column gap-1">
                        <small><del>Már napi&nbsp;<b>59.99€</b></del></small>
                        <span>Már napi&nbsp;<b>49.99€</b></span>
                    </div>
                    <div class="rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i>
                        <span class="rate-text">4.5</span>
                    </div>
                </div>
                <div class="d-flex justify-content-around w-100">
                    <span class="available d-flex align-items-center justify-content-center gap-1"><i class="fa-solid fa-circle-check"></i>Jelenleg elérhető</span>
                    <button class="button px-3 d-flex justify-content-center align-items-center gap-2">Tovább<i class="fa-solid fa-angle-right"></i></button>

                </div>
            </div>
        </div>
        <div class="col width-270 user-select-none"> <!--SPECIFIKÁCIÓ RÉSZ-->
            <h3 class="w-100 text-center mb-4">Jármű specifikációk</h3>
            <div class="row d-flex flex-wrap justify-content-start align-items-center gap-2 px-3">
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/engine.png" alt="engine"></div>
                    <span class="car-specs"><b>Motor: </b>4.0 TFSI</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/horsepower.png" alt="horsepower"></div>
                    <span class="car-specs"><b>Teljesítmény: </b>560 lóerő</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/gear.png" alt="gearbox"></div>
                    <span class="car-specs"><b>Váltó: </b>Automata 8 sebességű</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/fuel.png" alt="fuel"></div>
                    <span class="car-specs"><b>Üzemanyag: </b>Benzin</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/doors.png" alt="doors"></div>
                    <span class="car-specs"><b>Ajtók száma: </b>4</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/seats.png" alt="seats"></div>
                    <span class="car-specs"><b>Ülések száma: </b>4</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/airconditioner.png" alt="airconditioner"></div>
                    <span class="car-specs"><b>Klíma: </b>Automata</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/emissions.png" alt="emissions"></div>
                    <span class="car-specs"><b>Emisszió</b><small style="font-size: .725em">(CO<sup>2</sup>)</small><b>: </b>221</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/years/2016.png" alt="releasedate"></div>
                    <span class="car-specs"><b>Évjárat: </b>2016</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/bodywork/convertible.png" alt="bodywork"></div>
                    <span class="car-specs"><b>Karosszéria: </b>Kupe</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/odometer.png" alt="distance"></div>
                    <span class="car-specs"><b>Megtett út: </b>22.010 km</span>
                </div>
                <div class="col link car-specs-wrap d-flex justify-content-start align-items-center gap-2">
                    <div class="specs-img"><img src="../images/icons/carspecs/consumption.png" alt="consumption"></div>
                    <span class="car-specs"><b>Fogyasztás: </b>9.6l/100km</span>
                </div>
            </div>

            <div class="dropdown-push-wrap px-2 d-flex justify-content-center flex-column align-items-center">
                <div class="row w-100 d-flex mt-4 mb-2 dropdown-push p-2 position-relative" data-droppush-btn="1">
                    <i class="dropdown-push-arrow position-absolute fa-solid fa-angle-down"></i>
                    <h5 class="w-100 my-auto">Jármű felszereltségei</h5>
                </div>
                <div class="dropdown-push-content w-100 row d-flex flex-wrap justify-content-start align-items-center gap-2 p-2 d-none" data-droppush-content="1">
                    <div class="col car-specs-wrap link d-flex justify-content-start align-items-center gap-2">
                        <div class="specs-img"><img src="../images/icons/carspecs/parkingasistant.png" alt="parkingasistant"></div>
                        <span class="car-specs"><b>Parkolóaszisztens</b></span>
                    </div>
                    <div class="col car-specs-wrap link d-flex justify-content-start align-items-center gap-2">
                        <div class="specs-img"><img src="../images/icons/carspecs/seatheater.png" alt="seatheater"></div>
                        <span class="car-specs"><b>Ülésfűtés</b></span>
                    </div>
                    <div class="col car-specs-wrap link d-flex justify-content-start align-items-center gap-2">
                        <div class="specs-img"><img src="../images/icons/carspecs/tempomat.png" alt="tempomat"></div>
                        <span class="car-specs"><b>Tempomat</b></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="swiper mySwiper" style="padding: .5rem;">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="comment-card w-100">
                    <div class="comment-header d-flex gap-2">
                        <img src="../images/avatars/1/avatar.jpg" alt="avatar">
                        <div class="comment-user-data d-flex flex-column">
                            <span>Tarossza Irén</span>
                            <small>2022.04.08 18:36</small>
                        </div>
                    </div>
                    <div class="comment-body mt-3">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <span class="comment-title d-block text-start">Majdnem tökéletes autó!</span>
                            <div class="rate d-flex align-items-center">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <span class="px-1">4.0</span>
                            </div>
                        </div>
                        <p class="p-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi consequatur doloremque dolores doloribus eligendi facere facilis, impedit ipsum itaque labore libero maiores nostrum optio pariatur, placeat praesentium quae quod sit? Asdqweqew qwerqM MMMM</p>
                    </div>
                    <div class="comment-footer d-flex flex-column gap-2 pt-3">
                        <div class="likes d-flex align-items-center gap-4">
                            <div class="likes d-flex gap-2 align-items-center thumbs-myselect">
                                <button class="button-2 like"><i class="fa-solid fa-thumbs-up"></i></button>
                                <span class="like">112</span>
                            </div>
                            <div class="likes d-flex gap-2 align-items-center">
                                <button class="button-2 dislike"><i class="fa-solid fa-thumbs-down"></i></button>
                                <span class="dislike">4</span>
                            </div>
                        </div>
                        <span class="w-100 text-start fs-6">Nem kedveli :(</span>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="comment-card w-100">
                    <div class="comment-header d-flex gap-2">
                        <img src="../images/avatars/1/avatar.jpg" alt="avatar">
                        <div class="comment-user-data d-flex flex-column">
                            <span>Tarossza Irén</span>
                            <small>2022.04.08 18:36</small>
                        </div>
                    </div>
                    <div class="comment-body mt-3">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <span class="comment-title d-block text-start">Majdnem tökéletes autó!</span>
                            <div class="rate d-flex align-items-center">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <span class="px-1">4.0</span>
                            </div>
                        </div>
                        <p class="p-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi consequatur doloremque dolores doloribus eligendi facere facilis, impedit ipsum itaque labore libero maiores nostrum optio pariatur, placeat praesentium quae quod sit? Asdqweqew qwerqM MMMM</p>
                    </div>
                    <div class="comment-footer d-flex flex-column gap-2 pt-3">
                        <div class="likes d-flex align-items-center gap-4">
                            <div class="likes d-flex gap-2 align-items-center thumbs-myselect">
                                <button class="button-2 like"><i class="fa-solid fa-thumbs-up"></i></button>
                                <span class="like">112</span>
                            </div>
                            <div class="likes d-flex gap-2 align-items-center">
                                <button class="button-2 dislike"><i class="fa-solid fa-thumbs-down"></i></button>
                                <span class="dislike">4</span>
                            </div>
                        </div>
                        <span class="w-100 text-start fs-6">&nbsp;</span>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="comment-card w-100">
                    <div class="comment-header d-flex gap-2">
                        <img src="../images/avatars/1/avatar.jpg" alt="avatar">
                        <div class="comment-user-data d-flex flex-column">
                            <span>Tarossza Irén</span>
                            <small>2022.04.08 18:36</small>
                        </div>
                    </div>
                    <div class="comment-body mt-3">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <span class="comment-title d-block text-start">Majdnem tökéletes autó!</span>
                            <div class="rate d-flex align-items-center">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <span class="px-1">4.0</span>
                            </div>
                        </div>
                        <p class="p-2">Lorem ipsum optio pariatur, placeat praesentium quae quod sit? Asdqweqew qwerqM MMMM</p>
                    </div>
                    <div class="comment-footer d-flex flex-column gap-2 pt-3">
                        <div class="likes d-flex align-items-center gap-4">
                            <div class="likes d-flex gap-2 align-items-center thumbs-myselect">
                                <button class="button-2 like"><i class="fa-solid fa-thumbs-up"></i></button>
                                <span class="like">112</span>
                            </div>
                            <div class="likes d-flex gap-2 align-items-center">
                                <button class="button-2 dislike"><i class="fa-solid fa-thumbs-down"></i></button>
                                <span class="dislike">4</span>
                            </div>
                        </div>
                        <span class="w-100 text-start fs-6">Nem kedveli :(</span>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="comment-card w-100">
                    <div class="comment-header d-flex gap-2">
                        <img src="../images/avatars/1/avatar.jpg" alt="avatar">
                        <div class="comment-user-data d-flex flex-column">
                            <span>Tarossza Irén</span>
                            <small>2022.04.08 18:36</small>
                        </div>
                    </div>
                    <div class="comment-body mt-3">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <span class="comment-title d-block text-start">Majdnem tökéletes autó!</span>
                            <div class="rate d-flex align-items-center">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <span class="px-1">4.0</span>
                            </div>
                        </div>
                        <p class="p-2"> Asdqweqew qwerqM MMMM</p>
                    </div>
                    <div class="comment-footer d-flex flex-column gap-2 pt-3">
                        <div class="likes d-flex align-items-center gap-4">
                            <div class="likes d-flex gap-2 align-items-center thumbs-myselect">
                                <button class="button-2 like"><i class="fa-solid fa-thumbs-up"></i></button>
                                <span class="like">112</span>
                            </div>
                            <div class="likes d-flex gap-2 align-items-center">
                                <button class="button-2 dislike"><i class="fa-solid fa-thumbs-down"></i></button>
                                <span class="dislike">4</span>
                            </div>
                        </div>
                        <span class="w-100 text-start fs-6">Kedveli ezt.</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


</main>

<?php
    require_once "footer.php";
?>

    <script src="../scripts/button-events.js"></script>
    <script src="../scripts/events.js"></script>
    <script src="../scripts/auto-swipe.js"></script>

</body>
</html>