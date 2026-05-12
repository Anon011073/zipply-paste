<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Paste;

class UserController extends Controller
{
    public function profile($params)
    {
        $username = $params['username'];
        $userModel = new \App\Models\User();
        $user = $userModel->findByUsername($username);

        if (!$user) {
            die("User not found.");
        }

        $pasteModel = new Paste();
        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM pastes WHERE user_id = ? AND visibility = 'public' ORDER BY created_at DESC");
        $stmt->execute([$user['id']]);
        $pastes = $stmt->fetchAll();

        $this->view('user/profile', [
            'title' => $user['username'] . "'s Profile",
            'user' => $user,
            'pastes' => $pastes
        ]);
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) $this->redirect('/login');

        $userModel = new \App\Models\User();
        $user = $userModel->find($_SESSION['user_id']);

        $this->view('user/edit', [
            'title' => 'Edit Profile',
            'user' => $user
        ]);
    }

    public function update()
    {
        if (!isset($_SESSION['user_id'])) $this->redirect('/login');

        $userId = $_SESSION['user_id'];
        $fullName = $_POST['full_name'] ?? '';
        $bio = $_POST['bio'] ?? '';

        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("UPDATE users SET full_name = ?, bio = ? WHERE id = ?");
        $stmt->execute([$fullName, $bio, $userId]);

        $this->redirect('/dashboard');
    }

    public function pastes()
    {
        if (!isset($_SESSION['user_id'])) $this->redirect('/login');

        $userId = $_SESSION['user_id'];
        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM pastes WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        $pastes = $stmt->fetchAll();

        $this->view('user/pastes', [
            'title' => 'My Pastes',
            'pastes' => $pastes
        ]);
    }
}
