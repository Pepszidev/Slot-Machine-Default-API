<?php
header('Content-type: application/json');
// Start the session
session_start();
/* @TODO Calculate result from database data */

/* Simulate result */
$gameData = [
    "win"=> true, 
    "winAmount"=> 36,
];
$currentGame = NULL;

if(isset($_SESSION["gameData"])) {
    $currentGame = $_SESSION["gameData"];

    $hasWin = false;
    
    foreach($currentGame["spinResult"]["winSymbols"] as $reelWinSymbols) {
        if(count($reelWinSymbols["reelWinSymbols"]) > 0) {
            $hasWin = true;
            break;
        }
    }

    if($hasWin) {
        $gameData["win"] = true;
        $gameData["winAmount"] = 36;
    }
    else {
        $gameData["win"] = false;
        $gameData["winAmount"] = 0;
    }
}
else {
    $gameData["win"] = false;
    $gameData["winAmount"] = 0;
}

$resp = $gameData;


echo json_encode($resp);

?>