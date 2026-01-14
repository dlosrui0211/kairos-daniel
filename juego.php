<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drift Racing</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/konva/8.4.3/konva.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #2c2c2c; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        #container { position: relative; width: 800px; height: 600px; background: #1a1a1a; border: 2px solid #444; }
        .screen { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; background: #1a1a1a; z-index: 10; }
        .screen.hidden { display: none; }
        h1 { color: #fff; font-size: 48px; margin-bottom: 20px; }
        .subtitle { font-size: 18px; color: #999; margin-bottom: 30px; }
        button { padding: 12px 30px; font-size: 16px; color: #fff; background: #444; border: 1px solid #666; cursor: pointer; margin: 10px; }
        button:hover { background: #555; }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 30px; }
        .card { width: 280px; padding: 20px; background: #222; border: 1px solid #444; cursor: pointer; }
        .card:hover { background: #2a2a2a; border-color: #666; }
        .card h3 { color: #fff; font-size: 20px; margin-bottom: 8px; }
        .card p { color: #888; font-size: 13px; }
        .preview { width: 100%; height: 100px; margin-top: 10px; border: 1px solid #333; }
        #hud { position: absolute; top: 10px; left: 10px; color: #fff; background: rgba(0,0,0,0.7); padding: 10px 15px; z-index: 5; border: 1px solid #444; font-size: 16px; }
        #hud div { margin: 5px 0; }
        #drift { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 32px; font-weight: bold; color: #ffd700; z-index: 5; opacity: 0; pointer-events: none; }
        @keyframes pulse { 0%, 100% { opacity: 0; } 50% { opacity: 1; } }
        .leaderboard { margin-top: 20px; width: 400px; background: #222; border: 1px solid #444; padding: 15px; }
        .leaderboard h3 { color: #fff; margin-bottom: 10px; text-align: center; }
        .entry { display: flex; justify-content: space-between; color: #999; padding: 8px; border-bottom: 1px solid #333; }
        .entry:last-child { border-bottom: none; }
        .entry.highlight { background: #2a2a2a; color: #fff; }
    </style>
</head>
<body>
    <div id="container">
        <div id="konva"></div>
        <div id="menu" class="screen">
            <h1>DRIFT RACING</h1>
            <p class="subtitle">¡Domina las curvas y gana puntos con el drift!</p>
            <button onclick="showScreen('circuits')">PULSA PARA EMPEZAR</button>
        </div>
        <div id="circuits" class="screen hidden">
            <h1>ELIGE TU CIRCUITO</h1>
            <div class="grid">
                <div class="card" onclick="start(0)">
                    <h3>Circuito Oval</h3>
                    <p>Perfecto para principiantes</p>
                    <div class="preview" id="p0"></div>
                </div>
                <div class="card" onclick="start(1)">
                    <h3>Circuito Serpiente</h3>
                    <p>Curvas técnicas y desafiantes</p>
                    <div class="preview" id="p1"></div>
                </div>
                <div class="card" onclick="start(2)">
                    <h3>Circuito Relámpago</h3>
                    <p>Para expertos del drift</p>
                    <div class="preview" id="p2"></div>
                </div>
                <div class="card" onclick="start(3)">
                    <h3>Circuito Infernal</h3>
                    <p>El desafío definitivo</p>
                    <div class="preview" id="p3"></div>
                </div>
            </div>
        </div>
        <div id="results" class="screen hidden">
            <h1>¡CARRERA COMPLETADA!</h1>
            <div style="color:#fff;font-size:24px;margin:20px 0;">
                <div>Puntos Finales: <span id="fs" style="color:#ffd700;">0</span></div>
                <div>Tiempo Total: <span id="ft" style="color:#667eea;">0.0</span>s</div>
            </div>
            <div class="leaderboard" id="leaderboard"></div>
            <div>
                <button onclick="showScreen('circuits')">ELEGIR OTRO CIRCUITO</button>
                <button onclick="showScreen('menu')">MENÚ PRINCIPAL</button>
            </div>
        </div>
        
        <div id="hud" class="hidden">
            <div>Vuelta: <span id="lap">1</span>/3</div>
            <div>Puntos: <span id="score">0</span></div>
            <div>Tiempo: <span id="time">0.0</span>s</div>
            <div id="db" style="color:#ffd700;"></div>
        </div>
        <div id="drift"></div>
    </div>
    <script>
        const circuits = [
            {name:'Oval', pts:[[150,200],[650,200],[650,400],[150,400]], col:'#3b82f6', start:{x:150,y:300,a:0}},
            {name:'Serpiente', pts:[[100,300],[300,150],[500,150],[700,300],[700,450],[400,450],[200,300]], col:'#10b981', start:{x:100,y:300,a:0}},
            {name:'Relámpago', pts:[[150,150],[650,150],[650,250],[150,250],[150,350],[650,350],[650,450],[150,450]], col:'#f59e0b', start:{x:150,y:200,a:0}},
            {name:'Infernal', pts:[[400,120],[600,200],[650,380],[450,480],[200,420],[150,240],[300,140]], col:'#ef4444', start:{x:400,y:120,a:0}}
        ];
        
        let stage, layer, car, circ, cps=[], cpIdx=0, lap=1, score=0, t0, keys={}, loop, state, dp=0, lastD=0;
        
        function init() {
            if (typeof Konva === 'undefined') return setTimeout(init, 100);
            stage = new Konva.Stage({ container: 'konva', width: 800, height: 600 });
            layer = new Konva.Layer();
            stage.add(layer);
            circuits.forEach((c, i) => {
                const ps = new Konva.Stage({ container: `p${i}`, width: 268, height: 100 });
                const pl = new Konva.Layer();
                ps.add(pl);
                pl.add(new Konva.Line({ points:c.pts.flat().map((v,j) => j%2===0 ? v*0.335 : v*0.167), stroke:c.col, strokeWidth:8, closed:true, lineJoin:'round' }));
                pl.draw();
            });
        }
        
        function showScreen(screenId) {
            document.querySelectorAll('.screen').forEach(s => s.classList.add('hidden'));
            document.getElementById(screenId).classList.remove('hidden');
        }
        
        function start(i) {
            circ = circuits[i];
            document.querySelectorAll('.screen').forEach(s => s.classList.add('hidden'));
            document.getElementById('hud').classList.remove('hidden');
            lap=1; score=0; cpIdx=0; t0=Date.now(); dp=0;
            state = {...circ.start, spd:0, drift:0};
            layer.destroyChildren();
            
            layer.add(new Konva.Rect({ x:0, y:0, width:800, height:600, fill:'#1a1a2e' }));
            layer.add(new Konva.Line({ points:circ.pts.flat(), stroke:'#333', strokeWidth:80, closed:true, lineJoin:'round' }));
            layer.add(new Konva.Line({ points:circ.pts.flat(), stroke:'#2a2a3e', strokeWidth:60, closed:true, lineJoin:'round' }));
            layer.add(new Konva.Line({ points:circ.pts.flat(), stroke:circ.col, strokeWidth:3, closed:true, lineJoin:'round', dash:[15,10], opacity:0.6 }));
            
            cps = circ.pts.map((p,j) => {
                const cp = new Konva.Circle({ x:p[0], y:p[1], radius:20, fill:j===0?'#ffd700':'#555', stroke:'#fff', strokeWidth:2, opacity:0.7 });
                layer.add(cp);
                return cp;
            });
            
            car = new Konva.Group({ x:state.x, y:state.y, rotation:state.a*180/Math.PI });
            car.add(new Konva.Rect({ x:-15, y:-15, width:30, height:30, fill:'#ff0000', cornerRadius:4, shadowColor:'black', shadowBlur:10, shadowOpacity:0.5 }));
            car.add(new Konva.Rect({ x:12, y:-10, width:5, height:20, fill:'#ffff00', cornerRadius:2 }));
            car.add(new Konva.Rect({ x:-7, y:-10, width:15, height:7, fill:'#88ccff', cornerRadius:2 }));
            layer.add(car);
            layer.draw();
            
            if(loop) cancelAnimationFrame(loop);
            loop = requestAnimationFrame(update);
        }
        
        function update() {
            if(keys.ArrowUp||keys.w||keys.W) state.spd = Math.min(state.spd + 0.2, 6);
            else if(keys.ArrowDown||keys.s||keys.S) state.spd = Math.max(state.spd - 0.2, -3);
            
            let drifting = false;
            if(Math.abs(state.spd) > 0.5) {
                if(keys.ArrowLeft||keys.a||keys.A) {
                    state.a -= 0.06 * Math.abs(state.spd) / 6;
                    if(Math.abs(state.spd) > 2.5) { state.drift += 0.03; drifting = true; }
                }
                if(keys.ArrowRight||keys.d||keys.D) {
                    state.a += 0.06 * Math.abs(state.spd) / 6;
                    if(Math.abs(state.spd) > 2.5) { state.drift -= 0.03; drifting = true; }
                }
            }
            
            if(drifting && Math.abs(state.drift) > 0.05) {
                const db = Math.floor(Math.abs(state.drift) * 20);
                dp += db; score += db;
                const now = Date.now();
                if(now - lastD > 300) {
                    const d = document.getElementById('drift');
                    d.textContent = `+${db} DRIFT!`;
                    d.style.animation = 'pulse 0.5s';
                    setTimeout(() => d.style.animation = '', 500);
                    lastD = now;
                }
                document.getElementById('db').textContent = `Drift: +${dp}`;
            } else if(dp > 0) {
                dp = 0;
                document.getElementById('db').textContent = '';
            }
            
            state.drift *= 0.92;
            state.spd *= 0.96;
            const ma = state.a + state.drift;
            state.x += Math.cos(ma) * state.spd;
            state.y += Math.sin(ma) * state.spd;
            state.x = Math.max(30, Math.min(770, state.x));
            state.y = Math.max(30, Math.min(570, state.y));
            
            car.position({ x:state.x, y:state.y });
            car.rotation(state.a * 180 / Math.PI);
            
            const cp = cps[cpIdx];
            const dx = state.x - cp.x(), dy = state.y - cp.y();
            if(Math.sqrt(dx*dx + dy*dy) < 40) {
                score += 50;
                cpIdx++;
                if(cpIdx >= cps.length) {
                    cpIdx = 0;
                    lap++;
                    score += 200;
                    if(lap > 3) { end(); return; }
                }
                cps.forEach((c,j) => c.fill(j===cpIdx?'#ffd700':'#555'));
            }
            
            document.getElementById('lap').textContent = lap;
            document.getElementById('score').textContent = score;
            document.getElementById('time').textContent = ((Date.now() - t0) / 1000).toFixed(1);
            
            layer.batchDraw();
            loop = requestAnimationFrame(update);
        }
        
        function end() {
            cancelAnimationFrame(loop);
            const ft = ((Date.now() - t0) / 1000).toFixed(1);
            document.getElementById('fs').textContent = score;
            document.getElementById('ft').textContent = ft;
            
            let lb = JSON.parse(localStorage.getItem('driftLB') || '[]');
            lb.push({score:score, time:parseFloat(ft), circuit:circ.name});
            lb.sort((a,b) => b.score - a.score);
            lb = lb.slice(0, 10);
            localStorage.setItem('driftLB', JSON.stringify(lb));
            
            let html = '<h3>TOP 10 CLASIFICACIÓN</h3>';
            lb.forEach((e, i) => {
                html += `<div class="entry ${i===0?'highlight':''}"><span>${i+1}. ${e.circuit}</span><span>${e.score} pts - ${e.time}s</span></div>`;
            });
            if(lb.length === 0) html += '<p style="color:#a0a0b0;text-align:center;">No hay registros aún</p>';
            document.getElementById('leaderboard').innerHTML = html;
            
            document.getElementById('hud').classList.add('hidden');
            showScreen('results');
        }
        
        window.addEventListener('keydown', e => { keys[e.key] = true; e.preventDefault(); });
        window.addEventListener('keyup', e => { keys[e.key] = false; e.preventDefault(); });
        
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
        else init();
    </script>
</body>
</html>