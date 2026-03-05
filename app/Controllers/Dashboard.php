<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'userName' => session()->get('userName')
        ]);
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByEmail(session()->get('userEmail'));

        return view('dashboard/profile', [
            'title' => 'My Profile',
            'user' => $user
        ]);
    }

    public function updateProfile()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/dashboard/profile');
        }

        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($this->request->getPost('password')) {
            $validation->setRule('password', 'Password', 'min_length[6]');
        }

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $userModel = new UserModel();
        $email = session()->get('userEmail');

        $data = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        try {
            $userModel->updateUserByEmail($email, $data);

            // Update session if name changed
            session()->set('userName', $data['name']);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Profile updated successfully.'
            ]);
        }
        catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update profile.'
            ]);
        }
    }
}
