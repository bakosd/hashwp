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
                    <button class='button px-3' data-bs-toggle='modal' data-bs-target='#newsletter-modal'>Feliratkozom</button> <!-- Ezzel nyitod meg a modal-t-->
                    <form name='subscribe' id='subscribe' action='recovery.php' method='post'><input type='hidden' name='subscribe' value='1'></form>
                    
                    ";
    $mail_input = "";
    $session = new Session();

    if (empty($session->get("email")))
        $mail_input = "<div class='px-1 py-1 w-75 mx-auto mb-5'>
        <label for='newsletter-email' class='user-select-none'>Email cím</label>
        <div class='login-input input-with-icon d-flex align-items-center'>
            <i class='px-2 fa-solid fa-at'></i>
            <input form='subscribe' type='email' id='newsletter-email' name='newsletter-email' minlength='3' placeholder='Email cím' autocomplete='false'>
        </div>
    </div>";
        $newsletter_content = "<div class='p-3'><p>Ha szeretne információkat kapni a legfrissebb akcióinkról, járműveinkről, az elfogadás gombbal beleegyezik, hogy üzenet küldjünk önnek.<p><small><i>Bármikor le tud íratkozni, ha mégsem szeretne üzeneteket kapni!</i></small></p></p></div>$mail_input";
    $modal = new Modal("newsletter", "Hírlevél", $newsletter_content, [['name'=>'dismiss', 'type'=>'button', 'icon'=>'fa-circle-xmark', 'text'=>'Elutasítás'], ['name'=>'subscribe_submit', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Elfogadás', 'form'=>'subscribe']]);
    echo $modal->getModal();
echo "</div>
            </div>
        </div>
    </div>
    <div class='copyright'>
        <b>Hash</b> &copy; ".date('Y')." Minden jog fenntartva

    </div>
</footer>";