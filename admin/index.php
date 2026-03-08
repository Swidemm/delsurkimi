<?php
// admin/index.php - Dashboard Premium - VERSIÓN 2025
require_once '../auth.php';
requireLogin();

// Leer contactos
$contactsFile = '../contacts.json';
$allLeads = [];
$totalLeads = 0;

if (file_exists($contactsFile)) {
    $data = json_decode(file_get_contents($contactsFile), true);
    if (is_array($data)) {
        $allLeads = $data;
        $totalLeads = count($data);
    }
}

// Estadísticas por estado
$estados = ['Nuevo' => 0, 'Contactado' => 0, 'Presupuestado' => 0, 'En Negociación' => 0, 'Ganado' => 0, 'Perdido' => 0];
$origenes = ['Web' => 0, 'Cotizador' => 0, 'Referido' => 0, 'Otro' => 0];
$pagos = ['N/A' => 0, 'Pendiente' => 0, 'Seña' => 0, 'Total' => 0];

foreach ($allLeads as $lead) {
    $estado = $lead['estado'] ?? 'Nuevo';
    $origen = $lead['origen'] ?? 'Web';
    $pago = $lead['pago'] ?? 'N/A';
    
    if (isset($estados[$estado])) $estados[$estado]++;
    if (isset($origenes[$origen])) $origenes[$origen]++;
    if (isset($pagos[$pago])) $pagos[$pago]++;
}

// Leads recientes (últimos 10)
$recentLeads = array_slice($allLeads, 0, 10);

// Filtrar por búsqueda si existe
$search = $_GET['search'] ?? '';
$filterEstado = $_GET['estado'] ?? '';

