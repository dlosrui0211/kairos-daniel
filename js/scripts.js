
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
// CARRITO.JS - Solo abre/cierra modal y maneja botón agregar
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    const cartModalElement = document.getElementById('cartModal');
    const productList = document.getElementById('productList');
    const subtotalElement = document.getElementById('subtotalPrice');
    
    // Inicializar offcanvas
    const cartOffcanvas = new bootstrap.Offcanvas(cartModalElement);
    
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
    // 2. ACTUALIZAR SUBTOTAL (basado en data-price y cantidad)
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
            subtotalElement.textContent = total.toFixed(2) + '€';
        }
    }
    
    // =========================================================================
    // 3. AGREGAR PRODUCTO AL CARRITO (desde product-card y detalle)
    // =========================================================================
    
    // Función para agregar al carrito con AJAX
    function agregarAlCarrito(productId, productName, buttonElement) {
        // Crear formulario
        const formData = new FormData();
        formData.append('accion', 'agregar');
        formData.append('producto_id', productId);
        
        // Deshabilitar botón mientras se procesa
        const originalText = buttonElement.innerHTML;
        buttonElement.disabled = true;
        buttonElement.innerHTML = '<i class="bi bi-hourglass-split"></i> Agregando...';
        
        // Enviar petición AJAX
        fetch('carrito-acciones.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Éxito - Mostrar feedback
                buttonElement.innerHTML = '<i class="bi bi-check-circle"></i> ¡Agregado!';
                buttonElement.classList.add('btn-success');
                buttonElement.classList.remove('btn-primary');
                
                // Mostrar notificación
                mostrarNotificacion('Producto agregado al carrito', 'success');
                
                // Recargar página con flag para abrir carrito
                setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('cart_open', '1');
                    window.location.href = url.toString();
                }, 800);
            } else {
                throw new Error(data.error || 'Error al agregar producto');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            buttonElement.innerHTML = originalText;
            buttonElement.disabled = false;
            mostrarNotificacion(error.message || 'Error al agregar el producto', 'danger');
        });
    }
    
    // Evento para botones en product-card
    document.addEventListener('click', function(e) {
        const button = e.target.closest('.btn-add-to-cart');
        if (button) {
            e.preventDefault();
            const productId = button.getAttribute('data-product-id');
            const productName = button.getAttribute('data-product-name') || 'Producto';
            
            agregarAlCarrito(productId, productName, button);
        }
    });
    
    // Evento para botón en página de detalle
    document.addEventListener('click', function(e) {
        const button = e.target.closest('.btn-add-to-cart-detalle');
        if (button) {
            e.preventDefault();
            const productId = button.getAttribute('data-product-id');
            const productName = button.getAttribute('data-product-name') || 'Producto';
            
            agregarAlCarrito(productId, productName, button);
        }
    });
    
    // =========================================================================
    // 4. FUNCIÓN PARA MOSTRAR NOTIFICACIONES (Toast)
    // =========================================================================
    function mostrarNotificacion(mensaje, tipo = 'success') {
        // Crear elemento de notificación
        const notificacion = document.createElement('div');
        notificacion.className = `alert alert-${tipo} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        notificacion.style.zIndex = '9999';
        notificacion.style.minWidth = '300px';
        notificacion.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(notificacion);
        
        // Auto-eliminar después de 3 segundos
        setTimeout(() => {
            notificacion.remove();
        }, 3000);
    }
    
    // =========================================================================
    // 5. INICIALIZAR SUBTOTAL AL CARGAR
    // =========================================================================
    updateSubtotal();
    
    // =========================================================================
    // 6. AUTO-ABRIR CARRITO SI VIENE DE AGREGAR PRODUCTO
    // =========================================================================
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('cart_open') === '1') {
        // Abrir el offcanvas del carrito
        cartOffcanvas.show();
        // Limpiar el parámetro de la URL sin recargar
        const cleanUrl = new URL(window.location.href);
        cleanUrl.searchParams.delete('cart_open');
        window.history.replaceState({}, '', cleanUrl.toString());
    }
});


// ===== CONTROLES DEL VIDEO =====
const video = document.getElementById('miVideo');
const btnPlayPausa = document.getElementById('btnPlayPausa');
const btnVolumen = document.getElementById('btnVolumen');
const volumenSlider = document.getElementById('volumenSlider');
const btnPantallaCompleta = document.getElementById('btnPantallaCompleta');
const progresoRelleno = document.getElementById('progresoRelleno');
const progresoHandle = document.getElementById('progresoHandle');
const progresoBarra = document.getElementById('progresoBarra');
const tiempoVideo = document.getElementById('tiempoVideo');

// Solo inicializar controles de video si el video existe en la página
if (video && btnPlayPausa) {

// Reproducir/Pausar
btnPlayPausa.addEventListener('click', () => {
    if (video.paused) {
        video.play();
        btnPlayPausa.innerHTML = '<svg viewBox="0 0 24 24" width="24" height="24"><path d="M6 4h4v16H6V4zm8 0h4v' +
                '16h-4V4z" fill="currentColor"/></svg>';
    } else {
        video.pause();
        btnPlayPausa.innerHTML = '<svg viewBox="0 0 24 24" width="24" height="24"><path d="M8 5v14l11-7z" fill="' +
                'currentColor"/></svg>';
    }
});

// Volumen
volumenSlider.addEventListener('input', (e) => {
    video.volume = e.target.value / 100;
    if (e.target.value > 0) {
        btnVolumen.innerHTML = '<svg viewBox="0 0 24 24" width="20" height="20"><path d="M3 9v6h4l5 5V4L7 9H3z' +
                'm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.26 2.5-4.02zM14 3.23v2.0' +
                '6c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.' +
                '86-7-8.77z" fill="currentColor"/></svg>';
    } else {
        btnVolumen.innerHTML = '<svg viewBox="0 0 24 24" width="20" height="20"><path d="M16.5 12c0-1.77-1.02-' +
                '3.29-2.5-4.03v2.21h2.5v3.64zm2.5 0c0 .94-.2 1.82-.54 2.64h1.54c.33-.82.5-1.7.5' +
                '-2.64s-.17-1.82-.5-2.64h-1.54c.34.82.54 1.7.54 2.64zM3 9v6h4l5 5V4L7 9H3z" fil' +
                'l="currentColor"/></svg>';
    }
});

btnVolumen.addEventListener('click', () => {
    if (video.volume > 0) {
        video.volume = 0;
        volumenSlider.value = 0;
        btnVolumen.innerHTML = '<svg viewBox="0 0 24 24" width="20" height="20"><path d="M16.5 12c0-1.77-1.02-' +
                '3.29-2.5-4.03v2.21h2.5v3.64zm2.5 0c0 .94-.2 1.82-.54 2.64h1.54c.33-.82.5-1.7.5' +
                '-2.64s-.17-1.82-.5-2.64h-1.54c.34.82.54 1.7.54 2.64zM3 9v6h4l5 5V4L7 9H3z" fil' +
                'l="currentColor"/></svg>';
    } else {
        video.volume = 0.5;
        volumenSlider.value = 50;
        btnVolumen.innerHTML = '<svg viewBox="0 0 24 24" width="20" height="20"><path d="M3 9v6h4l5 5V4L7 9H3z' +
                'm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.26 2.5-4.02zM14 3.23v2.0' +
                '6c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.' +
                '86-7-8.77z" fill="currentColor"/></svg>';
    }
});

// Progreso - Click en la barra
progresoBarra.addEventListener('click', (e) => {
    const rect = progresoBarra.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const porcentaje = x / rect.width;
    video.currentTime = porcentaje * video.duration;
});

// Actualizar progreso mientras se reproduce
video.addEventListener('timeupdate', () => {
    const porcentaje = (video.currentTime / video.duration) * 100 || 0;
    progresoRelleno.style.width = porcentaje + '%';
    progresoHandle.style.left = porcentaje + '%';

    // Actualizar tiempo
    const minutos = Math.floor(video.currentTime / 60);
    const segundos = Math.floor(video.currentTime % 60);
    const minutosTotales = Math.floor(video.duration / 60) || 0;
    const segundosTotales = Math.floor(video.duration % 60) || 0;

    tiempoVideo.textContent = `${minutos
        .toString()
        .padStart(2, '0')}:${segundos
        .toString()
        .padStart(2, '0')} / ${minutosTotales
        .toString()
        .padStart(2, '0')}:${segundosTotales
        .toString()
        .padStart(2, '0')}`;
});

// Pantalla completa
btnPantallaCompleta.addEventListener('click', () => {
    if (video.requestFullscreen) {
        video.requestFullscreen();
    } else if (video.webkitRequestFullscreen) {
        video.webkitRequestFullscreen();
    } else if (video.mozRequestFullScreen) {
        video.mozRequestFullScreen();
    }
});

// Autoplay
video.autoplay = true;

} // fin del if (video && btnPlayPausa)