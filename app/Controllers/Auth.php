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
            return $this->response->setJSON([
                'status' => 'error',
                'message' => implode(', ', $this->validator->getErrors())
            ]);
        }

        $model = new UserModel();

        // check existing email
        if ($model->getUserByEmail($this->request->getPost('email'))) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email already registered.'
            ]);
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

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Registration successful! Your account is pending admin approval.'
        ]);
    }

   public function authenticate()
{
    $session = session();
    $model = new UserModel();

    $email = trim($this->request->getPost('email'));
    $password = $this->request->getPost('password');

    $user = $model->getUserByEmail($email);

    if (!$user) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid email or password.'
        ]);
    }

    if ($user['role'] !== 'user') {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Only users can login here.'
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
            'message' => 'Your account is pending admin approval.'
        ]);
    }

    // Session create
    $session->set([
        'userId' => $user['id'],
        'userName' => $user['name'],
        'userEmail' => $user['email'],
        'userRole' => $user['role'],
        'isLoggedIn' => true
    ]);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Login successful',
        'redirect' => '/user/dashboard'
    ]);
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

            // Check admin role
            if (($user['role'] ?? '') !== 'admin') {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unauthorized access. Admin role required.'
                ]);
            }

            // Set session
            $ses_data = [
                'userId'     => $user['id'],
                'userName'   => $user['name'],
                'userEmail'  => $user['email'],
                'userRole'   => $user['role'],
                'isLoggedIn' => true
            ];

            $session->set($ses_data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Admin login successful',
                'redirect' => '/admin/dashboard'
            ]);
        }
    }

    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Invalid email or password'
    ]);
}


    




}
