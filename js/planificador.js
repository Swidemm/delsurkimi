/*
 * planificador.js - Versión "Etiquetas + Pro"
 * Incluye: Herramienta Texto (T), Rotación (R), Muros doble línea, Cotas y m².
 */

(() => {
  window.addEventListener('DOMContentLoaded', () => {
    // --- REFERENCIAS DOM ---
    const canvas = document.getElementById('plan2d');
    const hudStatus = document.getElementById('hudStatus');
    
    // Inputs
    const inputs = {
      wallH: document.getElementById('wallH'),
      wallT: document.getElementById('wallT'),
      scale: document.getElementById('scaleInput'),
      snap: document.getElementById('snap'),
      grid: document.getElementById('gridToggle')
    };

    // Herramientas
    const tools = {
      select: document.getElementById('tool-select'),
      pan:    document.getElementById('tool-pan'),
      wall:   document.getElementById('tool-wall'),
      room:   document.getElementById('tool-room'),
      door:   document.getElementById('tool-door'),
      window: document.getElementById('tool-window'),
      text:   document.getElementById('tool-text'), // <--- NUEVO
      erase:  document.getElementById('tool-erase'),
      undo:   document.getElementById('tool-undo'),
      redo:   document.getElementById('tool-redo'),
      reset:  document.getElementById('tool-reset')
    };

    // --- ESTADO ---
    const state = {
      tool: 'select', 
      walls: [],
      openings: [], 
      furniture: [], 
      labels: [], // {x, y, text}
      
      // Navegación
      scale: 40, 
      offset: { x: 50, y: 50 }, 
      isPanning: false,
      lastMouse: { x: 0, y: 0 },

      // Acción actual
      activeWall: null, 
      activeRoom: null, 
      selection: null,  
      currentItem: null, 

      // Config
      snap: true,
      grid: true,
      wallThickness: 0.20,
      
      // Historial
      history: [],
      historyIndex: -1
    };

    const ctx = canvas.getContext('2d');

    // --- INICIALIZACIÓN ---
    function init() {
      resizeCanvas();
      window.addEventListener('resize', resizeCanvas);
      loadProject();
      bindEvents();
      bindShortcuts();
      draw();
    }

    function resizeCanvas() {
      const parent = canvas.parentElement;
      canvas.width = parent.clientWidth;
      canvas.height = parent.clientHeight;
      draw();
    }

    // --- ATAJOS TECLADO ---
    function bindShortcuts() {
        window.addEventListener('keydown', (e) => {
            if (e.target.tagName === 'INPUT') return;
            switch(e.key.toLowerCase()) {
                case '1': setTool('select'); break;
                case '2': setTool('pan'); break;
                case '3': setTool('wall'); break;
                case '4': setTool('room'); break;
                case 't': setTool('text'); break; // <--- NUEVO
                case 'r': // ROTAR
                    if (state.selection) rotateSelection();
                    break;
                case 'escape':
                    state.activeWall = null;
                    state.activeRoom = null;
                    state.selection = null;
                    state.currentItem = null;
                    document.querySelectorAll('.lib-item').forEach(el => el.classList.remove('active'));
                    setTool('select');
                    draw();
                    break;
                case 'delete': 
                case 'backspace':
                    if (state.selection) deleteSelection();
                    break;
                case 'z': if (e.ctrlKey || e.metaKey) undo(); break;
                case 'y': if (e.ctrlKey || e.metaKey) redo(); break;
            }
        });
    }

    function rotateSelection() {
        const s = state.selection;
        if (!s) return;

        if (s.type === 'furniture') {
            s.obj.rot = (s.obj.rot + Math.PI/2) % (Math.PI * 2);
        } 
        else if (s.type === 'opening') {
            s.obj.flip = (s.obj.flip || 0) + 1;
            if (s.obj.flip > 3) s.obj.flip = 0;
        }
        saveState();
        draw();
    }

    // --- EVENTOS ---
    function bindEvents() {
        Object.keys(tools).forEach(key => {
            if (!tools[key]) return;
            tools[key].addEventListener('click', () => {
                if (['undo', 'redo', 'reset'].includes(key)) {
                    if (key === 'undo') undo();
                    if (key === 'redo') redo();
                    if (key === 'reset') resetProject();
                } else {
                    setTool(key);
                }
            });
        });

        canvas.addEventListener('mousedown', onMouseDown);
        canvas.addEventListener('mousemove', onMouseMove);
        canvas.addEventListener('mouseup', onMouseUp);
        canvas.addEventListener('wheel', onWheel);

        if (inputs.grid) inputs.grid.addEventListener('change', () => { state.grid = inputs.grid.checked; draw(); });
        if (inputs.snap) inputs.snap.addEventListener('change', () => { state.snap = inputs.snap.checked; });
        if (inputs.wallT) inputs.wallT.addEventListener('change', () => { state.wallThickness = parseFloat(inputs.wallT.value); draw(); });
        
        document.querySelectorAll('.lib-item').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.lib-item').forEach(el => el.classList.remove('active'));
                item.classList.add('active');
                state.currentItem = {
                    type: item.dataset.type,
                    w: parseFloat(item.dataset.w),
                    d: parseFloat(item.dataset.d),
                    rot: 0
                };
                setTool('select');
                hudStatus.textContent = "Haz clic para colocar. Usa 'R' para rotar.";
            });
        });
    }

    function setTool(name) {
        state.tool = name;
        state.activeWall = null;
        state.activeRoom = null;
        
        document.querySelectorAll('.tool-btn').forEach(btn => btn.classList.remove('active'));
        if (tools[name]) tools[name].classList.add('active');

        const msgs = {
            'select': 'Selecciona un objeto. Presiona "R" para rotarlo.',
            'pan': 'Arrastra para mover la vista.',
            'wall': 'Clic Inicio -> Clic Fin.',
            'room': 'Clic esquina -> Arrastra -> Clic opuesto.',
            'door': 'Clic en pared para puerta.',
            'window': 'Clic en pared para ventana.',
            'text': 'Clic en el plano para agregar nombre de ambiente.',
            'erase': 'Clic para borrar.'
        };
        hudStatus.textContent = msgs[name] || '';
        
        if (name !== 'select') {
             state.currentItem = null;
             document.querySelectorAll('.lib-item').forEach(el => el.classList.remove('active'));
        }
        draw();
    }

    // --- LOGICA MOUSE ---

    function onMouseDown(e) {
        const m = getMousePos(e);
        const wM = toWorld(m.x, m.y);

        if (state.tool === 'pan' || e.button === 1) {
            state.isPanning = true;
            state.lastMouse = m;
            canvas.style.cursor = 'grabbing';
            return;
        }

        // HERRAMIENTA TEXTO (NUEVA)
        if (state.tool === 'text') {
            const text = prompt("Nombre del ambiente (ej: Cocina, Baño):", "Habitación");
            if (text && text.trim() !== "") {
                state.labels.push({ x: wM.x, y: wM.y, text: text.trim() });
                saveState();
                hudStatus.textContent = "Etiqueta agregada.";
                // Volver a seleccionar para comodidad
                setTool('select');
            }
            draw();
            return;
        }

        if (state.tool === 'wall') {
            const snapPos = applySnap(wM.x, wM.y);
            if (!state.activeWall) {
                state.activeWall = { start: snapPos, end: snapPos };
            } else {
                state.activeWall.end = snapPos;
                if (dist(state.activeWall.start, state.activeWall.end) > 0.1) {
                    addWall(state.activeWall.start, state.activeWall.end);
                }
                state.activeWall = null; 
                saveState();
            }
            draw();
            return;
        }

        if (state.tool === 'room') {
            const snapPos = applySnap(wM.x, wM.y);
            if (!state.activeRoom) {
                state.activeRoom = { start: snapPos, end: snapPos };
                hudStatus.textContent = "Arrastra hacia la esquina opuesta y haz clic.";
            } else {
                const s = state.activeRoom.start;
                const e = applySnap(wM.x, wM.y);
                
                addWall({x: s.x, y: s.y}, {x: e.x, y: s.y});
                addWall({x: e.x, y: s.y}, {x: e.x, y: e.y});
                addWall({x: e.x, y: e.y}, {x: s.x, y: e.y});
                addWall({x: s.x, y: e.y}, {x: s.x, y: s.y});

                // ETIQUETA M2 AUTOMATICA
                const w = Math.abs(e.x - s.x);
                const h = Math.abs(e.y - s.y);
                const area = (w * h).toFixed(2);
                const cx = (s.x + e.x) / 2;
                const cy = (s.y + e.y) / 2;
                state.labels.push({ x: cx, y: cy, text: `${area} m²` });
                
                state.activeRoom = null;
                hudStatus.textContent = "Habitación creada.";
                saveState();
            }
            draw();
            return;
        }

        if (state.currentItem) {
            addFurniture(wM.x, wM.y, state.currentItem);
            saveState();
            draw();
            return;
        }

        if (state.tool === 'select') {
            // 1. Etiquetas
            const clickedLabel = state.labels.find(l => dist(wM, {x: l.x, y: l.y}) < 0.5);
            if (clickedLabel) {
                state.selection = { type: 'label', obj: clickedLabel };
                draw();
                return;
            }
            // 2. Muebles
            const clickedFurn = state.furniture.find(f => hitTestRect(wM, f));
            if (clickedFurn) {
                state.selection = { type: 'furniture', obj: clickedFurn };
                draw();
                return;
            }
            // 3. Aberturas
            const clickedOpening = state.openings.find(op => dist(wM, {x: op.x, y: op.y}) < 0.4);
            if (clickedOpening) {
                state.selection = { type: 'opening', obj: clickedOpening };
                hudStatus.textContent = "Abertura seleccionada. Presiona 'R' para cambiar apertura.";
                draw();
                return;
            }
            // 4. Paredes
            const clickedWall = state.walls.find(w => hitTestLine(wM, w.start, w.end, 0.2));
            if (clickedWall) {
                state.selection = { type: 'wall', obj: clickedWall };
                draw();
                return;
            }
            state.selection = null;
            draw();
        }

        if (state.tool === 'door' || state.tool === 'window') {
            const targetWall = state.walls.find(w => hitTestLine(wM, w.start, w.end, 0.3));
            if (targetWall) {
                addOpening(targetWall, wM, state.tool);
                saveState();
                draw();
            }
        }
        
        if (state.tool === 'erase') {
            const lIndex = state.labels.findIndex(l => dist(wM, {x: l.x, y: l.y}) < 0.5);
            if(lIndex >= 0) { state.labels.splice(lIndex, 1); saveState(); draw(); return; }

            const fIndex = state.furniture.findIndex(f => hitTestRect(wM, f));
            if (fIndex >= 0) { state.furniture.splice(fIndex, 1); saveState(); draw(); return; }
            
            const oIndex = state.openings.findIndex(op => dist(wM, {x: op.x, y: op.y}) < 0.4);
            if (oIndex >= 0) { state.openings.splice(oIndex, 1); saveState(); draw(); return; }

            const wIndex = state.walls.findIndex(w => hitTestLine(wM, w.start, w.end, 0.2));
            if (wIndex >= 0) {
                state.walls.splice(wIndex, 1);
                state.openings = state.openings.filter(o => o.wallIndex !== wIndex);
                saveState();
                draw();
            }
        }
    }

    function onMouseMove(e) {
        const m = getMousePos(e);
        const wM = toWorld(m.x, m.y);

        if (state.isPanning) {
            state.offset.x += m.x - state.lastMouse.x;
            state.offset.y += m.y - state.lastMouse.y;
            state.lastMouse = m;
            draw();
            return;
        }

        if (state.tool === 'wall' && state.activeWall) {
            state.activeWall.end = applySnap(wM.x, wM.y);
            draw();
        }

        if (state.tool === 'room' && state.activeRoom) {
            state.activeRoom.end = applySnap(wM.x, wM.y);
            draw();
        }

        if (state.currentItem) {
            draw();
            ctx.save();
            applyTransform();
            ctx.globalAlpha = 0.5;
            drawFurnitureObj(wM.x, wM.y, state.currentItem.w, state.currentItem.d, state.currentItem.type, 0);
            ctx.restore();
        }
    }

    function onMouseUp(e) {
        state.isPanning = false;
        canvas.style.cursor = 'default';
    }

    function onWheel(e) {
        e.preventDefault();
        const delta = e.deltaY < 0 ? 1 : -1;
        const newScale = state.scale + (delta * state.scale * 0.1);
        
        if (newScale > 5 && newScale < 200) {
            const m = getMousePos(e);
            const wx = (m.x - state.offset.x) / state.scale;
            const wy = (m.y - state.offset.y) / state.scale;

            state.offset.x -= wx * (newScale - state.scale);
            state.offset.y -= wy * (newScale - state.scale);
            state.scale = newScale;
            draw();
        }
    }

    // --- DIBUJO ---

    function draw() {
        ctx.fillStyle = '#151d30';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.save();
        applyTransform();

        if (state.grid) drawGrid();

        // 1. Etiquetas (Abajo)
        state.labels.forEach(l => {
            const isSel = state.selection && state.selection.obj === l;
            drawLabel(l, isSel);
        });

        // 2. Muebles
        state.furniture.forEach(f => {
            const isSel = state.selection && state.selection.obj === f;
            drawFurnitureObj(f.x, f.y, f.w, f.d, f.type, f.rot, isSel);
        });

        // 3. Paredes
        state.walls.forEach(wall => {
            const isSel = state.selection && state.selection.obj === wall;
            drawArchitecturalWall(wall, isSel);
        });
        state.walls.forEach(wall => {
             drawDimension(wall.start, wall.end, false);
        });

        // 4. Fantasmas
        if (state.activeWall) {
            drawGhostWall(state.activeWall.start, state.activeWall.end);
            drawDimension(state.activeWall.start, state.activeWall.end, true);
        }

        if (state.activeRoom) {
            const s = state.activeRoom.start;
            const e = state.activeRoom.end;
            drawGhostWall({x:s.x, y:s.y}, {x:e.x, y:s.y});
            drawGhostWall({x:e.x, y:s.y}, {x:e.x, y:e.y});
            drawGhostWall({x:e.x, y:e.y}, {x:s.x, y:e.y});
            drawGhostWall({x:s.x, y:e.y}, {x:s.x, y:s.y});
            
            const area = (Math.abs(e.x - s.x) * Math.abs(e.y - s.y)).toFixed(2);
            const cx = (s.x + e.x) / 2 * state.scale;
            const cy = (s.y + e.y) / 2 * state.scale;
            
            ctx.beginPath();
            ctx.fillStyle = 'rgba(249, 115, 22, 0.2)'; 
            ctx.strokeStyle = '#f97316';
            ctx.lineWidth = 1;
            const boxW = 80;
            const boxH = 40;
            ctx.roundRect(cx - boxW/2, cy - boxH/2, boxW, boxH, 5);
            ctx.fill();
            ctx.stroke();

            ctx.fillStyle = '#fff';
            ctx.font = 'bold 16px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(`${area} m²`, cx, cy + 5);
        }

        // 5. Puertas y Ventanas
        state.openings.forEach(op => {
            const isSel = state.selection && state.selection.obj === op;
            drawOpeningDetail(op, isSel);
        });

        ctx.restore();
    }

    function applyTransform() {
        ctx.translate(state.offset.x, state.offset.y);
    }

    function drawGrid() {
        ctx.save();
        const step = state.scale;
        const range = 50;
        
        ctx.strokeStyle = 'rgba(255,255,255,0.05)';
        ctx.lineWidth = 1;
        
        ctx.beginPath();
        for(let x = -range; x <= range; x++) {
            ctx.moveTo(x * step, -range * step);
            ctx.lineTo(x * step, range * step);
        }
        for(let y = -range; y <= range; y++) {
            ctx.moveTo(-range * step, y * step);
            ctx.lineTo(range * step, y * step);
        }
        ctx.stroke();
        ctx.restore();
    }

    function drawArchitecturalWall(wall, selected) {
        const sx = wall.start.x * state.scale;
        const sy = wall.start.y * state.scale;
        const ex = wall.end.x * state.scale;
        const ey = wall.end.y * state.scale;
        
        ctx.beginPath();
        ctx.lineCap = 'butt';
        ctx.lineWidth = state.wallThickness * state.scale;
        ctx.strokeStyle = selected ? 'rgba(110, 231, 255, 0.3)' : '#334155';
        ctx.moveTo(sx, sy);
        ctx.lineTo(ex, ey);
        ctx.stroke();

        const dx = ex - sx;
        const dy = ey - sy;
        const len = Math.sqrt(dx*dx + dy*dy);
        const nx = -dy / len; 
        const ny = dx / len;  
        const offset = (state.wallThickness * state.scale) / 2;

        ctx.lineWidth = 2;
        ctx.strokeStyle = selected ? '#6ee7ff' : '#94a3b8';
        ctx.beginPath();
        ctx.moveTo(sx + nx * offset, sy + ny * offset);
        ctx.lineTo(ex + nx * offset, ey + ny * offset);
        ctx.moveTo(sx - nx * offset, sy - ny * offset);
        ctx.lineTo(ex - nx * offset, ey - ny * offset);
        ctx.stroke();
        
        if (!selected) {
            ctx.lineWidth = 1;
            ctx.strokeStyle = 'rgba(255,255,255,0.1)';
            ctx.setLineDash([5, 5]);
            ctx.beginPath();
            ctx.moveTo(sx, sy);
            ctx.lineTo(ex, ey);
            ctx.stroke();
            ctx.setLineDash([]);
        }

        ctx.fillStyle = '#fff';
        ctx.beginPath();
        ctx.arc(sx, sy, 3, 0, Math.PI*2);
        ctx.arc(ex, ey, 3, 0, Math.PI*2);
        ctx.fill();
    }

    function drawGhostWall(start, end) {
        ctx.beginPath();
        ctx.strokeStyle = '#f97316';
        ctx.lineWidth = state.wallThickness * state.scale;
        ctx.lineCap = 'round';
        ctx.globalAlpha = 0.5;
        ctx.moveTo(start.x * state.scale, start.y * state.scale);
        ctx.lineTo(end.x * state.scale, end.y * state.scale);
        ctx.stroke();
        ctx.globalAlpha = 1.0;
    }

    function drawFurnitureObj(x, y, w, d, type, rot, selected) {
        ctx.save();
        ctx.translate(x * state.scale, y * state.scale);
        ctx.rotate(rot);

        const sw = w * state.scale;
        const sd = d * state.scale;

        ctx.fillStyle = selected ? 'rgba(110, 231, 255, 0.2)' : '#1e293b';
        ctx.strokeStyle = selected ? '#6ee7ff' : '#475569';
        ctx.lineWidth = 2;
        
        ctx.beginPath();
        ctx.rect(-sw/2, -sd/2, sw, sd);
        ctx.fill();
        ctx.stroke();
        
        ctx.beginPath();
        ctx.moveTo(-sw/2, -sd/2);
        ctx.lineTo(sw/2, sd/2);
        ctx.moveTo(sw/2, -sd/2);
        ctx.lineTo(-sw/2, sd/2);
        ctx.strokeStyle = 'rgba(255,255,255,0.05)';
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(0, sd/2 - 5);
        ctx.lineTo(0, sd/2 + 5);
        ctx.strokeStyle = '#f97316';
        ctx.stroke();

        ctx.restore();
    }
    
    function drawLabel(label, selected) {
        const cx = label.x * state.scale;
        const cy = label.y * state.scale;
        
        ctx.save();
        ctx.beginPath();
        ctx.fillStyle = selected ? 'rgba(249, 115, 22, 0.4)' : 'rgba(249, 115, 22, 0.1)';
        ctx.strokeStyle = selected ? '#fff' : '#f97316';
        
        const text = label.text;
        ctx.font = 'bold 16px Arial';
        const metrics = ctx.measureText(text);
        const w = metrics.width + 20;
        const h = 30;
        
        ctx.roundRect(cx - w/2, cy - h/2, w, h, 8);
        ctx.fill();
        ctx.stroke();
        
        ctx.fillStyle = '#fff';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(text, cx, cy);
        ctx.restore();
    }

    function drawOpeningDetail(op, selected) {
        const wall = state.walls[op.wallIndex];
        if(!wall) return;

        const dx = wall.end.x - wall.start.x;
        const dy = wall.end.y - wall.start.y;
        const angle = Math.atan2(dy, dx);
        
        const cx = op.x * state.scale;
        const cy = op.y * state.scale;
        const size = 0.8 * state.scale;
        
        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(angle);

        const flip = op.flip || 0;
        const scaleX = (flip === 1 || flip === 3) ? -1 : 1;
        const scaleY = (flip === 2 || flip === 3) ? -1 : 1;
        ctx.scale(scaleX, scaleY);

        ctx.fillStyle = '#151d30';
        const thick = (state.wallThickness * state.scale);
        ctx.fillRect(-size/2, -thick/2 - 2, size, thick + 4);
        
        if (selected) {
            ctx.strokeStyle = '#6ee7ff';
            ctx.lineWidth = 2;
            ctx.strokeRect(-size/2 - 2, -thick/2 - 4, size + 4, thick + 8);
        }

        if (op.type === 'door') {
            ctx.strokeStyle = '#fde047'; 
            ctx.lineWidth = 2;
            
            ctx.beginPath();
            ctx.moveTo(-size/2, 0);
            ctx.lineTo(-size/2, -size); 
            ctx.stroke();
            
            ctx.beginPath();
            ctx.arc(-size/2, 0, size, -Math.PI/2, 0); 
            ctx.setLineDash([3, 3]);
            ctx.stroke();
            ctx.setLineDash([]);
            
        } else if (op.type === 'window') {
            ctx.fillStyle = 'rgba(96, 165, 250, 0.3)';
            ctx.fillRect(-size/2, -2, size, 4);
            ctx.fillStyle = '#94a3b8'; 
            ctx.fillRect(-size/2, -thick/2, 2, thick);
            ctx.fillRect(size/2 - 2, -thick/2, 2, thick);
        }
        
        ctx.restore();
    }

    function drawDimension(p1, p2, active) {
        const midX = (p1.x + p2.x) / 2 * state.scale;
        const midY = (p1.y + p2.y) / 2 * state.scale;
        const len = dist(p1, p2).toFixed(2) + 'm';
        
        ctx.save();
        const dx = p2.x - p1.x;
        const dy = p2.y - p1.y;
        let angle = Math.atan2(dy, dx);
        if (angle > Math.PI/2 || angle < -Math.PI/2) angle += Math.PI;

        ctx.translate(midX, midY);
        ctx.rotate(angle);
        
        ctx.fillStyle = active ? '#f97316' : '#64748b';
        ctx.font = active ? 'bold 12px Arial' : '11px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';
        
        ctx.fillText(len, 0, -5);
        ctx.restore();
    }

    // --- UTILS ---
    function getMousePos(evt) {
        const rect = canvas.getBoundingClientRect();
        return { x: evt.clientX - rect.left, y: evt.clientY - rect.top };
    }
    function toWorld(sx, sy) {
        return { x: (sx - state.offset.x) / state.scale, y: (sy - state.offset.y) / state.scale };
    }
    function dist(p1, p2) {
        return Math.sqrt(Math.pow(p2.x - p1.x, 2) + Math.pow(p2.y - p1.y, 2));
    }
    function applySnap(x, y) {
        if (!state.snap) return { x, y };
        let resX = x, resY = y, snapped = false;
        for (let w of state.walls) {
            if (dist({x,y}, w.start) < 0.3) return { x: w.start.x, y: w.start.y };
            if (dist({x,y}, w.end) < 0.3) return { x: w.end.x, y: w.end.y };
        }
        if (state.activeWall) {
            const s = state.activeWall.start;
            if (Math.abs(x - s.x) < 0.2) resX = s.x;
            if (Math.abs(y - s.y) < 0.2) resY = s.y;
        }
        if (!snapped) {
            resX = Math.round(resX * 2) / 2;
            resY = Math.round(resY * 2) / 2;
        }
        return { x: resX, y: resY };
    }

    function addWall(start, end) {
        state.walls.push({ start: { ...start }, end: { ...end } });
    }
    function addFurniture(x, y, item) {
        state.furniture.push({ x, y, w: item.w, d: item.d, type: item.type, rot: 0 });
    }
    function addOpening(wall, pos, type) {
        state.openings.push({ x: pos.x, y: pos.y, type, wallIndex: state.walls.indexOf(wall), flip: 0 });
    }

    function deleteSelection() {
        if (!state.selection) return;
        if (state.selection.type === 'label') {
            const idx = state.labels.indexOf(state.selection.obj);
            if (idx > -1) state.labels.splice(idx, 1);
        }
        if (state.selection.type === 'furniture') {
            const idx = state.furniture.indexOf(state.selection.obj);
            if (idx > -1) state.furniture.splice(idx, 1);
        }
        if (state.selection.type === 'opening') {
            const idx = state.openings.indexOf(state.selection.obj);
            if (idx > -1) state.openings.splice(idx, 1);
        }
        if (state.selection.type === 'wall') {
            const idx = state.walls.indexOf(state.selection.obj);
            if (idx > -1) state.walls.splice(idx, 1);
        }
        state.selection = null;
        saveState();
        draw();
    }

    function hitTestRect(pt, box) {
        const maxDim = Math.max(box.w, box.d);
        return (pt.x > box.x - maxDim/2 && pt.x < box.x + maxDim/2 &&
                pt.y > box.y - maxDim/2 && pt.y < box.y + maxDim/2);
    }
    function hitTestLine(pt, p1, p2, tolerance) {
        const A = pt.x - p1.x, B = pt.y - p1.y, C = p2.x - p1.x, D = p2.y - p1.y;
        const dot = A * C + B * D;
        const len_sq = C * C + D * D;
        let param = -1;
        if (len_sq != 0) param = dot / len_sq;
        let xx, yy;
        if (param < 0) { xx = p1.x; yy = p1.y; }
        else if (param > 1) { xx = p2.x; yy = p2.y; }
        else { xx = p1.x + param * C; yy = p1.y + param * D; }
        const dx = pt.x - xx, dy = pt.y - yy;
        return Math.sqrt(dx * dx + dy * dy) < tolerance;
    }

    function saveState() {
        if (state.historyIndex < state.history.length - 1) {
            state.history = state.history.slice(0, state.historyIndex + 1);
        }
        const snapshot = JSON.stringify({ walls: state.walls, furniture: state.furniture, openings: state.openings, labels: state.labels });
        state.history.push(snapshot);
        if (state.history.length > 20) state.history.shift();
        else state.historyIndex++;
        localStorage.setItem('delsur_project', snapshot);
    }

    function undo() {
        if (state.historyIndex > 0) {
            state.historyIndex--;
            loadFromJSON(state.history[state.historyIndex]);
        }
    }
    function redo() {
        if (state.historyIndex < state.history.length - 1) {
            state.historyIndex++;
            loadFromJSON(state.history[state.historyIndex]);
        }
    }
    function loadFromJSON(json) {
        const data = JSON.parse(json);
        state.walls = data.walls || [];
        state.furniture = data.furniture || [];
        state.openings = data.openings || [];
        state.labels = data.labels || [];
        draw();
    }
    function loadProject() {
        const saved = localStorage.getItem('delsur_project');
        if (saved) {
            loadFromJSON(saved);
            saveState();
        }
    }
    function resetProject() {
        if(confirm('¿Borrar todo?')) {
            state.walls = []; state.furniture = []; state.openings = []; state.labels = [];
            saveState(); draw();
        }
    }

    init();
  });
})();