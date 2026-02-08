<?php
// Gestión avanzada de cookies

class CookieManager {
    
    // Nombres de cookies
    const COOKIE_ACEPTADAS = 'kairos_cookies_aceptadas';
    const COOKIE_PRIMERA_VISITA = 'kairos_primera_visita';
    const COOKIE_SUGERENCIA_REGISTRO = 'kairos_sugerencia_registro_mostrada';
    const COOKIE_ULTIMA_NOTIFICACION = 'kairos_ultima_notificacion';
    
    // Duraciones (en segundos)
    const DURACION_1_ANO = 365 * 24 * 60 * 60;
    const DURACION_30_DIAS = 30 * 24 * 60 * 60;
    
    // Verificar si aceptó cookies
    public static function cookiesAceptadas() {
        return isset($_COOKIE[self::COOKIE_ACEPTADAS]) && $_COOKIE[self::COOKIE_ACEPTADAS] === 'si';
    }
    
    // Marcar cookies como aceptadas
    public static function aceptarCookies() {
        setcookie(self::COOKIE_ACEPTADAS, 'si', time() + self::DURACION_1_ANO, '/', '', true, true);
        setcookie(self::COOKIE_PRIMERA_VISITA, 'no', time() + self::DURACION_1_ANO, '/', '', false, false);
    }
    
    // Verificar si es primera visita
    public static function esPrimeraVisita() {
        return !isset($_COOKIE[self::COOKIE_PRIMERA_VISITA]);
    }
    
    // Mostrar sugerencia de registro
    public static function mostrarSugerenciaRegistro() {
        if (isset($_COOKIE[self::COOKIE_SUGERENCIA_REGISTRO])) {
            return false;
        }
        
        if (isset($_SESSION['usuario_id'])) {
            return false;
        }
        
        if (!self::cookiesAceptadas()) {
            return false;
        }
        
        return self::esPrimeraVisita();
    }
    
    // Marcar sugerencia de registro como mostrada
    public static function marcarSugerenciaRegistroMostrada() {
        setcookie(self::COOKIE_SUGERENCIA_REGISTRO, 'si', time() + self::DURACION_1_ANO, '/', '', false, false);
    }
    
    // Mostrar notificación de novedades (1 vez al mes)
    public static function mostrarNotificacionNovedades() {
        if (!self::cookiesAceptadas()) {
            return false;
        }
        
        if (!isset($_SESSION['usuario_id'])) {
            return false;
        }
        
        if (!isset($_COOKIE[self::COOKIE_ULTIMA_NOTIFICACION])) {
            return true;
        }
        
        $ultimaNotificacion = (int)$_COOKIE[self::COOKIE_ULTIMA_NOTIFICACION];
        $unMes = 30 * 24 * 60 * 60;
        
        return (time() - $ultimaNotificacion) >= $unMes;
    }
    
    // Marcar notificación de novedades como mostrada
    public static function marcarNotificacionMostrada() {
        setcookie(self::COOKIE_ULTIMA_NOTIFICACION, (string)time(), time() + self::DURACION_1_ANO, '/', '', false, false);
    }
    
    // Generar modal de aceptación de cookies
    public static function generarModalCookies() {
        if (self::cookiesAceptadas()) {
            return '';
        }
        
        return '
        <!-- Modal Cookies -->
        <div class="modal fade" id="cookiesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            Uso de Cookies
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
                                Al continuar navegando en nuestro sitio, aceptas el uso de cookies conforme a nuestra política de privacidad.
                            </small>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-lg w-100" id="aceptarCookiesBtn">
                            Aceptar y Continuar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cookiesModal = new bootstrap.Modal(document.getElementById("cookiesModal"));
            cookiesModal.show();
            
            document.getElementById("aceptarCookiesBtn").addEventListener("click", function() {
                fetch("aceptar_cookies.php", {
                    method: "POST"
                }).then(() => {
                    cookiesModal.hide();
                    location.reload();
                });
            });
        });
        </script>';
    }
    
    // Generar modal de sugerencia de registro
    public static function generarModalSugerenciaRegistro() {
        if (!self::mostrarSugerenciaRegistro()) {
            return '';
        }
        
        // Marcar como mostrada
        self::marcarSugerenciaRegistroMostrada();
        
        return '
        <!-- Modal Sugerencia Registro -->
        <div class="modal fade" id="sugerenciaRegistroModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            ¡Únete a Kairos!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 class="mb-3">¿Te gustaría registrarte?</h4>
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
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const registroModal = new bootstrap.Modal(document.getElementById("sugerenciaRegistroModal"));
                registroModal.show();
            }, 3000);
        });
        </script>';
    }
    
    // Generar modal de novedades mensuales
    public static function generarModalNovedades() {
        if (!self::mostrarNotificacionNovedades()) {
            return '';
        }
        
        // Marcar como mostrada
        self::marcarNotificacionMostrada();
        
        return '
        <!-- Modal Novedades -->
        <div class="modal fade" id="novedadesModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            Novedades de Este Mes
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4 class="mb-3">¡Hola ' . ($_SESSION['nombre'] ?? 'Usuario') . '!</h4>
                        <p class="mb-4">
                            Tenemos grandes novedades para ti este mes:
                        </p>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">🆕 Nuevos Lanzamientos</h5>
                                        <p class="card-text">
                                            Descubre los últimos títulos que han llegado a nuestra tienda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Ofertas Exclusivas</h5>
                                        <p class="card-text">
                                            Hasta 50% de descuento en juegos seleccionados solo para usuarios registrados.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Promociones Especiales</h5>
                                        <p class="card-text">
                                            Participa en nuestros sorteos y gana productos gratis.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Eventos</h5>
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