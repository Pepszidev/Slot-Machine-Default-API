<?php

$initialBalance = 100;
$nbReels = 5;
$nbLines = 3;
$nbSymbols = 5;

$defaultConfig = [
    "SoundEnabled" => true,
    "FastPlay" => false,
    "TurboPlay" => false,
    "Intro" => true,
    "Volume" => 1,
    "BetAmount" => 1,
];

function clearFloat($floatText) {
    if(is_string($floatText)) {
        return floatval(str_replace(',', '.', $floatText));
    }
    else {
        return floatval($floatText);
    }
   
}