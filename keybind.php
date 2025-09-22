<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Keybind Picker</title>

  <style>
    :root{
      --accent: 255, 255, 255;

      --panel-min: 320px;
      --panel-max: 640px;
      --panel-pad-x: 22px;
      --panel-pad-y: 18px;

      --panel-bg: #101114;
      --panel-border: #21232a;
      --text: rgba(255,255,255,0.94);
      --muted: rgba(255,255,255,0.66);
      --track: #23262d;
      --bar-border: #1a1c22;

      --t-fast: 220ms;
      --t-med: 420ms;
      --t-reveal: 720ms;

      --logo-top: 8px;
      --logo-size: 44px;
      --bg-origin-y: calc(var(--logo-top) + var(--logo-size) / 2);
    }

    html, body, #root { background: transparent !important; }
    html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; }

    body {
      font-family: Inter, ui-sans-serif, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      color: var(--text);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      letter-spacing: .1px;
    }

    .root {
      position: fixed; inset: 0;
      display: grid; place-items: center;
      pointer-events: none;
    }

    .panel {
      position: relative;
      pointer-events: auto;
      min-width: clamp(var(--panel-min), 48vw, var(--panel-max));
      padding: calc(var(--panel-pad-y) + 8px) var(--panel-pad-x) 44px;
      border-radius: 16px;
      box-sizing: border-box;
      overflow: hidden; /* clip FX */
    }

    .bg {
      position: absolute; inset: 0;
      border-radius: 16px;
      background: var(--panel-bg);
      border: 1px solid var(--panel-border);
      transform-origin: 0 var(--bg-origin-y);
      transform: scale(0.08);
      transition: transform var(--t-reveal) cubic-bezier(.22,.61,.36,1);
      will-change: transform;
      z-index: 0;
    }
    .panel.revealed .bg { transform: scale(1); }

    /* === Animated glow orbs (same vibe as loader) === */
    .fx {
      position: absolute; inset: 0;
      z-index: 0; pointer-events: none;
      filter: saturate(120%); opacity: .75;
      mix-blend-mode: screen;
    }
    .orbTrack { position: absolute; left: 50%; top: 50%; width: 0; height: 0; transform-origin: 0 0; }
    .orbTrack.t1 { animation: orbit 24s linear infinite; }
    .orbTrack.t2 { animation: orbit 34s linear infinite reverse; }
    .orbTrack.t3 { animation: orbit 46s linear infinite; }
    @keyframes orbit {
      from { transform: translate(-50%, -50%) rotate(0deg); }
      to   { transform: translate(-50%, -50%) rotate(360deg); }
    }
    .orb {
      position: absolute; border-radius: 50%;
      transform: translateX(var(--r, 180px));
      filter: blur(32px);
      animation: spinBack var(--d, 24s) linear infinite;
    }
    .o1 { width: 340px; height: 340px; background: radial-gradient(circle at 35% 35%, rgba(138,180,255,.95), rgba(138,180,255,0) 62%); }
    .o2 { width: 280px; height: 280px; background: radial-gradient(circle at 42% 42%, rgba(200,160,255,.95), rgba(200,160,255,0) 64%); }
    .o3 { width: 400px; height: 400px; background: radial-gradient(circle at 40% 40%, rgba(128,255,211,.95), rgba(128,255,211,0) 60%); }
    @keyframes spinBack {
      from { transform: translateX(var(--r,180px)) rotate(0deg) }
      to   { transform: translateX(var(--r,180px)) rotate(-360deg) }
    }

    /* Header */
    .header { position: relative; height: 64px; z-index: 2; }

    /* Logo with subtle motion */
    .logoFloat {
      position: absolute;
      top: var(--logo-top);
      left: 14px;
      width: var(--logo-size); height: var(--logo-size);
      display: grid; place-items: center;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 0 1px rgba(255,255,255,0.06), 0 8px 24px rgba(120,180,255,0.12);
      background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0));
      transform: translateZ(0);
      animation: logoDrift 6s ease-in-out infinite;
    }
    @keyframes logoDrift { 0%{ transform:translateY(0);} 50%{ transform:translateY(2px);} 100%{ transform:translateY(0);} }
    .logoFloat .logo {
      width: 90%; height: 90%;
      object-fit: contain; -webkit-user-drag: none;
      filter: drop-shadow(0 2px 8px rgba(138,180,255,.18));
    }

    .meta {
      position: absolute; top: var(--logo-top); left: 16px; right: 16px;
      display: grid;
      grid-template-columns: calc(var(--logo-size) + 8px) 1fr;
      grid-template-areas:
        "spacer title"
        "spacer hint";
      column-gap: 10px; row-gap: 6px; align-items: center;
      opacity: 0; transform: translateY(-6px);
      transition: opacity var(--t-fast) ease, transform var(--t-fast) ease;
      z-index: 1; pointer-events: none;
    }
    .panel.reveal-done .meta { opacity: 1; transform: translateY(0); }

    /* Title gradient (static colors, not changing hue) */
    .meta .title  {
      grid-area: title;
      font-weight: 800; font-size: 15px; letter-spacing: .2px;
      background: linear-gradient(90deg, #8ab4ff, #b388ff, #80ffd3, #8ab4ff);
      background-size: 300% 300%;
      -webkit-background-clip: text; background-clip: text; color: transparent;
      animation: gradientShift 9s ease infinite;
    }
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .meta .hint { grid-area: hint; font-weight: 600; font-size: 12.5px; color: var(--muted); }

    /* Content */
    .content {
      position: relative; z-index: 1;
      margin-top: 10px;
      opacity: 0; transform: translateY(6px);
      transition: opacity var(--t-med) ease, transform var(--t-med) cubic-bezier(.22,.61,.36,1);
    }
    .panel.reveal-done .content { opacity: 1; transform: translateY(0); }

    .keypad { margin-top: 8px; display: grid; gap: 10px; }

    .keycap {
      display: grid; place-items: center;
      min-height: 104px;
      border-radius: 14px;
      border: 1px solid var(--bar-border);
      background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
      font-weight: 900;
      font-size: 42px;
      letter-spacing: .5px;
      text-transform: uppercase;
      user-select: none;
      will-change: transform, filter;
      transition: transform var(--t-fast) ease, filter var(--t-fast) ease, opacity var(--t-fast) ease;
    }
    .keycap.waiting { opacity: .85; }
    .keycap.captured { filter: drop-shadow(0 10px 24px rgba(138,180,255,.18)); }

    /* Instruction text: gradient text with animated OPACITY (breathing), not color */
    .instruction {
      font-weight: 800;
      text-align: center;
      font-size: 13.5px;
      letter-spacing: .2px;
      background: linear-gradient(90deg, #8ab4ff, #b388ff, #80ffd3);
      -webkit-background-clip: text; background-clip: text;
      color: transparent;
      opacity: .72;
      animation: pulseOpacity 2.2s ease-in-out infinite;
    }
    @keyframes pulseOpacity {
      0% { opacity: .55; }
      50% { opacity: 1; }
      100% { opacity: .55; }
    }

    .status {
      margin-top: 2px;
      font-size: 12.5px;
      font-weight: 700;
      letter-spacing: .2px;
      text-align: center;
      color: var(--muted);
    }

    .fadeable { transition: opacity var(--t-fast) ease; }
    .fade-hide { opacity: 0 !important; }

    .hidden{ opacity: 0; transform: translateY(4px); transition: opacity var(--t-fast) ease, transform var(--t-fast) ease; pointer-events: none; }
    .visible{ opacity: 1; transform: translateY(0); transition: opacity var(--t-fast) ease, transform var(--t-fast) ease; }

    @media (prefers-reduced-motion: reduce){
      .bg, .meta, .content, .title, .fadeable,
      .fx, .orbTrack, .orb, .logoFloat, .instruction { transition: none !important; animation: none !important; }
      .meta .title, .instruction { color: var(--text); background: none; -webkit-background-clip: initial; background-clip: initial; }
    }
  </style>
</head>

<body>
  <div id="root" class="root visible" role="dialog" aria-live="polite" aria-label="Keybind Picker">
    <div class="panel" id="panel">
      <div class="bg" id="bg"></div>

      <!-- FX Orbs -->
      <div class="fx" aria-hidden="true">
        <div class="orbTrack t1"><span class="orb o1" style="--r:180px;--d:24s;"></span></div>
        <div class="orbTrack t2"><span class="orb o2" style="--r:140px;--d:34s;"></span></div>
        <div class="orbTrack t3"><span class="orb o3" style="--r:220px;--d:46s;"></span></div>
      </div>

      <div class="header">
        <div class="logoFloat" id="logoFloat">
          <img class="logo" id="logo" src="img/Logo.png" alt="Logo" />
        </div>

        <div class="meta" id="meta">
          <div class="spacer" aria-hidden="true"></div>
          <div class="title fadeable" id="titleText">Clara.lua</div>
          <div class="hint  fadeable" id="hintText">Choose a key for your bind</div>
        </div>
      </div>

      <div class="content" id="content">
        <div class="keypad" id="keypad">
          <div class="keycap waiting fadeable" id="keycap" aria-live="assertive">—</div>
          <div class="instruction" id="confirmHint">Press ENTER to confirm…</div>
          <div class="status fadeable" id="statusText">Waiting for input… (Press any key)</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function(){
      const $ = (s)=>document.querySelector(s);

      const root   = $('#root');
      const panel  = $('#panel');
      const bg     = $('#bg');

      const title  = $('#titleText');
      const hint   = $('#hintText');
      const keycap = $('#keycap');
      const status = $('#statusText');
      const confirmHint = $('#confirmHint');

      const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      function fadeSwap(node, newText){
        if (!node) return;
        const text = String(newText ?? '');
        if (prefersReduced){ node.textContent = text; return; }
        if (node.textContent === text) return;
        node.classList.add('fade-hide');
        node.addEventListener('transitionend', () => {
          node.textContent = text;
          requestAnimationFrame(()=>node.classList.remove('fade-hide'));
        }, { once: true });
      }

      /* ===== Public API (called from Lua via MachoExecuteDuiScript) ===== */
      window.KeybindUI = {
        setLabel(txt){ fadeSwap(keycap, txt); keycap.classList.toggle('captured', txt && txt !== '—'); keycap.classList.toggle('waiting', !txt || txt === '—'); },
        setStatus(txt){ fadeSwap(status, txt); },
        setHint(txt){ fadeSwap(hint, txt); },
        // optional helpers:
        setSelectedVKHex(hex){ fadeSwap(keycap, hex); keycap.classList.add('captured'); keycap.classList.remove('waiting'); },
        reset(){ fadeSwap(keycap,'—'); fadeSwap(status,'Waiting for input… (Press any key)'); fadeSwap(hint,'Choose a key for your bind'); keycap.classList.remove('captured'); keycap.classList.add('waiting'); }
      };

      /* ===== Optional internal visuals (no key logic here) ===== */
      document.addEventListener('DOMContentLoaded', () => {
        document.documentElement.style.background = 'transparent';
        document.body.style.background = 'transparent';
        if (root) root.style.background = 'transparent';
        requestAnimationFrame(() => panel.classList.add('revealed'));
        bg.addEventListener('transitionend', (ev) => {
          if (ev.target !== bg || ev.propertyName !== 'transform') return;
          panel.classList.add('reveal-done');
        }, { once: true });
      });

      window.addEventListener('load', () => {
        try { window.focus(); } catch(_) {}
      });
    })();
  </script>
</body>
</html>
