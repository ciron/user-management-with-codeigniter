<?php

namespace App\Controllers;
use App\Libraries\ClickHouseService;
use App\Models\UserModel;

class User extends BaseController
{

    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

   
        if ($session->get('userRole') !== 'user') {
            return redirect()->to('/admin/dashboard');
        }

        $model = new UserModel();
        $user = $model->getUserById($session->get('userId'));

        $data = [
            'userName' => $user['name'] ?? $session->get('userName'),
            'userEmail' => $user['email'] ?? $session->get('userEmail'),
            'userPhone' => $user['phone'] ?? '',
            'userRole' => $user['role'] ?? $session->get('userRole'),
            'user' => $user
        ];

        return view('user/dashboard', $data);
    }

    public function profile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($session->get('userRole') !== 'user') {
            return redirect()->to('/admin/dashboard');
        }

        $model = new UserModel();
        $user = $model->getUserById($session->get('userId'));

        $data = [
            'userName' => $user['name'] ?? $session->get('userName'),
            'userEmail' => $user['email'] ?? $session->get('userEmail'),
            'userstatus' => $user['status'] ?? '',
            'userPhone' => $user['phone'] ?? '',
            'userAddress' => $user['address'] ?? '',            
            'userRole' => $user['role'] ?? $session->get('userRole'),
            'user' => $user
        ];

        return view('user/profile', $data);
    }

    public function updateProfile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        
        if ($session->get('userRole') !== 'user') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Forbidden'])->setStatusCode(403);
        }

        $userId = $session->get('userId');
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

      
        if (empty($name) || strlen($name) < 3) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Name must be at least 3 characters long']);
        }

        if (!empty($password)) {
            if (strlen($password) < 6) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Password must be at least 6 characters long']);
            }
            if ($password !== $confirmPassword) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Passwords do not match']);
            }
        }

        $updateData = [
            'name' => $name,
            'phone' => $phone,
            'address' => $address
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            $model = new UserModel();
            $model->updateUserProfile($userId, $updateData);

            $session->set('userName', $name);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'userName' => $name
            ]);
        }
        catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }





}
