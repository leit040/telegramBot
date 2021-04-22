<?php
require_once '../vendor/autoload.php';
require_once '../config/dotenv.php';

$json = json_decode(file_get_contents('php://input'), true);
$dbh = new PDO("mysql:host=" . getenv("DB_HOST") . "; dbname=" . getenv("DB_NAME"), getenv("DB_USER"), getenv("DB_PASSWORD"));
$sth = $dbh->prepare("SELECT order_status FROM order_status WHERE order_id=?");

$sth->execute([$json['message']['text']]);
$status = $sth->fetchColumn();
$data['chat_id'] = $json['message']['chat']['id'];

if($status!=null){
$data['text'] = "Your order (#" . $json['message']['text'] . ") now have  status  '" . $status . "'";
}
else{
    $data['text'] = "I can't find your order number ".$json['message']['text'].". Please give me correct order number!";
}
file_get_contents('https://api.telegram.org/bot' . getenv("API_TOKEN") . '/sendMessage?' . http_build_query($data));

