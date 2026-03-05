<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Libraries/ClickHouseService.php';

use App\Libraries\ClickHouseService;

$db = new ClickHouseService();
$res = $db->query("SHOW CREATE TABLE users");
echo $res[0]['statement'] . "\n";
