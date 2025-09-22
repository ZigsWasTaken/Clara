<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loader</title>

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
      --fill-top: rgba(var(--accent), 1);
      --fill-bot: rgba(var(--accent), .85);

      --bar-height: 12px;
      --bar-radius: 999px;

      --t-fast: 220ms;
      --t-med: 420ms;
      --t-reveal: 720ms;
      --stripe-speed: 1200ms;

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
      transform-origin: 0 var(--bg-origin-y); /* scale out from top-left */
      transform: scale(0.08);
      transition: transform var(--t-reveal) cubic-bezier(.22,.61,.36,1);
      will-change: transform;
      z-index: 0;
    }
    .panel.revealed .bg { transform: scale(1); }

    /* === Animated glow orbs === */
    .fx {
      position: absolute;
      inset: 0;
      z-index: 0;
      pointer-events: none;
      filter: saturate(120%);
      opacity: .75;
      mix-blend-mode: screen;
    }
    /* Each track rotates; the orb is offset along X to create an orbit. */
    .orbTrack {
      position: absolute;
      left: 50%; top: 50%;
      width: 0; height: 0;
      transform-origin: 0 0;
    }
    .orbTrack.track1 { animation: orbit 26s linear infinite; }
    .orbTrack.track2 { animation: orbit 36s linear infinite reverse; }
    .orbTrack.track3 { animation: orbit 48s linear infinite; }

    /* subtle speed variance for organic feel */
    .panel.reveal-done .orbTrack.track1 { animation-duration: 24s; }
    .panel.reveal-done .orbTrack.track2 { animation-duration: 34s; }
    .panel.reveal-done .orbTrack.track3 { animation-duration: 46s; }

    @keyframes orbit {
      from { transform: translate(-50%, -50%) rotate(0deg); }
      to   { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .orb {
      position: absolute;
      width: 340px; height: 340px;
      border-radius: 50%;
      /* gradient core */
      background: radial-gradient(circle at 35% 35%, rgba(138,180,255,.95), rgba(138,180,255,0) 62%);
      /* place on the orbit radius */
      transform: translateX(var(--r, 180px));
      filter: blur(32px);
      /* counter-rotate so texture doesn’t spin awkwardly */
      animation: spinBack var(--d, 26s) linear infinite;
    }
    .orb.o2{
      width: 280px; height: 280px;
      background: radial-gradient(circle at 42% 42%, rgba(200,160,255,.95), rgba(200,160,255,0) 64%);
    }
    .orb.o3{
      width: 400px; height: 400px;
      background: radial-gradient(circle at 40% 40%, rgba(128,255,211,.95), rgba(128,255,211,0) 60%);
    }

    @keyframes spinBack {
      from { transform: translateX(var(--r, 180px)) rotate(0deg) scale(1); }
      to   { transform: translateX(var(--r, 180px)) rotate(-360deg) scale(1.03); }
    }

    /* Header */
    .header { position: relative; height: 64px; z-index: 2; }

    /* Logo with improved placement & subtle motion */
    .logoFloat {
      position: absolute;
      top: var(--logo-top);
      left: 14px;
      width: var(--logo-size); height: var(--logo-size);
      border-radius: 10px;
      overflow: hidden;
      display: grid; place-items: center;
      box-shadow:
        0 0 0 1px rgba(255,255,255,0.06),
        0 8px 24px rgba(120,180,255,0.12);
      background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0));
      transform: translateZ(0); /* promote to its own layer */
      will-change: transform, filter;
      animation: logoDrift 6s ease-in-out infinite;
    }
    /* Keeps the logo comfortably placed while animated (small drift only) */
    @keyframes logoDrift {
      0%   { transform: translate3d(0, 0, 0) rotate(0.0001deg); }
      50%  { transform: translate3d(0, 2px, 0) rotate(0.0001deg); }
      100% { transform: translate3d(0, 0, 0) rotate(0.0001deg); }
    }
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
      z-index: 1;
      pointer-events: none;
    }
    .meta .spacer { grid-area: spacer; width: 1px; height: 1px; } /* grid spacer, real space handled by column size */

    /* Title with modern animated gradient */
    .meta .title  {
      grid-area: title;
      font-weight: 800; font-size: 15px; letter-spacing: .2px;
      background: linear-gradient(90deg, #8ab4ff, #b388ff, #80ffd3, #8ab4ff);
      background-size: 300% 300%;
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: gradientShift 9s ease infinite;
    }
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .meta .hint   { grid-area: hint;  font-weight: 600; font-size: 12.5px; color: var(--muted); }

    .panel.reveal-done .meta { opacity: 1; transform: translateY(0); }

    .content {
      position: relative; z-index: 1;
      margin-top: 10px;
      opacity: 0; transform: translateY(6px);
      transition: opacity var(--t-med) ease, transform var(--t-med) cubic-bezier(.22,.61,.36,1);
    }
    .panel.reveal-done .content { opacity: 1; transform: translateY(0); }

    .bar {
      width: 100%; height: var(--bar-height);
      border-radius: var(--bar-radius);
      background: var(--track);
      overflow: hidden;
      border: 1px solid var(--bar-border);
      box-sizing: border-box;
    }
    .fill {
      width: 0%; height: 100%; border-radius: inherit;
      background: linear-gradient(180deg, var(--fill-top) 0%, var(--fill-bot) 100%);
      transition: width var(--t-med) cubic-bezier(.22,.61,.36,1);
      position: relative;
    }
    .fill::after{
      content:""; position:absolute; inset:0;
      background: repeating-linear-gradient(45deg, rgba(0,0,0,0.10) 0 12px, rgba(255,255,255,0.12) 12px 24px);
      opacity: .12; animation: stripes var(--stripe-speed) linear infinite; pointer-events: none;
    }
    @keyframes stripes{ from{ transform: translateX(0) } to{ transform: translateX(48px) } }

    .status { margin-top: 10px; font-size: 13.5px; font-weight: 700; letter-spacing: .2px; text-align: center; color: var(--text); }

    /* Text fade utility */
    .fadeable { transition: opacity var(--t-fast) ease; }
    .fade-hide { opacity: 0 !important; }

    .hidden{ opacity: 0; transform: translateY(4px); transition: opacity var(--t-fast) ease, transform var(--t-fast) ease; pointer-events: none; }
    .visible{ opacity: 1; transform: translateY(0); transition: opacity var(--t-fast) ease, transform var(--t-fast) ease; }

    @media (prefers-reduced-motion: reduce){
      .bg, .meta, .content, .title, .fadeable,
      .fx, .orbTrack, .orb, .logoFloat { transition: none !important; animation: none !important; }
      .meta .title { color: var(--text); background: none; -webkit-background-clip: initial; background-clip: initial; }
    }
  </style>
</head>

<body>
  <div id="root" class="root visible" role="dialog" aria-live="polite" aria-label="Loading">
    <div class="panel" id="panel">
      <div class="bg" id="bg"></div>

      <!-- Animated glow orbs (orbits around panel center) -->
      <div class="fx" aria-hidden="true">
        <div class="orbTrack track1">
          <span class="orb o1" style="--r: 180px; --d: 26s;"></span>
        </div>
        <div class="orbTrack track2">
          <span class="orb o2" style="--r: 140px; --d: 36s;"></span>
        </div>
        <div class="orbTrack track3">
          <span class="orb o3" style="--r: 220px; --d: 48s;"></span>
        </div>
      </div>

      <div class="header">
        <div class="logoFloat" id="logoFloat">
          <img class="logo" id="logo" src="img/Logo.png" alt="Logo" />
        </div>

        <div class="meta" id="meta">
          <div class="spacer" aria-hidden="true"></div>
          <div class="title fadeable" id="titleText">Clara.lua</div>
          <div class="hint fadeable"  id="hintText">Did you know? Clara.lua disabled flagged features by active anticheats.</div>
        </div>
      </div>

      <div class="content" id="content">
        <div class="bar">
          <div class="fill" id="fill" style="width:0%"></div>
        </div>
        <div class="status fadeable" id="statusText">Loading…</div>
      </div>
    </div>
  </div>

  <script>
    (function(){
      const clamp = (n,min,max)=>Math.max(min,Math.min(max,n));
      const $ = (s)=>document.querySelector(s);

      const root   = $('#root');
      const panel  = $('#panel');
      const bg     = $('#bg');
      const fill   = $('#fill');
      const status = $('#statusText');
      const logo   = $('#logo');
      const title  = $('#titleText');
      const hint   = $('#hintText');

      // Helper: fade out -> swap text -> fade in
      const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      function fadeSwap(node, newText){
        if (!node) return;
        const text = String(newText ?? '');
        if (prefersReduced){
          node.textContent = text;
          return;
        }
        if (node.textContent === text) return;
        node.classList.add('fadeable');
        node.classList.add('fade-hide');
        const onOut = () => {
          node.removeEventListener('transitionend', onOut);
          node.textContent = text;
          requestAnimationFrame(() => node.classList.remove('fade-hide'));
        };
        node.addEventListener('transitionend', onOut, { once: true });
      }

      window.Loader = {
        setProgress(pct, label){
          const v = clamp(Number(pct)||0, 0, 100);
          fill.style.width = v + '%';
          if (typeof label === 'string') fadeSwap(status, label);
        },
        setText(label){ fadeSwap(status, label); },
        setAccent(r=255,g=255,b=255){
          const R = clamp(r,0,255), G = clamp(g,0,255), B = clamp(b,0,255);
          document.documentElement.style.setProperty('--accent', `${R}, ${G}, ${B}`);
        },
        setLogo(path){ if (typeof path === 'string' && path.trim()) logo.src = path; },
        setTitle(text){ fadeSwap(title, text); },
        setHint(text){ fadeSwap(hint, text); },
        show(){ root.classList.remove('hidden'); root.classList.add('visible'); },
        hide(){ root.classList.remove('visible'); root.classList.add('hidden'); },
        complete(label){
          this.setProgress(100, label || 'Done');
          setTimeout(()=>this.hide(), 300);
        }
      };

      document.addEventListener('DOMContentLoaded', () => {
        document.documentElement.style.background = 'transparent';
        document.body.style.background = 'transparent';
        if (root) root.style.background = 'transparent';

        requestAnimationFrame(() => {
          panel.classList.add('revealed');
        });

        const onRevealEnd = (ev) => {
          if (ev.target !== bg || ev.propertyName !== 'transform') return;
          panel.classList.add('reveal-done');
        };
        bg.addEventListener('transitionend', onRevealEnd, { once: true });
      });

      const hints = [
        "Did you know? Clara.lua automatically disables risky features that may trigger anticheats.",
        "Tip: You can manage your subscription and settings from your dashboard: https://clara.wtf/Auth/",
        "Reminder: No cheat is ever 100% undetectable — server staff can still review and ban players.",
        "Clara.lua updates frequently to stay ahead of GTA V anticheat patches.",
        "Using smooth and natural settings for aimbot or ESP reduces the risk of being flagged.",
        "Always avoid obvious trolling or griefing — human reports are one of the biggest ban risks.",
        "Clara.lua includes protections that help block common screenshot and screen-grab detections.",
        "Performance hint: Lowering your ESP range can improve FPS and stability.",
        "Safety tip: Restart the game and loader after updates to ensure all protections are active.",
        "Remember: Anticheats watch for impossible stats (speed, godmode). Stay subtle to play longer."
      ];

      let i = 0;
      setInterval(() => {
        i = (i + 1) % hints.length;
        fadeSwap(hint, hints[i]);
      }, 6000);
    })();
  </script>
</body>
</html>
