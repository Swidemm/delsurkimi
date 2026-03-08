<?php
// proceso.php - Cómo Trabajamos - VERSIÓN PREMIUM 2025 con animación de pasos
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cómo Trabajamos — Del Sur Construcciones</title>
  <meta name="description" content="Conocé nuestro proceso de trabajo en 5 pasos. Desde la consulta inicial hasta la entrega de llaves." />
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
              blue: '#3b82f6',
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
    /* Timeline Styles */
    .timeline-container {
      position: relative;
      padding-left: 40px;
    }
    
    @media (min-width: 768px) {
      .timeline-container {
        padding-left: 0;
      }
    }
    
    .timeline-line {
      position: absolute;
      left: 20px;
      top: 0;
      width: 4px;
      height: 0;
      background: linear-gradient(to bottom, #ea580c, #f97316, #3b82f6, #22c55e, #ea580c);
      border-radius: 2px;
      transition: height 1.5s ease-out;
    }
    
    @media (min-width: 768px) {
      .timeline-line {
        left: 50%;
        transform: translateX(-50%);
      }
    }
    
    .timeline-line.animate {
      height: 100%;
    }
    
    .step-item {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .step-item.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    .step-dot {
      position: relative;
      z-index: 10;
      transition: all 0.5s ease;
    }
    
    .step-dot.pulse::after {
      content: '';
      position: absolute;
      inset: -8px;
      border-radius: 50%;
      background: inherit;
      opacity: 0.4;
      animation: pulse-ring 1.5s ease-out infinite;
    }
    
    @keyframes pulse-ring {
      0% { transform: scale(1); opacity: 0.4; }
      100% { transform: scale(1.5); opacity: 0; }
    }
    
    /* Step Card */
    .step-card {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .step-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    /* Icon Animation */
    .step-icon {
      transition: all 0.3s ease;
    }
    
    .step-card:hover .step-icon {
      transform: scale(1.1) rotate(5deg);
    }
    
    /* Pricing Cards Animation */
    .pricing-cards-container {
      opacity: 0;
      transform: translateY(50px);
      transition: all 1s ease-out;
    }
    
    .pricing-cards-container.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Glass Card for pricing */
    .glass-card {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.1);
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
    </div>
  </div>

  <!-- Navigation -->
  <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 bg-white/90 backdrop-blur-md border-b border-slate-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <a href="index.php" class="flex-shrink-0 group">
          <img src="./imagenes/logo.webp" alt="Del Sur" class="h-12 w-auto group-hover:scale-105 transition-transform" />
        </a>
        
        <div class="hidden lg:flex items-center space-x-1">
          <a href="index.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-delsur-900 rounded-lg hover:bg-slate-100 transition-all">Inicio</a>
          <a href="proceso.php" class="px-4 py-2 text-sm font-medium text-delsur-accent rounded-lg bg-orange-50">Proceso</a>
          <a href="proyectos.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-delsur-900 rounded-lg hover:bg-slate-100 transition-all">Proyectos</a>
          <a href="pagos.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-delsur-900 rounded-lg hover:bg-slate-100 transition-all">Planes</a>
          <a href="index.php#contacto" class="ml-4 px-6 py-2.5 rounded-xl bg-gradient-to-r from-delsur-accent to-delsur-accent-light text-white font-semibold text-sm hover:shadow-lg transition-all">
            Pedir Presupuesto
          </a>
        </div>

        <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
          <i class="ph ph-list text-2xl text-slate-600"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-600 text-xs font-bold tracking-widest uppercase mb-4 animate-fadeIn">Nuestro Proceso</span>
      <h1 class="text-4xl md:text-6xl font-display font-bold text-delsur-900 mb-4 animate-fadeInUp">
        El Método Del Sur
      </h1>
      <p class="text-slate-600 text-lg max-w-2xl mx-auto animate-fadeInUp delay-100">
        Un método probado en más de 50 proyectos. Claridad, transparencia y resultados excepcionales.
      </p>
    </div>
  </header>

  <!-- Timeline Section -->
  <section class="py-16 bg-white relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4">
      <div class="timeline-container relative">
        <!-- Timeline Line - se anima con JS -->
        <div class="timeline-line" id="timelineLine"></div>

        <!-- Steps -->
        <div class="space-y-16 md:space-y-24">
          
          <!-- Step 1 -->
          <div class="step-item relative flex flex-col md:flex-row items-center gap-8" data-step="1">
            <div class="md:w-1/2 md:text-right md:pr-12 w-full">
              <div class="step-card bg-white p-8 rounded-3xl shadow-lg border border-slate-100 inline-block text-left w-full md:w-auto">
                <div class="step-icon w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-orange-500/30">
                  <i class="ph ph-chat-dots text-3xl text-white"></i>
                </div>
                <span class="text-orange-500 font-bold text-sm uppercase tracking-wider">Paso 1</span>
                <h3 class="text-2xl font-display font-bold text-delsur-900 mt-2 mb-3">Consulta Inicial</h3>
                <p class="text-slate-600">Nos reunimos para conocer tus necesidades, presupuesto y expectativas. Analizamos el terreno y viabilidad del proyecto.</p>
                <ul class="mt-4 space-y-2">
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Reunión presencial o virtual
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Análisis de necesidades
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Evaluación de terreno
                  </li>
                </ul>
              </div>
            </div>
            <div class="step-dot w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-lg z-10 shrink-0">
              <span class="text-white font-bold text-xl">1</span>
            </div>
            <div class="md:w-1/2 md:pl-12 hidden md:block"></div>
          </div>

          <!-- Step 2 -->
          <div class="step-item relative flex flex-col md:flex-row items-center gap-8" data-step="2">
            <div class="md:w-1/2 md:pr-12 hidden md:block"></div>
            <div class="step-dot w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg z-10 shrink-0">
              <span class="text-white font-bold text-xl">2</span>
            </div>
            <div class="md:w-1/2 md:text-left md:pl-12 w-full">
              <div class="step-card bg-white p-8 rounded-3xl shadow-lg border border-slate-100 inline-block w-full md:w-auto">
                <div class="step-icon w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                  <i class="ph ph-pencil-ruler text-3xl text-white"></i>
                </div>
                <span class="text-blue-500 font-bold text-sm uppercase tracking-wider">Paso 2</span>
                <h3 class="text-2xl font-display font-bold text-delsur-900 mt-2 mb-3">Diseño y Planificación</h3>
                <p class="text-slate-600">Nuestros arquitectos crean el diseño conceptual. Presentamos planos, renders y ajustamos según tu feedback.</p>
                <ul class="mt-4 space-y-2">
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Planos arquitectónicos
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Renders 3D
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Ajustes ilimitados
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="step-item relative flex flex-col md:flex-row items-center gap-8" data-step="3">
            <div class="md:w-1/2 md:text-right md:pr-12 w-full">
              <div class="step-card bg-white p-8 rounded-3xl shadow-lg border border-slate-100 inline-block text-left w-full md:w-auto">
                <div class="step-icon w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-purple-500/30">
                  <i class="ph ph-calculator text-3xl text-white"></i>
                </div>
                <span class="text-purple-500 font-bold text-sm uppercase tracking-wider">Paso 3</span>
                <h3 class="text-2xl font-display font-bold text-delsur-900 mt-2 mb-3">Presupuesto Detallado</h3>
                <p class="text-slate-600">Preparamos un presupuesto transparente con desglose de materiales, mano de obra y tiempos estimados.</p>
                <ul class="mt-4 space-y-2">
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Desglose completo
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Sin costos ocultos
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Cronograma de pagos
                  </li>
                </ul>
              </div>
            </div>
            <div class="step-dot w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg z-10 shrink-0">
              <span class="text-white font-bold text-xl">3</span>
            </div>
            <div class="md:w-1/2 md:pl-12 hidden md:block"></div>
          </div>

          <!-- Step 4 -->
          <div class="step-item relative flex flex-col md:flex-row items-center gap-8" data-step="4">
            <div class="md:w-1/2 md:pr-12 hidden md:block"></div>
            <div class="step-dot w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg z-10 shrink-0">
              <span class="text-white font-bold text-xl">4</span>
            </div>
            <div class="md:w-1/2 md:text-left md:pl-12 w-full">
              <div class="step-card bg-white p-8 rounded-3xl shadow-lg border border-slate-100 inline-block w-full md:w-auto">
                <div class="step-icon w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-green-500/30">
                  <i class="ph ph-hard-hat text-3xl text-white"></i>
                </div>
                <span class="text-green-500 font-bold text-sm uppercase tracking-wider">Paso 4</span>
                <h3 class="text-2xl font-display font-bold text-delsur-900 mt-2 mb-3">Construcción</h3>
                <p class="text-slate-600">Comienza la obra con supervisión constante. Te mantenemos informado con reportes semanales y fotos del progreso.</p>
                <ul class="mt-4 space-y-2">
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Supervisión diaria
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Reportes semanales
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Control de calidad
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Step 5 -->
          <div class="step-item relative flex flex-col md:flex-row items-center gap-8" data-step="5">
            <div class="md:w-1/2 md:text-right md:pr-12 w-full">
              <div class="step-card bg-white p-8 rounded-3xl shadow-lg border border-slate-100 inline-block text-left w-full md:w-auto">
                <div class="step-icon w-16 h-16 bg-gradient-to-br from-delsur-accent to-delsur-accent-light rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-orange-500/30">
                  <i class="ph ph-key text-3xl text-white"></i>
                </div>
                <span class="text-orange-500 font-bold text-sm uppercase tracking-wider">Paso 5</span>
                <h3 class="text-2xl font-display font-bold text-delsur-900 mt-2 mb-3">Entrega de Llaves</h3>
                <p class="text-slate-600">Inspección final, limpieza completa y entrega de documentación. Tu proyecto terminado y listo para disfrutar.</p>
                <ul class="mt-4 space-y-2">
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Inspección final
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Limpieza profesional
                  </li>
                  <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-check-circle text-green-500"></i> Garantía de obra
                  </li>
                </ul>
              </div>
            </div>
            <div class="step-dot w-14 h-14 bg-gradient-to-br from-delsur-accent to-delsur-accent-light rounded-full flex items-center justify-center shadow-lg z-10 shrink-0">
              <span class="text-white font-bold text-xl">5</span>
            </div>
            <div class="md:w-1/2 md:pl-12 hidden md:block"></div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Pricing Cards Section - Aparece al final -->
  <section class="py-20 bg-gradient-to-br from-delsur-900 via-delsur-800 to-delsur-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 pattern-dots opacity-10"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/20 rounded-full blur-[120px]"></div>
    
    <div class="max-w-6xl mx-auto px-4 relative">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-orange-300 text-xs font-bold uppercase tracking-wider mb-4">
          <i class="ph ph-crown"></i> Comenzá con el pie derecho
        </span>
        <h2 class="font-display text-4xl md:text-5xl font-bold mb-6">Asesoría Profesional</h2>
        <p class="text-slate-300 text-lg">
          Elegí cómo querés comenzar tu proyecto. Sin letras chicas ni costos ocultos.
        </p>
      </div>

      <div class="pricing-cards-container grid md:grid-cols-2 gap-8 max-w-4xl mx-auto" id="pricingCards">
        <!-- Plan Básico -->
        <div class="glass-card p-8 rounded-3xl border-t border-white/10 hover:bg-white/10 transition-all">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-slate-700 rounded-xl flex items-center justify-center">
              <i class="ph ph-chat-circle-text text-xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-300">Asesoría General</h3>
          </div>
          
          <div class="flex items-baseline gap-1 mb-6">
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
        <div class="glass-card p-8 rounded-3xl border-2 border-orange-500/50 bg-gradient-to-br from-orange-500/10 to-transparent relative transform hover:-translate-y-2 transition-all">
          <div class="absolute -top-4 left-1/2 -translate-x-1/2">
            <span class="px-4 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-bold rounded-full shadow-lg shadow-orange-500/30">
              <i class="ph ph-star-fill mr-1"></i> RECOMENDADO
            </span>
          </div>
          
          <div class="flex items-center gap-3 mb-4 mt-2">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
              <i class="ph ph-crown text-xl text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-orange-300">Pack Premium</h3>
          </div>
          
          <div class="flex items-baseline gap-1 mb-6">
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

  <!-- CTA Section -->
  <section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-3xl md:text-4xl font-display font-bold text-delsur-900 mb-6">¿Listo para comenzar tu proyecto?</h2>
      <p class="text-slate-600 text-lg mb-8 max-w-2xl mx-auto">
        Contactanos hoy mismo y recibí una consulta gratuita. El primer paso hacia tu sueño empieza ahora.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="index.php#contacto" class="px-8 py-4 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold hover:shadow-lg hover:shadow-orange-500/40 transition-all flex items-center justify-center gap-2">
          <i class="ph ph-paper-plane-right"></i>
          Solicitar Consulta
        </a>
        <a href="https://wa.me/5491167040733" target="_blank" class="px-8 py-4 rounded-xl bg-white/10 text-white font-bold hover:bg-white/20 transition-all flex items-center justify-center gap-2 backdrop-blur-sm border border-white/20">
          <i class="ph ph-whatsapp-logo"></i>
          WhatsApp Directo
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-delsur-900 text-slate-400 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-12 text-center">
      <p>© 2025 Del Sur Construcciones. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
    // Preloader
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.getElementById('preloader').classList.add('hidden');
      }, 1000);
    });

    // Mobile Menu
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
      document.getElementById('mobileMenu').classList.toggle('hidden');
    });

    // Animación de pasos apareciendo uno por uno
    (function() {
      const steps = document.querySelectorAll('.step-item');
      const timelineLine = document.getElementById('timelineLine');
      const pricingCards = document.getElementById('pricingCards');
      let currentStep = 0;
      
      function showNextStep() {
        if (currentStep < steps.length) {
          const step = steps[currentStep];
          const dot = step.querySelector('.step-dot');
          
          // Mostrar el paso
          step.classList.add('visible');
          
          // Agregar pulse al dot
          setTimeout(() => {
            dot.classList.add('pulse');
          }, 300);
          
          currentStep++;
          
          // Programar el siguiente paso
          setTimeout(showNextStep, 1200);
        } else {
          // Todos los pasos mostrados, animar la línea completa
          timelineLine.classList.add('animate');
          
          // Mostrar las cartas de precios
          setTimeout(() => {
            pricingCards.classList.add('visible');
          }, 1500);
        }
      }
      
      // Iniciar la animación cuando la sección sea visible
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            // Comenzar animación
            setTimeout(showNextStep, 500);
            observer.disconnect();
          }
        });
      }, { threshold: 0.2 });
      
      observer.observe(document.querySelector('.timeline-container'));
    })();
  </script>
</body>
</html>
