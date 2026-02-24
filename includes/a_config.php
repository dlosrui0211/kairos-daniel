<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

	switch ($_SERVER["SCRIPT_NAME"]) {
		case "/index.php":
			$CURRENT_PAGE = "index"; 
			$PAGE_TITLE = "Index";
			break;
		case "/conocenos.php":
			$CURRENT_PAGE = "conocenos"; 
			$PAGE_TITLE = "Conócenos";
			break;
		case "/trabaja_con_nosotros.php":
			$CURRENT_PAGE = "trabaja_con_nosotros"; 
			$PAGE_TITLE = "Trabaja con Nosotros";
			break;
		case "/terminos_condiciones.php":
			$CURRENT_PAGE = "terminos_condiciones"; 
			$PAGE_TITLE = "Términos y Condiciones";
			break;
		case "/plataformas.php":
			$CURRENT_PAGE = "plataformas"; 
			$PAGE_TITLE = "Plataformas";
			break;
		case "/steam.php":
			$CURRENT_PAGE = "steam"; 
			$PAGE_TITLE = "Steam";
			break;
		case "/playstation.php":
			$CURRENT_PAGE = "playstation"; 
			$PAGE_TITLE = "Playstation";
			break;
		case "/xbox.php":
			$CURRENT_PAGE = "xbox"; 
			$PAGE_TITLE = "Xbox";
			break;
		case "/nintendo.php":
			$CURRENT_PAGE = "nintendo"; 
			$PAGE_TITLE = "Nintendo";
			break;
		case "/otros.php":
			$CURRENT_PAGE = "otros"; 
			$PAGE_TITLE = "Otros";
			break;
		case "/soporte.php":
			$CURRENT_PAGE = "soporte"; 
			$PAGE_TITLE = "Soporte";
			break;
		case "/recibos.php":
			$CURRENT_PAGE = "recibos"; 
			$PAGE_TITLE = "Recibos";
			break;
		case "/devoluciones.php":
			$CURRENT_PAGE = "devoluciones"; 
			$PAGE_TITLE = "Devoluciones";
			break;
		case "/login.php":
			$CURRENT_PAGE = "login"; 
			$PAGE_TITLE = "Login";
			break;
		case "/registro.php":
			$CURRENT_PAGE = "registro"; 
			$PAGE_TITLE = "Registro";
			break;
		case "/carrito.php":
			$CURRENT_PAGE = "carrito"; 
			$PAGE_TITLE = "Carrito";
			break;
		case "/zona_pago.php":
			$CURRENT_PAGE = "zona_pago"; 
			$PAGE_TITLE = "Zona de Pago";
			break;		
		case "/terninoslegales.php":
			$CURRENT_PAGE = "terninoslegales"; 
			$PAGE_TITLE = "Terminos legales";
			break;
		case "/valoracion.php":
			$CURRENT_PAGE = "valoracion"; 
			$PAGE_TITLE = "Valoracion";
			break;
		// ============================================
		// RUTAS DE ADMINISTRACIÓN
		// ============================================
		case "/admin/usuarios.php":
			$CURRENT_PAGE = "usuarios"; 
			$PAGE_TITLE = "Administrar Usuarios - Panel Admin";
			break;

		case "/admin/productos.php":
			$CURRENT_PAGE = "productos"; 
			$PAGE_TITLE = "Administrar Productos - Panel Admin";
			break;

		case "/admin/valoraciones.php":
			$CURRENT_PAGE = "valoraciones"; 
			$PAGE_TITLE = "Administrar Valoraciones - Panel Admin";
			break;

		default:
			$CURRENT_PAGE = "index";
			$PAGE_TITLE = "Kairos - Tu página de claves";
		}
?>