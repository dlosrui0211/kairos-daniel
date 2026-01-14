window.addEventListener('DOMContentLoaded', event => {

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

    navbarShrink();

    document.addEventListener('scroll', navbarShrink);

    

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

document.addEventListener('DOMContentLoaded', function() {
    const cartModalElement = document.getElementById('cartModal');
    const cartOffcanvas = new bootstrap.Offcanvas(cartModalElement);
    const productList = document.getElementById('productList');
    const subtotalElement = document.getElementById('subtotalPrice');
    const removeAllButton = document.getElementById('removeAllItems');

    const openButton = document.getElementById('openCartModal');
    if (openButton) {
        openButton.addEventListener('click', function(e) {
            e.preventDefault();
            updateSubtotal();
            cartOffcanvas.show();
        });
    }

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

    productList.addEventListener('click', function(e) {
        if (e.target.classList.contains('increment-btn')) {
            const element = e.target.closest('.elemento-carrito');
            const quantityDisplay = element.querySelector('[data-quantity]');
            let quantity = parseInt(quantityDisplay.textContent);
            quantityDisplay.textContent = quantity + 1;
            updateSubtotal();
        }
    });


    productList.addEventListener('click', function(e) {
        if (e.target.classList.contains('decrement-btn')) {
            const element = e.target.closest('.elemento-carrito');
            const quantityDisplay = element.querySelector('[data-quantity]');
            let quantity = parseInt(quantityDisplay.textContent);
            
            if (quantity > 1) {
                quantityDisplay.textContent = quantity - 1;
                updateSubtotal();
            } else {
                element.remove();
                updateSubtotal();
            }
        }
    });

    productList.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            const element = e.target.closest('.elemento-carrito');
            element.remove();
            updateSubtotal();
        }
    });

    if (removeAllButton) {
        removeAllButton.addEventListener('click', function() {
            productList.innerHTML = '';
            updateSubtotal();
        });
    }

    updateSubtotal();
});

const video = document.getElementById('miVideo');
const btnPlayPausa = document.getElementById('btnPlayPausa');
const btnVolumen = document.getElementById('btnVolumen');
const volumenSlider = document.getElementById('volumenSlider');
const btnPantallaCompleta = document.getElementById('btnPantallaCompleta');
const progresoRelleno = document.getElementById('progresoRelleno');
const progresoHandle = document.getElementById('progresoHandle');
const progresoBarra = document.getElementById('progresoBarra');
const tiempoVideo = document.getElementById('tiempoVideo');

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

progresoBarra.addEventListener('click', (e) => {
    const rect = progresoBarra.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const porcentaje = x / rect.width;
    video.currentTime = porcentaje * video.duration;
});

video.addEventListener('timeupdate', () => {
    const porcentaje = (video.currentTime / video.duration) * 100 || 0;
    progresoRelleno.style.width = porcentaje + '%';
    progresoHandle.style.left = porcentaje + '%';

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

btnPantallaCompleta.addEventListener('click', () => {
    if (video.requestFullscreen) {
        video.requestFullscreen();
    } else if (video.webkitRequestFullscreen) {
        video.webkitRequestFullscreen();
    } else if (video.mozRequestFullScreen) {
        video.mozRequestFullScreen();
    }
});

video.autoplay = true;