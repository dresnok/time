<?php
// time.php
$file = 'time.json';

if ($_GET['action'] === 'get') {
    if (!file_exists($file)) {
        file_put_contents($file, json_encode(['seconds' => 0]));
    }
    echo file_get_contents($file);
    exit;
}

if ($_GET['action'] === 'save') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['seconds'])) {
        file_put_contents($file, json_encode(['seconds' => (int)$data['seconds']]));
    }
    echo json_encode(['status' => 'ok']);
    exit;
}

