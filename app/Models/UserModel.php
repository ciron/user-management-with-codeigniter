<?php

namespace App\Models;

use App\Libraries\ClickHouseService;

class UserModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new ClickHouseService();
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT id, name, email, password, role, status FROM users WHERE email = " . $this->escape($email) . " LIMIT 1";
        $results = $this->db->query($sql);
        return !empty($results) ? $results[0] : null;
    }

    private function escape($value)
    {
        return "'" . addslashes($value) . "'";
    }

    public function insertUser($data)
    {
        if (!isset($data['id'])) {
            $data['id'] = $this->generateUUID();
        }

        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function ($val) {
            if (is_numeric($val) && !is_string($val))
                return $val;
            return "'" . addslashes($val) . "'";
        }, array_values($data)));

        $sql = "INSERT INTO users ($columns) VALUES ($values)";
        return $this->db->execute($sql);
    }

    private function generateUUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
