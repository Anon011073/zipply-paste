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
        $driver = $_POST['db_driver'] ?? 'sqlite';
        $dbPath = __DIR__ . '/../../storage/database/database.sqlite';

        if ($driver === 'sqlite' && file_exists($dbPath)) {
            $this->json(['success' => false, 'message' => 'Already installed (SQLite)']);
        }

        try {
            if ($driver === 'sqlite') {
                $dbDir = dirname($dbPath);
                if (!is_dir($dbDir)) {
                    mkdir($dbDir, 0755, true);
                }
                if (!is_writable($dbDir)) {
                    $this->json(['success' => false, 'message' => "The directory '$dbDir' is not writable. Please check permissions."]);
                    return;
                }
                $db = new PDO("sqlite:" . $dbPath);
            } else {
                $host = $_POST['db_host'] ?? 'localhost';
                $name = $_POST['db_name'] ?? '';
                $user = $_POST['db_user'] ?? '';
                $pass = $_POST['db_pass'] ?? '';
                $db = new PDO("mysql:host=$host;dbname=$name", $user, $pass);

                // Update config file
                $configPath = __DIR__ . '/../../config/database.php';
                $config = "<?php\n\nreturn [\n    'driver' => 'mysql',\n    'sqlite' => [\n        'path' => __DIR__ . '/../storage/database/database.sqlite'\n    ],\n    'mysql' => [\n        'host' => '$host',\n        'database' => '$name',\n        'username' => '$user',\n        'password' => '$pass'\n    ]\n];";
                file_put_contents($configPath, $config);
            }

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $autoIncrement = ($driver === 'sqlite') ? 'AUTOINCREMENT' : 'AUTO_INCREMENT';
            $pk = "INTEGER PRIMARY KEY $autoIncrement";
            if ($driver === 'mysql') $pk = "INT PRIMARY KEY AUTO_INCREMENT";

            // Create Users table
            $db->exec("CREATE TABLE IF NOT EXISTS users (
                id $pk,
                username VARCHAR(255) UNIQUE NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                full_name VARCHAR(255),
                role VARCHAR(50) DEFAULT 'member',
                avatar VARCHAR(255),
                bio TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");

            // Create Pastes table
            $db->exec("CREATE TABLE IF NOT EXISTS pastes (
                id $pk,
                slug VARCHAR(255) UNIQUE NOT NULL,
                title VARCHAR(255),
                content TEXT NOT NULL,
                language VARCHAR(50) DEFAULT 'plaintext',
                visibility VARCHAR(20) DEFAULT 'public',
                password VARCHAR(255),
                expires_at DATETIME,
                user_id INT,
                views INT DEFAULT 0,
                is_burned INT DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )");

            // Create Settings table
            $db->exec("CREATE TABLE IF NOT EXISTS settings (
                `key` VARCHAR(255) PRIMARY KEY,
                `value` TEXT
            )");

            // Create API Keys table
            $db->exec("CREATE TABLE IF NOT EXISTS api_keys (
                id $pk,
                user_id INT NOT NULL,
                key_name VARCHAR(255) NOT NULL,
                api_key VARCHAR(255) UNIQUE NOT NULL,
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
