<?php
include('config/defaultSettings.php');

header('Content-type: application/json');

session_start();
ob_start();

$resp = NULL;

if(!isset($_SESSION["settings"]) || is_null($_SESSION["settings"]["SoundEnabled"]) || floatval($_POST["BetAmount"]) == 0) {
    $resp = $defaultConfig;    
}
else {
    $resp = [
        "SoundEnabled" => boolval($_POST["SoundEnabled"]),
        "FastPlay" => boolval($_POST["FastPlay"]),
        "TurboPlay" => boolval($_POST["TurboPlay"]),
        "Intro" => boolval($_POST["Intro"]),
        "Volume" => floatval($_POST["Volume"]),
        "BetAmount" => floatval($_POST["BetAmount"]),
    ];
}

$_SESSION["settings"] = $resp;

$resp["test"] = $_POST;

echo json_encode($resp);

?>