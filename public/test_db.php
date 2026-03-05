<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Libraries/ClickHouseService.php';

use App\Libraries\ClickHouseService;

try {
    $db = new ClickHouseService();
    echo "Connected successfully to ClickHouse.\n";

    echo "Columns in 'users' table:\n";
    $columns = $db->query("DESCRIBE TABLE users");
    foreach ($columns as $column) {
        echo "- {$column['name']} ({$column['type']})\n";
    }
}
catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
