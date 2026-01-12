
//
// Poner aquí los scripts 
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    
    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});

// ============================================================================
// CARRITO.JS - Lógica completa del carrito
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    const cartModalElement = document.getElementById('cartModal');
    const cartOffcanvas = new bootstrap.Offcanvas(cartModalElement);
    const productList = document.getElementById('productList');
    const subtotalElement = document.getElementById('subtotalPrice');
    const removeAllButton = document.getElementById('removeAllItems');

    // =========================================================================
    // 1. ABRIR CARRITO - Busca el botón con ID openCartModal
    // =========================================================================
    const openButton = document.getElementById('openCartModal');
    if (openButton) {
        openButton.addEventListener('click', function(e) {
            e.preventDefault();
            updateSubtotal();
            cartOffcanvas.show();
        });
    }

    // =========================================================================
    // 2. ACTUALIZAR SUBTOTAL
    // =========================================================================
    function updateSubtotal() {
        let total = 0;
        const items = productList.querySelectorAll('.elemento-carrito');
        
        items.forEach(item => {
            const price = parseFloat(item.getAttribute('data-price')) || 0;
            const quantityDisplay = item.querySelector('[data-quantity]');
            const quantity = parseInt(quantityDisplay.textContent) || 1;
            
            total += price * quantity;
        });

        if (subtotalElement) {
            subtotalElement.textContent = total + '€';
        }
    }

    // =========================================================================
    // 3. INCREMENTAR CANTIDAD (Botón +)
    // =========================================================================
    productList.addEventListener('click', function(e) {
        if (e.target.classList.contains('increment-btn')) {
            const element = e.target.closest('.elemento-carrito');
            const quantityDisplay = element.querySelector('[data-quantity]');
            let quantity = parseInt(quantityDisplay.textContent);
            quantityDisplay.textContent = quantity + 1;
            updateSubtotal();
        }
    });

    // =========================================================================
    // 4. DECREMENTAR CANTIDAD (Botón -)
    // =========================================================================
    productList.addEventListener('click', function(e) {
        if (e.target.classList.contains('decrement-btn')) {
            const element = e.target.closest('.elemento-carrito');
            const quantityDisplay = element.querySelector('[data-quantity]');
            let quantity = parseInt(quantityDisplay.textContent);
            
            if (quantity > 1) {
                quantityDisplay.textContent = quantity - 1;
                updateSubtotal();
            } else {
                // Si es 1, eliminar el producto
                element.remove();
                updateSubtotal();
            }
        }
    });

    // =========================================================================
    // 5. ELIMINAR PRODUCTO INDIVIDUAL (Botón 🗑️)
    // =========================================================================
    productList.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            const element = e.target.closest('.elemento-carrito');
            element.remove();
            updateSubtotal();
        }
    });

    // =========================================================================
    // 6. ELIMINAR TODOS LOS PRODUCTOS
    // =========================================================================
    if (removeAllButton) {
        removeAllButton.addEventListener('click', function() {
            productList.innerHTML = '';
            updateSubtotal();
        });
    }

    // =========================================================================
    // 7. INICIALIZAR SUBTOTAL
    // =========================================================================
    updateSubtotal();
});