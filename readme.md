# Kai2

Sitio web dinámico desarrollado con PHP, JavaScript, SCSS y Node.js.  
El proyecto incluye funcionalidades típicas de una plataforma con usuarios, catálogo, carrito y panel de administración.

---

## 📌 Descripción

**Kai2** es una aplicación web construida con tecnologías web clásicas que permite:

- Registro e inicio de sesión de usuarios  
- Gestión de carrito de compras  
- Navegación por categorías y plataformas (Nintendo, Playstation, Xbox, Steam, etc.)  
- Panel de administración  
- Integración con base de datos y lógica backend en PHP  

El proyecto está organizado de forma modular, facilitando su mantenimiento y ampliación.

---

## 🚀 Tecnologías utilizadas

- **PHP** – Lógica backend y gestión del servidor  
- **JavaScript** – Interactividad en el frontend  
- **SCSS / CSS** – Estilos y diseño responsive  
- **Node.js / npm** – Gestión de dependencias y scripts  
- **MySQL** – Base de datos (carpeta `bbdd`)  

---

## 📂 Estructura del proyecto

```text
/
├── admin/
├── assets/
├── bbdd/
├── controller/
├── css/
├── includes/
├── js/
├── modelo/
├── scss/
├── index.php
├── login.php
├── contact.php
├── package.json
└── README.md
```

## 🛠️ Instalación

Clona el repositorio:

git clone https://github.com/Baltany/kai2.git

y cambia a la rama ra4 con el comando 
```git
git checkout ra4
```

## 📌 Requisitos
Servidor local compatible con PHP (XAMPP, Laragon, WAMP, etc.)

MySQL para la base de datos

Node.js y npm (opcional, para SCSS o scripts)

## ⚙️ Configuración

Crea una base de datos en MySQL.

Importa el archivo SQL disponible en la carpeta bbdd/ (si existe).

Configura la conexión a la base de datos en los archivos correspondientes.

Instala dependencias de Node si es necesario:
```node
npm install
```
## ▶️ Uso
Inicia el servidor.(tanto de xampp como de node)

Accede desde el navegador:
http://localhost:[PUERTO]


## BBDD
Compo podrá observar la clave no está en texto plano asi que esta es(admin y demas usuarios tienen la misma): 123456
```sql
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-02-2026 a las 14:31:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kai2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `id_usuario`) VALUES
(4, 1),
(5, 2),
(2, 4),
(3, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_producto`
--

