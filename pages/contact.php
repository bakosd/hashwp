<?php
//TODO: sendEmail to hash@gmail.com
echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script><script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script><link rel='icon' type='image/x-icon' href='../images/icons/logo-100.png'><link rel='stylesheet' href='../styles/global.css'><link rel='stylesheet' href='../styles/navbar.css'><link rel='stylesheet' href='../styles/index.css'><link rel='stylesheet' href='../styles/cards.css'><link rel='stylesheet' href='../styles/contact.css'><meta name='viewport' content='width=device-width,height=device-heightinitial-scale=1'><link rel='stylesheet' href='https://unpkg.com/swiper/swiper-bundle.min.css'><title>Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";
    require_once "navigation.php";
    $session = new Session();
    $query = new SQLQuery("SELECT city, address, phone, email FROM places ORDER BY placesID ASC LIMIT 1", []);
    $office = $query->getResult()[0];
    $first_name = "value = '".$session->get('firstname')."' disabled";
    $last_name = "value = '".$session->get('lastname')."' disabled";
    $email = "value = '".$session->get('email')."' disabled";
echo "<main class='container-fluid bg-color'>
    <div class='container'>
        <div class='row' style='overflow: hidden !important;'>
            <div class='col con-text'>
                <h4 id='title'>Vegye fel velünk a kapcsolatot!</h4>
                <div class='info'>
                    <div>
                        <p><i class='fa-solid fa-location-dot'></i>&nbsp;Fő irodánk</p>
                        <span>$office->address, <b>$office->city</b></span>

                    </div>
                    <div>
                        <p><i class='fa-solid fa-phone'></i>&nbsp;Telefon</p>
                        <span>$office->phone</span>
                    </div>
                    <div>
                        <p><i class='fa-solid fa-envelope'></i>&nbsp;Email</p>
                        <span>$office->email</span>
                    </div>
                </div>
                <form>
                    <div class='name'>
                        <div class='first-name'>
                            <label>Vezetéknév <span>*</span></label><br>
                            <input type='text' class='input-with-icon w-100' $last_name>
                        </div>
                        <div class='first-name'>
                            <label>Keresztnév <span>*</span></label><br>
                            <input type='text' class='input-with-icon w-100' $first_name>
                        </div>
                    </div>
                    <label>Email <span>*</span></label><br>
                    <input type='email' class='input-with-icon w-100' $email>
                    <label>Üzenet <span>*</span></label><br>
                    <textarea class='input-with-icon' style='width: 100%; height:120px; resize: none;'></textarea><br>
                    <input type='submit' class='button w-100 mt-4' value='Küldés'>
                </form>
            </div>
            <div class='col p-0'>
                <div class='col p-0' id='map'>
                    <iframe src='https://www.google.com/maps/d/embed?mid=1LXQo4_dupajUdCrkUqIBmI3VmfNPEvSs&ehbc=2E312F' width='100%' height='860'></iframe>
                </div>
            </div>
        </div>
    </div>
</main>";
    include_once "footer.php";
    echo '<script src="../scripts/button-events.js"></script><script src="../scripts/events.js"></script><script src="../scripts/auto-swipe.js"></script></body></html>';
?>

