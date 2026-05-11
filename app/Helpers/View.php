<?php

namespace App\Helpers;

class View
{
    public static function e($text)
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
