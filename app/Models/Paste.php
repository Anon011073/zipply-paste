<?php

namespace App\Models;

use App\Core\Model;

class Paste extends Model
{
    protected $table = 'pastes';

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT p.*, u.username FROM {$this->table} p LEFT JOIN users u ON p.user_id = u.id WHERE p.slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (slug, title, content, language, visibility, password, expires_at, user_id, is_burned)
                VALUES (:slug, :title, :content, :language, :visibility, :password, :expires_at, :user_id, :is_burned)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':slug' => $data['slug'],
            ':title' => $data['title'] ?? 'Untitled',
            ':content' => $data['content'],
            ':language' => $data['language'] ?? 'plaintext',
            ':visibility' => $data['visibility'] ?? 'public',
            ':password' => !empty($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : null,
            ':expires_at' => $data['expires_at'] ?? null,
            ':user_id' => $data['user_id'] ?? null,
            ':is_burned' => $data['is_burned'] ?? 0
        ]);

        return $this->db->lastInsertId();
    }

    public function getRecent($limit = 10)
    {
        $stmt = $this->db->prepare("SELECT slug, title, language, created_at FROM {$this->table} WHERE visibility = 'public' AND (expires_at IS NULL OR expires_at > DATETIME('now')) ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function incrementViews($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET views = views + 1 WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function markAsBurned($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET expires_at = DATETIME('now') WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
