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

        $db = \App\Core\Database::getInstance();
        $userId = $_SESSION['user_id'];

        $stmtTotal = $db->prepare("SELECT COUNT(*) FROM pastes WHERE user_id = ?");
        $stmtTotal->execute([$userId]);
        $stmtViews = $db->prepare("SELECT SUM(views) FROM pastes WHERE user_id = ?");
        $stmtViews->execute([$userId]);
        $stmtPublic = $db->prepare("SELECT COUNT(*) FROM pastes WHERE user_id = ? AND visibility = 'public'");
        $stmtPublic->execute([$userId]);
        $stmtPrivate = $db->prepare("SELECT COUNT(*) FROM pastes WHERE user_id = ? AND visibility = 'private'");
        $stmtPrivate->execute([$userId]);

        $stats = [
            'total' => $stmtTotal->fetchColumn(),
            'views' => $stmtViews->fetchColumn() ?: 0,
            'public' => $stmtPublic->fetchColumn(),
            'private' => $stmtPrivate->fetchColumn(),
        ];

        $stmt = $db->prepare("SELECT * FROM pastes WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
        $stmt->execute([$userId]);
        $recentPastes = $stmt->fetchAll();

        $stmt = $db->prepare("SELECT * FROM api_keys WHERE user_id = ?");
        $stmt->execute([$userId]);
        $apiKeys = $stmt->fetchAll();

        $this->view('user/dashboard', [
            'title' => 'Dashboard',
            'user' => $user,
            'stats' => $stats,
            'recentPastes' => $recentPastes,
            'apiKeys' => $apiKeys
        ]);
    }

    public function createApiKey()
    {
        if (!isset($_SESSION['user_id'])) $this->redirect('/login');

        $keyName = $_POST['key_name'] ?? 'Default Key';
        $apiKey = bin2hex(random_bytes(16));
        $userId = $_SESSION['user_id'];

        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("INSERT INTO api_keys (user_id, key_name, api_key) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $keyName, $apiKey]);

        $this->redirect('/dashboard');
    }
}
