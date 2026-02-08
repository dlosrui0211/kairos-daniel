<?php
/**
 * CONFIGURACIÓN DE OAUTH Y RECAPTCHA
 */

// ============================================
// GOOGLE OAUTH CREDENTIALS
// ============================================
define('GOOGLE_CLIENT_ID', '416269202705-jr8pb3i4g82f69sm9b8r227cb2v3geu2.apps.googleusercontent.com');

// ============================================
// RECAPTCHA V2 CREDENTIALS
// ============================================
define('RECAPTCHA_SITE_KEY', '6LeZ0WEsAAAAAI68yF94tvvmsaYwduIMxEUwJVCt');
define('RECAPTCHA_SECRET_KEY', '6LeZ0WEsAAAAAKCbdMBiQ2KnoGbEWbGzWZgxJp3d');

// ============================================
// CONFIGURACIÓN DE COOKIES
// ============================================
define('COOKIE_NAME', 'kairos_remember');
define('COOKIE_EXPIRY', 30 * 24 * 60 * 60); // 30 días en segundos

?>