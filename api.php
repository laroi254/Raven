<?php

ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

header('content-type: application/json');

if (!isset($_GET['cmd'], $_GET['card'])) exit;

require_once 'config.php';
require_once 'telegram.php';

// Updated bot credentials
$bot = new TelegramBot(
    '7423919758:AAFQQD9C7K7bGPkkNT7sJi0KPd4zZ1OtbQw', // BOT_TOKEN
    '-1002301782430', // BOT_LOGS
    '-1002301782430' // BOT_GROUP
);

// Updated database credentials
$bot->dbInfo('localhost', 'Amkush', 'Amkush', 'Amkush');

require 'classes/CurlX.php';
require 'classes/Response.php';
require 'classes/Tools.php';
require 'classes/Generator.php';

$curlx = new CurlX;
$response = new Response;
$tools = new Tools;
$generator = new GenCard;

$bot->setChkAPI($curlx, $response, $tools);

$gate = $bot->fetchGate($_GET['cmd']);

if ($gate) {
    $lista = $bot->getCards($_GET['card'])[0];

    $extra = empty($gate['extra']) ? '' : json_decode($gate['extra']);

    $result = $bot->chkAPI($gate['file'], $lista, $extra);

    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    die();
}
?>
