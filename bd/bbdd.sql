-- ============================================
-- BBDD: Kairos Gaming Store
-- ============================================

DROP DATABASE IF EXISTS kairos-daniel;
CREATE DATABASE kairos-daniel CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE kairos-daniel;

-- ============================================
-- TABLAS MAESTRAS / CATÁLOGOS
-- ============================================

CREATE TABLE plataforma (
  id INT AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (nombre)
);

CREATE TABLE modo_juego (
  id INT AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (nombre)
);

CREATE TABLE genero (
  id INT AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (nombre)
);

CREATE TABLE rol (
  id INT AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (nombre)
);

-- ============================================
-- PRODUCTO
-- ============================================

CREATE TABLE producto (
  id INT AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  cover VARCHAR(255) NOT NULL,
  platform_id INT NOT NULL,
  descuento INT NOT NULL DEFAULT 0,
  precio DECIMAL(10,2) NOT NULL,
  modo INT NOT NULL,
  descripcion LONGTEXT NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  fecha_lanzamiento DATE,
  
  PRIMARY KEY (id),
  FOREIGN KEY (platform_id) REFERENCES plataforma(id),
  FOREIGN KEY (modo) REFERENCES modo_juego(id)
);

-- ============================================
-- RELACIÓN PRODUCTO - GENERO (N:M)
-- ============================================

CREATE TABLE producto_genero (
  id_producto INT NOT NULL,
  id_genero INT NOT NULL,
  PRIMARY KEY (id_producto, id_genero),
  FOREIGN KEY (id_producto) REFERENCES producto(id) ON DELETE CASCADE,
  FOREIGN KEY (id_genero) REFERENCES genero(id) ON DELETE CASCADE
);

-- ============================================
-- USUARIO
-- ============================================

CREATE TABLE usuario (
  id INT AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  apellidos VARCHAR(150) NOT NULL,
  correo VARCHAR(150) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  codigo_postal VARCHAR(10) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  rol INT NOT NULL,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  activo BOOLEAN DEFAULT TRUE,
  
  PRIMARY KEY (id),
  UNIQUE (username),
  UNIQUE (correo),
  FOREIGN KEY (rol) REFERENCES rol(id)
);

-- ============================================
-- FAVORITOS (USUARIO - PRODUCTO) (N:M)
-- ============================================

CREATE TABLE wishlist (
  id_usuario INT NOT NULL,
  id_producto INT NOT NULL,
  fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (id_usuario, id_producto),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES producto(id) ON DELETE CASCADE
);

-- ============================================
-- CARRITO
-- ============================================

