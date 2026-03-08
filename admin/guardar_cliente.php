<?php
// admin/guardar_cliente.php - Backend Cliente - VERSIÓN 2025
require_once '../auth.php';
requireLogin();
header('Content-Type: application/json');

$jsonFile = '../contacts.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    if (!is_array($current)) $current = [];

    $accion = $_POST['accion'] ?? '';
    $id = $_POST['id'] ?? '';

    // Buscar índice del cliente
    $index = -1;
    foreach ($current as $key => $client) {
        if (isset($client['id']) && $client['id'] === $id) {
            $index = $key;
            break;
        }
    }

    if ($index === -1) {
        echo json_encode(['error' => 'Cliente no encontrado']);
        exit;
    }

    // --- ACCIÓN: ELIMINAR ---
    if ($accion === 'eliminar') {
        array_splice($current, $index, 1);
        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al escribir archivo']);
        }
        exit;
    }

    // --- ACCIÓN: ACTUALIZAR ---
    if ($accion === 'actualizar') {
        $current[$index]['estado'] = $_POST['estado'] ?? $current[$index]['estado'] ?? 'Nuevo';
        $current[$index]['pago'] = $_POST['pago'] ?? $current[$index]['pago'] ?? 'N/A';
        $current[$index]['updated_at'] = date('Y-m-d H:i:s');

        // Agregar nota
        $nuevaNota = trim($_POST['nueva_nota'] ?? '');
        if (!empty($nuevaNota)) {
            if (!isset($current[$index]['historial_notas']) || !is_array($current[$index]['historial_notas'])) {
                $notasViejas = $current[$index]['notas'] ?? '';
                $current[$index]['historial_notas'] = [];
                if (!empty($notasViejas)) {
                    $current[$index]['historial_notas'][] = [
                        'fecha' => $current[$index]['updated_at'] ?? date('Y-m-d H:i:s'),
                        'texto' => $notasViejas
                    ];
                }
            }
            array_unshift($current[$index]['historial_notas'], [
                'fecha' => date('Y-m-d H:i:s'),
                'texto' => $nuevaNota
            ]);
        }

        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al guardar cambios']);
        }
        exit;
    }

    // --- ACCIÓN: AGREGAR ETIQUETA ---
    if ($accion === 'agregar_etiqueta') {
        $etiqueta = $_POST['etiqueta'] ?? '';
        if (empty($etiqueta)) {
            echo json_encode(['error' => 'Etiqueta vacía']);
            exit;
        }

        if (!isset($current[$index]['etiquetas']) || !is_array($current[$index]['etiquetas'])) {
            $current[$index]['etiquetas'] = [];
        }

        if (!in_array($etiqueta, $current[$index]['etiquetas'])) {
            $current[$index]['etiquetas'][] = $etiqueta;
            $current[$index]['updated_at'] = date('Y-m-d H:i:s');
            
            if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error al guardar etiqueta']);
            }
        } else {
            echo json_encode(['success' => true, 'message' => 'Etiqueta ya existe']);
        }
        exit;
    }

    // --- ACCIÓN: ELIMINAR ETIQUETA ---
    if ($accion === 'eliminar_etiqueta') {
        $etiqueta = $_POST['etiqueta'] ?? '';
        
        if (isset($current[$index]['etiquetas']) && is_array($current[$index]['etiquetas'])) {
            $current[$index]['etiquetas'] = array_values(array_diff($current[$index]['etiquetas'], [$etiqueta]));
            $current[$index]['updated_at'] = date('Y-m-d H:i:s');
            
            if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error al eliminar etiqueta']);
            }
        } else {
            echo json_encode(['success' => true]);
        }
        exit;
    }

    // --- ACCIÓN: AGREGAR RECORDATORIO ---
    if ($accion === 'agregar_recordatorio') {
        $texto = $_POST['texto'] ?? '';
        $fecha = $_POST['fecha'] ?? '';
        
        if (empty($texto) || empty($fecha)) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }

        if (!isset($current[$index]['recordatorios']) || !is_array($current[$index]['recordatorios'])) {
            $current[$index]['recordatorios'] = [];
        }

        $current[$index]['recordatorios'][] = [
            'id' => uniqid(),
            'texto' => $texto,
            'fecha' => $fecha,
            'creado' => date('Y-m-d H:i:s')
        ];
        
        $current[$index]['updated_at'] = date('Y-m-d H:i:s');

        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al guardar recordatorio']);
        }
        exit;
    }

    // --- ACCIÓN: ELIMINAR RECORDATORIO ---
    if ($accion === 'eliminar_recordatorio') {
        $recordatorioId = $_POST['recordatorio_id'] ?? '';
        
        if (isset($current[$index]['recordatorios']) && is_array($current[$index]['recordatorios'])) {
            $current[$index]['recordatorios'] = array_values(array_filter($current[$index]['recordatorios'], function($r) use ($recordatorioId) {
                return $r['id'] !== $recordatorioId;
            }));
            $current[$index]['updated_at'] = date('Y-m-d H:i:s');
            
            if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error al eliminar recordatorio']);
            }
        } else {
            echo json_encode(['success' => true]);
        }
        exit;
    }

    echo json_encode(['error' => 'Acción no válida']);
}
?>
