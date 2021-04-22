<?php
require_once '../vendor/autoload.php';
require_once '../config/dotenv.php';


$status_array = ['order prepared', 'order was send', 'order accepted'];
$dbh = new PDO("mysql:host=" . getenv("DB_HOST") . "; dbname=" . getenv("DB_NAME"), getenv("DB_USER"), getenv("DB_PASSWORD"));
$query_create_table = "DROP TABLE IF EXISTS order_status; CREATE TABLE `order_status` (
`id` bigint NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `order_status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_name_order_id_uindex` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$stmt = $dbh->prepare($query_create_table);
$stmt->execute();
$query = "INSERT INTO order_status (`order_id`,`order_status`) values (:order_id,:order_status)";
$stmt = $dbh->prepare($query);
for ($i = 1; $i < 40; $i++) {
    $stmt->execute(['order_id' => $i, 'order_status' => $status_array[rand(0, 2)]]);
}

unset($dbh);