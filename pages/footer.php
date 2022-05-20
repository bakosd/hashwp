<?php
echo "<footer>
    <div class='container px-4'>
        <div class='row'>
            <div class='col'>
                <span><b>Hash.</b></span><br>
                <div style='font-size: .85rem; font-weight: lighter;'>Béreljen gyorsan és egyszerűen!</div>
                    <div class='d-flex flex-column gap-1 py-3'>
                        <small>Jovana Mikića 28, <b>Subotica</b></small>
                        <small><i class='fa-solid fa-phone'></i>&nbsp;+381 66 255 255</small>
                    </div>
            </div>

            <div class='col'>
                <div class='footer-nav'>
                    <b>Navigáció</b>
                    <ul>
                        <li><a href='index.php'>Kezdőoldal</a></li>
                        <li><a href='cars.php'>Járművek</a></li>
                        <li><a href='destinations.php'>Átvételi pontok</a></li>
                        <li><a href='contact.php'>Kapcsolat</a></li>
                    </ul>
                </div>
            </div>

            <div class='col'>
                <b>Kövess minket</b>
                <ul>
                    <li><a target='_blank' href='https://www.instagram.com/'><i class='fa-brands fa-instagram'></i>Instagram</a></li>
                    <li><a target='_blank' href='https://www.facebook.com/'><i class='fa-brands fa-facebook-f'></i>Facebook</a></li>
                    <li><a target='_blank' href='https://www.youtube.com/'><i class='fa-brands fa-youtube'></i></i>Youtube</a></li>
                    <li><a target='_blank' href='https://www.twitter.com/'><i class='fa-brands fa-twitter'></i></i>Twitter</a></li>
                </ul>
            </div>

            <div class='col'>
                <b>Legyél naprakész!</b>
                <div class='newletter'>
                    <span>Íratkozz fel hírlevelűnkre, hogy ne<br> maradj le legfrissebb akcióinkról!<br></span>
                    <button class='button px-3' data-bs-toggle='modal' data-bs-target='#modal1'>Feliratkozom</button>
                    <div class='modal fade' id='modal1' tabindex='-1' aria-labelledby='newsletter' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title fw-2' id='newsletter'>Hírlevél</h5>
                                    <button type='button' class='button d-flex justify-content-center align-items-center' data-bs-dismiss='modal' aria-label='Close'><i class='fa-solid fa-xmark'></i></button>
                                </div>
                                <div class='modal-body'>
                                    <p>Ha szeretne információkat kapni a legfrissebb akcióinkról, járműveinkről, az elfogadás gombbal beleegyezik, hogy üzenet küldjünk önnek.
                                    <p><small><i>Bármikor le tud íratkozni, ha mégsem szeretne üzeneteket kapni!</i></small></p></p>
                                </div>
                                <div class='modal-footer d-flex gap-2'>
                                    <button type='button' class='button-2 px-2 d-flex justify-content-center align-items-center gap-2' data-bs-dismiss='modal'><i class='fa-solid fa-circle-xmark'></i>Elutasítás</button>
                                    <button type='button' class='button px-2 d-flex justify-content-center align-items-center gap-2'><i class='fa-solid fa-circle-check'></i>Elfogadás</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='copyright'>
        <b>Hash</b> &copy; 2022 Minden jog fenntartva

    </div>
</footer>";