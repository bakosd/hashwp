<?php
$id = "1";
$carname = "Ferrari Italy 486";
$message_type = "recovery";
$site = "order.php";
$token = "?token=asdadad";
$archive_code = "2192-4962-1952";
$firstname= "";
$lastname= "";
require_once "config.php";
echo getHTMLFormattedMessage($message_type, $lastname, $firstname, $site, $token, $carname, $id, $archive_code);
