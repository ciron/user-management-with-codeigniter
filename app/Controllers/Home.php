<?php

namespace App\Controllers;
use App\Libraries\ClickHouseService;

class Home extends BaseController
{
     public function index(): string
    {
        try {
             $ch = new ClickHouseService();

        // Example: Create table if not exists
        $ch->execute("
            CREATE TABLE IF NOT EXISTS users (
                id UInt32,
                name String,
                created_at DateTime
            ) ENGINE = MergeTree()
            ORDER BY id
        ");

        // Insert sample data
        $ch->execute("
            INSERT INTO users (id, name, created_at) VALUES (1, 'Chironjit', now())
        ");

            // Example: fetch data
            $data['users'] = $ch->query("SELECT * FROM users");

            return view('welcome_message', $data);

        } catch (\Exception $e) {
            // Show the real error
            return "Error: " . $e->getMessage();
        }
    }
}
