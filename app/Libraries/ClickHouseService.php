<?php

namespace App\Libraries;

use ClickHouseDB\Client;

class ClickHouseService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => '127.0.0.1',
            'port' => 8123,        // ← HTTP port (not 9000)
            'username' => 'default',
            'password' => 'admin',
        ]);

        $this->client->database('ci4_clickhouse');
    }

    public function query(string $sql)
    {
        return $this->client->select($sql)->rows();
    }

    public function execute(string $sql)
    {
        $this->client->write($sql);
    }
}