<?php
/**
 * GESTIÓN AVANZADA DE COOKIES
 * ============================
 * Sistema para gestionar cookies de forma avanzada según requisitos Fase IV:
 * - Modal informativo sobre uso de cookies (primera visita)
 * - Modal sugerencia de registro (primera visita)
 * - Notificación de novedades (1 vez al mes)
 */

class CookieManager {
    
    // Nombres de cookies
    const COOKIE_ACEPTADAS = 'kairos_cookies_aceptadas';
    const COOKIE_DECIDIDAS = 'kairos_cookies_decididas';
    const COOKIE_PRIMERA_VISITA = 'kairos_primera_visita';
    const COOKIE_SUGERENCIA_REGISTRO = 'kairos_sugerencia_registro_mostrada';
    const COOKIE_ULTIMA_NOTIFICACION = 'kairos_ultima_notificacion';
    
    // Duraciones (en segundos)
    const DURACION_1_ANO = 365 * 24 * 60 * 60;
    const DURACION_30_DIAS = 30 * 24 * 60 * 60;
    
    /**
     * Verifica si el usuario ha aceptado las cookies
     */
    public static function cookiesAceptadas() {
        return isset($_COOKIE[self::COOKIE_ACEPTADAS]) && $_COOKIE[self::COOKIE_ACEPTADAS] === 'si';
    }
    
    /**
     * Marca que el usuario aceptó las cookies
     */
    public static function aceptarCookies() {
        setcookie(self::COOKIE_ACEPTADAS, 'si', time() + self::DURACION_1_ANO, '/', '', false, true);
        setcookie(self::COOKIE_DECIDIDAS, 'si', time() + self::DURACION_1_ANO, '/', '', false, true);
        setcookie(self::COOKIE_PRIMERA_VISITA, 'no', time() + self::DURACION_1_ANO, '/', '', false, false);
    }
    
    /**
     * Marca que el usuario denegó las cookies (solo obligatorias)
     */
    public static function denegarCookies() {
        setcookie(self::COOKIE_DECIDIDAS, 'solo_obligatorias', time() + self::DURACION_1_ANO, '/', '', false, true);
        setcookie(self::COOKIE_PRIMERA_VISITA, 'no', time() + self::DURACION_1_ANO, '/', '', false, false);
    }

    /**
     * Verifica si el usuario ya decidió sobre las cookies (aceptar o denegar)
     */
    public static function cookiesDecididas() {
        return isset($_COOKIE[self::COOKIE_DECIDIDAS]);
    }
    
    /**
     * Verifica si es la primera visita del usuario
     */
    public static function esPrimeraVisita() {
        return !isset($_COOKIE[self::COOKIE_PRIMERA_VISITA]);
    }
    
    /**
     * Verifica si debe mostrar la sugerencia de registro
     * (primera visita y usuario no logueado)
     */
    public static function mostrarSugerenciaRegistro() {
        // No mostrar si ya se mostró antes
        if (isset($_COOKIE[self::COOKIE_SUGERENCIA_REGISTRO])) {
            return false;
        }
        
        // No mostrar si el usuario ya está logueado
        if (isset($_SESSION['usuario_id'])) {
            return false;
        }
        
        // No mostrar si no ha aceptado cookies
        if (!self::cookiesAceptadas()) {
            return false;
        }
        
        // Mostrar solo en primera visita
        return self::esPrimeraVisita();
    }
    
    /**
     * Marca que ya se mostró la sugerencia de registro
     */
    public static function marcarSugerenciaRegistroMostrada() {
        setcookie(self::COOKIE_SUGERENCIA_REGISTRO, 'si', time() + self::DURACION_1_ANO, '/', '', false, false);
    }
    
    /**
     * Verifica si debe mostrar la notificación de novedades
     * (1 vez al mes)
     */
    public static function mostrarNotificacionNovedades() {
        // No mostrar si no ha aceptado cookies
        if (!self::cookiesAceptadas()) {
            return false;
        }
        
        // No mostrar si no está logueado
        if (!isset($_SESSION['usuario_id'])) {
            return false;
        }
        
        // Verificar si pasó 1 mes desde la última notificación
        if (!isset($_COOKIE[self::COOKIE_ULTIMA_NOTIFICACION])) {
            return true;
        }
        
        $ultimaNotificacion = (int)$_COOKIE[self::COOKIE_ULTIMA_NOTIFICACION];
        $unMes = 30 * 24 * 60 * 60; // 30 días en segundos
        
        return (time() - $ultimaNotificacion) >= $unMes;
    }
    
    /**
     * Marca que se mostró la notificación de novedades
     */
    public static function marcarNotificacionMostrada() {
        setcookie(self::COOKIE_ULTIMA_NOTIFICACION, (string)time(), time() + self::DURACION_1_ANO, '/', '', false, false);
    }
    
