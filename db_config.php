<?php
if(defined('SECRET') AND SECRET === "ogGM_pzr3ybW") {
    define("SITE", "https://hash.proj.vts.su.ac.rs/test/pages/");
    define("HOST", "localhost");
    define("USER", "hash");
    define("PASSWORD", "ze6R1JivqbJ2ECz");
    define("DATABASE", "hash");
    //ogGM_pzr3ybW
    try {
        $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE,
            USER, PASSWORD,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'", PDO::ATTR_EMULATE_PREPARES => false]);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}