<?php

header('Content-Type: application/json');

$results = [];

$results['pdo_sqlite_loaded'] = extension_loaded('pdo_sqlite');
$results['file_exists'] = file_exists(__DIR__ . '/../database/database.sqlite');

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
    $results['pdo_connect_success'] = true;
} catch (Exception $e) {
    $results['pdo_connect_success'] = false;
    $results['error'] = $e->getMessage();
}

$results['path'] = realpath(__DIR__ . '/../database/database.sqlite');

echo json_encode($results, JSON_PRETTY_PRINT);
