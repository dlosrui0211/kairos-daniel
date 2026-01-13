<?php
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartModal" aria-labelledby="cartModalLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartModalLabel">Tu Carrito</h5>
        <button type="button" id="closeCartModal" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <div class="offcanvas-body">
        <div class="product-list" id="productList">
            
            <div class="list-group-item elemento-carrito" data-product-id="1" data-price="99">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <img src="assets/img/fc26.jpg" alt="EA Sports FC 26" 
                            class="car-tula rounded" style="width: 70px; height: 70px; object-fit: cover;">
                    </div>
                    
                    <div class="flex-grow-1">
                        <h6 class="mb-1 producto-title">EA Sports FC 26</h6>
                        <p class="mb-0 product-price">99€</p>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <div class="item-quantity">
                            <button class="quantity-btn decrement-btn" aria-label="Disminuir cantidad">−</button>
                            <span class="quantity-display" data-quantity>1</span>
                            <button class="quantity-btn increment-btn" aria-label="Aumentar cantidad">+</button>
                        </div>
                        
                        <button class="btn btn-sm remove-item-btn" aria-label="Eliminar producto">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="list-group-item elemento-carrito" data-product-id="2" data-price="49">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <img src="assets/img/fc26.jpg" alt="God of War" 
                            class="car-tula rounded" style="width: 70px; height: 70px; object-fit: cover;">
                    </div>
                    
                    <div class="flex-grow-1">
                        <h6 class="mb-1 producto-title">God of War</h6>
                        <p class="mb-0 product-price">49€</p>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <div class="item-quantity">
                            <button class="quantity-btn decrement-btn" aria-label="Disminuir cantidad">−</button>
                            <span class="quantity-display" data-quantity>2</span>
                            <button class="quantity-btn increment-btn" aria-label="Aumentar cantidad">+</button>
                        </div>
                        
                        <button class="btn btn-sm remove-item-btn" aria-label="Eliminar producto">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas-footer">
        <div class="w-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="subtotal-text">Subtotal:</span>
                <span class="subtotal-price" id="subtotalPrice">0€</span>
            </div>

            <div class="d-grid gap-2">
                <a href="zonadepago.php" class="btn btn-primary btn-lg fw-bold">
                    COMPRAR
                </a>
                <button type="button" class="btn btn-outline-secondary btn-lg fw-bold" id="removeAllItems">
                    ELIMINAR TODOS
                </button>
            </div>
        </div>
    </div>
</div>