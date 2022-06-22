<?php

    include "config.php";

    if(isset($_POST['id']))
    {

        $id = $_POST['id'];

        $sql = new SQLQuery("DELETE FROM users WHERE usersID = :id",[':id'=>$id]);
        $result = $sql -> getResult();

    }

    