    /**
     * Genera el HTML del modal de aceptación de cookies
     * Solo se muestra cuando el usuario ha iniciado sesión y no ha decidido aún
     */
    public static function generarModalCookies() {
        // Solo mostrar si el usuario está logueado
        if (!isset($_SESSION['usuario_id'])) {
            return '';
        }
        if (self::cookiesDecididas()) {
            return '';
        }
        
        return '
        <!-- Modal Cookies -->
        <div class="modal fade" id="cookiesModal" tabindex="-1" aria-labelledby="cookiesModalTitle">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="cookiesModalTitle">
                            🍪 Uso de Cookies
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">
                            En <strong>Kairos</strong> utilizamos cookies para mejorar tu experiencia de navegación y ofrecerte contenido personalizado.
                        </p>
                        <p class="mb-3">
                            Las cookies nos permiten:
                        </p>
                        <ul class="mb-3">
                            <li>Recordar tus preferencias y mantener tu sesión activa</li>
                            <li>Permitir el login con Google</li>
                            <li>Mejorar la seguridad de tu cuenta</li>
                            <li>Personalizar tu experiencia en el sitio</li>
                        </ul>
                        <p class="mb-0">
                            <small class="text-muted">
                                Si denegas las cookies, podrás seguir navegando pero solo se usarán las cookies obligatorias necesarias para el funcionamiento básico del sitio.
                            </small>
                        </p>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="denegarCookiesBtn">
                            Denegar (solo obligatorias)
                        </button>
                        <button type="button" class="btn btn-primary" id="aceptarCookiesBtn">
                            Aceptar todas
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        // Mostrar modal automáticamente
        document.addEventListener("DOMContentLoaded", function() {
            const cookiesModal = new bootstrap.Modal(document.getElementById("cookiesModal"));
            cookiesModal.show();
            
            // Handler para aceptar cookies
            document.getElementById("aceptarCookiesBtn").addEventListener("click", function() {
                // Enviar petición AJAX para marcar cookies como aceptadas
                fetch("aceptar_cookies.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: "accion=aceptar"
                }).then(() => {
                    cookiesModal.hide();
                    location.reload();
                });
            });
            
            // Handler para denegar cookies
            document.getElementById("denegarCookiesBtn").addEventListener("click", function() {
                fetch("aceptar_cookies.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: "accion=denegar"
                }).then(() => {
                    cookiesModal.hide();
                    location.reload();                });
            });
        });
        </script>';
    }
    
    /**
     * Genera el HTML del modal de sugerencia de registro
     */
    public static function generarModalSugerenciaRegistro() {
        if (!self::mostrarSugerenciaRegistro()) {
            return '';
        }
        
        // Marcar como mostrada
        self::marcarSugerenciaRegistroMostrada();
        
        return '
        <!-- Modal Sugerencia Registro -->
        <div class="modal fade" id="sugerenciaRegistroModal" tabindex="-1" aria-labelledby="sugerenciaRegistroModalTitle">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="sugerenciaRegistroModalTitle">
                            ✨ ¡Únete a Kairos!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="h6 mb-3">¿Te gustaría registrarte?</p>
                        <p class="mb-4">
                            Crea una cuenta en <strong>Kairos</strong> para:
                        </p>
                        <div class="row text-start mb-4">
                            <div class="col-12 mb-2">
                                <span class="badge bg-success me-2">✓</span> Valorar productos y contenidos
                            </div>
                            <div class="col-12 mb-2">
                                <span class="badge bg-success me-2">✓</span> Guardar tus productos favoritos
                            </div>
                            <div class="col-12 mb-2">
                                <span class="badge bg-success me-2">✓</span> Recibir ofertas exclusivas
                            </div>
                            <div class="col-12 mb-2">
                                <span class="badge bg-success me-2">✓</span> Acceso prioritario a novedades
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Ahora no
                        </button>
                        <a href="register.php" class="btn btn-success">
                            Registrarme Gratis
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        // Mostrar modal después de 3 segundos
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const registroModal = new bootstrap.Modal(document.getElementById("sugerenciaRegistroModal"));
                registroModal.show();
            }, 3000);
        });
        </script>';
    }
    
    /**
     * Genera el HTML del modal de novedades mensuales
     */
    public static function generarModalNovedades() {
        if (!self::mostrarNotificacionNovedades()) {
            return '';
        }
        
        // Marcar como mostrada
        self::marcarNotificacionMostrada();
        
        return '
        <!-- Modal Novedades -->
        <div class="modal fade" id="novedadesModal" tabindex="-1" aria-labelledby="novedadesModalTitle">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="novedadesModalTitle">
                            🎮 Novedades de Este Mes
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="h6 mb-3">¡Hola ' . ($_SESSION['nombre'] ?? 'Usuario') . '!</p>
                        <p class="mb-4">
                            Tenemos grandes novedades para ti este mes:
                        </p>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">🆕 Nuevos Lanzamientos</h6>
                                        <p class="card-text">
                                            Descubre los últimos títulos que han llegado a nuestra tienda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">💰 Ofertas Exclusivas</h6>
                                        <p class="card-text">
                                            Hasta 50% de descuento en juegos seleccionados solo para usuarios registrados.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">🎁 Promociones Especiales</h6>
                                        <p class="card-text">
                                            Participa en nuestros sorteos y gana productos gratis.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">📢 Eventos</h6>
                                        <p class="card-text">
                                            Únete a nuestros torneos online y eventos en tienda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                        <a href="plataformas.php" class="btn btn-info text-white">
                            Ver Productos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        // Mostrar modal después de 2 segundos
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const novedadesModal = new bootstrap.Modal(document.getElementById("novedadesModal"));
                novedadesModal.show();
            }, 2000);
        });
        </script>';
    }
}
?>