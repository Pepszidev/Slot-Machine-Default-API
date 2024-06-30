<?php
header('Content-type: application/json');
session_start();
ob_start();

$initialBalance = 100;

if(!isset($_SESSION["balance"]) || $_SESSION["balance"] <= 10) {
    $_SESSION["balance"] = $initialBalance;
}

$resp = [
    "Balance" => $_SESSION["balance"]
];

echo json_encode($resp);

?>