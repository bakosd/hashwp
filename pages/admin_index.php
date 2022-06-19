<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/icons/logo-100.png">
    <link rel="stylesheet" href="../styles/admin_index.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/cards.css">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>

    <!--Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <!--Chart-->
    <!--JSON-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!--JSON-->

    <title>Hash | Járműbérlés egyszerűen, gyorsan.</title>
</head>
<body>
<?php
    session_start();
    require_once "navigation.php";
?>

<div class="container" style="margin-top: 3rem">
        <div class="flex-wrap">
            <div class="cards">
                <p>Új rendelések</p>
                <h4>56</h4>
                <p style="color: rgb(153, 152, 152);">Elmult 30 nap</p>
            </div>

            <div class="cards">
                <p>Alkalmazottak</p>
                <h4>17</h4>
                <p style="color: rgb(153, 152, 152);">Jelenleg</p>
            </div>

            <div class="cards">
                <p>Autók</p>
                <h4>62</h4>
                <p style="color: rgb(153, 152, 152);">Jelenleg</p>
            </div>

            <div class="cards">
                <p>Bevétel</p>
                <h4>1597 $</h4>
                <p style="color: rgb(153, 152, 152);">Utolsó 1 év</p>
            </div>
        </div>

        <div class="graphBox">
            <div class="box">
                <canvas id="barChart"></canvas>
            </div>
            <div class="box">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="orders">
            <h4 style="overflow: hidden;">Rendelések</h4>
            <hr>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                        <th>ID</th>
                        <th>Ár</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011-04-25</td>
                        <td>$320,800</td>
                        <td>4</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>2011-07-25</td>
                        <td>$170,750</td>
                        <td>14</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009-01-12</td>
                        <td>$86,000</td>
                        <td>3</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Cedric Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2012-03-29</td>
                        <td>$433,060</td>
                        <td>45</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Airi Satou</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>33</td>
                        <td>2008-11-28</td>
                        <td>$162,700</td>
                        <td>92</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Brielle Williamson</td>
                        <td>Integration Specialist</td>
                        <td>New York</td>
                        <td>61</td>
                        <td>2012-12-02</td>
                        <td>$372,000</td>
                        <td>20</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Herrod Chandler</td>
                        <td>Sales Assistant</td>
                        <td>San Francisco</td>
                        <td>59</td>
                        <td>2012-08-06</td>
                        <td>$137,500</td>
                        <td>21</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Herrod Chandler</td>
                        <td>Sales Assistant</td>
                        <td>San Francisco</td>
                        <td>59</td>
                        <td>2012-08-06</td>
                        <td>$137,500</td>
                        <td>21</td>
                        <td>20</td>
                    </tr>
                    
            </table>
        </div>
    </div>


    <script src="../scripts/admin_graph.js"></script>
    <script src="../scripts/admin_dataTable.js"></script>



    <script src="../scripts/button-events.js"></script>
    <script src="../scripts/events.js"></script>

</body>
</html>