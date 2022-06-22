<?php

    include_once "config.php";
    

if(isset($_POST['upload_car']))
    {
        $manufacturer = $_POST['manufacturer'];
        $modell = $_POST['modell'];
        $motor = $_POST['motor'];
        $horsepower = $_POST['horsepower'];
        $gear = $_POST['gear'];
        $fuel = $_POST['fuel'];
        $doors = $_POST['doors'];
        $seats = $_POST['seats'];
        $airconditioner = $_POST['airconditioner'];
        $emission = $_POST['emission'];
        $year = $_POST['year'];
        $bodywork = $_POST['bodywork'];
        $distance = $_POST['distance'];
        $servisdistance = $_POST['servisdistance'];
        $consumtions = $_POST['consumtions'];
        $discount = $_POST['discount'];
        $price = $_POST['price'];
        $equipment_arr = array();
        $equipment = null;
        $status = 0;

        if(isset($_POST['gps']))
        {
            $equipment_arr['gps'] = "GPS";
        }
        if(isset($_POST['hook']))
        {
            $equipment_arr['hook'] = "Vonóhorog";
        }
        if(isset($_POST['parkingassist']))
        {
            $equipment_arr['parkingasistant'] = "Parkolókamera";
        }
        if(isset($_POST['roof']))
        {
            $equipment_arr['roof'] = "Tetőcsomagtartó";
        }
        if(isset($_POST['seatheater']))
        {
            $equipment_arr['seatheater'] = "Ülésfűtés";
        }
        if(isset($_POST['tempomat']))
        {
            $equipment_arr['tempomat'] = "Tempomat";
        }
        if($equipment_arr != null)
        {
            $equipment = "[".json_encode($equipment_arr, JSON_UNESCAPED_UNICODE)."]";
        }
        
        $sql = new SQLQuery("INSERT INTO cars (manufacturerID, carname,engine,gearbox,fuel,horsepower,seats,doors,bodywork,releasedate,distance,servisdistance,consumption,emissions,airconditioner,status,extras) VALUES (:manufacturer, :modell, :motor, :gear, :fuel, :horsepower, :seats, :doors,  :bodywork,  :year, :distance, :servisdistance, :consumtions, :emission, :airconditioner, :status ,:equipment)",[':manufacturer'=>$manufacturer,':modell'=>$modell,':motor'=>$motor,':gear'=>$gear,':fuel'=>$fuel,':horsepower'=>$horsepower,':seats'=>$seats,':doors'=>$doors,':bodywork'=>$bodywork,':year'=>$year,':distance'=>$distance,':servisdistance'=>$servisdistance,':consumtions'=>$consumtions,':emission'=>$emission,':airconditioner'=>$airconditioner,':status'=>$status,':equipment'=>$equipment]);
        $result = $sql -> getResult();

        $id = $sql->lastInsertId;

        $priceSQL = new SQLQuery("INSERT INTO prices (carID, price, discount) VALUES (:carid, :price, :discount)",[':carid'=>$id,':price'=>$price,':discount'=>$discount]);
        $priceResult = $priceSQL -> getResult();
        
        $manSQL = new SQLQuery("SELECT name FROM manufactures WHERE manufacturesID = $manufacturer",[]);
        $NameResult = $manSQL->getResult();

        foreach($NameResult as $name)
        {
            $folderName = $id." ".$year." ".$name->name." ".$modell;
            
            $manufacturName = $name->name;
        }

        $directorName = $manufacturName;

        $path = dirname(getcwd()).'/'.'images/cars/'.$directorName;

        if(!is_dir($path))
        {
            mkdir($path, 0777);
        }

        if(!is_dir($path.'/'.$folderName))
        {
            mkdir($path.'/'.$folderName, 0777);
        }

        $finalpath = $path.'/'.$folderName.'/';
        $nameCount=0;
       foreach($_FILES['image']['tmp_name'] as $key => $value)
        {
            $nameCount++;
            $format = array('jpg');
            $imageName = $_FILES['image']['name'][$key];
            $imageSize = $_FILES['image']['size'][$key];
            $imageTmp = $_FILES['image']['tmp_name'][$key];
            $imageType = pathinfo($finalpath.$imageName, PATHINFO_EXTENSION);
            
            $newName=$nameCount.'.'.$imageType;

            if($imageSize > 120000)
            {
                echo 'Túl big a pic';
            }
            else if(!empty($imageName) && !in_array($imageType, $format))
            {
                echo 'Csak jpg';
            }
            else
            {
                move_uploaded_file($imageTmp, $finalpath.$newName);
            }
        }
    }
