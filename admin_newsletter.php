<?php
require_once "config.php";
$session = new Session();
if (!$session->get('userID') && $session->get('level') < 2)
    redirection('index.php');
$queryS = new SQLQuery("SELECT carsID, CONCAT(m.name, ' ', c.carname, ' ', c.engine, ' ', c.releasedate) as carname, p.discount as discount_percent, ROUND((p.price - (p.price * discount / 100)),2) as discounted_price, price FROM cars c INNER JOIN manufactures m on c.manufacturerID = m.manufacturesID INNER JOIN prices p on c.carsID = p.carID AND p.discount > 0", []);
if ($queryS->getResult() != null) {
    $newsletter_string = "<table class='row display mx-auto' style='width: 100% !important;'>
<h2 style='overflow: hidden'>Heti akciós járművek</h2><hr>
<thead><tr class='d-flex justify-content-between'>
<th class='text-center col-lg-3 col-sm-12'>Jármű neve</th>
<th class='text-center col-lg-3 col-sm-12'>Rendes ára</th>
<th class='text-center col-lg-3 col-sm-12'>Leárazás %</th>
<th class='text-center col-lg-3 col-sm-12'>Jelenlegi ára</th>
        </tr></thead><tbody>";


    foreach ($queryS->getResult() as $result) {
        $newsletter_string .= "<tr class='d-flex'>
<td class='text-center col-lg-3 col-sm-12'>$result->carname</td>
<td class='text-center col-lg-3 col-sm-12'>$result->price €</td>
<td class='text-center col-lg-3 col-sm-12'>$result->discount_percent %</td>
<td class='text-center col-lg-3 col-sm-12'>$result->discounted_price €</td>
</tr>
";
    }
    $newsletter_string .= "</tbody></table>";
}else
    $newsletter_string = "";

if (isset($_POST['newsletter_send']) && $_POST['newsletter_send'] == 1){
    $mails_query = new SQLQuery("(SELECT email FROM users WHERE subscribed >= 0) UNION (SELECT email FROM newslettermails)",[]);
    $mails = $mails_query->getResult();
    $counter = 0;
    if (isset($mails)){
        foreach ($mails as $mail){
            if (filter_var($mail->email, FILTER_VALIDATE_EMAIL)){
                if (UserSystem::sendEmail('newsletter', $mail->email, "", "", null, $newsletter_string))
                    $counter++;
            }
        }
        redirection('index.php?message=20&count='.$counter);
    }
    else
        redirection('index.php?message=21');

}
?>
<!DOCTYPE html>
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
    <link rel="stylesheet" href="styles/admin_tables.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>

<?php
require_once "navigation.php";


?>
<main class='container' style='margin-top: 4.5rem'>


    <?php
    if (strlen($newsletter_string) > 0) {
        echo $newsletter_string;
        echo "<div class='row'>
        <form method='post' id='newsletter_send'><input type='hidden' name='newsletter_send' value='1'></form>
        <button form='newsletter_send' type='submit' class='button w-75 mx-auto' style='margin: 4.5rem;'>Hírlevél körbeküldése</button></div>
    </div>";
    }
    else
        echo "<div>Nincs akciós jármű!</div>";
    ?>


</main>



<script src='scripts/button-events.js'></script>
<script src='scripts/events.js'></script>


</body>
<?php
require_once "footer.php";
?>
</html>
