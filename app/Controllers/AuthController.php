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
        // Simple placeholder for reset logic
        // In a full app, we'd generate a token and send an email
        $this->view('auth/forgot', ['title' => 'Reset Password', 'success' => true]);
    }
}
