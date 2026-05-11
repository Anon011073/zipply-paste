<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Paste;

class SearchController extends Controller
{
    public function index()
    {
        $q = $_GET['q'] ?? '';
        $pastes = [];

        if (!empty($q)) {
            $db = \App\Core\Database::getInstance();
            $stmt = $db->prepare("SELECT * FROM pastes WHERE visibility = 'public' AND (title LIKE ? OR content LIKE ?) ORDER BY created_at DESC");
            $stmt->execute(["%$q%", "%$q%"]);
            $pastes = $stmt->fetchAll();
        } else {
            $pasteModel = new Paste();
            $pastes = $pasteModel->getRecent(20);
        }

        $this->view('home/search', [
            'title' => 'Search Pastes',
            'pastes' => $pastes,
            'query' => $q
        ]);
    }
}
