<?php
header('Content-type: application/json');

$resp = [
    "SoundEnabled" => true,
    "FastPlay" => false,
    "TurboPlay" => false,
    "Intro" => true,
    "Volume" => 1,
    "BetAmount" => 1,
];

echo json_encode($resp);

?>