<?php

namespace App\Controllers;
use App\Libraries\ClickHouseService;
use App\Models\UserModel;

class Admin extends BaseController
{


    public function adminDashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('userRole') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $model = new UserModel();

        $data = [
            'adminName' => $session->get('userName'),
            'adminEmail' => $session->get('userEmail'),
            'pendingCount' => $model->getPendingUsersCount(),
            'activeCount' => $model->getActiveUsersCount(),
            'newTodayCount' => $model->getNewUsersTodayCount()
        ];

        return view('admin/adminDashboard', $data);
    }

    public function userlist()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('userRole') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        $model = new UserModel();

        $data = [
            'adminName' => $session->get('userName'),
            'adminEmail' => $session->get('userEmail'),
            'pendingCount' => $model->getPendingUsersCount(),
            'activeCount' => $model->getActiveUsersCount(),
            'newTodayCount' => $model->getNewUsersTodayCount()
        ];

        return view('admin/userlist', $data);
    }

    public function getUsers()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('userRole') !== 'admin') {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $model = new UserModel();
        $start = $this->request->getVar('start') ?? 0;
        $length = $this->request->getVar('length') ?? 10;
        $search = $this->request->getVar('search')['value'] ?? '';
        $order = $this->request->getVar('order')[0] ?? null;

        $columns = ['id', 'name', 'email', 'phone', 'address', 'status', 'created_at'];
        $colIndex = $order ? (int)$order['column'] : 6; // default: created_at
        $orderColumn = isset($columns[$colIndex]) ? $columns[$colIndex] : 'created_at';
        $orderDir = ($order && strtolower($order['dir']) === 'asc') ? 'asc' : 'desc';

        $users = $model->getUsersForDataTable($start, $length, $search, $orderColumn, $orderDir);
        $total = $model->countTotalUsers();
        $filteredTotal = $model->countFilteredUsers($search);

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                $user['id'],
                $user['name'],
                $user['email'],
                $user['phone'],
                $user['address'],
                $user['status'],
                $user['created_at'],
                '' // For actions
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($this->request->getVar('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $filteredTotal,
            'data' => $data
        ]);
    }

    public function updateStatus()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('userRole') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (empty($id) || empty($status)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid parameters']);
        }

        $model = new UserModel();
        $model->updateStatus($id, $status);

        return $this->response->setJSON(['status' => 'success', 'message' => 'User status updated to ' . $status]);
    }

    public function getUserById($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('userRole') !== 'admin') {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $model = new UserModel();
        $user = $model->getUserById($id);

        if (!$user) {
            return $this->response->setJSON(['error' => 'User not found'])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $user
        ]);
    }





    public function adminLogout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/admin/login');
    }
}
