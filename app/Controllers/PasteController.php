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
        $recent = $this->pasteModel->getRecent(10);
        $this->view('paste/create', [
            'title' => 'Create New Paste',
            'recent' => $recent
        ]);
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
            'title' => $_POST['p_title'] ?? 'Untitled',
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

    private function checkAccess($paste)
    {
        if (!$paste) {
            die("Paste not found.");
        }

        // Check visibility
        if ($paste['visibility'] === 'private') {
            $is_owner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $paste['user_id'];
            $is_privileged = isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'moderator']);

            if (!$is_owner && !$is_privileged) {
                die("This is a private paste.");
            }
        }

        // Check expiration
        if ($paste['expires_at'] && strtotime($paste['expires_at']) < time()) {
            die("Paste has expired.");
        }

        return true;
    }

    public function show($params)
    {
        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);

        $this->checkAccess($paste);

        $recent = $this->pasteModel->getRecent(10);

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
            'paste' => $paste,
            'recent' => $recent
        ]);
    }

    public function raw($params)
    {
        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);

        $this->checkAccess($paste);

        // Check password
        if ($paste['password'] && !isset($_SESSION['unlocked_pastes'][$slug])) {
            die("Password protected.");
        }

        header('Content-Type: text/plain');
        echo $paste['content'];
        exit;
    }

    public function download($params)
    {
        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);

        $this->checkAccess($paste);

        // Check password
        if ($paste['password'] && !isset($_SESSION['unlocked_pastes'][$slug])) {
            die("Password protected.");
        }

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

        $this->checkAccess($paste);

        // Check password
        if ($paste['password'] && !isset($_SESSION['unlocked_pastes'][$slug])) {
            die("Password protected.");
        }

        $recent = $this->pasteModel->getRecent(10);
        $this->view('paste/create', [
            'title' => 'Clone Paste: ' . $paste['title'],
            'clone' => $paste,
            'recent' => $recent
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

    public function edit($params)
    {
        if (!isset($_SESSION['user_id'])) $this->redirect('/login');

        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);

        if (!$paste || $paste['user_id'] != $_SESSION['user_id']) {
            die("Unauthorized or paste not found.");
        }

        $recent = $this->pasteModel->getRecent(10);
        $this->view('paste/edit', [
            'title' => 'Edit Paste: ' . $paste['title'],
            'paste' => $paste,
            'recent' => $recent
        ]);
    }

    public function update($params)
    {
        if (!isset($_SESSION['user_id'])) $this->redirect('/login');

        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);

        if (!$paste || $paste['user_id'] != $_SESSION['user_id']) {
            die("Unauthorized.");
        }

        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("UPDATE pastes SET title = ?, content = ?, language = ?, visibility = ? WHERE id = ?");
        $stmt->execute([
            $_POST['p_title'] ?? 'Untitled',
            $_POST['content'],
            $_POST['language'] ?? 'plaintext',
            $_POST['visibility'] ?? 'public',
            $paste['id']
        ]);

        $this->redirect("/v/{$slug}");
    }

    public function delete($params)
    {
        if (!isset($_SESSION['user_id'])) $this->redirect('/login');

        $slug = $params['slug'];
        $paste = $this->pasteModel->findBySlug($slug);

        if (!$paste || ($paste['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin')) {
            die("Unauthorized.");
        }

        $this->pasteModel->delete($paste['id']);
        $this->redirect('/dashboard');
    }
}
