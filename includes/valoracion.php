<!-- Modal para Valorar Producto -->
<div id="modalValoracion" class="modal-valoracion-overlay" style="display: none;">
    <div class="modal-valoracion-content">
        <div class="modal-valoracion-header">
            <h2>Valorar Producto</h2>
            <button class="modal-close-btn" onclick="cerrarModalValoracion()">&times;</button>
        </div>

        <div class="modal-valoracion-body">
            <p class="producto-nombre" id="productoNombre"></p>

            <!-- Stars para la puntuación -->
            <div class="estrellas-container">
                <div class="estrellas" id="estrellas">
                    <span class="estrella" data-valor="1">★</span>
                    <span class="estrella" data-valor="2">★</span>
                    <span class="estrella" data-valor="3">★</span>
                    <span class="estrella" data-valor="4">★</span>
                    <span class="estrella" data-valor="5">★</span>
                </div>
                <span class="puntuacion-texto" id="puntuacionTexto">0/5</span>
            </div>

            <!-- Comentario -->
            <textarea id="comentario" class="comentario-input" placeholder="Cuéntanos qué te pareció (opcional)"
                maxlength="500" rows="4"></textarea>
            <small class="texto-ayuda">Máximo 500 caracteres</small>
        </div>

        <div class="modal-valoracion-footer">
            <button class="btn-cancelar" onclick="cerrarModalValoracion()">Cancelar</button>
            <button class="btn-guardar" onclick="guardarValoracion()">Guardar Valoración</button>
        </div>
    </div>
</div>

<script>
let puntuacionSeleccionada = 0;
let productoIdActual = null;
let productoNombreActual = null;

// Abrir modal de valoración
function abrirModalValoracion(productId, productName) {
    // Verificar si el usuario está logueado
    if (!<?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>) {
        alert('Debes estar logueado para valorar productos. Por favor, inicia sesión.');
        window.location.href = 'login.php';
        return;
    }

    productoIdActual = productId;
    productoNombreActual = productName;
    puntuacionSeleccionada = 0;

    document.getElementById('productoNombre').textContent = productName;
    document.getElementById('comentario').value = '';
    document.getElementById('puntuacionTexto').textContent = '0/5';

    // Resetear estrellas
    document.querySelectorAll('.estrella').forEach(e => e.classList.remove('activa'));

    document.getElementById('modalValoracion').style.display = 'flex';
}

// Cerrar modal
function cerrarModalValoracion() {
    document.getElementById('modalValoracion').style.display = 'none';
}

// Manejo de estrellas
document.addEventListener('DOMContentLoaded', function() {
    const estrellas = document.querySelectorAll('.estrella');

    estrellas.forEach(estrella => {
        estrella.addEventListener('click', function() {
            puntuacionSeleccionada = this.getAttribute('data-valor');
            document.getElementById('puntuacionTexto').textContent = puntuacionSeleccionada +
                '/5';

            estrellas.forEach(e => e.classList.remove('activa'));
            estrellas.forEach(e => {
                if (e.getAttribute('data-valor') <= puntuacionSeleccionada) {
                    e.classList.add('activa');
                }
            });
        });
    });

    // Cerrar modal al hacer clic en el overlay
    const overlay = document.getElementById('modalValoracion');
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalValoracion();
        }
    });
});

// Guardar valoración
function guardarValoracion() {
    if (puntuacionSeleccionada === 0) {
        alert('Por favor selecciona una puntuación');
        return;
    }

    const comentario = document.getElementById('comentario').value;
    const btnGuardar = document.querySelector('.btn-guardar');
    btnGuardar.disabled = true;
    btnGuardar.textContent = 'Guardando...';

    fetch('procesar-valoracion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_producto: productoIdActual,
                puntuacion: puntuacionSeleccionada,
                comentario: comentario
            })
        })
        .then(response => response.json())
        .then(data => {
            btnGuardar.disabled = false;
            btnGuardar.textContent = 'Guardar Valoración';

            if (data.success) {
                alert('¡Gracias! Tu valoración se ha guardado correctamente');
                cerrarModalValoracion();
            } else {
                alert(data.message || 'Error al guardar la valoración');
            }
        })
        .catch(error => {
            btnGuardar.disabled = false;
            btnGuardar.textContent = 'Guardar Valoración';
            console.error('Error:', error);
            alert('Error al procesar la valoración');
        });
}
</script>