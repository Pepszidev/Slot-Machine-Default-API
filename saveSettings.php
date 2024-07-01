<?php
include('config/defaultSettings.php');

header('Content-type: application/json');

session_start();
ob_start();

$resp = NULL;
$reset = false;

//Initialize settings on first connection
if(!isset($_SESSION["settings"]) || $reset) {
    $resp = $defaultConfig;    
}
// If the bet amount != 0 => That means the user is updating its config
else if(clearFloat($_POST["BetAmount"]) != 0) {
    $resp = [
        "SoundEnabled" => boolval($_POST["SoundEnabled"]),
        "FastPlay" => boolval($_POST["FastPlay"]),
        "TurboPlay" => boolval($_POST["TurboPlay"]),
        "Intro" => boolval($_POST["Intro"]),
        "Volume" => clearFloat($_POST["Volume"]),
        "BetAmount" => clearFloat($_POST["BetAmount"]),
    ];
}
// Just retrieve session on first connection if its exist
else {
    $resp = [
        "SoundEnabled" => boolval($_SESSION['settings']["SoundEnabled"]),
        "FastPlay" => boolval($_SESSION['settings']["FastPlay"]),
        "TurboPlay" => boolval($_SESSION['settings']["TurboPlay"]),
        "Intro" => boolval($_SESSION['settings']["Intro"]),
        "Volume" => clearFloat($_SESSION['settings']["Volume"]),
        "BetAmount" => clearFloat($_SESSION['settings']["BetAmount"]),
    ];
}

$_SESSION["settings"] = $resp;

$resp["test"] = $_POST;

echo json_encode($resp);

?>