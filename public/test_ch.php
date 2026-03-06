<?php
require '/var/www/ci4_project/vendor/autoload.php';
$client = new \ClickHouseDB\Client(['host' => '127.0.0.1', 'port' => 8123, 'username' => 'default', 'password' => 'admin']);
$client->database('ci4_clickhouse');
try {
    print_r($client->select("DESCRIBE TABLE users")->rows());
}
catch (\Exception $e) {
    echo "ClickHouse Error: " . $e->getMessage();
}
