<?php
class CaptchaMath {
    
    // Generar operación matemática aleatoria
    public static function generar() {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operadores = ['+', '-', '*'];
        $operador = $operadores[array_rand($operadores)];
        
        switch ($operador) {
            case '+':
                $respuesta = $num1 + $num2;
                break;
            case '-':
                // Evitar resultados negativos
                if ($num1 < $num2) {
                    $temp = $num1;
                    $num1 = $num2;
                    $num2 = $temp;
                }
                $respuesta = $num1 - $num2;
                break;
            case '*':
                $respuesta = $num1 * $num2;
                break;
        }
        
        $pregunta = "$num1 $operador $num2";
        
        // Guardar en sesión
        $_SESSION['captcha_respuesta'] = $respuesta;
        $_SESSION['captcha_generado_en'] = time();
        
        return [
            'pregunta' => $pregunta,
            'respuesta' => $respuesta
        ];
    }
    
    // Verificar respuesta del usuario
    public static function verificar($respuestaUsuario) {
        // Verificar que existe captcha en sesión
        if (!isset($_SESSION['captcha_respuesta'])) {
            return false;
        }
        
        // Verificar timeout (5 minutos)
        if (isset($_SESSION['captcha_generado_en'])) {
            $tiempoTranscurrido = time() - $_SESSION['captcha_generado_en'];
            if ($tiempoTranscurrido > 300) { // 5 minutos
                self::limpiar();
                return false;
            }
        }
        
        // Verificar respuesta
        $correcto = ((int)$respuestaUsuario === (int)$_SESSION['captcha_respuesta']);
        
        // Limpiar captcha después de verificar
        self::limpiar();
        
        return $correcto;
    }
    
    // Limpiar captcha de sesión
    public static function limpiar() {
        unset($_SESSION['captcha_respuesta']);
        unset($_SESSION['captcha_generado_en']);
    }
    
    // Generar HTML del captcha
    public static function generarHTML() {
        $captcha = self::generar();
        
        $html = '
        <div class="captcha-container mb-3">
            <label class="form-label fw-500">Verificación Anti-Bot</label>
            <div class="captcha-question-box p-3 bg-light border rounded">
                <p class="mb-2 text-center">
                    <strong>Resuelve esta operación:</strong>
                </p>
                <p class="captcha-question text-center fs-3 mb-0">
                    <span class="badge bg-primary">' . htmlspecialchars($captcha['pregunta']) . ' = ?</span>
                </p>
            </div>
            <input type="number" 
                id="captcha_respuesta" 
                name="captcha_respuesta" 
                class="form-control form-control-lg mt-2" 
                placeholder="Tu respuesta" 
                required>
            <small class="text-muted">Completa la operación para continuar</small>
        </div>';
        
        return $html;
    }
}
?>