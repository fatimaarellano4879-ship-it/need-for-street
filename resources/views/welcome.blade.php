<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>NEED FOR STREET — HECHO PARA DESTACAR | Sistema Integral Streetwear &amp; POS</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jsPDF para generación de PDF con logotipo de marca (con fallback binario PDF 1.4 integrado) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <!-- Tipografías Inter y JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace'],
          },
          colors: {
            carbon: '#09090B',
            surface: '#121215',
            surfaceAlt: '#18181B',
            borderSubtle: '#27272A',
          },
        },
      },
    };
  </script>

  <style>
    /* ==========================================================================
       SISTEMA DE CUADRÍCULAS RESPONSIVAS ANTI-DEFORMACIÓN — NEED FOR STREET
       Basado en Container Queries (@container) para simular con fidelidad
       Teléfono (375px), Tablet (768px) y PC (100%) con 10 módulos sin huecos.
       ========================================================================== */

    .nfs-viewport-container {
      container-type: inline-size;
      container-name: nfs-viewport;
      position: relative;
      overflow: hidden;
      transition: width 0.35s cubic-bezier(0.22, 1, 0.36, 1);
    }

    /* Protección base anti-desbordamiento de tarjetas */
    .nfs-module-card {
      min-width: 0;
      padding: clamp(0.85rem, 2cqi, 1.3rem);
      border-radius: 1rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 0.7rem;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s ease, border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .nfs-module-card:hover {
      transform: translateY(-2px);
    }

    .nfs-module-card:active {
      transform: scale(0.985);
    }

    .nfs-card-title {
      font-size: clamp(0.9rem, 1.45cqi, 1.08rem);
      line-height: 1.25;
      font-weight: 800;
      overflow-wrap: break-word;
      word-break: break-word;
    }

    .nfs-card-desc {
      font-size: clamp(0.71rem, 1.1cqi, 0.8rem);
      line-height: 1.35;
      overflow-wrap: break-word;
    }

    /* --------------------------------------------------------------------------
       1. LAYOUT BREAKPOINTS: 5×2 en PC (>=960px) / 2×5 en Tablet y Teléfono
       -------------------------------------------------------------------------- */
    .grid-mode-breakpoints {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: clamp(0.65rem, 1.6cqi, 1.1rem);
    }

    .grid-mode-breakpoints .nfs-module-card {
      min-height: 144px;
    }

    @container nfs-viewport (min-width: 960px) {
      .grid-mode-breakpoints {
        grid-template-columns: repeat(5, minmax(0, 1fr));
      }
      .grid-mode-breakpoints .nfs-module-card {
        min-height: 172px;
      }
    }

    /* --------------------------------------------------------------------------
       2. LAYOUT FLUIDO AUTO-FIT: repeat(auto-fit, minmax(205px, 1fr))
       -------------------------------------------------------------------------- */
    .grid-mode-autofit {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(100%, 205px), 1fr));
      gap: clamp(0.65rem, 1.6cqi, 1.1rem);
    }

    .grid-mode-autofit .nfs-module-card {
      min-height: 154px;
    }

    /* --------------------------------------------------------------------------
       3. LAYOUT BENTO MODULAR: grid-auto-flow: dense equilibrado para 10 tarjetas
       -------------------------------------------------------------------------- */
    .grid-mode-bento {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      grid-auto-flow: dense;
      gap: clamp(0.65rem, 1.6cqi, 1.1rem);
    }

    .grid-mode-bento .nfs-module-card {
      min-height: 142px;
    }

    .grid-mode-bento .bento-stock,
    .grid-mode-bento .bento-carrito {
      grid-column: span 2;
    }

    @container nfs-viewport (min-width: 640px) and (max-width: 959px) {
      .grid-mode-bento {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }
      .grid-mode-bento .bento-stock,
      .grid-mode-bento .bento-carrito {
        grid-column: span 2;
      }
    }

    @container nfs-viewport (min-width: 960px) {
      .grid-mode-bento {
        grid-template-columns: repeat(5, minmax(0, 1fr));
      }
      .grid-mode-bento .bento-stock {
        grid-column: span 2;
        grid-row: span 2;
      }
      .grid-mode-bento .bento-finanzas {
        grid-column: span 2;
      }
      .grid-mode-bento .bento-carrito {
        grid-column: span 2;
      }
    }

    /* --------------------------------------------------------------------------
       CUADRÍCULAS INTERNAS DE LOS MÓDULOS (CONTAINER QUERIES)
       -------------------------------------------------------------------------- */
    .cq-grid-2 {
      display: grid;
      grid-template-columns: minmax(0, 1fr);
      gap: 0.875rem;
    }
    @container nfs-viewport (min-width: 620px) {
      .cq-grid-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
      }
    }

    .cq-grid-3 {
      display: grid;
      grid-template-columns: minmax(0, 1fr);
      gap: 0.875rem;
    }
    @container nfs-viewport (min-width: 580px) {
      .cq-grid-3 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }
    @container nfs-viewport (min-width: 920px) {
      .cq-grid-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }
    }

    .cq-grid-5-kpi {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 0.75rem;
    }
    @container nfs-viewport (min-width: 860px) {
      .cq-grid-5-kpi {
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.85rem;
      }
    }

    .cq-split-main {
      display: grid;
      grid-template-columns: minmax(0, 1fr);
      gap: 1rem;
    }
    @container nfs-viewport (min-width: 880px) {
      .cq-split-main {
        grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr);
        gap: 1.25rem;
      }
    }

    /* --------------------------------------------------------------------------
       CARRITO RÁPIDO: DRAWER LATERAL (PC/TABLET) Y BOTTOM SHEET (TELÉFONO)
       -------------------------------------------------------------------------- */
    .nfs-quick-drawer {
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      width: 380px;
      max-width: 100%;
      border-left: 1px solid #27272A;
      transform: translateX(100%);
      transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .nfs-quick-drawer.is-open {
      transform: translateX(0);
    }

    .nfs-quick-sheet {
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      height: 88%;
      border-top: 1px solid #27272A;
      border-top-left-radius: 1.25rem;
      border-top-right-radius: 1.25rem;
      transform: translateY(100%);
      transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .nfs-quick-sheet.is-open {
      transform: translateY(0);
    }

    /* Modo Guías Visuales Grid */
    .grid-guides-active .nfs-module-card,
    .grid-guides-active .cq-guide-box {
      outline: 1.5px dashed rgba(59, 130, 246, 0.78);
      outline-offset: -2px;
    }
    .grid-guides-active #dashboardGrid {
      background-image:
        linear-gradient(to right, rgba(99, 102, 241, 0.1) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(99, 102, 241, 0.1) 1px, transparent 1px);
      background-size: 24px 24px;
    }

    /* Animación de escáner láser QR */
    @keyframes qrLaserSweep {
      0%, 100% { transform: translateY(6px); opacity: 0.45; }
      50% { transform: translateY(58px); opacity: 1; }
    }
    .qr-laser-line {
      animation: qrLaserSweep 2s ease-in-out infinite;
    }

    @keyframes badgePulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.28); }
      100% { transform: scale(1); }
    }
    .animate-badge-pulse {
      animation: badgePulse 0.28s ease-out;
    }

    /* Scrollbars oscuros estilizados */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #09090B;
    }
    ::-webkit-scrollbar-thumb {
      background: #27272A;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #3F3F46;
    }
  </style>
</head>

