<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/icons/logo-100.png">
    <link rel="stylesheet" href="../styles/admin_tables.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/cards.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>
<?php
    require_once "navigation.php";
?>

<div class="container">
        <div class="customer">
            <table id="customers" class="display" style="width:100%">
            <h2 style="overflow: hidden">Alkalmazottak  </h2>
                <hr>
                <thead>
                    <tr>
                    <th>Felhasználónév</th>
                        <th>Vezetéknév</th>
                        <th>Keresztnév</th>
                        <th>Születési év</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Kiállítási hely</th>
                        <th></th>
                        <th style="display: none;"></th>
                        <th style="display: none;"></th>
                        <th style="display: none;"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = new SQLQuery("SELECT * FROM users WHERE level = 2", []);
                    $result = $sql -> getResult();
                    foreach($result as $row)
                    {
                        
                        //echo $row->username."<br>";
                        if($row->level > 0){
                            echo '<tr id="'.$row->usersID.'">';
                        }
                        else{
                            echo '<tr style="color: red;" id="'.$row->usersID.'">';
                        }
                        echo'
                            <td style="display: none;" data-target = "idNum">'.$row->idcardNumber.'</td>
                            <td style="display: none;" data-target = "licenseNum">'.$row->licensecardNumber.'</td>
                            <td style="display: none;" data-target = "level">'.$row->level.'</td>
                            <td data-target = "usname">'.$row->username.'</td>
                            <td data-target = "lastname">'.$row->lastname.'</td>
                            <td data-target = "firstname">'.$row->firstname.'</td>
                            <td data-target = "birthdate">'.$row->birthdate.'</td>
                            <td data-target = "email">'.$row->email.'</td>
                            <td data-target = "phone">'.$row->phonenumber.'</td>
                            <td data-target = place>'.$row->licensecardPlace.'</td>
                            <td><a href="#" data-role="update" data-id="'.$row->usersID.'">Valami</a></td>
                        </tr>';
                    }
                    $content = "<div class='p-3';'><div class='form-group'><label>Email</label><br><input id='emailc' type='email'></div><div class='form-group'><label>Vezetéknév</label><br><input id='lname' type='text'></div><div class='form-group'><label>Keresztknév</label><br><input id='fname' type='text'></div><div class='form-group'><label>Telefonszám</label><br><input id='phone' type='number'></div><div class='form-group'><label>Születési dátum</label><br><input id='birthd' type='date'></div><div class='form-group'><label>Személyi/útlevél szám</label><br><input id='idNum' type='number'></div><div class='form-group'><label>Vezetői engedély szám</label><br><input id='licensenum' type='number'></div><div class='form-group'><label>Kiadási helye</label><br><input id='licenseplace' type='text'></div><div class='form-group'><label>Szint</label><br><select id='level' class='sel'><option value = -1>Tiltás</option><option value = 1>Felhasználó</option><option value = 2>Alkalmazott</option><option value = 3>Admin</option></select></div></i></small></p></p></div><input type='hidden' id='usname'><input type='hidden' id='ID'><input type='hidden' id='ID'>";
                    $modal = new Modal("customerdata", "Adat módosítás", $content, [['name'=>'del', 'type'=>'submit', 'icon'=>'fa-circle-xmark', 'text'=>'Mégsem'], ['name'=>'update', 'type'=>'submit', 'icon'=>'fa-circle-check', 'text'=>'Mentés', 'form'=>'customerdata']]);
                    echo $modal->getModal();
                    ?>
                    
            </table>
        </div>
    </div>
    </div>
    

    <script src="../scripts/admin_dataTable.js"></script>

    <script src="../scripts/button-events.js"></script>
    <script src="../scripts/events.js"></script>
    <script src="../scripts/admin_ajax.js"></script>
</body>
</html>