<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Paste;

class AdminController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
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
        $limit = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $userModel = new User();
        $users = $userModel->all($limit, $offset);
        $total = $userModel->count();
        $totalPages = ceil($total / $limit);

        $this->view('admin/users', [
            'title' => 'Manage Users',
            'users' => $users,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function deleteUser($params)
    {
        if ($_SESSION['role'] !== 'admin') die("Unauthorized.");

        $id = $params['id'];
        if ($id == $_SESSION['user_id']) {
            die("Cannot delete yourself.");
        }

        $userModel = new User();
        $userModel->delete($id);

        // Also delete their pastes
        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("DELETE FROM pastes WHERE user_id = ?");
        $stmt->execute([$id]);

        $this->redirect('/admin/users');
    }

    public function settings()
    {
        if ($_SESSION['role'] !== 'admin') die("Unauthorized.");
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        $this->view('admin/settings', ['title' => 'Site Settings', 'settings' => $settings]);
    }

    public function saveSettings()
    {
        if ($_SESSION['role'] !== 'admin') die("Unauthorized.");
        $settingModel = new \App\Models\Setting();
        $allowedKeys = [
            'site_name', 'site_description', 'allow_guest_pastes',
            'registration_enabled', 'maintenance_mode', 'footer_text',
            'max_paste_size', 'default_expiration', 'theme_primary_color'
        ];

        foreach ($_POST as $key => $value) {
            if (in_array($key, $allowedKeys)) {
                $settingModel->set($key, $value);
            }
        }
        $this->redirect('/admin/settings');
    }
}
