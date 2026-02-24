<a class="skip-to-content" href="#main-content">Saltar al contenido principal</a>
<nav class="kairos-header fixed-top" aria-label="Navegación principal">
    <div class="kairos-header-container">

        <!-- Logo -->
        <a class="kairos-logo" href="index.php">
            <img src="assets/img/logo150.png" alt="Kairos - Ir a inicio">
        </a>

        <!-- Barra grande: menú + buscador + lupa -->
        <div class="kairos-bar">
            <div class="kairos-menu-wrapper dropdown">
                <button class="kairos-menu-btn dropdown-toggle" type="button" id="kairosMenuDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menú de plataformas">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>

                <ul class="dropdown-menu kairos-menu-dropdown" aria-labelledby="kairosMenuDropdown">
                    <li><a class="dropdown-item" href="steam.php">Steam</a></li>
                    <li><a class="dropdown-item" href="playstation.php">PlayStation</a></li>
                    <li><a class="dropdown-item" href="xbox.php">Xbox</a></li>
                    <li><a class="dropdown-item" href="nintendo.php">Nintendo</a></li>
                    <li><a class="dropdown-item" href="plataformas.php">Otros</a></li>
                </ul>
            </div>

            <div class="kairos-search" role="search">
                <label for="kairos-search-input" class="visually-hidden">Buscar juegos</label>
                <input type="text" id="kairos-search-input" placeholder="Busca tus juegos favoritos...">
            </div>

            <button class="kairos-search-btn" type="button" aria-label="Buscar">
                <i class="fas fa-search" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Barra pequeña: usuario + carrito -->
        <div class="kairos-actions-bar">
            <a class="kairos-action-btn" href="login.php"
                aria-label="Iniciar sesión">
                <i class="fas fa-user" aria-hidden="true"></i>
            </a>
            <a class="kairos-action-btn" href="logout.php" aria-label="Cerrar sesión">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
            </a>
            <a class="kairos-action-btn" href="wishlist.php" aria-label="Lista de deseos">
                <i class="fas fa-star" aria-hidden="true"></i>
            </a>
            <a class="kairos-action-btn" href="recibos.php" aria-label="Mis recibos">
                <i class="fas fa-receipt" aria-hidden="true"></i>
            </a>
            <a class="kairos-action-btn" href="devoluciones.php" aria-label="Mis devoluciones">
                <i class="fas fa-box-open" aria-hidden="true"></i>
            </a>
            <button class="kairos-action-btn" type="button" id="openCartModal" aria-label="Abrir carrito de compras">
                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
            </button>
        </div>

    </div>
</nav>