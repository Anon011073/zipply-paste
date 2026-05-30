<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        if (isset($_SESSION['user_id'])) $this->redirect('/');
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function postLogin()
    {
        if (!\App\Helpers\RateLimiter::check("login", 10, 300)) die("Too many login attempts.");

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $this->redirect('/');
        }

        $this->view('auth/login', ['title' => 'Login', 'error' => 'Invalid credentials']);
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) $this->redirect('/');
        $this->view('auth/register', ['title' => 'Register']);
    }

    public function postRegister()
    {
        if (!\App\Helpers\RateLimiter::check("register", 5, 3600)) die("Too many registrations.");

        $data = [
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'full_name' => $_POST['full_name'] ?? ''
        ];

        if ($this->userModel->findByUsername($data['username'])) {
            return $this->view('auth/register', ['title' => 'Register', 'error' => 'Username already exists']);
        }

        if ($this->userModel->create($data)) {
            $this->redirect('/login');
        }

        $this->view('auth/register', ['title' => 'Register', 'error' => 'Something went wrong']);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/');
    }

    public function forgotPassword()
    {
        $this->view('auth/forgot', ['title' => 'Reset Password']);
    }

    public function postForgotPassword()
    {
        $email = $_POST['email'] ?? '';
        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $db = \App\Core\Database::getInstance();
            try {
                $db->exec("CREATE TABLE IF NOT EXISTS password_resets (email VARCHAR(255), token VARCHAR(255), expires_at DATETIME)");
                $stmt = $db->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
                $stmt->execute([$email, $token, $expiry]);

                $resetLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . \App\Core\Router::getBase() . "/reset-password?token=$token";
                $body = "Click here to reset your password: <a href='$resetLink'>$resetLink</a>";

                \App\Helpers\Mailer::send($email, "Password Reset - Swiffy Code", $body);
            } catch (\Exception $e) {
                error_log("Reset Error: " . $e->getMessage());
            }
        }

        $this->view('auth/forgot', ['title' => 'Reset Password', 'success' => true]);
    }

    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';
        $this->view('auth/reset', ['title' => 'Set New Password', 'token' => $token]);
    }

    public function postResetPassword()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            return $this->view('auth/reset', ['title' => 'Set New Password', 'token' => $token, 'error' => 'Passwords do not match']);
        }

        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > CURRENT_TIMESTAMP LIMIT 1");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if (!$reset) {
            die("Invalid or expired token.");
        }

        $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $reset['email']]);

        $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$reset['email']]);

        $this->redirect('/login');
    }
}
