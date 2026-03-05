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
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function ($val) {
            return is_string($val) ? "'" . addslashes($val) . "'" : $val;
        }, array_values($data)));

        $sql = "INSERT INTO users ($columns) VALUES ($values)";
        return $this->db->execute($sql);
    }
}
