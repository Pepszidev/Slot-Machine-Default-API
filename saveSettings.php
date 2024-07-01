<?php
include('config/defaultSettings.php');

header('Content-type: application/json');

session_start();
ob_start();

$resp = NULL;

if(!isset($_SESSION["settings"]) || is_null($_SESSION["settings"]["SoundEnabled"])) {
    $resp = $defaultConfig;    
}
else {
    $resp = [
        "SoundEnabled" => $_POST["SoundEnabled"],
        "FastPlay" => $_POST["FastPlay"],
        "TurboPlay" => $_POST["TurboPlay"],
        "Intro" => $_POST["Intro"],
        "Volume" => $_POST["Volume"],
        "BetAmount" => $_POST["BetAmount"],
    ];
    $_SESSION["settings"] = $resp;
}

$_SESSION["settings"] = $resp;

echo json_encode($resp);

?>