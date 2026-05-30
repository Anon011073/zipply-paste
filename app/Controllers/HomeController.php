<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Check if installed
        if (!file_exists(__DIR__ . '/../../storage/database/database.sqlite')) {
            $this->redirect('/install');
        }

        $limit = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $pasteModel = new \App\Models\Paste();
        $recent = $pasteModel->getRecent($limit, $offset);
        $total = $pasteModel->countPublic();
        $totalPages = ceil($total / $limit);

        $this->view('home/index', [
            'title' => 'Welcome to Swiffy Code',
            'recent' => $recent,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
}
