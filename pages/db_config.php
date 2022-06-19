<?php
if(defined('SECRET') AND SECRET === "ogGM_pzr3ybW") {
    define("SITE", "http://localhost/Carrent/pages/");
    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("DATABASE", "car");
    //ogGM_pzr3ybW
    try {
        $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE,
            USER, PASSWORD,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'", PDO::ATTR_EMULATE_PREPARES => false]);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}