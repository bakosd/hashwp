<?php
//TODO: sendEmail to hash@gmail.com
require_once "config.php";
if (isset($_POST['last_name']) && isset($_POST['first_name']) && isset($_POST['email']) && isset($_POST['message']) && !empty($lastname = trim($_POST['last_name'])) && !empty($first_name = trim($_POST['first_name'])) && !empty($comment =trim($_POST['message'])) && !empty($mail =trim($_POST['email']))){
    if (filter_var($mail, FILTER_VALIDATE_EMAIL))
        if (UserSystem::sendEmail('contact',HASH_MAIL, $first_name, $lastname, null, $mail, $comment))
           $message = 19;
        else
            $message = 18;
    else
        $message = 17;
    redirection("index.php?message=$message");
}
echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script><script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script><link rel='icon' type='image/x-icon' href='../images/icons/logo-100.png'><link rel='stylesheet' href='../styles/global.css'><link rel='stylesheet' href='../styles/navbar.css'><link rel='stylesheet' href='../styles/index.css'><link rel='stylesheet' href='../styles/cards.css'><link rel='stylesheet' href='../styles/contact.css'><meta name='viewport' content='width=device-width,height=device-heightinitial-scale=1'><title>Hash | Járműbérlés egyszerűen, gyorsan.</title></head><body>";
    require_once "navigation.php";
    $session = new Session();
    $query = new SQLQuery("SELECT city, address, phone, email FROM places ORDER BY placesID ASC LIMIT 1", []);
    $office = $query->getResult()[0];
    $first_name = "";
    $last_name = "";
    $email = "";
    if ($session->get('userID')) {
        $first_name = "value = '" . $session->get('firstname') . "' readonly='readonly'";
        $last_name = "value = '" . $session->get('lastname') . "' readonly='readonly'";
        $email = "value = '" . $session->get('email') . "' readonly='readonly'";
    }
echo "<main class='container' style='margin-top: 4.5rem'>
   
        <div class='row d-flex gap-4' style='overflow: hidden !important;'>
            <div class='col con-text d-flex flex-column gap-4'>
                <h4 class='title'>Vegye fel velünk a kapcsolatot!</h4>
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
                <h6 class='mx-4 title'>Vegye fel a kapcsolatot űrlap formájában!</h6>
                <form class='d-flex flex-column gap-2 px-4' method='post' id='contact-form'>
                    
               <div class='d-flex justify-content-between gap-2 flex-wrap'> <div class='col'>    <label class='text-nowrap'>Vezetéknév <span>*</span></label><br>
                    <input type='text' class='input-with-icon w-100' name='last_name' $last_name></div>
               
                   <div class='col'> <label class='text-nowrap'>Keresztnév <span>*</span></label>
                    <input type='text' class='input-with-icon w-100' name='first_name' $first_name></div></div>
                    
                    <label>Email <span>*</span></label>
                    <input type='email' class='input-with-icon w-100' name='email' $email>
                    
                    <label>Üzenet <span>*</span></label>
                    <textarea class='input-with-icon' style='width: 100%; height:120px; resize: none;' name='message'></textarea><br>
                    <input type='submit' class='button w-100 mt-4' value='Küldés'>
                </form>
            </div>
            <div class='col-lg-6 col-sm-12 p-2' id='map'>
            <h6 class='mx-4 title'>Tekintse meg az irodáinkat!</h6>
                <!--<iframe src='https://www.google.com/maps/d/embed?mid=1LXQo4_dupajUdCrkUqIBmI3VmfNPEvSs&ehbc=2E312F' width='100%' height='860'></iframe>-->
                <iframe style='border-radius: 1rem !important; border: 1px solid #000; box-shadow: 0 2px 12px #000;' src='https://my.atlistmaps.com/map/9cd1d586-5b21-4b4e-be98-37a5d8e6434f?share=true' allow='geolocation' width='100%' height='890' frameborder='0' scrolling='no' allowfullscreen></iframe>
            </div>
        </div>
</main>";
    include_once "footer.php";
    echo '<script src="../scripts/button-events.js"></script><script src="../scripts/events.js"></script></body></html>';
?>

