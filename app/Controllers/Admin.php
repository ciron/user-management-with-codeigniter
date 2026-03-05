<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('userRole') !== 'admin') {
            return redirect()->to('/login');
        }

        return view('admin/users_list', ['title' => 'Admin Panel']);
    }

    public function getUsers()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin');
        }

        $draw = $this->request->getGet('draw');
        $start = $this->request->getGet('start');
        $length = $this->request->getGet('length');
        $search = $this->request->getGet('search')['value'];
        $order = $this->request->getGet('order')[0];

        $columns = ['id', 'name', 'email', 'phone', 'status', 'created_at'];
        $sortCol = $columns[$order['column']] ?? 'created_at';
        $sortDir = $order['dir'] ?? 'DESC';

        $users = $this->userModel->getUsers((int)$length, (int)$start, $search, $sortCol, $sortDir);
        $totalUsers = $this->userModel->countUsers($search);

        return $this->response->setJSON([
            "draw" => intval($draw),
            "recordsTotal" => $totalUsers,
            "recordsFiltered" => $totalUsers,
            "data" => $users
        ]);
    }

    public function updateStatus()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin');
        }

        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        try {
            $this->userModel->updateStatus($id, $status);
            return $this->response->setJSON(['status' => 'success', 'message' => 'User status updated.']);
        }
        catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }
}
