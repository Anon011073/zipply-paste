<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $userModel = new User();
        $user = $userModel->find($_SESSION['user_id']);

        $this->view('user/dashboard', [
            'title' => 'Dashboard',
            'user' => $user
        ]);
    }
}
