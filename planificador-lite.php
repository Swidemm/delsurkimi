<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
  <title>Planificador Espacial — Pro</title>
  
  <style>
    :root {
      --bg-dark: #0f172a;       /* Slate 900 */
      --bg-panel: #1e293b;      /* Slate 800 */
      --border: #334155;        /* Slate 700 */
      --accent: #f97316;        /* Orange 500 */
      --accent-hover: #ea580c;  /* Orange 600 */
      --text: #f1f5f9;          /* Slate 100 */
      --text-muted: #94a3b8;    /* Slate 400 */
    }

    * { box-sizing: border-box; user-select: none; }
    
    body {
      margin: 0;
      background-color: var(--bg-dark);
      color: var(--text);
      font-family: 'Inter', system-ui, sans-serif;
      height: 100vh;
      display: grid;
      grid-template-rows: 50px 1fr;
      overflow: hidden;
    }

    /* HEADER */
    header {
      background: var(--bg-panel);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1rem;
    }
    .brand { font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
    .brand span { color: var(--accent); font-size: 0.8rem; background: rgba(249, 115, 22, 0.1); padding: 2px 6px; border-radius: 4px; }
    
    .top-actions { display: flex; gap: 0.5rem; }
    
    .btn {
      background: var(--border);
      color: var(--text);
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 0.8rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }
    .btn:hover { background: #475569; }
    .btn.primary { background: var(--accent); color: white; font-weight: 600; }
    .btn.primary:hover { background: var(--accent-hover); }
    .btn.danger { background: #ef4444; color: white; }
    
    /* MAIN LAYOUT */
    .workspace {
      display: grid;
      grid-template-columns: 60px 1fr 240px; /* Toolbar | Canvas | Sidebar */
      height: 100%;
    }

    /* TOOLBAR (LEFT) */
    .toolbar-left {
      background: var(--bg-panel);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 1rem;
      gap: 0.5rem;
    }
    
    .tool-btn {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      border: 1px solid transparent;
      background: transparent;
      color: var(--text-muted);
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.2rem;
      transition: all 0.2s;
    }
    .tool-btn:hover { background: var(--border); color: var(--text); }
    .tool-btn.active { background: var(--accent); color: white; box-shadow: 0 0 10px rgba(249, 115, 22, 0.4); }

    /* CANVAS AREA */
    .canvas-container {
      position: relative;
      background: #151d30; /* Darker blueprint bg */
      background-image: 
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 20px 20px;
      overflow: hidden;
    }
    canvas { display: block; cursor: crosshair; }
    
    .hud {
      position: absolute;
      bottom: 10px;
      left: 10px;
      background: rgba(0,0,0,0.5);
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 0.75rem;
      color: var(--text-muted);
      pointer-events: none;
    }

    /* SIDEBAR (RIGHT) */
    .sidebar-right {
      background: var(--bg-panel);
      border-left: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      overflow-y: auto;
    }
    
    .panel-section { padding: 1rem; border-bottom: 1px solid var(--border); }
    .panel-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.8rem; letter-spacing: 0.5px; }

    /* Controls inputs */
    .control-group { margin-bottom: 0.8rem; }
    .control-group label { display: block; font-size: 0.8rem; margin-bottom: 0.3rem; }
    .control-row { display: flex; gap: 0.5rem; align-items: center; }
    
    input[type="number"] {
      background: var(--bg-dark);
      border: 1px solid var(--border);
      color: var(--text);
      padding: 4px 8px;
      border-radius: 4px;
      width: 100%;
      font-size: 0.85rem;
    }
    input:focus { outline: 1px solid var(--accent); border-color: var(--accent); }
    
    /* Library Grid */
    .lib-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .lib-item {
      background: var(--bg-dark);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 8px;
      cursor: pointer;
      text-align: center;
      transition: all 0.2s;
    }
    .lib-item:hover { border-color: var(--text-muted); }
    .lib-item.active { border-color: var(--accent); background: rgba(249, 115, 22, 0.1); }
    .lib-item svg { width: 32px; height: 32px; margin-bottom: 4px; fill: var(--text-muted); }
    .lib-item div { font-size: 0.7rem; color: var(--text-muted); line-height: 1.2; }

    /* Responsive */
    @media (max-width: 768px) {
      .workspace { grid-template-columns: 50px 1fr; grid-template-rows: 1fr auto; }
      .sidebar-right { grid-column: 1 / -1; height: 180px; border-left: none; border-top: 1px solid var(--border); flex-direction: row; }
      .panel-section { width: 50%; border-bottom: none; border-right: 1px solid var(--border); }
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

  <header>
    <div class="brand">
      DEL SUR <span>STUDIO 2D</span>
    </div>
    <div class="top-actions">
      <button class="btn" id="tool-undo" title="Deshacer">↩</button>
      <button class="btn" id="tool-redo" title="Rehacer">↪</button>
      <button class="btn danger" id="tool-reset" title="Borrar todo">🗑</button>
      <div style="width: 10px;"></div>
      <button class="btn primary" id="btnExport">📷 Exportar Imagen</button>
    </div>
  </header>

  <div class="workspace">
    
    <div class="toolbar-left">
      <button class="tool-btn active" id="tool-select" title="Seleccionar">👆</button>
      <button class="tool-btn" id="tool-pan" title="Mover Vista">✋</button>
      <hr style="width: 20px; border-color: var(--border); opacity: 0.5;">
      <button class="tool-btn" id="tool-wall" title="Dibujar Pared">🧱</button>
      <button class="tool-btn" id="tool-room" title="Dibujar Habitación">📐</button>
      <button class="tool-btn" id="tool-door" title="Puerta">🚪</button>
      <button class="tool-btn" id="tool-window" title="Ventana">🪟</button>
      <hr style="width: 20px; border-color: var(--border); opacity: 0.5;">
      <button class="tool-btn" id="tool-erase" title="Goma de Borrar">❌</button>
      <button class="tool-btn" id="tool-window" title="Ventana">🪟</button>
      <button class="tool-btn" id="tool-text" title="Agregar Texto (T)">T</button> 
      <hr style="width: 20px; border-color: var(--border); opacity: 0.5;">
    </div>

    <div class="canvas-container" id="canvasWrap">
      <canvas id="plan2d"></canvas>
      <div class="hud" id="hudStatus">Listo</div>
    </div>

    <div class="sidebar-right">
      
      <div class="panel-section">
        <div class="panel-title">Propiedades</div>
        
        <div class="control-group">
          <label>Altura Muro (m)</label>
          <input id="wallH" type="number" step="0.1" value="2.7">
        </div>
        <div class="control-group">
          <label>Espesor (m)</label>
          <input id="wallT" type="number" step="0.05" value="0.15">
        </div>
        <div class="control-group">
            <label class="control-row">
                <input id="snap" type="checkbox" checked> Imán (Snap)
            </label>
        </div>
        <div class="control-group">
            <label class="control-row">
                <input id="gridToggle" type="checkbox" checked> Mostrar Grilla
            </label>
        </div>
         <input id="scaleInput" type="number" value="40" style="display:none;">
      </div>

      <div class="panel-section">
        <div class="panel-title">Mobiliario</div>
        <div class="lib-grid">
            <div class="lib-item" data-type="mesa" data-w="1.0" data-d="1.0">
                <svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" fill="currentColor"/></svg>
                <div>Mesa</div>
            </div>
            <div class="lib-item" data-type="cama" data-w="1.4" data-d="1.9">
                <svg viewBox="0 0 24 24"><path d="M4 8h16v12H4z" fill="currentColor"/><path d="M4 8h16v4H4z" fill="#fff" fill-opacity="0.2"/></svg>
                <div>Cama 2P</div>
            </div>
            <div class="lib-item" data-type="sillon" data-w="2.0" data-d="0.9">
                <svg viewBox="0 0 24 24"><path d="M4 12h16v8H4z" fill="currentColor"/><path d="M4 8h16v4H4z" fill="currentColor"/></svg>
                <div>Sillón</div>
            </div>
            <div class="lib-item" data-type="inodoro" data-w="0.5" data-d="0.7">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="10" r="4" fill="currentColor"/><rect x="8" y="16" width="8" height="6" rx="2" fill="currentColor"/></svg>
                <div>Baño</div>
            </div>
            <div class="lib-item" data-type="tv" data-w="1.2" data-d="0.2">
                <svg viewBox="0 0 24 24"><rect x="2" y="8" width="20" height="2" fill="currentColor"/></svg>
                <div>TV</div>
            </div>
            <div class="lib-item" data-type="heladera" data-w="0.7" data-d="0.7">
                <svg viewBox="0 0 24 24"><rect x="6" y="4" width="12" height="16" rx="1" fill="currentColor"/><line x1="6" y1="10" x2="18" y2="10" stroke="#000" stroke-opacity="0.3"/></svg>
                <div>Heladera</div>
            </div>
        </div>
      </div>

    </div>
  </div>

  <script src="js/planificador.js"></script>

  <script>
    // Funcionalidad extra para el botón Exportar
    document.getElementById('btnExport').addEventListener('click', () => {
        const canvas = document.getElementById('plan2d');
        
        // Crear un fondo blanco temporal para que la imagen no sea transparente
        // (Truco: dibujamos sobre un canvas temporal o aceptamos fondo negro)
        
        const link = document.createElement('a');
        link.download = 'mi-plano-delsur.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });

    // Pequeño hack para que los botones de herramientas resalten al clickear
    const toolBtns = document.querySelectorAll('.tool-btn');
    toolBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Solo si no es undo/redo/reset
            if(btn.id.includes('undo') || btn.id.includes('redo') || btn.id.includes('reset')) return;
            
            toolBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
  </script>
</body>
</html>