CREATE TABLE `carrito_producto` (
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito_producto`
--

INSERT INTO `carrito_producto` (`id_carrito`, `id_producto`, `cantidad`, `fecha_agregado`) VALUES
(1, 2, 1, '2026-01-28 16:34:33'),
(1, 5, 1, '2026-02-06 13:03:06'),
(2, 2, 2, '2026-02-02 14:14:02'),
(2, 5, 1, '2026-01-28 16:34:33'),
(2, 9, 1, '2026-02-02 18:07:40'),
(2, 10, 1, '2026-02-02 17:57:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cookie`
--

CREATE TABLE `cookie` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo` varchar(50) NOT NULL,
  `valor` varchar(50) NOT NULL,
  `fecha_aceptacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE `devolucion` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `estado` varchar(50) DEFAULT 'solicitada',
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_procesado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `devolucion`
--

INSERT INTO `devolucion` (`id`, `id_pedido`, `razon`, `estado`, `fecha_solicitud`, `fecha_procesado`) VALUES
(1, 1, 'Producto defectuoso', 'aprobada', '2026-01-28 16:34:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `nombre`) VALUES
(1, 'Acción'),
(3, 'Aventura'),
(8, 'Carreras'),
(7, 'Deportes'),
(4, 'Estrategia'),
(6, 'Puzzle'),
(2, 'RPG'),
(5, 'Shooter');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modo_juego`
--

CREATE TABLE `modo_juego` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modo_juego`
--

INSERT INTO `modo_juego` (`id`, `nombre`) VALUES
(3, 'Cooperativo'),
(2, 'Multiplayer'),
(4, 'Online'),
(1, 'Single Player');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `direccion_envio` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `id_usuario`, `fecha`, `estado`, `total`, `ciudad`, `codigo_postal`, `direccion_envio`, `telefono`) VALUES
(1, 3, '2026-01-28 17:34:33', 'completado', 129.98, 'Valencia', '46001', 'Calle Principal 123', '602345678'),
(2, 4, '2026-01-28 17:34:33', 'completado', 59.99, 'Madrid', '28001', 'Avenida Gran Vía 456', '603456789'),
(3, 5, '2026-01-28 17:34:33', 'pendiente', 39.99, 'Barcelona', '08002', 'Paseo de Gracia 789', '604567890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_linea`
--

CREATE TABLE `pedido_linea` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_linea`
--

INSERT INTO `pedido_linea` (`id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 2, 1, 69.99),
(2, 5, 1, 59.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataforma`
--

CREATE TABLE `plataforma` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plataforma`
--

INSERT INTO `plataforma` (`id`, `nombre`) VALUES
(3, 'Nintendo Switch'),
(4, 'PC'),
(2, 'PlayStation 5'),
(5, 'Steam'),
(1, 'Xbox Series X');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `descuento` int(11) NOT NULL DEFAULT 0,
  `precio` decimal(10,2) NOT NULL,
  `modo` int(11) NOT NULL,
  `descripcion` longtext NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `fecha_lanzamiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `titulo`, `cover`, `platform_id`, `descuento`, `precio`, `modo`, `descripcion`, `stock`, `fecha_lanzamiento`) VALUES
(2, 'Final Fantasy XVI', 'assets/img/fifa-22.jpg', 2, 10, 69.99, 1, 'RPG de acción de Square Enix con combate dinámico y una historia épica.', 20, '2023-06-22'),
(3, 'The Legend of Zelda: Tears of the Kingdom', 'assets/img/placeholder.png', 3, 10, 59.99, 1, 'Aventura épica en Hyrule con nuevas mecánicas de juego.', 25, '2023-05-12'),
(4, 'Baldur\'s Gate 3', 'assets/img/placeholder.png', 4, 15, 59.99, 3, 'RPG por turnos de Larian Studios con historias ramificadas y decisiones impactantes.', 30, '2023-08-03'),
(5, 'Elden Ring', 'assets/img/placeholder.png', 2, 5, 59.99, 1, 'Action RPG de FromSoftware con combate desafiante en un mundo abierto.', 18, '2022-02-25'),
(7, 'Halo Infinite', 'assets/img/placeholder.png', 1, 10, 59.99, 2, 'Shooter emblemático de Xbox con campaña y multijugador competitivo.', 20, '2021-12-08'),
(8, 'Forza Horizon 5', 'assets/img/placeholder.png', 1, 0, 69.99, 2, 'Juego de conducción en mundo abierto ambientado en México.', 25, '2021-11-09'),
(9, 'Counter-Strike 2', 'assets/img/placeholder.png', 5, 0, 10.00, 2, 'Shooter competitivo táctico por equipos, sucesor de CS:GO.', 999, '2023-09-27'),
(10, 'Hades', 'assets/img/placeholder.png', 5, 20, 24.99, 1, 'Roguelike de acción con narrativa profunda basada en la mitología griega.', 40, '2020-09-17'),
(11, 'Prueba', 'assets/img/1770310775_papelera.png', 1, 1, 10.00, 2, 'Juegaso para borrrar', 15, '2000-01-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_genero`
--

CREATE TABLE `producto_genero` (
  `id_producto` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_genero`
--

INSERT INTO `producto_genero` (`id_producto`, `id_genero`) VALUES
(2, 2),
(2, 3),
(3, 4),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(7, 1),
(7, 5),
(8, 8),
(9, 1),
(10, 1),
(10, 2),
(11, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE `recibo` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `numero_recibo` varchar(50) NOT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recibo`
--

INSERT INTO `recibo` (`id`, `id_pedido`, `numero_recibo`, `fecha_emision`, `metodo_pago`) VALUES
(1, 1, 'REC-2024-001', '2026-01-28 16:34:33', 'tarjeta_credito'),
(2, 2, 'REC-2024-002', '2026-01-28 16:34:33', 'paypal'),
(3, 3, 'REC-2024-003', '2026-01-28 16:34:33', 'tarjeta_credito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'administrador'),
(3, 'cliente'),
(2, 'trabajador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `rol` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password`, `nombre`, `apellidos`, `correo`, `fecha_nacimiento`, `codigo_postal`, `telefono`, `rol`, `fecha_creacion`, `activo`, `remember_token`) VALUES
(1, 'admin', '$2y$10$4Po/D/EF9bSBwlAjowcVJ.hF.GNj480i8ubK53882HOfdum5hjVS2', 'Admin', 'Sistema Principal', 'bmoylop0903@iesmarquesdecomares.org', '1990-01-15', '28001', '600123456', 1, '2026-01-28 16:34:33', 1, NULL),
(2, 'editor_juan', '$2y$10$4Po/D/EF9bSBwlAjowcVJ.hF.GNj480i8ubK53882HOfdum5hjVS2', 'Juan', 'García López', 'juan@kairos.com', '1992-05-20', '08002', '601234567', 2, '2026-01-28 16:34:33', 1, NULL),
(3, 'usuario_maria', '$2y$10$PZJh0K8e9s2wH7Q5mV3N0OqWxY1Z2A3B4C5D6E7F8G9H0I1J2K3L4', 'María', 'Rodríguez Martínez', 'maria@kairos.com', '1995-11-10', '46001', '602345678', 3, '2026-01-28 16:34:33', 1, NULL),
(4, 'usuario_carlos', '$2y$10$4Po/D/EF9bSBwlAjowcVJ.hF.GNj480i8ubK53882HOfdum5hjVS2', 'Carlos', 'López García', 'carlos@kairos.com', '1988-03-25', '41001', '603456789', 3, '2026-01-28 16:34:33', 1, NULL),
(5, 'usuario_ana', '$2y$10$4Po/D/EF9bSBwlAjowcVJ.hF.GNj480i8ubK53882HOfdum5hjVS2', 'Ana', 'Fernández Sánchez', 'ana@kairos.com', '1998-07-14', '29001', '604567890', 3, '2026-01-28 16:34:33', 1, NULL),
(6, 'kiwi', '$2y$10$4Po/D/EF9bSBwlAjowcVJ.hF.GNj480i8ubK53882HOfdum5hjVS2', 'balbino', 'kiwi', 'baltanyml@gmail.com', '2000-01-17', '14900', '666666666', 3, '2026-01-29 16:08:17', 1, '$2y$12$BtX73yuo01TTxAblnFJdH.8RWZwjz0O50Lp3ZB5kNPXo4NeGPLQfC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion_producto`
--

CREATE TABLE `valoracion_producto` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `puntuacion` int(11) NOT NULL DEFAULT 5 CHECK (`puntuacion` >= 1 and `puntuacion` <= 5),
  `comentario` varchar(500) DEFAULT NULL,
  `fecha_valoracion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoracion_producto`
--

INSERT INTO `valoracion_producto` (`id_usuario`, `id_producto`, `puntuacion`, `comentario`, `fecha_valoracion`) VALUES
(3, 2, 3, 'Muy bueno, aunque algo caro', '2026-02-05 17:03:24'),
(4, 5, 5, 'Elden Ring es increíble', '2026-01-28 16:34:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

CREATE TABLE `wishlist` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `wishlist`
--

INSERT INTO `wishlist` (`id_usuario`, `id_producto`, `fecha_agregado`) VALUES
(3, 3, '2026-01-28 16:34:33'),
(3, 4, '2026-01-28 16:34:33'),
(4, 2, '2026-01-28 16:34:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY `idx_carrito_usuario` (`id_usuario`);

--
-- Indices de la tabla `carrito_producto`
--
ALTER TABLE `carrito_producto`
  ADD PRIMARY KEY (`id_carrito`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `cookie`
--
ALTER TABLE `cookie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_devolucion_pedido` (`id_pedido`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `modo_juego`
--
ALTER TABLE `modo_juego`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pedido_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido_linea`
--
ALTER TABLE `pedido_linea`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `plataforma`
--
ALTER TABLE `plataforma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_producto_plataforma` (`platform_id`),
  ADD KEY `idx_producto_modo` (`modo`);

--
-- Indices de la tabla `producto_genero`
--
ALTER TABLE `producto_genero`
  ADD PRIMARY KEY (`id_producto`,`id_genero`),
  ADD KEY `id_genero` (`id_genero`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pedido` (`id_pedido`),
  ADD UNIQUE KEY `numero_recibo` (`numero_recibo`),
  ADD KEY `idx_recibo_pedido` (`id_pedido`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `idx_usuarios_correo` (`correo`),
  ADD KEY `idx_usuarios_username` (`username`),
  ADD KEY `idx_usuarios_rol` (`rol`);

--
-- Indices de la tabla `valoracion_producto`
--
ALTER TABLE `valoracion_producto`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`),
  ADD KEY `idx_valoracion_producto` (`id_producto`),
  ADD KEY `idx_valoracion_usuario` (`id_usuario`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `idx_wishlist_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cookie`
--
ALTER TABLE `cookie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `modo_juego`
--
ALTER TABLE `modo_juego`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `plataforma`
--
ALTER TABLE `plataforma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carrito_producto`
--
ALTER TABLE `carrito_producto`
  ADD CONSTRAINT `carrito_producto_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cookie`
--
ALTER TABLE `cookie`
  ADD CONSTRAINT `cookie_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `devolucion_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido_linea`
--
ALTER TABLE `pedido_linea`
  ADD CONSTRAINT `pedido_linea_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_linea_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`platform_id`) REFERENCES `plataforma` (`id`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`modo`) REFERENCES `modo_juego` (`id`);

--
-- Filtros para la tabla `producto_genero`
--
ALTER TABLE `producto_genero`
  ADD CONSTRAINT `producto_genero_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_genero_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `genero` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `recibo_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`);

--
-- Filtros para la tabla `valoracion_producto`
--
ALTER TABLE `valoracion_producto`
  ADD CONSTRAINT `valoracion_producto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `valoracion_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```

## 🧑‍💻 Autor

Balbino Moyano López
GitHub: https://github.com/Baltany