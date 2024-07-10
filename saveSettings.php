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
// If the bet amount is set => That means its an update
else if(isset($_POST["BetAmount"])) {
    $resp = [
        "SoundEnabled" => filter_var($_POST["SoundEnabled"], FILTER_VALIDATE_BOOLEAN),
        "FastPlay" => filter_var($_POST["FastPlay"], FILTER_VALIDATE_BOOLEAN),
        "TurboPlay" => filter_var($_POST["TurboPlay"], FILTER_VALIDATE_BOOLEAN),
        "Intro" => filter_var($_POST["Intro"], FILTER_VALIDATE_BOOLEAN),       
        "Volume" => clearFloat($_POST["Volume"]),
        "BetAmount" => clearFloat($_POST["BetAmount"]),
    ];
    $resp["settings_update"] = $_POST;

}
// If it's not set => call for init
else {
    $resp = [
        "SoundEnabled" => $_SESSION['settings']["SoundEnabled"],
        "FastPlay" => $_SESSION['settings']["FastPlay"],
        "TurboPlay" => $_SESSION['settings']["TurboPlay"],
        "Intro" => $_SESSION['settings']["Intro"],
        "Volume" => clearFloat($_SESSION['settings']["Volume"]),
        "BetAmount" => clearFloat($_SESSION['settings']["BetAmount"]),
    ];
    $resp["settings_session"] = $_POST;
}

$_SESSION["settings"] = $resp;


echo json_encode($resp);

?>