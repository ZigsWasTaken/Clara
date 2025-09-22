<?php
  // Define initial values here
  $initial_title  = "Clara.lua - 1.0.4";
  $initial_title2  = "https://discord.gg/paCX7QBtw9";
  $initial_server = "Server";
  $initial_fps    = "FPS";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clara.lua</title>

  <style>
    :root {
      /* Dynamic content */
      --title-text: "<?php echo htmlspecialchars($initial_title); ?>";

      /* Watermark / BG controls */
      --wm-opacity: 0.10;
      --wm-size: 360px;
      --wm-rotate: -15deg;
      --wm-speed: 28s;
      --wm-speed-alt: 42s;

      /* Particles */
      --particle-opacity: 0.35;
      --particle-speed: 12s;

      /* Accent color (RGB triplet) */
      --accent: 255, 255, 255;

      /* Motion */
      --pulse-scale: 1.25;
      --brand-float: 10px;

      /* Crossfade for smooth BG updates */
      --crossfade-ms: 600ms;
    }

    html, body {
      height: 100%;
      background: transparent !important;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    body {
      font-family: ui-sans-serif, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      color: rgba(255,255,255,0.92);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .brand {
      position: fixed;
      top: 16px;
      left: 16px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 14px;
      background: rgba(20,20,20,0.45);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.35);
      user-select: none;
      pointer-events: none;
      transform: translateY(0);
      animation: brandFloat 6s ease-in-out infinite;
    }

    .brand .logo {
      max-height: 34px;
      height: 5.5vmin;
      width: auto;
      filter: drop-shadow(0 6px 22px rgba(0,0,0,0.35));
      -webkit-user-drag: none;
    }

    .brand .chip {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 10px;
      border-radius: 12px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      white-space: nowrap;
    }

    .brand .chip .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(var(--accent), 0.95);
      box-shadow: 0 0 12px rgba(var(--accent), 0.9), 0 0 30px rgba(var(--accent), 0.55);
      animation: pulse 2.4s ease-in-out infinite;
    }
    .brand .chip .text { font-weight: 700; letter-spacing: 0.2px; font-size: 12.5px; }

    /* Left stack now vertical so Spectators sits under FPS */
    .left-stack {
      position: fixed;
      top: 90px;
      left: 16px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      pointer-events: none;
      animation: brandFloat 6s ease-in-out infinite;
      width: max-content;
      min-width: 220px;
    }

    .info-stack {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .info-card {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 8px 12px;
      border-radius: 12px;
      background: rgba(20,20,20,0.45);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.35);
      font-size: 13px;
      transition: background-color 300ms ease;
      width: 100%;
    }
    .info-card .label { font-weight: 500; opacity: 0.7; }
    .info-card .value { font-weight: 700; }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.9; }
      50% { transform: scale(var(--pulse-scale)); opacity: 0.6; }
    }

    @keyframes brandFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(var(--brand-float)); }
    }

    .watermark {
      position: fixed;
      inset: 0;
      pointer-events: none;
      transform: rotate(var(--wm-rotate));
      transform-origin: center;
      overflow: visible;
      top: 50px;
    }

    .wm-layer {
      position: absolute;
      inset: -35%;
      background-size: var(--wm-size) var(--wm-size);
      background-repeat: repeat;
      image-rendering: -webkit-optimize-contrast;
      filter: drop-shadow(0 2px 0 rgba(0,0,0,0.08));
      opacity: var(--wm-opacity);
      animation: drift var(--wm-speed) linear infinite;
      transition: opacity var(--crossfade-ms) ease, filter 400ms ease;
    }

    .wm-layer.alt {
      animation-duration: var(--wm-speed-alt);
      animation-direction: reverse;
      opacity: calc(var(--wm-opacity) * 0.9);
    }

    @keyframes drift {
      0% { background-position: 0 0; }
      100% { background-position: var(--wm-size) var(--wm-size); }
    }

    .particles {
      position: fixed;
      inset: 0;
      pointer-events: none;
      background-image:
        radial-gradient(circle at 10% 20%, rgba(255,255,255,0.12) 0 2px, transparent 3px),
        radial-gradient(circle at 80% 30%, rgba(255,255,255,0.10) 0 2px, transparent 3px),
        radial-gradient(circle at 30% 70%, rgba(255,255,255,0.08) 0 2px, transparent 3px),
        radial-gradient(circle at 60% 80%, rgba(255,255,255,0.06) 0 2px, transparent 3px);
      background-size: 100% 100%;
      animation: floaty var(--particle-speed) ease-in-out infinite alternate;
      opacity: var(--particle-opacity);
      mix-blend-mode: screen;
    }

    @keyframes floaty {
      from { transform: translateY(0px) }
      to   { transform: translateY(-8px) }
    }

    .title {
      position: fixed;
      left: 18px;
      bottom: 18px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 14px;
      border-radius: 14px;
      background: rgba(20,20,20,0.45);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.35);
      white-space: nowrap;
      pointer-events: none;
    }

    .title .dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: rgba(var(--accent), 0.95);
      box-shadow: 0 0 12px rgba(var(--accent), 0.9), 0 0 30px rgba(var(--accent), 0.55);
      animation: pulse 2.4s ease-in-out infinite;
    }
    .title .text { font-weight: 600; letter-spacing: 0.2px; }

    /* =========================
       Optimized Notification System
       ========================= */
    #notifyRoot {
      position: fixed;
      top: 12px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 9999;
      pointer-events: none;
      display: flex;
      flex-direction: column;
      gap: 12px;
      align-items: center;
    }

    .clara-notif {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 20px;
      border-radius: 99px;
      background: rgba(20,20,20,0.60);
      border: 1px solid rgba(255,255,255,0.12);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      color: rgba(255,255,255,0.96);
      box-shadow: 0 14px 40px rgba(0,0,0,0.35);
      overflow: hidden;
      pointer-events: none;
      will-change: transform, opacity, max-height, margin;
      transform: translateY(-20px) scale(0.9);
      opacity: 0;
      max-height: 100px;
      margin-top: 0;
      transition: transform 0.4s cubic-bezier(.22,.61,.36,1),
                  opacity 0.4s cubic-bezier(.22,.61,.36,1);
    }

    .clara-notif.show { transform: translateY(0) scale(1); opacity: 1; }
    .clara-notif.hide {
      max-height: 0;
      opacity: 0;
      margin-top: 0;
      transform: translateY(-20px);
      transition: max-height 0.4s ease-out, opacity 0.4s ease-out, margin-top 0.4s ease-out, transform 0.4s ease-out;
    }

    .clara-notif .n-logo { height: 40px; width: auto; filter: drop-shadow(0 6px 22px rgba(0,0,0,0.35)); -webkit-user-drag: none; flex-shrink: 0; }
    .clara-notif .n-text {
      display: inline-flex;
      align-items: baseline;
      gap: 6px;
      white-space: nowrap;
      font-weight: 800;
      letter-spacing: .2px;
      opacity: 0;
      transform: translateX(10px);
      transition: opacity 0.3s ease 0.2s, transform 0.4s cubic-bezier(.22,.61,.36,1) 0.1s;
    }
    .clara-notif.show .n-text { opacity: 1; transform: translateX(0); }
    .clara-notif .n-mult { opacity: .75; font-weight: 700; }

    /* ========================= Spectators Card ========================= */
    .spectators-card {
      display: flex;
      flex-direction: column;
      gap: 8px;
      width: 100%;
      padding: 12px 14px;
      border-radius: 14px;
      background: rgba(20,20,20,0.45);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.35);
      pointer-events: none;
      overflow: hidden;
      /* Smoothly adapt height */
      transition: max-height 380ms cubic-bezier(.22,.61,.36,1), padding 280ms ease, gap 280ms ease, border-color 280ms ease, background-color 280ms ease;
      max-height: 600px; /* will be updated in JS on expand */
    }

    .sp-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
      padding: 0; /* container spacing handled by card */
    }

    .sp-title {
      font-weight: 800;
      color: rgba(255,255,255,0.98);
      letter-spacing: .2px;
      font-size: 14px;
    }

    .sp-status {
      font-size: 13px;
      font-weight: 800;
      letter-spacing: .2px;
    }
    .sp-status.sp-none {
      color: rgba(255,255,255,0.55);
      background: rgba(0,0,0,0.35);
      padding: 2px 8px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow: inset 0 0 0 1px rgba(0,0,0,0.25);
    }

    .viewer {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      gap: 8px;
      padding: 8px 10px;
      border-radius: 10px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      opacity: 1;
      transition: opacity 220ms ease, transform 220ms ease;
    }

    .gradient-text {
      font-weight: 800;
      letter-spacing: .2px;
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      white-space: nowrap;
    }
    .gradient-jackey {
      background-image: linear-gradient(90deg, #8affff, #9bff85, #ffd56b, #8affff);
      background-size: 300% 300%;
      animation: sweepJackey 3.2s ease-in-out infinite;
    }
    .gradient-dick {
      background-image: linear-gradient(90deg, #ff8ad6, #9aa6ff, #6bf0ff, #ff8ad6);
      background-size: 300% 300%;
      animation: sweepDick 4.4s ease-in-out infinite, shimmerDick 2.6s ease-in-out infinite;
      background-position: 0% 50%;
    }
    @keyframes sweepJackey {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    @keyframes sweepDick {
      0% { background-position: 100% 50%; }
      50% { background-position: 0% 50%; }
      100% { background-position: 100% 50%; }
    }
    @keyframes shimmerDick {
      0%,100% { filter: brightness(1); }
      50% { filter: brightness(1.15); }
    }
    .spectators-card .name { font-size: 13px; }
    .spectators-card .pct  { font-size: 13px; }

    /* Collapsed state: smoothly shrink under FPS and show only "Spectators — none" */
    .spectators-card.is-collapsed {
      gap: 4px;
      padding: 8px 12px;
      max-height: 46px; /* just tall enough for header row */
      background: rgba(20,20,20,0.40);
      border-color: rgba(255,255,255,0.08);
    }
    .spectators-card.is-collapsed .viewer-list {
      opacity: 0;
      transform: translateY(-6px);
      pointer-events: none;
    }

  </style>
</head>

<body class="no-js">

  <div class="brand" role="group" aria-label="Brand">
    <img class="logo" src="img/Logo.png" alt="Logo" />
    <div class="chip" role="note" aria-label="Watermark Chip">
      <span class="dot" aria-hidden="true"></span>
      <span class="text" id="brandText"><?php echo htmlspecialchars($initial_title); ?></span>
    </div>
  </div>

  <!-- Left floating stack: info cards + spectators underneath FPS -->
  <div class="left-stack" id="leftStack">
    <div class="info-stack" id="info-stack">
      <div class="info-card" id="serverCard">
          <span class="label" id="serverLabel">Server:</span>
          <span class="value" id="serverText"><?php echo htmlspecialchars($initial_server); ?></span>
      </div>
      <div class="info-card" id="fpsCard">
          <span class="label" id="fpsLabel">FPS:</span>
          <span class="value" id="fpsText"><?php echo htmlspecialchars($initial_fps); ?></span>
      </div>

      <!-- Spectators Card (now directly under FPS) -->
      <div class="spectators-card" id="spectatorsCard" role="region" aria-label="Spectators">
        <div class="sp-row sp-head">
          <div class="sp-title">Spectators</div>
          <div class="sp-status" id="spStatus"></div>
        </div>
        <div class="viewer-list" id="viewerList" aria-live="polite" aria-atomic="true">
          <div class="viewer">
            <span class="name gradient-text gradient-jackey">Jackey</span>
            <span class="pct  gradient-text gradient-jackey">99%</span>
          </div>
          <div class="viewer">
            <span class="name gradient-text gradient-dick">Dick</span>
            <span class="pct  gradient-text gradient-dick">83%</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="watermark" aria-hidden="true">
    <div class="wm-layer" id="wmA"></div>
    <div class="wm-layer alt" id="wmB"></div>
  </div>

  <div class="particles" aria-hidden="true"></div>

  <div class="title" role="note" aria-label="Overlay Title">
    <span class="dot" aria-hidden="true"></span>
    <span class="text" id="titleText"><?php echo htmlspecialchars($initial_title2); ?></span>
  </div>

  <div id="notifyRoot" aria-live="polite" aria-atomic="false"></div>

  <script>
    const $  = (sel) => document.querySelector(sel);
    const $$ = (sel) => document.querySelectorAll(sel);

    function escapeXML(s){
      return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    const svgPattern = (t) => (
      `<svg xmlns='http://www.w3.org/2000/svg' width='360' height='360'>`+
      `<rect width='100%' height='100%' fill='none'/>`+
      `<g fill='white' fill-opacity='1'>`+
      `<text x='0' y='80' font-family='Arial, sans-serif' font-weight='700' font-size='24'>${escapeXML(t)}</text>`+
      `<text x='60' y='180' font-family='Arial, sans-serif' font-weight='700' font-size='24'>${escapeXML(t)}</text>`+
      `<text x='0' y='280' font-family='Arial, sans-serif' font-weight='700' font-size='24'>${escapeXML(t)}</text>`+
      `</g></svg>`
    );
    const dataURI = (s) => `data:image/svg+xml;utf8,${s}`;

    function setLayerImage(el, text){
      el.style.backgroundImage = `url('${dataURI(svgPattern(text))}')`;
    }

    function updateWatermarkTextSmooth(text){
      const a = $('#wmA');
      const b = $('#wmB');
      b.style.opacity = 0;
      setTimeout(() => {
        setLayerImage(b, text);
        b.style.opacity = getComputedStyle(a).getPropertyValue('opacity') || 1;
        a.style.opacity = 0.0001;
        setTimeout(() => {
          setLayerImage(a, text);
          a.style.opacity = getComputedStyle(document.documentElement).getPropertyValue('--wm-opacity') || 0.1;
        }, 600);
      }, 20);
    }

    function setTitleText(text){
      try {
        document.documentElement.style.setProperty('--title-text', `"${text}"`);
      } catch {}
      $('#titleText').textContent = text;
      $('#brandText').textContent = text;
      updateWatermarkTextSmooth(text);
    }
    function setServerText(name) { $('#serverText').textContent = name; }
    function setFPSText(value)  { $('#fpsText').textContent = value; }

    (function init(){
      const txt = getComputedStyle(document.documentElement)
        .getPropertyValue('--title-text').trim().replace(/^"|"$/g,'');
      setLayerImage($('#wmA'), txt);
      setLayerImage($('#wmB'), txt);
    })();

    // ===== Spectators logic (auto-scale height + smooth collapse to "none") =====
    const spCard   = $('#spectatorsCard');
    const spList   = $('#viewerList');
    const spStatus = $('#spStatus');

    // Helpers to animate auto height with max-height
    function measureContentHeight() {
      // Temporarily set max-height to huge to measure actual height
      const prev = spCard.style.maxHeight;
      spCard.style.maxHeight = '1000px';
      const h = spCard.scrollHeight;
      spCard.style.maxHeight = prev || '';
      return h;
    }

    function expandCard() {
      spCard.classList.remove('is-collapsed');
      const target = measureContentHeight();
      spCard.style.maxHeight = target + 'px';
    }

    function collapseCard() {
      spCard.classList.add('is-collapsed');
      // max-height set via CSS for collapsed height
      // ensure CSS takes effect
      spCard.style.maxHeight = '';
    }

    function setSpectators(viewers) {
      // Update list
      spList.innerHTML = '';
      if (viewers.length === 0) {
        // Show "none" status darker & with lower opacity
        spStatus.textContent = 'none';
        spStatus.classList.add('sp-none');
        collapseCard();
        return;
      }

      // Non-empty: populate rows
      const frag = document.createDocumentFragment();
      viewers.forEach(v => {
        const row = document.createElement('div');
        row.className = 'viewer';
        const name = document.createElement('span');
        name.className = 'name gradient-text ' + (v.gradient || '');
        name.textContent = v.name;
        const pct = document.createElement('span');
        pct.className = 'pct gradient-text ' + (v.gradient || '');
        pct.textContent = v.pct;
        row.appendChild(name);
        row.appendChild(pct);
        frag.appendChild(row);
      });
      spList.appendChild(frag);

      // Update status (optional: count)
      spStatus.textContent = viewers.length + (viewers.length === 1 ? ' viewer' : ' viewers');
      spStatus.classList.remove('sp-none');

      // Expand smoothly and autoscale
      // First, force opacity back (if previously collapsed)
      spList.style.opacity = '1';
      spList.style.transform = 'translateY(0)';
      expandCard();
    }

    // Initialize status based on initial DOM
    (function initSpectatorsFromDOM() {
      const existing = [...spList.querySelectorAll('.viewer')].map((el) => {
        const name = el.querySelector('.name')?.textContent?.trim() || 'Viewer';
        const pct  = el.querySelector('.pct')?.textContent?.trim()  || '';
        const cls  = [...(el.querySelector('.name')?.classList || [])]
                      .find(c => c.startsWith('gradient-')) || '';
        return { name, pct, gradient: cls };
      });
      setSpectators(existing);
    })();

    // Toggle to "none" every 3 seconds as requested
    // It alternates between initial viewers and none
    const INITIAL_VIEWERS = [
      { name: 'Jackey', pct: '99%', gradient: 'gradient-jackey' },
      { name: 'Dick',   pct: '83%', gradient: 'gradient-dick' }
    ];
    let showNone = true;
    setInterval(() => {
      if (showNone) {
        setSpectators([]);                // collapse and show "none"
      } else {
        setSpectators(INITIAL_VIEWERS);   // expand and auto-scale to fit rows
      }
      showNone = !showNone;
    }, 3000);

    // ===== DUI API =====
    window.Clara = {
      applyPreset(name){
        const p = this.presets[name];
        if(!p) return;
        for(const [k,v] of Object.entries(p)){
          document.documentElement.style.setProperty(k, v);
        }
      },
      setTitle(text){ setTitleText(text); },
      setServer(name) { setServerText(name); },
      setFPS(value) { setFPSText(value); },
      toggleInfoCards(show) {
          const display = show ? 'flex' : 'none';
          $('#leftStack').style.display = display;
      },
      setInfoCardLabels(serverLabel = 'Server:', fpsLabel = 'FPS:') {
          $('#serverLabel').textContent = serverLabel;
          $('#fpsLabel').textContent = fpsLabel;
      },
      setInfoCardColor(r=20, g=20, b=20, a=0.45) {
          $$('.info-card').forEach(card => {
              card.style.backgroundColor = `rgba(${r}, ${g}, ${b}, ${a})`;
          });
      },
      setAccentRGB(r=255,g=255,b=255){ document.documentElement.style.setProperty('--accent', `${r}, ${g}, ${b}`); },
      setWatermark(angleDeg){ document.documentElement.style.setProperty('--wm-rotate', angleDeg + 'deg'); },
      setSpeed(wm=28, alt=42, particle=12){
        document.documentElement.style.setProperty('--wm-speed', wm + 's');
        document.documentElement.style.setProperty('--wm-speed-alt', alt + 's');
        document.documentElement.style.setProperty('--particle-speed', particle + 's');
      },
      setOpacity(wm=0.10, particles=0.35){
        document.documentElement.style.setProperty('--wm-opacity', wm);
        document.documentElement.style.setProperty('--particle-opacity', particles);
        const txt = getComputedStyle(document.documentElement).getPropertyValue('--title-text').trim().replace(/^"|"$/g,'');
        updateWatermarkTextSmooth(txt);
      },
      // Expose spectators control as part of API too
      setSpectators(list){ setSpectators(Array.isArray(list) ? list : []); },

      presets: {
        idle:   { '--wm-opacity': '0.10', '--wm-rotate': '-15deg', '--wm-speed':'28s', '--wm-speed-alt':'42s', '--particle-opacity':'0.35', '--particle-speed':'12s', '--pulse-scale':'1.25', '--brand-float':'10px' },
        macho:  { '--wm-opacity': '0.16', '--wm-rotate': '-12deg', '--wm-speed':'18s', '--wm-speed-alt':'26s', '--particle-opacity':'0.45', '--particle-speed':'8s',  '--pulse-scale':'1.35', '--brand-float':'12px' },
        nebula: { '--wm-opacity': '0.08', '--wm-rotate': '-25deg', '--wm-speed':'36s', '--wm-speed-alt':'54s', '--particle-opacity':'0.30', '--particle-speed':'16s', '--pulse-scale':'1.18', '--brand-float':'6px'  },
        matrix: { '--wm-opacity': '0.12', '--wm-rotate': '-40deg', '--wm-speed':'24s', '--wm-speed-alt':'36s', '--particle-opacity':'0.25', '--particle-speed':'10s', '--pulse-scale':'1.20', '--brand-float':'8px'  },
        stealth:{ '--wm-opacity': '0.05', '--wm-rotate': '-18deg', '--wm-speed':'38s', '--wm-speed-alt':'60s', '--particle-opacity':'0.18', '--particle-speed':'18s', '--pulse-scale':'1.12', '--brand-float':'4px'  }
      }
    };

    // =========================
    // Optimized Notification System with Stacking & List Layout
    // =========================
    (function(){
      const rootSel = '#notifyRoot';
      const DEFAULT_LOGO = 'img/Logo.png';

      function buildNotif({ text, logo }){
        const el = document.createElement('div');
        el.className = 'clara-notif';
        el.setAttribute('role','alert');
        const img = document.createElement('img');
        img.className = 'n-logo';
        img.src = logo || DEFAULT_LOGO;
        const textWrap = document.createElement('div');
        textWrap.className = 'n-text';
        const title = document.createElement('span');
        title.className = 'n-title';
        title.textContent = text;
        const mult = document.createElement('span');
        mult.className = 'n-mult';
        mult.textContent = '';
        textWrap.appendChild(title);
        textWrap.appendChild(mult);
        el.appendChild(img);
        el.appendChild(textWrap);
        return { el, title, mult };
      }

      function updateMultiplier(parts, count){
        parts.mult.textContent = count > 1 ? `×${count}` : '';
        parts.el.animate(
          [{ transform: 'scale(1.0)' }, { transform: 'scale(1.05)' }, { transform: 'scale(1.0)' }],
          { duration: 220, easing: 'ease-out' }
        );
      }

      function scheduleHide(el, ms){
        el.hideTimer = setTimeout(() => {
          el.classList.add('hide');
          el.addEventListener('transitionend', () => {
            el.remove();
          }, { once: true });
        }, ms);
      }

      function showNotification(text, opts = {}){
        const { logo = DEFAULT_LOGO, duration = 3000 } = opts;
        const root = document.querySelector(rootSel);
        if(!root) return;

        const recentNotif = root.querySelector('.clara-notif:not(.hide)');

        // Merge with the most recent if identical
        if (recentNotif && recentNotif.textContent.includes(text)) {
            let count = parseInt(recentNotif.dataset.count || 1);
            count = Math.min(count + 1, 99);
            recentNotif.dataset.count = count;
            const parts = { el: recentNotif, mult: recentNotif.querySelector('.n-mult') };
            updateMultiplier(parts, count);
            clearTimeout(recentNotif.hideTimer);
            scheduleHide(recentNotif, duration);
            return;
        }

        // Create a new notification
        const parts = buildNotif({ text, logo });
        parts.el.dataset.count = 1;

        // Add to top
        root.prepend(parts.el);

        // Force layout before show
        parts.el.offsetWidth;

        parts.el.classList.add('show');
        scheduleHide(parts.el, duration);
      }

      if (!window.Clara) window.Clara = {};
      window.Clara.notify         = function(text){ showNotification(String(text || '')); };
      window.Clara.notifyAdvanced = function(text, opts){ showNotification(String(text || ''), opts || {}); };
    })();
  </script>

</body>
</html>
