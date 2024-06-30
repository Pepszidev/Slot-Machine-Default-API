<?php
header('Content-type =>  application/json');
// Start the session
session_start();

$spinResult = ["reels" => [], "winSymbols" => []];

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

/* 
Generate a random symbol between 1 and 2 
*/
for($x = 0; $x < 5; ++$x) {
    $spinResult["reels"][] = ["reel" => []];
    
    for($y = 0; $y < 30; ++$y) {
        $spinResult["reels"][$x]["reel"][] = random_int(1, 5);        
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

foreach($lines as $line) {
    
    $firstSymbolIndex = count($spinResult["reels"][$line[0][0]]["reel"]) - 1 - $line[0][1];
    $firstSymbol = $spinResult["reels"][$line[0][0]]["reel"][$firstSymbolIndex];

    $connections = [
        [
            "x" =>  $line[0][0], 
            "y" =>  $line[0][1], 
            "symbol" => $firstSymbol
        ]
    ];

    for($x = 1; $x < 5; ++$x) {
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

    if(count($connections) >= 3) {
        foreach($connections as $key => $connectionReel) {
            $spinResult["winSymbols"][$key]["reelWinSymbols"][] = $connectionReel;
        }        
    }
}

/* @TODO
Make sure to save data in db to be able to retrieve it through the doCollect route 
Total result is calculated later via doCollect
*/

$gameData = [
    "spinResult" => $spinResult,
];
$_SESSION["gameData"] = $gameData;

$resp = $gameData["spinResult"];


echo json_encode($resp);

?>