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

    public function insertUser(array $data)
    {
        $id = $data['id'] ?? null;
        if (!$id) {
        // ClickHouse will generate UUID if not provided by default, 
        // but if we want to return it or use it, we might want to generate it here.
        // Let's rely on ClickHouse default for now.
        }

        $sql = "INSERT INTO users (name, email, password, phone, address, role, status, created_at) VALUES (
            '{$this->escape($data['name'])}',
            '{$this->escape($data['email'])}',
            '{$this->escape($data['password'])}',
            '{$this->escape($data['phone'])}',
            '{$this->escape($data['address'])}',
            '{$this->escape($data['role'] ?? 'user')}',
            '{$this->escape($data['status'] ?? 'pending')}',
            now()
        )";

        return $this->db->execute($sql);
    }

    public function getUserByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = '{$this->escape($email)}' LIMIT 1";
        $results = $this->db->query($sql);
        return !empty($results) ? $results[0] : null;
    }

    public function updateUserByEmail(string $email, array $data)
    {
        $sets = [];
        foreach ($data as $key => $value) {
            $sets[] = "`$key` = '{$this->escape($value)}'";
        }

        $sql = "ALTER TABLE users UPDATE " . implode(', ', $sets) . " WHERE email = '{$this->escape($email)}'";
        return $this->db->execute($sql);
    }

    public function getUsers(int $limit = 10, int $offset = 0, string $search = '', string $sortCol = 'created_at', string $sortDir = 'DESC')
    {
        $where = "";
        if ($search) {
            $search = $this->escape($search);
            $where = "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
        }

        $sql = "SELECT id, name, email, phone, status, created_at FROM users $where ORDER BY $sortCol $sortDir LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    public function countUsers(string $search = '')
    {
        $where = "";
        if ($search) {
            $search = $this->escape($search);
            $where = "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
        }

        $sql = "SELECT count() as total FROM users $where";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function updateStatus(string $id, string $status)
    {
        $sql = "ALTER TABLE users UPDATE status = '{$this->escape($status)}' WHERE id = '{$this->escape($id)}'";
        return $this->db->execute($sql);
    }

    protected function escape($value)
    {
        return addslashes($value);
    }
}
