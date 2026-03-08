<?php
// proyectos.php - Galería de Proyectos - VERSIÓN PREMIUM 2025
?>
<!DOCTYPE html>
<html lang="es-AR" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nuestros Proyectos — Del Sur Construcciones</title>
  <meta name="description" content="Explorá nuestra galería de proyectos de construcción. Viviendas, locales comerciales y refacciones en AMBA." />
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
    /* Masonry Grid */
    .masonry-grid {
      column-count: 1;
      column-gap: 1.5rem;
    }
    
    @media (min-width: 640px) {
      .masonry-grid { column-count: 2; }
    }
    
    @media (min-width: 1024px) {
      .masonry-grid { column-count: 3; }
    }
    
    .masonry-item {
      break-inside: avoid;
      margin-bottom: 1.5rem;
    }
    
    /* Filter Button Active State */
    .filter-btn.active {
      background: linear-gradient(135deg, #ea580c, #f97316);
      color: white;
      border-color: transparent;
      box-shadow: 0 4px 15px rgba(234, 88, 12, 0.4);
    }
    
    /* Project Card Hover */
    .project-card {
      position: relative;
      overflow: hidden;
      border-radius: 1.5rem;
    }
    
    .project-card img {
      transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .project-card:hover img {
      transform: scale(1.08);
    }
    
    .project-overlay {
      background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.5) 50%, transparent 100%);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    
    .project-card:hover .project-overlay {
      opacity: 1;
    }
    
    .project-info {
      transform: translateY(20px);
      opacity: 0;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .project-card:hover .project-info {
      transform: translateY(0);
      opacity: 1;
    }
    
    /* Modal Styles */
    .modal-backdrop {
      background: rgba(15, 23, 42, 0.95);
      backdrop-filter: blur(10px);
    }
    
    .modal-content {
      animation: modal-in 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @keyframes modal-in {
      from {
        opacity: 0;
        transform: scale(0.95) translateY(20px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }
    
    /* Carousel */
    .carousel-track {
      display: flex;
      transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .carousel-slide {
      min-width: 100%;
    }
    
    /* Zoom Overlay */
    .zoom-overlay {
      background: rgba(0, 0, 0, 0.98);
    }
    
    /* Image Loading Skeleton */
    .skeleton {
      background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
      background-size: 200% 100%;
      animation: skeleton-loading 1.5s infinite;
    }
    
    @keyframes skeleton-loading {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
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

  <!-- Zoom Overlay -->
  <div id="zoomOverlay" class="zoom-overlay fixed inset-0 z-[200] hidden items-center justify-center" onclick="closeZoom()">
    <button class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors p-2">
      <i class="ph ph-x text-3xl"></i>
    </button>
    <img id="zoomImage" src="" alt="Zoom" class="max-w-[95vw] max-h-[90vh] object-contain" onclick="event.stopPropagation()">
    <p class="absolute bottom-6 text-white/50 text-sm">Click afuera para cerrar</p>
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
          <a href="proceso.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-delsur-900 rounded-lg hover:bg-slate-100 transition-all">Proceso</a>
          <a href="proyectos.php" class="px-4 py-2 text-sm font-medium text-delsur-accent rounded-lg bg-orange-50">Proyectos</a>
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
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-slate-100 absolute w-full shadow-2xl">
      <div class="px-4 py-6 space-y-2">
        <a href="index.php" class="block px-4 py-3 text-slate-600 font-medium rounded-lg hover:bg-slate-50">Inicio</a>
        <a href="proceso.php" class="block px-4 py-3 text-slate-600 font-medium rounded-lg hover:bg-slate-50">Proceso</a>
        <a href="proyectos.php" class="block px-4 py-3 text-delsur-accent font-bold rounded-lg bg-orange-50">Proyectos</a>
        <a href="pagos.php" class="block px-4 py-3 text-slate-600 font-medium rounded-lg hover:bg-slate-50">Planes</a>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="pt-32 pb-16 bg-gradient-to-br from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-600 text-xs font-bold tracking-widest uppercase mb-4 animate-fadeIn">Portfolio</span>
      <h1 class="text-4xl md:text-6xl font-display font-bold text-delsur-900 mb-4 animate-fadeInUp">
        Nuestras Obras
      </h1>
      <p class="text-slate-500 max-w-2xl mx-auto text-lg animate-fadeInUp delay-100">
        Explorá nuestra galería de proyectos recientes. Cada construcción cuenta una historia de dedicación y excelencia.
      </p>
    </div>
  </header>

  <!-- Filter Buttons -->
  <section class="pb-8 bg-gradient-to-br from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex flex-wrap justify-center gap-3 animate-fadeInUp delay-200">
        <button onclick="filterProjects('all')" class="filter-btn active px-6 py-3 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-orange-300 transition-all font-medium text-sm" data-category="all">
          Todos
        </button>
        <button onclick="filterProjects('vivienda')" class="filter-btn px-6 py-3 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-orange-300 transition-all font-medium text-sm" data-category="vivienda">
          <i class="ph ph-house mr-2"></i>Vivienda
        </button>
        <button onclick="filterProjects('comercial')" class="filter-btn px-6 py-3 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-orange-300 transition-all font-medium text-sm" data-category="comercial">
          <i class="ph ph-storefront mr-2"></i>Comercial
        </button>
        <button onclick="filterProjects('refacción')" class="filter-btn px-6 py-3 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-orange-300 transition-all font-medium text-sm" data-category="refacción">
          <i class="ph ph-paint-brush mr-2"></i>Refacción
        </button>
      </div>
    </div>
  </section>

  <!-- Projects Grid -->
  <section class="py-8 bg-gradient-to-br from-slate-50 to-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
      <div id="projectsGrid" class="masonry-grid">
        <!-- Projects will be rendered here -->
      </div>
      
      <!-- Empty State -->
      <div id="emptyState" class="hidden text-center py-20">
        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <i class="ph ph-images text-4xl text-slate-400"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-700 mb-2">No hay proyectos</h3>
        <p class="text-slate-500">No se encontraron proyectos en esta categoría.</p>
      </div>
    </div>
  </section>

  <!-- Project Modal -->
  <div id="projectModal" class="modal-backdrop fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="modal-content bg-white rounded-3xl w-full max-w-6xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col lg:flex-row">
      
      <!-- Close Button -->
      <button onclick="closeModal()" class="absolute top-4 right-4 z-50 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-colors">
        <i class="ph ph-x text-xl"></i>
      </button>

      <!-- Image Carousel -->
      <div class="lg:w-3/5 bg-slate-900 relative h-64 lg:h-auto overflow-hidden group">
        <div id="carouselTrack" class="carousel-track h-full">
          <!-- Slides will be inserted here -->
        </div>
        
        <!-- Zoom Button -->
        <button onclick="openZoom()" class="absolute bottom-4 right-4 z-20 bg-white/20 hover:bg-white/40 backdrop-blur-md p-3 rounded-full text-white opacity-0 group-hover:opacity-100 transition-all">
          <i class="ph ph-magnifying-glass-plus text-xl"></i>
        </button>

        <!-- Carousel Dots -->
        <div id="carouselDots" class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
          <!-- Dots will be inserted here -->
        </div>
        
        <!-- Navigation Arrows -->
        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 backdrop-blur-sm p-3 rounded-full text-white opacity-0 group-hover:opacity-100 transition-all">
          <i class="ph ph-caret-left text-xl"></i>
        </button>
        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 backdrop-blur-sm p-3 rounded-full text-white opacity-0 group-hover:opacity-100 transition-all">
          <i class="ph ph-caret-right text-xl"></i>
        </button>
      </div>

      <!-- Project Details -->
      <div class="lg:w-2/5 p-8 overflow-y-auto bg-white">
        <div class="mb-6">
          <span id="modalCategory" class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold uppercase tracking-wider rounded-full mb-3"></span>
          <h2 id="modalTitle" class="text-3xl font-display font-bold text-delsur-900 leading-tight mb-4"></h2>
          <p id="modalDesc" class="text-slate-600 leading-relaxed"></p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-3 gap-4 py-6 border-y border-slate-100 mb-6">
          <div class="text-center">
            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Superficie</span>
            <span id="modalSize" class="block text-delsur-900 font-bold"></span>
          </div>
          <div class="text-center border-l border-slate-100">
            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Ubicación</span>
            <span id="modalLocation" class="block text-delsur-900 font-bold"></span>
          </div>
          <div class="text-center border-l border-slate-100">
            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Año</span>
            <span id="modalYear" class="block text-delsur-900 font-bold"></span>
          </div>
        </div>

        <!-- Features -->
        <div class="mb-8">
          <h4 id="modalFeaturesTitle" class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wider"></h4>
          <ul id="modalFeatures" class="space-y-2">
            <!-- Features will be inserted here -->
          </ul>
        </div>

        <!-- CTA Button -->
        <a href="#" id="modalCta" class="block w-full py-4 rounded-xl bg-gradient-to-r from-delsur-900 to-delsur-800 text-white font-bold text-center hover:shadow-xl transition-all flex items-center justify-center gap-2 btn-shine">
          <i class="ph ph-calculator"></i>
          COTIZAR PROYECTO SIMILAR
        </a>
      </div>
    </div>
  </div>

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

    // Load Projects Data
    const projectsRaw = <?php 
      $jsonFile = 'proyectos.json';
      echo file_exists($jsonFile) ? file_get_contents($jsonFile) : '[]';
    ?>;

    const projects = projectsRaw.map(p => ({
      id: p.id,
      title: p.titulo,
      category: p.categoria.toLowerCase(),
      description: p.descripcion,
      location: p.ubicacion || "Consultar",
      size: p.medidas || "Consultar",
      year: p.anio || "2025",
      featuresTitle: p.titulo_features || "Servicios Incluidos",
      features: Array.isArray(p.features) && p.features.length > 0 ? p.features : ["Consultar detalles"],
      images: Array.isArray(p.imagenes) ? p.imagenes : [p.imagenes]
    }));

    // Render Projects
    function renderProjects(filter = 'all') {
      const grid = document.getElementById('projectsGrid');
      const emptyState = document.getElementById('emptyState');
      grid.innerHTML = '';

      const filtered = filter === 'all' ? projects : projects.filter(p => p.category === filter);

      if (filtered.length === 0) {
        emptyState.classList.remove('hidden');
        return;
      }
      emptyState.classList.add('hidden');

      filtered.forEach((p, index) => {
        const card = document.createElement('div');
        card.className = 'masonry-item';
        card.innerHTML = `
          <div class="project-card cursor-pointer shadow-lg hover:shadow-2xl transition-all" onclick="openModal('${p.id}')" style="animation: fadeInUp 0.5s ease ${index * 0.1}s both;">
            <div class="relative">
              <img src="${p.images[0]}" alt="${p.title}" class="w-full object-cover" loading="lazy">
              <div class="project-overlay absolute inset-0 flex flex-col justify-end p-6">
                <div class="project-info">
                  <span class="text-orange-400 text-xs font-bold uppercase tracking-wider mb-1 block">${p.category}</span>
                  <h3 class="text-xl font-bold text-white mb-1">${p.title}</h3>
                  <p class="text-slate-300 text-sm flex items-center gap-2">
                    <i class="ph ph-ruler"></i> ${p.size}
                  </p>
                </div>
              </div>
            </div>
          </div>
        `;
        grid.appendChild(card);
      });
    }

    // Filter Function
    function filterProjects(category) {
      // Update active button
      document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.category === category) {
          btn.classList.add('active');
        }
      });

      // Render filtered projects
      renderProjects(category);
    }

    // Modal Logic
    let currentProject = null;
    let currentSlide = 0;
    let autoPlayInterval = null;

    function openModal(id) {
      currentProject = projects.find(p => p.id === id);
      if (!currentProject) return;

      // Populate modal content
      document.getElementById('modalTitle').textContent = currentProject.title;
      document.getElementById('modalCategory').textContent = currentProject.category;
      document.getElementById('modalDesc').textContent = currentProject.description;
      document.getElementById('modalSize').textContent = currentProject.size;
      document.getElementById('modalLocation').textContent = currentProject.location;
      document.getElementById('modalYear').textContent = currentProject.year;
      document.getElementById('modalFeaturesTitle').textContent = currentProject.featuresTitle;
      document.getElementById('modalCta').href = `comenzar.php?ref_proyecto=${encodeURIComponent(currentProject.title)}`;

      // Populate features
      const featuresList = document.getElementById('modalFeatures');
      featuresList.innerHTML = '';
      currentProject.features.forEach(f => {
        const li = document.createElement('li');
        li.className = 'flex items-center gap-2 text-slate-600';
        li.innerHTML = `<i class="ph ph-check-circle text-orange-500"></i> ${f}`;
        featuresList.appendChild(li);
      });

      // Setup carousel
      setupCarousel(currentProject.images);

      // Show modal
      const modal = document.getElementById('projectModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';

      startAutoPlay();
    }

    function closeModal() {
      const modal = document.getElementById('projectModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = '';
      stopAutoPlay();
    }

    function setupCarousel(images) {
      currentSlide = 0;
      const track = document.getElementById('carouselTrack');
      const dots = document.getElementById('carouselDots');
      
      track.innerHTML = '';
      dots.innerHTML = '';

      images.forEach((img, index) => {
        // Create slide
        const slide = document.createElement('div');
        slide.className = 'carousel-slide h-full';
        slide.innerHTML = `<img src="${img}" class="w-full h-full object-cover" alt="">`;
        track.appendChild(slide);

        // Create dot
        const dot = document.createElement('button');
        dot.className = `w-2 h-2 rounded-full transition-all ${index === 0 ? 'bg-white w-6' : 'bg-white/50'}`;
        dot.onclick = () => goToSlide(index);
        dots.appendChild(dot);
      });

      updateCarousel();
    }

    function updateCarousel() {
      const track = document.getElementById('carouselTrack');
      track.style.transform = `translateX(-${currentSlide * 100}%)`;

      const dots = document.getElementById('carouselDots').children;
      Array.from(dots).forEach((d, i) => {
        d.className = `w-2 h-2 rounded-full transition-all ${i === currentSlide ? 'bg-white w-6' : 'bg-white/50'}`;
      });
    }

    function nextSlide() {
      if (!currentProject) return;
      currentSlide = (currentSlide + 1) % currentProject.images.length;
      updateCarousel();
    }

    function prevSlide() {
      if (!currentProject) return;
      currentSlide = (currentSlide - 1 + currentProject.images.length) % currentProject.images.length;
      updateCarousel();
    }

    function goToSlide(n) {
      currentSlide = n;
      updateCarousel();
      startAutoPlay();
    }

    function startAutoPlay() {
      stopAutoPlay();
      if (currentProject && currentProject.images.length > 1) {
        autoPlayInterval = setInterval(nextSlide, 4000);
      }
    }

    function stopAutoPlay() {
      if (autoPlayInterval) clearInterval(autoPlayInterval);
    }

    // Zoom Function
    function openZoom() {
      if (!currentProject) return;
      const zoomOverlay = document.getElementById('zoomOverlay');
      const zoomImage = document.getElementById('zoomImage');
      
      zoomImage.src = currentProject.images[currentSlide];
      zoomOverlay.classList.remove('hidden');
      zoomOverlay.classList.add('flex');
      stopAutoPlay();
    }

    function closeZoom() {
      document.getElementById('zoomOverlay').classList.add('hidden');
      document.getElementById('zoomOverlay').classList.remove('flex');
      startAutoPlay();
    }

    // Keyboard Navigation
    document.addEventListener('keydown', (e) => {
      const modal = document.getElementById('projectModal');
      if (modal.classList.contains('hidden')) return;

      if (e.key === 'Escape') closeModal();
      if (e.key === 'ArrowRight') nextSlide();
      if (e.key === 'ArrowLeft') prevSlide();
    });

    // Close modal on backdrop click
    document.getElementById('projectModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) closeModal();
    });

    // Initial Render
    renderProjects();
  </script>
</body>
</html>
