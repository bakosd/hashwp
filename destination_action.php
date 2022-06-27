<?php

include "config.php";

if(isset($_POST['add_dest']))
{
    $city = $_POST['city'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $workdaystart = $_POST['workday_start'];
    $workdayend = $_POST['workday_end'];
    $weekendstart = $_POST['weekend_start'];
    $weekendend = $_POST['weekend_end'];

    $workday = $workdaystart." - ".$workdayend;
    $weekendend = $weekendstart." - ".$weekendend;
    
    $sql = new SQLQuery("INSERT INTO places (city, address, phone, email, workday, weekend) VALUES (:city, :address, :phone, :email, :workday, :weekend)",[':city'=>$city,':address'=>$address,':phone'=>$phone,':email'=>$email,':workday'=>$workday,':weekend'=>$weekendend]);
    $result = $sql -> getResult();

    $id = $sql->lastInsertId;

    $citySQL=new SQLQuery("SELECT * FROM places WHERE placesID = :id",[':id'=>$id]);
    $cityResult = $citySQL -> getResult();

    foreach($cityResult as $cityn)
    {
        $cityname=$cityn->city;
    }
    $folderName = $cityname.$id;

    $path = dirname(getcwd()).'/public_html/images/offices/'.$folderName;

    if(!is_dir($path))
    {
        mkdir($path, 0777);
    }
    $nameCount=0;
    foreach($_FILES['image']['tmp_name'] as $key => $value)
    {
        $nameCount++;
        $format = array('jpg');
        $imageName = $_FILES['image']['name'][$key];
        $imageSize = $_FILES['image']['size'][$key];
        $imageTmp = $_FILES['image']['tmp_name'][$key];
        $imageType = pathinfo($path.'/'.$imageName, PATHINFO_EXTENSION);
        
        $newName=$nameCount.'.'.$imageType;

        if(!empty($imageName) && !in_array($imageType, $format))
        {
            
        }
        else
        {
            move_uploaded_file($imageTmp, $path.'/'.$newName);
        }
    }
    header('Location: destinations.php');
}


if(isset($_POST['upd_dest']))
{
    $id = $_POST['ID'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $workdaystart = $_POST['workday_start'];
    $workdayend = $_POST['workday_end'];
    $weekendstart = $_POST['weekend_start'];
    $weekendend = $_POST['weekend_end'];

    $originalname = $_POST['originalName'];
    
    

    $workday = $workdaystart." - ".$workdayend;
    $weekendend = $weekendstart." - ".$weekendend;

    $sql = new SQLQuery("UPDATE places SET city = :city, address = :address, phone = :phone, email = :email, workday = :workday, weekend = :weekend WHERE placesID = :id",[':id'=>$id,':city'=>$city,':address'=>$address,':phone'=>$phone,':email'=>$email,':workday'=>$workday,':weekend'=>$weekendend]);
    $result = $sql -> getResult();

    $newName = $city.$id;

    if($originalname != $newName)
    {
        $path = dirname(getcwd()).'/public_html/images/offices/'.$newName;
        $fromCopy =  dirname(getcwd()).'/public_html/images/offices/'.$originalname;

        if(!is_dir($path))
            {
                mkdir($path, 0777);
            }


            $imgCount = count(glob($fromCopy. "/*"));

            for($i = 1;$i<=$imgCount;$i++)
            {
                copy($fromCopy.'/'.$i.'.jpg' , $path.'/'.$i.'.jpg');
                unlink($fromCopy.'/'.$i.'.jpg');
            }
            rmdir($fromCopy);
    }
    header('Location: destinations.php');
}

if(isset($_POST['del_dest']))
{
    $id = $_POST['ID'];

    
    $selectsql = new SQLQuery("SELECT * FROM places WHERE placesID = :id",[':id'=>$id]);
    $selectresult = $selectsql -> getResult();
    foreach($selectresult as $select)
    {
        $city = $select->city;
    }
    $folderName = $city.$id;
    $mainfolder = dirname(getcwd()).'/public_html/images/offices/'.$folderName;
    $imgCount = count(glob($mainfolder. "/*"));
    for($i = 1;$i<=$imgCount;$i++)
    {
        unlink($mainfolder.'/'.$i.'.jpg');
    }

    rmdir($mainfolder);

    $sql = new SQLQuery("DELETE FROM places WHERE placesID= :id",[':id'=>$id]);
    $result = $sql -> getResult();


    header('Location: destinations.php');
}


