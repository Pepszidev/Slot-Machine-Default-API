<?php
header('Content-type: application/json');
// Start the session
session_start();
ob_start();
/* @TODO Calculate result from database data */

$betAmount = $_SESSION["betAmount"];

$lines = [
    /* 1
    * * * * *
    - - - - -
    * * * * *
    */
    [
        [0, 1],
        [1, 1],
        [2, 1],
        [3, 1],
        [4, 1],
    ],
    /* 2
    - - - - -
    * * * * *    
    * * * * *
    */
    [
        [0, 0],
        [1, 0],
        [2, 0],
        [3, 0],
        [4, 0],
    ],
    /* 3
    - - - - -
    * * * * *
    * * * * *
    */
    [
        [0, 2],
        [1, 2],
        [2, 2],
        [3, 2],
        [4, 2],
    ],
    /* 4
    - * * * -
    * - * - *
    * * - * *
    */
    [
        [0, 0],
        [1, 1],
        [2, 2],
        [3, 1],
        [4, 0],
    ],
    /* 5
    * * - * *
    * - * - *
    - * * * -
    */
    [
        [0, 2],
        [1, 1],
        [2, 0],
        [3, 1],
        [4, 2],
    ],
    /* 6
    * - - - *
    - * * * -
    * * * * *
    */
    [
        [0, 1],
        [1, 0],
        [2, 0],
        [3, 0],
        [4, 1],
    ],
    /* 7
    * * * * *
    - * * * -
    * - - - *
    */
    [
        [0, 1],
        [1, 2],
        [2, 2],
        [3, 2],
        [4, 1],
    ],
];

$winBySymbol = [
    [
        0,
        0,
        1,
        2,
        3
    ],
    [
        0,
        0,
        1,
        2,
        3
    ],
    [
        0,
        0,
        1,
        2,
        3
    ],
    [
        0,
        0,
        1,
        2,
        3
    ],
    [
        0,
        0,
        1,
        2,
        3
    ]
];
/* Simulate result */
$gameData = [
    "win"=> true, 
    "winAmount"=> 36,
];

$currentGame = NULL;

if(isset($_SESSION["gameData"])) {
    $currentGame = $_SESSION["gameData"];

    $hasWin = false;
    $winAmount = 0;

    foreach($currentGame["spinResult"]["winSymbols"] as $reelWinSymbols) {
        if(count($reelWinSymbols["reelWinSymbols"]) == 0) continue;
        $hasWin = true;

        $firstSymbol = $reelWinSymbols["reelWinSymbols"][0];
        
        $symbol = $reelWinSymbols["reelWinSymbols"][0]["symbol"];

        $nbConnection = $reelWinSymbols["reelWinSymbols"][0]["nbConnection"];
        $winAmount += $winBySymbol[$symbol - 1][$nbConnection - 1];
    }
    
    $gameData["winAmount"] = ($winAmount * $betAmount);
    $gameData["win"] = $hasWin;    
}
else {
    $gameData["win"] = false;
    $gameData["winAmount"] = 0;
}

$_SESSION["balance"] += $gameData["winAmount"];
$resp = $gameData;


echo json_encode($resp);

?>