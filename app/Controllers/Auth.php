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


    




}
