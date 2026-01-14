<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drift Racing Game</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/konva/8.4.3/konva.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #2c2c2c;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        #game-container {
            position: relative;
            width: 800px;
            height: 600px;
            background: #1a1a1a;
            border: 2px solid #444;
            overflow: hidden;
        }

        #menu-screen, #circuit-select, #game-over {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #1a1a1a;
            z-index: 10;
        }

        .hidden {
            display: none !important;
        }

        h1 {
            font-size: 48px;
            color: #fff;
            margin-bottom: 20px;
        }

        @keyframes glow {
            0%, 100% { text-shadow: 0 0 10px rgba(255, 255, 255, 0.3); }
            50% { text-shadow: 0 0 15px rgba(255, 255, 255, 0.5); }
        }

        .subtitle {
            font-size: 18px;
            color: #999;
            margin-bottom: 30px;
        }

        button {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: normal;
            color: #fff;
            background: #444;
            border: 1px solid #666;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 10px;
        }

        button:hover {
            background: #555;
            border-color: #777;
        }

        .circuit-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .circuit-card {
            width: 280px;
            padding: 20px;
            background: #222;
            border: 1px solid #444;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .circuit-card:hover {
            background: #2a2a2a;
            border-color: #666;
        }

        .circuit-card h3 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 8px;
            font-weight: normal;
        }

        .circuit-card p {
            color: #888;
            font-size: 13px;
        }

        .circuit-preview {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            border: 1px solid #333;
            overflow: hidden;
        }

        #hud {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #fff;
            font-size: 16px;
            z-index: 5;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 15px;
            border: 1px solid #444;
        }

        #hud div {
            margin: 5px 0;
        }

        .drift-indicator {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            font-weight: bold;
            color: #ffd700;
            z-index: 5;
            pointer-events: none;
        }

        @keyframes driftPulse {
            0% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
            50% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            100% { opacity: 0; transform: translate(-50%, -50%) scale(1); }
        }

        .leaderboard {
            margin-top: 20px;
            width: 400px;
            background: #222;
            border: 1px solid #444;
            padding: 15px;
        }

        .leaderboard h3 {
            color: #fff;
            margin-bottom: 10px;
            text-align: center;
            font-weight: normal;
        }

        .leaderboard-entry {
            display: flex;
            justify-content: space-between;
            color: #999;
            padding: 8px;
            border-bottom: 1px solid #333;
        }

        .leaderboard-entry:last-child {
            border-bottom: none;
        }

        .leaderboard-entry.highlight {
            background: #2a2a2a;
            color: #fff;
        }

        #konva-container {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="game-container">
        <!-- Menú principal -->
        <div id="menu-screen">
            <h1>🏎️ DRIFT RACING</h1>
            <p class="subtitle">¡Domina las curvas y gana puntos con el drift!</p>
            <button onclick="showCircuitSelect()">PULSA PARA EMPEZAR</button>
        </div>

        <!-- Selección de circuito -->
        <div id="circuit-select" class="hidden">
            <h1>ELIGE TU CIRCUITO</h1>
            <div class="circuit-grid">
                <div class="circuit-card" onclick="startGame(0)">
                    <h3>🏁 Circuito Oval</h3>
                    <p>Perfecto para principiantes</p>
                    <div class="circuit-preview" id="preview-0"></div>
                </div>
                <div class="circuit-card" onclick="startGame(1)">
                    <h3>🌊 Circuito Serpiente</h3>
                    <p>Curvas técnicas y desafiantes</p>
                    <div class="circuit-preview" id="preview-1"></div>
                </div>
                <div class="circuit-card" onclick="startGame(2)">
                    <h3>⚡ Circuito Relámpago</h3>
                    <p>Para expertos del drift</p>
                    <div class="circuit-preview" id="preview-2"></div>
                </div>
                <div class="circuit-card" onclick="startGame(3)">
                    <h3>🔥 Circuito Infernal</h3>
                    <p>El desafío definitivo</p>
                    <div class="circuit-preview" id="preview-3"></div>
                </div>
            </div>
        </div>

        <!-- HUD del juego -->
        <div id="hud" class="hidden">
            <div>Vuelta: <span id="lap">1</span>/3</div>
            <div>Puntos: <span id="score">0</span></div>
            <div>Tiempo: <span id="time">0.0</span>s</div>
            <div id="drift-bonus" style="color: #ffd700;"></div>
        </div>

        <!-- Pantalla de Game Over -->
        <div id="game-over" class="hidden">
            <h1>🏆 ¡CARRERA COMPLETADA!</h1>
            <div style="color: #fff; font-size: 24px; margin: 20px 0;">
                <div>Puntos Finales: <span id="final-score" style="color: #ffd700;">0</span></div>
                <div>Tiempo Total: <span id="final-time" style="color: #667eea;">0.0</span>s</div>
            </div>
            <div class="leaderboard" id="leaderboard"></div>
            <div>
                <button onclick="showCircuitSelect()">ELEGIR OTRO CIRCUITO</button>
                <button onclick="location.reload()">MENÚ PRINCIPAL</button>
            </div>
        </div>

        <!-- Canvas de Konva -->
        <div id="konva-container"></div>
    </div>

    <script>
        // Esperar a que Konva se cargue y el DOM esté listo
        (function() {
            function checkKonvaAndInit() {
                if (typeof Konva !== 'undefined') {
                    initGame();
                } else {
                    setTimeout(checkKonvaAndInit, 100);
                }
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', checkKonvaAndInit);
            } else {
                checkKonvaAndInit();
            }
        })();

        // Configuración del juego
        const CANVAS_WIDTH = 800;
        const CANVAS_HEIGHT = 600;
        const CAR_SIZE = 30;
        const MAX_SPEED = 6;
        const ACCELERATION = 0.2;
        const FRICTION = 0.96;
        const TURN_SPEED = 0.06;
        const DRIFT_THRESHOLD = 2.5;

        // Variables del juego
        let stage, layer;
        let car;
        let currentCircuit = null;
        let checkpoints = [];
        let currentCheckpoint = 0;
        let lap = 1;
        let score = 0;
        let startTime = null;
        let gameLoop = null;
        let keys = {};
        let carState = {
            x: 100,
            y: 300,
            angle: 0,
            speed: 0,
            driftAngle: 0
        };
        let driftPoints = 0;
        let lastDriftTime = 0;

        // Definición de circuitos
        const circuits = [
            {
                name: 'Oval',
                color: '#3b82f6',
                points: [
                    [150, 200], [650, 200], [650, 400], [150, 400]
                ],
                startPos: { x: 150, y: 300, angle: 0 }
            },
            {
                name: 'Serpiente',
                color: '#10b981',
                points: [
                    [100, 300], [300, 150], [500, 150], [700, 300],
                    [700, 450], [400, 450], [200, 300]
                ],
                startPos: { x: 100, y: 300, angle: 0 }
            },
            {
                name: 'Relámpago',
                color: '#f59e0b',
                points: [
                    [150, 150], [650, 150], [650, 250], [150, 250],
                    [150, 350], [650, 350], [650, 450], [150, 450]
                ],
                startPos: { x: 150, y: 200, angle: 0 }
            },
            {
                name: 'Infernal',
                color: '#ef4444',
                points: [
                    [400, 120], [600, 200], [650, 380], [450, 480],
                    [200, 420], [150, 240], [300, 140]
                ],
                startPos: { x: 400, y: 120, angle: 0 }
            }
        ];

        // Inicializar el juego
        function initGame() {
            initKonva();
            createPreviews();
            setupKeyboardControls();
        }

        // Inicializar Konva
        function initKonva() {
            stage = new Konva.Stage({
                container: 'konva-container',
                width: CANVAS_WIDTH,
                height: CANVAS_HEIGHT
            });

            layer = new Konva.Layer();
            stage.add(layer);
        }

        // Crear vistas previas de circuitos
        function createPreviews() {
            circuits.forEach((circuit, index) => {
                const previewStage = new Konva.Stage({
                    container: `preview-${index}`,
                    width: 268,
                    height: 120
                });

                const previewLayer = new Konva.Layer();
                previewStage.add(previewLayer);

                const line = new Konva.Line({
                    points: circuit.points.flat().map((v, i) => 
                        i % 2 === 0 ? v * 0.335 : v * 0.2
                    ),
                    stroke: circuit.color,
                    strokeWidth: 8,
                    closed: true,
                    lineJoin: 'round'
                });

                previewLayer.add(line);
                previewLayer.draw();
            });
        }

        // Configurar controles de teclado
        function setupKeyboardControls() {
            window.addEventListener('keydown', (e) => {
                keys[e.key] = true;
                e.preventDefault();
            });

            window.addEventListener('keyup', (e) => {
                keys[e.key] = false;
                e.preventDefault();
            });
        }

        // Mostrar selección de circuito
        function showCircuitSelect() {
            document.getElementById('menu-screen').classList.add('hidden');
            document.getElementById('circuit-select').classList.remove('hidden');
            document.getElementById('game-over').classList.add('hidden');
        }

        // Iniciar el juego
        function startGame(circuitIndex) {
            currentCircuit = circuits[circuitIndex];
            document.getElementById('circuit-select').classList.add('hidden');
            document.getElementById('hud').classList.remove('hidden');

            // Reiniciar variables
            lap = 1;
            score = 0;
            currentCheckpoint = 0;
            startTime = Date.now();
            carState = {
                x: currentCircuit.startPos.x,
                y: currentCircuit.startPos.y,
                angle: currentCircuit.startPos.angle,
                speed: 0,
                driftAngle: 0
            };

            updateHUD();
            createCircuit();
            createCar();
            
            if (gameLoop) cancelAnimationFrame(gameLoop);
            gameLoop = requestAnimationFrame(update);
        }

        // Crear el circuito
        function createCircuit() {
            // Limpiar layer si existe
            if (layer) {
                layer.destroyChildren();
            }
            
            // Fondo del circuito
            const background = new Konva.Rect({
                x: 0,
                y: 0,
                width: CANVAS_WIDTH,
                height: CANVAS_HEIGHT,
                fill: '#1a1a2e'
            });
            layer.add(background);

            // Pista exterior
            const outerTrack = new Konva.Line({
                points: currentCircuit.points.flat(),
                stroke: '#333',
                strokeWidth: 80,
                closed: true,
                lineJoin: 'round'
            });
            layer.add(outerTrack);

            // Pista interior
            const innerTrack = new Konva.Line({
                points: currentCircuit.points.flat(),
                stroke: '#2a2a3e',
                strokeWidth: 60,
                closed: true,
                lineJoin: 'round'
            });
            layer.add(innerTrack);

            // Línea central
            const centerLine = new Konva.Line({
                points: currentCircuit.points.flat(),
                stroke: currentCircuit.color,
                strokeWidth: 3,
                closed: true,
                lineJoin: 'round',
                dash: [15, 10],
                opacity: 0.6
            });
            layer.add(centerLine);

            // Checkpoints
            checkpoints = [];
            for (let i = 0; i < currentCircuit.points.length; i++) {
                const checkpoint = new Konva.Circle({
                    x: currentCircuit.points[i][0],
                    y: currentCircuit.points[i][1],
                    radius: 20,
                    fill: i === 0 ? '#ffd700' : '#555',
                    stroke: '#fff',
                    strokeWidth: 2,
                    opacity: 0.7
                });
                checkpoints.push(checkpoint);
                layer.add(checkpoint);
            }
        }

        // Crear el coche
        function createCar() {
            car = new Konva.Group({
                x: carState.x,
                y: carState.y,
                rotation: carState.angle * 180 / Math.PI
            });

            // Cuerpo del coche
            const carBody = new Konva.Rect({
                x: -CAR_SIZE / 2,
                y: -CAR_SIZE / 2,
                width: CAR_SIZE,
                height: CAR_SIZE,
                fill: '#ff0000',
                cornerRadius: 4,
                shadowColor: 'black',
                shadowBlur: 10,
                shadowOffset: { x: 0, y: 0 },
                shadowOpacity: 0.5
            });

            // Frente del coche (amarillo)
            const carFront = new Konva.Rect({
                x: CAR_SIZE / 2 - 3,
                y: -CAR_SIZE / 3,
                width: 5,
                height: CAR_SIZE * 2 / 3,
                fill: '#ffff00',
                cornerRadius: 2
            });

            // Ventanas
            const window1 = new Konva.Rect({
                x: -CAR_SIZE / 4,
                y: -CAR_SIZE / 3,
                width: CAR_SIZE / 2,
                height: CAR_SIZE / 4,
                fill: '#88ccff',
                cornerRadius: 2
            });

            car.add(carBody);
            car.add(window1);
            car.add(carFront);
            layer.add(car);
            layer.draw();
        }

        // Actualizar el juego
        function update() {
            // Controles
            if (keys['ArrowUp'] || keys['w'] || keys['W']) {
                carState.speed = Math.min(carState.speed + ACCELERATION, MAX_SPEED);
            } else if (keys['ArrowDown'] || keys['s'] || keys['S']) {
                carState.speed = Math.max(carState.speed - ACCELERATION, -MAX_SPEED / 2);
            }

            let isDrifting = false;
            if (Math.abs(carState.speed) > 0.5) {
                if (keys['ArrowLeft'] || keys['a'] || keys['A']) {
                    carState.angle -= TURN_SPEED * Math.abs(carState.speed) / MAX_SPEED;
                    if (Math.abs(carState.speed) > DRIFT_THRESHOLD) {
                        carState.driftAngle += 0.03;
                        isDrifting = true;
                    }
                }
                if (keys['ArrowRight'] || keys['d'] || keys['D']) {
                    carState.angle += TURN_SPEED * Math.abs(carState.speed) / MAX_SPEED;
                    if (Math.abs(carState.speed) > DRIFT_THRESHOLD) {
                        carState.driftAngle -= 0.03;
                        isDrifting = true;
                    }
                }
            }

            // Puntos de drift
            if (isDrifting && Math.abs(carState.driftAngle) > 0.05) {
                const driftBonus = Math.floor(Math.abs(carState.driftAngle) * 20);
                driftPoints += driftBonus;
                score += driftBonus;
                
                const now = Date.now();
                if (now - lastDriftTime > 300) {
                    showDriftIndicator(driftBonus);
                    lastDriftTime = now;
                }
                
                document.getElementById('drift-bonus').textContent = `Drift: +${driftPoints}`;
            } else {
                if (driftPoints > 0) {
                    driftPoints = 0;
                    document.getElementById('drift-bonus').textContent = '';
                }
            }

            carState.driftAngle *= 0.92;
            carState.speed *= FRICTION;

            // Movimiento
            const moveAngle = carState.angle + carState.driftAngle;
            carState.x += Math.cos(moveAngle) * carState.speed;
            carState.y += Math.sin(moveAngle) * carState.speed;

            // Límites del canvas
            carState.x = Math.max(CAR_SIZE, Math.min(CANVAS_WIDTH - CAR_SIZE, carState.x));
            carState.y = Math.max(CAR_SIZE, Math.min(CANVAS_HEIGHT - CAR_SIZE, carState.y));

            // Actualizar posición del coche
            car.position({ x: carState.x, y: carState.y });
            car.rotation(carState.angle * 180 / Math.PI);

            // Verificar checkpoints
            checkCheckpoints();

            // Actualizar HUD
            updateHUD();

            layer.batchDraw();
            gameLoop = requestAnimationFrame(update);
        }

        // Verificar checkpoints
        function checkCheckpoints() {
            const checkpoint = checkpoints[currentCheckpoint];
            const dx = carState.x - checkpoint.x();
            const dy = carState.y - checkpoint.y();
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < 40) {
                score += 50;
                currentCheckpoint++;

                if (currentCheckpoint >= checkpoints.length) {
                    currentCheckpoint = 0;
                    lap++;
                    score += 200;

                    if (lap > 3) {
                        endGame();
                        return;
                    }
                }

                // Actualizar colores de checkpoints
                checkpoints.forEach((cp, i) => {
                    cp.fill(i === currentCheckpoint ? '#ffd700' : '#555');
                });
            }
        }

        // Mostrar indicador de drift
        function showDriftIndicator(points) {
            const indicator = document.createElement('div');
            indicator.className = 'drift-indicator';
            indicator.style.animation = 'driftPulse 0.5s ease-in-out';
            indicator.textContent = `+${points} DRIFT!`;
            document.getElementById('game-container').appendChild(indicator);
            setTimeout(() => indicator.remove(), 500);
        }

        // Actualizar HUD
        function updateHUD() {
            document.getElementById('lap').textContent = lap;
            document.getElementById('score').textContent = score;
            if (startTime) {
                const elapsed = ((Date.now() - startTime) / 1000).toFixed(1);
                document.getElementById('time').textContent = elapsed;
            }
        }

        // Finalizar el juego
        function endGame() {
            cancelAnimationFrame(gameLoop);
            const finalTime = ((Date.now() - startTime) / 1000).toFixed(1);

            document.getElementById('final-score').textContent = score;
            document.getElementById('final-time').textContent = finalTime;

            // Guardar en clasificación
            saveToLeaderboard(score, finalTime, currentCircuit.name);
            displayLeaderboard();

            document.getElementById('hud').classList.add('hidden');
            document.getElementById('game-over').classList.remove('hidden');
        }

        // Guardar en clasificación
        function saveToLeaderboard(finalScore, time, circuit) {
            let leaderboard = JSON.parse(localStorage.getItem('driftLeaderboard') || '[]');
            const entry = {
                score: finalScore,
                time: parseFloat(time),
                circuit: circuit,
                date: new Date().toLocaleDateString()
            };
            leaderboard.push(entry);
            leaderboard.sort((a, b) => b.score - a.score);
            leaderboard = leaderboard.slice(0, 10);
            localStorage.setItem('driftLeaderboard', JSON.stringify(leaderboard));
        }

        // Mostrar clasificación
        function displayLeaderboard() {
            const leaderboard = JSON.parse(localStorage.getItem('driftLeaderboard') || '[]');
            const leaderboardDiv = document.getElementById('leaderboard');
            
            let html = '<h3>🏆 TOP 10 CLASIFICACIÓN</h3>';
            leaderboard.forEach((entry, index) => {
                const isLatest = index === 0;
                html += `
                    <div class="leaderboard-entry ${isLatest ? 'highlight' : ''}">
                        <span>${index + 1}. ${entry.circuit}</span>
                        <span>${entry.score} pts - ${entry.time}s</span>
                    </div>
                `;
            });
            
            if (leaderboard.length === 0) {
                html += '<p style="color: #a0a0b0; text-align: center;">No hay registros aún</p>';
            }
            
            leaderboardDiv.innerHTML = html;
        }
    </script>
</body>
</html>