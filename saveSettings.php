<?php
include('config/defaultSettings.php');

header('Content-type: application/json');

session_start();
ob_start();

$resp = NULL;

//Initialize settings on first connection
if(!isset($_SESSION["settings"])) {
    $resp = $defaultConfig;    
}
// If the bet amount != 0 => That means the user is updating its config
else if(floatval($_POST["BetAmount"]) != 0) {
    $resp = [
        "SoundEnabled" => boolval($_POST["SoundEnabled"]),
        "FastPlay" => boolval($_POST["FastPlay"]),
        "TurboPlay" => boolval($_POST["TurboPlay"]),
        "Intro" => boolval($_POST["Intro"]),
        "Volume" => floatval($_POST["Volume"]),
        "BetAmount" => floatval($_POST["BetAmount"]),
    ];
}
// Just retrieve session on first connection if its exist
else {
    $resp = [
        "SoundEnabled" => boolval($_SESSION['settings']["SoundEnabled"]),
        "FastPlay" => boolval($_SESSION['settings']["FastPlay"]),
        "TurboPlay" => boolval($_SESSION['settings']["TurboPlay"]),
        "Intro" => boolval($_SESSION['settings']["Intro"]),
        "Volume" => floatval($_SESSION['settings']["Volume"]),
        "BetAmount" => floatval($_SESSION['settings']["BetAmount"]),
    ];
}

$_SESSION["settings"] = $resp;

$resp["test"] = $_POST;

echo json_encode($resp);

?>