<?php
header('Content-Type: application/json; charset=utf-8');
$exts = ['jpg','jpeg','png','webp','gif'];
$files = array_values(array_filter(scandir(__DIR__), function ($f) use ($exts) {
    if ($f === '.' || $f === '..') return false;
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    return in_array($ext, $exts, true);
}));
sort($files);
echo json_encode($files);
