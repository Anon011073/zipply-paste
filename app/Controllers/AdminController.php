<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Paste;

class AdminController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/');
        }
    }

    public function index()
    {
        $db = \App\Core\Database::getInstance();
        $stats = [
            'users' => $db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            'pastes' => $db->query("SELECT COUNT(*) FROM pastes")->fetchColumn(),
            'views' => $db->query("SELECT SUM(views) FROM pastes")->fetchColumn() ?: 0,
        ];

        $recentPastes = (new Paste())->getRecent(10);

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'recentPastes' => $recentPastes
        ]);
    }

    public function users()
    {
        $users = (new User())->all();
        $this->view('admin/users', ['title' => 'Manage Users', 'users' => $users]);
    }

    public function settings()
    {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        $this->view('admin/settings', ['title' => 'Site Settings', 'settings' => $settings]);
    }

    public function saveSettings()
    {
        $settingModel = new \App\Models\Setting();
        foreach ($_POST as $key => $value) {
            if ($key !== 'csrf_token') {
                $settingModel->set($key, $value);
            }
        }
        $this->redirect('/admin/settings');
    }
}
