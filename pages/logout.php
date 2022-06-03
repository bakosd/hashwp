<?php
require_once "config.php";
$session = new Session();
if($session->clear())
    redirection($_SERVER["HTTP_REFERER"]);
else
    redirection('index.php?log=11');