<body class="bg-[#050507] text-zinc-100 font-sans min-h-screen flex flex-col antialiased selection:bg-indigo-600 selection:text-white">

  <!-- ========================================================================
       1. BARRA SUPERIOR DE SIMULACIÓN Y ARQUITECTURA RESPONSIVA
       ======================================================================== -->
  <header id="labSimulatorToolbar" class="hidden sticky top-0 z-40 bg-[#09090B]/95 backdrop-blur-md border-b border-[#27272A]">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 py-2.5 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-2.5">

      <!-- Identificador y Métrica en Vivo -->
      <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5 min-w-0">
          <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center font-mono font-bold text-xs text-white shrink-0 shadow-md shadow-indigo-500/20">
            N4S
          </div>
          <div class="min-w-0">
            <h1 class="text-xs sm:text-sm font-extrabold tracking-tight text-white truncate">
              LABORATORIO RESPONSIVO • NEED FOR STREET
            </h1>
            <p class="text-[11px] text-zinc-400 truncate">
              Simulador Multi-Dispositivo &amp; Cuadrícula 10 Módulos
            </p>
          </div>
        </div>

        <!-- Contador en vivo de ancho y columnas -->
        <div class="flex items-center gap-2 bg-[#121215] border border-[#27272A] px-2.5 py-1.5 rounded-lg font-mono text-[11px] shrink-0">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
          <span id="simWidthIndicator" class="text-zinc-200 font-semibold">100%</span>
          <span class="text-zinc-600">|</span>
          <span id="simColsIndicator" class="text-blue-400 font-semibold">5 cols</span>
        </div>
      </div>

      <!-- Controles de Dispositivo, Layouts CSS Grid, Guías y Ver CSS -->
      <div class="flex flex-wrap items-center gap-2">

        <!-- Selector de Dispositivo -->
        <div class="inline-flex bg-[#121215] p-1 rounded-xl border border-[#27272A] gap-1" role="group" aria-label="Ancho de dispositivo">
          <button
            type="button"
            data-sim-device="mobile"
            class="sim-device-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all text-zinc-400 hover:text-white hover:bg-[#18181B]"
          >
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="6" y="2" width="12" height="20" rx="2"></rect>
              <line x1="12" y1="18" x2="12.01" y2="18"></line>
            </svg>
            <span>Teléfono (375px)</span>
          </button>

          <button
            type="button"
            data-sim-device="tablet"
            class="sim-device-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all text-zinc-400 hover:text-white hover:bg-[#18181B]"
          >
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="2" width="16" height="20" rx="2"></rect>
              <line x1="12" y1="18" x2="12.01" y2="18"></line>
            </svg>
            <span>Tablet (768px)</span>
          </button>

          <button
            type="button"
            data-sim-device="desktop"
            class="sim-device-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-blue-600 text-white shadow-sm"
          >
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="3" width="20" height="14" rx="2"></rect>
              <line x1="8" y1="21" x2="16" y2="21"></line>
              <line x1="12" y1="17" x2="12" y2="21"></line>
            </svg>
            <span>PC (100%)</span>
          </button>
        </div>

        <!-- Selector de 3 Layouts CSS Grid -->
        <div id="gridLayoutSelectorGroup" class="inline-flex flex-wrap bg-[#121215] p-1 rounded-xl border border-[#27272A] gap-1" role="group" aria-label="Arquitectura CSS Grid">
          <button
            type="button"
            data-grid-mode="breakpoints"
            class="grid-mode-btn px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-indigo-600 text-white"
          >
            Breakpoints (5×2 / 2×5)
          </button>
          <button
            type="button"
            data-grid-mode="autofit"
            class="grid-mode-btn px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all text-zinc-400 hover:text-white hover:bg-[#18181B]"
          >
            Fluido Auto-Fit (minmax)
          </button>
          <button
            type="button"
            data-grid-mode="bento"
            class="grid-mode-btn px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all text-zinc-400 hover:text-white hover:bg-[#18181B]"
          >
            Bento Modular
          </button>
        </div>

        <!-- Botón Guías Grid -->
        <button
          type="button"
          id="btnToggleGuides"
          class="px-3 py-1.5 rounded-xl text-xs font-semibold border border-[#27272A] bg-[#121215] text-zinc-300 hover:text-white hover:border-blue-500/60 transition-all"
        >
          Guías Grid
        </button>

        <!-- Botón Ver CSS -->
        <button
          type="button"
          id="btnOpenCssModal"
          class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white text-xs font-semibold transition-all"
        >
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="16 18 22 12 16 6"></polyline>
            <polyline points="8 6 2 12 8 18"></polyline>
          </svg>
          <span>Ver CSS</span>
        </button>
      </div>
    </div>
  </header>

  <!-- ========================================================================
       2. MARCO PRINCIPAL DE LA APP "NEED FOR STREET"
       ======================================================================== -->
  <main class="flex-1 w-full max-w-none mx-0 px-0 py-0 flex flex-col items-stretch">

    <div
      id="appViewportFrame"
      style="width: 100%; max-width: 100%;"
      class="nfs-viewport-container bg-[#09090B] text-zinc-100 min-h-screen w-full rounded-none border-0 shadow-none flex flex-col"
    >

      <!-- ====================================================================
           MENÚ LATERAL DESPLEGABLE (HAMBURGUESA — 10 MÓDULOS + TABLERO)
           ==================================================================== -->
      <div id="sideNavBackdrop" class="hidden absolute inset-0 z-40 bg-black/70 backdrop-blur-[2px]">
        <aside class="w-72 max-w-[85%] h-full bg-[#121215] border-r border-[#27272A] p-4 flex flex-col justify-between">
          <div class="overflow-y-auto pr-1">
            <div class="flex items-center justify-between pb-3.5 border-b border-[#27272A]">
              <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <span class="font-black tracking-wider text-xs text-white uppercase">NEED 4 STREET</span>
              </div>
              <button type="button" id="btnCloseSideNav" class="p-1.5 rounded-lg text-zinc-400 hover:text-white hover:bg-[#18181B]" aria-label="Cerrar menú">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </button>
            </div>

            <div class="mt-3 flex flex-col gap-1">
              <button type="button" data-route="dashboard" class="side-nav-item w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white text-left">
                <span>Tablero Principal</span>
                <span class="font-mono text-[10px] bg-white/20 px-1.5 py-0.5 rounded">10</span>
              </button>
            </div>

            <p class="mt-4 mb-1.5 px-2 text-[10px] font-bold uppercase tracking-widest text-zinc-500">
              Módulos Operativos
            </p>
            <nav id="sideNavModulesList" class="flex flex-col gap-1"></nav>
          </div>

          <div class="pt-3 border-t border-[#27272A] flex items-center justify-between text-[11px] text-zinc-400">
            <span id="sideNavUserFooter" class="truncate">Sesión: <strong class="text-white">Carlos Méndez</strong></span>
            <span class="text-emerald-400 font-mono shrink-0">ONLINE</span>
          </div>
        </aside>
      </div>

      <!-- ====================================================================
           SELECTOR RÁPIDO DE SESIÓN DE USUARIO (POPOVER EN HEADER)
           ==================================================================== -->
      <div id="userSwitcherBackdrop" class="hidden absolute inset-0 z-40 bg-black/40"></div>
      <div id="userSwitcherPopover" class="hidden absolute right-3 sm:right-6 top-16 z-50 w-72 max-w-[90%] bg-[#121215] border border-[#27272A] rounded-2xl p-3.5 shadow-2xl flex flex-col gap-2.5">
        <div class="flex items-center justify-between pb-2 border-b border-[#27272A]">
          <span class="text-[11px] font-extrabold uppercase tracking-wider text-zinc-400">Cambiar Sesión Activa</span>
          <button type="button" id="btnCloseUserPopover" class="text-zinc-400 hover:text-white text-xs font-bold px-1.5">Cerrar</button>
        </div>
        <div id="userSwitcherList" class="flex flex-col gap-1.5 max-h-56 overflow-y-auto"></div>
        <button
          type="button"
          data-route="usuarios"
          id="btnPopoverManageUsers"
          class="mt-1 w-full py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold text-center transition-colors"
        >
          Administrar Usuarios
        </button>
        <button
          type="button"
          id="btnLogout"
          class="w-full py-2 px-3 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs font-bold text-center transition-colors inline-flex items-center justify-center gap-2"
        >
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M10 17l5-5-5-5"></path>
            <path d="M15 12H3"></path>
            <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"></path>
          </svg>
          Cerrar sesión
        </button>
      </div>

      <!-- ====================================================================
           CARRITO RÁPIDO DESDE HEADER (DRAWER EN PC/TABLET | BOTTOM SHEET EN MÓVIL)
           ==================================================================== -->
      <div id="quickCartBackdrop" class="hidden absolute inset-0 z-40 bg-black/70 backdrop-blur-[2px]"></div>

      <aside id="quickCartPanel" aria-label="Carrito rápido" class="nfs-quick-drawer z-50 bg-[#121215] flex flex-col shadow-2xl">
        <div id="quickCartSheetHandle" class="hidden pt-2.5 pb-1 flex justify-center cursor-pointer shrink-0">
          <span class="w-12 h-1.5 rounded-full bg-zinc-700"></span>
        </div>

        <div class="px-4 py-3 border-b border-[#27272A] flex items-center justify-between gap-2 shrink-0">
          <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-8 h-8 rounded-xl bg-blue-600/20 border border-blue-500/30 text-blue-400 flex items-center justify-center shrink-0">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
              </svg>
            </div>
            <div class="min-w-0">
              <h2 class="text-sm font-extrabold text-white truncate">Carrito Rápido</h2>
              <p id="quickCartModeSubtitle" class="text-[11px] text-zinc-400 truncate">Drawer Lateral • POS</p>
            </div>
          </div>
          <button type="button" id="btnCloseQuickCart" class="p-2 rounded-xl text-zinc-400 hover:text-white hover:bg-[#18181B]" aria-label="Cerrar carrito rápido">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>

        <div class="p-3 bg-[#18181B] border-b border-[#27272A] shrink-0">
          <form id="drawerQrForm" class="flex items-center gap-2">
            <input
              type="text"
              id="drawerQrInput"
              placeholder="Código QR (ej. QR-OVS-01)"
              class="flex-1 min-w-0 px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-blue-500"
            />
            <button type="submit" class="px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shrink-0 transition-colors">
              + QR
            </button>
          </form>
        </div>

        <div id="quickCartItemsList" class="flex-1 overflow-y-auto p-3.5 flex flex-col gap-2"></div>

        <div class="p-3.5 bg-[#18181B] border-t border-[#27272A] flex flex-col gap-2.5 shrink-0">
          <div>
            <span class="block text-[10px] font-bold uppercase tracking-wider text-zinc-400 mb-1">Método de Pago</span>
            <div class="grid grid-cols-3 gap-1">
              <button type="button" data-pay-method="Efectivo" class="pay-method-btn py-1.5 px-2 rounded-lg text-[11px] font-bold bg-blue-600 text-white">Efectivo</button>
              <button type="button" data-pay-method="Transferencia" class="pay-method-btn py-1.5 px-2 rounded-lg text-[11px] font-semibold bg-[#09090B] text-zinc-300 border border-[#27272A]">Transfer.</button>
              <button type="button" data-pay-method="Terminal" class="pay-method-btn py-1.5 px-2 rounded-lg text-[11px] font-semibold bg-[#09090B] text-zinc-300 border border-[#27272A]">Terminal</button>
            </div>
          </div>

          <div id="quickCartFeeRow" class="hidden flex items-center justify-between text-[11px] text-amber-400">
            <span id="quickCartFeeLabel">Comisión Terminal (3.5%)</span>
            <span id="quickCartFeeAmount" class="font-mono font-bold">-$0.00</span>
          </div>

          <div class="flex items-center justify-between text-xs text-zinc-300">
            <span>Neto a recibir</span>
            <span id="quickCartTotalAmount" class="font-mono text-base font-extrabold text-emerald-400">$0.00 MXN</span>
          </div>

          <div class="grid grid-cols-2 gap-2">
            <button
              type="button"
              id="btnQuickGoToPos"
              class="py-2.5 px-3 rounded-xl bg-[#09090B] hover:bg-zinc-900 border border-[#27272A] text-zinc-200 text-xs font-bold transition-colors"
            >
              Módulo POS
            </button>
            <button
              type="button"
              id="btnQuickCheckout"
              class="py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 disabled:opacity-40 disabled:pointer-events-none text-white text-xs font-bold transition-colors"
            >
              Cobrar Venta
            </button>
          </div>
        </div>
      </aside>

      <!-- ====================================================================
           HEADER PRINCIPAL DE LA APP CON LOGOTIPO BRUSH NEED 4 STREET
           ==================================================================== -->
      <div class="sticky top-0 z-30 bg-[#121215]/95 backdrop-blur-md border-b border-[#27272A] px-3 sm:px-6 py-2.5 flex items-center justify-between gap-2 shrink-0">
        <!-- Izquierda: Botón Hamburguesa + Logotipo Brush NEED 4 STREET -->
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
          <button
            type="button"
            id="btnOpenSideNav"
            class="p-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-zinc-200 transition-colors shrink-0"
            aria-label="Abrir menú de navegación"
          >
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
              <line x1="4" y1="7" x2="20" y2="7"></line>
              <line x1="4" y1="12" x2="20" y2="12"></line>
              <line x1="4" y1="17" x2="20" y2="17"></line>
            </svg>
          </button>

          <button type="button" id="btnHeaderBrand" class="flex items-center gap-2.5 text-left min-w-0 group focus:outline-none" title="Ir al Tablero Principal">
            <svg class="h-8 sm:h-9 w-auto shrink-0 text-white group-hover:text-blue-400 transition-colors" viewBox="0 0 240 68" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="NEED 4 STREET - HECHO PARA DESTACAR">
              <path d="M138 6L84 36L146 39L74 60" stroke="#3B82F6" stroke-width="5.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M134 11L94 34H142" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
              <text x="12" y="29" fill="currentColor" font-family="Inter, sans-serif" font-weight="900" font-style="italic" font-size="22" letter-spacing="1.2">NEED</text>
              <text x="148" y="34" fill="currentColor" font-family="Inter, sans-serif" font-weight="900" font-style="italic" font-size="22" letter-spacing="1">STREET</text>
              <text x="14" y="62" fill="#A1A1AA" font-family="Inter, sans-serif" font-weight="700" font-size="7.5" letter-spacing="3.6">HECHO PARA DESTACAR</text>
            </svg>
          </button>
        </div>

        <!-- Derecha: Selector Rápido Usuario Activo + Carrito Rápido + Acceso Usuarios/Admin -->
        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
          <button
            type="button"
            id="btnHeaderUserSwitcher"
            class="inline-flex items-center gap-1.5 px-2.5 py-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] hover:border-indigo-500/50 text-xs font-bold text-zinc-100 transition-all max-w-[165px] sm:max-w-[235px]"
            title="Cambiar usuario activo"
          >
            <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
            <span id="headerActiveUserText" class="truncate">Carlos Méndez · Admin</span>
            <svg class="w-3.5 h-3.5 text-zinc-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </button>

          <button
            type="button"
            id="btnHeaderQuickCart"
            class="relative p-2.5 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] hover:border-blue-500/50 text-zinc-100 transition-all"
            aria-label="Abrir carrito rápido"
          >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span
              id="headerCartBadge"
              class="absolute -top-1.5 -right-1.5 min-w-[19px] h-[19px] px-1 rounded-full bg-blue-600 text-white font-mono text-[10px] font-bold flex items-center justify-center shadow"
            >
              0
            </span>
          </button>

          <button
            type="button"
            data-route="usuarios"
            class="p-2.5 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] hover:border-indigo-500/50 text-zinc-200 transition-all"
            title="Administrador de Usuarios"
            aria-label="Administrador de Usuarios"
          >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- ====================================================================
           BARRA DE NAVEGACIÓN SECUNDARIA (VISIBLE DENTRO DE CADA MÓDULO)
           ==================================================================== -->
      <div id="moduleSubheaderBar" class="hidden bg-[#18181B] border-b border-[#27272A] px-3.5 sm:px-6 py-2.5 flex flex-wrap items-center justify-between gap-2 shrink-0">
        <div class="flex items-center gap-2.5 min-w-0">
          <button
            type="button"
            id="btnBackToDashboard"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#121215] hover:bg-zinc-800 border border-[#27272A] text-xs font-bold text-zinc-100 transition-colors shrink-0"
          >
            <span>← Tablero Principal</span>
          </button>
          <div class="min-w-0">
            <h2 id="activeModuleTitle" class="text-sm sm:text-base font-extrabold text-white truncate">Módulo</h2>
          </div>
        </div>
        <span id="activeModuleTag" class="font-mono text-[11px] px-2.5 py-1 rounded-lg bg-[#121215] border border-[#27272A] text-zinc-400">
          NEED FOR STREET OS
        </span>
      </div>

      <!-- ====================================================================
           CONTENEDOR PRINCIPAL DE VISTAS (TABLERO + 10 MÓDULOS)
           ==================================================================== -->
      <div class="flex-1 p-3.5 sm:p-6 flex flex-col">

        <!-- Banner de Guías Grid -->
        <div id="gridGuidesIndicatorBar" class="hidden mb-4 p-2.5 rounded-xl bg-blue-950/40 border border-blue-500/40 flex flex-wrap items-center justify-between gap-2 font-mono text-[11px] text-blue-300">
          <span class="font-bold">GUÍAS DE CUADRÍCULA ACTIVAS (10 MÓDULOS)</span>
          <div id="gridTracksBadges" class="flex flex-wrap gap-1.5"></div>
        </div>

        <!-- ==================================================================
             VISTA 0: TABLERO PRINCIPAL (10 TARJETAS RESPONSIVAS)
             ================================================================== -->
        <section id="view-dashboard" class="flex-1 flex flex-col justify-center">
          <div id="dashboardGrid" class="grid-mode-bento"></div>
        </section>

        <!-- ==================================================================
             MÓDULO 1: STOCK (PRODUCTOS DISPONIBLES + DESCARGA PEGATINA QR PNG)
             ================================================================== -->
        <section id="view-stock" class="hidden flex flex-col gap-4">
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5 sm:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="relative flex-1 min-w-0">
              <svg class="w-4 h-4 text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <input
                type="text"
                id="stockSearchInput"
                placeholder="Buscar por nombre, color, talla o código QR / SKU..."
                class="w-full pl-9 pr-3 py-2.5 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-blue-500"
              />
            </div>
            <div class="flex items-center gap-2 shrink-0">
              <button
                type="button"
                data-route="registro"
                class="px-3.5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-colors"
              >
                + Registrar Producto
              </button>
            </div>
          </div>

          <div id="stockCategoryFilters" class="flex flex-wrap items-center gap-1.5" role="group" aria-label="Categorías de Stock"></div>
          <div id="stockProductsGrid" class="cq-grid-3"></div>
        </section>

        <!-- ==================================================================
             MÓDULO 2: MATERIA PRIMA (CATEGORÍAS EXACTAS, TALLA S-XXXL Y COLORES HEX)
             ================================================================== -->
        <section id="view-materia" class="hidden flex flex-col gap-4">
          <div class="cq-split-main">
            <!-- Formulario de Alta de Materia Prima -->
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 h-fit">
              <h3 class="text-sm font-extrabold text-white">Alta de Materia Prima / Artículos en Blanco</h3>
              <p class="text-xs text-zinc-400 mt-0.5 mb-4">Registra playeras, hoodies, tote bags, lámina/aluminio o llaveros MDF.</p>

              <form id="formAddRawMaterial" class="flex flex-col gap-3">
                <div>
                  <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nombre del artículo o insumo</label>
                  <input
                    type="text"
                    id="rmName"
                    required
                    placeholder="Ej. Playera Oversize 240g en blanco"
                    class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-blue-500"
                  />
                </div>

                <!-- Categoría y Subtipo condicional (Solo Playeras) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Categoría</label>
                    <select id="rmCategory" class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white focus:outline-none focus:border-blue-500">
                      <option value="Playeras">Playeras</option>
                      <option value="Hoodies">Hoodies</option>
                      <option value="Tote bag">Tote bag</option>
                      <option value="Lámina / aluminio">Lámina / aluminio</option>
                      <option value="Llavero / MDF">Llavero / MDF</option>
                    </select>
                  </div>

                  <!-- Tipo de Playera (Visible únicamente cuando Categoría === 'Playeras') -->
                  <div id="rmShirtTypeWrapper">
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Tipo de Playera</label>
                    <select id="rmShirtType" class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white focus:outline-none focus:border-blue-500">
                      <option value="Oversize">Oversize</option>
                      <option value="Regular fit">Regular fit</option>
                      <option value="Infantil">Infantil</option>
                      <option value="Polo">Polo</option>
                      <option value="DryFit">DryFit</option>
                    </select>
                  </div>
                </div>

                <!-- Talla / Medida condicional según Categoría -->
                <div>
                  <!-- Lista cerrada S-XXXL para Playeras y Hoodies -->
                  <div id="rmApparelSizeWrapper">
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Talla (Lista cerrada S – XXXL)</label>
                    <select id="rmApparelSize" class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500">
                      <option value="S">S</option>
                      <option value="M">M</option>
                      <option value="L" selected>L</option>
                      <option value="XL">XL</option>
                      <option value="XXL">XXL</option>
                      <option value="XXXL">XXXL</option>
                    </select>
                  </div>

                  <!-- Medida editable para Lámina / aluminio (Cuadros) -->
                  <div id="rmCustomMeasureWrapper" class="hidden">
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Medida de Lámina / Cuadro</label>
                    <input
                      type="text"
                      id="rmCustomMeasure"
                      value="30×40 cm"
                      placeholder="Ej. 30×40 cm, 40×60 cm"
                      class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500"
                    />
                  </div>

                  <!-- Medida fija para Tote bag y Llavero / MDF -->
                  <div id="rmFixedMeasureWrapper" class="hidden">
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Medida Única</label>
                    <div id="rmFixedMeasureBadge" class="px-3 py-2 rounded-xl bg-[#18181B] border border-[#27272A] font-mono text-xs text-zinc-300">
                      35×40 cm (Única)
                    </div>
                  </div>
                </div>

                <!-- Selector de Color con Circulito + Alta de Color HEX (Solo Playeras, Hoodies y Tote bag) -->
                <div id="rmColorSection" class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex flex-col gap-2.5">
                  <div class="flex items-center justify-between gap-2">
                    <span class="text-[11px] font-semibold text-zinc-300">
                      Color seleccionado: <strong id="rmSelectedColorLabel" class="text-white">Negro</strong>
                    </span>
                    <button
                      type="button"
                      id="btnToggleNewColorForm"
                      class="text-[11px] font-bold text-indigo-400 hover:text-indigo-300"
                    >
                      + Nuevo color HEX
                    </button>
                  </div>

                  <div id="rmColorSwatchesList" class="flex flex-wrap gap-1.5"></div>

                  <!-- Mini formulario para registrar un color nuevo con Nombre + Código HEX -->
                  <div id="rmNewColorCreator" class="hidden pt-2.5 border-t border-[#27272A] flex flex-col gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Registrar color en gama global</span>
                    <div class="flex items-center gap-2">
                      <input
                        type="color"
                        id="rmNewColorPicker"
                        value="#2563EB"
                        class="w-9 h-9 rounded-lg bg-transparent border border-[#27272A] cursor-pointer shrink-0"
                        title="Elegir tono"
                      />
                      <input
                        type="text"
                        id="rmNewColorName"
                        placeholder="Nombre (ej. Rojo Vino)"
                        class="flex-1 min-w-0 px-2.5 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] text-xs text-white"
                      />
                      <input
                        type="text"
                        id="rmNewColorHex"
                        value="#2563EB"
                        maxlength="7"
                        placeholder="#HEX"
                        class="w-20 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-zinc-200 uppercase"
                      />
                    </div>
                    <button
                      type="button"
                      id="btnSaveNewPaletteColor"
                      class="w-full py-1.5 px-3 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold"
                    >
                      Guardar Color en Paleta
                    </button>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Cantidad inicial</label>
                    <input
                      type="number"
                      id="rmQty"
                      min="1"
                      value="20"
                      required
                      class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500"
                    />
                  </div>
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Costo unitario ($ MXN)</label>
                    <input
                      type="number"
                      id="rmCost"
                      min="1"
                      step="0.5"
                      value="135"
                      required
                      class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500"
                    />
                  </div>
                </div>

                <button
                  type="submit"
                  class="mt-1 w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition-colors"
                >
                  Guardar Materia Prima
                </button>
              </form>
            </div>

            <!-- Listado de Inventario de Materia Prima -->
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col gap-3 min-w-0">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                  <h3 class="text-sm font-extrabold text-white">Inventario de Materia Prima</h3>
                  <p class="text-xs text-zinc-400">Alerta automática con menos de 10 unidades y registro de usuario.</p>
                </div>
                <span id="rmLowStockSummary" class="font-mono text-[11px] px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-400">
                  0 alertas
                </span>
              </div>

              <div id="rawMaterialsList" class="flex flex-col gap-2.5"></div>
            </div>
          </div>
        </section>

        <!-- ==================================================================
             MÓDULO 3: FINANZAS (FILTRO FECHAS + DESCARGA PDF CON LOGO + GRÁFICAS)
             ================================================================== -->
        <section id="view-finanzas" class="hidden flex flex-col gap-4">
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5 sm:p-4 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div class="grid grid-cols-2 sm:flex sm:items-end gap-2.5">
              <div>
                <label for="finDateFrom" class="block text-[11px] font-semibold text-zinc-400 mb-1">Desde fecha</label>
                <input
                  type="date"
                  id="finDateFrom"
                  class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500"
                />
              </div>
              <div>
                <label for="finDateTo" class="block text-[11px] font-semibold text-zinc-400 mb-1">Hasta fecha</label>
                <input
                  type="date"
                  id="finDateTo"
                  class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500"
                />
              </div>
              <button
                type="button"
                id="btnFinResetDates"
                class="col-span-2 sm:col-span-1 px-3 py-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-xs font-semibold text-zinc-300"
              >
                Todo el periodo
              </button>
            </div>

            <button
              type="button"
              id="btnDownloadFinancePdf"
              class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white text-xs font-extrabold transition-all shrink-0"
            >
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="12" y1="18" x2="12" y2="12"></line>
                <polyline points="9 15 12 18 15 15"></polyline>
              </svg>
              <span>Descargar Reporte Finanzas (PDF)</span>
            </button>
          </div>

          <div id="financeKpiGrid" class="cq-grid-5-kpi"></div>

          <div class="cq-split-main">
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col gap-4 min-w-0">
              <div>
                <h3 class="text-sm font-extrabold text-white">Ventas por Tipo de Artículo</h3>
                <p id="finRangeSubtitle" class="text-xs text-zinc-400">Ingresos brutos generados por línea de producto y personalizados.</p>
              </div>
              <div id="financeBarChart" class="flex flex-col gap-3"></div>
            </div>

            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col gap-3 min-w-0">
              <div>
                <h3 class="text-sm font-extrabold text-white">Rentabilidad por Línea</h3>
                <p class="text-xs text-zinc-400">Unidades, ingresos, costos de elaboración y margen neto.</p>
              </div>
              <div class="overflow-x-auto rounded-xl border border-[#27272A]">
                <table class="w-full text-left border-collapse text-xs">
                  <thead>
                    <tr class="bg-[#18181B] border-b border-[#27272A] text-zinc-400 font-semibold">
                      <th class="py-2.5 px-3">Tipo de Artículo</th>
                      <th class="py-2.5 px-2 text-right">Uds.</th>
                      <th class="py-2.5 px-2 text-right">Ingresos</th>
                      <th class="py-2.5 px-2 text-right">Costos</th>
                      <th class="py-2.5 px-3 text-right">Margen</th>
                    </tr>
                  </thead>
                  <tbody id="financeProfitabilityBody" class="divide-y divide-[#27272A]"></tbody>
                </table>
              </div>
            </div>
          </div>
        </section>

        <!-- ==================================================================
             MÓDULO 4: CARRITO (POS + ESCÁNER QR + COMISIÓN TERMINAL)
             ================================================================== -->
        <section id="view-carrito" class="hidden flex flex-col gap-4">
          <div class="cq-split-main">
            <div class="flex flex-col gap-4 min-w-0">
              <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col gap-4">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <span class="inline-block font-mono text-[10px] uppercase tracking-wider px-2 py-0.5 rounded bg-blue-500/15 text-blue-400 border border-blue-500/30 mb-1">
                      Lector Óptico POS
                    </span>
                    <h3 class="text-sm sm:text-base font-extrabold text-white">Agregar Producto por Código QR</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Escanea la pegatina QR de la prenda o usa los accesos directos.</p>
                  </div>

                  <div class="relative w-16 h-16 rounded-xl bg-[#09090B] border border-blue-500/40 flex items-center justify-center shrink-0 overflow-hidden">
                    <svg class="w-10 h-10 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <rect x="3" y="3" width="7" height="7"></rect>
                      <rect x="14" y="3" width="7" height="7"></rect>
                      <rect x="3" y="14" width="7" height="7"></rect>
                      <path d="M14 14h3v3h-3zM18 18h3v3h-3zM14 20h2"></path>
                    </svg>
                    <div class="qr-laser-line absolute left-1 right-1 top-0 h-0.5 bg-emerald-400 shadow-[0_0_8px_#10B981]"></div>
                  </div>
                </div>

                <form id="posQrScannerForm" class="flex flex-col sm:flex-row gap-2">
                  <input
                    type="text"
                    id="posQrInput"
                    placeholder="Código QR (ej. QR-OVS-01, QR-REG-02, QR-INF-03...)"
                    class="flex-1 min-w-0 px-3.5 py-2.5 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-emerald-500"
                  />
                  <button
                    type="submit"
                    class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white text-xs font-extrabold shrink-0 transition-all"
                  >
                    Escanear / Agregar
                  </button>
                </form>

                <div class="p-2.5 rounded-xl bg-[#09090B] border border-[#27272A] flex items-center justify-between gap-2 text-xs">
                  <span class="text-zinc-400">Última lectura:</span>
                  <span id="qrLastReadLabel" class="font-mono font-semibold text-zinc-300 truncate">En espera de código QR...</span>
                </div>

                <div>
                  <p class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 mb-2">
                    Escaneo Rápido de 1 Clic
                  </p>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <button type="button" data-quick-qr="QR-OVS-01" class="quick-qr-btn p-2.5 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] hover:border-blue-500/50 text-left flex items-center justify-between gap-2 transition-all">
                      <span class="text-xs font-bold text-white truncate">QR Playera Oversize</span>
                      <span class="font-mono text-[10px] text-blue-400 shrink-0">QR-OVS-01</span>
                    </button>
                    <button type="button" data-quick-qr="QR-REG-02" class="quick-qr-btn p-2.5 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] hover:border-blue-500/50 text-left flex items-center justify-between gap-2 transition-all">
                      <span class="text-xs font-bold text-white truncate">QR Regular Fit</span>
                      <span class="font-mono text-[10px] text-blue-400 shrink-0">QR-REG-02</span>
                    </button>
                    <button type="button" data-quick-qr="QR-INF-03" class="quick-qr-btn p-2.5 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] hover:border-blue-500/50 text-left flex items-center justify-between gap-2 transition-all">
                      <span class="text-xs font-bold text-white truncate">QR Playera Infantil</span>
                      <span class="font-mono text-[10px] text-blue-400 shrink-0">QR-INF-03</span>
                    </button>
                    <button type="button" data-quick-qr="QR-HOD-04" class="quick-qr-btn p-2.5 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] hover:border-blue-500/50 text-left flex items-center justify-between gap-2 transition-all">
                      <span class="text-xs font-bold text-white truncate">QR Hoodie Boxy</span>
                      <span class="font-mono text-[10px] text-blue-400 shrink-0">QR-HOD-04</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col justify-between gap-4 min-w-0">
              <div>
                <div class="flex items-center justify-between pb-3 border-b border-[#27272A]">
                  <div>
                    <h3 class="text-sm font-extrabold text-white">Ticket de Venta Actual</h3>
                    <span id="posCashierIndicator" class="text-[11px] text-zinc-400">Cajero: Carlos Méndez</span>
                  </div>
                  <button type="button" id="btnClearPosCart" class="text-[11px] font-semibold text-zinc-400 hover:text-rose-400 transition-colors">
                    Vaciar lista
                  </button>
                </div>

                <div id="posCartItemsList" class="mt-3 flex flex-col gap-2.5 max-h-[290px] overflow-y-auto pr-1"></div>
              </div>

              <div class="pt-3 border-t border-[#27272A] flex flex-col gap-3">
                <div>
                  <div class="flex items-center justify-between mb-1.5">
                    <label class="text-[11px] font-semibold text-zinc-400">Método de Pago (Obligatorio)</label>
                    <button type="button" data-route="reportes" class="text-[10px] text-blue-400 hover:underline">
                      Editar % Terminal
                    </button>
                  </div>
                  <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5" role="group" aria-label="Método de pago">
                    <button type="button" data-pay-method="Efectivo" class="pay-method-btn py-2 px-2 rounded-xl text-xs font-bold bg-blue-600 text-white">Efectivo</button>
                    <button type="button" data-pay-method="Transferencia" class="pay-method-btn py-2 px-2 rounded-xl text-xs font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]">Transferencia</button>
                    <button type="button" data-pay-method="Terminal" class="pay-method-btn py-2 px-2 rounded-xl text-xs font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]">Terminal</button>
                    <button type="button" data-pay-method="Dividido" class="pay-method-btn py-2 px-2 rounded-xl text-xs font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]">Dividir pago</button>
                  </div>
                </div>

                <!-- Panel de Pago Dividido -->
                <div id="posSplitPaymentBox" class="hidden bg-[#09090B] border border-blue-500/40 rounded-xl p-3 flex flex-col gap-2.5 text-xs">
                  <div class="flex items-center justify-between gap-2">
                    <span class="font-extrabold text-blue-400">Distribución de Pago Dividido</span>
                    <span id="posSplitStatusBadge" class="font-mono text-[10px] font-bold px-2 py-0.5 rounded bg-amber-500/15 text-amber-300">
                      Falta: $0.00
                    </span>
                  </div>

                  <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <div class="p-2 rounded-lg bg-[#121215] border border-[#27272A] flex flex-col gap-1">
                      <div class="flex items-center justify-between">
                        <label for="splitPayEfectivo" class="text-[11px] font-semibold text-zinc-300">Efectivo ($)</label>
                        <button type="button" data-fill-split="Efectivo" class="text-[10px] font-bold text-blue-400 hover:underline">Resto</button>
                      </div>
                      <input
                        type="number"
                        id="splitPayEfectivo"
                        min="0"
                        step="0.01"
                        value="0"
                        class="w-full px-2 py-1.5 rounded-lg bg-[#09090B] border border-[#27272A] font-mono text-xs text-white text-right focus:outline-none focus:border-blue-500"
                      />
                    </div>

                    <div class="p-2 rounded-lg bg-[#121215] border border-[#27272A] flex flex-col gap-1">
                      <div class="flex items-center justify-between">
                        <label for="splitPayTransferencia" class="text-[11px] font-semibold text-zinc-300">Transferencia ($)</label>
                        <button type="button" data-fill-split="Transferencia" class="text-[10px] font-bold text-blue-400 hover:underline">Resto</button>
                      </div>
                      <input
                        type="number"
                        id="splitPayTransferencia"
                        min="0"
                        step="0.01"
                        value="0"
                        class="w-full px-2 py-1.5 rounded-lg bg-[#09090B] border border-[#27272A] font-mono text-xs text-white text-right focus:outline-none focus:border-blue-500"
                      />
                    </div>

                    <div class="p-2 rounded-lg bg-[#121215] border border-[#27272A] flex flex-col gap-1">
                      <div class="flex items-center justify-between">
                        <label for="splitPayTerminal" class="text-[11px] font-semibold text-zinc-300">Terminal ($)</label>
                        <button type="button" data-fill-split="Terminal" class="text-[10px] font-bold text-blue-400 hover:underline">Resto</button>
                      </div>
                      <input
                        type="number"
                        id="splitPayTerminal"
                        min="0"
                        step="0.01"
                        value="0"
                        class="w-full px-2 py-1.5 rounded-lg bg-[#09090B] border border-[#27272A] font-mono text-xs text-white text-right focus:outline-none focus:border-blue-500"
                      />
                    </div>
                  </div>
                </div>

                <div class="bg-[#09090B] border border-[#27272A] rounded-xl p-3 flex flex-col gap-1.5 text-xs">
                  <div class="flex justify-between text-zinc-400">
                    <span>Subtotal Bruto</span>
                    <span id="posSubtotalLabel" class="font-mono text-zinc-200">$0.00 MXN</span>
                  </div>
                  <div id="posTerminalFeeRow" class="hidden flex justify-between text-amber-400 font-semibold">
                    <span id="posTerminalFeeLabel">Comisión Terminal (3.5%)</span>
                    <span id="posTerminalFeeAmount" class="font-mono">-$0.00 MXN</span>
                  </div>
                  <div class="flex justify-between text-sm font-extrabold text-white pt-1.5 border-t border-[#27272A]">
                    <span>Total Neto Venta</span>
                    <span id="posTotalLabel" class="font-mono text-emerald-400">$0.00 MXN</span>
                  </div>
                </div>

                <button
                  type="button"
                  id="btnCompletePosSale"
                  class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 disabled:opacity-40 disabled:pointer-events-none text-white text-xs sm:text-sm font-extrabold shadow-lg shadow-emerald-950/40 transition-all"
                >
                  Confirmar y Registrar Venta
                </button>
              </div>
            </div>
          </div>
        </section>

        <!-- ==================================================================
             MÓDULO 5: COTIZACIÓN MULTI-GRUPO + DESCUENTO SELECTIVO POR GRUPO + PDF
             ================================================================== -->
        <section id="view-cotizacion" class="hidden flex flex-col gap-4">
          <div class="cq-split-main">
            <!-- Columna Izquierda: Constructor de Grupos de Prendas/Artículos -->
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col gap-4 min-w-0">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                  <h3 class="text-sm sm:text-base font-extrabold text-white">Cotizador Multi-Grupo &amp; PDF Oficial</h3>
                  <p class="text-xs text-zinc-400">Generada por: <strong id="quoteAuthorBadge" class="text-indigo-400">Carlos Méndez (Administrador)</strong></p>
                </div>

                <div class="flex flex-wrap items-center gap-1.5">
                  <button
                    type="button"
                    id="btnClearAllQuoteGroups"
                    class="px-2.5 py-1.5 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-zinc-400 hover:text-white text-[11px] font-semibold"
                  >
                    Limpiar grupos
                  </button>
                </div>
              </div>

              <!-- Datos del Cliente -->
              <div class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex flex-col gap-2.5">
                <div class="flex flex-wrap items-center justify-between gap-2">
                  <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-400">Datos del Cliente</span>
                  <select id="quoteExistingClientSelect" class="px-2.5 py-1 rounded-lg bg-[#18181B] border border-[#27272A] text-[11px] text-zinc-200 focus:outline-none focus:border-indigo-500">
                    <option value="">-- Cliente nuevo o seleccionar --</option>
                  </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                  <div class="sm:col-span-2">
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nombre del Cliente / Marca</label>
                    <input
                      type="text"
                      id="quoteClientInput"
                      value="Colectivo Urbano MX"
                      placeholder="Ej. Estudio Drift / Cliente"
                      class="w-full px-3 py-2 rounded-xl bg-[#121215] border border-[#27272A] text-xs text-white focus:outline-none focus:border-indigo-500"
                    />
                  </div>
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Teléfono / WhatsApp</label>
                    <input
                      type="text"
                      id="quoteClientPhoneInput"
                      value="33 1845 9021"
                      placeholder="Ej. 33 1234 5678"
                      class="w-full px-3 py-2 rounded-xl bg-[#121215] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-indigo-500"
                    />
                  </div>
                </div>
              </div>

              <!-- CONSTRUCTOR DE GRUPO / PARTIDA -->
              <div class="p-3.5 rounded-2xl bg-[#18181B] border border-[#27272A] flex flex-col gap-3.5">
                <div class="flex items-center justify-between gap-2">
                  <span class="text-xs font-extrabold uppercase tracking-wider text-blue-400">
                    Configurar Nuevo Grupo de Artículos
                  </span>
                  <span id="builderGroupTotalPiecesBadge" class="font-mono text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-600/20 border border-blue-500/40 text-blue-300">
                    Grupo: 6 piezas
                  </span>
                </div>

                <!-- 1. Seleccionar Producto Base -->
                <div>
                  <label class="block text-[11px] font-semibold text-zinc-400 mb-1.5">1. Producto / Corte Base</label>
                  <div id="quoteGarmentOptions" class="grid grid-cols-2 sm:grid-cols-3 gap-2"></div>
                </div>

                <!-- 2. Desglose de Cantidad, Color y Talla dentro del Grupo -->
                <div id="quoteBreakdownSection" class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex flex-col gap-2.5">
                  <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                      <span id="quoteBreakdownTitle" class="text-xs font-extrabold text-white">2. Desglose de Cantidad, Color y Talla</span>
                      <span id="quoteBreakdownHint" class="block text-[11px] text-zinc-400">Combina varias tallas o colores dentro de este mismo grupo (S a XXXL).</span>
                    </div>
                    <button
                      type="button"
                      id="btnAddGroupBreakdownRow"
                      class="px-2.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-bold shrink-0 transition-colors"
                    >
                      + Fila Color / Talla
                    </button>
                  </div>

                  <div id="quoteGroupBreakdownRows" class="flex flex-col gap-2"></div>
                </div>

                <!-- 3. Aplicaciones de DTF para este Grupo -->
                <div id="quoteDtfSection" class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex flex-col gap-2.5 transition-opacity">
                  <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                      <span class="text-xs font-extrabold text-white">3. Aplicaciones de DTF del Grupo (cm²)</span>
                      <span id="quoteDtfSubtext" class="block text-[11px] text-zinc-400">Costo real calculado por cm² según el costo del metro lineal (58×100 cm)</span>
                    </div>
                    <button
                      type="button"
                      id="btnAddDtfApp"
                      class="px-2.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 disabled:opacity-40 disabled:pointer-events-none text-white text-[11px] font-bold shrink-0 transition-colors"
                    >
                      + Agregar DTF
                    </button>
                  </div>

                  <!-- Entrada de costo del metro de DTF para cálculo real -->
                  <div class="p-2.5 rounded-lg bg-[#121215] border border-[#27272A] flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                      <label for="quoteDtfMeterCostInput" class="text-[11px] font-semibold text-zinc-300">Costo metro DTF ($):</label>
                      <input
                        type="number"
                        id="quoteDtfMeterCostInput"
                        min="0"
                        step="5"
                        value="350"
                        class="w-24 px-2 py-1 rounded-lg bg-[#09090B] border border-indigo-500/40 font-mono text-xs font-bold text-indigo-300 text-right focus:outline-none focus:border-indigo-400"
                      />
                    </div>
                    <span id="quoteDtfCm2RateBadge" class="font-mono text-[10px] text-zinc-400">
                      5,800 cm²/m → $0.0603/cm²
                    </span>
                  </div>

                  <div id="quoteDtfAppsList" class="flex flex-col gap-2"></div>
                </div>

                <button
                  type="button"
                  id="btnAddGroupToQuote"
                  class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 active:scale-[0.99] text-white text-xs font-extrabold shadow-md shadow-blue-950/40 transition-all"
                >
                  + Agregar Grupo a la Cotización
                </button>
              </div>

              <!-- Costo "Otros" (Bolsa / Envío — USO INTERNO, NO DESGLOSADO EN PDF) -->
              <div class="p-3.5 rounded-xl bg-amber-950/20 border border-amber-500/35 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="min-w-0">
                  <span class="inline-block font-mono text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30 mb-1">
                    Uso interno (Bolsa / Envío) — Solo visible para ti, no se desglosa en el PDF
                  </span>
                  <span class="block text-xs text-zinc-300">Costo adicional de empaque o envío integrado discretamente al total final.</span>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                  <label for="quoteOtherCostInput" class="text-xs text-amber-300 font-semibold">Otros ($):</label>
                  <input
                    type="number"
                    id="quoteOtherCostInput"
                    min="0"
                    step="5"
                    value="85"
                    class="w-24 px-2.5 py-1.5 rounded-lg bg-[#09090B] border border-amber-500/40 font-mono text-xs text-amber-300 font-bold text-right focus:outline-none focus:border-amber-400"
                  />
                </div>
              </div>
            </div>

            <!-- Columna Derecha: Grupos Agregados + Descuento Selectivo por Grupo + PDF + Convertir a Pedido -->
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col justify-between gap-4 min-w-0">
              <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between pb-3 border-b border-[#27272A]">
                  <div>
                    <h3 class="text-sm font-extrabold text-white">Grupos en esta Cotización</h3>
                    <span id="quoteTotalPiecesSummary" class="text-[11px] text-zinc-400">0 piezas en total</span>
                  </div>
                  <span id="quoteFolioPreview" class="font-mono text-[11px] px-2.5 py-0.5 rounded bg-indigo-500/15 text-indigo-400 border border-indigo-500/30 font-bold">
                    COT-301
                  </span>
                </div>

                <!-- Control de Porcentaje de Descuento Selectivo -->
                <div class="p-3 rounded-xl bg-[#18181B] border border-amber-500/35 flex items-center justify-between gap-3">
                  <div class="min-w-0">
                    <span class="block text-xs font-extrabold text-white">Descuento Selectivo por Grupo (%)</span>
                    <span class="block text-[11px] text-zinc-400">Marca la casilla en cada grupo al que desees aplicar este %</span>
                  </div>
                  <div class="flex items-center gap-1.5 shrink-0">
                    <input
                      type="number"
                      id="quoteDiscountPctInput"
                      min="0"
                      max="80"
                      value="15"
                      class="w-16 px-2 py-1.5 rounded-lg bg-[#09090B] border border-amber-500/50 font-mono text-xs text-amber-400 font-extrabold text-right focus:outline-none focus:border-amber-400"
                    />
                    <span class="font-mono text-xs font-bold text-amber-400">%</span>
                  </div>
                </div>

                <!-- Lista de Grupos Agregados con Casilla Individual de Descuento -->
                <div id="quoteAddedGroupsList" class="flex flex-col gap-2.5 max-h-[340px] overflow-y-auto pr-1"></div>

                <!-- Desglose Económico Total -->
                <div id="quoteLiveBreakdown" class="bg-[#09090B] border border-[#27272A] rounded-xl p-3.5 flex flex-col gap-2 text-xs"></div>

                <!-- Anticipo recibido ($) al convertir en pedido -->
                <div class="p-3 rounded-xl bg-[#18181B] border border-[#27272A] flex items-center justify-between gap-3">
                  <div class="min-w-0">
                    <label for="quoteInitialAdvanceInput" class="block text-xs font-bold text-white">Anticipo recibido al convertir ($)</label>
                    <span class="block text-[11px] text-zinc-400">Ingresa $0 si aún no deja anticipo</span>
                  </div>
                  <input
                    type="number"
                    id="quoteInitialAdvanceInput"
                    min="0"
                    step="10"
                    value="0"
                    class="w-28 px-2.5 py-1.5 rounded-lg bg-[#09090B] border border-[#27272A] font-mono text-xs text-emerald-400 font-extrabold text-right focus:outline-none focus:border-emerald-500"
                  />
                </div>
              </div>

              <div class="flex flex-col gap-2">
                <button
                  type="button"
                  id="btnDownloadQuotePdf"
                  class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:scale-[0.99] text-white text-xs sm:text-sm font-extrabold shadow-lg shadow-emerald-950/40 flex items-center justify-center gap-2 transition-all"
                >
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <polyline points="9 15 12 18 15 15"></polyline>
                  </svg>
                  <span>Descargar Cotización PDF</span>
                </button>

                <button
                  type="button"
                  id="btnSendQuoteToOrders"
                  class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 active:scale-[0.99] text-white text-xs sm:text-sm font-extrabold transition-all"
                >
                  Enviar Cotización a Pedidos
                </button>
                <button
                  type="button"
                  id="btnQuoteWhatsapp"
                  class="w-full py-3 px-4 rounded-xl bg-green-600 hover:bg-green-500 active:scale-[0.99] text-white text-xs sm:text-sm font-extrabold transition-all"
                >
                  Enviar Cotización por WhatsApp
                </button>
              </div>
            </div>
          </div>
        </section>

        <!-- ==================================================================
             MÓDULO 6: REPORTES (CON USUARIO + COMISIÓN TERMINAL % + CSV Y PDF)
             ================================================================== -->
        <section id="view-reportes" class="hidden flex flex-col gap-4">
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5 sm:p-4 flex flex-col gap-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
              <div id="reportTabsGroup" class="flex flex-wrap gap-1.5" role="tablist">
                <button type="button" data-report-tab="ventas" class="report-tab-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-600 text-white">Ventas</button>
                <button type="button" data-report-tab="stock" class="report-tab-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]">Movimientos Stock</button>
                <button type="button" data-report-tab="materias" class="report-tab-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]">Materias Primas</button>
                <button type="button" data-report-tab="pedidos" class="report-tab-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]">Historial de Pedidos</button>
              </div>

              <div class="flex flex-wrap items-center gap-2">
                <button
                  type="button"
                  id="btnDownloadReportCsv"
                  class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-zinc-200 text-xs font-bold transition-all"
                >
                  <span>Exportar CSV</span>
                </button>

                <button
                  type="button"
                  id="btnDownloadReportPdf"
                  class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white text-xs font-extrabold transition-all"
                >
                  <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                  </svg>
                  <span>Descargar PDF</span>
                </button>
              </div>
            </div>

            <div id="reportTerminalFeeBar" class="p-3 rounded-xl bg-[#18181B] border border-amber-500/35 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
              <div class="min-w-0">
                <span class="text-xs font-extrabold text-white">Comisión Terminal Bancaria (%)</span>
                <span class="block text-[11px] text-zinc-400">Al modificar este porcentaje se recalcula el descuento en ventas con Terminal y Finanzas.</span>
              </div>
              <div class="flex items-center gap-2 shrink-0">
                <label for="terminalFeePctInput" class="text-xs font-semibold text-amber-400">Comisión (%):</label>
                <input
                  type="number"
                  id="terminalFeePctInput"
                  min="0"
                  max="25"
                  step="0.1"
                  value="3.5"
                  class="w-20 px-2.5 py-1.5 rounded-lg bg-[#09090B] border border-amber-500/50 font-mono text-xs font-extrabold text-amber-300 text-right focus:outline-none focus:border-amber-400"
                />
              </div>
            </div>

            <div class="relative">
              <svg class="w-4 h-4 text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <input
                type="text"
                id="reportSearchInput"
                placeholder="Filtrar por folio, artículo, cliente o usuario..."
                class="w-full pl-9 pr-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-blue-500"
              />
            </div>
          </div>

          <div class="bg-[#121215] border border-[#27272A] rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse text-xs">
                <thead id="reportTableHead" class="bg-[#18181B] border-b border-[#27272A] text-zinc-400 font-semibold"></thead>
                <tbody id="reportTableBody" class="divide-y divide-[#27272A]"></tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ==================================================================
             MÓDULO 7: PEDIDOS (ENTRADA MANUAL DE ANTICIPO DADO $ SIN 50% FIJO)
             ================================================================== -->
        <section id="view-pedidos" class="hidden flex flex-col gap-4">
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5 sm:p-4 flex flex-col gap-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
              <h3 class="text-sm font-extrabold text-white">Control de Pedidos Personalizados</h3>
              <button
                type="button"
                data-route="cotizacion"
                class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-colors"
              >
                + Nueva Cotización
              </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-zinc-400 mb-1.5">Estado de Producción</span>
                <div id="orderProdFilters" class="flex flex-wrap gap-1"></div>
              </div>
              <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-zinc-400 mb-1.5">Estado de Pago / Anticipo</span>
                <div id="orderPayFilters" class="flex flex-wrap gap-1"></div>
              </div>
            </div>
          </div>

          <div id="ordersCardsGrid" class="cq-grid-2"></div>
        </section>

        <!-- ==================================================================
             MÓDULO 8: REGISTRO (GAMA DE COLORES DE MATERIA PRIMA + TALLAS S-XXXL + TOTE BAG)
             ================================================================== -->
        <section id="view-registro" class="hidden flex flex-col gap-4">
          <div class="cq-split-main">
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col gap-3.5 min-w-0">
              <div>
                <h3 class="text-sm sm:text-base font-extrabold text-white">Alta de Producto Terminado para Stock</h3>
                <p class="text-xs text-zinc-400">Elige color de tu gama registrada en Materia Prima, talla (S a XXXL) y genera pegatina QR.</p>
              </div>

              <form id="formRegisterStockProduct" class="flex flex-col gap-3">
                <div>
                  <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nombre del producto</label>
                  <input
                    type="text"
                    id="regProdName"
                    required
                    placeholder="Ej. Playera Oversize Midnight Drift"
                    class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-blue-500"
                  />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Categoría</label>
                    <select id="regProdCategory" class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white focus:outline-none focus:border-blue-500">
                      <option value="Playeras: Oversize">Playeras: Oversize</option>
                      <option value="Playeras: Regular fit">Playeras: Regular fit</option>
                      <option value="Playeras: Infantil">Playeras: Infantil</option>
                      <option value="Hoodies">Hoodies</option>
                      <option value="Tote bag">Tote bag</option>
                      <option value="Cuadros">Cuadros</option>
                      <option value="Llaveros">Llaveros</option>
                    </select>
                  </div>

                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Código QR Personal / SKU</label>
                    <div class="flex gap-1.5">
                      <input
                        type="text"
                        id="regProdQr"
                        required
                        class="flex-1 min-w-0 px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-blue-400 font-bold focus:outline-none focus:border-blue-500"
                      />
                      <button
                        type="button"
                        id="btnRegenerateQr"
                        class="px-2.5 py-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-xs font-mono text-zinc-300 shrink-0"
                        title="Generar nuevo código QR"
                      >
                        Auto
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Color de la Gama de Materia Prima + Tallas S a XXXL / Medida Tote bag -->
                <div id="regApparelAttrsBox" class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex flex-col gap-3">
                  <div>
                    <div class="flex items-center justify-between mb-1.5">
                      <label class="text-[11px] font-semibold text-zinc-400">
                        Color (Gama Materia Prima): <strong id="regSelectedColorLabel" class="text-white">Negro</strong>
                      </label>
                      <button type="button" data-route="materia" class="text-[10px] text-indigo-400 hover:underline">
                        + Registrar más colores
                      </button>
                    </div>
                    <div id="regPaletteSwatches" class="flex flex-wrap gap-1.5"></div>
                  </div>

                  <div id="regSizeSelectWrapper">
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Talla (Solo S – XXXL)</label>
                    <select id="regProdSize" class="w-full px-3 py-2 rounded-xl bg-[#121215] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500">
                      <option value="S">S</option>
                      <option value="M">M</option>
                      <option value="L" selected>L</option>
                      <option value="XL">XL</option>
                      <option value="XXL">XXL</option>
                      <option value="XXXL">XXXL</option>
                    </select>
                  </div>

                  <div id="regFixedMeasureWrapper" class="hidden">
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Medida Única</label>
                    <div class="px-3 py-2 rounded-xl bg-[#121215] border border-[#27272A] font-mono text-xs text-zinc-300">
                      35×40 cm (Única Tote bag)
                    </div>
                  </div>
                </div>

                <!-- Selección de Insumo de Materia Prima (Descuento automático de inventario) -->
                <div class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex flex-col gap-2">
                  <div class="flex flex-wrap items-center justify-between gap-2">
                    <label for="regRawMaterialSelect" class="text-[11px] font-semibold text-zinc-300">Insumo Base (Materia Prima)</label>
                    <span id="regRmAvailBadge" class="font-mono text-[10px] font-bold px-2 py-0.5 rounded bg-blue-500/15 text-blue-300 border border-blue-500/30">
                      Disponible: 32 u. • $135.00
                    </span>
                  </div>
                  <select id="regRawMaterialSelect" class="w-full px-3 py-2 rounded-xl bg-[#121215] border border-[#27272A] text-xs text-white focus:outline-none focus:border-blue-500"></select>
                </div>

                <!-- Apartado de Aplicaciones de DTF (Solo Playeras, Hoodies y Tote bag) -->
                <div id="regDtfSection" class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex flex-col gap-2.5">
                  <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                      <span class="text-xs font-extrabold text-white">Aplicaciones de DTF (cm²)</span>
                      <span class="block text-[11px] text-zinc-400">Se suma al insumo de materia prima para el costo de elaboración</span>
                    </div>
                    <button
                      type="button"
                      id="btnAddRegDtfApp"
                      class="px-2.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-bold shrink-0 transition-colors"
                    >
                      + Agregar DTF
                    </button>
                  </div>

                  <div class="p-2 rounded-lg bg-[#121215] border border-[#27272A] flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                      <label for="regDtfMeterCostInput" class="text-[11px] font-semibold text-zinc-300">Costo metro DTF ($):</label>
                      <input
                        type="number"
                        id="regDtfMeterCostInput"
                        min="0"
                        step="5"
                        value="350"
                        class="w-24 px-2 py-1 rounded-lg bg-[#09090B] border border-indigo-500/40 font-mono text-xs font-bold text-indigo-300 text-right focus:outline-none focus:border-indigo-400"
                      />
                    </div>
                    <span id="regDtfCm2RateBadge" class="font-mono text-[10px] text-zinc-400">
                      5,800 cm²/m → $0.0603/cm²
                    </span>
                  </div>

                  <div id="regDtfAppsList" class="flex flex-col gap-2"></div>
                </div>

                <div class="grid grid-cols-3 gap-2.5">
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Stock inicial</label>
                    <input
                      type="number"
                      id="regProdStock"
                      min="1"
                      value="5"
                      required
                      class="w-full px-2.5 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500"
                    />
                  </div>
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Costo elab. ($)</label>
                    <input
                      type="number"
                      id="regProdCost"
                      min="1"
                      step="0.01"
                      value="195.34"
                      required
                      class="w-full px-2.5 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-blue-500"
                    />
                  </div>
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Ganancia (%)</label>
                    <input
                      type="number"
                      id="regProdMargin"
                      min="5"
                      max="500"
                      value="100"
                      required
                      class="w-full px-2.5 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-emerald-400 font-bold focus:outline-none focus:border-emerald-500"
                    />
                  </div>
                </div>

                <div class="p-3 rounded-xl bg-[#18181B] border border-[#27272A] flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                  <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-zinc-300">
                    <input type="checkbox" id="regUseSuggestedCheck" checked class="w-4 h-4 rounded bg-[#09090B] border-zinc-600 text-emerald-500" />
                    <span>Usar precio sugerido automáticamente</span>
                  </label>
                  <div class="flex items-center gap-2">
                    <span class="text-xs text-zinc-400">Precio Venta ($):</span>
                    <input
                      type="number"
                      id="regProdFinalPrice"
                      min="1"
                      step="1"
                      required
                      class="w-24 px-2.5 py-1.5 rounded-lg bg-[#09090B] border border-[#27272A] font-mono text-xs font-extrabold text-white text-right focus:outline-none focus:border-emerald-500"
                    />
                  </div>
                </div>

                <button
                  type="submit"
                  class="mt-1 w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:scale-[0.99] text-white text-xs sm:text-sm font-extrabold transition-all"
                >
                  Guardar en Stock
                </button>
              </form>
            </div>

            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col justify-between gap-4 min-w-0">
              <div class="flex flex-col gap-3">
                <h3 class="text-sm font-extrabold text-white">Pegatina QR Personal &amp; Precio Sugerido</h3>

                <div class="grid grid-cols-2 gap-2.5">
                  <div class="p-3 rounded-xl bg-[#09090B] border border-[#27272A]">
                    <span class="block text-[11px] text-zinc-400">Precio Sugerido</span>
                    <span id="regSuggestedPreview" class="block font-mono text-base sm:text-lg font-black text-blue-400 mt-0.5">$462.00</span>
                  </div>
                  <div class="p-3 rounded-xl bg-[#09090B] border border-[#27272A]">
                    <span class="block text-[11px] text-zinc-400">Utilidad por Pieza</span>
                    <span id="regUnitProfitPreview" class="block font-mono text-base sm:text-lg font-black text-emerald-400 mt-0.5">+$252.00</span>
                  </div>
                </div>

                <div class="p-4 rounded-2xl bg-white text-zinc-950 border-2 border-zinc-300 shadow-lg flex flex-col items-center text-center gap-2">
                  <span class="font-black tracking-widest text-[11px] uppercase text-zinc-900">NEED 4 STREET • HECHO PARA DESTACAR</span>
                  <canvas id="regQrPreviewCanvas" width="150" height="150" class="rounded-lg border border-zinc-200"></canvas>
                  <div class="w-full min-w-0">
                    <p id="regCardPreviewName" class="text-xs font-extrabold text-zinc-950 truncate">Nuevo Producto Streetwear</p>
                    <p id="regCardPreviewMeta" class="text-[11px] font-semibold text-zinc-600 truncate">Playeras: Oversize • Negro • Talla L</p>
                    <div class="mt-1 flex items-center justify-center gap-2 font-mono text-xs font-black">
                      <span id="regCardPreviewQr" class="px-2 py-0.5 rounded bg-zinc-900 text-white">QR-OVS-07</span>
                      <span id="regCardPreviewPrice" class="text-zinc-950">$462.00</span>
                    </div>
                  </div>
                </div>
              </div>

              <button
                type="button"
                id="btnDownloadRegSticker"
                class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 active:scale-[0.99] text-white text-xs sm:text-sm font-extrabold flex items-center justify-center gap-2 transition-all"
              >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="3" width="7" height="7"></rect>
                  <rect x="14" y="3" width="7" height="7"></rect>
                  <rect x="3" y="14" width="7" height="7"></rect>
                  <path d="M14 14h3v3h-3zM18 18h3v3h-3z"></path>
                </svg>
                <span>Descargar Pegatina QR (PNG)</span>
              </button>
            </div>
          </div>
        </section>

        <!-- ==================================================================
             MÓDULO 9: USUARIOS (ELIMINACIÓN EXCLUSIVA PARA ADMINISTRADOR CON CONFIRMACIÓN)
             ================================================================== -->
        <section id="view-usuarios" class="hidden flex flex-col gap-4">
          <div class="cq-split-main">
            <div id="userRegistrationPanel" class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 h-fit">
              <h3 class="text-sm sm:text-base font-extrabold text-white">Registrar Usuario Nuevo</h3>
              <p class="text-xs text-zinc-400 mt-0.5 mb-4">Crea perfiles operativos para auditar ventas, movimientos y cotizaciones.</p>

              <form id="formRegisterUser" class="flex flex-col gap-3">
                <div>
                  <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nombre completo</label>
                  <input
                    type="text"
                    id="usrFullName"
                    required
                    placeholder="Ej. Sofía Ramírez"
                    class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500"
                  />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Usuario / Alias</label>
                    <input
                      type="text"
                      id="usrAlias"
                      required
                      placeholder="Ej. sramirez"
                      class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-indigo-500"
                    />
                  </div>
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">PIN de acceso (4 dígitos)</label>
                    <input
                      type="password"
                      id="usrPin"
                      inputmode="numeric"
                      maxlength="4"
                      pattern="[0-9]{4}"
                      placeholder="••••"
                      autocomplete="new-password"
                      required
                      class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white focus:outline-none focus:border-indigo-500"
                    />
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                  <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Rol en el sistema</label>
                    <select id="usrRole" class="w-full px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white focus:outline-none focus:border-indigo-500">
                      <option value="Administrador">Administrador</option>
                      <option value="Ventas / Mostrador">Ventas / Mostrador</option>
                      <option value="Producción / Taller">Producción / Taller</option>
                    </select>
                  </div>
                  <label class="inline-flex items-center gap-2 py-2 px-3 rounded-xl bg-[#09090B] border border-[#27272A] cursor-pointer text-xs text-zinc-200">
                    <input type="checkbox" id="usrActiveCheck" checked class="w-4 h-4 rounded bg-[#121215] border-zinc-600 text-emerald-500" />
                    <span>Usuario Activo</span>
                  </label>
                </div>

                <button
                  type="submit"
                  class="mt-1 w-full py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-extrabold transition-colors"
                >
                  Registrar Usuario
                </button>
              </form>
            </div>

            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 flex flex-col gap-3 min-w-0">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                  <h3 class="text-sm font-extrabold text-white">Equipo y Sesiones Registradas</h3>
                  <p class="text-xs text-zinc-400">Solo el rol Administrador puede eliminar a otros usuarios con confirmación.</p>
                </div>
                <span id="usersAdminPermBadge" class="font-mono text-[10px] font-bold px-2.5 py-1 rounded-lg bg-indigo-500/15 text-indigo-300 border border-indigo-500/30">
                  Modo Administrador
                </span>
              </div>

              <div id="usersListContainer" class="flex flex-col gap-2.5"></div>
            </div>
          </div>
        </section>

        <!-- ==================================================================
             MÓDULO 10: HISTORIAL DE CLIENTES (EXCLUSIVO PEDIDOS PERSONALIZADOS)
             ================================================================== -->
        <section id="view-clientes" class="hidden flex flex-col gap-4">
          <div id="clientsKpiRow" class="cq-grid-3"></div>

          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5 sm:p-4 flex flex-col gap-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
              <div class="relative flex-1 min-w-0">
                <svg class="w-4 h-4 text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input
                  type="text"
                  id="clientSearchInput"
                  placeholder="Buscar cliente de pedidos personalizados por nombre o teléfono..."
                  class="w-full pl-9 pr-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-blue-500"
                />
              </div>
              <button
                type="button"
                id="btnToggleNewClientForm"
                class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shrink-0 transition-colors"
              >
                + Registrar Cliente Personalizado
              </button>
            </div>

            <form id="formAddCustomClient" class="hidden pt-3 border-t border-[#27272A] grid grid-cols-1 sm:grid-cols-3 gap-2.5">
              <input
                type="text"
                id="newClientName"
                required
                placeholder="Nombre completo o Marca"
                class="px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] text-xs text-white"
              />
              <input
                type="text"
                id="newClientPhone"
                required
                placeholder="Teléfono / WhatsApp"
                class="px-3 py-2 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-xs text-white"
              />
              <button type="submit" class="py-2 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold">
                Guardar Cliente
              </button>
            </form>
          </div>

          <div class="cq-split-main">
            <div id="customClientsList" class="flex flex-col gap-2.5 min-w-0"></div>
            <div id="customClientDetailPanel" class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 sm:p-5 h-fit min-w-0"></div>
          </div>
        </section>

      </div>

      <!-- ====================================================================
           FOOTER DEL SISTEMA
           ==================================================================== -->
      <footer class="bg-[#121215] border-t border-[#27272A] px-3.5 sm:px-6 py-2.5 flex flex-wrap items-center justify-between gap-2 text-[11px] text-zinc-400 shrink-0">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
          <span class="font-bold text-zinc-200">NEED 4 STREET • HECHO PARA DESTACAR</span>
          <span class="hidden sm:inline text-zinc-600">|</span>
          <span id="footerLiveStatus" class="hidden sm:inline">10 módulos activos y sincronizados</span>
        </div>
        <span id="footerViewportInfo" class="hidden font-mono text-zinc-400" aria-hidden="true">Viewport: 100%</span>
      </footer>

    </div>
  </main>

  <!-- ========================================================================
       MODAL DE CONFIRMACIÓN PARA ELIMINAR (STOCK, MATERIA PRIMA Y USUARIOS)
       ======================================================================== -->
  <div id="confirmDeleteModal" class="hidden fixed inset-0 z-50 bg-black/80 backdrop-blur-sm p-4 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="bg-[#121215] border border-[#27272A] rounded-2xl w-full max-w-md p-5 flex flex-col gap-4 shadow-2xl">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-400 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
            <path d="M10 11v6M14 11v6"></path>
          </svg>
        </div>
        <div class="min-w-0">
          <h3 id="confirmDeleteTitle" class="text-sm font-extrabold text-white">Confirmar eliminación</h3>
          <p id="confirmDeleteText" class="text-xs text-zinc-300 mt-1 leading-relaxed">
            ¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.
          </p>
        </div>
      </div>

      <div class="flex items-center justify-end gap-2 pt-2 border-t border-[#27272A]">
        <button
          type="button"
          id="btnCancelConfirmDelete"
          class="px-3.5 py-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-xs font-bold text-zinc-300"
        >
          Cancelar
        </button>
        <button
          type="button"
          id="btnExecuteConfirmDelete"
          class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-extrabold"
        >
          Sí, eliminar
        </button>
      </div>
    </div>
  </div>

  <!-- ========================================================================
       MODAL DE AUTENTICACIÓN POR PIN PARA CAMBIO DE USUARIO
       ======================================================================== -->
  <div id="userPinAuthModal" class="hidden fixed inset-0 z-50 bg-black/80 backdrop-blur-sm p-4 flex items-center justify-center" role="dialog" aria-modal="true">
    <form id="formVerifyUserPin" class="bg-[#121215] border border-[#27272A] rounded-2xl w-full max-w-sm p-5 flex flex-col gap-4 shadow-2xl">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-indigo-500/15 border border-indigo-500/30 text-indigo-400 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
          </svg>
        </div>
        <div class="min-w-0">
          <h3 class="text-sm font-extrabold text-white">Iniciar Sesión con PIN</h3>
          <p id="userPinAuthSubtitle" class="text-xs text-zinc-300 mt-1 leading-relaxed">
            Ingresa el PIN de 4 dígitos configurado para este usuario.
          </p>
        </div>
      </div>

      <div class="flex flex-col gap-1.5">
        <label for="userPinAuthUser" class="text-[11px] font-semibold text-zinc-400">Usuario</label>
        <select
          id="userPinAuthUser"
          required
          class="w-full px-3.5 py-2.5 rounded-xl bg-[#09090B] border border-[#27272A] text-sm text-white focus:outline-none focus:border-indigo-500"
        ></select>
      </div>

      <div class="flex flex-col gap-1.5">
        <label for="userPinAuthInput" class="text-[11px] font-semibold text-zinc-400">PIN de acceso (4 dígitos)</label>
        <input
          type="password"
          id="userPinAuthInput"
          inputmode="numeric"
          maxlength="4"
          pattern="[0-9]{4}"
          required
          placeholder="••••"
          class="w-full px-3.5 py-2.5 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-base tracking-[0.5em] text-center text-white focus:outline-none focus:border-indigo-500"
        />
        <p id="userPinAuthError" class="hidden text-[11px] font-semibold text-rose-400 mt-0.5">
          PIN incorrecto. Verifica los 4 dígitos configurados.
        </p>
      </div>

      <div class="flex items-center justify-end gap-2 pt-2 border-t border-[#27272A]">
        <button
          type="button"
          id="btnCancelUserPin"
          class="hidden px-3.5 py-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-xs font-bold text-zinc-300"
        >
          Cancelar
        </button>
        <button
          type="submit"
          class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-extrabold"
        >
          Ingresar
        </button>
      </div>
    </form>
  </div>

  <!-- ========================================================================
       MODAL "VER CSS" CON CÓDIGO RESPONSIVO LISTO PARA COPIAR
       ======================================================================== -->
  <div id="cssCodeModal" class="hidden fixed inset-0 z-50 bg-black/80 backdrop-blur-sm p-3 sm:p-6 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="bg-[#121215] border border-[#27272A] rounded-2xl w-full max-w-3xl max-h-[86vh] flex flex-col shadow-2xl overflow-hidden">
      <div class="px-4 sm:px-6 py-3.5 border-b border-[#27272A] flex items-center justify-between gap-3">
        <div>
          <h3 class="text-sm font-extrabold text-white">Código CSS Responsivo (10 Módulos) — NEED FOR STREET</h3>
          <p id="cssModalModeDesc" class="text-xs text-zinc-400">Arquitectura activa con protección anti-deformación</p>
        </div>
        <div class="flex items-center gap-2">
          <button
            type="button"
            id="btnCopyCssModal"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition-colors"
          >
            <span id="copyCssBtnLabel">Copiar CSS</span>
          </button>
          <button type="button" id="btnCloseCssModal" class="p-1.5 rounded-xl text-zinc-400 hover:text-white hover:bg-[#18181B]" aria-label="Cerrar modal">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>
      <div class="flex-1 overflow-auto p-4 sm:p-5 bg-[#09090B]">
        <pre class="font-mono text-xs leading-relaxed text-zinc-200"><code id="cssModalPreCode"></code></pre>
      </div>
    </div>
  </div>

  <!-- Toast flotante limpio -->
  <div
    id="appToast"
    class="fixed bottom-4 right-4 z-50 pointer-events-none opacity-0 translate-y-3 transition-all duration-200 bg-[#18181B] border border-[#27272A] text-white px-4 py-2.5 rounded-xl shadow-2xl flex items-center gap-2.5 text-xs font-semibold"
  >
    <span id="appToastDot" class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
    <span id="appToastText">Listo</span>
  </div>

  <!-- ========================================================================
       4. LÓGICA INTEGRAL DE ESTADO, QR MATRIX, PDF CON LOGO Y LOS 10 MÓDULOS
       ======================================================================== -->
  <script>
    (function () {
      // ----------------------------------------------------------------------
      // CONSTANTES Y CATÁLOGOS BASE
      // ----------------------------------------------------------------------
      const APPAREL_SIZES_S_TO_XXXL = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

      const STOCK_CATEGORIES = [
        'Todos',
        'Playeras: Infantil',
        'Playeras: Regular fit',
        'Playeras: Oversize',
        'Hoodies',
        'Tote bag',
        'Cuadros',
        'Llaveros'
      ];

      const QUOTE_ARTICLES = [
        { id: 'q-ovs', name: 'Playera Oversize 240g', basePrice: 210, baseCost: 135, quoteMode: 'apparel', allowsDtf: true },
        { id: 'q-reg', name: 'Playera Regular Fit 200g', basePrice: 175, baseCost: 105, quoteMode: 'apparel', allowsDtf: true },
        { id: 'q-inf', name: 'Playera Infantil 190g', basePrice: 145, baseCost: 85, quoteMode: 'apparel', allowsDtf: true },
        { id: 'q-hod', name: 'Hoodie Boxy Felpa 360g', basePrice: 440, baseCost: 280, quoteMode: 'apparel', allowsDtf: true },
        { id: 'q-tot', name: 'Tote Bag Loneta', basePrice: 110, baseCost: 58, quoteMode: 'totebag', allowsDtf: true },
        { id: 'q-cua', name: 'Cuadro Aluminio HD', basePrice: 320, baseCost: 165, quoteMode: 'cuadro', allowsDtf: false },
        { id: 'q-lla', name: 'Llavero MDF Sublimado', basePrice: 45, baseCost: 18, quoteMode: 'llavero', allowsDtf: false }
      ];

      const TOTEBAG_QUOTE_COLORS = ['Negro', 'Hueso'];
      const CUADRO_QUOTE_MEASURES = ['20 × 30 cm', '30 × 40 cm', '30 × 60 cm', '40 × 60 cm'];
      const DTF_METER_AREA_CM2 = 5800; // 1 metro lineal estándar de DTF (58 cm ancho × 100 cm largo)

      const MODULE_CARDS_META = [
        {
          id: 'stock',
          title: 'Stock',
          tag: 'INVENTARIO & QR',
          desc: 'Catálogo terminado, existencias por talla/color y descarga de pegatina QR.',
          bentoClass: 'bento-stock',
          accent: 'text-blue-400',
          badgeBg: 'bg-blue-500/15 text-blue-300 border-blue-500/30',
          icon: '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>'
        },
        {
          id: 'materia',
          title: 'Materia Prima',
          tag: 'INSUMOS EN BLANCO',
          desc: 'Prendas en blanco, tallas S–XXXL, gama de colores HEX y alertas mínimas.',
          bentoClass: '',
          accent: 'text-amber-400',
          badgeBg: 'bg-amber-500/15 text-amber-300 border-amber-500/30',
          icon: '<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline>'
        },
        {
          id: 'finanzas',
          title: 'Finanzas',
          tag: 'UTILIDAD & PDF',
          desc: 'KPIs de ingresos, costos, comisiones Terminal, gráficas y reporte PDF.',
          bentoClass: 'bento-finanzas',
          accent: 'text-emerald-400',
          badgeBg: 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30',
          icon: '<line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>'
        },
        {
          id: 'carrito',
          title: 'Carrito POS',
          tag: 'PUNTO DE VENTA',
          desc: 'Escaneo QR óptico, cobro en Efectivo, Transferencia o Terminal.',
          bentoClass: 'bento-carrito',
          accent: 'text-cyan-400',
          badgeBg: 'bg-cyan-500/15 text-cyan-300 border-cyan-500/30',
          icon: '<circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>'
        },
        {
          id: 'cotizacion',
          title: 'Cotización',
          tag: 'MULTI-GRUPO & DTF',
          desc: 'Presupuestos por grupos, cálculo DTF cm², descuento selectivo y PDF.',
          bentoClass: '',
          accent: 'text-indigo-400',
          badgeBg: 'bg-indigo-500/15 text-indigo-300 border-indigo-500/30',
          icon: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line>'
        },
        {
          id: 'reportes',
          title: 'Reportes',
          tag: 'AUDITORÍA & CSV',
          desc: 'Bitácora de ventas, movimientos de stock, materias, pedidos y % Terminal.',
          bentoClass: '',
          accent: 'text-purple-400',
          badgeBg: 'bg-purple-500/15 text-purple-300 border-purple-500/30',
          icon: '<line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line>'
        },
        {
          id: 'pedidos',
          title: 'Pedidos',
          tag: 'TALLER & ANTICIPOS',
          desc: 'Seguimiento de producción y control flexible de anticipos recibidos ($).',
          bentoClass: '',
          accent: 'text-orange-400',
          badgeBg: 'bg-orange-500/15 text-orange-300 border-orange-500/30',
          icon: '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>'
        },
        {
          id: 'registro',
          title: 'Registro',
          tag: 'ALTA & STICKERS QR',
          desc: 'Alta de prendas, hoodies, tote bags y generación de pegatina QR PNG.',
          bentoClass: '',
          accent: 'text-teal-400',
          badgeBg: 'bg-teal-500/15 text-teal-300 border-teal-500/30',
          icon: '<rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><path d="M14 14h3v3h-3zM18 18h3v3h-3z"></path>'
        },
        {
          id: 'usuarios',
          title: 'Usuarios',
          tag: 'EQUIPO & ROLES',
          desc: 'Perfiles de acceso, PIN operativo y permisos de administración.',
          bentoClass: '',
          accent: 'text-pink-400',
          badgeBg: 'bg-pink-500/15 text-pink-300 border-pink-500/30',
          icon: '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>'
        },
        {
          id: 'clientes',
          title: 'Clientes',
          tag: 'PERSONALIZADOS',
          desc: 'Historial exclusivo de clientes y marcas con pedidos personalizados.',
          bentoClass: '',
          accent: 'text-sky-400',
          badgeBg: 'bg-sky-500/15 text-sky-300 border-sky-500/30',
          icon: '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>'
        }
      ];

      // ----------------------------------------------------------------------
      // ESTADO GLOBAL REACTIVO (STORE)
      // ----------------------------------------------------------------------
      const todayIso = new Date().toLocaleDateString('en-CA'); // AAAA-MM-DD en hora local

      const STORE = {
        users: [
          { id: 'u-1', name: 'Carlos Méndez', alias: 'cmendez', role: 'Administrador', active: true },
          { id: 'u-2', name: 'Valeria Soto', alias: 'vsoto', role: 'Ventas / Mostrador', active: true },
          { id: 'u-3', name: 'Diego Navarro', alias: 'dnavarro', role: 'Producción / Taller', active: true }
        ],
        activeUserId: 'u-1',
        terminalFeePct: 3.5,

        colorPalette: [
          { name: 'Negro', hex: '#111113' },
          { name: 'Blanco Hueso', hex: '#F4F4F0' },
          { name: 'Gris Carbón', hex: '#3F3F46' },
          { name: 'Azul Cobalto', hex: '#2563EB' },
          { name: 'Verde Bosque', hex: '#166534' },
          { name: 'Arena / Crudo', hex: '#D6C7B2' }
        ],

        products: [
          { id: 'p-1', qr: 'QR-OVS-01', name: 'Playera Oversize Street Drift', category: 'Playeras: Oversize', color: 'Negro', size: 'L', stock: 18, cost: 210, price: 480 },
          { id: 'p-2', qr: 'QR-REG-02', name: 'Playera Regular Fit Core Logo', category: 'Playeras: Regular fit', color: 'Blanco Hueso', size: 'M', stock: 24, cost: 165, price: 360 },
          { id: 'p-3', qr: 'QR-INF-03', name: 'Playera Infantil Mini Racer', category: 'Playeras: Infantil', color: 'Azul Cobalto', size: 'S', stock: 14, cost: 130, price: 290 },
          { id: 'p-4', qr: 'QR-HOD-04', name: 'Hoodie Boxy Heavyweight 360g', category: 'Hoodies', color: 'Gris Carbón', size: 'XL', stock: 9, cost: 380, price: 850 },
          { id: 'p-5', qr: 'QR-TOT-05', name: 'Tote Bag Loneta Heavy 35×40', category: 'Tote bag', color: 'Arena / Crudo', size: '35×40 cm', stock: 22, cost: 85, price: 220 },
          { id: 'p-6', qr: 'QR-CUA-06', name: 'Cuadro Aluminio HD Skyline', category: 'Cuadros', color: 'N/A', size: '40×60 cm', stock: 7, cost: 210, price: 540 }
        ],

        rawMaterials: [
          { id: 'rm-1', name: 'Playera Oversize 240g Blanco', category: 'Playeras', subType: 'Oversize', color: 'Negro', sizeOrMeasure: 'L', qty: 32, cost: 135, updatedBy: 'Carlos Méndez' },
          { id: 'rm-2', name: 'Hoodie Boxy Felpa 360g Blanco', category: 'Hoodies', subType: '', color: 'Gris Carbón', sizeOrMeasure: 'XL', qty: 8, cost: 280, updatedBy: 'Diego Navarro' },
          { id: 'rm-3', name: 'Tote Bag Loneta Cruda', category: 'Tote bag', subType: '', color: 'Arena / Crudo', sizeOrMeasure: '35×40 cm', qty: 25, cost: 58, updatedBy: 'Carlos Méndez' },
          { id: 'rm-4', name: 'Lámina Aluminio Sublimable', category: 'Lámina / aluminio', subType: '', color: 'N/A', sizeOrMeasure: '40×60 cm', qty: 6, cost: 165, updatedBy: 'Diego Navarro' },
          { id: 'rm-5', name: 'Llavero MDF Corte Láser', category: 'Llavero / MDF', subType: '', color: 'N/A', sizeOrMeasure: '5×5 cm', qty: 45, cost: 18, updatedBy: 'Valeria Soto' }
        ],

        sales: [
          {
            id: 's-1',
            folio: 'VTA-1041',
            date: todayIso,
            user: 'Carlos Méndez',
            method: 'Efectivo',
            grossAmount: 960,
            feeAmount: 0,
            netAmount: 960,
            costAmount: 420,
            items: [{ name: 'Playera Oversize Street Drift', category: 'Playeras: Oversize', qty: 2, price: 480, cost: 210 }]
          },
          {
            id: 's-2',
            folio: 'VTA-1042',
            date: todayIso,
            user: 'Valeria Soto',
            method: 'Terminal',
            grossAmount: 1070,
            feeAmount: 37.45,
            netAmount: 1032.55,
            costAmount: 465,
            items: [
              { name: 'Hoodie Boxy Heavyweight 360g', category: 'Hoodies', qty: 1, price: 850, cost: 380 },
              { name: 'Tote Bag Loneta Heavy 35×40', category: 'Tote bag', qty: 1, price: 220, cost: 85 }
            ]
          },
          {
            id: 's-3',
            folio: 'VTA-1043',
            date: todayIso,
            user: 'Carlos Méndez',
            method: 'Transferencia',
            grossAmount: 1450,
            feeAmount: 0,
            netAmount: 1450,
            costAmount: 690,
            items: [{ name: 'Pedido Personalizado Lote DTF', category: 'Personalizados', qty: 5, price: 290, cost: 138 }]
          }
        ],

        stockMovements: [
          { id: 'sm-1', date: todayIso, product: 'Playera Oversize Street Drift', qr: 'QR-OVS-01', type: 'Salida POS', delta: -2, user: 'Carlos Méndez' },
          { id: 'sm-2', date: todayIso, product: 'Hoodie Boxy Heavyweight 360g', qr: 'QR-HOD-04', type: 'Salida POS', delta: -1, user: 'Valeria Soto' },
          { id: 'sm-3', date: todayIso, product: 'Tote Bag Loneta Heavy 35×40', qr: 'QR-TOT-05', type: 'Alta Inicial', delta: 22, user: 'Carlos Méndez' }
        ],

        orders: [
          {
            id: 'ord-1',
            folio: 'PED-501',
            date: todayIso,
            clientName: 'Colectivo Urbano MX',
            clientPhone: '33 1845 9021',
            summary: '12 Playeras Oversize 240g + 2 DTF',
            totalAmount: 3680,
            advancePaid: 2000,
            prodStatus: 'En Producción',
            createdBy: 'Carlos Méndez'
          },
          {
            id: 'ord-2',
            folio: 'PED-502',
            date: todayIso,
            clientName: 'Garage Nocturno GDL',
            clientPhone: '33 9012 4410',
            summary: '8 Hoodies Boxy + 10 Tote Bags',
            totalAmount: 5420,
            advancePaid: 5420,
            prodStatus: 'Listo para Entrega',
            createdBy: 'Valeria Soto'
          }
        ],

        customClients: [
          { id: 'c-1', name: 'Colectivo Urbano MX', phone: '33 1845 9021', notes: 'Marca streetwear local, entregas quincenales.' },
          { id: 'c-2', name: 'Garage Nocturno GDL', phone: '33 9012 4410', notes: 'Eventos automotrices, pide hoodies y tote bags.' }
        ],

        cart: [
          { productId: 'p-1', qr: 'QR-OVS-01', name: 'Playera Oversize Street Drift', category: 'Playeras: Oversize', color: 'Negro', size: 'L', price: 480, cost: 210, qty: 1 }
        ],
        paymentMethod: 'Efectivo',
        splitPayment: {
          Efectivo: 0,
          Transferencia: 0,
          Terminal: 0
        },

        quoteBuilder: {
          selectedArticleId: 'q-ovs',
          dtfMeterCost: 350,
          breakdownRows: [
            { id: 'br-1', qty: 6, color: 'Negro', size: 'L', measure: '30 × 40 cm' }
          ],
          dtfApps: [
            { id: 'dtf-1', label: 'Pecho Izquierdo', widthCm: 10, heightCm: 10 },
            { id: 'dtf-2', label: 'Espalda Completa', widthCm: 28, heightCm: 35 }
          ]
        },
        regBuilder: {
          selectedRawMaterialId: 'rm-1',
          dtfMeterCost: 350,
          dtfApps: [
            { id: 'rdtf-1', label: 'Pecho', widthCm: 10, heightCm: 10 }
          ]
        },
        quoteGroups: [],
        quoteFolioCounter: 301,

        ui: {
          route: 'dashboard',
          device: 'desktop',
          gridMode: 'bento',
          guidesActive: false,
          stockCategory: 'Todos',
          stockSearch: '',
          rmSelectedColorName: 'Negro',
          regSelectedColorName: 'Negro',
          finDateFrom: '',
          finDateTo: '',
          reportTab: 'ventas',
          reportSearch: '',
          orderProdFilter: 'Todos',
          orderPayFilter: 'Todos',
          clientSearch: '',
          selectedClientId: 'c-1',
          pendingDelete: null,
          pendingSwitchUserId: null,
          loginRequired: false
        }
      };

      // ----------------------------------------------------------------------
      // UTILIDADES GENERALES Y FORMATEO
      // ----------------------------------------------------------------------
      function formatMoney(val) {
        const num = Number(val) || 0;
        return '$' + num.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }

      function escapeHtml(str) {
        return String(str ?? '')
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;');
      }

      function getActiveUser() {
        return STORE.users.find((u) => u.id === STORE.activeUserId) || STORE.users[0];
      }

      function populateUserPinSelect(users, selectedId = '') {
        const select = document.getElementById('userPinAuthUser');
        if (!select) return;

        select.innerHTML = (users || []).map((user) => `
          <option value="${escapeHtml(user.id)}">
            ${escapeHtml(user.name)} · ${escapeHtml(user.role)}
          </option>
        `).join('');

        if (selectedId) select.value = selectedId;
      }

      let toastTimer = null;
      function showToast(msg, type = 'success') {
        const toast = document.getElementById('appToast');
        const dot = document.getElementById('appToastDot');
        const text = document.getElementById('appToastText');
        if (!toast || !text) return;

        text.textContent = msg;
        dot.className = 'w-2 h-2 rounded-full shrink-0 ' + (
          type === 'error' ? 'bg-rose-500' : type === 'warn' ? 'bg-amber-400' : 'bg-emerald-500'
        );

        toast.classList.remove('opacity-0', 'translate-y-3');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
          toast.classList.add('opacity-0', 'translate-y-3');
        }, 2800);
      }

            // ---- QR REAL (ISO/IEC 18004) con QRServer, servido por tu Laravel en /nfs/qr/{codigo} ----
      const QR_CACHE = new Map();
      const qrKey = (text) => String(text || 'NEED4STREET').trim().toUpperCase();

      function getQrEntry(key, size) {
        const id = key + '@' + size;
        let entry = QR_CACHE.get(id);
        if (!entry) {
          entry = { img: new Image(), ready: false, failed: false, waiters: [] };
          entry.img.onload = () => {
            entry.ready = true;
            entry.waiters.splice(0).forEach((fn) => fn(entry.img));
          };
          entry.img.onerror = () => {
            entry.failed = true;
            QR_CACHE.delete(id); // para reintentar la próxima vez
            entry.waiters.splice(0).forEach((fn) => fn(null));
          };
          entry.img.src = '/nfs/qr/' + encodeURIComponent(key) + '?size=' + size;
          QR_CACHE.set(id, entry);
        }
        return entry;
      }

      function whenQrReady(text, size) {
        const entry = getQrEntry(qrKey(text), size);
        if (entry.ready) return Promise.resolve(entry.img);
        if (entry.failed) return Promise.resolve(null);
        return new Promise((resolve) => entry.waiters.push(resolve));
      }

      // Mismo nombre que antes, así el resto de tu código no cambia
      function drawQrMatrixOnCanvas(canvas, text, sizePx) {
        if (!canvas) return;
        const size = sizePx || canvas.width || 150;
        const key = qrKey(text);
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, size, size);
        canvas.dataset.qrKey = key;
        clearTimeout(canvas._qrTimer);

        const paint = (img) => {
          if (canvas.dataset.qrKey !== key) return; // llegó tarde: ya piden otro código
          ctx.fillStyle = '#FFFFFF';
          ctx.fillRect(0, 0, size, size);
          if (img) {
            ctx.drawImage(img, 0, 0, size, size);
          } else {
            ctx.fillStyle = '#71717A';
            ctx.font = '600 11px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('QR no disponible', size / 2, size / 2);
          }
        };

        const cached = QR_CACHE.get(key + '@' + size);
        if (cached && cached.ready) { paint(cached.img); return; }
        // Pequeña espera para no pedir un QR por cada tecla que escribes en el formulario
        canvas._qrTimer = setTimeout(() => whenQrReady(key, size).then(paint), 350);
      }

      async function downloadQrStickerPng(item) {
        try {
          const qrImg = await whenQrReady(item.qr, 270);
          if (!qrImg) {
            showToast('No se pudo obtener el QR (revisa tu conexión a internet)', 'error');
            return;
          }

          const sticker = document.createElement('canvas');
          sticker.width = 420;
          sticker.height = 510;
          const ctx = sticker.getContext('2d');

          ctx.fillStyle = '#FFFFFF';
          ctx.fillRect(0, 0, sticker.width, sticker.height);

          ctx.strokeStyle = '#18181B';
          ctx.lineWidth = 6;
          ctx.strokeRect(12, 12, sticker.width - 24, sticker.height - 24);

          ctx.fillStyle = '#09090B';
          ctx.font = '900 18px Inter, sans-serif';
          ctx.textAlign = 'center';
          ctx.fillText('NEED 4 STREET • HECHO PARA DESTACAR', sticker.width / 2, 50);

          ctx.drawImage(qrImg, (sticker.width - 270) / 2, 72, 270, 270);

          ctx.fillStyle = '#09090B';
          ctx.font = '800 18px Inter, sans-serif';
          ctx.fillText(String(item.name || '').slice(0, 32), sticker.width / 2, 378);

          ctx.fillStyle = '#3F3F46';
          ctx.font = '600 14px Inter, sans-serif';
          const attrLine = item.color && item.color !== 'N/A'
            ? (item.category === 'Tote bag'
              ? `${item.category} • ${item.color} • ${item.size}`
              : `${item.category} • ${item.color} • Talla ${item.size}`)
            : `${item.category} • ${item.size}`;
          ctx.fillText(attrLine, sticker.width / 2, 408);

          ctx.fillStyle = '#09090B';
          ctx.font = '700 20px JetBrains Mono, monospace';
          ctx.fillText(`${item.qr}   |   ${formatMoney(item.price)}`, sticker.width / 2, 456);

          const link = document.createElement('a');
          link.download = `Pegatina_${item.qr}.png`;
          link.href = sticker.toDataURL('image/png');
          link.click();
          showToast(`Pegatina QR (${item.qr}) descargada en PNG`);
        } catch (err) {
          showToast('No se pudo generar la pegatina PNG', 'error');
        }
      }

      // ----------------------------------------------------------------------
      // GENERADOR DE PDF OFICIAL CON LOGOTIPO NEED 4 STREET
      // ----------------------------------------------------------------------
      function generateBrandPdf(filename, title, subtitle, lines, totalFooterText) {
        try {
          if (window.jspdf && window.jspdf.jsPDF) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ unit: 'pt', format: 'a4' });
            const pageW = doc.internal.pageSize.getWidth();

            // Encabezado oscuro con identidad NEED 4 STREET
            doc.setFillColor(9, 9, 11);
            doc.rect(0, 0, pageW, 92, 'F');

            doc.setTextColor(59, 130, 246);
            doc.setFont('helvetica', 'bolditalic');
            doc.setFontSize(22);
            doc.text('NEED 4 STREET', 40, 42);

            doc.setTextColor(212, 212, 216);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(8.5);
            doc.text('HECHO PARA DESTACAR  •  SISTEMA OPERATIVO STREETWEAR', 40, 62);

            doc.setTextColor(255, 255, 255);
            doc.setFontSize(10);
            doc.text(title, pageW - 40, 42, { align: 'right' });
            doc.setTextColor(161, 161, 170);
            doc.setFontSize(8.5);
            doc.text(`Fecha: ${todayIso}`, pageW - 40, 62, { align: 'right' });

            let y = 122;
            doc.setTextColor(24, 24, 27);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(13);
            doc.text(title, 40, y);

            y += 18;
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9.5);
            doc.setTextColor(82, 82, 91);
            doc.text(subtitle, 40, y);

            y += 18;
            doc.setDrawColor(228, 228, 231);
            doc.line(40, y, pageW - 40, y);
            y += 20;

            doc.setFont('courier', 'normal');
            doc.setFontSize(9.2);
            doc.setTextColor(24, 24, 27);

            lines.forEach((line) => {
              if (y > 740) {
                doc.addPage();
                y = 50;
              }
              doc.text(String(line), 40, y);
              y += 16;
            });

            if (totalFooterText) {
              y += 12;
              doc.setFillColor(244, 244, 245);
              doc.roundedRect(40, y, pageW - 80, 34, 6, 6, 'F');
              doc.setFont('helvetica', 'bold');
              doc.setFontSize(11);
              doc.setTextColor(9, 9, 11);
              doc.text(totalFooterText, pageW - 54, y + 22, { align: 'right' });
            }

            doc.save(filename);
            showToast(`PDF "${filename}" descargado correctamente`);
            return;
          }
        } catch (err) {
          // Fallback a Blob texto/PDF si CDN no responde
        }

        const blob = new Blob([`${title}\n${subtitle}\n\n${lines.join('\n')}\n\n${totalFooterText || ''}`], { type: 'text/plain;charset=utf-8' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = filename.replace(/\.pdf$/i, '.txt');
        a.click();
        showToast('Documento descargado');
      }

      // ----------------------------------------------------------------------
      // SIMULADOR DE DISPOSITIVO, LAYOUTS GRID Y MODAL VER CSS
      // ----------------------------------------------------------------------
      const CSS_SNIPPETS_BY_MODE = {
        breakpoints: `/* LAYOUT 1: BREAKPOINTS RESPONSIVOS (5x2 EN PC / 2x5 EN TABLET Y TELÉFONO) */
.nfs-viewport-container {
  container-type: inline-size;
  container-name: nfs-viewport;
}
.grid-mode-breakpoints {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: clamp(0.65rem, 1.6cqi, 1.1rem);
}
@container nfs-viewport (min-width: 960px) {
  .grid-mode-breakpoints {
    grid-template-columns: repeat(5, minmax(0, 1fr));
  }
}`,
        autofit: `/* LAYOUT 2: FLUIDO AUTO-FIT CON MINMAX ANTI-DESBORDAMIENTO */
.grid-mode-autofit {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(min(100%, 205px), 1fr));
  gap: clamp(0.65rem, 1.6cqi, 1.1rem);
}`,
        bento: `/* LAYOUT 3: BENTO MODULAR DENSE PARA 10 MÓDULOS */
.grid-mode-bento {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  grid-auto-flow: dense;
  gap: clamp(0.65rem, 1.6cqi, 1.1rem);
}
@container nfs-viewport (min-width: 960px) {
  .grid-mode-bento {
    grid-template-columns: repeat(5, minmax(0, 1fr));
  }
  .grid-mode-bento .bento-stock { grid-column: span 2; grid-row: span 2; }
  .grid-mode-bento .bento-finanzas { grid-column: span 2; }
  .grid-mode-bento .bento-carrito { grid-column: span 2; }
}`
      };

      function updateViewportAndGridMetrics() {
        const frame = document.getElementById('appViewportFrame');
        const widthLabel = document.getElementById('simWidthIndicator');
        const colsLabel = document.getElementById('simColsIndicator');
        const footerInfo = document.getElementById('footerViewportInfo');
        const quickPanel = document.getElementById('quickCartPanel');
        const quickSub = document.getElementById('quickCartModeSubtitle');
        const sheetHandle = document.getElementById('quickCartSheetHandle');

        const w = frame.offsetWidth || 1200;
        const deviceText = STORE.ui.device === 'mobile' ? '375px' : STORE.ui.device === 'tablet' ? '768px' : '100%';
        widthLabel.textContent = deviceText;
        footerInfo.textContent = `Viewport: ${deviceText} (${w}px)`;

        let cols = 2;
        if (STORE.ui.gridMode === 'breakpoints') {
          cols = w >= 960 ? 5 : 2;
        } else if (STORE.ui.gridMode === 'autofit') {
          cols = Math.max(1, Math.floor(w / 220));
        } else {
          cols = w >= 960 ? 5 : w >= 640 ? 3 : 2;
        }
        colsLabel.textContent = `${cols} cols`;

        // Adaptar Carrito Rápido: Bottom Sheet en teléfono vs Drawer lateral en tablet/PC
        const isOpen = quickPanel.classList.contains('is-open');
        if (STORE.ui.device === 'mobile' || w < 520) {
          quickPanel.className = `nfs-quick-sheet z-50 bg-[#121215] flex flex-col shadow-2xl${isOpen ? ' is-open' : ''}`;
          sheetHandle.classList.remove('hidden');
          quickSub.textContent = 'Bottom Sheet Móvil • POS';
        } else {
          quickPanel.className = `nfs-quick-drawer z-50 bg-[#121215] flex flex-col shadow-2xl${isOpen ? ' is-open' : ''}`;
          sheetHandle.classList.add('hidden');
          quickSub.textContent = 'Drawer Lateral • POS';
        }

        // Actualizar badges de pistas si Guías Grid está activo
        const tracksBadges = document.getElementById('gridTracksBadges');
        if (tracksBadges) {
          tracksBadges.innerHTML = Array.from({ length: cols }, (_, idx) =>
            `<span class="px-2 py-0.5 rounded bg-blue-500/20 border border-blue-400/30">Col ${idx + 1}</span>`
          ).join('');
        }
      }

      function setSimDevice(device) {
        STORE.ui.device = device;
        const frame = document.getElementById('appViewportFrame');
        frame.style.width = device === 'mobile' ? '375px' : device === 'tablet' ? '768px' : '100%';

        document.querySelectorAll('.sim-device-btn').forEach((btn) => {
          const active = btn.dataset.simDevice === device;
          btn.className = active
            ? 'sim-device-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-blue-600 text-white shadow-sm'
            : 'sim-device-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all text-zinc-400 hover:text-white hover:bg-[#18181B]';
        });

        setTimeout(updateViewportAndGridMetrics, 60);
      }

      function setGridMode(mode) {
        STORE.ui.gridMode = mode;
        const grid = document.getElementById('dashboardGrid');
        grid.className = `grid-mode-${mode}`;

        document.querySelectorAll('.grid-mode-btn').forEach((btn) => {
          const active = btn.dataset.gridMode === mode;
          btn.className = active
            ? 'grid-mode-btn px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-indigo-600 text-white'
            : 'grid-mode-btn px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all text-zinc-400 hover:text-white hover:bg-[#18181B]';
        });

        updateViewportAndGridMetrics();
      }

      // ----------------------------------------------------------------------
      // NAVEGACIÓN ENTRE TABLERO Y LOS 10 MÓDULOS
      // ----------------------------------------------------------------------
      function navigateTo(routeId) {
        STORE.ui.route = routeId;

        document.querySelectorAll('[id^="view-"]').forEach((sec) => {
          sec.classList.add('hidden');
        });
        const target = document.getElementById(`view-${routeId}`);
        if (target) target.classList.remove('hidden');

        const subheader = document.getElementById('moduleSubheaderBar');
        const modTitle = document.getElementById('activeModuleTitle');
        const modTag = document.getElementById('activeModuleTag');

        if (routeId === 'dashboard') {
          subheader.classList.add('hidden');
        } else {
          const meta = MODULE_CARDS_META.find((m) => m.id === routeId);
          subheader.classList.remove('hidden');
          modTitle.textContent = meta ? meta.title : routeId;
          modTag.textContent = meta ? meta.tag : 'NEED FOR STREET OS';
        }

        // Cerrar menú lateral o popover si estaban abiertos
        document.getElementById('sideNavBackdrop').classList.add('hidden');
        document.getElementById('userSwitcherBackdrop').classList.add('hidden');
        document.getElementById('userSwitcherPopover').classList.add('hidden');

        renderAll();
      }

      // ----------------------------------------------------------------------
      // RENDER: TABLERO DE 10 MÓDULOS & MENÚ LATERAL
      // ----------------------------------------------------------------------
      function getModuleLiveKpi(id) {
        const fin = computeFinanceMetrics();
        switch (id) {
          case 'stock': {
            const totalUnits = STORE.products.reduce((acc, p) => acc + p.stock, 0);
            return `${STORE.products.length} SKUs • ${totalUnits} pzs`;
          }
          case 'materia': {
            const low = STORE.rawMaterials.filter((r) => r.qty < 10).length;
            return low > 0 ? `${low} alerta(s) < 10 u.` : `${STORE.rawMaterials.length} insumos OK`;
          }
          case 'finanzas':
            return `${formatMoney(fin.netSales)} neto`;
          case 'carrito': {
            const count = STORE.cart.reduce((acc, c) => acc + c.qty, 0);
            return `${count} en carrito`;
          }
          case 'cotizacion':
            return `${STORE.quoteGroups.length} grupo(s) activos`;
          case 'reportes':
            return `${STORE.sales.length} ventas reg.`;
          case 'pedidos': {
            const active = STORE.orders.filter((o) => o.prodStatus !== 'Entregado').length;
            return `${active} activos`;
          }
          case 'registro':
            return 'QR + Tote bag';
          case 'usuarios':
            return `${STORE.users.filter((u) => u.active).length} activos`;
          case 'clientes':
            return `${STORE.customClients.length} clientes`;
          default:
            return '';
        }
      }

      function renderDashboardAndSideNav() {
        const grid = document.getElementById('dashboardGrid');
        const sideList = document.getElementById('sideNavModulesList');

        grid.innerHTML = MODULE_CARDS_META.map((mod) => {
          const kpi = getModuleLiveKpi(mod.id);
          return `
            <button
              type="button"
              data-route="${mod.id}"
              class="nfs-module-card ${mod.bentoClass} text-left bg-[#121215] hover:bg-[#18181B] border border-[#27272A] hover:border-blue-500/50 focus:outline-none focus:border-blue-500 group"
            >
              <div class="flex items-start justify-between gap-2 w-full">
                <div class="w-9 h-9 rounded-xl bg-[#18181B] group-hover:bg-[#09090B] border border-[#27272A] ${mod.accent} flex items-center justify-center shrink-0">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    ${mod.icon}
                  </svg>
                </div>
                <span class="font-mono text-[10px] font-bold px-2 py-0.5 rounded-md border ${mod.badgeBg} truncate">
                  ${escapeHtml(mod.tag)}
                </span>
              </div>

              <div class="min-w-0">
                <h3 class="nfs-card-title text-white group-hover:text-blue-400 transition-colors">${escapeHtml(mod.title)}</h3>
                <p class="nfs-card-desc text-zinc-400 mt-1">${escapeHtml(mod.desc)}</p>
              </div>

              <div class="pt-2 border-t border-[#27272A]/80 flex items-center justify-between gap-2 w-full text-[11px]">
                <span class="font-mono font-semibold text-zinc-300 truncate">${escapeHtml(kpi)}</span>
                <span class="text-zinc-500 group-hover:text-white font-bold shrink-0">Abrir →</span>
              </div>
            </button>
          `;
        }).join('');

        sideList.innerHTML = MODULE_CARDS_META.map((mod) => {
          const isCurrent = STORE.ui.route === mod.id;
          return `
            <button
              type="button"
              data-route="${mod.id}"
              class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-colors text-left ${
                isCurrent ? 'bg-blue-600 text-white font-bold' : 'text-zinc-300 hover:bg-[#18181B] hover:text-white'
              }"
            >
              <span class="truncate">${escapeHtml(mod.title)}</span>
              <span class="font-mono text-[10px] opacity-75 shrink-0">${escapeHtml(getModuleLiveKpi(mod.id))}</span>
            </button>
          `;
        }).join('');
      }

      // ----------------------------------------------------------------------
      // RENDER: HEADER USUARIO ACTIVO & CARRITO RÁPIDO
      // ----------------------------------------------------------------------
      function renderHeaderAndQuickCart() {
        const activeUser = getActiveUser();
        const shortRole = activeUser.role === 'Administrador' ? 'Admin' : activeUser.role.split('/')[0].trim();
        document.getElementById('headerActiveUserText').textContent = `${activeUser.name} · ${shortRole}`;
        document.getElementById('sideNavUserFooter').innerHTML = `Sesión: <strong class="text-white">${escapeHtml(activeUser.name)}</strong>`;

        // Lista del popover de cambio rápido de usuario
        const switcherList = document.getElementById('userSwitcherList');
        switcherList.innerHTML = STORE.users.filter((u) => u.active).map((u) => {
          const isSelected = u.id === activeUser.id;
          return `
            <button
              type="button"
              data-switch-user="${u.id}"
              class="w-full p-2 rounded-xl border text-left flex items-center justify-between gap-2 transition-colors ${
                isSelected ? 'bg-indigo-600/20 border-indigo-500/50 text-white' : 'bg-[#18181B] border-[#27272A] text-zinc-300 hover:text-white'
              }"
            >
              <div class="min-w-0">
                <p class="text-xs font-bold truncate">${escapeHtml(u.name)}</p>
                <p class="text-[10px] text-zinc-400 truncate">${escapeHtml(u.role)}</p>
              </div>
              ${isSelected ? '<span class="text-[10px] font-mono font-bold text-indigo-400">ACTIVO</span>' : ''}
            </button>
          `;
        }).join('');

        // Badge de carrito
        const totalQty = STORE.cart.reduce((acc, item) => acc + item.qty, 0);
        const badge = document.getElementById('headerCartBadge');
        badge.textContent = totalQty;

        // Métodos de pago sincronizados
        document.querySelectorAll('.pay-method-btn').forEach((btn) => {
          const active = btn.dataset.payMethod === STORE.paymentMethod;
          btn.className = btn.closest('#quickCartPanel')
            ? `pay-method-btn py-1.5 px-2 rounded-lg text-[11px] ${active ? 'font-bold bg-blue-600 text-white' : 'font-semibold bg-[#09090B] text-zinc-300 border border-[#27272A]'}`
            : `pay-method-btn py-2 px-2 rounded-xl text-xs ${active ? 'font-bold bg-blue-600 text-white' : 'font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]'}`;
        });

        const subtotal = STORE.cart.reduce((acc, item) => acc + item.price * item.qty, 0);
        const isSplit = STORE.paymentMethod === 'Dividido';
        const terminalBase = isSplit
          ? (Number(STORE.splitPayment.Terminal) || 0)
          : (STORE.paymentMethod === 'Terminal' ? subtotal : 0);
        const fee = terminalBase * (STORE.terminalFeePct / 100);
        const net = Math.max(0, subtotal - fee);
        const splitAssigned = (Number(STORE.splitPayment.Efectivo) || 0) + (Number(STORE.splitPayment.Transferencia) || 0) + (Number(STORE.splitPayment.Terminal) || 0);
        const splitValid = !isSplit || (subtotal > 0 && Math.abs(subtotal - splitAssigned) < 0.01);

        const qList = document.getElementById('quickCartItemsList');
        if (STORE.cart.length === 0) {
          qList.innerHTML = `<div class="p-6 text-center text-xs text-zinc-500 border border-dashed border-[#27272A] rounded-xl">Tu carrito está vacío. Escanea un QR o agrega desde Stock.</div>`;
        } else {
          qList.innerHTML = STORE.cart.map((item) => `
            <div class="p-2.5 rounded-xl bg-[#18181B] border border-[#27272A] flex items-center justify-between gap-2">
              <div class="min-w-0">
                <p class="text-xs font-bold text-white truncate">${escapeHtml(item.name)}</p>
                <p class="font-mono text-[10px] text-zinc-400">${escapeHtml(item.qr)} • ${formatMoney(item.price)} c/u</p>
              </div>
              <div class="flex items-center gap-1.5 shrink-0">
                <button type="button" data-cart-delta="-1" data-cart-id="${item.productId}" class="w-6 h-6 rounded-lg bg-[#09090B] border border-[#27272A] text-xs font-bold text-zinc-300 hover:text-white">-</button>
                <span class="font-mono text-xs font-bold w-5 text-center">${item.qty}</span>
                <button type="button" data-cart-delta="1" data-cart-id="${item.productId}" class="w-6 h-6 rounded-lg bg-[#09090B] border border-[#27272A] text-xs font-bold text-zinc-300 hover:text-white">+</button>
              </div>
            </div>
          `).join('');
        }

        const qFeeRow = document.getElementById('quickCartFeeRow');
        if (fee > 0) {
          qFeeRow.classList.remove('hidden');
          document.getElementById('quickCartFeeLabel').textContent = `Comisión Terminal (${STORE.terminalFeePct}%)`;
          document.getElementById('quickCartFeeAmount').textContent = `-${formatMoney(fee)}`;
        } else {
          qFeeRow.classList.add('hidden');
        }
        document.getElementById('quickCartTotalAmount').textContent = `${formatMoney(net)} MXN`;
        document.getElementById('btnQuickCheckout').disabled = STORE.cart.length === 0 || !splitValid;
      }

      // ----------------------------------------------------------------------
      // MÓDULO 1: STOCK
      // ----------------------------------------------------------------------
      function renderStockModule() {
        const filtersEl = document.getElementById('stockCategoryFilters');
        filtersEl.innerHTML = STOCK_CATEGORIES.map((cat) => {
          const active = STORE.ui.stockCategory === cat;
          return `
            <button
              type="button"
              data-stock-cat="${escapeHtml(cat)}"
              class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors ${
                active ? 'bg-blue-600 text-white' : 'bg-[#121215] text-zinc-400 hover:text-white border border-[#27272A]'
              }"
            >
              ${escapeHtml(cat)}
            </button>
          `;
        }).join('');

        const q = STORE.ui.stockSearch.toLowerCase().trim();
        const filtered = STORE.products.filter((p) => {
          const matchCat = STORE.ui.stockCategory === 'Todos' || p.category === STORE.ui.stockCategory;
          const matchSearch = !q ||
            p.name.toLowerCase().includes(q) ||
            p.qr.toLowerCase().includes(q) ||
            p.color.toLowerCase().includes(q) ||
            p.size.toLowerCase().includes(q) ||
            p.category.toLowerCase().includes(q);
          return matchCat && matchSearch;
        });

        const grid = document.getElementById('stockProductsGrid');
        if (filtered.length === 0) {
          grid.innerHTML = `<div class="col-span-full p-8 text-center text-xs text-zinc-500 bg-[#121215] border border-dashed border-[#27272A] rounded-2xl">No se encontraron productos con esos filtros.</div>`;
          return;
        }

        grid.innerHTML = filtered.map((p) => {
          const pal = STORE.colorPalette.find((c) => c.name === p.color);
          const hex = pal ? pal.hex : '#52525B';
          const lowStock = p.stock < 10;
          return `
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 flex flex-col justify-between gap-3">
              <div>
                <div class="flex items-center justify-between gap-2 mb-2">
                  <span class="font-mono text-[11px] font-bold px-2 py-0.5 rounded bg-blue-500/15 text-blue-400 border border-blue-500/30">${escapeHtml(p.qr)}</span>
                  <span class="font-mono text-[11px] font-bold px-2 py-0.5 rounded ${
                    lowStock ? 'bg-amber-500/15 text-amber-400 border border-amber-500/30' : 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30'
                  }">
                    ${p.stock} uds.
                  </span>
                </div>
                <h4 class="text-sm font-extrabold text-white">${escapeHtml(p.name)}</h4>
                <p class="text-[11px] text-zinc-400 mt-0.5">${escapeHtml(p.category)}</p>

                <div class="mt-2.5 flex flex-wrap items-center gap-2 text-[11px] text-zinc-300">
                  ${p.color !== 'N/A' ? `
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg bg-[#09090B] border border-[#27272A]">
                      <span class="w-2.5 h-2.5 rounded-full border border-white/20" style="background:${hex}"></span>
                      ${escapeHtml(p.color)}
                    </span>
                  ` : ''}
                  <span class="font-mono px-2 py-0.5 rounded-lg bg-[#09090B] border border-[#27272A]">
                    ${p.category === 'Tote bag' || p.category === 'Cuadros' || p.category === 'Llaveros' ? escapeHtml(p.size) : 'Talla ' + escapeHtml(p.size)}
                  </span>
                </div>
              </div>

              <div class="pt-3 border-t border-[#27272A] flex flex-col gap-2">
                <div class="flex items-center justify-between">
                  <span class="font-mono text-base font-black text-emerald-400">${formatMoney(p.price)}</span>
                  <div class="flex items-center gap-1">
                    <button type="button" data-stock-adj="-1" data-prod-id="${p.id}" class="w-7 h-7 rounded-lg bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-xs font-bold">-1</button>
                    <button type="button" data-stock-adj="1" data-prod-id="${p.id}" class="w-7 h-7 rounded-lg bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-xs font-bold">+1</button>
                  </div>
                </div>
                <div class="grid grid-cols-3 gap-1.5">
                  <button type="button" data-download-qr-id="${p.id}" class="py-2 px-2 rounded-xl bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-[11px] font-bold text-zinc-200 transition-colors">
                    Pegatina QR
                  </button>
                  <button type="button" data-add-cart-id="${p.id}" ${p.stock <= 0 ? 'disabled' : ''} class="py-2 px-2 rounded-xl bg-blue-600 hover:bg-blue-500 disabled:opacity-40 text-[11px] font-bold text-white transition-colors">
                    + Carrito
                  </button>
                  <button type="button" data-delete-stock-id="${p.id}" class="py-2 px-2 rounded-xl bg-rose-600/15 hover:bg-rose-600 border border-rose-500/35 text-[11px] font-bold text-rose-300 hover:text-white transition-colors" title="Eliminar artículo del stock">
                    Eliminar
                  </button>
                </div>
              </div>
            </div>
          `;
        }).join('');
      }

      // ----------------------------------------------------------------------
      // MÓDULO 2: MATERIA PRIMA
      // ----------------------------------------------------------------------
      function syncRawMaterialFormVisibility() {
        const cat = document.getElementById('rmCategory').value;
        const isShirt = cat === 'Playeras';
        const isApparel = cat === 'Playeras' || cat === 'Hoodies';
        const isCustomMeasure = cat === 'Lámina / aluminio';
        const isFixedMeasure = cat === 'Tote bag' || cat === 'Llavero / MDF';
        const hasColor = cat === 'Playeras' || cat === 'Hoodies' || cat === 'Tote bag';

        document.getElementById('rmShirtTypeWrapper').classList.toggle('hidden', !isShirt);
        document.getElementById('rmApparelSizeWrapper').classList.toggle('hidden', !isApparel);
        document.getElementById('rmCustomMeasureWrapper').classList.toggle('hidden', !isCustomMeasure);
        document.getElementById('rmFixedMeasureWrapper').classList.toggle('hidden', !isFixedMeasure);
        document.getElementById('rmColorSection').classList.toggle('hidden', !hasColor);

        if (cat === 'Tote bag') {
          document.getElementById('rmFixedMeasureBadge').textContent = '35×40 cm (Única)';
        } else if (cat === 'Llavero / MDF') {
          document.getElementById('rmFixedMeasureBadge').textContent = '5×5 cm (Única)';
        }
      }

      function renderRawMaterialsModule() {
        syncRawMaterialFormVisibility();

        const swatchesEl = document.getElementById('rmColorSwatchesList');
        document.getElementById('rmSelectedColorLabel').textContent = STORE.ui.rmSelectedColorName;
        swatchesEl.innerHTML = STORE.colorPalette.map((c) => {
          const active = c.name === STORE.ui.rmSelectedColorName;
          return `
            <button
              type="button"
              data-rm-color="${escapeHtml(c.name)}"
              class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-[11px] font-semibold transition-all ${
                active ? 'bg-indigo-600/25 border-indigo-400 text-white' : 'bg-[#121215] border-[#27272A] text-zinc-300 hover:border-zinc-500'
              }"
            >
              <span class="w-3 h-3 rounded-full border border-white/25 shrink-0" style="background:${c.hex}"></span>
              <span>${escapeHtml(c.name)}</span>
            </button>
          `;
        }).join('');

        const lowCount = STORE.rawMaterials.filter((r) => r.qty < 10).length;
        document.getElementById('rmLowStockSummary').textContent = `${lowCount} alerta${lowCount === 1 ? '' : 's'} (<10 u.)`;

        const listEl = document.getElementById('rawMaterialsList');
        listEl.innerHTML = STORE.rawMaterials.map((rm) => {
          const isLow = rm.qty < 10;
          const pal = STORE.colorPalette.find((c) => c.name === rm.color);
          return `
            <div class="p-3 rounded-xl bg-[#09090B] border ${isLow ? 'border-amber-500/45' : 'border-[#27272A]'} flex flex-wrap items-center justify-between gap-2.5">
              <div class="min-w-0">
                <div class="flex items-center gap-2">
                  <h4 class="text-xs font-extrabold text-white truncate">${escapeHtml(rm.name)}</h4>
                  ${isLow ? '<span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300">BAJO STOCK</span>' : ''}
                </div>
                <p class="text-[11px] text-zinc-400 mt-0.5">
                  ${escapeHtml(rm.category)}${rm.subType ? ' (' + escapeHtml(rm.subType) + ')' : ''} • ${escapeHtml(rm.sizeOrMeasure)}
                  ${rm.color !== 'N/A' ? ` • <span class="inline-block w-2 h-2 rounded-full align-middle" style="background:${pal ? pal.hex : '#71717A'}"></span> ${escapeHtml(rm.color)}` : ''}
                </p>
                <p class="text-[10px] text-zinc-500 mt-0.5">Costo: ${formatMoney(rm.cost)} • Reg: ${escapeHtml(rm.updatedBy)}</p>
              </div>

              <div class="flex items-center gap-1.5 shrink-0">
                <button type="button" data-rm-delta="-1" data-rm-id="${rm.id}" class="w-7 h-7 rounded-lg bg-[#18181B] border border-[#27272A] text-xs font-bold hover:text-white">-1</button>
                <span class="font-mono text-xs font-extrabold px-2 ${isLow ? 'text-amber-400' : 'text-emerald-400'}">${rm.qty} u.</span>
                <button type="button" data-rm-delta="5" data-rm-id="${rm.id}" class="w-7 h-7 rounded-lg bg-[#18181B] border border-[#27272A] text-xs font-bold hover:text-white">+5</button>
                <button type="button" data-delete-rm="${rm.id}" class="px-2 h-7 rounded-lg bg-rose-600/15 hover:bg-rose-600 border border-rose-500/35 text-rose-300 hover:text-white text-[11px] font-bold transition-colors" title="Eliminar insumo">
                  Eliminar
                </button>
              </div>
            </div>
          `;
        }).join('');
      }

      // ----------------------------------------------------------------------
      // MÓDULO 3: FINANZAS
      // ----------------------------------------------------------------------
      function computeFinanceMetrics() {
        const categoriesOrder = [
          'Playeras: Infantil',
          'Playeras: Regular fit',
          'Playeras: Oversize',
          'Hoodies',
          'Tote bag',
          'Cuadros',
          'Llaveros',
          'Personalizados'
        ];

        const statsByType = {};
        categoriesOrder.forEach((c) => {
          statsByType[c] = { units: 0, revenue: 0, cost: 0 };
        });

        const from = STORE.ui.finDateFrom;
        const to = STORE.ui.finDateTo;

        const filteredSales = STORE.sales.filter((s) => {
          if (from && s.date < from) return false;
          if (to && s.date > to) return false;
          return true;
        });

        let grossSales = 0;
        let terminalFees = 0;
        let totalCost = 0;

        filteredSales.forEach((sale) => {
          grossSales += sale.grossAmount;
          const terminalPortion = sale.splitDetails
            ? (Number(sale.splitDetails.Terminal) || 0)
            : (sale.method === 'Terminal' ? sale.grossAmount : 0);
          const fee = terminalPortion * (STORE.terminalFeePct / 100);
          terminalFees += fee;
          totalCost += sale.costAmount;

          (sale.items || []).forEach((it) => {
            const key = statsByType[it.category] ? it.category : 'Personalizados';
            statsByType[key].units += it.qty;
            statsByType[key].revenue += it.price * it.qty;
            statsByType[key].cost += (it.cost || 0) * it.qty;
          });
        });

        const netSales = grossSales - terminalFees;
        const netProfit = netSales - totalCost;

        return { filteredSales, grossSales, terminalFees, netSales, totalCost, netProfit, statsByType, categoriesOrder };
      }

      function renderFinanceModule() {
        const fin = computeFinanceMetrics();

        const kpis = [
          { label: 'Ventas Brutas', val: formatMoney(fin.grossSales), color: 'text-white' },
          { label: `Comisión Terminal (${STORE.terminalFeePct}%)`, val: `-${formatMoney(fin.terminalFees)}`, color: 'text-amber-400' },
          { label: 'Ingresos Netos', val: formatMoney(fin.netSales), color: 'text-blue-400' },
          { label: 'Costos Elaboración', val: formatMoney(fin.totalCost), color: 'text-zinc-300' },
          { label: 'Utilidad Neta', val: formatMoney(fin.netProfit), color: 'text-emerald-400' }
        ];

        document.getElementById('financeKpiGrid').innerHTML = kpis.map((k) => `
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5">
            <span class="block text-[11px] text-zinc-400 truncate">${escapeHtml(k.label)}</span>
            <span class="block font-mono text-sm sm:text-base font-black ${k.color} mt-1 truncate">${escapeHtml(k.val)}</span>
          </div>
        `).join('');

        const maxRev = Math.max(1, ...Object.values(fin.statsByType).map((v) => v.revenue));
        document.getElementById('financeBarChart').innerHTML = fin.categoriesOrder.map((cat) => {
          const st = fin.statsByType[cat];
          const pct = Math.round((st.revenue / maxRev) * 100);
          return `
            <div class="flex flex-col gap-1">
              <div class="flex items-center justify-between text-xs">
                <span class="font-semibold text-zinc-200">${escapeHtml(cat)}</span>
                <span class="font-mono text-zinc-400">${st.units} uds. • <strong class="text-white">${formatMoney(st.revenue)}</strong></span>
              </div>
              <div class="w-full h-2.5 rounded-full bg-[#09090B] border border-[#27272A] overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-blue-600 to-indigo-500 transition-all duration-300" style="width:${pct}%"></div>
              </div>
            </div>
          `;
        }).join('');

        document.getElementById('financeProfitabilityBody').innerHTML = fin.categoriesOrder.map((cat) => {
          const st = fin.statsByType[cat];
          const margin = st.revenue - st.cost;
          return `
            <tr class="hover:bg-[#18181B]/70">
              <td class="py-2.5 px-3 font-semibold text-zinc-200">${escapeHtml(cat)}</td>
              <td class="py-2.5 px-2 text-right font-mono text-zinc-400">${st.units}</td>
              <td class="py-2.5 px-2 text-right font-mono text-zinc-200">${formatMoney(st.revenue)}</td>
              <td class="py-2.5 px-2 text-right font-mono text-zinc-400">${formatMoney(st.cost)}</td>
              <td class="py-2.5 px-3 text-right font-mono font-bold ${margin >= 0 ? 'text-emerald-400' : 'text-rose-400'}">${formatMoney(margin)}</td>
            </tr>
          `;
        }).join('');
      }

      // ----------------------------------------------------------------------
      // MÓDULO 4: CARRITO POS
      // ----------------------------------------------------------------------
      function addProductToCartByQr(qrRaw) {
        const code = String(qrRaw || '').trim().toUpperCase();
        if (!code) return;
        const prod = STORE.products.find((p) => p.qr.toUpperCase() === code);
        const lastLabel = document.getElementById('qrLastReadLabel');

        if (!prod) {
          if (lastLabel) lastLabel.textContent = `Código no encontrado: ${code}`;
          showToast(`QR "${code}" no registrado en Stock`, 'error');
          return;
        }
        if (prod.stock <= 0) {
          if (lastLabel) lastLabel.textContent = `Sin existencias: ${prod.name}`;
          showToast(`Sin existencias disponibles para ${prod.name}`, 'warn');
          return;
        }

        const existing = STORE.cart.find((c) => c.productId === prod.id);
        if (existing) {
          if (existing.qty >= prod.stock) {
            showToast(`Stock máximo alcanzado (${prod.stock} uds.)`, 'warn');
            return;
          }
          existing.qty += 1;
        } else {
          STORE.cart.push({
            productId: prod.id,
            qr: prod.qr,
            name: prod.name,
            category: prod.category,
            color: prod.color,
            size: prod.size,
            price: prod.price,
            cost: prod.cost,
            qty: 1
          });
        }

        if (lastLabel) lastLabel.textContent = `${prod.qr} → ${prod.name} (${formatMoney(prod.price)})`;
        showToast(`Agregado: ${prod.name}`);
        renderAll();
      }

      function completeCheckoutSale() {
        if (STORE.cart.length === 0) return;
        const activeUser = getActiveUser();
        const gross = STORE.cart.reduce((acc, it) => acc + it.price * it.qty, 0);
        const cost = STORE.cart.reduce((acc, it) => acc + it.cost * it.qty, 0);

        const isSplit = STORE.paymentMethod === 'Dividido';
        let terminalBase = 0;
        let methodLabel = STORE.paymentMethod;
        let splitDetails = null;

        if (isSplit) {
          const ef = Math.max(0, Number(STORE.splitPayment.Efectivo) || 0);
          const tr = Math.max(0, Number(STORE.splitPayment.Transferencia) || 0);
          const te = Math.max(0, Number(STORE.splitPayment.Terminal) || 0);
          const assigned = ef + tr + te;
          if (Math.abs(gross - assigned) >= 0.01) {
            showToast('La suma del pago dividido debe coincidir con el subtotal', 'warn');
            return;
          }
          terminalBase = te;
          splitDetails = { Efectivo: ef, Transferencia: tr, Terminal: te };
          const parts = [];
          if (ef > 0) parts.push(`Efectivo ${formatMoney(ef)}`);
          if (tr > 0) parts.push(`Transferencia ${formatMoney(tr)}`);
          if (te > 0) parts.push(`Terminal ${formatMoney(te)}`);
          methodLabel = `Dividido (${parts.join(' + ')})`;
        } else if (STORE.paymentMethod === 'Terminal') {
          terminalBase = gross;
        }

        const fee = terminalBase * (STORE.terminalFeePct / 100);
        const net = Math.max(0, gross - fee);

        // Descontar de Stock y registrar movimientos
        STORE.cart.forEach((item) => {
          const prod = STORE.products.find((p) => p.id === item.productId);
          if (prod) {
            prod.stock = Math.max(0, prod.stock - item.qty);
          }
          STORE.stockMovements.unshift({
            id: 'sm-' + Date.now() + Math.random(),
            date: todayIso,
            product: item.name,
            qr: item.qr,
            type: `Venta POS (${methodLabel})`,
            delta: -item.qty,
            user: activeUser.name
          });
        });

        const folio = `VTA-${1041 + STORE.sales.length}`;
        STORE.sales.unshift({
          id: 's-' + Date.now(),
          folio,
          date: todayIso,
          user: activeUser.name,
          method: methodLabel,
          splitDetails,
          grossAmount: gross,
          feeAmount: fee,
          netAmount: net,
          costAmount: cost,
          items: STORE.cart.map((c) => ({ ...c }))
        });

        STORE.cart = [];
        STORE.splitPayment = { Efectivo: 0, Transferencia: 0, Terminal: 0 };
        document.getElementById('quickCartPanel').classList.remove('is-open');
        document.getElementById('quickCartBackdrop').classList.add('hidden');
        showToast(`Venta ${folio} registrada (${formatMoney(net)} neto)`);
        renderAll();
      }

      function renderPosCartModule() {
        const activeUser = getActiveUser();
        document.getElementById('posCashierIndicator').textContent = `Cajero: ${activeUser.name}`;

        const listEl = document.getElementById('posCartItemsList');
        if (STORE.cart.length === 0) {
          listEl.innerHTML = `<div class="p-6 text-center text-xs text-zinc-500 border border-dashed border-[#27272A] rounded-xl">Escanea un código QR o selecciona un acceso rápido para iniciar la venta.</div>`;
        } else {
          listEl.innerHTML = STORE.cart.map((item) => `
            <div class="p-3 rounded-xl bg-[#09090B] border border-[#27272A] flex items-center justify-between gap-2.5">
              <div class="min-w-0">
                <p class="text-xs font-extrabold text-white truncate">${escapeHtml(item.name)}</p>
                <p class="font-mono text-[11px] text-zinc-400">${escapeHtml(item.qr)} • ${escapeHtml(item.size)} • ${formatMoney(item.price)} c/u</p>
              </div>
              <div class="flex items-center gap-2 shrink-0">
                <button type="button" data-cart-delta="-1" data-cart-id="${item.productId}" class="w-7 h-7 rounded-lg bg-[#18181B] border border-[#27272A] text-xs font-bold">-</button>
                <span class="font-mono text-xs font-extrabold w-5 text-center">${item.qty}</span>
                <button type="button" data-cart-delta="1" data-cart-id="${item.productId}" class="w-7 h-7 rounded-lg bg-[#18181B] border border-[#27272A] text-xs font-bold">+</button>
                <span class="font-mono text-xs font-bold text-emerald-400 w-20 text-right">${formatMoney(item.price * item.qty)}</span>
              </div>
            </div>
          `).join('');
        }

        const subtotal = STORE.cart.reduce((acc, it) => acc + it.price * it.qty, 0);
        const isSplit = STORE.paymentMethod === 'Dividido';
        const splitBox = document.getElementById('posSplitPaymentBox');
        splitBox.classList.toggle('hidden', !isSplit);

        let terminalBase = 0;
        let splitValid = true;

        if (isSplit) {
          const ef = Math.max(0, Number(STORE.splitPayment.Efectivo) || 0);
          const tr = Math.max(0, Number(STORE.splitPayment.Transferencia) || 0);
          const te = Math.max(0, Number(STORE.splitPayment.Terminal) || 0);

          const efInp = document.getElementById('splitPayEfectivo');
          const trInp = document.getElementById('splitPayTransferencia');
          const teInp = document.getElementById('splitPayTerminal');
          if (document.activeElement !== efInp) efInp.value = ef;
          if (document.activeElement !== trInp) trInp.value = tr;
          if (document.activeElement !== teInp) teInp.value = te;

          const assigned = ef + tr + te;
          const diff = subtotal - assigned;
          const statusBadge = document.getElementById('posSplitStatusBadge');

          if (subtotal > 0 && Math.abs(diff) < 0.01) {
            splitValid = true;
            statusBadge.className = 'font-mono text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-500/15 text-emerald-300';
            statusBadge.textContent = `✓ Cuadrado (${formatMoney(subtotal)})`;
          } else if (diff > 0) {
            splitValid = false;
            statusBadge.className = 'font-mono text-[10px] font-bold px-2 py-0.5 rounded bg-amber-500/15 text-amber-300';
            statusBadge.textContent = `Falta: ${formatMoney(diff)}`;
          } else {
            splitValid = false;
            statusBadge.className = 'font-mono text-[10px] font-bold px-2 py-0.5 rounded bg-rose-500/15 text-rose-300';
            statusBadge.textContent = `Excede: ${formatMoney(Math.abs(diff))}`;
          }
          terminalBase = te;
        } else if (STORE.paymentMethod === 'Terminal') {
          terminalBase = subtotal;
        }

        const fee = terminalBase * (STORE.terminalFeePct / 100);
        const net = Math.max(0, subtotal - fee);

        document.getElementById('posSubtotalLabel').textContent = `${formatMoney(subtotal)} MXN`;
        const feeRow = document.getElementById('posTerminalFeeRow');
        if (fee > 0) {
          feeRow.classList.remove('hidden');
          document.getElementById('posTerminalFeeLabel').textContent = isSplit
            ? `Comisión Terminal (${STORE.terminalFeePct}% sobre ${formatMoney(terminalBase)})`
            : `Comisión Terminal (${STORE.terminalFeePct}%)`;
          document.getElementById('posTerminalFeeAmount').textContent = `-${formatMoney(fee)} MXN`;
        } else {
          feeRow.classList.add('hidden');
        }
        document.getElementById('posTotalLabel').textContent = `${formatMoney(net)} MXN`;
        document.getElementById('btnCompletePosSale').disabled = STORE.cart.length === 0 || !splitValid;
      }

      // ----------------------------------------------------------------------
      // MÓDULO 5: COTIZACIÓN MULTI-GRUPO + DESCUENTO SELECTIVO + PDF
      // ----------------------------------------------------------------------
      function getQuoteArticleInsumoCost(art) {
        if (!art) return 0;
        let match = null;
        if (art.id === 'q-ovs') {
          match = STORE.rawMaterials.find((r) => r.category === 'Playeras' && r.subType === 'Oversize') || STORE.rawMaterials.find((r) => r.category === 'Playeras');
        } else if (art.id === 'q-reg') {
          match = STORE.rawMaterials.find((r) => r.category === 'Playeras' && r.subType === 'Regular fit') || STORE.rawMaterials.find((r) => r.category === 'Playeras');
        } else if (art.id === 'q-inf') {
          match = STORE.rawMaterials.find((r) => r.category === 'Playeras' && r.subType === 'Infantil') || STORE.rawMaterials.find((r) => r.category === 'Playeras');
        } else if (art.id === 'q-hod') {
          match = STORE.rawMaterials.find((r) => r.category === 'Hoodies');
        } else if (art.id === 'q-tot') {
          match = STORE.rawMaterials.find((r) => r.category === 'Tote bag');
        } else if (art.id === 'q-cua') {
          match = STORE.rawMaterials.find((r) => r.category === 'Lámina / aluminio');
        } else if (art.id === 'q-lla') {
          match = STORE.rawMaterials.find((r) => r.category === 'Llavero / MDF');
        }
        return match ? Number(match.cost) : Number(art.baseCost || 0);
      }

      function computeQuoteTotals() {
        const discountPct = Math.max(0, Math.min(80, Number(document.getElementById('quoteDiscountPctInput').value) || 0));
        const otherCost = Math.max(0, Number(document.getElementById('quoteOtherCostInput').value) || 0);

        let totalPieces = 0;
        let groupsSubtotal = 0;
        let totalDiscount = 0;
        let totalRealCost = 0;

        const computedGroups = STORE.quoteGroups.map((g) => {
          const pieces = g.breakdownRows.reduce((acc, r) => acc + (Number(r.qty) || 0), 0);
          const meterCost = Math.max(0, Number(g.dtfMeterCost ?? STORE.quoteBuilder.dtfMeterCost) || 0);
          const cm2Rate = meterCost / DTF_METER_AREA_CM2;
          const dtfPerPiece = g.allowsDtf
            ? g.dtfApps.reduce((acc, d) => acc + ((Number(d.widthCm) || 0) * (Number(d.heightCm) || 0) * cm2Rate), 0)
            : 0;
          // Fórmula: Insumos + DTF = Costo de producción; Precio de venta = Costo de producción + 100%
          const insumoCost = Number(g.baseCost) || 0;
          const unitProductionCost = insumoCost + dtfPerPiece;
          const unitPrice = unitProductionCost * 2;
          const grossGroup = unitPrice * pieces;
          const groupDiscount = g.applyDiscount ? grossGroup * (discountPct / 100) : 0;
          const netGroup = grossGroup - groupDiscount;
          const groupRealCost = unitProductionCost * pieces;

          totalPieces += pieces;
          groupsSubtotal += grossGroup;
          totalDiscount += groupDiscount;
          totalRealCost += groupRealCost;

          return { ...g, pieces, dtfPerPiece, unitProductionCost, unitPrice, grossGroup, groupDiscount, netGroup, groupRealCost };
        });

        const finalTotal = Math.max(0, groupsSubtotal - totalDiscount + otherCost);
        return { computedGroups, totalPieces, groupsSubtotal, totalDiscount, otherCost, discountPct, finalTotal, totalRealCost };
      }

      function renderQuoteModule() {
        const activeUser = getActiveUser();
        document.getElementById('quoteAuthorBadge').textContent = `${activeUser.name} (${activeUser.role})`;
        document.getElementById('quoteFolioPreview').textContent = `COT-${STORE.quoteFolioCounter}`;

        // Selector de clientes existentes
        const clientSelect = document.getElementById('quoteExistingClientSelect');
        const currentVal = clientSelect.value;
        clientSelect.innerHTML = `<option value="">-- Cliente nuevo o seleccionar --</option>` +
          STORE.customClients.map((c) => `<option value="${c.id}">${escapeHtml(c.name)} (${escapeHtml(c.phone)})</option>`).join('');
        clientSelect.value = currentVal;

        // Opciones de artículo base en constructor
        const selectedArt = QUOTE_ARTICLES.find((a) => a.id === STORE.quoteBuilder.selectedArticleId) || QUOTE_ARTICLES[0];
        document.getElementById('quoteGarmentOptions').innerHTML = QUOTE_ARTICLES.map((art) => {
          const active = art.id === selectedArt.id;
          const insumoCost = getQuoteArticleInsumoCost(art);
          return `
            <button
              type="button"
              data-quote-art="${art.id}"
              class="p-2.5 rounded-xl border text-left transition-all ${
                active ? 'bg-blue-600/20 border-blue-500 text-white' : 'bg-[#09090B] border-[#27272A] text-zinc-300 hover:border-zinc-500'
              }"
            >
              <p class="text-xs font-bold truncate">${escapeHtml(art.name)}</p>
              <p class="font-mono text-[11px] text-emerald-400 mt-0.5">Insumo: ${formatMoney(insumoCost)}</p>
            </button>
          `;
        }).join('');

        // Encabezado y controles dinámicos según tipo de producto seleccionado
        const mode = selectedArt.quoteMode;
        const breakdownTitle = document.getElementById('quoteBreakdownTitle');
        const breakdownHint = document.getElementById('quoteBreakdownHint');
        const btnAddBreakdownRow = document.getElementById('btnAddGroupBreakdownRow');

        if (mode === 'llavero') {
          breakdownTitle.textContent = '2. Cantidad de Llaveros';
          breakdownHint.textContent = 'Ingresa la cantidad total de llaveros para este grupo.';
          btnAddBreakdownRow.classList.add('hidden');
        } else if (mode === 'cuadro') {
          breakdownTitle.textContent = '2. Cantidad y Medida del Cuadro';
          breakdownHint.textContent = 'Elige entre 20 × 30 cm, 30 × 40 cm, 30 × 60 cm y 40 × 60 cm.';
          btnAddBreakdownRow.classList.remove('hidden');
          btnAddBreakdownRow.textContent = '+ Fila Medida';
        } else if (mode === 'totebag') {
          breakdownTitle.textContent = '2. Cantidad y Color de Tote Bag';
          breakdownHint.textContent = 'Colores disponibles: Negro y Hueso.';
          btnAddBreakdownRow.classList.remove('hidden');
          btnAddBreakdownRow.textContent = '+ Fila Color';
        } else {
          breakdownTitle.textContent = '2. Desglose de Cantidad, Color y Talla';
          breakdownHint.textContent = 'Combina varias tallas o colores dentro de este mismo grupo (S a XXXL).';
          btnAddBreakdownRow.classList.remove('hidden');
          btnAddBreakdownRow.textContent = '+ Fila Color / Talla';
        }

        // Filas de desglose del constructor según quoteMode
        const builderPieces = STORE.quoteBuilder.breakdownRows.reduce((acc, r) => acc + (Number(r.qty) || 0), 0);
        document.getElementById('builderGroupTotalPiecesBadge').textContent = `Grupo: ${builderPieces} pieza${builderPieces === 1 ? '' : 's'}`;

        document.getElementById('quoteGroupBreakdownRows').innerHTML = STORE.quoteBuilder.breakdownRows.map((row) => {
          if (mode === 'llavero') {
            return `
              <div class="flex items-center justify-between gap-3">
                <label class="text-xs font-semibold text-zinc-300">Cantidad (piezas):</label>
                <input
                  type="number"
                  min="1"
                  value="${row.qty}"
                  data-br-id="${row.id}"
                  data-br-field="qty"
                  class="w-32 px-3 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                  title="Cantidad"
                />
              </div>
            `;
          }

          if (mode === 'cuadro') {
            return `
              <div class="grid grid-cols-12 gap-1.5 items-center">
                <input
                  type="number"
                  min="1"
                  value="${row.qty}"
                  data-br-id="${row.id}"
                  data-br-field="qty"
                  class="col-span-4 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                  title="Cantidad"
                />
                <select
                  data-br-id="${row.id}"
                  data-br-field="measure"
                  class="col-span-7 px-2.5 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white"
                >
                  ${CUADRO_QUOTE_MEASURES.map((m) => `<option value="${m}" ${m === row.measure ? 'selected' : ''}>${m}</option>`).join('')}
                </select>
                <button
                  type="button"
                  data-remove-br="${row.id}"
                  class="col-span-1 py-1.5 rounded-lg text-zinc-500 hover:text-rose-400 text-xs font-bold text-center"
                  title="Quitar fila"
                >
                  ×
                </button>
              </div>
            `;
          }

          if (mode === 'totebag') {
            return `
              <div class="grid grid-cols-12 gap-1.5 items-center">
                <input
                  type="number"
                  min="1"
                  value="${row.qty}"
                  data-br-id="${row.id}"
                  data-br-field="qty"
                  class="col-span-4 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                  title="Cantidad"
                />
                <select
                  data-br-id="${row.id}"
                  data-br-field="color"
                  class="col-span-7 px-2.5 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] text-xs text-white"
                >
                  ${TOTEBAG_QUOTE_COLORS.map((col) => `<option value="${col}" ${col === row.color ? 'selected' : ''}>${col}</option>`).join('')}
                </select>
                <button
                  type="button"
                  data-remove-br="${row.id}"
                  class="col-span-1 py-1.5 rounded-lg text-zinc-500 hover:text-rose-400 text-xs font-bold text-center"
                  title="Quitar fila"
                >
                  ×
                </button>
              </div>
            `;
          }

          return `
            <div class="grid grid-cols-12 gap-1.5 items-center">
              <input
                type="number"
                min="1"
                value="${row.qty}"
                data-br-id="${row.id}"
                data-br-field="qty"
                class="col-span-3 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                title="Cantidad"
              />
              <select
                data-br-id="${row.id}"
                data-br-field="color"
                class="col-span-5 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] text-xs text-white"
              >
                ${STORE.colorPalette.map((c) => `<option value="${escapeHtml(c.name)}" ${c.name === row.color ? 'selected' : ''}>${escapeHtml(c.name)}</option>`).join('')}
              </select>
              <select
                data-br-id="${row.id}"
                data-br-field="size"
                class="col-span-3 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white"
              >
                ${APPAREL_SIZES_S_TO_XXXL.map((sz) => `<option value="${sz}" ${sz === row.size ? 'selected' : ''}>${sz}</option>`).join('')}
              </select>
              <button
                type="button"
                data-remove-br="${row.id}"
                class="col-span-1 py-1.5 rounded-lg text-zinc-500 hover:text-rose-400 text-xs font-bold text-center"
                title="Quitar fila"
              >
                ×
              </button>
            </div>
          `;
        }).join('');

        // Aplicaciones DTF del constructor con costo real por metro de DTF
        const dtfSection = document.getElementById('quoteDtfSection');
        const btnAddDtf = document.getElementById('btnAddDtfApp');
        const meterCostInput = document.getElementById('quoteDtfMeterCostInput');
        const meterCost = Math.max(0, Number(STORE.quoteBuilder.dtfMeterCost) || 0);
        const cm2Rate = meterCost / DTF_METER_AREA_CM2;

        if (document.activeElement !== meterCostInput) {
          meterCostInput.value = meterCost;
        }
        meterCostInput.disabled = !selectedArt.allowsDtf;
        document.getElementById('quoteDtfCm2RateBadge').textContent = `5,800 cm²/m → $${cm2Rate.toFixed(4)}/cm²`;

        dtfSection.classList.toggle('opacity-45', !selectedArt.allowsDtf);
        btnAddDtf.disabled = !selectedArt.allowsDtf;

        document.getElementById('quoteDtfAppsList').innerHTML = !selectedArt.allowsDtf
          ? `<p class="text-[11px] text-zinc-500">Este artículo ya incluye sublimación directa sin DTF adicional.</p>`
          : STORE.quoteBuilder.dtfApps.map((dtf) => {
              const area = (Number(dtf.widthCm) || 0) * (Number(dtf.heightCm) || 0);
              const costPiece = area * cm2Rate;
              return `
                <div class="grid grid-cols-12 gap-1.5 items-center">
                  <input
                    type="text"
                    value="${escapeHtml(dtf.label)}"
                    data-dtf-id="${dtf.id}"
                    data-dtf-field="label"
                    placeholder="Ubicación (ej. Pecho)"
                    class="col-span-4 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] text-xs text-white"
                  />
                  <input
                    type="number"
                    min="1"
                    value="${dtf.widthCm}"
                    data-dtf-id="${dtf.id}"
                    data-dtf-field="widthCm"
                    class="col-span-2 px-1.5 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                    title="Ancho cm"
                  />
                  <input
                    type="number"
                    min="1"
                    value="${dtf.heightCm}"
                    data-dtf-id="${dtf.id}"
                    data-dtf-field="heightCm"
                    class="col-span-2 px-1.5 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                    title="Alto cm"
                  />
                  <span class="col-span-3 font-mono text-[10px] text-indigo-300 text-right truncate">
                    +${formatMoney(costPiece)}/pz
                  </span>
                  <button type="button" data-remove-dtf="${dtf.id}" class="col-span-1 text-zinc-500 hover:text-rose-400 text-xs font-bold text-center">×</button>
                </div>
              `;
            }).join('');

        // Lista de grupos agregados en la cotización
        const totals = computeQuoteTotals();
        document.getElementById('quoteTotalPiecesSummary').textContent = `${totals.totalPieces} piezas en total (${totals.computedGroups.length} grupo${totals.computedGroups.length === 1 ? '' : 's'})`;

        const groupsListEl = document.getElementById('quoteAddedGroupsList');
        if (totals.computedGroups.length === 0) {
          groupsListEl.innerHTML = `<div class="p-5 text-center text-xs text-zinc-500 border border-dashed border-[#27272A] rounded-xl">Configura un grupo a la izquierda y pulsa "+ Agregar Grupo a la Cotización".</div>`;
        } else {
          groupsListEl.innerHTML = totals.computedGroups.map((g) => {
            const detailStr = g.breakdownRows.map((r) => {
              if (g.quoteMode === 'llavero') return `${r.qty} pzs`;
              if (g.quoteMode === 'cuadro') return `${r.qty} (${r.measure})`;
              if (g.quoteMode === 'totebag') return `${r.qty} ${r.color}`;
              return `${r.qty} ${r.color} (${r.size})`;
            }).join(', ');
            return `
              <div class="p-3 rounded-xl bg-[#09090B] border ${g.applyDiscount ? 'border-amber-500/45' : 'border-[#27272A]'} flex flex-col gap-2">
                <div class="flex items-start justify-between gap-2">
                  <div class="min-w-0">
                    <h4 class="text-xs font-extrabold text-white truncate">${g.pieces}× ${escapeHtml(g.articleName)}</h4>
                    <p class="text-[11px] text-zinc-400 truncate">${escapeHtml(detailStr)}</p>
                  </div>
                  <button type="button" data-remove-qgroup="${g.id}" class="text-xs font-bold text-zinc-500 hover:text-rose-400 px-1">Eliminar</button>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-[#27272A] text-[11px]">
                  <label class="inline-flex items-center gap-1.5 cursor-pointer text-amber-300 font-semibold">
                    <input type="checkbox" data-toggle-qgroup-disc="${g.id}" ${g.applyDiscount ? 'checked' : ''} class="w-3.5 h-3.5 rounded bg-[#121215] border-zinc-600 text-amber-500" />
                    <span>Aplicar ${totals.discountPct}% desc.</span>
                  </label>
                  <div class="font-mono text-right">
                    ${g.applyDiscount ? `<span class="line-through text-zinc-500 mr-1.5">${formatMoney(g.grossGroup)}</span>` : ''}
                    <strong class="text-emerald-400">${formatMoney(g.netGroup)}</strong>
                  </div>
                </div>
              </div>
            `;
          }).join('');
        }

        document.getElementById('quoteLiveBreakdown').innerHTML = `
          <div class="flex justify-between text-zinc-400">
            <span>Subtotal grupos</span>
            <span class="font-mono text-zinc-200">${formatMoney(totals.groupsSubtotal)}</span>
          </div>
          <div class="flex justify-between text-amber-400">
            <span>Descuento selectivo (${totals.discountPct}%)</span>
            <span class="font-mono">-${formatMoney(totals.totalDiscount)}</span>
          </div>
          <div class="flex justify-between text-zinc-400">
            <span>Costo real producción (Insumos + DTF)</span>
            <span class="font-mono text-indigo-300">${formatMoney(totals.totalRealCost)}</span>
          </div>
          <div class="flex justify-between text-zinc-400">
            <span>Otros (Uso interno — oculto en PDF)</span>
            <span class="font-mono text-amber-300">+${formatMoney(totals.otherCost)}</span>
          </div>
          <div class="flex justify-between text-sm font-extrabold text-white pt-2 border-t border-[#27272A]">
            <span>Total Cotización</span>
            <span class="font-mono text-emerald-400">${formatMoney(totals.finalTotal)} MXN</span>
          </div>
        `;
      }

      // ----------------------------------------------------------------------
      // MÓDULO 6: REPORTES OPERATIVOS
      // ----------------------------------------------------------------------
      function renderReportsModule() {
        const tab = STORE.ui.reportTab;
        document.querySelectorAll('.report-tab-btn').forEach((btn) => {
          const active = btn.dataset.reportTab === tab;
          btn.className = active
            ? 'report-tab-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-600 text-white'
            : 'report-tab-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#18181B] text-zinc-300 border border-[#27272A]';
        });

        document.getElementById('reportTerminalFeeBar').classList.toggle('hidden', tab !== 'ventas');
        const feeInput = document.getElementById('terminalFeePctInput');
        if (document.activeElement !== feeInput) {
          feeInput.value = STORE.terminalFeePct;
        }

        const q = STORE.ui.reportSearch.toLowerCase().trim();
        const thead = document.getElementById('reportTableHead');
        const tbody = document.getElementById('reportTableBody');

        if (tab === 'ventas') {
          thead.innerHTML = `
            <tr>
              <th class="py-2.5 px-3">Folio</th>
              <th class="py-2.5 px-3">Fecha</th>
              <th class="py-2.5 px-3">Usuario</th>
              <th class="py-2.5 px-3">Método</th>
              <th class="py-2.5 px-3 text-right">Bruto</th>
              <th class="py-2.5 px-3 text-right">Comisión</th>
              <th class="py-2.5 px-3 text-right">Neto</th>
            </tr>
          `;
          const rows = STORE.sales.filter((s) =>
            !q ||
            s.folio.toLowerCase().includes(q) ||
            s.user.toLowerCase().includes(q) ||
            s.method.toLowerCase().includes(q)
          );
          tbody.innerHTML = rows.length === 0
            ? `<tr><td colspan="7" class="py-6 text-center text-zinc-500">Sin registros de ventas para ese filtro.</td></tr>`
            : rows.map((s) => {
                const terminalPortion = s.splitDetails
                  ? (Number(s.splitDetails.Terminal) || 0)
                  : (s.method === 'Terminal' ? s.grossAmount : 0);
                const fee = terminalPortion * (STORE.terminalFeePct / 100);
                const net = Math.max(0, s.grossAmount - fee);
                return `
                  <tr class="hover:bg-[#18181B]/70">
                    <td class="py-2.5 px-3 font-mono font-bold text-blue-400">${escapeHtml(s.folio)}</td>
                    <td class="py-2.5 px-3 font-mono text-zinc-400">${escapeHtml(s.date)}</td>
                    <td class="py-2.5 px-3 text-zinc-200">${escapeHtml(s.user)}</td>
                    <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(s.method)}</td>
                    <td class="py-2.5 px-3 text-right font-mono text-zinc-200">${formatMoney(s.grossAmount)}</td>
                    <td class="py-2.5 px-3 text-right font-mono text-amber-400">${fee > 0 ? '-' + formatMoney(fee) : '$0.00'}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-400">${formatMoney(net)}</td>
                  </tr>
                `;
              }).join('');
        } else if (tab === 'stock') {
          thead.innerHTML = `
            <tr>
              <th class="py-2.5 px-3">Fecha</th>
              <th class="py-2.5 px-3">Producto</th>
              <th class="py-2.5 px-3">QR</th>
              <th class="py-2.5 px-3">Movimiento</th>
              <th class="py-2.5 px-3 text-right">Cantidad</th>
              <th class="py-2.5 px-3">Usuario</th>
            </tr>
          `;
          const rows = STORE.stockMovements.filter((m) =>
            !q ||
            m.product.toLowerCase().includes(q) ||
            m.qr.toLowerCase().includes(q) ||
            m.type.toLowerCase().includes(q) ||
            m.user.toLowerCase().includes(q)
          );
          tbody.innerHTML = rows.length === 0
            ? `<tr><td colspan="6" class="py-6 text-center text-zinc-500">Sin movimientos de stock registrados.</td></tr>`
            : rows.map((m) => `
                <tr class="hover:bg-[#18181B]/70">
                  <td class="py-2.5 px-3 font-mono text-zinc-400">${escapeHtml(m.date)}</td>
                  <td class="py-2.5 px-3 font-semibold text-white">${escapeHtml(m.product)}</td>
                  <td class="py-2.5 px-3 font-mono text-blue-400">${escapeHtml(m.qr)}</td>
                  <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(m.type)}</td>
                  <td class="py-2.5 px-3 text-right font-mono font-bold ${m.delta >= 0 ? 'text-emerald-400' : 'text-amber-400'}">${m.delta > 0 ? '+' + m.delta : m.delta}</td>
                  <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(m.user)}</td>
                </tr>
              `).join('');
        } else if (tab === 'materias') {
          thead.innerHTML = `
            <tr>
              <th class="py-2.5 px-3">Insumo</th>
              <th class="py-2.5 px-3">Categoría</th>
              <th class="py-2.5 px-3">Color / Medida</th>
              <th class="py-2.5 px-3 text-right">Existencia</th>
              <th class="py-2.5 px-3 text-right">Costo Unit.</th>
              <th class="py-2.5 px-3">Actualizó</th>
            </tr>
          `;
          const rows = STORE.rawMaterials.filter((r) =>
            !q ||
            r.name.toLowerCase().includes(q) ||
            r.category.toLowerCase().includes(q) ||
            r.updatedBy.toLowerCase().includes(q)
          );
          tbody.innerHTML = rows.length === 0
            ? `<tr><td colspan="6" class="py-6 text-center text-zinc-500">Sin insumos de materia prima registrados.</td></tr>`
            : rows.map((r) => `
                <tr class="hover:bg-[#18181B]/70">
                  <td class="py-2.5 px-3 font-semibold text-white">${escapeHtml(r.name)}</td>
                  <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(r.category)}${r.subType ? ' (' + escapeHtml(r.subType) + ')' : ''}</td>
                  <td class="py-2.5 px-3 font-mono text-zinc-400">${escapeHtml(r.color)} • ${escapeHtml(r.sizeOrMeasure)}</td>
                  <td class="py-2.5 px-3 text-right font-mono font-bold ${r.qty < 10 ? 'text-amber-400' : 'text-emerald-400'}">${r.qty} u.</td>
                  <td class="py-2.5 px-3 text-right font-mono text-zinc-200">${formatMoney(r.cost)}</td>
                  <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(r.updatedBy)}</td>
                </tr>
              `).join('');
        } else {
          thead.innerHTML = `
            <tr>
              <th class="py-2.5 px-3">Folio</th>
              <th class="py-2.5 px-3">Cliente</th>
              <th class="py-2.5 px-3">Detalle</th>
              <th class="py-2.5 px-3">Estado</th>
              <th class="py-2.5 px-3 text-right">Total</th>
              <th class="py-2.5 px-3 text-right">Anticipo</th>
              <th class="py-2.5 px-3">Registró</th>
            </tr>
          `;
          const rows = STORE.orders.filter((o) =>
            !q ||
            o.folio.toLowerCase().includes(q) ||
            o.clientName.toLowerCase().includes(q) ||
            o.summary.toLowerCase().includes(q) ||
            o.createdBy.toLowerCase().includes(q)
          );
          tbody.innerHTML = rows.length === 0
            ? `<tr><td colspan="7" class="py-6 text-center text-zinc-500">Sin pedidos registrados.</td></tr>`
            : rows.map((o) => `
                <tr class="hover:bg-[#18181B]/70">
                  <td class="py-2.5 px-3 font-mono font-bold text-indigo-400">${escapeHtml(o.folio)}</td>
                  <td class="py-2.5 px-3 font-semibold text-white">${escapeHtml(o.clientName)}</td>
                  <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(o.summary)}</td>
                  <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(o.prodStatus)}</td>
                  <td class="py-2.5 px-3 text-right font-mono text-zinc-200">${formatMoney(o.totalAmount)}</td>
                  <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-400">${formatMoney(o.advancePaid)}</td>
                  <td class="py-2.5 px-3 text-zinc-300">${escapeHtml(o.createdBy)}</td>
                </tr>
              `).join('');
        }
      }

      // ----------------------------------------------------------------------
      // MÓDULO 7: PEDIDOS PERSONALIZADOS
      // ----------------------------------------------------------------------
      function renderOrdersModule() {
        const prodStatuses = ['Todos', 'Pendiente', 'En Producción', 'Listo para Entrega', 'Entregado'];
        const payStatuses = ['Todos', 'Con Saldo Pendiente', 'Liquidado'];

        document.getElementById('orderProdFilters').innerHTML = prodStatuses.map((st) => {
          const active = STORE.ui.orderProdFilter === st;
          return `
            <button
              type="button"
              data-ord-prod-filter="${escapeHtml(st)}"
              class="px-2.5 py-1 rounded-lg text-[11px] font-bold transition-colors ${
                active ? 'bg-blue-600 text-white' : 'bg-[#09090B] text-zinc-400 hover:text-white border border-[#27272A]'
              }"
            >
              ${escapeHtml(st)}
            </button>
          `;
        }).join('');

        document.getElementById('orderPayFilters').innerHTML = payStatuses.map((st) => {
          const active = STORE.ui.orderPayFilter === st;
          return `
            <button
              type="button"
              data-ord-pay-filter="${escapeHtml(st)}"
              class="px-2.5 py-1 rounded-lg text-[11px] font-bold transition-colors ${
                active ? 'bg-indigo-600 text-white' : 'bg-[#09090B] text-zinc-400 hover:text-white border border-[#27272A]'
              }"
            >
              ${escapeHtml(st)}
            </button>
          `;
        }).join('');

        const filtered = STORE.orders.filter((o) => {
          const matchProd = STORE.ui.orderProdFilter === 'Todos' || o.prodStatus === STORE.ui.orderProdFilter;
          const balance = Math.max(0, o.totalAmount - o.advancePaid);
          const matchPay =
            STORE.ui.orderPayFilter === 'Todos' ||
            (STORE.ui.orderPayFilter === 'Liquidado' && balance === 0) ||
            (STORE.ui.orderPayFilter === 'Con Saldo Pendiente' && balance > 0);
          return matchProd && matchPay;
        });

        const grid = document.getElementById('ordersCardsGrid');
        if (filtered.length === 0) {
          grid.innerHTML = `<div class="col-span-full p-8 text-center text-xs text-zinc-500 bg-[#121215] border border-dashed border-[#27272A] rounded-2xl">No hay pedidos que coincidan con los filtros seleccionados.</div>`;
          return;
        }

        grid.innerHTML = filtered.map((ord) => {
          const balance = Math.max(0, ord.totalAmount - ord.advancePaid);
          const isPaid = balance === 0;
          return `
            <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-4 flex flex-col justify-between gap-3">
              <div>
                <div class="flex items-center justify-between gap-2 mb-1.5">
                  <span class="font-mono text-xs font-extrabold px-2 py-0.5 rounded bg-indigo-500/15 text-indigo-400 border border-indigo-500/30">${escapeHtml(ord.folio)}</span>
                  <span class="font-mono text-[11px] font-bold px-2 py-0.5 rounded ${
                    isPaid ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/15 text-amber-300 border border-amber-500/30'
                  }">
                    ${isPaid ? 'LIQUIDADO' : 'SALDO: ' + formatMoney(balance)}
                  </span>
                </div>
                <h4 class="text-sm font-extrabold text-white">${escapeHtml(ord.clientName)}</h4>
                <p class="font-mono text-[11px] text-zinc-400">${escapeHtml(ord.clientPhone)} • ${escapeHtml(ord.date)}</p>
                <p class="text-xs text-zinc-300 mt-2 p-2.5 rounded-xl bg-[#09090B] border border-[#27272A]">${escapeHtml(ord.summary)}</p>
              </div>

              <div class="pt-3 border-t border-[#27272A] flex flex-col gap-2.5 text-xs">
                <div class="flex items-center justify-between gap-2">
                  <span class="text-zinc-400">Estado taller:</span>
                  <select data-ord-status="${ord.id}" class="px-2.5 py-1.5 rounded-lg bg-[#09090B] border border-[#27272A] text-xs font-bold text-white">
                    ${['Pendiente', 'En Producción', 'Listo para Entrega', 'Entregado'].map((st) =>
                      `<option value="${st}" ${st === ord.prodStatus ? 'selected' : ''}>${st}</option>`
                    ).join('')}
                  </select>
                </div>

                <div class="grid grid-cols-3 gap-2 p-2.5 rounded-xl bg-[#09090B] border border-[#27272A] font-mono text-[11px]">
                  <div>
                    <span class="block text-[10px] text-zinc-500">Total</span>
                    <strong class="text-white">${formatMoney(ord.totalAmount)}</strong>
                  </div>
                  <div>
                    <span class="block text-[10px] text-zinc-500">Anticipo</span>
                    <strong class="text-emerald-400">${formatMoney(ord.advancePaid)}</strong>
                  </div>
                  <div>
                    <span class="block text-[10px] text-zinc-500">Restante</span>
                    <strong class="${isPaid ? 'text-zinc-400' : 'text-amber-400'}">${formatMoney(balance)}</strong>
                  </div>
                </div>

                <div class="flex items-center gap-2">
                  <input
                    type="number"
                    id="adv-input-${ord.id}"
                    min="0"
                    max="${ord.totalAmount}"
                    step="10"
                    value="${ord.advancePaid}"
                    class="flex-1 min-w-0 px-2.5 py-1.5 rounded-lg bg-[#09090B] border border-[#27272A] font-mono text-xs text-white"
                  />
                  <button
                    type="button"
                    data-save-adv="${ord.id}"
                    class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-bold shrink-0"
                  >
                    Guardar Anticipo
                  </button>
                </div>
                                  <button
                  type="button"
                  data-wa-order="${ord.id}"
                  class="w-full py-2 px-3 rounded-lg text-[11px] font-bold transition-colors ${
                    ord.prodStatus === 'Listo para Entrega'
                      ? 'bg-green-600 hover:bg-green-500 text-white'
                      : 'bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-zinc-200'
                  }"
                >
                  ${ord.prodStatus === 'Listo para Entrega' ? 'Avisar por WhatsApp: Pedido Listo' : 'Enviar estatus por WhatsApp'}
                </button>
              </div>
            </div>
          `;
        }).join('');
      }

      // ----------------------------------------------------------------------
      // MÓDULO 8: REGISTRO DE PRODUCTO TERMINADO (CON TOTE BAG, DTF Y MATERIA PRIMA)
      // ----------------------------------------------------------------------
      function getMatchingRawMaterialsForRegCategory(category) {
        if (category === 'Playeras: Oversize') {
          const specific = STORE.rawMaterials.filter((r) => r.category === 'Playeras' && r.subType === 'Oversize');
          return specific.length > 0 ? specific : STORE.rawMaterials.filter((r) => r.category === 'Playeras');
        }
        if (category === 'Playeras: Regular fit') {
          const specific = STORE.rawMaterials.filter((r) => r.category === 'Playeras' && r.subType === 'Regular fit');
          return specific.length > 0 ? specific : STORE.rawMaterials.filter((r) => r.category === 'Playeras');
        }
        if (category === 'Playeras: Infantil') {
          const specific = STORE.rawMaterials.filter((r) => r.category === 'Playeras' && r.subType === 'Infantil');
          return specific.length > 0 ? specific : STORE.rawMaterials.filter((r) => r.category === 'Playeras');
        }
        if (category === 'Hoodies') {
          return STORE.rawMaterials.filter((r) => r.category === 'Hoodies');
        }
        if (category === 'Tote bag') {
          return STORE.rawMaterials.filter((r) => r.category === 'Tote bag');
        }
        if (category === 'Cuadros') {
          return STORE.rawMaterials.filter((r) => r.category === 'Lámina / aluminio');
        }
        if (category === 'Llaveros') {
          return STORE.rawMaterials.filter((r) => r.category === 'Llavero / MDF');
        }
        return STORE.rawMaterials;
      }

      function generateNextSkuQr() {
        const cat = document.getElementById('regProdCategory').value;
        const prefixMap = {
          'Playeras: Oversize': 'QR-OVS',
          'Playeras: Regular fit': 'QR-REG',
          'Playeras: Infantil': 'QR-INF',
          Hoodies: 'QR-HOD',
          'Tote bag': 'QR-TOT',
          Cuadros: 'QR-CUA',
          Llaveros: 'QR-LLA'
        };
        const prefix = prefixMap[cat] || 'QR-NFS';
        const nextNum = String(STORE.products.length + 1).padStart(2, '0');
        return `${prefix}-${nextNum}`;
      }

      function updateRegistroPreview(recalculateCostFromInputs = false) {
        const name = (document.getElementById('regProdName').value || '').trim() || 'Nuevo Producto Streetwear';
        const category = document.getElementById('regProdCategory').value;
        const qr = (document.getElementById('regProdQr').value || '').trim().toUpperCase() || 'QR-NFS-00';
        const isApparel = category.startsWith('Playeras') || category === 'Hoodies';
        const isToteBag = category === 'Tote bag';
        const hasColor = isApparel || isToteBag;
        const allowsDtf = isApparel || isToteBag;

        document.getElementById('regApparelAttrsBox').classList.toggle('hidden', !hasColor);
        document.getElementById('regSizeSelectWrapper').classList.toggle('hidden', !isApparel);
        document.getElementById('regFixedMeasureWrapper').classList.toggle('hidden', !isToteBag);
        document.getElementById('regDtfSection').classList.toggle('hidden', !allowsDtf);

        // Sincronizar selector de Materia Prima compatible con la categoría
        const matchingRms = getMatchingRawMaterialsForRegCategory(category);
        const rmPool = matchingRms.length > 0 ? matchingRms : STORE.rawMaterials;
        const rmSelect = document.getElementById('regRawMaterialSelect');

        if (!rmPool.some((r) => r.id === STORE.regBuilder.selectedRawMaterialId)) {
          STORE.regBuilder.selectedRawMaterialId = rmPool[0] ? rmPool[0].id : '';
        }

        rmSelect.innerHTML = rmPool.length === 0
          ? `<option value="">-- Sin insumos en Materia Prima --</option>`
          : rmPool.map((r) => `<option value="${r.id}" ${r.id === STORE.regBuilder.selectedRawMaterialId ? 'selected' : ''}>${escapeHtml(r.name)} (${escapeHtml(r.sizeOrMeasure)}) — ${formatMoney(r.cost)} [${r.qty} u.]</option>`).join('');

        const selectedRm = rmPool.find((r) => r.id === STORE.regBuilder.selectedRawMaterialId) || null;
        const rmUnitCost = selectedRm ? Number(selectedRm.cost) : 0;
        const rmAvailQty = selectedRm ? Number(selectedRm.qty) : 0;
        document.getElementById('regRmAvailBadge').textContent = selectedRm
          ? `Disponible: ${rmAvailQty} u. • Insumo: ${formatMoney(rmUnitCost)}`
          : 'Sin insumo vinculado';

        // Renderizar aplicaciones DTF de Registro (Playeras, Hoodies, Tote bag)
        const regMeterCostInput = document.getElementById('regDtfMeterCostInput');
        const regMeterCost = Math.max(0, Number(STORE.regBuilder.dtfMeterCost) || 0);
        const regCm2Rate = regMeterCost / DTF_METER_AREA_CM2;
        if (document.activeElement !== regMeterCostInput) {
          regMeterCostInput.value = regMeterCost;
        }
        document.getElementById('regDtfCm2RateBadge').textContent = `5,800 cm²/m → $${regCm2Rate.toFixed(4)}/cm²`;

        let dtfUnitCost = 0;
        if (allowsDtf) {
          dtfUnitCost = STORE.regBuilder.dtfApps.reduce((acc, d) => {
            return acc + ((Number(d.widthCm) || 0) * (Number(d.heightCm) || 0) * regCm2Rate);
          }, 0);

          document.getElementById('regDtfAppsList').innerHTML = STORE.regBuilder.dtfApps.length === 0
            ? `<p class="text-[11px] text-zinc-500">Sin aplicaciones DTF agregadas (solo costo de materia prima).</p>`
            : STORE.regBuilder.dtfApps.map((dtf) => {
                const area = (Number(dtf.widthCm) || 0) * (Number(dtf.heightCm) || 0);
                const costPiece = area * regCm2Rate;
                return `
                  <div class="grid grid-cols-12 gap-1.5 items-center">
                    <input
                      type="text"
                      value="${escapeHtml(dtf.label)}"
                      data-reg-dtf-id="${dtf.id}"
                      data-reg-dtf-field="label"
                      placeholder="Ubicación (ej. Pecho)"
                      class="col-span-4 px-2 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] text-xs text-white"
                    />
                    <input
                      type="number"
                      min="1"
                      value="${dtf.widthCm}"
                      data-reg-dtf-id="${dtf.id}"
                      data-reg-dtf-field="widthCm"
                      class="col-span-2 px-1.5 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                      title="Ancho cm"
                    />
                    <input
                      type="number"
                      min="1"
                      value="${dtf.heightCm}"
                      data-reg-dtf-id="${dtf.id}"
                      data-reg-dtf-field="heightCm"
                      class="col-span-2 px-1.5 py-1.5 rounded-lg bg-[#121215] border border-[#27272A] font-mono text-xs text-white text-center"
                      title="Alto cm"
                    />
                    <span class="col-span-3 font-mono text-[10px] text-indigo-300 text-right truncate">
                      +${formatMoney(costPiece)}/pz
                    </span>
                    <button type="button" data-remove-reg-dtf="${dtf.id}" class="col-span-1 text-zinc-500 hover:text-rose-400 text-xs font-bold text-center">×</button>
                  </div>
                `;
              }).join('');
        }

        if (!STORE.colorPalette.some((c) => c.name === STORE.ui.regSelectedColorName)) {
          STORE.ui.regSelectedColorName = STORE.colorPalette[0] ? STORE.colorPalette[0].name : 'Negro';
        }
        document.getElementById('regSelectedColorLabel').textContent = STORE.ui.regSelectedColorName;

        document.getElementById('regPaletteSwatches').innerHTML = STORE.colorPalette.map((c) => {
          const active = c.name === STORE.ui.regSelectedColorName;
          return `
            <button
              type="button"
              data-reg-color="${escapeHtml(c.name)}"
              class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-[11px] font-semibold transition-all ${
                active ? 'bg-emerald-600/25 border-emerald-400 text-white' : 'bg-[#121215] border-[#27272A] text-zinc-300 hover:border-zinc-500'
              }"
            >
              <span class="w-3 h-3 rounded-full border border-white/25 shrink-0" style="background:${c.hex}"></span>
              <span>${escapeHtml(c.name)}</span>
            </button>
          `;
        }).join('');

        const color = hasColor ? STORE.ui.regSelectedColorName : 'N/A';
        const size = isApparel
          ? document.getElementById('regProdSize').value
          : isToteBag
          ? '35×40 cm'
          : selectedRm
          ? selectedRm.sizeOrMeasure
          : category === 'Cuadros'
          ? '40×60 cm'
          : '5×5 cm';

        const costInput = document.getElementById('regProdCost');
        if (recalculateCostFromInputs && selectedRm) {
          const computedElab = Math.round((rmUnitCost + dtfUnitCost) * 100) / 100;
          costInput.value = computedElab;
        }

        const cost = Math.max(0.01, Number(costInput.value) || 0);
        const margin = Math.max(0, Number(document.getElementById('regProdMargin').value) || 0);
        const suggestedPrice = Math.round(cost * (1 + margin / 100));

        const useSuggested = document.getElementById('regUseSuggestedCheck').checked;
        const finalPriceInput = document.getElementById('regProdFinalPrice');
        if (useSuggested || !finalPriceInput.value) {
          finalPriceInput.value = suggestedPrice;
        }
        const finalPrice = Math.max(1, Number(finalPriceInput.value) || suggestedPrice);
        const unitProfit = finalPrice - cost;

        document.getElementById('regSuggestedPreview').textContent = formatMoney(suggestedPrice);
        document.getElementById('regUnitProfitPreview').textContent = `${unitProfit >= 0 ? '+' : ''}${formatMoney(unitProfit)}`;

        document.getElementById('regCardPreviewName').textContent = name;
        document.getElementById('regCardPreviewMeta').textContent = isApparel
          ? `${category} • ${color} • Talla ${size}`
          : isToteBag
          ? `${category} • ${color} • ${size}`
          : `${category} • ${size}`;
        document.getElementById('regCardPreviewQr').textContent = qr;
        document.getElementById('regCardPreviewPrice').textContent = formatMoney(finalPrice);

        drawQrMatrixOnCanvas(document.getElementById('regQrPreviewCanvas'), qr, 150);
      }

      // ----------------------------------------------------------------------
      // MÓDULO 9: USUARIOS
      // ----------------------------------------------------------------------
      function renderUsersModule() {
        const activeUser = getActiveUser();
        const isAdmin = activeUser.role === 'Administrador';
        const badge = document.getElementById('usersAdminPermBadge');
        const registrationPanel = document.getElementById('userRegistrationPanel');
        if (registrationPanel) registrationPanel.classList.toggle('hidden', !isAdmin);
        badge.textContent = isAdmin ? 'Modo Administrador (Permiso Total)' : `Modo ${activeUser.role} (Solo Lectura)`;

        document.getElementById('usersListContainer').innerHTML = STORE.users.map((u) => {
          const isSelf = u.id === activeUser.id;
          return `
            <div class="p-3 rounded-xl bg-[#09090B] border ${isSelf ? 'border-indigo-500/50' : 'border-[#27272A]'} flex flex-wrap items-center justify-between gap-2.5">
              <div class="min-w-0">
                <div class="flex items-center gap-2">
                  <h4 class="text-xs font-extrabold text-white truncate">${escapeHtml(u.name)}</h4>
                  ${isSelf ? '<span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-indigo-500/20 text-indigo-300">SESIÓN ACTIVA</span>' : ''}
                </div>
                <p class="font-mono text-[11px] text-zinc-400 mt-0.5">@${escapeHtml(u.alias)} • ${escapeHtml(u.role)} • PIN: ••••</p>
              </div>

              <div class="flex items-center gap-2 shrink-0">
                ${!isSelf ? `
                  <button type="button" data-switch-user="${u.id}" class="px-2.5 py-1.5 rounded-lg bg-[#18181B] hover:bg-zinc-800 border border-[#27272A] text-[11px] font-bold text-zinc-200">
                    Usar Sesión
                  </button>
                ` : ''}
                ${isAdmin && !isSelf ? `
                  <button type="button" data-ask-delete-user="${u.id}" class="px-2.5 py-1.5 rounded-lg bg-rose-600/20 hover:bg-rose-600 border border-rose-500/40 text-rose-300 hover:text-white text-[11px] font-bold transition-colors">
                    Eliminar
                  </button>
                ` : ''}
              </div>
            </div>
          `;
        }).join('');
      }

      // ----------------------------------------------------------------------
      // MÓDULO 10: CLIENTES PERSONALIZADOS
      // ----------------------------------------------------------------------
      function renderClientsModule() {
        const totalClients = STORE.customClients.length;
        const totalOrders = STORE.orders.length;
        const totalBilled = STORE.orders.reduce((acc, o) => acc + o.totalAmount, 0);

        document.getElementById('clientsKpiRow').innerHTML = `
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5">
            <span class="block text-[11px] text-zinc-400">Clientes Personalizados</span>
            <span class="block font-mono text-lg font-black text-white mt-0.5">${totalClients}</span>
          </div>
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5">
            <span class="block text-[11px] text-zinc-400">Pedidos Registrados</span>
            <span class="block font-mono text-lg font-black text-blue-400 mt-0.5">${totalOrders}</span>
          </div>
          <div class="bg-[#121215] border border-[#27272A] rounded-2xl p-3.5">
            <span class="block text-[11px] text-zinc-400">Facturación Personalizada</span>
            <span class="block font-mono text-lg font-black text-emerald-400 mt-0.5">${formatMoney(totalBilled)}</span>
          </div>
        `;

        const q = STORE.ui.clientSearch.toLowerCase().trim();
        const filtered = STORE.customClients.filter((c) =>
          !q || c.name.toLowerCase().includes(q) || c.phone.toLowerCase().includes(q)
        );

        const listEl = document.getElementById('customClientsList');
        listEl.innerHTML = filtered.map((c) => {
          const active = c.id === STORE.ui.selectedClientId;
          const clientOrders = STORE.orders.filter((o) => o.clientName.toLowerCase() === c.name.toLowerCase());
          return `
            <button
              type="button"
              data-select-client="${c.id}"
              class="w-full p-3.5 rounded-2xl border text-left transition-all ${
                active ? 'bg-blue-600/15 border-blue-500 text-white' : 'bg-[#121215] border-[#27272A] text-zinc-300 hover:border-zinc-600'
              }"
            >
              <div class="flex items-center justify-between gap-2">
                <h4 class="text-xs sm:text-sm font-extrabold text-white truncate">${escapeHtml(c.name)}</h4>
                <span class="font-mono text-[11px] text-blue-400 shrink-0">${clientOrders.length} pedido(s)</span>
              </div>
              <p class="font-mono text-[11px] text-zinc-400 mt-0.5">${escapeHtml(c.phone)}</p>
            </button>
          `;
        }).join('');

        const selectedClient = STORE.customClients.find((c) => c.id === STORE.ui.selectedClientId) || filtered[0];
        const detailEl = document.getElementById('customClientDetailPanel');
        if (!selectedClient) {
          detailEl.innerHTML = `<p class="text-xs text-zinc-500">Selecciona un cliente para ver su historial.</p>`;
          return;
        }

        const cOrders = STORE.orders.filter((o) => o.clientName.toLowerCase() === selectedClient.name.toLowerCase());
        detailEl.innerHTML = `
          <h4 class="text-sm font-extrabold text-white">${escapeHtml(selectedClient.name)}</h4>
          <p class="font-mono text-xs text-blue-400 mt-0.5">${escapeHtml(selectedClient.phone)}</p>
          <button type="button" data-wa-client="${selectedClient.id}" class="mt-2 px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-500 text-white text-[11px] font-bold">Escribir por WhatsApp</button>
          <p class="text-xs text-zinc-400 mt-2 p-2.5 rounded-xl bg-[#09090B] border border-[#27272A]">${escapeHtml(selectedClient.notes || 'Cliente registrado para pedidos personalizados.')}</p>
          <h5 class="text-xs font-extrabold uppercase tracking-wider text-zinc-400 mt-4 mb-2">Historial de Pedidos (${cOrders.length})</h5>
          <div class="flex flex-col gap-2">
            ${cOrders.length === 0
              ? `<p class="text-xs text-zinc-500">Aún no tiene pedidos vinculados.</p>`
              : cOrders.map((o) => `
                  <div class="p-2.5 rounded-xl bg-[#09090B] border border-[#27272A] flex items-center justify-between gap-2 text-xs">
                    <div class="min-w-0">
                      <span class="font-mono font-bold text-indigo-400">${escapeHtml(o.folio)}</span>
                      <p class="text-zinc-300 truncate">${escapeHtml(o.summary)}</p>
                    </div>
                    <span class="font-mono font-bold text-emerald-400 shrink-0">${formatMoney(o.totalAmount)}</span>
                  </div>
                `).join('')}
          </div>
        `;
      }

      // ----------------------------------------------------------------------
      // ORQUESTADOR CENTRAL DE RENDERIZADO
      // ----------------------------------------------------------------------
      function renderAll() {
        renderHeaderAndQuickCart();
        renderDashboardAndSideNav();
        renderStockModule();
        renderRawMaterialsModule();
        renderFinanceModule();
        renderPosCartModule();
        renderQuoteModule();
        renderReportsModule();
        renderOrdersModule();
        updateRegistroPreview();
        renderUsersModule();
        renderClientsModule();
        updateViewportAndGridMetrics();
      }

      // ----------------------------------------------------------------------
      // INICIALIZACIÓN DE EVENTOS DOM
      // ----------------------------------------------------------------------
      function initEvents() {
        // Delegación global de clics
        document.addEventListener('click', (e) => {
          // 1. Navegación [data-route]
          const routeBtn = e.target.closest('[data-route]');
          if (routeBtn) {
            navigateTo(routeBtn.dataset.route);
            return;
          }

          // 2. Simulador de dispositivo [data-sim-device]
          const devBtn = e.target.closest('[data-sim-device]');
          if (devBtn) {
            setSimDevice(devBtn.dataset.simDevice);
            return;
          }

          // 3. Modos CSS Grid [data-grid-mode]
          const modeBtn = e.target.closest('[data-grid-mode]');
          if (modeBtn) {
            setGridMode(modeBtn.dataset.gridMode);
            return;
          }

          // 4. Cambiar sesión de usuario (solicita PIN configurado) [data-switch-user]
          const swUser = e.target.closest('[data-switch-user]');
          if (swUser) {
            const targetId = swUser.dataset.switchUser;
            if (targetId === STORE.activeUserId) return;
            const targetUsr = STORE.users.find((u) => u.id === targetId);
            if (targetUsr) {
              STORE.ui.pendingSwitchUserId = targetUsr.id;
              STORE.ui.loginRequired = false;
              populateUserPinSelect(STORE.users, targetUsr.id);
              document.getElementById('userPinAuthSubtitle').textContent =
                `Ingresa el PIN de 4 dígitos configurado para ${targetUsr.name} (${targetUsr.role}).`;
              document.getElementById('btnCancelUserPin').classList.remove('hidden');
              const pinInp = document.getElementById('userPinAuthInput');
              pinInp.value = '';
              document.getElementById('userPinAuthError').classList.add('hidden');
              document.getElementById('userPinAuthModal').classList.remove('hidden');
              setTimeout(() => pinInp.focus(), 50);
            }
            return;
          }

          // 5. Método de pago [data-pay-method]
          const payBtn = e.target.closest('[data-pay-method]');
          if (payBtn) {
            STORE.paymentMethod = payBtn.dataset.payMethod;
            if (STORE.paymentMethod === 'Dividido') {
              const sub = STORE.cart.reduce((acc, it) => acc + it.price * it.qty, 0);
              const assigned = (Number(STORE.splitPayment.Efectivo) || 0) + (Number(STORE.splitPayment.Transferencia) || 0) + (Number(STORE.splitPayment.Terminal) || 0);
              if (assigned === 0 && sub > 0) {
                const half = Math.round((sub / 2) * 100) / 100;
                STORE.splitPayment = {
                  Efectivo: half,
                  Transferencia: Math.round((sub - half) * 100) / 100,
                  Terminal: 0
                };
              }
            }
            renderHeaderAndQuickCart();
            renderPosCartModule();
            return;
          }

          // 5b. Auto-completar restante en pago dividido [data-fill-split]
          const fillSplitBtn = e.target.closest('[data-fill-split]');
          if (fillSplitBtn) {
            const targetKey = fillSplitBtn.dataset.fillSplit;
            const sub = STORE.cart.reduce((acc, it) => acc + it.price * it.qty, 0);
            const othersSum = ['Efectivo', 'Transferencia', 'Terminal']
              .filter((k) => k !== targetKey)
              .reduce((acc, k) => acc + (Number(STORE.splitPayment[k]) || 0), 0);
            STORE.splitPayment[targetKey] = Math.max(0, Math.round((sub - othersSum) * 100) / 100);
            renderHeaderAndQuickCart();
            renderPosCartModule();
            return;
          }

          // 6. Ajustes de cantidad en Carrito [data-cart-delta]
          const cartDeltaBtn = e.target.closest('[data-cart-delta]');
          if (cartDeltaBtn) {
            const prodId = cartDeltaBtn.dataset.cartId;
            const delta = parseInt(cartDeltaBtn.dataset.cartDelta, 10);
            const itemIdx = STORE.cart.findIndex((c) => c.productId === prodId);
            if (itemIdx !== -1) {
              const prod = STORE.products.find((p) => p.id === prodId);
              const nextQty = STORE.cart[itemIdx].qty + delta;
              if (nextQty <= 0) {
                STORE.cart.splice(itemIdx, 1);
              } else if (prod && nextQty > prod.stock) {
                showToast(`Stock máximo alcanzado (${prod.stock} uds.)`, 'warn');
              } else {
                STORE.cart[itemIdx].qty = nextQty;
              }
              renderAll();
            }
            return;
          }

          // 7. Filtros de Stock [data-stock-cat]
          const stockCatBtn = e.target.closest('[data-stock-cat]');
          if (stockCatBtn) {
            STORE.ui.stockCategory = stockCatBtn.dataset.stockCat;
            renderStockModule();
            return;
          }

          // 8. Ajuste rápido de stock (+1 / -1)
          const stockAdjBtn = e.target.closest('[data-stock-adj]');
          if (stockAdjBtn) {
            const prod = STORE.products.find((p) => p.id === stockAdjBtn.dataset.prodId);
            const delta = parseInt(stockAdjBtn.dataset.stockAdj, 10);
            if (prod) {
              const nextStock = Math.max(0, prod.stock + delta);
              const appliedDelta = nextStock - prod.stock;
              if (appliedDelta !== 0) {
                prod.stock = nextStock;
                STORE.stockMovements.unshift({
                  id: 'sm-' + Date.now(),
                  date: todayIso,
                  product: prod.name,
                  qr: prod.qr,
                  type: appliedDelta > 0 ? 'Ajuste Manual (+)' : 'Ajuste Manual (-)',
                  delta: appliedDelta,
                  user: getActiveUser().name
                });
                renderAll();
              }
            }
            return;
          }

          // 9. Descargar pegatina QR desde Stock [data-download-qr-id]
          const downloadQrBtn = e.target.closest('[data-download-qr-id]');
          if (downloadQrBtn) {
            const prod = STORE.products.find((p) => p.id === downloadQrBtn.dataset.downloadQrId);
            if (prod) downloadQrStickerPng(prod);
            return;
          }

          // 10. Agregar producto al carrito desde Stock
          const addCartBtn = e.target.closest('[data-add-cart-id]');
          if (addCartBtn) {
            const prod = STORE.products.find((p) => p.id === addCartBtn.dataset.addCartId);
            if (prod) addProductToCartByQr(prod.qr);
            return;
          }

          // 10b. Eliminar artículo del Stock (con confirmación)
          const delStockBtn = e.target.closest('[data-delete-stock-id]');
          if (delStockBtn) {
            const prod = STORE.products.find((p) => p.id === delStockBtn.dataset.deleteStockId);
            if (prod) {
              STORE.ui.pendingDelete = { type: 'stock', id: prod.id, label: prod.name };
              document.getElementById('confirmDeleteTitle').textContent = 'Confirmar eliminación de Stock';
              document.getElementById('confirmDeleteText').textContent =
                `¿Estás seguro de que deseas eliminar el producto "${prod.name}" (${prod.qr}) del Stock?`;
              document.getElementById('btnExecuteConfirmDelete').textContent = 'Sí, eliminar producto';
              document.getElementById('confirmDeleteModal').classList.remove('hidden');
            }
            return;
          }

          // 11. Escaneo rápido en Carrito POS
          const quickQrBtn = e.target.closest('[data-quick-qr]');
          if (quickQrBtn) {
            addProductToCartByQr(quickQrBtn.dataset.quickQr);
            return;
          }

          // 12. Color en Materia Prima
          const rmColorBtn = e.target.closest('[data-rm-color]');
          if (rmColorBtn) {
            STORE.ui.rmSelectedColorName = rmColorBtn.dataset.rmColor;
            renderRawMaterialsModule();
            return;
          }

          // 13. Variación cantidad Materia Prima
          const rmDeltaBtn = e.target.closest('[data-rm-delta]');
          if (rmDeltaBtn) {
            const rm = STORE.rawMaterials.find((r) => r.id === rmDeltaBtn.dataset.rmId);
            if (rm) {
              rm.qty = Math.max(0, rm.qty + parseInt(rmDeltaBtn.dataset.rmDelta, 10));
              rm.updatedBy = getActiveUser().name;
              renderAll();
            }
            return;
          }

          // 13b. Eliminar artículo de Materia Prima (con confirmación)
          const delRmBtn = e.target.closest('[data-delete-rm]');
          if (delRmBtn) {
            const rm = STORE.rawMaterials.find((r) => r.id === delRmBtn.dataset.deleteRm);
            if (rm) {
              STORE.ui.pendingDelete = { type: 'materia', id: rm.id, label: rm.name };
              document.getElementById('confirmDeleteTitle').textContent = 'Confirmar eliminación de Materia Prima';
              document.getElementById('confirmDeleteText').textContent =
                `¿Estás seguro de que deseas eliminar el insumo "${rm.name}" de Materia Prima?`;
              document.getElementById('btnExecuteConfirmDelete').textContent = 'Sí, eliminar insumo';
              document.getElementById('confirmDeleteModal').classList.remove('hidden');
            }
            return;
          }

          // 14. Color en Registro de Producto
          const regColorBtn = e.target.closest('[data-reg-color]');
          if (regColorBtn) {
            STORE.ui.regSelectedColorName = regColorBtn.dataset.regColor;
            updateRegistroPreview(false);
            return;
          }

          // 14b. Quitar aplicación DTF en Registro
          const remRegDtf = e.target.closest('[data-remove-reg-dtf]');
          if (remRegDtf) {
            STORE.regBuilder.dtfApps = STORE.regBuilder.dtfApps.filter((d) => d.id !== remRegDtf.dataset.removeRegDtf);
            updateRegistroPreview(true);
            return;
          }

          // 15. Cotización: seleccionar artículo base
          const qArtBtn = e.target.closest('[data-quote-art]');
          if (qArtBtn) {
            STORE.quoteBuilder.selectedArticleId = qArtBtn.dataset.quoteArt;
            const art = QUOTE_ARTICLES.find((a) => a.id === STORE.quoteBuilder.selectedArticleId) || QUOTE_ARTICLES[0];
            if (art.quoteMode === 'llavero') {
              const sumQty = STORE.quoteBuilder.breakdownRows.reduce((acc, r) => acc + (Number(r.qty) || 0), 0) || 1;
              STORE.quoteBuilder.breakdownRows = [{ id: 'br-' + Date.now(), qty: sumQty, color: 'N/A', size: '', measure: '' }];
            } else if (art.quoteMode === 'totebag') {
              STORE.quoteBuilder.breakdownRows = STORE.quoteBuilder.breakdownRows.map((r) => ({
                ...r,
                color: TOTEBAG_QUOTE_COLORS.includes(r.color) ? r.color : 'Negro',
                size: '',
                measure: ''
              }));
            } else if (art.quoteMode === 'cuadro') {
              STORE.quoteBuilder.breakdownRows = STORE.quoteBuilder.breakdownRows.map((r) => ({
                ...r,
                color: 'N/A',
                size: '',
                measure: CUADRO_QUOTE_MEASURES.includes(r.measure) ? r.measure : '30 × 40 cm'
              }));
            } else {
              STORE.quoteBuilder.breakdownRows = STORE.quoteBuilder.breakdownRows.map((r) => ({
                ...r,
                color: STORE.colorPalette.some((c) => c.name === r.color) ? r.color : 'Negro',
                size: APPAREL_SIZES_S_TO_XXXL.includes(r.size) ? r.size : 'L',
                measure: ''
              }));
            }
            renderQuoteModule();
            return;
          }

          // 16. Cotización: quitar fila desglose o DTF
          const remBr = e.target.closest('[data-remove-br]');
          if (remBr && STORE.quoteBuilder.breakdownRows.length > 1) {
            STORE.quoteBuilder.breakdownRows = STORE.quoteBuilder.breakdownRows.filter((r) => r.id !== remBr.dataset.removeBr);
            renderQuoteModule();
            return;
          }
          const remDtf = e.target.closest('[data-remove-dtf]');
          if (remDtf) {
            STORE.quoteBuilder.dtfApps = STORE.quoteBuilder.dtfApps.filter((d) => d.id !== remDtf.dataset.removeDtf);
            renderQuoteModule();
            return;
          }

          // 17. Cotización: quitar grupo agregado
          const remGrp = e.target.closest('[data-remove-qgroup]');
          if (remGrp) {
            STORE.quoteGroups = STORE.quoteGroups.filter((g) => g.id !== remGrp.dataset.removeQgroup);
            renderAll();
            return;
          }

          // 18. Reportes tabs
          const repTab = e.target.closest('[data-report-tab]');
          if (repTab) {
            STORE.ui.reportTab = repTab.dataset.reportTab;
            renderReportsModule();
            return;
          }

          // 19. Pedidos filtros y guardar anticipo manual ($)
          const ordProdF = e.target.closest('[data-ord-prod-filter]');
          if (ordProdF) {
            STORE.ui.orderProdFilter = ordProdF.dataset.ordProdFilter;
            renderOrdersModule();
            return;
          }
          const ordPayF = e.target.closest('[data-ord-pay-filter]');
          if (ordPayF) {
            STORE.ui.orderPayFilter = ordPayF.dataset.ordPayFilter;
            renderOrdersModule();
            return;
          }
          const saveAdvBtn = e.target.closest('[data-save-adv]');
          if (saveAdvBtn) {
            const ord = STORE.orders.find((o) => o.id === saveAdvBtn.dataset.saveAdv);
            const inp = ord ? document.getElementById(`adv-input-${ord.id}`) : null;
            if (ord && inp) {
              const val = Math.max(0, Math.min(ord.totalAmount, Number(inp.value) || 0));
              ord.advancePaid = val;
              showToast(`Anticipo de ${ord.folio} actualizado a ${formatMoney(val)}`);
              renderAll();
            }
            return;
          }

          // 20. Eliminar usuario (modal confirmación)
          const askDelUsr = e.target.closest('[data-ask-delete-user]');
          if (askDelUsr) {
            const targetUsr = STORE.users.find((u) => u.id === askDelUsr.dataset.askDeleteUser);
            if (targetUsr) {
              STORE.ui.pendingDelete = { type: 'usuario', id: targetUsr.id, label: targetUsr.name };
              document.getElementById('confirmDeleteTitle').textContent = 'Confirmar eliminación de usuario';
              document.getElementById('confirmDeleteText').textContent =
                `¿Estás seguro de que deseas eliminar permanentemente al usuario "${targetUsr.name}" (${targetUsr.role})?`;
              document.getElementById('btnExecuteConfirmDelete').textContent = 'Sí, eliminar usuario';
              document.getElementById('confirmDeleteModal').classList.remove('hidden');
            }
            return;
          }

          // 21. Seleccionar cliente en Módulo Clientes
          const selClient = e.target.closest('[data-select-client]');
          if (selClient) {
            STORE.ui.selectedClientId = selClient.dataset.selectClient;
            renderClientsModule();
            return;
          }
        });

        // Eventos específicos de botones y formularios
        document.getElementById('btnToggleGuides').addEventListener('click', () => {
          STORE.ui.guidesActive = !STORE.ui.guidesActive;
          document.getElementById('appViewportFrame').classList.toggle('grid-guides-active', STORE.ui.guidesActive);
          document.getElementById('gridGuidesIndicatorBar').classList.toggle('hidden', !STORE.ui.guidesActive);
          document.getElementById('btnToggleGuides').classList.toggle('border-blue-500', STORE.ui.guidesActive);
          document.getElementById('btnToggleGuides').classList.toggle('text-blue-400', STORE.ui.guidesActive);
          updateViewportAndGridMetrics();
        });

        document.getElementById('btnOpenCssModal').addEventListener('click', () => {
          document.getElementById('cssModalPreCode').textContent = CSS_SNIPPETS_BY_MODE[STORE.ui.gridMode] || CSS_SNIPPETS_BY_MODE.breakpoints;
          document.getElementById('cssCodeModal').classList.remove('hidden');
        });
        document.getElementById('btnCloseCssModal').addEventListener('click', () => {
          document.getElementById('cssCodeModal').classList.add('hidden');
        });
        document.getElementById('btnCopyCssModal').addEventListener('click', () => {
          const code = document.getElementById('cssModalPreCode').textContent;
          const ta = document.createElement('textarea');
          ta.value = code;
          document.body.appendChild(ta);
          ta.select();
          try {
            document.execCommand('copy');
            document.getElementById('copyCssBtnLabel').textContent = '¡Copiado!';
            setTimeout(() => {
              document.getElementById('copyCssBtnLabel').textContent = 'Copiar CSS';
            }, 1800);
          } catch (err) {
            showToast('No se pudo copiar el CSS', 'error');
          }
          document.body.removeChild(ta);
        });

        // Menú lateral hamburguesa
        document.getElementById('btnOpenSideNav').addEventListener('click', () => {
          document.getElementById('sideNavBackdrop').classList.remove('hidden');
        });
        document.getElementById('btnCloseSideNav').addEventListener('click', () => {
          document.getElementById('sideNavBackdrop').classList.add('hidden');
        });
        document.getElementById('sideNavBackdrop').addEventListener('click', (e) => {
          if (e.target.id === 'sideNavBackdrop') document.getElementById('sideNavBackdrop').classList.add('hidden');
        });

        // Marca header -> Tablero Principal
        document.getElementById('btnHeaderBrand').addEventListener('click', () => navigateTo('dashboard'));
        document.getElementById('btnBackToDashboard').addEventListener('click', () => navigateTo('dashboard'));

        // Popover Usuario Activo
        document.getElementById('btnHeaderUserSwitcher').addEventListener('click', () => {
          document.getElementById('userSwitcherPopover').classList.toggle('hidden');
          document.getElementById('userSwitcherBackdrop').classList.toggle('hidden');
        });
        document.getElementById('btnCloseUserPopover').addEventListener('click', () => {
          document.getElementById('userSwitcherPopover').classList.add('hidden');
          document.getElementById('userSwitcherBackdrop').classList.add('hidden');
        });
        document.getElementById('userSwitcherBackdrop').addEventListener('click', () => {
          document.getElementById('userSwitcherPopover').classList.add('hidden');
          document.getElementById('userSwitcherBackdrop').classList.add('hidden');
        });

        // Cierre explícito de sesión en Laravel; la sesión se conserva solo hasta esta acción.
        document.getElementById('btnLogout').addEventListener('click', async (e) => {
          const button = e.currentTarget;
          const originalMarkup = button.innerHTML;

          if (button.disabled) return;

          button.disabled = true;
          button.textContent = 'Guardando cambios…';

          try {
            const saved = await NFS_DB.save(true);

            if (!saved) {
              throw new Error('No se pudieron guardar los cambios. Espera a que termine la sincronización e inténtalo de nuevo.');
            }

            button.textContent = 'Cerrando sesión…';
            await NFS_DB.logout();

            // La recarga obtiene un token CSRF nuevo y muestra nuevamente el acceso por PIN.
            window.location.reload();
          } catch (error) {
            console.error('NFS logout', error);
            button.disabled = false;
            button.innerHTML = originalMarkup;
            showToast(error.message || 'No fue posible cerrar la sesión.', 'error');
          }
        });

        // Carrito rápido Drawer / Sheet
        function openQuickCart() {
          document.getElementById('quickCartBackdrop').classList.remove('hidden');
          document.getElementById('quickCartPanel').classList.add('is-open');
          updateViewportAndGridMetrics();
        }
        function closeQuickCart() {
          document.getElementById('quickCartBackdrop').classList.add('hidden');
          document.getElementById('quickCartPanel').classList.remove('is-open');
        }
        document.getElementById('btnHeaderQuickCart').addEventListener('click', openQuickCart);
        document.getElementById('btnCloseQuickCart').addEventListener('click', closeQuickCart);
        document.getElementById('quickCartBackdrop').addEventListener('click', closeQuickCart);
        document.getElementById('quickCartSheetHandle').addEventListener('click', closeQuickCart);
        document.getElementById('btnQuickGoToPos').addEventListener('click', () => {
          closeQuickCart();
          navigateTo('carrito');
        });
        document.getElementById('btnQuickCheckout').addEventListener('click', completeCheckoutSale);

        document.getElementById('drawerQrForm').addEventListener('submit', (e) => {
          e.preventDefault();
          const inp = document.getElementById('drawerQrInput');
          addProductToCartByQr(inp.value);
          inp.value = '';
        });

        // Stock búsqueda
        document.getElementById('stockSearchInput').addEventListener('input', (e) => {
          STORE.ui.stockSearch = e.target.value;
          renderStockModule();
        });

        // Materia Prima eventos
        document.getElementById('rmCategory').addEventListener('change', syncRawMaterialFormVisibility);
        document.getElementById('btnToggleNewColorForm').addEventListener('click', () => {
          document.getElementById('rmNewColorCreator').classList.toggle('hidden');
        });
        document.getElementById('rmNewColorPicker').addEventListener('input', (e) => {
          document.getElementById('rmNewColorHex').value = e.target.value.toUpperCase();
        });
        document.getElementById('btnSaveNewPaletteColor').addEventListener('click', () => {
          const name = document.getElementById('rmNewColorName').value.trim();
          const hex = document.getElementById('rmNewColorHex').value.trim();
          if (!name || !/^#[0-9A-Fa-f]{6}$/.test(hex)) {
            showToast('Ingresa un nombre y código #HEX válido (ej. #881337)', 'warn');
            return;
          }
          STORE.colorPalette.push({ name, hex });
          STORE.ui.rmSelectedColorName = name;
          STORE.ui.regSelectedColorName = name;
          document.getElementById('rmNewColorName').value = '';
          document.getElementById('rmNewColorCreator').classList.add('hidden');
          showToast(`Color "${name}" agregado a la gama global`);
          renderAll();
        });

        document.getElementById('formAddRawMaterial').addEventListener('submit', (e) => {
          e.preventDefault();
          const name = document.getElementById('rmName').value.trim();
          const category = document.getElementById('rmCategory').value;
          const subType = category === 'Playeras' ? document.getElementById('rmShirtType').value : '';
          const isApparel = category === 'Playeras' || category === 'Hoodies';
          const hasColor = isApparel || category === 'Tote bag';
          const sizeOrMeasure = isApparel
            ? document.getElementById('rmApparelSize').value
            : category === 'Lámina / aluminio'
            ? (document.getElementById('rmCustomMeasure').value.trim() || '30×40 cm')
            : category === 'Tote bag'
            ? '35×40 cm'
            : '5×5 cm';

          STORE.rawMaterials.unshift({
            id: 'rm-' + Date.now(),
            name,
            category,
            subType,
            color: hasColor ? STORE.ui.rmSelectedColorName : 'N/A',
            sizeOrMeasure,
            qty: Math.max(1, parseInt(document.getElementById('rmQty').value, 10) || 1),
            cost: Math.max(1, Number(document.getElementById('rmCost').value) || 1),
            updatedBy: getActiveUser().name
          });
          document.getElementById('rmName').value = '';
          showToast(`Materia prima "${name}" registrada`);
          renderAll();
        });

        // Finanzas fechas y PDF
        document.getElementById('finDateFrom').addEventListener('change', (e) => {
          STORE.ui.finDateFrom = e.target.value;
          renderFinanceModule();
        });
        document.getElementById('finDateTo').addEventListener('change', (e) => {
          STORE.ui.finDateTo = e.target.value;
          renderFinanceModule();
        });
        document.getElementById('btnFinResetDates').addEventListener('click', () => {
          STORE.ui.finDateFrom = '';
          STORE.ui.finDateTo = '';
          document.getElementById('finDateFrom').value = '';
          document.getElementById('finDateTo').value = '';
          renderFinanceModule();
        });
        document.getElementById('btnDownloadFinancePdf').addEventListener('click', () => {
          const fin = computeFinanceMetrics();
          const lines = [
            `Ventas Brutas: ${formatMoney(fin.grossSales)} MXN`,
            `Comisiones Terminal (${STORE.terminalFeePct}%): -${formatMoney(fin.terminalFees)} MXN`,
            `Ingresos Netos: ${formatMoney(fin.netSales)} MXN`,
            `Costos de Elaboración: ${formatMoney(fin.totalCost)} MXN`,
            '------------------------------------------------------------',
            ...fin.categoriesOrder.map((c) => {
              const st = fin.statsByType[c];
              return `${c.padEnd(24, ' ')} | ${String(st.units).padStart(3, ' ')} uds | Ing: ${formatMoney(st.revenue)}`;
            })
          ];
          generateBrandPdf(
            `Reporte_Finanzas_N4S_${todayIso}.pdf`,
            'REPORTE FINANCIERO EJECUTIVO',
            `Generado por ${getActiveUser().name}`,
            lines,
            `UTILIDAD NETA TOTAL: ${formatMoney(fin.netProfit)} MXN`
          );
        });

        // Carrito POS eventos
        document.getElementById('posQrScannerForm').addEventListener('submit', (e) => {
          e.preventDefault();
          const inp = document.getElementById('posQrInput');
          addProductToCartByQr(inp.value);
          inp.value = '';
        });
        document.getElementById('btnClearPosCart').addEventListener('click', () => {
          STORE.cart = [];
          STORE.splitPayment = { Efectivo: 0, Transferencia: 0, Terminal: 0 };
          renderAll();
        });
        document.getElementById('btnCompletePosSale').addEventListener('click', completeCheckoutSale);

        [
          ['splitPayEfectivo', 'Efectivo'],
          ['splitPayTransferencia', 'Transferencia'],
          ['splitPayTerminal', 'Terminal']
        ].forEach(([elId, key]) => {
          document.getElementById(elId).addEventListener('input', (e) => {
            STORE.splitPayment[key] = Math.max(0, Number(e.target.value) || 0);
            renderHeaderAndQuickCart();
            renderPosCartModule();
          });
        });

        // Cotización eventos
        document.getElementById('quoteExistingClientSelect').addEventListener('change', (e) => {
          const cl = STORE.customClients.find((c) => c.id === e.target.value);
          if (cl) {
            document.getElementById('quoteClientInput').value = cl.name;
            document.getElementById('quoteClientPhoneInput').value = cl.phone;
          }
        });

        document.getElementById('btnAddGroupBreakdownRow').addEventListener('click', () => {
          const art = QUOTE_ARTICLES.find((a) => a.id === STORE.quoteBuilder.selectedArticleId) || QUOTE_ARTICLES[0];
          if (art.quoteMode === 'llavero') return;
          STORE.quoteBuilder.breakdownRows.push({
            id: 'br-' + Date.now() + Math.random(),
            qty: 2,
            color: art.quoteMode === 'totebag' ? 'Hueso' : 'Negro',
            size: 'M',
            measure: '30 × 40 cm'
          });
          renderQuoteModule();
        });

        document.getElementById('quoteDtfMeterCostInput').addEventListener('input', (e) => {
          STORE.quoteBuilder.dtfMeterCost = Math.max(0, Number(e.target.value) || 0);
          renderQuoteModule();
        });

        document.getElementById('btnAddDtfApp').addEventListener('click', () => {
          STORE.quoteBuilder.dtfApps.push({
            id: 'dtf-' + Date.now() + Math.random(),
            label: 'Manga / Detalle',
            widthCm: 8,
            heightCm: 8
          });
          renderQuoteModule();
        });

        document.getElementById('quoteGroupBreakdownRows').addEventListener('input', (e) => {
          const id = e.target.dataset.brId;
          const field = e.target.dataset.brField;
          const row = STORE.quoteBuilder.breakdownRows.find((r) => r.id === id);
          if (row && field) {
            row[field] = field === 'qty' ? Math.max(1, parseInt(e.target.value, 10) || 1) : e.target.value;
            const totalPzs = STORE.quoteBuilder.breakdownRows.reduce((acc, r) => acc + (Number(r.qty) || 0), 0);
            document.getElementById('builderGroupTotalPiecesBadge').textContent = `Grupo: ${totalPzs} pieza${totalPzs === 1 ? '' : 's'}`;
          }
        });

        document.getElementById('quoteDtfAppsList').addEventListener('input', (e) => {
          const id = e.target.dataset.dtfId;
          const field = e.target.dataset.dtfField;
          const dtf = STORE.quoteBuilder.dtfApps.find((d) => d.id === id);
          if (dtf && field) {
            dtf[field] = field === 'label' ? e.target.value : Math.max(1, Number(e.target.value) || 1);
            renderQuoteModule();
          }
        });

        document.getElementById('btnAddGroupToQuote').addEventListener('click', () => {
          const art = QUOTE_ARTICLES.find((a) => a.id === STORE.quoteBuilder.selectedArticleId) || QUOTE_ARTICLES[0];
          const insumoCost = getQuoteArticleInsumoCost(art);
          STORE.quoteGroups.push({
            id: 'qg-' + Date.now(),
            articleId: art.id,
            articleName: art.name,
            basePrice: art.basePrice,
            baseCost: insumoCost,
            quoteMode: art.quoteMode,
            allowsDtf: art.allowsDtf,
            dtfMeterCost: Math.max(0, Number(STORE.quoteBuilder.dtfMeterCost) || 0),
            applyDiscount: false,
            breakdownRows: STORE.quoteBuilder.breakdownRows.map((r) => ({ ...r })),
            dtfApps: art.allowsDtf ? STORE.quoteBuilder.dtfApps.map((d) => ({ ...d })) : []
          });
          showToast(`Grupo "${art.name}" agregado a la cotización`);
          renderAll();
        });

        document.getElementById('btnClearAllQuoteGroups').addEventListener('click', () => {
          STORE.quoteGroups = [];
          renderAll();
        });

        document.getElementById('quoteAddedGroupsList').addEventListener('change', (e) => {
          const id = e.target.dataset.toggleQgroupDisc;
          if (id) {
            const grp = STORE.quoteGroups.find((g) => g.id === id);
            if (grp) {
              grp.applyDiscount = e.target.checked;
              renderQuoteModule();
            }
          }
        });

        document.getElementById('quoteDiscountPctInput').addEventListener('input', renderQuoteModule);
        document.getElementById('quoteOtherCostInput').addEventListener('input', renderQuoteModule);

        document.getElementById('btnDownloadQuotePdf').addEventListener('click', () => {
          const totals = computeQuoteTotals();
          if (totals.computedGroups.length === 0) {
            showToast('Agrega al menos un grupo antes de generar el PDF', 'warn');
            return;
          }
          const client = document.getElementById('quoteClientInput').value.trim() || 'Cliente General';
          const phone = document.getElementById('quoteClientPhoneInput').value.trim() || 'N/A';
          const folio = `COT-${STORE.quoteFolioCounter}`;

          const lines = [
            `Folio: ${folio}   |   Cliente: ${client} (${phone})`,
            `Asesor: ${getActiveUser().name}`,
            '------------------------------------------------------------',
            ...totals.computedGroups.map((g, i) => {
              const det = g.breakdownRows.map((r) => {
                if (g.quoteMode === 'llavero') return `${r.qty} pzs`;
                if (g.quoteMode === 'cuadro') return `${r.qty} ${r.measure}`;
                if (g.quoteMode === 'totebag') return `${r.qty} ${r.color}`;
                return `${r.qty} ${r.color} ${r.size}`;
              }).join(', ');
              return `${i + 1}. ${g.pieces}x ${g.articleName} [${det}] -> ${formatMoney(g.netGroup)}`;
            }),
            '------------------------------------------------------------',
            `Total de piezas cotizadas: ${totals.totalPieces} pzs`
          ];

          generateBrandPdf(
            `${folio}_${client.replace(/\s+/g, '_')}.pdf`,
            `COTIZACIÓN OFICIAL ${folio}`,
            `Cliente: ${client} • Tel: ${phone}`,
            lines,
            `TOTAL COTIZACIÓN: ${formatMoney(totals.finalTotal)} MXN`
          );
        });

        document.getElementById('btnSendQuoteToOrders').addEventListener('click', () => {
          const totals = computeQuoteTotals();
          if (totals.computedGroups.length === 0) {
            showToast('Agrega al menos un grupo para enviar a Pedidos', 'warn');
            return;
          }
          const clientName = document.getElementById('quoteClientInput').value.trim() || 'Cliente Personalizado';
          const clientPhone = document.getElementById('quoteClientPhoneInput').value.trim() || 'Sin teléfono';
          const advancePaid = Math.max(0, Math.min(totals.finalTotal, Number(document.getElementById('quoteInitialAdvanceInput').value) || 0));
          const summary = totals.computedGroups.map((g) => `${g.pieces}× ${g.articleName}`).join(' + ');

          const orderFolio = `PED-${501 + STORE.orders.length}`;
          STORE.orders.unshift({
            id: 'ord-' + Date.now(),
            folio: orderFolio,
            date: todayIso,
            clientName,
            clientPhone,
            summary,
            totalAmount: totals.finalTotal,
            advancePaid,
            prodStatus: 'Pendiente',
            createdBy: getActiveUser().name
          });

          if (!STORE.customClients.some((c) => c.name.toLowerCase() === clientName.toLowerCase())) {
            STORE.customClients.unshift({
              id: 'c-' + Date.now(),
              name: clientName,
              phone: clientPhone,
              notes: `Cliente generado desde cotización COT-${STORE.quoteFolioCounter}.`
            });
          }

          STORE.quoteFolioCounter += 1;
          STORE.quoteGroups = [];
          showToast(`Pedido ${orderFolio} creado y enviado a Pedidos`);
          navigateTo('pedidos');
        });

        // Reportes eventos
        document.getElementById('terminalFeePctInput').addEventListener('input', (e) => {
          STORE.terminalFeePct = Math.max(0, Math.min(25, Number(e.target.value) || 0));
          renderAll();
        });
        document.getElementById('reportSearchInput').addEventListener('input', (e) => {
          STORE.ui.reportSearch = e.target.value;
          renderReportsModule();
        });
        document.getElementById('btnDownloadReportCsv').addEventListener('click', () => {
          const rows = [['Folio', 'Fecha', 'Usuario', 'Metodo', 'Bruto', 'Neto']];
          STORE.sales.forEach((s) => rows.push([s.folio, s.date, s.user, s.method, s.grossAmount, s.netAmount]));
          const csv = rows.map((r) => r.join(',')).join('\n');
          const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
          const a = document.createElement('a');
          a.href = URL.createObjectURL(blob);
          a.download = `Reporte_Ventas_N4S_${todayIso}.csv`;
          a.click();
          showToast('Archivo CSV exportado');
        });
        document.getElementById('btnDownloadReportPdf').addEventListener('click', () => {
          const lines = STORE.sales.map((s) => `${s.folio} | ${s.date} | ${s.user} | ${s.method} | ${formatMoney(s.netAmount)}`);
          generateBrandPdf(
            `Reporte_Operativo_N4S_${todayIso}.pdf`,
            'REPORTE OPERATIVO DE VENTAS',
            `Comisión Terminal vigente: ${STORE.terminalFeePct}%`,
            lines,
            `Total registros: ${STORE.sales.length}`
          );
        });

        // Pedidos cambio estado producción
        document.getElementById('ordersCardsGrid').addEventListener('change', (e) => {
          const id = e.target.dataset.ordStatus;
          if (id) {
            const ord = STORE.orders.find((o) => o.id === id);
            if (ord) {
              ord.prodStatus = e.target.value;
              showToast(`${ord.folio} → ${ord.prodStatus}`);
              renderAll();
            }
          }
        });

        // Registro de producto terminado eventos
        document.getElementById('regProdQr').value = generateNextSkuQr();
        document.getElementById('regProdCategory').addEventListener('change', () => {
          document.getElementById('regProdQr').value = generateNextSkuQr();
          updateRegistroPreview(true);
        });
        document.getElementById('regRawMaterialSelect').addEventListener('change', (e) => {
          STORE.regBuilder.selectedRawMaterialId = e.target.value;
          updateRegistroPreview(true);
        });
        document.getElementById('regDtfMeterCostInput').addEventListener('input', (e) => {
          STORE.regBuilder.dtfMeterCost = Math.max(0, Number(e.target.value) || 0);
          updateRegistroPreview(true);
        });
        document.getElementById('btnAddRegDtfApp').addEventListener('click', () => {
          STORE.regBuilder.dtfApps.push({
            id: 'rdtf-' + Date.now() + Math.random(),
            label: 'Espalda / Detalle',
            widthCm: 20,
            heightCm: 25
          });
          updateRegistroPreview(true);
        });
        document.getElementById('regDtfAppsList').addEventListener('input', (e) => {
          const id = e.target.dataset.regDtfId;
          const field = e.target.dataset.regDtfField;
          const dtf = STORE.regBuilder.dtfApps.find((d) => d.id === id);
          if (dtf && field) {
            dtf[field] = field === 'label' ? e.target.value : Math.max(1, Number(e.target.value) || 1);
            updateRegistroPreview(true);
          }
        });
        document.getElementById('btnRegenerateQr').addEventListener('click', () => {
          document.getElementById('regProdQr').value = generateNextSkuQr();
          updateRegistroPreview(false);
        });
        ['regProdName', 'regProdQr', 'regProdSize', 'regProdCost', 'regProdMargin', 'regProdFinalPrice'].forEach((id) => {
          document.getElementById(id).addEventListener('input', () => updateRegistroPreview(false));
        });
        document.getElementById('regUseSuggestedCheck').addEventListener('change', () => updateRegistroPreview(false));

        document.getElementById('btnDownloadRegSticker').addEventListener('click', () => {
          const category = document.getElementById('regProdCategory').value;
          const isApparel = category.startsWith('Playeras') || category === 'Hoodies';
          const isToteBag = category === 'Tote bag';
          const hasColor = isApparel || isToteBag;
          const selectedRm = STORE.rawMaterials.find((r) => r.id === STORE.regBuilder.selectedRawMaterialId);
          downloadQrStickerPng({
            name: (document.getElementById('regProdName').value || '').trim() || 'Producto Streetwear',
            category,
            color: hasColor ? STORE.ui.regSelectedColorName : 'N/A',
            size: isApparel
              ? document.getElementById('regProdSize').value
              : isToteBag
              ? '35×40 cm'
              : selectedRm
              ? selectedRm.sizeOrMeasure
              : category === 'Cuadros'
              ? '40×60 cm'
              : '5×5 cm',
            qr: (document.getElementById('regProdQr').value || '').trim().toUpperCase() || 'QR-NFS-00',
            price: Math.max(1, Number(document.getElementById('regProdFinalPrice').value) || 100)
          });
        });

        document.getElementById('formRegisterStockProduct').addEventListener('submit', (e) => {
          e.preventDefault();
          const activeUser = getActiveUser();
          const name = document.getElementById('regProdName').value.trim();
          const category = document.getElementById('regProdCategory').value;
          const qr = document.getElementById('regProdQr').value.trim().toUpperCase();
          const isApparel = category.startsWith('Playeras') || category === 'Hoodies';
          const isToteBag = category === 'Tote bag';
          const hasColor = isApparel || isToteBag;
          const color = hasColor ? STORE.ui.regSelectedColorName : 'N/A';

          const selectedRm = STORE.rawMaterials.find((r) => r.id === STORE.regBuilder.selectedRawMaterialId) || null;
          const stock = Math.max(1, parseInt(document.getElementById('regProdStock').value, 10) || 1);

          if (selectedRm) {
            if (selectedRm.qty < stock) {
              showToast(`Materia prima insuficiente (${selectedRm.name}: ${selectedRm.qty} u. disponibles)`, 'error');
              return;
            }
            selectedRm.qty = Math.max(0, selectedRm.qty - stock);
            selectedRm.updatedBy = activeUser.name;
          }

          const size = isApparel
            ? document.getElementById('regProdSize').value
            : isToteBag
            ? '35×40 cm'
            : selectedRm
            ? selectedRm.sizeOrMeasure
            : category === 'Cuadros'
            ? '40×60 cm'
            : '5×5 cm';

          const cost = Math.max(0.01, Number(document.getElementById('regProdCost').value) || 1);
          const price = Math.max(1, Number(document.getElementById('regProdFinalPrice').value) || 1);

          STORE.products.unshift({
            id: 'p-' + Date.now(),
            qr,
            name,
            category,
            color,
            size,
            stock,
            cost,
            price
          });

          STORE.stockMovements.unshift({
            id: 'sm-' + Date.now(),
            date: todayIso,
            product: name,
            qr,
            type: selectedRm ? `Elaborado (${selectedRm.name} -${stock})` : 'Registro Nuevo Stock',
            delta: stock,
            user: activeUser.name
          });

          document.getElementById('regProdName').value = '';
          document.getElementById('regProdQr').value = generateNextSkuQr();
          showToast(
            selectedRm
              ? `"${name}" guardado en Stock (${stock} uds.) y descontado de Materia Prima`
              : `Producto "${name}" guardado en Stock (${stock} uds.)`
          );
          renderAll();
          updateRegistroPreview(true);
        });

        // Usuarios eventos
        document.getElementById('formRegisterUser').addEventListener('submit', (e) => {
          e.preventDefault();
          const name = document.getElementById('usrFullName').value.trim();
          const alias = document.getElementById('usrAlias').value.trim().toLowerCase();
          const pin = document.getElementById('usrPin').value.trim();
          if (!/^[0-9]{4}$/.test(pin)) {
            showToast('El PIN debe tener exactamente 4 dígitos numéricos', 'warn');
            return;
          }
          const role = document.getElementById('usrRole').value;
          const active = document.getElementById('usrActiveCheck').checked;

          STORE.users.push({
            id: 'u-' + Date.now(),
            name,
            alias,
            pin,
            role,
            active
          });
          document.getElementById('usrFullName').value = '';
          document.getElementById('usrAlias').value = '';
          document.getElementById('usrPin').value = '';
          showToast(`Usuario "${name}" registrado con PIN configurado`);
          renderAll();
        });

        // Modal unificado de confirmación de eliminación (Stock, Materia Prima y Usuarios)
        document.getElementById('btnCancelConfirmDelete').addEventListener('click', () => {
          STORE.ui.pendingDelete = null;
          document.getElementById('confirmDeleteModal').classList.add('hidden');
        });
        document.getElementById('btnExecuteConfirmDelete').addEventListener('click', () => {
          const pending = STORE.ui.pendingDelete;
          if (pending) {
            if (pending.type === 'stock') {
              const idx = STORE.products.findIndex((p) => p.id === pending.id);
              if (idx !== -1) {
                const removed = STORE.products[idx];
                STORE.products.splice(idx, 1);
                STORE.cart = STORE.cart.filter((c) => c.productId !== removed.id);
                STORE.stockMovements.unshift({
                  id: 'sm-' + Date.now(),
                  date: todayIso,
                  product: removed.name,
                  qr: removed.qr,
                  type: 'Eliminado de Stock',
                  delta: -removed.stock,
                  user: getActiveUser().name
                });
                showToast(`Producto "${removed.name}" eliminado del stock`);
              }
            } else if (pending.type === 'materia') {
              const idx = STORE.rawMaterials.findIndex((r) => r.id === pending.id);
              if (idx !== -1) {
                const removed = STORE.rawMaterials[idx];
                STORE.rawMaterials.splice(idx, 1);
                showToast(`Insumo "${removed.name}" eliminado de materia prima`);
              }
            } else if (pending.type === 'usuario') {
              if (getActiveUser().role === 'Administrador') {
                STORE.users = STORE.users.filter((u) => u.id !== pending.id);
                showToast('Usuario eliminado correctamente');
              }
            }
          }
          STORE.ui.pendingDelete = null;
          document.getElementById('confirmDeleteModal').classList.add('hidden');
          renderAll();
        });

        // Autenticación por PIN validada en Laravel, tanto al entrar como al cambiar de usuario.
        document.getElementById('btnCancelUserPin').addEventListener('click', () => {
          if (STORE.ui.loginRequired) return;
          STORE.ui.pendingSwitchUserId = null;
          document.getElementById('userPinAuthModal').classList.add('hidden');
        });

        document.getElementById('formVerifyUserPin').addEventListener('submit', async (e) => {
          e.preventDefault();

          const targetId = document.getElementById('userPinAuthUser').value;
          const enteredPin = document.getElementById('userPinAuthInput').value.trim();
          const errEl = document.getElementById('userPinAuthError');
          const pinInput = document.getElementById('userPinAuthInput');
          const submitButton = e.currentTarget.querySelector('button[type="submit"]');

          if (!targetId || !/^[0-9]{4}$/.test(enteredPin)) {
            errEl.textContent = 'Selecciona un usuario e ingresa un PIN de cuatro dígitos.';
            errEl.classList.remove('hidden');
            pinInput.focus();
            return;
          }

          submitButton.disabled = true;
          submitButton.textContent = 'Verificando…';

          try {
            const result = await NFS_DB.login(targetId, enteredPin);
            STORE.activeUserId = result.user.id;
            STORE.ui.pendingSwitchUserId = null;
            STORE.ui.loginRequired = false;

            errEl.classList.add('hidden');
            pinInput.value = '';

            await NFS_DB.load();
            document.getElementById('userPinAuthModal').classList.add('hidden');
            document.getElementById('btnCancelUserPin').classList.add('hidden');
            document.getElementById('userSwitcherPopover').classList.add('hidden');
            document.getElementById('userSwitcherBackdrop').classList.add('hidden');

            renderAll();
            updateRegistroPreview(true);
            NFS_DB.start();
            showToast(`Sesión iniciada: ${result.user.name}`);
          } catch (error) {
            console.error('NFS login', error);
            errEl.textContent = error.status === 422
              ? 'Usuario o PIN incorrecto. Verifica los datos.'
              : 'No fue posible iniciar sesión. Intenta nuevamente.';
            errEl.classList.remove('hidden');
            pinInput.value = '';
            pinInput.focus();
          } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Ingresar';
          }
        });

        // Clientes eventos
        document.getElementById('clientSearchInput').addEventListener('input', (e) => {
          STORE.ui.clientSearch = e.target.value;
          renderClientsModule();
        });
        document.getElementById('btnToggleNewClientForm').addEventListener('click', () => {
          document.getElementById('formAddCustomClient').classList.toggle('hidden');
        });
        document.getElementById('formAddCustomClient').addEventListener('submit', (e) => {
          e.preventDefault();
          const name = document.getElementById('newClientName').value.trim();
          const phone = document.getElementById('newClientPhone').value.trim();
          const newId = 'c-' + Date.now();
          STORE.customClients.unshift({ id: newId, name, phone, notes: 'Cliente registrado manualmente.' });
          STORE.ui.selectedClientId = newId;
          document.getElementById('newClientName').value = '';
          document.getElementById('newClientPhone').value = '';
          document.getElementById('formAddCustomClient').classList.add('hidden');
          showToast(`Cliente "${name}" agregado`);
          renderAll();
        });

        window.addEventListener('resize', updateViewportAndGridMetrics);
      }

            // ----------------------------------------------------------------------
      // PERSISTENCIA EN LARAVEL + MYSQL/SQLITE (sesión autenticada)
      // ----------------------------------------------------------------------
      const NFS_DB = (() => {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const known = { sales: new Set(), stockMovements: new Set() };
        let lastJson = '';
        let saving = false;
        let online = true;
        let started = false;

        const api = async (url, options = {}) => {
          const res = await fetch(url, {
            ...options,
            credentials: 'same-origin',
            headers: {
              Accept: 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf,
              'X-Requested-With': 'XMLHttpRequest',
              ...(options.headers || {})
            }
          });

          const payload = await res.json().catch(() => ({}));

          if (!res.ok) {
            const error = new Error(payload.message || ('HTTP ' + res.status));
            error.status = res.status;
            error.payload = payload;
            throw error;
          }

          return payload;
        };

        const setOnline = (ok) => {
          if (ok === online) return;
          online = ok;
          showToast(
            ok ? 'Base de datos sincronizada de nuevo' : 'Sin conexión con la base de datos: reintentando…',
            ok ? 'success' : 'warn'
          );
        };

        const snapshot = () => ({
          users: STORE.users,
          colorPalette: STORE.colorPalette,
          products: STORE.products,
          rawMaterials: STORE.rawMaterials,
          orders: STORE.orders,
          customClients: STORE.customClients,
          terminalFeePct: STORE.terminalFeePct,
          quoteFolioCounter: STORE.quoteFolioCounter
        });

        async function login(uid, pin) {
          return api('/nfs/login', {
            method: 'POST',
            body: JSON.stringify({ uid, pin })
          });
        }

        async function load() {
          const data = await api('/nfs/bootstrap');

          if (!data.initialized) {
            throw new Error('La base de datos no está inicializada. Debe importarse el respaldo antes de usar el sistema.');
          }

          ['users', 'colorPalette', 'products', 'rawMaterials', 'orders', 'customClients', 'sales', 'stockMovements']
            .forEach((key) => { STORE[key] = data[key]; });

          STORE.terminalFeePct = data.terminalFeePct;
          STORE.quoteFolioCounter = data.quoteFolioCounter;
          STORE.activeUserId = data.currentUser?.id || STORE.activeUserId;

          if (!STORE.users.some((user) => user.id === STORE.activeUserId)) {
            STORE.activeUserId = (STORE.users.find((user) => user.active) || STORE.users[0] || {}).id;
          }

          STORE.cart = STORE.cart.filter((cartItem) =>
            STORE.products.some((product) => product.id === cartItem.productId)
          );

          STORE.sales.forEach((sale) => known.sales.add(sale.id));
          STORE.stockMovements.forEach((movement) => known.stockMovements.add(movement.id));
          lastJson = JSON.stringify(snapshot());
          setOnline(true);
        }

        async function initialize() {
          try {
            const session = await api('/nfs/session');

            if (session.authenticated) {
              STORE.activeUserId = session.user.id;
              await load();
              return true;
            }
          } catch (error) {
            if (error.status !== 401) {
              console.error('NFS session check', error);
              setOnline(false);
              throw error;
            }
          }

          const response = await api('/nfs/login-users');
          STORE.users = response.users || [];
          STORE.ui.loginRequired = true;
          STORE.ui.pendingSwitchUserId = null;

          populateUserPinSelect(STORE.users, STORE.users[0]?.id || '');
          document.getElementById('userPinAuthSubtitle').textContent =
            'Selecciona tu usuario e ingresa tu PIN de cuatro dígitos.';
          document.getElementById('btnCancelUserPin').classList.add('hidden');
          document.getElementById('userPinAuthError').classList.add('hidden');
          document.getElementById('userPinAuthModal').classList.remove('hidden');

          if (STORE.users.length === 0) {
            const error = document.getElementById('userPinAuthError');
            error.textContent = 'No hay usuarios activos. Se requiere configurar un administrador antes de ingresar.';
            error.classList.remove('hidden');
            document.querySelector('#formVerifyUserPin button[type="submit"]').disabled = true;
          }

          return false;
        }

        async function save(force = false) {
          if (saving || STORE.ui.loginRequired) return false;

          const snap = snapshot();
          const json = JSON.stringify(snap);
          const newSales = STORE.sales.filter((sale) => !known.sales.has(sale.id));
          const newMoves = STORE.stockMovements.filter((movement) => !known.stockMovements.has(movement.id));

          if (!force && json === lastJson && !newSales.length && !newMoves.length) return true;

          saving = true;

          try {
            await api('/nfs/sync', {
              method: 'POST',
              body: JSON.stringify({ ...snap, sales: newSales, stockMovements: newMoves })
            });

            // El PIN de un usuario nuevo solo vive en memoria hasta que el servidor
            // confirma el guardado; después se elimina del estado del navegador.
            STORE.users.forEach((user) => {
              if (Object.prototype.hasOwnProperty.call(user, 'pin')) {
                delete user.pin;
              }
            });

            lastJson = JSON.stringify(snapshot());
            newSales.forEach((sale) => known.sales.add(sale.id));
            newMoves.forEach((movement) => known.stockMovements.add(movement.id));
            setOnline(true);
            return true;
          } catch (error) {
            console.error('NFS sync', error);
            setOnline(false);

            if (error.status === 401) {
              STORE.ui.loginRequired = true;
              const cancelButton = document.getElementById('btnCancelUserPin');
              cancelButton.classList.add('hidden');
              populateUserPinSelect(STORE.users, STORE.activeUserId);
              document.getElementById('userPinAuthSubtitle').textContent =
                'La sesión expiró. Vuelve a ingresar tu PIN.';
              document.getElementById('userPinAuthModal').classList.remove('hidden');
            }

            return false;
          } finally {
            saving = false;
          }
        }

        async function logout() {
          return api('/nfs/logout', {
            method: 'POST',
            body: JSON.stringify({})
          });
        }

        function start() {
          if (started) return;
          started = true;
          setInterval(() => save(), 1500);
          document.addEventListener('visibilitychange', () => {
            if (document.hidden) save();
          });
        }

        return { api, login, load, initialize, save, logout, start };
      })();

            // ----------------------------------------------------------------------
      // WHATSAPP CLICK-TO-CHAT  (https://wa.me/52{telefono}?text={mensaje})
      // ----------------------------------------------------------------------
      function waPhone(raw) {
        let d = String(raw || '').replace(/\D/g, '');
        if (d.startsWith('00')) d = d.slice(2);
        if (d.length === 10) return '52' + d;                          // 33 1845 9021
        if (d.length === 12 && d.startsWith('52')) return d;           // 52 33 1845 9021
        if (d.length === 13 && d.startsWith('521')) return '52' + d.slice(3); // formato viejo 521...
        return null;
      }

      function openWhatsApp(rawPhone, text) {
        const phone = waPhone(rawPhone);
        if (!phone) {
          showToast('Teléfono no válido: captura 10 dígitos (ej. 33 1234 5678)', 'warn');
          return;
        }
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(text)}`, '_blank', 'noopener');
      }

      function initWhatsApp() {
        document.addEventListener('click', (e) => {
          // 1) Pedidos: aviso de estatus / "Pedido Listo para Entrega"
          const orderBtn = e.target.closest('[data-wa-order]');
          if (orderBtn) {
            const o = STORE.orders.find((x) => x.id === orderBtn.dataset.waOrder);
            if (!o) return;
            const balance = Math.max(0, o.totalAmount - o.advancePaid);
            const saldo = balance === 0
              ? 'Tu pedido está *liquidado* ✅'
              : `Saldo pendiente: *${formatMoney(balance)} MXN*`;
            const text = o.prodStatus === 'Listo para Entrega'
              ? `Hola ${o.clientName} 👋\nTu pedido *${o.folio}* de NEED FOR STREET ya está *LISTO PARA ENTREGA* ✅\n${saldo}\n¡Pasa por él cuando gustes!`
              : `Hola ${o.clientName} 👋\nEstatus de tu pedido *${o.folio}*: *${o.prodStatus}*\nTotal: ${formatMoney(o.totalAmount)} • Anticipo: ${formatMoney(o.advancePaid)}\n${saldo}`;
            openWhatsApp(o.clientPhone, text);
            return;
          }

          // 2) Cotización: envía el folio COT-xxx con el resumen
          if (e.target.closest('#btnQuoteWhatsapp')) {
            const totals = computeQuoteTotals();
            if (totals.computedGroups.length === 0) {
              showToast('Agrega al menos un grupo para enviar la cotización', 'warn');
              return;
            }
            const client = document.getElementById('quoteClientInput').value.trim() || 'cliente';
            const phone = document.getElementById('quoteClientPhoneInput').value;
            const lines = totals.computedGroups.map((g) => `• ${g.pieces}× ${g.articleName}`).join('\n');
            openWhatsApp(
              phone,
              `Hola ${client} 👋\nTe comparto tu cotización *COT-${STORE.quoteFolioCounter}* de NEED FOR STREET — Hecho para destacar:\n${lines}\n*Total: ${formatMoney(totals.finalTotal)} MXN*\nCualquier duda estoy a tus órdenes. ¡Gracias!`
            );
            return;
          }

          // 3) Clientes: mensaje de contacto
          const cliBtn = e.target.closest('[data-wa-client]');
          if (cliBtn) {
            const c = STORE.customClients.find((x) => x.id === cliBtn.dataset.waClient);
            if (c) openWhatsApp(c.phone, `Hola ${c.name} 👋 te escribimos de NEED FOR STREET — Hecho para destacar.`);
          }
        });
      }
      // Arrancar aplicación: primero comprobar sesión o solicitar PIN al servidor.
      window.addEventListener('DOMContentLoaded', async () => {
        initEvents();
        initWhatsApp();

        try {
          const authenticated = await NFS_DB.initialize();

          if (authenticated) {
            renderAll();
            updateRegistroPreview(true);
            NFS_DB.start();
          }
        } catch (error) {
          console.error('NFS initialization', error);
          showToast('No fue posible conectar con la base de datos.', 'error');
        }
      });
    })();
  </script>
</body>
</html>
