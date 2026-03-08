<?php
// api/contact.php - Handle POST contact submissions
header('Content-Type: application/json; charset=utf-8');

// 1. Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// 2. Obtener y decodificar el JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// 3. Validar datos mínimos (Honeypot anti-spam)
if (!empty($data['honeypot'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Spam detectado']);
    exit;
}
unset($data['honeypot']);

// Validación básica
$contactMethod = $data['email'] ?? $data['telefono'] ?? $data['contacto'] ?? null;
if (empty($data['nombre']) || empty($contactMethod)) {
    http_response_code(400);
    echo json_encode(['error' => 'Por favor completá tu nombre y un medio de contacto.']);
    exit;
}

// Agregar campos adicionales
$data['id'] = uniqid();
$data['fecha_registro'] = date('c');
$data['estado'] = 'Nuevo';
$data['pago'] = 'N/A';

// Detectar origen
if (!isset($data['origen'])) {
    if (isset($data['estructura']) || isset($data['ref_proyecto'])) {
        $data['origen'] = 'Cotizador';
    } else {
        $data['origen'] = 'Web';
    }
}

// Ruta al archivo de contactos
$contactsFile = __DIR__ . '/../contacts.json';

// Abrir el archivo en modo escritura segura con bloqueo
$fp = fopen($contactsFile, 'c+');

if ($fp && flock($fp, LOCK_EX)) {
    $fileSize = filesize($contactsFile);
    $currentData = $fileSize > 0 ? fread($fp, $fileSize) : '[]';
    $contacts = json_decode($currentData, true) ?? [];

    if (!is_array($contacts)) {
        $contacts = [];
    }

    array_unshift($contacts, $data);

    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Mensaje recibido correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
?>
