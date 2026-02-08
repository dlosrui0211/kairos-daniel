<?php
session_start();
require_once __DIR__ . "/cookie_manager.php";

// Aceptar cookies
CookieManager::aceptarCookies();

echo json_encode(['success' => true]);
?>