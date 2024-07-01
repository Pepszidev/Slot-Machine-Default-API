<?php

$defaultConfig = [
    "SoundEnabled" => true,
    "FastPlay" => false,
    "TurboPlay" => false,
    "Intro" => true,
    "Volume" => 1,
    "BetAmount" => 1,
];

$initialBalance = 100;

function clearFloat($floatText) {
    if(is_string($floatText)) {
        return floatval(str_replace(',', '.', $floatText));
    }
    else {
        return floatval($floatText);
    }
   
}