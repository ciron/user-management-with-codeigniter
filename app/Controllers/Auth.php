<?php

namespace App\Controllers;
use App\Libraries\ClickHouseService;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): string
    {
        return view('auth/login');
    }

    public function signup(): string
    {
        return view('auth/signup');
    }

    public function register()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|min_length[6]|max_length[100]|valid_email',
            'phone' => 'required|min_length[10]|max_length[15]',
            'address' => 'required',
            'password' => 'required|min_length[6]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return "Validation Error: " . implode(', ', $this->validator->getErrors());
        }

        $model = new UserModel();


        if ($model->getUserByEmail($this->request->getPost('email'))) {
            return "Error: Email already registered.";
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'pending'
        ];

        $model->insertUser($data);

        return "Registration successful! Your account is pending admin approval. <a href='/login'>Go to Login</a>";
    }

    public function authenticate()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->getUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'] ?? '')) {
                if (($user['status'] ?? '') !== 'approved') {
                    return "Error: Your account is pending approval.";
                }

                $ses_data = [
                    'userId' => $user['id'],
                    'userName' => $user['name'],
                    'userEmail' => $user['email'],
                    'userRole' => $user['role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);

                return redirect()->to('/dashboard');
            }
        }

        return "Error: Invalid email or password.";
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function adminLogin(): string
    {
        return view('auth/adminlogin');
    }

    public function adminAuthenticate()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->getUserByEmail($email);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'] ?? '')) {
                // Verify role is admin
                if (($user['role'] ?? '') !== 'admin') {
                    return "Error: Unauthorized access. Admin role required.";
                }


                $ses_data = [
                    'userId' => $user['id'],
                    'userName' => $user['name'],
                    'userEmail' => $user['email'],
                    'userRole' => $user['role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);

                return redirect()->to('/admin/dashboard');
            }
        }

        return "Error: Invalid email or password.";
    }

    public function adminLogout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/admin/login');
    }

    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'userName' => $session->get('userName'),
            'userEmail' => $session->get('userEmail'),
            'userRole' => $session->get('userRole')
        ];

        return view('auth/dashboard', $data);
    }

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

        $columns = ['id', 'name', 'email', 'phone', 'status', 'created_at'];
        $orderColumn = $order ? $columns[$order['column']] : 'created_at';
        $orderDir = $order ? $order['dir'] : 'desc';

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
}
