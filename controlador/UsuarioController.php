<?php
require_once __DIR__ . "/../modelo/Conexion.php";
require_once __DIR__ . "/../modelo/Usuario.php";
require_once __DIR__ . "/../config_oauth.php";


class UsuarioController {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // ============================================
    // LOGIN TRADICIONAL
    // ============================================
    public function login($username, $password) {
        try {
            // Validar que no estén vacíos
            if (empty($username) || empty($password)) {
                return ["success" => false, "message" => "Usuario y contraseña requeridos"];
            }

            // Buscar usuario por username o email
            $sql = "SELECT * FROM usuario WHERE username = :username OR correo = :correo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return ["success" => false, "message" => "Usuario no encontrado"];
            }

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar que el usuario esté activo
            if (!$usuario['activo']) {
                return ["success" => false, "message" => "Usuario desactivado"];
            }

            // Verificar contraseña
            if (!password_verify($password, $usuario['password'])) {
                return ["success" => false, "message" => "Contraseña incorrecta"];
            }

            // Login exitoso - crear sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['correo'] = $usuario['correo'];

            return ["success" => true, "message" => "Login exitoso", "usuario" => $usuario];

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error en el servidor: " . $e->getMessage()];
        }
    }

    // ============================================
    // REGISTRO
    // ============================================
    public function registrar($datos) {
        try {
            // Validar campos obligatorios
            $camposObligatorios = ['username', 'password', 'nombre', 'apellidos', 'correo', 'fecha_nacimiento', 'codigo_postal', 'telefono'];
            
            foreach ($camposObligatorios as $campo) {
                if (empty($datos[$campo])) {
                    return ["success" => false, "message" => "Campo requerido: $campo"];
                }
            }

            // Validar email
            if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
                return ["success" => false, "message" => "Email no válido"];
            }

            // Validar teléfono (9 dígitos)
            if (!preg_match('/^\d{9}$/', $datos['telefono'])) {
                return ["success" => false, "message" => "Teléfono debe tener 9 dígitos"];
            }

            // Validar código postal (5 dígitos)
            if (!preg_match('/^\d{5}$/', $datos['codigo_postal'])) {
                return ["success" => false, "message" => "Código postal debe tener 5 dígitos"];
            }

            // Validar contraseña fuerte (minúscula, mayúscula, número, carácter especial)
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $datos['password'])) {
                return ["success" => false, "message" => "Contraseña debe tener: minúscula, mayúscula, número, carácter especial (@$!%*?&) y 8+ caracteres"];
            }

            // Validar username (alfanumérico, 3-50 caracteres)
            if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $datos['username'])) {
                return ["success" => false, "message" => "Username: alfanumérico/guion bajo, 3-50 caracteres"];
            }

            // Validar fecha de nacimiento (mayor de 18 años)
            $fecha = DateTime::createFromFormat('Y-m-d', $datos['fecha_nacimiento']);
            if (!$fecha) {
                return ["success" => false, "message" => "Formato de fecha inválido"];
            }
            $today = new DateTime();
            $age = $today->diff($fecha)->y;
            if ($age < 18) {
                return ["success" => false, "message" => "Debes ser mayor de 18 años"];
            }

            // Verificar si usuario ya existe
            $sql = "SELECT id FROM usuario WHERE username = :username OR correo = :correo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':username', $datos['username'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ["success" => false, "message" => "Usuario o email ya registrado"];
            }

            // Hashear contraseña
            $passwordHasheada = password_hash($datos['password'], PASSWORD_BCRYPT);

            // Insertar nuevo usuario
            $sql = "INSERT INTO usuario (username, password, nombre, apellidos, correo, fecha_nacimiento, codigo_postal, telefono, rol, activo) 
                    VALUES (:username, :password, :nombre, :apellidos, :correo, :fecha_nacimiento, :codigo_postal, :telefono, 3, 1)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':username', $datos['username'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHasheada, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $datos['apellidos'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR);
            $stmt->bindParam(':codigo_postal', $datos['codigo_postal'], PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ["success" => true, "message" => "Registro exitoso"];
            } else {
                return ["success" => false, "message" => "Error al registrar usuario"];
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }

    // ============================================
    // GOOGLE OAUTH LOGIN
    // ============================================
    public function loginGoogle($googleToken) {
        try {
            if (empty($googleToken)) {
                return ["success" => false, "message" => "Token de Google inválido"];
            }

            // Decodificar JWT (versión simplificada)
            $parts = explode('.', $googleToken);
            if (count($parts) !== 3) {
                return ["success" => false, "message" => "Token inválido"];
            }

            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
            
            if (!$payload) {
                return ["success" => false, "message" => "No se pudo procesar el token"];
            }

            $googleEmail = $payload['email'] ?? null;
            $googleNombre = $payload['given_name'] ?? '';
            $googleApellido = $payload['family_name'] ?? '';

            if (!$googleEmail) {
                return ["success" => false, "message" => "Email de Google no disponible"];
            }

            // Buscar usuario por email
            $sql = "SELECT * FROM usuario WHERE correo = :correo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':correo', $googleEmail, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Usuario existe, login
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$usuario['activo']) {
                    return ["success" => false, "message" => "Usuario desactivado"];
                }

                // Crear sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['rol'] = $usuario['rol'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['correo'] = $usuario['correo'];

                return ["success" => true, "message" => "Login con Google exitoso", "usuario" => $usuario];

            } else {
                // Crear nuevo usuario desde Google
                $username = str_replace(' ', '_', strtolower($googleNombre . $googleApellido));
                $passwordAleatorio = bin2hex(random_bytes(16));
                $passwordHasheada = password_hash($passwordAleatorio, PASSWORD_BCRYPT);

                $sql = "INSERT INTO usuario (username, password, nombre, apellidos, correo, rol, activo) 
                        VALUES (:username, :password, :nombre, :apellidos, :correo, 3, 1)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $passwordHasheada, PDO::PARAM_STR);
                $stmt->bindParam(':nombre', $googleNombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellidos', $googleApellido, PDO::PARAM_STR);
                $stmt->bindParam(':correo', $googleEmail, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $usuarioId = $this->conexion->lastInsertId();

                    $_SESSION['usuario_id'] = $usuarioId;
                    $_SESSION['username'] = $username;
                    $_SESSION['rol'] = 3;
                    $_SESSION['nombre'] = $googleNombre;
                    $_SESSION['correo'] = $googleEmail;

                    return ["success" => true, "message" => "Usuario creado y login exitoso"];
                } else {
                    return ["success" => false, "message" => "Error al crear usuario"];
                }
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }

    // ============================================
    // LOGOUT
    // ============================================
    public function logout() {
        // Borrar cookie de remember me si existe
        if (isset($_COOKIE[COOKIE_NAME])) {
            setcookie(COOKIE_NAME, '', time() - 3600, '/', '', true, true);
            
            // Eliminar token de BD
            if (isset($_SESSION['usuario_id'])) {
                try {
                    $sql = "UPDATE usuario SET remember_token = NULL WHERE id = :id";
                    $stmt = $this->conexion->prepare($sql);
                    $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
                    $stmt->execute();
                } catch (Exception $e) {
                    // Silencioso
                }
            }
        }

        // Destruir todas las variables de sesión
        $_SESSION = [];

        // Si se desea destruir la sesión completamente, borrar también la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión
        session_destroy();
        return ["success" => true, "message" => "Sesión cerrada"];
    }

    // ============================================
    // REMEMBER ME - CREAR COOKIE
    // ============================================
    public function crearRememberMe($usuario_id) {
        try {
            // Generar token único
            $token = bin2hex(random_bytes(32));
            $hashedToken = password_hash($token, PASSWORD_BCRYPT);
            
            // Guardar token en BD
            $sql = "UPDATE usuario SET remember_token = :token WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':token', $hashedToken, PDO::PARAM_STR);
            $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Crear cookie (httponly y secure)
            setcookie(COOKIE_NAME, $usuario_id . ':' . $token, time() + COOKIE_EXPIRY, '/', '', true, true);
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // ============================================
    // REMEMBER ME - VALIDAR COOKIE Y AUTO-LOGIN
    // ============================================
    public function validarRememberMe() {
        if (!isset($_COOKIE[COOKIE_NAME])) {
            return false;
        }

        try {
            $cookie = $_COOKIE[COOKIE_NAME];
            $parts = explode(':', $cookie, 2);
            
            if (count($parts) !== 2) {
                return false;
            }
            
            list($usuario_id, $token) = $parts;
            
            // Buscar usuario
            $sql = "SELECT * FROM usuario WHERE id = :id AND activo = 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                return false;
            }
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar token
            if (empty($usuario['remember_token']) || !password_verify($token, $usuario['remember_token'])) {
                return false;
            }
            
            // Auto-login exitoso
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['correo'] = $usuario['correo'];
            
            // Renovar cookie
            $this->crearRememberMe($usuario_id);
            
            return true;
            
        } catch (Exception $e) {
            return false;
        }
    }

    // ============================================
    // VERIFICAR RECAPTCHA
    // ============================================
    public function verificarRecaptcha($recaptchaResponse) {
        if (empty($recaptchaResponse)) {
            return false;
        }

        $data = [
            'secret' => RECAPTCHA_SECRET_KEY,
            'response' => $recaptchaResponse
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        
        if ($result === false) {
            return false;
        }

        $resultJson = json_decode($result);
        return $resultJson->success ?? false;
    }

    // ============================================
    // OBTENER USUARIO ACTUAL
    // ============================================
    public function usuarioActual() {
        if (!isset($_SESSION['usuario_id'])) {
            return null;
        }

        $sql = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================================
    // VERIFICAR SESIÓN
    // ============================================
    public function verificarSesion() {
        return isset($_SESSION['usuario_id']);
    }

    // ============================================
    // OBTENER USUARIO POR ID
    // ============================================
    public function obtenerUsuario($id) {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Métodos adicionales para UsuarioController.php
// Agregar estos métodos a la clase UsuarioController existente

    // ============================================
    // OBTENER TODOS LOS USUARIOS (ADMIN)
    // ============================================
    public function obtenerTodosUsuarios() {
        try {
            $sql = "SELECT u.*, r.nombre as rol_nombre 
                    FROM usuario u
                    LEFT JOIN rol r ON u.rol = r.id
                    ORDER BY u.id DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // OBTENER ROLES
    // ============================================
    public function obtenerRoles() {
        try {
            $sql = "SELECT * FROM rol ORDER BY id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // ACTUALIZAR USUARIO (ADMIN)
    // ============================================
    public function actualizarUsuario($datos) {
        try {
            // Validar que el ID esté presente
            if (empty($datos['id'])) {
                return ["success" => false, "message" => "ID de usuario requerido"];
            }

            // Si se proporciona nueva contraseña, validarla y hashearla
            if (!empty($datos['password'])) {
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $datos['password'])) {
                    return ["success" => false, "message" => "Contraseña debe tener: minúscula, mayúscula, número, carácter especial y 8+ caracteres"];
                }
                $passwordHasheada = password_hash($datos['password'], PASSWORD_BCRYPT);
                $actualizarPassword = true;
            } else {
                $actualizarPassword = false;
            }

            // Validar email
            if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
                return ["success" => false, "message" => "Email no válido"];
            }

            // Validar teléfono
            if (!preg_match('/^\d{9}$/', $datos['telefono'])) {
                return ["success" => false, "message" => "Teléfono debe tener 9 dígitos"];
            }

            // Validar código postal
            if (!preg_match('/^\d{5}$/', $datos['codigo_postal'])) {
                return ["success" => false, "message" => "Código postal debe tener 5 dígitos"];
            }

            // Verificar si username o email ya existen en otro usuario
            $sql = "SELECT id FROM usuario WHERE (username = :username OR correo = :correo) AND id != :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':username', $datos['username'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $datos['id'], PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ["success" => false, "message" => "Username o email ya existe"];
            }

            // Actualizar usuario
            if ($actualizarPassword) {
                $sql = "UPDATE usuario SET 
                        username = :username,
                        password = :password,
                        nombre = :nombre,
                        apellidos = :apellidos,
                        correo = :correo,
                        fecha_nacimiento = :fecha_nacimiento,
                        codigo_postal = :codigo_postal,
                        telefono = :telefono,
                        rol = :rol
                        WHERE id = :id";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':password', $passwordHasheada, PDO::PARAM_STR);
            } else {
                $sql = "UPDATE usuario SET 
                        username = :username,
                        nombre = :nombre,
                        apellidos = :apellidos,
                        correo = :correo,
                        fecha_nacimiento = :fecha_nacimiento,
                        codigo_postal = :codigo_postal,
                        telefono = :telefono,
                        rol = :rol
                        WHERE id = :id";
                $stmt = $this->conexion->prepare($sql);
            }

            $stmt->bindParam(':username', $datos['username'], PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $datos['apellidos'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR);
            $stmt->bindParam(':codigo_postal', $datos['codigo_postal'], PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
            $stmt->bindParam(':rol', $datos['rol'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $datos['id'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["success" => true, "message" => "Usuario actualizado correctamente"];
            } else {
                return ["success" => false, "message" => "Error al actualizar usuario"];
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }

    // ============================================
    // ELIMINAR USUARIO (ADMIN)
    // ============================================
    public function eliminarUsuario($id) {
        try {
            // No permitir eliminar al admin principal
            if ($id == 1) {
                return ["success" => false, "message" => "No se puede eliminar el administrador principal"];
            }

            $sql = "DELETE FROM usuario WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["success" => true, "message" => "Usuario eliminado correctamente"];
            } else {
                return ["success" => false, "message" => "Error al eliminar usuario"];
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }

    // ============================================
    // ACTIVAR/DESACTIVAR USUARIO
    // ============================================
    public function toggleActivo($id) {
        try {
            // No permitir desactivar al admin principal
            if ($id == 1) {
                return ["success" => false, "message" => "No se puede desactivar el administrador principal"];
            }

            $sql = "UPDATE usuario SET activo = NOT activo WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ["success" => true, "message" => "Estado del usuario actualizado"];
            } else {
                return ["success" => false, "message" => "Error al cambiar estado"];
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }


}

?>