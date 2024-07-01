<?php

include('config/defaultSettings.php');

header('Content-type: application/json');

session_start();
ob_start();



if(!isset($_SESSION["balance"]) || clearFloat($_SESSION["balance"]) <= 10) {
    $_SESSION["balance"] = $initialBalance;
}

$resp = [
    "Balance" => clearFloat($_SESSION["balance"])
];

echo json_encode($resp);

?>