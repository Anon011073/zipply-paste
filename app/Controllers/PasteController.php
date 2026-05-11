<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Paste;

class PasteController extends Controller
{
    protected $pasteModel;

    public function __construct()
    {
        $this->pasteModel = new Paste();
    }

    public function create()
    {
        $this->view('paste/create', ['title' => 'Create New Paste']);
    }

    public function store()
    {
        $content = $_POST['content'] ?? '';
        if (empty($content)) {
            $this->redirect('/paste/new');
        }

        $slug = bin2hex(random_bytes(4)); // Simple 8-char slug
        $expiration = $_POST['expiration'] ?? 'never';
        $expires_at = null;
        $is_burned = 0;

        switch ($expiration) {
            case 'burn': $is_burned = 1; break;
            case '10m': $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes')); break;
            case '1h': $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); break;
            case '1d': $expires_at = date('Y-m-d H:i:s', strtotime('+1 day')); break;
            case '1w': $expires_at = date('Y-m-d H:i:s', strtotime('+1 week')); break;
        }

        $data = [
            'slug' => $slug,
            'title' => $_POST['title'] ?? 'Untitled',
            'content' => $content,
            'language' => $_POST['language'] ?? 'plaintext',
            'visibility' => $_POST['visibility'] ?? 'public',
            'password' => $_POST['password'] ?? null,
            'expires_at' => $expires_at,
            'user_id' => $_SESSION['user_id'] ?? null,
            'is_burned' => $is_burned
        ];

        if ($this->pasteModel->create($data)) {
            $this->redirect("/v/{$slug}");
        }

        $this->redirect('/paste/new');
    }

    public function show($params)
    {
        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);

        if (!$paste) {
            die("Paste not found.");
        }

        // Check expiration
        if ($paste['expires_at'] && strtotime($paste['expires_at']) < time()) {
            die("Paste has expired.");
        }

        // Check password
        if ($paste['password'] && !isset($_SESSION['unlocked_pastes'][$slug])) {
            $this->view('paste/password', ['slug' => $slug]);
            return;
        }

        $this->pasteModel->incrementViews($paste['id']);

        // Handle burn after read
        if ($paste['is_burned']) {
            $this->pasteModel->markAsBurned($paste['id']);
        }

        $this->view('paste/view', [
            'title' => $paste['title'],
            'paste' => $paste
        ]);
    }

    public function raw($params)
    {
        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);
        if (!$paste) die("Not found");
        header('Content-Type: text/plain');
        echo $paste['content'];
        exit;
    }

    public function download($params)
    {
        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);
        if (!$paste) die("Not found");

        $ext = 'txt';
        $langs = ['javascript' => 'js', 'php' => 'php', 'python' => 'py', 'html' => 'html', 'css' => 'css', 'markdown' => 'md'];
        if (isset($langs[$paste['language']])) $ext = $langs[$paste['language']];

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . ($paste['title'] ?: 'paste') . '.' . $ext . '"');
        echo $paste['content'];
        exit;
    }

    public function clone($params)
    {
        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);
        if (!$paste) die("Not found");

        $this->view('paste/create', [
            'title' => 'Clone Paste: ' . $paste['title'],
            'clone' => $paste
        ]);
    }

    public function unlock($params)
    {
        $slug = $params['slug'];
        $password = $_POST['password'] ?? '';
        $paste = $this->pasteModel->findBySlug($slug);

        if ($paste && password_verify($password, $paste['password'])) {
            $_SESSION['unlocked_pastes'][$slug] = true;
            $this->redirect("/v/{$slug}");
        }

        $this->view('paste/password', ['slug' => $slug, 'error' => 'Incorrect password']);
    }
}
