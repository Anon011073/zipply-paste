<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use PDO;

class InstallController extends Controller
{
    public function index()
    {
        if (file_exists(__DIR__ . '/../../storage/database/database.sqlite')) {
            $this->redirect('/');
        }

        $this->view('admin/install', ['title' => 'Install Zipply Paste']);
    }

    public function run()
    {
        if (file_exists(__DIR__ . '/../../storage/database/database.sqlite')) {
            $this->json(['success' => false, 'message' => 'Already installed']);
        }

        try {
            $dbPath = __DIR__ . '/../../storage/database/database.sqlite';
            $db = new PDO("sqlite:" . $dbPath);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create Users table
            $db->exec("CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                full_name TEXT,
                role TEXT DEFAULT 'member',
                avatar TEXT,
                bio TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");

            // Create Pastes table
            $db->exec("CREATE TABLE IF NOT EXISTS pastes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT UNIQUE NOT NULL,
                title TEXT,
                content TEXT NOT NULL,
                language TEXT DEFAULT 'plaintext',
                visibility TEXT DEFAULT 'public',
                password TEXT,
                expires_at DATETIME,
                user_id INTEGER,
                views INTEGER DEFAULT 0,
                is_burned INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )");

            // Create Settings table
            $db->exec("CREATE TABLE IF NOT EXISTS settings (
                key TEXT PRIMARY KEY,
                value TEXT
            )");

            // Create API Keys table
            $db->exec("CREATE TABLE IF NOT EXISTS api_keys (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                key_name TEXT NOT NULL,
                api_key TEXT UNIQUE NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )");

            // Create Admin user
            $adminUser = $_POST['admin_user'] ?? 'admin';
            $adminPass = password_hash($_POST['admin_pass'] ?? 'admin123', PASSWORD_DEFAULT);
            $adminEmail = $_POST['admin_email'] ?? 'admin@example.com';

            $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')");
            $stmt->execute([$adminUser, $adminEmail, $adminPass]);

            $this->json(['success' => true, 'message' => 'Installation successful!']);
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
