<?php
// index.php - Del Sur Construcciones - VERSIÓN PREMIUM 2025
$jsonFile = 'proyectos.json';
$proyectosTodo = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Filtramos solo los destacados
$proyectosHome = array_filter($proyectosTodo, function($p) {
    return isset($p['destacado']) && $p['destacado'] === true;
});

if (empty($proyectosHome)) {
    $proyectosHome = array_slice($proyectosTodo, 0, 3);
}
?>
<!DOCTYPE html>
<html lang="es-AR" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Del Sur Construcciones — Diseñamos y Construimos tu Futuro</title>
  <meta name="description" content="Empresa constructora líder en AMBA. Obras llave en mano, refacciones integrales y arquitectura comercial. Pedí tu presupuesto." />
  <meta name="theme-color" content="#0f172a" />
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">
  
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
              700: '#334155',
              accent: '#ea580c',
              'accent-light': '#f97316',
              blue: '#3b82f6',
            }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            display: ['Montserrat', 'system-ui', 'sans-serif'],
          },
          animation: {
            'float': 'float 6s ease-in-out infinite',
            'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
            'gradient': 'gradient-shift 8s ease infinite',
          }
        }
      }
    }
  </script>
  
  <link rel="stylesheet" href="./css/styles.css" />
  
  <style>
    /* Hero Background Animation */
    .hero-bg {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
      background-size: 400% 400%;
      animation: gradient-shift 15s ease infinite;
    }
    
    @keyframes gradient-shift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    /* Floating Orbs - Movimiento aleatorio lento */
    .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.5;
      transition: transform 0.1s linear;
      will-change: transform;
    }
    
    .orb-1 {
      width: 400px;
      height: 400px;
      background: linear-gradient(135deg, #ea580c, #f97316);
      top: 10%;
      right: 10%;
    }
    
    .orb-2 {
      width: 350px;
      height: 350px;
      background: linear-gradient(135deg, #3b82f6, #60a5fa);
      bottom: 15%;
      left: 5%;
    }
    
    .orb-3 {
      width: 300px;
      height: 300px;
      background: linear-gradient(135deg, #8b5cf6, #a78bfa);
      top: 50%;
      left: 30%;
    }
    
    .orb-4 {
      width: 250px;
      height: 250px;
      background: linear-gradient(135deg, #ec4899, #f472b6);
      top: 20%;
      left: 60%;
    }
    
    /* Grid Pattern Overlay */
    .grid-pattern {
      background-image: 
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 50px 50px;
    }
    
    /* Card Hover Effects */
    .service-card {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .service-card:hover {
      transform: translateY(-8px);
    }
    
    .service-card:hover .service-icon {
      transform: scale(1.1) rotate(5deg);
    }
    
    .service-icon {
      transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    /* Project Card */
    .project-card {
      overflow: hidden;
    }
    
    .project-card img {
      transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .project-card:hover img {
      transform: scale(1.1);
    }
    
    .project-overlay {
      background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.7) 50%, transparent 100%);
    }
    
    /* FAQ Accordion */
    details > summary {
      list-style: none;
    }
    
    details > summary::-webkit-details-marker {
      display: none;
    }
    
    details[open] summary ~ * {
      animation: sweep 0.3s ease-in-out;
    }
    
    @keyframes sweep {
      0%    { opacity: 0; transform: translateY(-10px); }
      100%  { opacity: 1; transform: translateY(0); }
    }
    
    /* Navbar Scroll Effect */
    .navbar-scrolled {
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(20px);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }
    
    /* Stats Counter Animation */
    .stat-number {
      background: linear-gradient(135deg, #ea580c, #f97316);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    /* Contact Form Focus */
    .form-input:focus {
      box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.15);
    }
    
    /* Button Shine Effect */
    .btn-shine {
      position: relative;
      overflow: hidden;
    }
    
    .btn-shine::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(
        to right,
        transparent 0%,
        rgba(255, 255, 255, 0.3) 50%,
        transparent 100%
      );
      transform: rotate(30deg) translateX(-100%);
      transition: transform 0.6s;
    }
    
    .btn-shine:hover::after {
      transform: rotate(30deg) translateX(100%);
    }
    
    /* Pricing Card Highlight */
    .pricing-highlight {
      position: relative;
    }
    
    .pricing-highlight::before {
      content: '';
      position: absolute;
      inset: -2px;
      background: linear-gradient(135deg, #ea580c, #f97316, #3b82f6);
      border-radius: inherit;
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s;
    }
    
    .pricing-highlight:hover::before {
      opacity: 1;
    }
  </style>
</head>

<body class="font-sans text-slate-700 bg-slate-50 antialiased">

  <!-- Preloader -->
  <div id="preloader">
    <div class="preloader-content">
      <img src="./imagenes/logo.webp" alt="Del Sur" class="h-16 w-auto animate-pulse" />
      <div class="preloader-bar">
        <div class="preloader-progress"></div>
      </div>
      <p class="text-xs text-slate-400 font-medium tracking-widest uppercase">Cargando Experiencia</p>
    </div>
  </div>

  <!-- Navigation -->
  <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 bg-white/80 backdrop-blur-md border-b border-slate-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        
        <a href="#inicio" class="flex-shrink-0 group">
          <img src="./imagenes/logo.webp" alt="Del Sur Construcciones" class="h-14 w-auto transition-transform duration-300 group-hover:scale-105" />
        </a>

        <div class="hidden lg:flex items-center space-x-1">
          <a href="#servicios" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-delsur-900 rounded-lg hover:bg-slate-100 transition-all">Servicios</a>
          <a href="proceso.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-delsur-900 rounded-lg hover:bg-slate-100 transition-all">Cómo Trabajamos</a>
          <a href="pagos.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-delsur-900 rounded-lg hover:bg-slate-100 transition-all">Precios</a>
          
          <a href="planificador.php" class="ml-4 px-4 py-2 text-sm font-semibold text-delsur-900 hover:text-delsur-accent flex items-center gap-2 rounded-lg hover:bg-slate-100 border border-transparent hover:border-slate-200 transition-all">
            <i class="ph ph-lock-key text-lg"></i>
            Acceso Clientes
          </a>

          <a href="#contacto" class="ml-4 px-6 py-2.5 rounded-xl bg-gradient-to-r from-delsur-accent to-delsur-accent-light text-white font-semibold text-sm hover:shadow-lg hover:shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 btn-shine">
            Presupuesto
          </a>
        </div>

        <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
          <i class="ph ph-list text-2xl text-slate-600"></i>
        </button>
      </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-slate-100 absolute w-full shadow-2xl">
      <div class="px-4 py-6 space-y-2">
        <a href="#servicios" class="block px-4 py-3 text-slate-600 font-medium rounded-lg hover:bg-slate-50 transition-colors">Servicios</a>
        <a href="proceso.php" class="block px-4 py-3 text-slate-600 font-medium rounded-lg hover:bg-slate-50 transition-colors">Cómo Trabajamos</a>
        <a href="pagos.php" class="block px-4 py-3 text-slate-600 font-medium rounded-lg hover:bg-slate-50 transition-colors">Planes y Precios</a>
        <a href="planificador.php" class="block px-4 py-3 text-delsur-900 font-bold rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
          <i class="ph ph-lock-key"></i> Ingresar al Planificador
        </a>
        <a href="#contacto" class="block mt-4 text-center px-4 py-3 bg-gradient-to-r from-delsur-accent to-delsur-accent-light text-white rounded-xl font-bold">Solicitar Presupuesto</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="inicio" class="relative min-h-screen flex items-center justify-center overflow-hidden hero-bg">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover opacity-40">
      <source src="./videos/hero.mp4" type="video/mp4" />
    </video>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-delsur-900/90 via-delsur-800/80 to-delsur-900/70"></div>
    
    <!-- Floating Orbs - Movimiento aleatorio con JS -->
    <div class="orb orb-1" id="orb1"></div>
    <div class="orb orb-2" id="orb2"></div>
    <div class="orb orb-3" id="orb3"></div>
    <div class="orb orb-4" id="orb4"></div>
    
    <!-- Grid Pattern -->
    <div class="absolute inset-0 grid-pattern opacity-50"></div>
    
    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        
        <!-- Left Content -->
        <div class="text-center lg:text-left">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-orange-300 text-xs font-bold tracking-widest uppercase mb-6 animate-fadeIn">
            <span class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
            Construcción & Diseño Premium
          </div>
          
          <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-6 animate-fadeInUp">
            Hacemos realidad<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-yellow-300 to-orange-400 animate-gradient">tu visión.</span>
          </h1>
          
          <p class="text-lg md:text-xl text-slate-300 mb-8 max-w-xl mx-auto lg:mx-0 font-light leading-relaxed animate-fadeInUp delay-100">
            Especialistas en obras llave en mano y arquitectura comercial en AMBA. Desde el primer boceto hasta la entrega de llaves.
          </p>
          
          <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fadeInUp delay-200">
            <a href="proyectos.php" class="px-8 py-4 rounded-xl bg-white text-delsur-900 font-bold hover:bg-slate-100 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1 flex items-center justify-center gap-2">
              <i class="ph ph-images text-xl"></i>
              Ver Galería
            </a>
            <a href="proceso.php" class="px-8 py-4 rounded-xl bg-gradient-to-r from-delsur-accent to-delsur-accent-light text-white font-bold hover:shadow-lg hover:shadow-orange-500/40 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2 btn-shine">
              <i class="ph ph-arrow-right text-xl"></i>
              ¿Cómo Trabajamos?
            </a>
          </div>

          <div class="mt-8 flex items-center justify-center lg:justify-start gap-3 text-sm animate-fadeInUp delay-300">
            <span class="text-slate-400">¿Ya tenés tu Pack Premium?</span>
            <a href="planificador.php" class="text-orange-400 font-bold hover:text-white transition-colors flex items-center gap-1 border-b border-orange-400/50 hover:border-white pb-0.5">
              <i class="ph ph-lock-key"></i>
              Ingresá al Planificador
            </a>
          </div>
        </div>
        
        <!-- Right Content - Stats Cards -->
        <div class="hidden lg:grid grid-cols-2 gap-4 animate-fadeInRight delay-300">
          <div class="glass-card p-6 rounded-2xl">
            <div class="text-4xl font-display font-bold stat-number mb-2">+10</div>
            <p class="text-slate-300 text-sm">Años de Experiencia</p>
          </div>
          <div class="glass-card p-6 rounded-2xl mt-8">
            <div class="text-4xl font-display font-bold text-gradient-blue mb-2">+50</div>
            <p class="text-slate-300 text-sm">Proyectos Entregados</p>
          </div>
          <div class="glass-card p-6 rounded-2xl">
            <div class="text-4xl font-display font-bold text-white mb-2">100%</div>
            <p class="text-slate-300 text-sm">Garantía Escrita</p>
          </div>
          <div class="glass-card p-6 rounded-2xl mt-8">
            <div class="text-4xl font-display font-bold text-gradient mb-2">24/7</div>
            <p class="text-slate-300 text-sm">Soporte al Cliente</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
      <a href="#servicios" class="flex flex-col items-center text-white/50 hover:text-white transition-colors">
        <span class="text-xs mb-2">Descubrí más</span>
        <i class="ph ph-caret-down text-2xl"></i>
      </a>
    </div>
  </section>

  <!-- Stats Bar -->
  <div class="bg-delsur-900 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="flex items-center justify-center gap-3">
          <i class="ph ph-trophy text-3xl text-orange-500"></i>
          <div>
            <div class="text-2xl font-bold text-white">+10</div>
            <div class="text-xs text-slate-400">Años Experiencia</div>
          </div>
        </div>
        <div class="flex items-center justify-center gap-3">
          <i class="ph ph-buildings text-3xl text-blue-500"></i>
          <div>
            <div class="text-2xl font-bold text-white">+50</div>
            <div class="text-xs text-slate-400">Proyectos</div>
          </div>
        </div>
        <div class="flex items-center justify-center gap-3">
          <i class="ph ph-shield-check text-3xl text-green-500"></i>
          <div>
            <div class="text-2xl font-bold text-white">100%</div>
            <div class="text-xs text-slate-400">Garantía</div>
          </div>
        </div>
        <div class="flex items-center justify-center gap-3">
          <i class="ph ph-users text-3xl text-purple-500"></i>
          <div>
            <div class="text-2xl font-bold text-white">+200</div>
            <div class="text-xs text-slate-400">Clientes</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Services Section -->
  <section id="servicios" class="py-24 bg-slate-50 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
      <div class="text-center max-w-3xl mx-auto mb-16 reveal">
        <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-600 text-xs font-bold tracking-widest uppercase mb-4">Nuestros Servicios</span>
        <h2 class="font-display text-4xl md:text-5xl font-bold text-delsur-900 mb-6">Soluciones Integrales</h2>
        <p class="text-slate-600 text-lg">No solo construimos paredes, creamos espacios funcionales donde la vida sucede. Cada proyecto es una obra de arte.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <!-- Service 1 -->
        <div class="service-card bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl border border-slate-100 reveal delay-100 group">
          <div class="service-icon w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30">
            <i class="ph ph-house-line text-3xl text-white"></i>
          </div>
          <h3 class="font-display text-xl font-bold text-delsur-900 mb-3">Viviendas Llave en Mano</h3>
          <p class="text-slate-600 leading-relaxed mb-4">Nos encargamos de todo: diseño, materiales, mano de obra y dirección. Vos solo te mudás.</p>
          <a href="#contacto" class="inline-flex items-center gap-2 text-orange-600 font-semibold text-sm hover:gap-3 transition-all">
            Consultar <i class="ph ph-arrow-right"></i>
          </a>
        </div>
        
        <!-- Service 2 -->
        <div class="service-card bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl border border-slate-100 reveal delay-200 group">
          <div class="service-icon w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/30">
            <i class="ph ph-storefront text-3xl text-white"></i>
          </div>
          <h3 class="font-display text-xl font-bold text-delsur-900 mb-3">Locales y Oficinas</h3>
          <p class="text-slate-600 leading-relaxed mb-4">Reformas comerciales rápidas y de alto impacto para potenciar tu marca y ventas.</p>
          <a href="#contacto" class="inline-flex items-center gap-2 text-orange-600 font-semibold text-sm hover:gap-3 transition-all">
            Consultar <i class="ph ph-arrow-right"></i>
          </a>
        </div>
        
        <!-- Service 3 -->
        <div class="service-card bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl border border-slate-100 reveal delay-300 group">
          <div class="service-icon w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30">
            <i class="ph ph-paint-brush text-3xl text-white"></i>
          </div>
          <h3 class="font-display text-xl font-bold text-delsur-900 mb-3">Refacciones y Diseño</h3>
          <p class="text-slate-600 leading-relaxed mb-4">Modernizamos tu casa actual. Cocinas, baños, quinchos y fachadas con diseño de vanguardia.</p>
          <a href="#contacto" class="inline-flex items-center gap-2 text-orange-600 font-semibold text-sm hover:gap-3 transition-all">
            Consultar <i class="ph ph-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Process CTA Section -->
  <section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-white"></div>
    
    <div class="max-w-5xl mx-auto px-4 text-center relative">
      <div class="reveal">
        <span class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-600 text-xs font-bold tracking-widest uppercase mb-4">Nuestro Proceso</span>
        <h2 class="font-display text-4xl md:text-5xl font-bold text-delsur-900 mb-6">Claridad ante todo</h2>
        <p class="text-slate-600 text-lg mb-10 max-w-2xl mx-auto">
          Sabemos que una obra puede generar incertidumbre. Por eso, diseñamos un método transparente de 5 pasos para que sepas qué pasa en cada momento.
        </p>
        
        <a href="proceso.php" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-delsur-900 font-bold rounded-2xl shadow-xl hover:shadow-2xl border border-slate-200 hover:border-orange-300 transition-all transform hover:-translate-y-1 group">
          Ver el paso a paso interactivo
          <i class="ph ph-arrow-right text-xl transition-transform group-hover:translate-x-1"></i>
        </a>
        
        <!-- Process Steps Preview -->
        <div class="mt-16 flex justify-center gap-4 md:gap-8">
          <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mb-2">
              <span class="text-orange-600 font-bold">1</span>
            </div>
            <span class="text-xs text-slate-500">Consulta</span>
          </div>
          <div class="w-8 h-px bg-slate-300 mt-6"></div>
          <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mb-2">
              <span class="text-orange-600 font-bold">2</span>
            </div>
            <span class="text-xs text-slate-500">Diseño</span>
          </div>
          <div class="w-8 h-px bg-slate-300 mt-6"></div>
          <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mb-2">
              <span class="text-orange-600 font-bold">3</span>
            </div>
            <span class="text-xs text-slate-500">Presupuesto</span>
          </div>
          <div class="w-8 h-px bg-slate-300 mt-6"></div>
          <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mb-2">
              <span class="text-orange-600 font-bold">4</span>
            </div>
            <span class="text-xs text-slate-500">Construcción</span>
          </div>
          <div class="w-8 h-px bg-slate-300 mt-6"></div>
          <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mb-2">
              <span class="text-orange-600 font-bold">5</span>
            </div>
            <span class="text-xs text-slate-500">Entrega</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing Section -->
  <section class="py-24 bg-gradient-to-br from-delsur-900 via-delsur-800 to-delsur-900 text-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 pattern-dots opacity-10"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/20 rounded-full blur-[120px]"></div>
    
    <div class="max-w-6xl mx-auto px-4 relative">
      <div class="text-center max-w-3xl mx-auto mb-16 reveal">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-orange-300 text-xs font-bold uppercase tracking-wider mb-4">
          <i class="ph ph-crown"></i> Comenzá con el pie derecho
        </span>
        <h2 class="font-display text-4xl md:text-5xl font-bold mb-6">Asesoría Profesional</h2>
        <p class="text-slate-300 text-lg">
          Antes de iniciar la obra, despejá todas tus dudas con un experto. Elegí el plan que mejor se adapte a tus necesidades.
        </p>
      </div>

      <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <!-- Plan Básico -->
        <div class="glass-card p-8 rounded-3xl border-t border-white/10 reveal delay-100 hover:bg-white/10 transition-all">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center">
              <i class="ph ph-chat-circle-text text-xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-300">Asesoría General</h3>
          </div>
          
          <div class="flex items-baseline gap-2 mb-6">
            <span class="text-5xl font-display font-bold text-white">$3.500</span>
            <span class="text-slate-400">/ única vez</span>
          </div>
          
          <p class="text-sm text-slate-400 mb-8">Ideal para consultas puntuales, viabilidad de terreno y estimación de costos.</p>
          
          <ul class="space-y-4 mb-8">
            <li class="flex items-center gap-3 text-slate-300">
              <i class="ph ph-check-circle text-green-400 text-xl"></i>
              <span>Reunión técnica 1 a 1</span>
            </li>
            <li class="flex items-center gap-3 text-slate-300">
              <i class="ph ph-check-circle text-green-400 text-xl"></i>
              <span>Presupuesto estimado de obra</span>
            </li>
            <li class="flex items-center gap-3 text-slate-500">
              <i class="ph ph-x-circle text-slate-600 text-xl"></i>
              <span class="line-through">Licencia de Software 2D</span>
            </li>
          </ul>
          
          <a href="pagos.php" class="block w-full py-4 rounded-xl border-2 border-white/20 text-center font-bold hover:bg-white hover:text-delsur-900 transition-all">
            Ver detalle
          </a>
        </div>
        
        <!-- Plan Premium -->
        <div class="glass-card p-8 rounded-3xl border-2 border-orange-500/50 bg-gradient-to-br from-orange-500/10 to-transparent reveal delay-200 relative transform hover:-translate-y-2 transition-all">
          <div class="absolute -top-4 left-1/2 -translate-x-1/2">
            <span class="px-4 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-bold rounded-full shadow-lg shadow-orange-500/30">
              <i class="ph ph-star-fill mr-1"></i> RECOMENDADO
            </span>
          </div>
          
          <div class="flex items-center gap-3 mb-4 mt-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
              <i class="ph ph-crown text-xl text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-orange-300">Pack Premium</h3>
          </div>
          
          <div class="flex items-baseline gap-2 mb-6">
            <span class="text-5xl font-display font-bold text-white">$4.500</span>
            <span class="text-slate-400">/ única vez</span>
          </div>
          
          <p class="text-sm text-slate-300 mb-8">La experiencia completa. Diseñá tu casa con nuestra herramienta exclusiva y recibí asesoramiento prioritario.</p>
          
          <ul class="space-y-4 mb-8">
            <li class="flex items-center gap-3 text-white">
              <i class="ph ph-check-circle text-orange-400 text-xl"></i>
              <span>Todo lo incluido en Asesoría</span>
            </li>
            <li class="flex items-center gap-3 text-white">
              <i class="ph ph-check-circle text-orange-400 text-xl"></i>
              <span class="font-bold">Licencia Planificador 2D</span>
            </li>
            <li class="flex items-center gap-3 text-white">
              <i class="ph ph-check-circle text-orange-400 text-xl"></i>
              <span>Prioridad en agenda</span>
            </li>
          </ul>
          
          <a href="pagos.php" class="block w-full py-4 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center font-bold hover:shadow-lg hover:shadow-orange-500/40 transition-all animate-pulse-glow">
            CONTRATAR PACK
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Projects Section -->
  <section id="proyectos" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 reveal">
        <div>
          <span class="inline-block px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold tracking-widest uppercase mb-4">Portfolio</span>
          <h2 class="font-display text-4xl md:text-5xl font-bold text-delsur-900">Nuestros Proyectos</h2>
          <p class="text-slate-500 mt-2 text-lg">La mejor carta de presentación es nuestra obra terminada.</p>
        </div>
        <a href="proyectos.php" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-slate-100 text-delsur-900 font-semibold rounded-xl hover:bg-slate-200 transition-all">
          Ver todos los proyectos <i class="ph ph-arrow-right"></i>
        </a>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <?php foreach($proyectosHome as $index => $ph): 
            $imgHome = is_array($ph['imagenes']) ? $ph['imagenes'][0] : $ph['imagenes'];
            $delay = ($index + 1) * 100;
        ?>
        <div class="project-card group rounded-3xl overflow-hidden cursor-pointer reveal shadow-lg hover:shadow-2xl transition-all" style="animation-delay: <?php echo $delay; ?>ms">
          <div class="relative h-80 overflow-hidden">
            <img src="./<?php echo htmlspecialchars($imgHome); ?>" alt="<?php echo htmlspecialchars($ph['titulo']); ?>" class="w-full h-full object-cover" />
            <div class="project-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
              <span class="text-orange-400 text-xs font-bold uppercase tracking-wider mb-2"><?php echo htmlspecialchars($ph['categoria']); ?></span>
              <h3 class="text-xl font-bold text-white mb-1"><?php echo htmlspecialchars($ph['titulo']); ?></h3>
              <p class="text-slate-300 text-sm"><?php echo htmlspecialchars($ph['medidas']); ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-24 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4">
      <div class="text-center mb-12 reveal">
        <span class="inline-block px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold tracking-widest uppercase mb-4">FAQ</span>
        <h2 class="font-display text-4xl font-bold text-delsur-900">Preguntas Frecuentes</h2>
      </div>
      
      <div class="space-y-4 reveal">
        <details class="group bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
          <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 hover:text-delsur-900 select-none">
            <span class="flex items-center gap-3">
              <i class="ph ph-question text-orange-500 text-xl"></i>
              ¿Cuánto tiempo demora una obra promedio?
            </span>
            <i class="ph ph-caret-down text-slate-400 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <div class="px-6 pb-6 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
            El tiempo depende de la complejidad. Una refacción de baño puede tomar 2-3 semanas, mientras que una vivienda llave en mano oscila entre 8 y 12 meses.
          </div>
        </details>
        
        <details class="group bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
          <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 hover:text-delsur-900 select-none">
            <span class="flex items-center gap-3">
              <i class="ph ph-question text-orange-500 text-xl"></i>
              ¿Qué incluye el servicio "Llave en Mano"?
            </span>
            <i class="ph ph-caret-down text-slate-400 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <div class="px-6 pb-6 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
            Incluye absolutamente todo: diseño, trámites municipales, materiales, dirección de obra y mano de obra completa. Te entregamos la casa limpia y lista para habitar.
          </div>
        </details>
        
        <details class="group bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
          <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 hover:text-delsur-900 select-none">
            <span class="flex items-center gap-3">
              <i class="ph ph-question text-orange-500 text-xl"></i>
              ¿Trabajan en toda el área de AMBA?
            </span>
            <i class="ph ph-caret-down text-slate-400 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <div class="px-6 pb-6 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
            Sí, realizamos obras en toda el Área Metropolitana de Buenos Aires y alrededores. Consultanos por tu zona específica.
          </div>
        </details>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contacto" class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
      <div class="grid lg:grid-cols-2 gap-12 items-start">
        
        <!-- Left - Contact Info -->
        <div class="reveal">
          <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-600 text-xs font-bold tracking-widest uppercase mb-4">Contacto</span>
          <h2 class="font-display text-4xl md:text-5xl font-bold text-delsur-900 mb-6">Hablemos de tu Proyecto</h2>
          <p class="text-slate-600 text-lg mb-10">Estamos listos para asesorarte. Completá el formulario o contactanos directamente.</p>
          
          <div class="space-y-6">
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 transition-colors">
              <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/30 shrink-0">
                <i class="ph ph-whatsapp-logo text-2xl text-white"></i>
              </div>
              <div>
                <h4 class="font-bold text-delsur-900 mb-1">WhatsApp</h4>
                <p class="text-slate-600 mb-2">+54 9 11 6704-0733</p>
                <a href="https://wa.me/5491167040733" target="_blank" class="text-green-600 font-semibold text-sm hover:underline inline-flex items-center gap-1">
                  Enviar mensaje <i class="ph ph-arrow-right"></i>
                </a>
              </div>
            </div>
            
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 transition-colors">
              <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 shrink-0">
                <i class="ph ph-envelope text-2xl text-white"></i>
              </div>
              <div>
                <h4 class="font-bold text-delsur-900 mb-1">Email</h4>
                <p class="text-slate-600">delsur.constr@gmail.com</p>
              </div>
            </div>
            
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 transition-colors">
              <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30 shrink-0">
                <i class="ph ph-clock text-2xl text-white"></i>
              </div>
              <div>
                <h4 class="font-bold text-delsur-900 mb-1">Horario de Atención</h4>
                <p class="text-slate-600">Lun - Vie: 9:00 - 18:00</p>
                <p class="text-slate-600">Sáb: 9:00 - 13:00</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Right - Contact Form -->
        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-2xl border border-slate-100 reveal delay-100">
          <form id="contactForm" class="space-y-5">
            <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
            
            <div class="grid md:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-2" for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required class="form-input w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" placeholder="Tu nombre" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-2" for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" required class="form-input w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" placeholder="11 1234 5678" />
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2" for="email">Email</label>
              <input type="email" id="email" name="email" required class="form-input w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all" placeholder="tu@email.com" />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2" for="mensaje">¿En qué podemos ayudarte?</label>
              <textarea id="mensaje" name="mensaje" rows="4" required class="form-input w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all resize-none" placeholder="Contanos brevemente sobre tu proyecto..."></textarea>
            </div>
            
            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-delsur-900 to-delsur-800 py-4 text-white font-bold text-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 btn-shine">
              <i class="ph ph-paper-plane-right text-xl"></i>
              Enviar Mensaje
            </button>
            
            <p id="formMessage" class="text-center text-sm font-medium mt-2 min-h-[20px]"></p>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-delsur-900 text-slate-400 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-16">
      <div class="grid md:grid-cols-4 gap-8 mb-12">
        <div class="md:col-span-2">
          <img src="./imagenes/logo.webp" alt="Del Sur Construcciones" class="h-12 w-auto mb-4 opacity-90" />
          <p class="max-w-sm text-slate-500 mb-6">Compromiso, calidad y diseño en cada metro cuadrado. Construyendo sueños desde 2014.</p>
          <div class="flex gap-4">
            <a href="https://wa.me/5491167040733" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-green-600 hover:text-white transition-all">
              <i class="ph ph-whatsapp-logo text-xl"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
              <i class="ph ph-facebook-logo text-xl"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all">
              <i class="ph ph-instagram-logo text-xl"></i>
            </a>
          </div>
        </div>
        
        <div>
          <h3 class="font-bold text-white mb-4 uppercase tracking-wider text-xs">Navegación</h3>
          <ul class="space-y-3">
            <li><a href="#servicios" class="hover:text-orange-400 transition-colors">Servicios</a></li>
            <li><a href="proyectos.php" class="hover:text-orange-400 transition-colors">Proyectos</a></li>
            <li><a href="proceso.php" class="hover:text-orange-400 transition-colors">Cómo Trabajamos</a></li>
            <li><a href="pagos.php" class="hover:text-orange-400 transition-colors">Medios de Pago</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="font-bold text-white mb-4 uppercase tracking-wider text-xs">Legal</h3>
          <ul class="space-y-3">
            <li><a href="legales.php#terminos" class="hover:text-white transition-colors">Términos y condiciones</a></li>
            <li><a href="legales.php#privacidad" class="hover:text-white transition-colors">Política de privacidad</a></li>
          </ul>
        </div>
      </div>
      
      <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-sm">© <span id="year"></span> Del Sur Construcciones. Todos los derechos reservados.</p>
        <a href="admin/login.php" class="text-xs text-slate-600 hover:text-slate-400 transition-colors flex items-center gap-1">
          <i class="ph ph-lock-key"></i> Acceso Admin
        </a>
      </div>
    </div>
  </footer>

  <script>
    // Year
    document.getElementById('year').textContent = new Date().getFullYear();

    // Preloader
    window.addEventListener('load', () => {
      setTimeout(() => {
        const preloader = document.getElementById('preloader');
        preloader.classList.add('hidden');
      }, 1500);
    });

    // Navbar Scroll Effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
      } else {
        navbar.classList.remove('navbar-scrolled');
      }
    });

    // Mobile Menu
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Reveal on Scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
        }
      });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Contact Form
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');
    
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      formMessage.textContent = 'Enviando...';
      formMessage.className = 'text-center text-sm font-medium mt-2 text-slate-500';
      
      const formData = new FormData(contactForm);
      const payload = {
        nombre: formData.get('nombre'),
        email: formData.get('email'),
        telefono: formData.get('telefono'),
        mensaje: formData.get('mensaje'),
        honeypot: formData.get('honeypot')
      };

      try {
        const res = await fetch('api/contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload),
        });
        if (res.ok) {
          formMessage.textContent = '¡Mensaje enviado con éxito!';
          formMessage.className = 'text-center text-sm font-bold mt-2 text-green-600';
          contactForm.reset();
        } else {
          throw new Error('Error al enviar');
        }
      } catch (err) {
        formMessage.textContent = 'Hubo un error. Por favor escribinos por WhatsApp.';
        formMessage.className = 'text-center text-sm font-bold mt-2 text-red-500';
      }
    });

    // Smooth Scroll for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // ORBES - Movimiento aleatorio lento
    (function() {
      const orbs = [
        { el: document.getElementById('orb1'), x: 0, y: 0, vx: 0.3, vy: 0.2 },
        { el: document.getElementById('orb2'), x: 0, y: 0, vx: -0.25, vy: 0.35 },
        { el: document.getElementById('orb3'), x: 0, y: 0, vx: 0.2, vy: -0.3 },
        { el: document.getElementById('orb4'), x: 0, y: 0, vx: -0.15, vy: -0.2 }
      ];

      function animateOrbs() {
        orbs.forEach(orb => {
          // Actualizar posición
          orb.x += orb.vx;
          orb.y += orb.vy;

          // Cambiar dirección aleatoriamente cada cierto tiempo
          if (Math.random() < 0.01) {
            orb.vx = (Math.random() - 0.5) * 0.6;
            orb.vy = (Math.random() - 0.5) * 0.6;
          }

          // Limitar el movimiento para que no se vayan muy lejos
          const maxOffset = 100;
          if (Math.abs(orb.x) > maxOffset) orb.vx *= -1;
          if (Math.abs(orb.y) > maxOffset) orb.vy *= -1;

          // Aplicar transformación
          orb.el.style.transform = `translate(${orb.x}px, ${orb.y}px)`;
        });

        requestAnimationFrame(animateOrbs);
      }

      animateOrbs();
    })();
  </script>
</body>
</html>
