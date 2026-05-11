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

        $this->view('home/index', ['title' => 'Welcome to Zipply Paste']);
    }
}
