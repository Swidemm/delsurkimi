<?php
// planificador.php - Acceso Clientes - VERSIÓN PREMIUM 2025
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Acceso Clientes — Del Sur Construcciones</title>
  <meta name="robots" content="noindex" />
  <meta name="theme-color" content="#0f172a" />
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            delsur: {
              900: '#0f172a',
              800: '#1e293b',
              accent: '#ea580c',
              'accent-light': '#f97316',
            }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            display: ['Montserrat', 'system-ui', 'sans-serif'],
          }
        }
      }
    }
  </script>
  
  <link rel="stylesheet" href="./css/styles.css" />
  
  <style>
    /* Animated Background */
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
    
    /* Floating Orbs */
    .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(100px);
      opacity: 0.3;
      animation: orb-float 20s ease-in-out infinite;
    }
    
    .orb-1 {
      width: 400px;
      height: 400px;
      background: linear-gradient(135deg, #ea580c, #f97316);
      top: -100px;
      right: -100px;
    }
    
    .orb-2 {
      width: 300px;
      height: 300px;
      background: linear-gradient(135deg, #3b82f6, #60a5fa);
      bottom: -50px;
      left: -50px;
      animation-delay: -10s;
    }
    
    @keyframes orb-float {
      0%, 100% { transform: translate(0, 0) scale(1); }
      33% { transform: translate(30px, -30px) scale(1.1); }
      66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    
    /* Glass Card */
    .glass-card {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Input Focus Animation */
    .input-group {
      position: relative;
    }
    
    .input-group input {
      transition: all 0.3s ease;
    }
    
    .input-group input:focus {
      box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.2);
    }
    
    .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      transition: color 0.3s ease;
    }
    
    .input-group input:focus + .input-icon {
      color: #ea580c;
    }
    
    /* Shake Animation for Error */
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
      20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .shake {
      animation: shake 0.5s ease-in-out;
    }
    
    /* Success Check Animation */
    @keyframes check-scale {
      0% { transform: scale(0); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }
    
    .check-animation {
      animation: check-scale 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
    }
    
    /* App Container Transition */
    #appContainer {
      transition: opacity 0.5s ease;
    }
    
    /* Pattern Overlay */
    .pattern-overlay {
      background-image: 
        linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
      background-size: 50px 50px;
    }
  </style>
</head>

<body class="animated-bg text-white font-sans min-h-screen flex items-center justify-center relative overflow-hidden">

  <!-- Preloader -->
  <div id="preloader" class="fixed inset-0 z-[100] bg-delsur-900 flex items-center justify-center">
    <div class="preloader-content">
      <img src="./imagenes/logo.webp" alt="Del Sur" class="h-20 w-auto animate-pulse brightness-0 invert" />
      <div class="preloader-bar">
        <div class="preloader-progress"></div>
      </div>
      <p class="text-xs text-slate-500 font-medium tracking-widest uppercase mt-4">Iniciando Sistema</p>
    </div>
  </div>

  <!-- Background Elements -->
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="absolute inset-0 pattern-overlay"></div>

  <!-- Login Screen -->
  <div id="loginScreen" class="relative z-10 w-full max-w-md p-4">
    <div class="glass-card rounded-3xl p-8 md:p-10 shadow-2xl">
      
      <!-- Logo -->
      <div class="text-center mb-8">
        <img src="./imagenes/logo.webp" alt="Del Sur" class="h-16 w-auto mx-auto mb-4 brightness-0 invert" />
        <h1 class="text-2xl font-display font-bold mb-2">Planificador Studio 2D</h1>
        <p class="text-slate-400 text-sm">Área exclusiva para clientes con Pack Premium</p>
      </div>

      <!-- Login Form -->
      <form id="loginForm" class="space-y-5">
        <div class="input-group">
          <input 
            type="password" 
            id="accessCode" 
            placeholder="Ingresá tu Clave de Acceso" 
            class="w-full bg-slate-800/50 border border-slate-700 rounded-xl pl-12 pr-4 py-4 text-white text-center text-lg tracking-widest focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none transition-all placeholder:text-slate-600 placeholder:tracking-normal placeholder:text-sm"
            autocomplete="off"
          >
          <i class="ph ph-lock-key input-icon text-xl"></i>
        </div>
        
        <button 
          type="submit" 
          class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl transition-all hover:shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 btn-shine"
        >
          <i class="ph ph-sign-in text-xl"></i>
          INGRESAR AL SISTEMA
        </button>
        
        <p id="errorMsg" class="text-red-400 text-sm text-center h-5 opacity-0 transition-opacity"></p>
      </form>

      <!-- Divider -->
      <div class="flex items-center gap-4 my-6">
        <div class="flex-1 h-px bg-slate-700"></div>
        <span class="text-slate-500 text-xs">o</span>
        <div class="flex-1 h-px bg-slate-700"></div>
      </div>

      <!-- Links -->
      <div class="text-center space-y-3">
        <p class="text-slate-500 text-sm">¿No tenés clave?</p>
        <a href="pagos.php" class="inline-flex items-center gap-2 text-orange-400 font-semibold hover:text-orange-300 transition-colors">
          <i class="ph ph-crown"></i>
          Adquirir Pack Premium
        </a>
      </div>

      <div class="mt-6 pt-6 border-t border-slate-700/50 text-center">
        <a href="index.php" class="text-slate-500 text-sm hover:text-white transition-colors inline-flex items-center gap-2">
          <i class="ph ph-arrow-left"></i>
          Volver al inicio
        </a>
      </div>
    </div>

    <!-- Security Badge -->
    <div class="mt-6 flex items-center justify-center gap-2 text-slate-500 text-xs">
      <i class="ph ph-shield-check text-green-500"></i>
      <span>Conexión segura encriptada</span>
    </div>
  </div>

  <!-- App Container (Hidden initially) -->
  <div id="appContainer" class="fixed inset-0 z-50 bg-delsur-900 hidden opacity-0">
    <iframe src="planificador-lite.php" class="w-full h-full border-0" allowfullscreen></iframe>
    
    <!-- Exit Button -->
    <button 
      id="btnExit" 
      class="absolute bottom-6 left-6 bg-red-500/90 hover:bg-red-600 text-white px-5 py-3 rounded-xl text-sm font-bold backdrop-blur-md transition-all shadow-lg flex items-center gap-2 hover:shadow-red-500/30"
    >
      <i class="ph ph-sign-out text-lg"></i>
      Salir y Volver al Inicio
    </button>
  </div>

  <script>
    // Preloader
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.getElementById('preloader').classList.add('hidden');
      }, 2000);
    });

    // Login Logic
    const loginForm = document.getElementById('loginForm');
    const loginScreen = document.getElementById('loginScreen');
    const appContainer = document.getElementById('appContainer');
    const errorMsg = document.getElementById('errorMsg');
    const accessCode = document.getElementById('accessCode');
    
    const SECRET_CODE = 'DELSUR24';

    // Check if already logged in
    if (sessionStorage.getItem('isLogged') === 'true') {
      showApp();
    }

    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const input = accessCode.value.trim();
      
      if (input === SECRET_CODE) {
        sessionStorage.setItem('isLogged', 'true');
        showApp();
      } else {
        // Show error
        errorMsg.textContent = 'Clave incorrecta. Revisá tu comprobante.';
        errorMsg.classList.remove('opacity-0');
        
        // Shake animation
        accessCode.classList.add('shake', 'border-red-500');
        setTimeout(() => {
          accessCode.classList.remove('shake', 'border-red-500');
          errorMsg.classList.add('opacity-0');
        }, 2000);
      }
    });

    function showApp() {
      loginScreen.style.display = 'none';
      appContainer.classList.remove('hidden');
      
      // Fade in
      setTimeout(() => {
        appContainer.style.opacity = '1';
      }, 50);
    }

    // Exit Button
    document.getElementById('btnExit').addEventListener('click', () => {
      // Fade out
      appContainer.style.opacity = '0';
      
      setTimeout(() => {
        sessionStorage.removeItem('isLogged');
        window.location.href = 'index.php';
      }, 500);
    });

    // Enter key support
    accessCode.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        loginForm.dispatchEvent(new Event('submit'));
      }
    });
  </script>
</body>
</html>
