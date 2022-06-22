<?php

include "config.php";


    if(isset($_POST['email']))
    {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $phone = $_POST['phone'];
        $birthdate = $_POST['birthdate'];
        $licenseplace = $_POST['licenseplace'];
        $idcardNum = $_POST['idcardNum'];
        $licenseNum = $_POST['licenseNum'];
        $level = $_POST['level'];
        $username = UserSystem::getUsernameFromEmail($email);

        $sql = new SQLQuery("UPDATE users SET username=:username, email=:email, lastname=:lastname, firstname=:firstname, phonenumber=:phone, birthdate=:birthdate, idcardNumber=:idcardNum, licensecardNumber=:licensecardNum, licensecardPlace=:licensePlace, level=:level WHERE usersID = :id", [':username'=>$username,':id'=>$id,':email'=>$email,':lastname'=>$lastname,':firstname'=>$firstname,':phone'=>$phone,':birthdate'=>$birthdate,':idcardNum'=>$idcardNum, ':licensecardNum'=>$licenseNum, ':licensePlace'=>$licenseplace, ':level'=>$level]);
        $result = $sql -> getResult();

        if($result){
            return "Data";
        }
    }
