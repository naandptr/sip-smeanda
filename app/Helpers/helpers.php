<?php

use Illuminate\Support\Str;

if (!function_exists('limitHtml')) {
    function limitHtml($html, $limit = 100, $allowedTags = '<ul><li><ol><p><br>') {
        $stripped = strip_tags($html, $allowedTags);
        $truncated = Str::limit($stripped, $limit, '...');

        return nl2br($truncated);
    }
}
