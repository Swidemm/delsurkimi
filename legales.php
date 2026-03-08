<?php
// legales.php - Términos y Privacidad - VERSIÓN PREMIUM 2025
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Términos y Privacidad — Del Sur Construcciones</title>
  <meta name="description" content="Términos y condiciones y política de privacidad de Del Sur Construcciones." />
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
  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40 shadow-sm">
    <div class="max-w-4xl mx-auto px-4 flex justify-between items-center">
      <a href="index.php" class="flex-shrink-0">
        <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" />
      </a>
      <a href="index.php" class="text-sm font-bold text-slate-500 hover:text-delsur-900 flex items-center gap-2 transition-colors px-4 py-2 rounded-lg hover:bg-slate-100">
        <i class="ph ph-arrow-left"></i> Volver
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="py-16">
    <div class="max-w-4xl mx-auto px-4">
      
      <!-- Tabs -->
      <div class="flex gap-4 mb-12 border-b border-slate-200">
        <button onclick="showTab('terminos')" id="tab-terminos" class="px-6 py-3 text-sm font-bold text-delsur-accent border-b-2 border-delsur-accent transition-all">
          Términos y Condiciones
        </button>
        <button onclick="showTab('privacidad')" id="tab-privacidad" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-delsur-900 border-b-2 border-transparent transition-all">
          Política de Privacidad
        </button>
      </div>

      <!-- Términos y Condiciones -->
      <div id="content-terminos" class="space-y-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
          <h1 class="text-3xl font-display font-bold text-delsur-900 mb-6">Términos y Condiciones</h1>
          <p class="text-slate-500 text-sm mb-8">Última actualización: Marzo 2025</p>
          
          <div class="space-y-6 text-slate-600">
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">1. Aceptación de los Términos</h2>
              <p>Al acceder y utilizar este sitio web, aceptás estar sujeto a estos términos y condiciones de uso. Si no estás de acuerdo con alguno de estos términos, te solicitamos que no utilices nuestro sitio.</p>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">2. Servicios Ofrecidos</h2>
              <p>Del Sur Construcciones ofrece servicios de construcción, arquitectura y diseño de interiores. Los presupuestos proporcionados son estimaciones sujetas a cambios según las especificaciones finales del proyecto.</p>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">3. Pagos y Reembolsos</h2>
              <p>Los pagos por asesoría y Pack Premium son finales y no reembolsables, salvo que se indique lo contrario en la descripción del servicio. Las obras de construcción se facturan según el cronograma acordado en el contrato.</p>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">4. Garantía</h2>
              <p>Todas nuestras obras cuentan con garantía escrita. El período de garantía varía según el tipo de trabajo realizado y se especifica en el contrato de obra.</p>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">5. Modificaciones</h2>
              <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación en el sitio.</p>
            </section>
          </div>
        </div>
      </div>

      <!-- Política de Privacidad -->
      <div id="content-privacidad" class="space-y-8 hidden">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
          <h1 class="text-3xl font-display font-bold text-delsur-900 mb-6">Política de Privacidad</h1>
          <p class="text-slate-500 text-sm mb-8">Última actualización: Marzo 2025</p>
          
          <div class="space-y-6 text-slate-600">
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">1. Información que Recopilamos</h2>
              <p>Recopilamos información personal que nos proporcionás voluntariamente a través de nuestros formularios de contacto, incluyendo nombre, email, teléfono y detalles sobre tu proyecto.</p>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">2. Uso de la Información</h2>
              <p>Utilizamos tu información para:</p>
              <ul class="list-disc list-inside mt-2 space-y-1">
                <li>Responder a tus consultas</li>
                <li>Proporcionar presupuestos</li>
                <li>Coordinar visitas técnicas</li>
                <li>Enviar información relevante sobre nuestros servicios</li>
              </ul>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">3. Protección de Datos</h2>
              <p>Implementamos medidas de seguridad para proteger tu información personal contra acceso no autorizado, alteración o divulgación. Tus datos se almacenan de forma segura y nunca los vendemos a terceros.</p>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">4. Tus Derechos</h2>
              <p>Podés solicitar acceso, rectificación o eliminación de tus datos personales en cualquier momento contactándonos a través de nuestros canales de comunicación.</p>
            </section>
            
            <section>
              <h2 class="text-xl font-bold text-delsur-900 mb-3">5. Cookies</h2>
              <p>Utilizamos cookies para mejorar tu experiencia de navegación. Podés configurar tu navegador para rechazar cookies, aunque esto puede afectar algunas funcionalidades del sitio.</p>
            </section>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-delsur-900 text-slate-400 border-t border-slate-800">
    <div class="max-w-4xl mx-auto px-4 py-8 text-center">
      <p class="text-sm">© 2025 Del Sur Construcciones. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
    // Preloader
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.getElementById('preloader').classList.add('hidden');
      }, 500);
    });

    // Tab Navigation
    function showTab(tab) {
      // Hide all content
      document.getElementById('content-terminos').classList.add('hidden');
      document.getElementById('content-privacidad').classList.add('hidden');
      
      // Reset all tabs
      document.getElementById('tab-terminos').classList.remove('text-delsur-accent', 'border-delsur-accent');
      document.getElementById('tab-terminos').classList.add('text-slate-500', 'border-transparent');
      document.getElementById('tab-privacidad').classList.remove('text-delsur-accent', 'border-delsur-accent');
      document.getElementById('tab-privacidad').classList.add('text-slate-500', 'border-transparent');
      
      // Show selected content
      document.getElementById('content-' + tab).classList.remove('hidden');
      
      // Highlight selected tab
      document.getElementById('tab-' + tab).classList.remove('text-slate-500', 'border-transparent');
      document.getElementById('tab-' + tab).classList.add('text-delsur-accent', 'border-delsur-accent');
    }

    // Check URL hash
    if (window.location.hash === '#privacidad') {
      showTab('privacidad');
    }
  </script>
</body>
</html>
