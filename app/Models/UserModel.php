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
        $sql = "SELECT id, name, email, password, role, status FROM users WHERE email = :email LIMIT 1";
        $results = $this->db->query($sql, ['email' => $email]);
        return !empty($results) ? $results[0] : null;
    }

    public function getUserById($id)
    {
        $sql = "SELECT id, name, email, address, phone, status, created_at FROM users WHERE id = :id LIMIT 1";
        $results = $this->db->query($sql, ['id' => $id]);
        return !empty($results) ? $results[0] : null;
    }

    public function insertUser($data)
    {
        if (!isset($data['id'])) {
            $data['id'] = $this->generateUUID();
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";
        return $this->db->execute($sql, $data);
    }

  public function getUsersForDataTable($start, $length, $searchValue, $orderColumn, $orderDir)
{
    $start = (int) $start;
    $length = (int) $length;

    $sql = "SELECT id, name, email, phone, address, status, created_at FROM users WHERE role != 'admin'";

    if (!empty($searchValue)) {
        $searchValue = addslashes($searchValue);
        $sql .= " AND (name LIKE '%$searchValue%' OR email LIKE '%$searchValue%' OR phone LIKE '%$searchValue%')";
    }

    $sql .= " ORDER BY $orderColumn $orderDir LIMIT $length OFFSET $start FORMAT JSON";

    return $this->db->query($sql);
}

    public function countTotalUsers()
    {
        $sql = "SELECT count() AS total FROM users WHERE role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function countFilteredUsers($searchValue)
    {
        $sql = "SELECT count() AS total FROM users WHERE role != 'admin'";
        $params = [];

        if (!empty($searchValue)) {
            $sql .= " AND (name LIKE :search OR email LIKE :search OR phone LIKE :search)";
            $params['search'] = "%$searchValue%";
        }

        $result = $this->db->query($sql, $params);
        return $result[0]['total'] ?? 0;
    }

    public function getPendingUsersCount()
    {
        $sql = "SELECT count() AS total FROM users WHERE status = 'pending' AND role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getActiveUsersCount()
    {
        $sql = "SELECT count() AS total FROM users WHERE status = 'approved' AND role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getNewUsersTodayCount()
    {
        $sql = "SELECT count() AS total FROM users WHERE toDate(created_at) = today() AND role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function updateStatus($id, $status)
    {
        $sql = "ALTER TABLE users UPDATE status = :status WHERE id = :id";
        return $this->db->execute($sql, ['status' => $status, 'id' => $id]);
    }

    public function updateUserProfile($id, $data)
    {
        $sets = [];
        $params = ['id' => $id];

        foreach ($data as $key => $value) {
            $sets[] = "$key = :$key";
            $params[$key] = $value;
        }

        $setStr = implode(', ', $sets);
        $sql = "ALTER TABLE users UPDATE $setStr WHERE id = :id";
        return $this->db->execute($sql, $params);
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