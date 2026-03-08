<?php
// auth.php - Autenticación Admin - VERSIÓN 2025
session_start();

// Credenciales (cambiar en producción)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'delsur2026');

// Verificar si está logueado
function requireLogin() {
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header('Location: login.php');
        exit;
    }
}

// Intentar loguearse
function tryLogin($user, $pass) {
    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_user'] = $user;
        return true;
    }
    return false;
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}
?>
