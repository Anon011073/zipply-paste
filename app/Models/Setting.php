<?php

namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    protected $table = 'settings';

    public function get($key, $default = null)
    {
        $stmt = $this->db->prepare("SELECT value FROM {$this->table} WHERE `key` = ?");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();
        return $val !== false ? $val : $default;
    }

    public function set($key, $value)
    {
        $driver = $this->db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        if ($driver === 'sqlite') {
            $stmt = $this->db->prepare("INSERT OR REPLACE INTO {$this->table} (`key`, value) VALUES (?, ?)");
        } else {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (`key`, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)");
        }
        return $stmt->execute([$key, $value]);
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $results = $stmt->fetchAll();
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['key']] = $row['value'];
        }
        return $settings;
    }
}
