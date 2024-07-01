<?php
include 'config/winningLines.php';
include 'config/winningSymbols.php';
include 'config/defaultSettings.php';

header('Content-type: application/json');

// Start the session
session_start();
ob_start();

$gameData = [
    "win"=> false, 
    "winAmount"=> 0,
];

$currentGame = NULL;
$betAmount = 0;

if(isset($_SESSION["gameData"])) {
    $currentGame = $_SESSION["gameData"];
    $betAmount = clearFloat($currentGame["betAmount"]);

    $winAmount = 0;

    $firstReel = $currentGame["spinResult"]["winSymbols"][0]["reelWinSymbols"];
    if(count($firstReel) == 0) {
        $gameData["winAmount"] = 0;
        $gameData["win"] = false;  
    }
    else {
        foreach($firstReel as $symbol) {
            if(intval($symbol["x"]) != 0) continue;
            $symbolIndex = $symbol["symbol"];

            $nbConnection = $symbol["nbConnection"];
            $winAmount += $winBySymbol[$symbolIndex - 1][$nbConnection - 1];
        }
        $gameData["winAmount"] = ($winAmount * $betAmount);
        $gameData["win"] = true;   
    }     
}
else {
    $gameData["win"] = false;
    $gameData["winAmount"] = 0;
}

$_SESSION["balance"] += $gameData["winAmount"];
$resp = $gameData;


echo json_encode($resp);

?>