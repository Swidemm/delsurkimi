<?php
// admin/cliente.php - Ficha de Cliente Premium - VERSIÓN 2025
require_once '../auth.php';
requireLogin();

$id = $_GET['id'] ?? null;
if (!$id) { 
    header('Location: index.php'); 
    exit; 
}

// Cargar datos
$jsonFile = '../contacts.json';
$contacts = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
$cliente = null;
$clienteIndex = -1;

foreach ($contacts as $index => $c) {
    if (isset($c['id']) && $c['id'] === $id) {
        $cliente = $c;
        $clienteIndex = $index;
        break;
    }
}

if (!$cliente) { 
    header('Location: index.php'); 
    exit; 
}

// Preparar historial de notas
$historial = $cliente['historial_notas'] ?? [];
if (empty($historial) && !empty($cliente['notas'])) {
    $historial[] = ['fecha' => 'Nota anterior', 'texto' => $cliente['notas']];
}

// Etiquetas predefinidas
$etiquetasDisponibles = ['Urgente', 'VIP', 'Seguimiento', 'Presupuesto', 'Cerrado', 'Referido'];
$etiquetasCliente = $cliente['etiquetas'] ?? [];

// Recordatorios
$recordatorios = $cliente['recordatorios'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($cliente['nombre']); ?> - Ficha Cliente</title>
    
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
        
        .timeline-line {
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #ea580c, #f97316);
        }
        
        .tag {
            transition: all 0.2s ease;
        }
        .tag:hover {
            transform: scale(1.05);
        }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <a href="index.php" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-900 transition-colors">
                        <i class="ph ph-arrow-left text-xl"></i>
                    </a>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-white font-bold">
                        <?php echo strtoupper(substr($cliente['nombre'], 0, 1)); ?>
                    </div>
                    <div>
                        <h1 class="font-bold text-slate-900"><?php echo htmlspecialchars($cliente['nombre']); ?></h1>
                        <p class="text-xs text-slate-500">Ficha de Cliente</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <button onclick="exportarCliente()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                        <i class="ph ph-download"></i>
                        Exportar
                    </button>
                    <button onclick="borrarCliente()" class="p-2 rounded-lg hover:bg-red-50 text-slate-500 hover:text-red-500 transition-colors" title="Eliminar">
                        <i class="ph ph-trash text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid lg:grid-cols-3 gap-6">
            
            <!-- Left Column - Info & Contact -->
            <div class="space-y-6">
                
                <!-- Contact Info -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-user-circle text-orange-500"></i>
                        Información de Contacto
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">Email</label>
                            <a href="mailto:<?php echo $cliente['email']; ?>" class="block text-blue-600 hover:underline break-all mt-1">
                                <?php echo htmlspecialchars($cliente['email'] ?? '-'); ?>
                            </a>
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">Teléfono</label>
                            <?php if(!empty($cliente['telefono'])): ?>
                                <a href="https://wa.me/549<?php echo preg_replace('/[^0-9]/', '', $cliente['telefono']); ?>" target="_blank" class="flex items-center gap-2 text-green-600 font-medium hover:underline mt-1">
                                    <i class="ph ph-whatsapp-logo text-lg"></i> 
                                    <?php echo htmlspecialchars($cliente['telefono']); ?>
                                </a>
                            <?php else: ?>
                                <span class="text-slate-500 mt-1 block">-</span>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">Origen</label>
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                <?php echo htmlspecialchars($cliente['origen'] ?? 'Web'); ?>
                            </span>
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">Registrado</label>
                            <p class="text-slate-600 mt-1">
                                <?php echo date('d/m/Y H:i', strtotime($cliente['fecha_registro'] ?? $cliente['date'] ?? 'now')); ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Etiquetas -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-tag text-purple-500"></i>
                        Etiquetas
                    </h3>
                    
                    <div id="etiquetasContainer" class="flex flex-wrap gap-2 mb-4">
                        <?php foreach ($etiquetasCliente as $tag): ?>
                        <span class="tag px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 flex items-center gap-1">
                            <?php echo $tag; ?>
                            <button onclick="eliminarEtiqueta('<?php echo $tag; ?>')" class="hover:text-red-500">
                                <i class="ph ph-x"></i>
                            </button>
                        </span>
                        <?php endforeach; ?>
                        <?php if (empty($etiquetasCliente)): ?>
                        <span class="text-slate-400 text-sm">Sin etiquetas</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex gap-2">
                        <select id="nuevaEtiqueta" class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                            <option value="">Agregar etiqueta...</option>
                            <?php foreach ($etiquetasDisponibles as $tag): 
                                if (!in_array($tag, $etiquetasCliente)): 
                            ?>
                            <option value="<?php echo $tag; ?>"><?php echo $tag; ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                        <button onclick="agregarEtiqueta()" class="px-4 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-colors">
                            <i class="ph ph-plus"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Recordatorios -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-bell text-yellow-500"></i>
                        Recordatorios
                    </h3>
                    
                    <div id="recordatoriosList" class="space-y-2 mb-4 max-h-48 overflow-y-auto">
                        <?php foreach ($recordatorios as $rec): ?>
                        <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl">
                            <i class="ph ph-clock text-slate-400"></i>
                            <div class="flex-1">
                                <p class="text-sm text-slate-700"><?php echo htmlspecialchars($rec['texto']); ?></p>
                                <p class="text-xs text-slate-400"><?php echo date('d/m/Y H:i', strtotime($rec['fecha'])); ?></p>
                            </div>
                            <button onclick="eliminarRecordatorio('<?php echo $rec['id']; ?>')" class="text-slate-400 hover:text-red-500">
                                <i class="ph ph-x"></i>
                            </button>
                        </div>
                        <?php endforeach; ?>
                        <?php if (empty($recordatorios)): ?>
                        <p class="text-slate-400 text-sm text-center py-4">Sin recordatorios</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="space-y-2">
                        <input type="text" id="recordatorioTexto" placeholder="Nuevo recordatorio..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                        <div class="flex gap-2">
                            <input type="datetime-local" id="recordatorioFecha" class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                            <button onclick="agregarRecordatorio()" class="px-4 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-colors">
                                <i class="ph ph-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Mensaje Inicial -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-chat-text text-blue-500"></i>
                        Mensaje Inicial
                    </h3>
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-slate-600 text-sm italic">
                            "<?php echo nl2br(htmlspecialchars($cliente['mensaje'] ?? 'Sin mensaje')); ?>"
                        </p>
                    </div>
                    <?php if(isset($cliente['estructura'])): ?>
                    <div class="mt-4 pt-4 border-t border-slate-100 text-sm space-y-1">
                        <p><span class="text-slate-400">Ref:</span> <?php echo htmlspecialchars($cliente['ref_proyecto'] ?? '-'); ?></p>
                        <p><span class="text-slate-400">Tipo:</span> <?php echo htmlspecialchars($cliente['estructura'] ?? '-'); ?></p>
                        <p><span class="text-slate-400">Zona:</span> <?php echo htmlspecialchars($cliente['zona'] ?? '-'); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Right Column - Estado & Notas -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Estado & Pago -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ph ph-gear text-slate-500"></i>
                        Gestión del Cliente
                    </h3>
                    
                    <form id="formGestion" class="grid md:grid-cols-2 gap-4">
                        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Estado</label>
                            <select name="estado" onchange="autoSave()" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none cursor-pointer">
                                <?php $st = $cliente['estado'] ?? 'Nuevo'; ?>
                                <option value="Nuevo" <?php echo $st=='Nuevo'?'selected':''; ?>>✨ Nuevo</option>
                                <option value="Contactado" <?php echo $st=='Contactado'?'selected':''; ?>>📞 Contactado</option>
                                <option value="Presupuestado" <?php echo $st=='Presupuestado'?'selected':''; ?>>📄 Presupuesto</option>
                                <option value="En Negociación" <?php echo $st=='En Negociación'?'selected':''; ?>>🤝 En Negociación</option>
                                <option value="Ganado" <?php echo $st=='Ganado'?'selected':''; ?>>✅ Venta Cerrada</option>
                                <option value="Perdido" <?php echo $st=='Perdido'?'selected':''; ?>>❌ Perdido</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pago</label>
                            <select name="pago" onchange="autoSave()" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none cursor-pointer">
                                <?php $pg = $cliente['pago'] ?? 'N/A'; ?>
                                <option value="N/A" <?php echo $pg=='N/A'?'selected':''; ?>>N/A</option>
                                <option value="Pendiente" <?php echo $pg=='Pendiente'?'selected':''; ?>>⏳ Pendiente</option>
                                <option value="Seña" <?php echo $pg=='Seña'?'selected':''; ?>>💳 Seña</option>
                                <option value="Total" <?php echo $pg=='Total'?'selected':''; ?>>💰 Pagado</option>
                            </select>
                        </div>
                    </form>
                    
                    <div class="mt-4 flex justify-between items-center border-t border-slate-100 pt-4">
                        <span id="saveStatus" class="text-sm font-medium text-green-600 flex items-center gap-2 opacity-0 transition-opacity">
                            <i class="ph ph-check-circle text-lg"></i> Guardado automáticamente
                        </span>
                        <button type="button" onclick="submitForm(false)" class="px-6 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-colors text-sm font-medium flex items-center gap-2">
                            <i class="ph ph-floppy-disk"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </div>
                
                <!-- Timeline de Notas -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900 flex items-center gap-2">
                            <i class="ph ph-notepad text-orange-500"></i>
                            Historial de Notas
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <!-- Nueva Nota -->
                        <div class="flex gap-3 mb-8">
                            <input type="text" name="nueva_nota" id="inputNota" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none" placeholder="Escribí una nueva observación..." autocomplete="off">
                            <button type="submit" onclick="document.getElementById('formGestion').dispatchEvent(new Event('submit'))" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:shadow-lg transition-all">
                                <i class="ph ph-paper-plane-right text-xl"></i>
                            </button>
                        </div>
                        
                        <!-- Timeline -->
                        <div class="relative">
                            <div class="timeline-line"></div>
                            <div class="space-y-6">
                                <?php if(empty($historial)): ?>
                                <p class="text-center text-slate-400 py-8">No hay notas registradas.</p>
                                <?php else: ?>
                                <?php foreach($historial as $nota): ?>
                                <div class="relative pl-10">
                                    <div class="absolute left-0 top-1 w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center border-4 border-white">
                                        <i class="ph ph-note text-orange-500"></i>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-xl">
                                        <p class="text-slate-700"><?php echo nl2br(htmlspecialchars($nota['texto'])); ?></p>
                                        <p class="text-xs text-slate-400 mt-2">
                                            <?php 
                                                $fecha = $nota['fecha'];
                                                echo (strtotime($fecha) ? date('d/m/Y H:i', strtotime($fecha)) : $fecha); 
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('formGestion');
        const statusLabel = document.getElementById('saveStatus');
        const clienteId = '<?php echo $cliente['id']; ?>';

        // Auto-save
        function autoSave() {
            submitForm(false);
        }

        // Submit form
        async function submitForm(isNote = false) {
            const formData = new FormData(form);
            formData.append('accion', 'actualizar');
            
            if (isNote) {
                const nota = document.getElementById('inputNota').value.trim();
                if (nota) {
                    formData.append('nueva_nota', nota);
                }
            }

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                
                if (data.success) {
                    if (isNote) {
                        document.getElementById('inputNota').value = '';
                        window.location.reload();
                    } else {
                        showSavedFeedback();
                    }
                } else {
                    alert('Error: ' + data.error);
                }
            } catch (err) {
                console.error(err);
            }
        }

        // Show saved feedback
        function showSavedFeedback() {
            statusLabel.classList.remove('opacity-0');
            setTimeout(() => {
                statusLabel.classList.add('opacity-0');
            }, 2000);
        }

        // Form submit handler
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const nota = document.getElementById('inputNota').value.trim();
            submitForm(nota !== '');
        });

        // Delete client
        async function borrarCliente() {
            if(!confirm('¿Eliminar cliente permanentemente?')) return;
            const formData = new FormData();
            formData.append('accion', 'eliminar');
            formData.append('id', clienteId);
            await fetch('guardar_cliente.php', { method: 'POST', body: formData });
            window.location.href = 'index.php';
        }

        // Export client
        function exportarCliente() {
            const data = <?php echo json_encode($cliente); ?>;
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `cliente_${data.nombre.replace(/\s+/g, '_')}.json`;
            a.click();
            URL.revokeObjectURL(url);
        }

        // Agregar etiqueta
        async function agregarEtiqueta() {
            const select = document.getElementById('nuevaEtiqueta');
            const etiqueta = select.value;
            if (!etiqueta) return;

            const formData = new FormData();
            formData.append('accion', 'agregar_etiqueta');
            formData.append('id', clienteId);
            formData.append('etiqueta', etiqueta);

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) window.location.reload();
            } catch (err) {
                console.error(err);
            }
        }

        // Eliminar etiqueta
        async function eliminarEtiqueta(etiqueta) {
            const formData = new FormData();
            formData.append('accion', 'eliminar_etiqueta');
            formData.append('id', clienteId);
            formData.append('etiqueta', etiqueta);

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) window.location.reload();
            } catch (err) {
                console.error(err);
            }
        }

        // Agregar recordatorio
        async function agregarRecordatorio() {
            const texto = document.getElementById('recordatorioTexto').value.trim();
            const fecha = document.getElementById('recordatorioFecha').value;
            
            if (!texto || !fecha) return;

            const formData = new FormData();
            formData.append('accion', 'agregar_recordatorio');
            formData.append('id', clienteId);
            formData.append('texto', texto);
            formData.append('fecha', fecha);

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) window.location.reload();
            } catch (err) {
                console.error(err);
            }
        }

        // Eliminar recordatorio
        async function eliminarRecordatorio(id) {
            const formData = new FormData();
            formData.append('accion', 'eliminar_recordatorio');
            formData.append('id', clienteId);
            formData.append('recordatorio_id', id);

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) window.location.reload();
            } catch (err) {
                console.error(err);
            }
        }
    </script>
</body>
</html>
