<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function signup()
    {
        return view('auth/signup');
    }

    public function register()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]',
                'phone' => 'required',
                'address' => 'required',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors()
                ]);
            }

            $userModel = new UserModel();
            $email = $this->request->getPost('email');

            // Check if email already exists
            if ($userModel->getUserByEmail($email)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => ['email' => 'Email already exists.']
                ]);
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $email,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'role' => 'user',
                'status' => 'pending',
            ];

            try {
                $userModel->insertUser($data);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Registration successful. Please wait for admin approval.'
                ]);
            }
            catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => ['db' => 'Failed to register. Please try again later.']
                ]);
            }
        }

        return redirect()->to('/signup');
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        if ($this->request->isAJAX()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid email or password.'
                ]);
            }

            if (!password_verify($password, $user['password'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid email or password.'
                ]);
            }

            if ($user['status'] !== 'approved') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Your account is pending approval.'
                ]);
            }

            // Set session
            $sessionData = [
                'userId' => $user['id'],
                'userName' => $user['name'],
                'userEmail' => $user['email'],
                'userRole' => $user['role'],
                'isLoggedIn' => true,
            ];
            session()->set($sessionData);

            return $this->response->setJSON([
                'status' => 'success',
                'redirect' => $user['role'] === 'admin' ? '/admin' : '/dashboard'
            ]);
        }

        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
