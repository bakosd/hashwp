<?php

    include "config.php";
    $session = new Session();
    if(isset($_POST['id']) && $session->get('level') > 2)
    {
        $id = $_POST['id'];
        $sql = new SQLQuery("DELETE FROM users WHERE usersID = :id",[':id'=>$id]);
//        $result = $sql -> getResult();
        if ($sql->getDbq()->rowCount() > 0)
            echo "success";
        else
            echo "error";
    }

    

