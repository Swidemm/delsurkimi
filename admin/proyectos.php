<?php
// admin/proyectos.php - Gestión de Proyectos - VERSIÓN 2025
require_once '../auth.php';
requireLogin();

$jsonFile = '../proyectos.json';
$proyectos = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Proyectos - Del Sur Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        delsur: {
                            900: '#0f172a',
                            accent: '#ea580c',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        
        .img-container {
            width: 100%;
            padding-top: 56.25%;
            position: relative;
            overflow: hidden;
            background-color: #f1f5f9;
        }
        .img-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }
        .project-card:hover .img-container img {
            transform: scale(1.05);
        }
        
        .form-section {
            transition: all 0.3s ease;
        }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 pb-20">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <a href="index.php" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-900 transition-colors">
                        <i class="ph ph-arrow-left text-xl"></i>
                    </a>
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="ph ph-buildings text-xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-slate-900">Gestionar Proyectos</h1>
                        <p class="text-xs text-slate-500">Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Form Section -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 id="formTitle" class="font-bold text-xl flex items-center gap-2 text-slate-900">
                    <i class="ph ph-plus-circle text-orange-500"></i>
                    Nuevo Proyecto
                </h2>
                <button id="btnCancel" onclick="resetForm()" class="hidden px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition-colors">
                    Cancelar Edición
                </button>
            </div>

            <form id="formProyecto">
                <input type="hidden" name="accion" id="accionInput" value="crear">
                <input type="hidden" name="id" id="idInput" value="">

                <div class="grid md:grid-cols-3 gap-6 mb-6">
                    <!-- Column 1: Info Principal -->
                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">1. Info Principal</label>
                        <input type="text" id="titulo" name="titulo" required class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all" placeholder="Título del proyecto">
                        <select id="categoria" name="categoria" class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all">
                            <option value="Vivienda">Vivienda</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Refacción">Refacción</option>
                        </select>
                        <textarea id="descripcion" name="descripcion" required rows="4" class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all resize-none" placeholder="Descripción del proyecto..."></textarea>
                    </div>

                    <!-- Column 2: Detalles Técnicos -->
                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">2. Detalles Técnicos</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" id="ubicacion" name="ubicacion" class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all" placeholder="Ubicación">
                            <input type="text" id="anio" name="anio" class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all" placeholder="Año" value="2025">
                        </div>
                        <input type="text" id="medidas" name="medidas" class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all" placeholder="Superficie (ej: 120m²)">
                        <input type="text" id="titulo_features" name="titulo_features" class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all" value="Servicios Incluidos">
                    </div>

                    <!-- Column 3: Items y Fotos -->
                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">3. Items y Fotos</label>
                        <textarea id="features" name="features" rows="4" class="w-full border border-slate-200 p-3 rounded-xl bg-slate-50 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition-all resize-none text-sm" placeholder="Un ítem por línea&#10;• Diseño arquitectónico&#10;• Materiales de calidad&#10;• Garantía de obra"></textarea>
                        
                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center relative hover:bg-slate-50 hover:border-orange-300 cursor-pointer transition-all group">
                            <input type="file" name="imagenes[]" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewFiles(this)">
                            <div class="text-slate-400 group-hover:text-orange-500 transition-colors">
                                <i class="ph ph-images text-3xl mb-2"></i>
                                <p id="fileLabel" class="text-sm">Arrastrá fotos o hacé click</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end">
                    <button type="submit" id="btnSave" class="px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-orange-500/30 transition-all flex items-center gap-2">
                        <i class="ph ph-upload-simple"></i>
                        <span id="btnText">Publicar Proyecto</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Projects Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($proyectos as $p): 
                $imgPortada = is_array($p['imagenes']) ? $p['imagenes'][0] : $p['imagenes'];
                $esDestacado = isset($p['destacado']) && $p['destacado'] === true;
            ?>
            <div class="project-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col group relative">
                
                <div class="img-container">
                    <img src="../<?php echo htmlspecialchars($imgPortada); ?>" alt="<?php echo htmlspecialchars($p['titulo']); ?>">
                    
                    <!-- Actions Overlay -->
                    <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                        <button onclick="toggleDestacado('<?php echo $p['id']; ?>')" 
                                class="p-2.5 rounded-xl shadow-lg transition-all <?php echo $esDestacado ? 'bg-orange-500 text-white' : 'bg-white text-slate-400 hover:text-orange-500'; ?>"
                                title="<?php echo $esDestacado ? 'Quitar de la Home' : 'Mostrar en la Home'; ?>">
                            <i class="ph ph-star<?php echo $esDestacado ? '-fill' : ''; ?>"></i>
                        </button>

                        <button onclick='editar(<?php echo json_encode($p); ?>)' class="bg-white text-slate-700 p-2.5 rounded-xl shadow-lg hover:text-orange-600 transition-colors">
                            <i class="ph ph-pencil-simple"></i>
                        </button>
                        <button onclick="borrar('<?php echo $p['id']; ?>')" class="bg-red-500 text-white p-2.5 rounded-xl shadow-lg hover:bg-red-600 transition-colors">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                    
                    <?php if ($esDestacado): ?>
                    <div class="absolute top-3 left-3 px-3 py-1 bg-orange-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                        <i class="ph ph-star-fill"></i> DESTACADO
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-5 flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider"><?php echo htmlspecialchars($p['categoria']); ?></span>
                        <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-lg font-bold"><?php echo htmlspecialchars($p['anio'] ?? '2025'); ?></span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-3 leading-tight line-clamp-2"><?php echo htmlspecialchars($p['titulo']); ?></h3>
                    <div class="flex gap-4 text-xs text-slate-500 font-medium">
                        <span class="flex items-center gap-1">
                            <i class="ph ph-map-pin"></i> <?php echo htmlspecialchars($p['ubicacion'] ?? '-'); ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="ph ph-ruler"></i> <?php echo htmlspecialchars($p['medidas'] ?? '-'); ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($proyectos)): ?>
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ph ph-images text-4xl text-slate-400"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-700 mb-2">No hay proyectos</h3>
            <p class="text-slate-500">Agregá tu primer proyecto usando el formulario de arriba.</p>
        </div>
        <?php endif; ?>
    </div>

    <script>
    function previewFiles(input) {
        const count = input.files.length;
        const label = document.getElementById('fileLabel');
        if (count > 0) {
            label.innerHTML = `<span class="text-orange-600 font-bold">${count} foto${count > 1 ? 's' : ''} seleccionada${count > 1 ? 's' : ''}</span>`;
        } else {
            label.innerText = 'Arrastrá fotos o hacé click';
        }
    }

    async function toggleDestacado(id) {
        const fd = new FormData();
        fd.append('accion', 'toggle_destacado');
        fd.append('id', id);
        try {
            const res = await fetch('guardar_proyecto.php', { method: 'POST', body: fd });
            const data = await res.json();
            if(data.success) location.reload();
            else alert('Error al destacar');
        } catch(err) { console.error(err); }
    }

    function editar(p) {
        document.getElementById('idInput').value = p.id;
        document.getElementById('accionInput').value = 'editar';
        document.getElementById('titulo').value = p.titulo;
        document.getElementById('categoria').value = p.categoria;
        document.getElementById('descripcion').value = p.descripcion;
        document.getElementById('ubicacion').value = p.ubicacion || '';
        document.getElementById('anio').value = p.anio || '';
        document.getElementById('medidas').value = p.medidas || '';
        document.getElementById('titulo_features').value = p.titulo_features || '';
        
        let feats = p.features;
        if(Array.isArray(feats)) feats = feats.join('\n');
        document.getElementById('features').value = feats || '';

        document.getElementById('formTitle').innerHTML = '<i class="ph ph-pencil-simple text-orange-500"></i> Editando Proyecto';
        document.getElementById('btnText').innerText = 'Guardar Cambios';
        document.getElementById('btnCancel').classList.remove('hidden');
        document.getElementById('btnSave').classList.remove('from-orange-500', 'to-orange-600');
        document.getElementById('btnSave').classList.add('from-slate-700', 'to-slate-800');
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('formProyecto').reset();
        document.getElementById('idInput').value = '';
        document.getElementById('accionInput').value = 'crear';
        document.getElementById('formTitle').innerHTML = '<i class="ph ph-plus-circle text-orange-500"></i> Nuevo Proyecto';
        document.getElementById('btnText').innerText = 'Publicar Proyecto';
        document.getElementById('btnCancel').classList.add('hidden');
        document.getElementById('btnSave').classList.add('from-orange-500', 'to-orange-600');
        document.getElementById('btnSave').classList.remove('from-slate-700', 'to-slate-800');
        document.getElementById('fileLabel').innerText = 'Arrastrá fotos o hacé click';
    }

    document.getElementById('formProyecto').addEventListener('submit', async e => {
        e.preventDefault();
        const btn = document.getElementById('btnSave');
        const ogText = document.getElementById('btnText').innerText;
        btn.disabled = true;
        document.getElementById('btnText').innerText = 'Procesando...';
        
        const formData = new FormData(e.target);
        
        try {
            const res = await fetch('guardar_proyecto.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.success) location.reload();
            else alert('Error: ' + data.error);
        } catch(err) { alert('Error de conexión'); }
        
        btn.disabled = false;
        document.getElementById('btnText').innerText = ogText;
    });

    async function borrar(id) {
        if(!confirm('¿Borrar proyecto permanentemente?')) return;
        const fd = new FormData(); 
        fd.append('accion','eliminar'); 
        fd.append('id', id);
        await fetch('guardar_proyecto.php', { method: 'POST', body: fd });
        location.reload();
    }
    </script>
</body>
</html>