CREATE TABLE carrito (
  id INT AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (id_usuario),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE carrito_producto (
  id_carrito INT NOT NULL,
  id_producto INT NOT NULL,
  cantidad INT NOT NULL,
  fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (id_carrito, id_producto),
  FOREIGN KEY (id_carrito) REFERENCES carrito(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES producto(id) ON DELETE CASCADE
);

-- ============================================
-- PEDIDO
-- ============================================

CREATE TABLE pedido (
  id INT AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  fecha DATETIME NOT NULL,
  estado VARCHAR(50) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  ciudad VARCHAR(100) NOT NULL,
  codigo_postal VARCHAR(10) NOT NULL,
  direccion_envio VARCHAR(255) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  
  PRIMARY KEY (id),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE pedido_linea (
  id_pedido INT NOT NULL,
  id_producto INT NOT NULL,
  cantidad INT NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  
  PRIMARY KEY (id_pedido, id_producto),
  FOREIGN KEY (id_pedido) REFERENCES pedido(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES producto(id) ON DELETE CASCADE
);

-- ============================================
-- RECIBOS
-- ============================================

CREATE TABLE recibo (
  id INT AUTO_INCREMENT,
  id_pedido INT NOT NULL UNIQUE,
  numero_recibo VARCHAR(50) UNIQUE NOT NULL,
  fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  metodo_pago VARCHAR(50),
  
  PRIMARY KEY (id),
  FOREIGN KEY (id_pedido) REFERENCES pedido(id) ON DELETE CASCADE
);

-- ============================================
-- DEVOLUCIONES
-- ============================================

CREATE TABLE devolucion (
  id INT AUTO_INCREMENT,
  id_pedido INT NOT NULL,
  razon VARCHAR(255) NOT NULL,
  estado VARCHAR(50) DEFAULT 'solicitada',
  fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_procesado TIMESTAMP,
  
  PRIMARY KEY (id),
  FOREIGN KEY (id_pedido) REFERENCES pedido(id) ON DELETE CASCADE
);

-- ============================================
-- VALORACIÓN DE PRODUCTOS
-- ============================================

CREATE TABLE valoracion_producto (
  id_usuario INT NOT NULL,
  id_producto INT NOT NULL,
  puntuacion INT NOT NULL DEFAULT 5 CHECK (puntuacion >= 1 AND puntuacion <= 5),
  comentario VARCHAR(500),
  fecha_valoracion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (id_usuario, id_producto),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES producto(id) ON DELETE CASCADE
);



-- ============================================
-- ÍNDICES PARA OPTIMIZAR BÚSQUEDAS
-- ============================================

CREATE INDEX idx_usuarios_correo ON usuario(correo);
CREATE INDEX idx_usuarios_username ON usuario(username);
CREATE INDEX idx_usuarios_rol ON usuario(rol);
CREATE INDEX idx_producto_plataforma ON producto(platform_id);
CREATE INDEX idx_producto_modo ON producto(modo);
CREATE INDEX idx_valoracion_producto ON valoracion_producto(id_producto);
CREATE INDEX idx_valoracion_usuario ON valoracion_producto(id_usuario);
CREATE INDEX idx_carrito_usuario ON carrito(id_usuario);
CREATE INDEX idx_wishlist_usuario ON wishlist(id_usuario);
CREATE INDEX idx_pedido_usuario ON pedido(id_usuario);
CREATE INDEX idx_recibo_pedido ON recibo(id_pedido);
CREATE INDEX idx_devolucion_pedido ON devolucion(id_pedido);


-- ============================================
-- INSERTAR DATOS MAESTROS
-- ============================================

INSERT INTO plataforma (nombre) VALUES
('Xbox Series X'),
('PlayStation 5'),
('Nintendo Switch'),
('PC');

INSERT INTO modo_juego (nombre) VALUES
('Single Player'),
('Multiplayer'),
('Cooperativo'),
('Online');

INSERT INTO genero (nombre) VALUES
('Acción'),
('RPG'),
('Aventura'),
('Estrategia'),
('Shooter'),
('Puzzle'),
('Deportes'),
('Carreras');

INSERT INTO rol (nombre) VALUES
('administrador'),
('trabajador'),
('cliente');

-- ============================================
-- INSERTAR USUARIOS
-- ============================================

INSERT INTO usuario (username, password, nombre, apellidos, correo, fecha_nacimiento, codigo_postal, telefono, rol) VALUES
('admin', '$2y$10$PZJh0K8e9s2wH7Q5mV3N0OqWxY1Z2A3B4C5D6E7F8G9H0I1J2K3L4', 'Admin', 'Sistema Principal', 'admin@kairos.com', '1990-01-15', '28001', '600123456', 1),
('editor_juan', '$2y$10$PZJh0K8e9s2wH7Q5mV3N0OqWxY1Z2A3B4C5D6E7F8G9H0I1J2K3L4', 'Juan', 'García López', 'juan@kairos.com', '1992-05-20', '08002', '601234567', 2),
('usuario_maria', '$2y$10$PZJh0K8e9s2wH7Q5mV3N0OqWxY1Z2A3B4C5D6E7F8G9H0I1J2K3L4', 'María', 'Rodríguez Martínez', 'maria@kairos.com', '1995-11-10', '46001', '602345678', 3),
('usuario_carlos', '$2y$10$PZJh0K8e9s2wH7Q5mV3N0OqWxY1Z2A3B4C5D6E7F8G9H0I1J2K3L4', 'Carlos', 'López García', 'carlos@kairos.com', '1988-03-25', '41001', '603456789', 3),
('usuario_ana', '$2y$10$PZJh0K8e9s2wH7Q5mV3N0OqWxY1Z2A3B4C5D6E7F8G9H0I1J2K3L4', 'Ana', 'Fernández Sánchez', 'ana@kairos.com', '1998-07-14', '29001', '604567890', 3);

-- ============================================
-- INSERTAR PRODUCTOS
-- ============================================

INSERT INTO producto (titulo, cover, platform_id, descuento, precio, modo, descripcion, stock, fecha_lanzamiento) VALUES
('Starfield', 'starfield.jpg', 4, 0, 59.99, 1, 'Juego de exploración espacial de Bethesda. Explora miles de planetas en una aventura única.', 15, '2023-09-06'),
('Final Fantasy XVI', 'ff16.jpg', 2, 10, 69.99, 1, 'RPG de acción de Square Enix con combate dinámico y una historia épica.', 20, '2023-06-22'),
('The Legend of Zelda: Tears of the Kingdom', 'zelda.jpg', 3, 0, 59.99, 1, 'Aventura épica en Hyrule con nuevas mecánicas de juego.', 25, '2023-05-12'),
('Baldur\'s Gate 3', 'bg3.jpg', 4, 15, 59.99, 3, 'RPG por turnos de Larian Studios con historias ramificadas y decisiones impactantes.', 30, '2023-08-03'),
('Elden Ring', 'elden.jpg', 2, 5, 59.99, 1, 'Action RPG de FromSoftware con combate desafiante en un mundo abierto.', 18, '2022-02-25'),
('Cyberpunk 2077', 'cyberpunk.jpg', 4, 20, 39.99, 1, 'Juego de rol futurista en la ciudad de Night City con múltiples caminos de historia.', 12, '2020-12-10');

-- ============================================
-- INSERTAR GÉNEROS A PRODUCTOS
-- ============================================

INSERT INTO producto_genero (id_producto, id_genero) VALUES
(1, 2), (1, 3),
(2, 2), (2, 3),
(3, 3),
(4, 2), (4, 3),
(5, 1), (5, 2),
(6, 1), (6, 2);

-- ============================================
-- INSERTAR CARRITO
-- ============================================

INSERT INTO carrito (id_usuario) VALUES (3), (4), (5);

INSERT INTO carrito_producto (id_carrito, id_producto, cantidad) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 5, 1);

-- ============================================
-- INSERTAR WISHLIST
-- ============================================

INSERT INTO wishlist (id_usuario, id_producto) VALUES
(3, 3),
(3, 4),
(4, 2),
(5, 6);

-- ============================================
-- INSERTAR PEDIDOS
-- ============================================

INSERT INTO pedido (id_usuario, fecha, estado, total, ciudad, codigo_postal, direccion_envio, telefono) VALUES
(3, NOW(), 'completado', 129.98, 'Valencia', '46001', 'Calle Principal 123', '602345678'),
(4, NOW(), 'completado', 59.99, 'Madrid', '28001', 'Avenida Gran Vía 456', '603456789'),
(5, NOW(), 'pendiente', 39.99, 'Barcelona', '08002', 'Paseo de Gracia 789', '604567890');

INSERT INTO pedido_linea (id_pedido, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 1, 59.99),
(1, 2, 1, 69.99),
(2, 5, 1, 59.99),
(3, 6, 1, 39.99);

-- ============================================
-- INSERTAR RECIBOS
-- ============================================

INSERT INTO recibo (id_pedido, numero_recibo, metodo_pago) VALUES
(1, 'REC-2024-001', 'tarjeta_credito'),
(2, 'REC-2024-002', 'paypal'),
(3, 'REC-2024-003', 'tarjeta_credito');

-- ============================================
-- INSERTAR DEVOLUCIONES
-- ============================================

INSERT INTO devolucion (id_pedido, razon, estado) VALUES
(1, 'Producto defectuoso', 'aprobada');

-- ============================================
-- INSERTAR VALORACIONES DE PRODUCTOS
-- ============================================

INSERT INTO valoracion_producto (id_usuario, id_producto, puntuacion, comentario) VALUES
(3, 1, 5, 'Excelente juego, muy completo'),
(3, 2, 4, 'Muy bueno, aunque algo caro'),
(4, 5, 5, 'Elden Ring es increíble'),
(5, 6, 4, 'Cyberpunk mejoró mucho con los updates');