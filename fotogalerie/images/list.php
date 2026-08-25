<?php
header('Content-Type: application/json; charset=utf-8');
$exts = ['jpg','jpeg','png','webp','gif'];

function list_images($dir, $exts) {
    $files = array_values(array_filter(scandir($dir), function ($f) use ($dir, $exts) {
        if ($f === '.' || $f === '..') return false;
        if (is_dir($dir . '/' . $f)) return false;
        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        return in_array($ext, $exts, true);
    }));
    sort($files);
    return $files;
}

$root = __DIR__;
$albums = [];

// photos directly in images/ (no album folder) go under a blank-key album
$rootFiles = list_images($root, $exts);
if ($rootFiles) $albums[''] = $rootFiles;

// each subfolder of images/ is one named album
$dirs = array_values(array_filter(scandir($root), function ($f) use ($root) {
    return $f !== '.' && $f !== '..' && is_dir($root . '/' . $f);
}));
sort($dirs);
foreach ($dirs as $d) {
    $files = list_images($root . '/' . $d, $exts);
    if ($files) $albums[$d] = $files;
}

echo json_encode($albums);
