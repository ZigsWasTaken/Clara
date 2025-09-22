<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* =========================
       DUI-SAFE TRANSPARENCY
       ========================= */
    html, body {
      background: transparent !important;
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden;
      color: #E7EAF0;
      font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    :root{
      --card: rgba(10,12,18,0.80);
      --card-2: rgba(14,16,24,0.78);
      --border: rgba(72,76,91,0.40);
      --muted: #9AA3B2;

      --a1: #7C5CFF;
      --a2: #16E1FF;
      --a3: #00FFA3;

      --radius: 18px;
      --shadow: 0 10px 30px rgba(0,0,0,.35);
      --speed: 220ms;
      --speed-fast: 140ms;
      --easing: cubic-bezier(.22,.61,.36,1);
    }

    .menu-root{
      position: fixed;
      top: 50%;
      left: 96px;
      transform: translateY(-50%);
      display: grid;
      grid-template-columns: 340px 480px;
      column-gap: 16px;
      align-items: stretch;
      z-index: 10;
      animation: rootIn .28s var(--easing);
    }
    @keyframes rootIn {
      from { opacity: 0; transform: translate(-10px,-50%);}
      to   { opacity: 1; transform: translate(0,-50%);}
    }

    /* LEFT: RAIL */
    .rail{
      position: relative;
      border-radius: var(--radius);
      background:
        linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,0) 40%),
        var(--card);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      overflow: hidden;
      transform: translateZ(0);
    }

    /* BANNER */
    .banner{
      position: relative;
      height: 140px;
      background-size: cover;
      background-position: center;
      border-bottom: 1px solid var(--border);
      display:flex; align-items:flex-end;
      padding: 16px;
      box-shadow: inset 0 -18px 28px rgba(0,0,0,.35);
    }
    .banner::after{
      content:"";
      position:absolute; inset:0;
      background: linear-gradient(180deg, rgba(0,0,0,0) 20%, rgba(0,0,0,.45) 100%);
      pointer-events:none;
    }
    .banner-sub{
      position: relative;
      z-index: 1;
      font-size: 12px;
      color: #CAD3E2;
      opacity: .95;
      margin-top: 2px;
      text-shadow: 0 2px 8px rgba(0,0,0,.5);
    }

    /* MENU LIST (no search; simple, accurate layout) */
    .list-wrap{ position:relative; max-height: 380px; overflow:hidden; }
    .list{
      list-style:none;
      margin: 10px 8px;
      padding: 8px;
      position:relative;
      display:flex;
      flex-direction:column;
      gap:8px;      /* ensures offsetTop is stable/accurate */
    }

    /* Moving pill under selected item */
    .pill{
      position:absolute;
      left: 6px; right: 6px;
      height: 46px;
      border-radius: 12px;
      background:
        linear-gradient(90deg, rgba(124,92,255,.18), rgba(22,225,255,.10) 60%, rgba(0,255,163,.14));
      box-shadow: 0 6px 18px rgba(0,0,0,.22), inset 0 0 0 1px rgba(255,255,255,.06);
      transform: translate3d(0,0,0);
      transition: transform var(--speed) var(--easing), height var(--speed-fast) var(--easing);
      will-change: transform, height;
      z-index: 0;
    }

    .item{
      position:relative;
      z-index:1;
      display:flex; align-items:center;
      gap:12px;
      padding: 12px 14px;
      border-radius: 12px;
      cursor:pointer;
      user-select:none;
      transform: translateZ(0);
      transition: transform var(--speed-fast) var(--easing);
    }
    .item:hover{ transform: translate3d(2px,-1px,0) scale(1.02); }
    .item.selected{
      transform: translate3d(0,0,0) scale(1.02) perspective(600px) rotateY(-2deg);
    }
    /* Removed shine/sweep on selection (as requested) */

    .icon{
      width:20px;height:20px;border-radius:6px; flex: 0 0 20px;
      background: linear-gradient(135deg, rgba(124,92,255,.9), rgba(22,225,255,.9));
      box-shadow: 0 2px 10px rgba(0,0,0,.25);
    }
    .label{ font-size: 14px; font-weight: 700; letter-spacing:.2px; white-space:nowrap; }

    .rail-foot{
      margin-top: 6px; padding: 10px 14px 12px; display:flex; align-items:center; justify-content:space-between;
      border-top:1px solid var(--border); font-size:12px; color: var(--muted);
      background: linear-gradient(180deg, rgba(255,255,255,0), rgba(255,255,255,.02));
    }

    /* RIGHT: PANEL */
    .panel{
      border-radius: var(--radius);
      background:
        linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,0) 40%),
        var(--card-2);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      overflow: hidden;
      transform: translateZ(0);
    }
    .panel-head{
      padding: 14px 16px; border-bottom:1px solid var(--border);
      display:flex; justify-content:space-between; align-items:center;
      background: radial-gradient(900px 140px at 120% -30%, rgba(0,255,163,.20), transparent 60%);
    }
    .panel-title{ font-weight: 800; letter-spacing:.3px; }
    .badge{
      font-size:11px; font-weight:800; padding: 6px 10px; border-radius: 999px;
      box-shadow: 0 6px 16px rgba(0,0,0,.25);
    }
    .badge.safe{ color:#0b2012; background: linear-gradient(90deg, #00FFA3, #16E1FF); }
    .badge.risky{ color:#2a0b0b; background: linear-gradient(90deg, #ffb37a, #ff6b6b); }
    .badge.hidden{ display:none; }

    .panel-body{ padding: 16px; display:grid; gap:12px; }
    .card{ border-radius: 12px; border: 1px solid rgba(255,255,255,.06); background: rgba(255,255,255,.02); padding: 12px; }
    .card h4{ margin: 0 0 6px 0; font-size:13px; opacity:.95;}
    .card p{ margin:0; font-size:12px; color: var(--muted); }
  </style>
</head>
<body>
  <div class="menu-root" id="app">
    <!-- LEFT: RAIL -->
    <section class="rail">
      <!-- Banner with only the subtitle text -->
      <div class="banner" id="banner" style="background-image:url('img/Banner1.png');">
        <div class="banner-sub">Welcome back, zigs.</div>
      </div>

      <div class="list-wrap" id="listWrap">
        <div class="pill" id="pill"></div>
        <ul class="list" id="menu">
          <!-- (No tags here; tags/badges appear only on the right panel) -->
          <li class="item selected" data-key="player"   data-badge="safe"><div class="icon"></div><span class="label">Player</span></li>
          <li class="item"           data-key="vehicle"  data-badge="both"><div class="icon"></div><span class="label">Vehicles</span></li>
          <li class="item"           data-key="weapons"  data-badge="both"><div class="icon"></div><span class="label">Weapons</span></li>
          <li class="item"           data-key="teleport" data-badge="safe"><div class="icon"></div><span class="label">Teleport</span></li>
          <li class="item"           data-key="server"   data-badge="both"><div class="icon"></div><span class="label">Server</span></li>
          <li class="item"           data-key="time"     data-badge="safe"><div class="icon"></div><span class="label">Time &amp; Weather</span></li>
          <li class="item"           data-key="settings" data-badge="none"><div class="icon"></div><span class="label">Settings</span></li>
        </ul>
      </div>

      <footer class="rail-foot">
        <span>v1.1.2</span>
        <span>Optimized for DUI</span>
      </footer>
    </section>

    <!-- RIGHT: PANEL -->
    <section class="panel">
      <header class="panel-head">
        <div class="panel-title" id="panelTitle">Player</div>
        <!-- Badge text toggles SAFE/RISKY or hides -->
        <div class="badge safe" id="riskBadge">SAFE</div>
      </header>
      <div class="panel-body" id="panelBody">
        <div class="card"><h4>Overview</h4><p>Navigate with ↑/↓ (or MenuAPI.Up/Down). Press Enter to select.</p></div>
        <div class="card"><h4>Banner</h4><p>Replace <code>img/Banner1.png</code> with your own image.</p></div>
        <div class="card"><h4>Performance</h4><p>Animations use transform/opacity only. No blur/backdrop filters.</p></div>
      </div>
    </section>
  </div>

  <script>
    (function(){
      const menu       = document.getElementById('menu');
      const items      = Array.from(menu.querySelectorAll('.item'));
      const pill       = document.getElementById('pill');
      const listWrap   = document.getElementById('listWrap');
      const panelTitle = document.getElementById('panelTitle');
      const panelBody  = document.getElementById('panelBody');
      const riskBadge  = document.getElementById('riskBadge');

      /* Panel content per tab */
      const content = {
        player: [
          ["Health & Armor", "Adjust health, armor, invincibility (safe)."],
          ["Movement", "Sprint multiplier, super jump, no ragdoll (safe)."],
          ["Outfits", "Swap skins, save/load presets."]
        ],
        vehicle: [
          ["Spawner", "Spawn by model or favorites."],
          ["Tuning", "Engine, brakes, suspension, visuals."],
          ["God Mode", "Unbreakable & instant flip (risky)."]
        ],
        weapons: [
          ["Loadouts", "Save/restore weapon sets."],
          ["Modifiers", "Damage/recoil/spread tweaks (risky)."],
          ["FX", "Tracers & muzzle flash styles."]
        ],
        teleport: [
          ["Saved Spots", "Save, rename, and warp to custom points."],
          ["Waypoint", "Jump to map marker or POIs."],
          ["No-clip", "Adjustable speed & snap (safe)."]
        ],
        server: [
          ["Density", "Traffic/ped density (may be risky on some servers)."],
          ["Events", "Chaos/mission spawner (risky)."],
          ["Cleanup", "Despawn radius & sweeps."]
        ],
        time: [
          ["Clock", "Freeze/step time, sync to server (safe)."],
          ["Weather", "Cycle presets, fog, wind, rain (safe)."],
          ["Atmos", "Sky tint & exposure."]
        ],
        settings: [
          ["Input", "Rebind keys & controller nav."],
          ["Theme", "Accent gradient & compact mode."],
          ["Performance", "Toggle animations or reduce FX cost."]
        ]
      };

      /* Utility: selected element */
      const getSelected = () => document.querySelector('.item.selected');

      /* Accurate pill movement (offsetTop within flex column + gap) */
      function movePillTo(el){
        if (!el) return;
        // y is item's offsetTop within the UL.list
        const y = el.offsetTop;                         // robust & cheap
        const h = el.offsetHeight;
        pill.style.height = `${h}px`;
        pill.style.transform = `translate3d(0, ${y}px, 0)`;
      }

      /* Keep selected visible inside listWrap */
      function keepVisible(el){
        const wrapRect = listWrap.getBoundingClientRect();
        const itemRect = el.getBoundingClientRect();
        if (itemRect.top < wrapRect.top) {
          listWrap.scrollTop += itemRect.top - wrapRect.top - 8;
        } else if (itemRect.bottom > wrapRect.bottom) {
          listWrap.scrollTop += itemRect.bottom - wrapRect.bottom + 8;
        }
      }

      /* Set panel + header badge (tags only here, not on the tabs) */
      function setPanel(key, label, badgeType){
        panelTitle.textContent = label;

        riskBadge.classList.remove('safe','risky','hidden');
        if (badgeType === 'safe'){
          riskBadge.textContent = 'SAFE';
          riskBadge.classList.add('safe');
        } else if (badgeType === 'both'){
          riskBadge.textContent = 'RISKY';  // category contains risky options
          riskBadge.classList.add('risky');
        } else {
          riskBadge.textContent = '';
          riskBadge.classList.add('hidden');
        }

        const rows = (content[key] || [["Info","No details"]])
          .map(([h,p]) => `<div class="card"><h4>${h}</h4><p>${p}</p></div>`)
          .join("");
        panelBody.innerHTML = rows;
      }

      /* Selection logic (debounced to avoid jitter) */
      let switching = false;
      function selectItem(next){
        if (!next || switching) return;
        switching = true;

        const cur = getSelected();
        if (cur !== next) {
          if (cur) cur.classList.remove('selected');
          next.classList.add('selected');
        }

        const key   = next.dataset.key;
        const label = next.querySelector('.label').textContent;
        const badge = next.dataset.badge || 'none';

        // Move first (visual), then update panel
        movePillTo(next);
        keepVisible(next);
        setPanel(key, label, badge);

        // small timeout to prevent rapid double-triggering from fast inputs
        setTimeout(() => { switching = false; }, 60);
      }

      /* Click selection */
      items.forEach(li => li.addEventListener('click', () => selectItem(li)));

      /* Sync pill on scroll/resize; recompute with current selected */
      listWrap.addEventListener('scroll', () => movePillTo(getSelected()), { passive: true });
      window.addEventListener('resize', () => movePillTo(getSelected()));

      /* Public API for FiveM */
      window.MenuAPI = {
        Up: function(){
          const cur = getSelected();
          const idx = items.indexOf(cur);
          const next = items[(idx - 1 + items.length) % items.length];
          selectItem(next);
        },
        Down: function(){
          const cur = getSelected();
          const idx = items.indexOf(cur);
          const next = items[(idx + 1) % items.length];
          selectItem(next);
        },
        CurrentKey: function(){
          const sel = getSelected();
          return sel ? sel.dataset.key : null;
        },
        SetByKey: function(key){
          const match = items.find(li => li.dataset.key === key);
          if (match) selectItem(match);
        }
      };

      /* Init */
      requestAnimationFrame(() => {
        movePillTo(getSelected());
        const init = getSelected();
        setPanel(init.dataset.key, init.querySelector('.label').textContent, init.dataset.badge);
      });

      /* Optional: arrow keys for desktop preview/testing */
      window.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowUp')   { window.MenuAPI.Up();   e.preventDefault(); }
        if (e.key === 'ArrowDown') { window.MenuAPI.Down(); e.preventDefault(); }
      });
    })();
  </script>
</body>
</html>
