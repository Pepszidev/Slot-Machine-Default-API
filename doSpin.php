<?php
include 'config/winningLines.php';
include 'config/winningSymbols.php';
include 'config/defaultSettings.php';

header('Content-type =>  application/json');

// Start the session
session_start();
ob_start();

$betAmount = clearFloat($_POST["betAmount"]);
$spinResult = ["reels" => [], "winSymbols" => []];

/* 
Generate a random symbol between 1 and Config.NbSymbols 
*/
for($x = 0; $x < $nbReels; ++$x) {
    $spinResult["reels"][] = ["reel" => []];
    
    for($y = 0; $y < 30; ++$y) {
        $spinResult["reels"][$x]["reel"][] = random_int(1, $nbSymbols);        
    }
}

/*
Let's define the winning symbol positions so front can animate it
*/
$spinResult["winSymbols"] = [];

$spinResult["winSymbols"][] = ["reelWinSymbols" => []];
$spinResult["winSymbols"][] = ["reelWinSymbols" => []];
$spinResult["winSymbols"][] = ["reelWinSymbols" => []];
$spinResult["winSymbols"][] = ["reelWinSymbols" => []];
$spinResult["winSymbols"][] = ["reelWinSymbols" => []];

foreach($lines as $key => $line) {
    
    $firstSymbolIndex = count($spinResult["reels"][$line[0][0]]["reel"]) - 1 - $line[0][1];
    $firstSymbol = $spinResult["reels"][$line[0][0]]["reel"][$firstSymbolIndex];

    $connections = [
        [
            "x" =>  $line[0][0], 
            "y" =>  $line[0][1], 
            "symbol" => $firstSymbol
        ]
    ];

    for($x = 1; $x < $nbReels; ++$x) {
        $symbolIndex = count($spinResult["reels"][$line[$x][0]]["reel"]) - 1 - $line[$x][1];
        $symbol = $spinResult["reels"][$line[$x][0]]["reel"][$symbolIndex];
        if($symbol != $firstSymbol) {
            break;
        }
        $connections[] = [
            "x" =>  $line[$x][0], 
            "y" =>  $line[$x][1], 
            "symbol" => $symbol
        ];
    }

    if(count($connections) >= $nbLines) {
        
        foreach($connections as $reelId => $connectionReel) {
            $connectionReel["lineId"] = $key;
            $connectionReel["nbConnection"] = count($connections);
            $spinResult["winSymbols"][$reelId]["reelWinSymbols"][] = $connectionReel;
        }        
    }
}

$winAmount = 0;
$win = false;
$firstReel = $spinResult["winSymbols"][0]["reelWinSymbols"];
if(count($firstReel) == 0) {
    $winAmount = 0;
    $win = false;  
}
else {
    foreach($firstReel as $symbol) {
        if(intval($symbol["x"]) != 0) continue;
        $symbolIndex = $symbol["symbol"];

        $nbConnection = $symbol["nbConnection"];
        $winAmount += $winBySymbol[$symbolIndex - 1][$nbConnection - 1];
    }
    $winAmount = ($winAmount * $betAmount);
    $win = true;   
}

/* @TODO
Make sure to save data in db to be able to retrieve it through the doCollect route 
Total result is calculated later via doCollect
*/

$spinResult["win"] = $win;
$spinResult["winAmount"] = $winAmount;
$spinResult["betAmount"] = $betAmount;

$gameData = [
    "spinResult" => $spinResult,
    "betAmount" => $betAmount,
    "collected" => false,
];

$_SESSION["gameData"] = $gameData;
$_SESSION["balance"] -= $betAmount;


$resp = $gameData["spinResult"];

echo json_encode($resp);

?>