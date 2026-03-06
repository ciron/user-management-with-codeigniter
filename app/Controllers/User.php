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

        $data = [
            'userName' => $session->get('userName'),
            'userEmail' => $session->get('userEmail'),
            'userRole' => $session->get('userRole')
        ];

        return view('user/dashboard', $data);
    }

     public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

   


}
