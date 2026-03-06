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

    public function getUsersForDataTable($start, $length, $searchValue, $orderColumn, $orderDir)
    {
        $sql = "SELECT id, name, email, phone, status, created_at FROM users";

        $where = " WHERE role != 'admin'"; // Exclude admins from the list if desired
        if (!empty($searchValue)) {
            $searchValue = addslashes($searchValue);
            $where .= " AND (name LIKE '%$searchValue%' OR email LIKE '%$searchValue%' OR phone LIKE '%$searchValue%')";
        }

        $sql .= $where;
        $sql .= " ORDER BY $orderColumn $orderDir";
        $sql .= " LIMIT $start, $length";

        return $this->db->query($sql);
    }

    public function countTotalUsers()
    {
        $sql = "SELECT count() as total FROM users WHERE role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function countFilteredUsers($searchValue)
    {
        $sql = "SELECT count() as total FROM users WHERE role != 'admin'";
        if (!empty($searchValue)) {
            $searchValue = addslashes($searchValue);
            $sql .= " AND (name LIKE '%$searchValue%' OR email LIKE '%$searchValue%' OR phone LIKE '%$searchValue%')";
        }
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getPendingUsersCount()
    {
        $sql = "SELECT count() as total FROM users WHERE status = 'pending' AND role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getActiveUsersCount()
    {
        $sql = "SELECT count() as total FROM users WHERE status = 'approved' AND role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getNewUsersTodayCount()
    {
        $sql = "SELECT count() as total FROM users WHERE toDate(created_at) = today() AND role != 'admin'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function updateStatus($id, $status)
    {
        $sql = "ALTER TABLE users UPDATE status = '$status' WHERE id = '$id'";
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
