<?php
// admin/login.php - VERSIÓN PREMIUM 2025
require_once '../auth.php';

if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (tryLogin($_POST['user'] ?? '', $_POST['pass'] ?? '')) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Del Sur</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
        
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #1e293b);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .glass-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.2);
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
        }
    </style>
</head>
<body class="animated-bg h-screen flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Orbs -->
    <div class="orb w-96 h-96 bg-orange-500 -top-20 -right-20"></div>
    <div class="orb w-80 h-80 bg-blue-500 -bottom-20 -left-20"></div>
    
    <!-- Login Card -->
    <div class="glass-card p-8 md:p-10 rounded-3xl shadow-2xl w-full max-w-md mx-4 relative z-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-orange-500/30">
                <i class="ph ph-lock-key text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Del Sur <span class="text-orange-500">Admin</span></h1>
            <p class="text-slate-400 text-sm mt-1">Panel de Control</p>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-sm p-4 rounded-xl mb-6 flex items-center gap-2 <?php echo $error ? 'shake' : ''; ?>">
                <i class="ph ph-warning-circle text-lg"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-5">
            <div class="relative">
                <i class="ph ph-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input 
                    type="text" 
                    name="user" 
                    class="w-full bg-slate-900/50 border border-slate-700 rounded-xl pl-12 pr-4 py-4 text-white focus:border-orange-500 focus:outline-none input-focus transition-all"
                    placeholder="Usuario"
                    required 
                    autofocus
                >
            </div>
            
            <div class="relative">
                <i class="ph ph-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input 
                    type="password" 
                    name="pass" 
                    class="w-full bg-slate-900/50 border border-slate-700 rounded-xl pl-12 pr-4 py-4 text-white focus:border-orange-500 focus:outline-none input-focus transition-all"
                    placeholder="Contraseña"
                    required
                >
            </div>
            
            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-orange-500/30 flex items-center justify-center gap-2"
            >
                <i class="ph ph-sign-in text-xl"></i>
                Ingresar
            </button>
        </form>
        
        <a href="../index.php" class="block text-center text-slate-500 text-sm mt-6 hover:text-white transition-colors flex items-center justify-center gap-2">
            <i class="ph ph-arrow-left"></i>
            Volver a la web
        </a>
    </div>
    
    <!-- Footer -->
    <div class="absolute bottom-6 left-0 right-0 text-center">
        <p class="text-slate-600 text-xs">© 2025 Del Sur Construcciones. Todos los derechos reservados.</p>
    </div>
</body>
</html>
