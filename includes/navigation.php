<nav class="kairos-header fixed-top">
    <div class="kairos-header-container">

        <a class="kairos-logo" href="index.php">
            <img src="assets/img/logo150.png" alt="Kairos Logo">
        </a>

        <div class="kairos-bar">
            <div class="kairos-menu-wrapper dropdown">
                <button class="kairos-menu-btn dropdown-toggle" type="button"
                        id="kairosMenuDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>

                <ul class="dropdown-menu kairos-menu-dropdown" aria-labelledby="kairosMenuDropdown">
                    <li><a class="dropdown-item" href="steam.php">Steam</a></li>
                    <li><a class="dropdown-item" href="playstation.php">PlayStation</a></li>
                    <li><a class="dropdown-item" href="xbox.php">Xbox</a></li>
                    <li><a class="dropdown-item" href="nintendo.php">Nintendo</a></li>
                    <li><a class="dropdown-item" href="plataformas.php">Otros</a></li>
                </ul>
            </div>

            <div class="kairos-search">
                <input type="text" placeholder="Buscar...">
            </div>

            <button class="kairos-search-btn" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div class="kairos-actions-bar">
            <button class="kairos-action-btn" type="button" onclick="window.location.href='login.php'">
                <i class="fas fa-user"></i>
            </button>
            <a class="kairos-action-btn" href="wishlist.php">
                <i class="fas fa-star"></i>
            </a>
            <a class="kairos-action-btn" href="recibos.php">
                <i class="fas fa-receipt"></i>
            </a>
            <button class="kairos-action-btn" type="button" id="openCartModal" title="Carrito">
                <i class="fas fa-shopping-cart"></i>
            </button>
            <a class="kairos-action-btn" href="devoluciones.php">
                <i class="fas fa-box-open"></i>
            </a>
        </div>

    </div>
</nav>