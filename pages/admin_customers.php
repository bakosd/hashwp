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

<div class="container" style="margin-top: 3rem">
        <div class="customer">
            <table id="customers" class="display" style="width:100%">
            
            <h2 style="overflow: hidden">Felhasználók</h2>
                <hr>
                <thead>
                    <tr>
                        <th>Felhasználónév</th>
                        <th>Név</th>
                        <th>Kor</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Állapot</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    
                        <tr>
                        <form method="post" id="myform"></form>
                            <td>Junior Technical Author</td>
                            <td>System Architect</td>
                            <td>29</td>
                            <td>Tiger_valami@gmail.com</td>
                            <td>063456277</td>
                            <td>Aktív</td>
                            <td><button type="submit" name="sub" form="myform">asdasd</button></td>
                        </tr>
    
            </table>
        </div>
    </div>
    </div>
    <?php
        if(isset($_POST['sub']))
        {
            echo 'hali';
        }
    ?>
    

    <script src="../scripts/admin_dataTable.js"></script>

    <script src="../scripts/button-events.js"></script>
    <script src="../scripts/events.js"></script>

</body>
</html>