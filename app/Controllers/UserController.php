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
}
