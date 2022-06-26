<?php

    require_once "config.php";
    
    

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

        $path = dirname(getcwd()).'/public_html/images/cars/'.$directorName;

        if(!is_dir($path))
        {
            mkdir($path, 0777);
        }

        if(!is_dir($path.'/'.$folderName))
        {
            mkdir($path.'/'.$folderName, 0777);
        }

        $indexformat = array('jpg');
        $indeximageName = $_FILES['indexp']['name'];
        $indeximageSize = $_FILES['indexp']['size'];
        $indeximageTmp = $_FILES['indexp']['tmp_name'];

        if(strpos($indeximageName, '.png') != false)
        {
            move_uploaded_file($indeximageTmp,$path.'/'.$indeximageName);
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

            if(!empty($imageName) && !in_array($imageType, $format))
            {
                
            }
            else
            {
                move_uploaded_file($imageTmp, $finalpath.$newName);
            }
        }

        header('Location: cars.php');
        
    }

    if(isset($_POST['edit_car']))
    {
        $carID = $_POST['carID'];

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
        if(isset($_POST['parkingasistant']))
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
        
        $sql = new SQLQuery("UPDATE cars SET manufacturerID=:manufacture, carname=:modell, engine=:engine,gearbox=:gear,fuel=:fuel,horsepower=:horsepower,seats=:seats,doors=:doors,bodywork=:bodywork,releasedate=:year,distance=:distance,servisdistance=:servisdistance,consumption=:consumption,emissions=:emissions,airconditioner=:airconditioner, extras=:equipment WHERE carsID = :carID",[':manufacture'=>$manufacturer,':carID'=>$carID, ':modell'=>$modell, ':engine'=>$motor,':gear'=>$gear,':fuel'=>$fuel, ':horsepower'=>$horsepower,':seats'=>$seats,':doors'=>$doors,':bodywork'=>$bodywork,':year'=>$year,':distance'=>$distance,':servisdistance'=>$servisdistance, ':consumption'=>$consumtions,':emissions'=>$emission,':airconditioner'=>$airconditioner,':equipment'=>$equipment]);
        $result = $sql -> getResult();

        $priceUpd = new SQLQuery("UPDATE prices SET price=:price, discount=:discount WHERE carID = :carID",[':price'=>$price,':discount'=>$discount, ':carID'=>$carID]);
        $Priceresult = $priceUpd -> getResult();

        $manufacturNameSQL = new SQLQuery("SELECT * FROM manufactures WHERE manufacturesID = :manID",[':manID'=>$manufacturer]);
        $manresult = $manufacturNameSQL -> getResult();

        foreach($manresult as $item)
        {
            $manufacturName = $item->name;
        }

        $originalName = $_POST['originalName'];
        $newName = $carID." ".$year." ".$manufacturName." ".$modell;

        if($originalName != $newName)
        {
            $originalmanname = $_POST['originalmanname'];
            $directorName = $manufacturName;
            $paths = dirname(getcwd()).'/public_html/images/cars/'.$directorName;
            $fromCopy =  dirname(getcwd()).'/public_html/images/cars/'.$originalmanname;
            
            if(!is_dir($paths))
            {
                mkdir($paths, 0777);
            }

            if(!is_dir($paths.'/'.$newName))
            {
                mkdir($paths.'/'.$newName, 0777);
            }

            $imgCount = count(glob($fromCopy.'/'.$originalName . "/*"));

            for($i = 1;$i<=$imgCount;$i++)
            {
                copy($fromCopy.'/'.$originalName.'/'.$i.'.jpg' , $paths.'/'.$newName.'/'.$i.'.jpg');
                unlink($fromCopy.'/'.$originalName.'/'.$i.'.jpg');
            }

            rmdir($fromCopy.'/'.$originalName);
        }
        
        header('Location: car.php?car='.$carID.'');
    }


    if(isset($_POST['delete_car']))
    {
        $carID = $_POST['carID'];
        $manufacturer = $_POST['manufacturer'];

        $carsql = new SQLQuery("SELECT * FROM cars WHERE carsID = :carid",[':carid'=>$carID]);
        $carresult = $carsql -> getResult();

        foreach($carresult as $cars)
        {
            $year = $cars->releasedate;
            $modell = $cars->carname;
        }

        $manufacturNameSQL = new SQLQuery("SELECT * FROM manufactures WHERE manufacturesID = :manID",[':manID'=>$manufacturer]);
        $manresult = $manufacturNameSQL -> getResult();

        foreach($manresult as $item)
        {
            $manufacturName = $item->name;
        }

        $originalName = $_POST['originalName'];
        $folderName = $carID." ".$year." ".$manufacturName." ".$modell;
        $fromdel =  dirname(getcwd()).'/public_html/images/cars/'.$manufacturName;

        $imgCount = count(glob($fromdel.'/'.$folderName."/*"));

        for($i = 1;$i<=$imgCount;$i++)
        {
            unlink($fromdel.'/'.$originalName.'/'.$i.'.jpg');
        }

        rmdir($fromdel.'/'.$originalName);
        

        
        

        $sql = new SQLQuery("DELETE FROM cars WHERE carsID = :id",[':id'=>$carID]);
        $result = $sql->getResult();

        header('Location: cars.php');
    }

