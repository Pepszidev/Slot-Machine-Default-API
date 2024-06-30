<?php
header('Content-type: application/json');

/* @TODO Calculate result from database data */

/* Simulate result */
$gameData = [
    "win"=> true, 
    "winAmount"=> 36,
];

$resp = $gameData;


echo json_encode($resp);

?>