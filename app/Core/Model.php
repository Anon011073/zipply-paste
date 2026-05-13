<?php

namespace App\Core;

use App\Core\Database;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all($limit = null, $offset = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
            if ($offset !== null) {
                $sql .= " OFFSET " . (int)$offset;
            }
        }
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function count()
    {
        return $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
