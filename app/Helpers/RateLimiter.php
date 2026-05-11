<?php

namespace App\Helpers;

class RateLimiter
{
    public static function check($key, $limit = 5, $period = 60)
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $fullKey = $key . '_' . $ip;

        if (!isset($_SESSION['rate_limits'][$fullKey])) {
            $_SESSION['rate_limits'][$fullKey] = ['count' => 1, 'start' => time()];
            return true;
        }

        $data = &$_SESSION['rate_limits'][$fullKey];
        if (time() - $data['start'] > $period) {
            $data = ['count' => 1, 'start' => time()];
            return true;
        }

        if ($data['count'] >= $limit) {
            return false;
        }

        $data['count']++;
        return true;
    }
}