if ($search || $filterEstado) {
    $recentLeads = array_filter($allLeads, function($lead) use ($search, $filterEstado) {
        $matchSearch = true;
        $matchEstado = true;
        
        if ($search) {
            $searchLower = strtolower($search);
            $matchSearch = 
                stripos($lead['nombre'] ?? '', $searchLower) !== false ||
                stripos($lead['email'] ?? '', $searchLower) !== false ||
                stripos($lead['telefono'] ?? '', $searchLower) !== false;
        }
        
        if ($filterEstado) {
            $matchEstado = ($lead['estado'] ?? 'Nuevo') === $filterEstado;
        }
        
        return $matchSearch && $matchEstado;
    });
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Del Sur Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        delsur: {
                            900: '#0f172a',
                            800: '#1e293b',
                            accent: '#ea580c',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .pipeline-item {
            transition: all 0.2s ease;
        }
        .pipeline-item:hover {
            transform: translateX(4px);
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="ph ph-buildings text-xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-slate-900">Del Sur <span class="text-orange-500">Admin</span></h1>
                        <p class="text-xs text-slate-500">Panel de Control</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-500 hidden sm:block"><?php echo htmlspecialchars($_SESSION['admin_user'] ?? 'Admin'); ?></span>
                    <a href="../auth.php?logout=true" class="p-2 rounded-lg hover:bg-red-50 text-slate-500 hover:text-red-500 transition-colors" title="Cerrar sesión">
                        <i class="ph ph-sign-out text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="ph ph-users text-2xl text-blue-600"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Total</span>
                </div>
                <div class="text-3xl font-bold text-slate-900"><?php echo $totalLeads; ?></div>
                <p class="text-sm text-slate-500">Clientes registrados</p>
            </div>
            
            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="ph ph-check-circle text-2xl text-green-600"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Ganados</span>
                </div>
                <div class="text-3xl font-bold text-slate-900"><?php echo $estados['Ganado']; ?></div>
                <p class="text-sm text-slate-500">Ventas cerradas</p>
            </div>
            
            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="ph ph-currency-dollar text-2xl text-orange-600"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Pagos</span>
                </div>
                <div class="text-3xl font-bold text-slate-900"><?php echo $pagos['Seña'] + $pagos['Total']; ?></div>
                <p class="text-sm text-slate-500">Con pago recibido</p>
            </div>
            
            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="ph ph-trend-up text-2xl text-purple-600"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Tasa</span>
                </div>
                <div class="text-3xl font-bold text-slate-900">
                    <?php echo $totalLeads > 0 ? round(($estados['Ganado'] / $totalLeads) * 100) : 0; ?>%
                </div>
                <p class="text-sm text-slate-500">Conversión</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Charts & Pipeline -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Charts -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="ph ph-chart-pie text-orange-500"></i>
                            Por Estado
                        </h3>
                        <canvas id="estadoChart" height="200"></canvas>
                    </div>
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="ph ph-chart-bar text-blue-500"></i>
                            Por Origen
                        </h3>
                        <canvas id="origenChart" height="200"></canvas>
                    </div>
                </div>
                
                <!-- Pipeline -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900 flex items-center gap-2">
                            <i class="ph ph-funnel text-purple-500"></i>
                            Pipeline de Ventas
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <?php 
                            $pipelineColors = [
                                'Nuevo' => 'bg-blue-500',
                                'Contactado' => 'bg-yellow-500',
                                'Presupuestado' => 'bg-orange-500',
                                'En Negociación' => 'bg-purple-500',
                                'Ganado' => 'bg-green-500',
                                'Perdido' => 'bg-red-500'
                            ];
                            $maxCount = max($estados) ?: 1;
                            foreach ($estados as $estado => $count): 
                                $percentage = ($count / $maxCount) * 100;
                            ?>
                            <div class="pipeline-item">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-slate-700"><?php echo $estado; ?></span>
                                    <span class="text-sm font-bold text-slate-900"><?php echo $count; ?></span>
                                </div>
                                <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full <?php echo $pipelineColors[$estado]; ?> rounded-full transition-all duration-500" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Actions -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-900 mb-4">Acciones Rápidas</h3>
                    <div class="space-y-3">
                        <a href="proyectos.php" class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-orange-50 border border-slate-200 hover:border-orange-200 transition-all group">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition-colors">
                                <i class="ph ph-plus text-orange-600 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Nuevo Proyecto</p>
                                <p class="text-xs text-slate-500">Agregar a la galería</p>
                            </div>
                        </a>
                        
                        <a href="../index.php" target="_blank" class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 transition-all group">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                                <i class="ph ph-globe text-blue-600 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Ver Web</p>
                                <p class="text-xs text-slate-500">Abrir sitio público</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-900 mb-4">Actividad Reciente</h3>
                    <div class="space-y-4">
                        <?php 
                        $recentActivity = array_slice($allLeads, 0, 5);
                        foreach ($recentActivity as $activity): 
                            $estado = $activity['estado'] ?? 'Nuevo';
                            $estadoColors = [
                                'Nuevo' => 'bg-blue-100 text-blue-600',
                                'Contactado' => 'bg-yellow-100 text-yellow-600',
                                'Presupuestado' => 'bg-orange-100 text-orange-600',
                                'En Negociación' => 'bg-purple-100 text-purple-600',
                                'Ganado' => 'bg-green-100 text-green-600',
                                'Perdido' => 'bg-red-100 text-red-600'
                            ];
                            $colorClass = $estadoColors[$estado] ?? 'bg-slate-100 text-slate-600';
                        ?>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-sm font-bold text-slate-600">
                                <?php echo strtoupper(substr($activity['nombre'] ?? 'U', 0, 1)); ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate"><?php echo htmlspecialchars($activity['nombre'] ?? 'Usuario'); ?></p>
                                <p class="text-xs text-slate-500"><?php echo date('d/m H:i', strtotime($activity['fecha_registro'] ?? 'now')); ?></p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-bold <?php echo $colorClass;">
                                <?php echo $estado; ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Clients Table -->
        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="ph ph-users text-blue-500"></i>
                        Clientes
                    </h3>
                    
                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <form method="GET" class="flex gap-3">
                            <div class="relative">
                                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="<?php echo htmlspecialchars($search); ?>"
                                    placeholder="Buscar cliente..."
                                    class="pl-10 pr-4 py-2 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none text-sm"
                                >
                            </div>
                            
                            <select name="estado" class="px-4 py-2 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none text-sm">
                                <option value="">Todos los estados</option>
                                <?php foreach ($estados as $est => $count): ?>
                                <option value="<?php echo $est; ?>" <?php echo $filterEstado === $est ? 'selected' : ''; ?>>
                                    <?php echo $est; ?> (<?php echo $count; ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                            
                            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-colors">
                                <i class="ph ph-funnel"></i>
                            </button>
                            
                            <?php if ($search || $filterEstado): ?>
                            <a href="index.php" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors">
                                <i class="ph ph-x"></i>
                            </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Contacto</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Origen</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Pago</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Fecha</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($recentLeads)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <i class="ph ph-users text-4xl mb-2"></i>
                                <p>No se encontraron clientes</p>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($recentLeads as $lead): 
                            $estado = $lead['estado'] ?? 'Nuevo';
                            $pago = $lead['pago'] ?? 'N/A';
                            $origen = $lead['origen'] ?? 'Web';
                            
                            $estadoColors = [
                                'Nuevo' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'Contactado' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'Presupuestado' => 'bg-orange-100 text-orange-700 border-orange-200',
                                'En Negociación' => 'bg-purple-100 text-purple-700 border-purple-200',
                                'Ganado' => 'bg-green-100 text-green-700 border-green-200',
                                'Perdido' => 'bg-red-100 text-red-700 border-red-200'
                            ];
                            
                            $pagoColors = [
                                'N/A' => 'bg-slate-100 text-slate-600',
                                'Pendiente' => 'bg-yellow-100 text-yellow-700',
                                'Seña' => 'bg-blue-100 text-blue-700',
                                'Total' => 'bg-green-100 text-green-700'
                            ];
                            
                            $origenColors = [
                                'Web' => 'bg-blue-100 text-blue-700',
                                'Cotizador' => 'bg-purple-100 text-purple-700',
                                'Referido' => 'bg-green-100 text-green-700',
                                'Otro' => 'bg-slate-100 text-slate-700'
                            ];
                        ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-white font-bold">
                                        <?php echo strtoupper(substr($lead['nombre'] ?? 'U', 0, 1)); ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900"><?php echo htmlspecialchars($lead['nombre'] ?? '-'); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="text-slate-600"><?php echo htmlspecialchars($lead['email'] ?? '-'); ?></p>
                                    <?php if (!empty($lead['telefono'])): ?>
                                    <a href="https://wa.me/549<?php echo preg_replace('/[^0-9]/', '', $lead['telefono']); ?>" target="_blank" class="text-green-600 hover:underline text-xs flex items-center gap-1 mt-1">
                                        <i class="ph ph-whatsapp-logo"></i> <?php echo htmlspecialchars($lead['telefono']); ?>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo $origenColors[$origen] ?? 'bg-slate-100 text-slate-700'; ?>">
                                    <?php echo $origen; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold border <?php echo $estadoColors[$estado] ?? 'bg-slate-100 text-slate-700 border-slate-200'; ?>">
                                    <?php echo $estado; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo $pagoColors[$pago] ?? 'bg-slate-100 text-slate-600'; ?>">
                                    <?php echo $pago; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                <?php echo date('d/m/Y', strtotime($lead['fecha_registro'] ?? $lead['date'] ?? 'now')); ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="cliente.php?id=<?php echo $lead['id'] ?? ''; ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-orange-100 text-slate-600 hover:text-orange-600 rounded-lg transition-colors text-sm font-medium">
                                    <i class="ph ph-pencil-simple"></i>
                                    Gestionar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Estado Chart
        const estadoCtx = document.getElementById('estadoChart').getContext('2d');
        new Chart(estadoCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($estados)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($estados)); ?>,
                    backgroundColor: [
                        '#3b82f6', // Nuevo - Blue
                        '#eab308', // Contactado - Yellow
                        '#f97316', // Presupuestado - Orange
                        '#a855f7', // En Negociación - Purple
                        '#22c55e', // Ganado - Green
                        '#ef4444'  // Perdido - Red
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
        
        // Origen Chart
        const origenCtx = document.getElementById('origenChart').getContext('2d');
        new Chart(origenCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($origenes)); ?>,
                datasets: [{
                    label: 'Clientes',
                    data: <?php echo json_encode(array_values($origenes)); ?>,
                    backgroundColor: [
                        '#3b82f6',
                        '#a855f7',
                        '#22c55e',
                        '#64748b'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
</body>
</html>
