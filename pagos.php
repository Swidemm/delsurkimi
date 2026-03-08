<?php
// pagos.php - Planes y Precios - VERSIÓN PREMIUM 2025
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Planes y Precios — Del Sur Construcciones</title>
  <meta name="description" content="Elegí el plan que mejor se adapte a tu proyecto. Asesoría General $3.500 o Pack Premium $4.500 con Planificador 2D incluido." />
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
    /* Pricing Card Effects */
    .pricing-card {
      position: relative;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .pricing-card:hover {
      transform: translateY(-8px);
    }
    
    .pricing-card.featured {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      border: 2px solid transparent;
      background-clip: padding-box;
    }
    
    .pricing-card.featured::before {
      content: '';
      position: absolute;
      inset: -2px;
      background: linear-gradient(135deg, #ea580c, #f97316, #3b82f6);
      border-radius: inherit;
      z-index: -1;
    }
    
    /* Check Animation */
    .check-icon {
      animation: check-pop 0.3s ease forwards;
    }
    
    @keyframes check-pop {
      0% { transform: scale(0); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }
    
    /* Price Counter Animation */
    .price-number {
      background: linear-gradient(135deg, #ea580c, #f97316);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    /* Feature List Hover */
    .feature-item {
      transition: all 0.2s ease;
    }
    
    .feature-item:hover {
      transform: translateX(4px);
    }
    
    /* Trust Badges */
    .trust-badge {
      transition: all 0.3s ease;
    }
    
    .trust-badge:hover {
      transform: translateY(-2px);
    }
    
    /* Payment Methods */
    .payment-method {
      transition: all 0.3s ease;
    }
    
    .payment-method:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="font-sans text-slate-700 bg-slate-50 antialiased min-h-screen flex flex-col">

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
  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40 shadow-sm">
    <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
      <a href="index.php" class="flex-shrink-0">
        <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" />
      </a>
      <a href="index.php" class="text-sm font-bold text-slate-500 hover:text-delsur-900 flex items-center gap-2 transition-colors px-4 py-2 rounded-lg hover:bg-slate-100">
        <i class="ph ph-arrow-left"></i> Volver
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow">
    
    <!-- Header -->
    <div class="py-16 bg-gradient-to-br from-slate-50 to-white">
      <div class="max-w-5xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-600 text-xs font-bold tracking-widest uppercase mb-4 animate-fadeIn">Inversión</span>
        <h1 class="text-4xl md:text-5xl font-display font-bold text-delsur-900 mb-4 animate-fadeInUp">
          Inversión Transparente
        </h1>
        <p class="text-slate-600 text-lg max-w-2xl mx-auto animate-fadeInUp delay-100">
          Elegí cómo querés comenzar tu proyecto. Sin letras chicas ni costos ocultos.
        </p>
      </div>
    </div>

    <!-- Pricing Cards -->
    <div class="pb-16 bg-gradient-to-br from-slate-50 to-white">
      <div class="max-w-5xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8 items-start">
          
          <!-- Plan Básico -->
          <div class="pricing-card bg-white p-8 rounded-3xl shadow-lg border border-slate-200 animate-fadeInUp delay-200">
            <div class="flex items-center gap-4 mb-6">
              <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                <i class="ph ph-chat-circle-text text-2xl text-slate-600"></i>
              </div>
              <div>
                <h3 class="text-xl font-bold text-slate-800">Asesoría General</h3>
                <p class="text-slate-500 text-sm">Consulta inicial</p>
              </div>
            </div>
            
            <div class="flex items-baseline gap-1 mb-6">
              <span class="text-slate-400 text-2xl">$</span>
              <span class="text-5xl font-display font-bold text-slate-800">3.500</span>
              <span class="text-slate-400">/ única vez</span>
            </div>
            
            <p class="text-slate-600 mb-8">
              Ideal si tenés el terreno y querés saber qué se puede construir y cuánto va a costar realmente.
            </p>
            
            <a href="https://mpago.la/2epkCqz" target="_blank" class="block w-full py-4 rounded-xl border-2 border-slate-200 text-slate-700 font-bold text-center hover:border-delsur-accent hover:text-delsur-accent transition-all mb-8 flex items-center justify-center gap-2">
              <i class="ph ph-credit-card"></i>
              Elegir Asesoría
            </a>

            <div class="space-y-4">
              <div class="feature-item flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                  <i class="ph ph-check text-green-600 text-sm"></i>
                </div>
                <span class="text-slate-700">Reunión de diagnóstico (Virtual/Presencial)</span>
              </div>
              <div class="feature-item flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                  <i class="ph ph-check text-green-600 text-sm"></i>
                </div>
                <span class="text-slate-700">Análisis de viabilidad técnica</span>
              </div>
              <div class="feature-item flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                  <i class="ph ph-check text-green-600 text-sm"></i>
                </div>
                <span class="text-slate-700">Presupuesto estimado de obra</span>
              </div>
              <div class="feature-item flex items-center gap-3 opacity-50">
                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                  <i class="ph ph-x text-slate-400 text-sm"></i>
                </div>
                <span class="text-slate-500 line-through">Sin acceso al Planificador 2D</span>
              </div>
            </div>
          </div>

          <!-- Plan Premium -->
          <div class="pricing-card featured p-8 rounded-3xl shadow-2xl text-white animate-fadeInUp delay-300 relative">
            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
              <span class="px-4 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-bold rounded-full shadow-lg shadow-orange-500/30 flex items-center gap-1">
                <i class="ph ph-crown"></i> MÁS ELEGIDO
              </span>
            </div>
            
            <div class="flex items-center gap-4 mb-6 mt-2">
              <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center">
                <i class="ph ph-crown text-2xl text-orange-400"></i>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Pack Premium</h3>
                <p class="text-slate-400 text-sm">Experiencia completa</p>
              </div>
            </div>
            
            <div class="flex items-baseline gap-1 mb-6">
              <span class="text-slate-400 text-2xl">$</span>
              <span class="text-5xl font-display font-bold text-orange-400">4.500</span>
              <span class="text-slate-400">/ única vez</span>
            </div>
            
            <p class="text-slate-300 mb-8">
              La experiencia completa. Diseñá tu casa con nuestra herramienta exclusiva y recibí asesoramiento prioritario.
            </p>
            
            <a href="https://mpago.la/1eswcbb" target="_blank" class="block w-full py-4 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold text-center hover:shadow-lg hover:shadow-orange-500/40 transition-all mb-8 flex items-center justify-center gap-2 btn-shine animate-pulse-glow">
              <i class="ph ph-lightning"></i>
              CONTRATAR PACK
            </a>

            <div class="space-y-4">
              <div class="feature-item flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-orange-500/20 flex items-center justify-center shrink-0">
                  <i class="ph ph-check text-orange-400 text-sm"></i>
                </div>
                <span class="text-white">Todo lo incluido en Asesoría</span>
              </div>
              <div class="feature-item flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-orange-500/20 flex items-center justify-center shrink-0">
                  <i class="ph ph-check text-orange-400 text-sm"></i>
                </div>
                <span class="text-white font-bold">Licencia Planificador 2D</span>
              </div>
              <div class="feature-item flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-orange-500/20 flex items-center justify-center shrink-0">
                  <i class="ph ph-check text-orange-400 text-sm"></i>
                </div>
                <span class="text-white">Prioridad en agenda de obra</span>
              </div>
              <div class="feature-item flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-orange-500/20 flex items-center justify-center shrink-0">
                  <i class="ph ph-check text-orange-400 text-sm"></i>
                </div>
                <span class="text-white">Descuento si contratás la obra</span>
              </div>
            </div>
          </div>
        </div>

        <!-- WhatsApp CTA -->
        <div class="mt-12 text-center">
          <p class="text-slate-500 mb-4">¿Tenés dudas antes de pagar?</p>
          <a href="https://wa.me/5491167040733" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-all hover:shadow-lg hover:shadow-green-500/30">
            <i class="ph ph-whatsapp-logo text-xl"></i>
            Escribinos por WhatsApp
          </a>
        </div>
      </div>
    </div>

    <!-- Trust Badges -->
    <div class="py-16 bg-white border-t border-slate-100">
      <div class="max-w-5xl mx-auto px-4">
        <p class="text-center text-slate-500 text-sm mb-8 uppercase tracking-wider">Confianza y Seguridad</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div class="trust-badge flex flex-col items-center text-center p-4">
            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-3">
              <i class="ph ph-shield-check text-3xl text-green-600"></i>
            </div>
            <h4 class="font-bold text-slate-800 text-sm">Pago Seguro</h4>
            <p class="text-slate-500 text-xs mt-1">MercadoPago</p>
          </div>
          <div class="trust-badge flex flex-col items-center text-center p-4">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-3">
              <i class="ph ph-certificate text-3xl text-blue-600"></i>
            </div>
            <h4 class="font-bold text-slate-800 text-sm">Garantía</h4>
            <p class="text-slate-500 text-xs mt-1">Satisfacción</p>
          </div>
          <div class="trust-badge flex flex-col items-center text-center p-4">
            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-3">
              <i class="ph ph-lock-key text-3xl text-purple-600"></i>
            </div>
            <h4 class="font-bold text-slate-800 text-sm">Datos Protegidos</h4>
            <p class="text-slate-500 text-xs mt-1">Encriptados</p>
          </div>
          <div class="trust-badge flex flex-col items-center text-center p-4">
            <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-3">
              <i class="ph ph-headset text-3xl text-orange-600"></i>
            </div>
            <h4 class="font-bold text-slate-800 text-sm">Soporte 24/7</h4>
            <p class="text-slate-500 text-xs mt-1">Siempre disponible</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Methods -->
    <div class="py-16 bg-slate-50">
      <div class="max-w-5xl mx-auto px-4">
        <p class="text-center text-slate-500 text-sm mb-8 uppercase tracking-wider">Métodos de Pago Aceptados</p>
        <div class="flex flex-wrap justify-center gap-4">
          <div class="payment-method bg-white px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="ph ph-credit-card text-2xl text-slate-600"></i>
            <span class="font-medium text-slate-700">Tarjetas de Crédito</span>
          </div>
          <div class="payment-method bg-white px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="ph ph-bank text-2xl text-slate-600"></i>
            <span class="font-medium text-slate-700">Transferencia</span>
          </div>
          <div class="payment-method bg-white px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="ph ph-money text-2xl text-slate-600"></i>
            <span class="font-medium text-slate-700">Efectivo</span>
          </div>
          <div class="payment-method bg-white px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="ph ph-qr-code text-2xl text-slate-600"></i>
            <span class="font-medium text-slate-700">MercadoPago</span>
          </div>
        </div>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="py-16 bg-white">
      <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-display font-bold text-delsur-900 text-center mb-8">Preguntas sobre el Pago</h2>
        <div class="space-y-4">
          <details class="group bg-slate-50 rounded-2xl overflow-hidden">
            <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 hover:text-delsur-900">
              <span>¿Qué pasa después de pagar?</span>
              <i class="ph ph-caret-down text-slate-400 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="px-6 pb-6 text-slate-600">
              Recibirás un email de confirmación con los próximos pasos. Nos pondremos en contacto dentro de las 24 horas para coordinar la reunión.
            </div>
          </details>
          <details class="group bg-slate-50 rounded-2xl overflow-hidden">
            <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 hover:text-delsur-900">
              <span>¿Puedo solicitar un reembolso?</span>
              <i class="ph ph-caret-down text-slate-400 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="px-6 pb-6 text-slate-600">
              Sí, tenés 7 días para solicitar un reembolso completo si no estás satisfecho con el servicio.
            </div>
          </details>
          <details class="group bg-slate-50 rounded-2xl overflow-hidden">
            <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 hover:text-delsur-900">
              <span>¿El Pack Premium tiene vencimiento?</span>
              <i class="ph ph-caret-down text-slate-400 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="px-6 pb-6 text-slate-600">
              La licencia del Planificador 2D es válida por 30 días desde la fecha de compra.
            </div>
          </details>
        </div>
      </div>
    </div>

  </main>

  <!-- Footer -->
  <footer class="bg-delsur-900 text-slate-400 border-t border-slate-800">
    <div class="max-w-5xl mx-auto px-4 py-8 text-center">
      <p class="text-sm">© 2025 Del Sur Construcciones. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
    // Preloader
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.getElementById('preloader').classList.add('hidden');
      }, 1000);
    });
  </script>
</body>
</html>
