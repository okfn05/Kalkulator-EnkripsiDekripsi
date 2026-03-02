<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CipherLab — Enkripsi & Dekripsi</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #181834;
    --surface: #12121a;
    --surface2: #1c1c28;
    --border: #2a2a3d;
    --accent: #00ff9d;
    --accent2: #7c3aed;
    --accent3: #ff6b35;
    --text: #e8e8f0;
    --muted: #666680;
    --danger: #ff4466;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Syne', sans-serif;
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* Grid background */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: 
      linear-gradient(rgba(0,255,157,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(0,255,157,0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: 0;
  }

  header {
    position: relative;
    z-index: 10;
    padding: 40px 60px 30px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    backdrop-filter: blur(10px);
    background: rgba(10,10,15,0.8);
  }

  .logo {
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -1px;
  }
  .logo span { color: var(--accent); }

  .subtitle {
    font-family: 'Space Mono', monospace;
    font-size: 11px;
    color: var(--muted);
    letter-spacing: 3px;
    text-transform: uppercase;
  }

  .main {
    position: relative;
    z-index: 1;
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 40px;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 30px;
  }

  /* Sidebar */
  .sidebar {
    position: sticky;
    top: 20px;
    height: fit-content;
  }

  .nav-label {
    font-family: 'Space Mono', monospace;
    font-size: 10px;
    color: var(--muted);
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 16px;
    padding-left: 4px;
  }

  .nav-btn {
    width: 100%;
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--muted);
    padding: 14px 18px;
    font-family: 'Syne', sans-serif;
    font-size: 14px;
    font-weight: 600;
    text-align: left;
    cursor: pointer;
    border-radius: 8px;
    margin-bottom: 6px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .nav-btn:hover { border-color: var(--accent); color: var(--text); background: var(--surface2); }
  .nav-btn.active { border-color: var(--accent); color: var(--accent); background: rgba(0,255,157,0.07); }
  .nav-btn .icon { font-size: 18px; }

  /* Content */
  .content { min-width: 0; }

  .panel { display: none; }
  .panel.active { display: block; }

  .panel-header {
    margin-bottom: 30px;
  }
  .panel-title {
    font-size: 32px;
    font-weight: 800;
    letter-spacing: -1px;
  }
  .panel-title span { color: var(--accent); }
  .panel-desc {
    font-family: 'Space Mono', monospace;
    font-size: 12px;
    color: var(--muted);
    margin-top: 8px;
    line-height: 1.7;
  }

  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
  }

  .card-title {
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .card-title::before {
    content: '';
    width: 3px;
    height: 14px;
    background: var(--accent);
    border-radius: 2px;
  }

  /* Mode toggle */
  .mode-toggle {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
  }
  .mode-btn {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--surface2);
    color: var(--muted);
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
  .mode-btn.active { border-color: var(--accent); color: var(--accent); background: rgba(0,255,157,0.07); }
  .mode-btn.decrypt.active { border-color: var(--accent3); color: var(--accent3); background: rgba(255,107,53,0.07); }

  label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
  }

  input[type="text"], input[type="number"], textarea, select {
    width: 100%;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 16px;
    color: var(--text);
    font-family: 'Space Mono', monospace;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
    margin-bottom: 16px;
  }
  input:focus, textarea:focus, select:focus { border-color: var(--accent); }
  textarea { resize: vertical; min-height: 100px; }
  select option { background: var(--surface2); }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .btn {
    padding: 14px 28px;
    border-radius: 8px;
    border: none;
    font-family: 'Syne', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.2s;
    text-transform: uppercase;
  }
  .btn-primary {
    background: var(--accent);
    color: #000;
  }
  .btn-primary:hover { background: #00cc7a; transform: translateY(-1px); box-shadow: 0 4px 20px rgba(0,255,157,0.3); }
  .btn-secondary {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--muted);
  }
  .btn-secondary:hover { border-color: var(--muted); color: var(--text); }
  .btn-danger {
    background: var(--danger);
    color: #fff;
  }

  .btn-row { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 4px; }

  /* Output */
  .output-box {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 16px;
    font-family: 'Space Mono', monospace;
    font-size: 13px;
    color: var(--accent);
    word-break: break-all;
    min-height: 60px;
    white-space: pre-wrap;
    position: relative;
  }
  .output-box.error { color: var(--danger); }
  .output-box.orange { color: var(--accent3); }

  .copy-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--muted);
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    font-family: 'Space Mono', monospace;
    transition: all 0.2s;
  }
  .copy-btn:hover { color: var(--accent); border-color: var(--accent); }

  /* File Input */
  .file-drop {
    border: 2px dashed var(--border);
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 16px;
    position: relative;
  }
  .file-drop:hover { border-color: var(--accent); background: rgba(0,255,157,0.03); }
  .file-drop input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
  .file-drop .icon { font-size: 32px; margin-bottom: 8px; }
  .file-drop p { font-size: 13px; color: var(--muted); font-family: 'Space Mono', monospace; }
  .file-drop .file-name { color: var(--accent); margin-top: 6px; font-size: 12px; }

  /* Progress */
  .progress-bar {
    width: 100%;
    height: 4px;
    background: var(--border);
    border-radius: 2px;
    overflow: hidden;
    margin: 10px 0;
    display: none;
  }
  .progress-bar.show { display: block; }
  .progress-fill {
    height: 100%;
    background: var(--accent);
    width: 0%;
    transition: width 0.3s;
    border-radius: 2px;
  }

  /* Matrix input for Hill */
  .matrix-grid {
    display: grid;
    gap: 8px;
    margin-bottom: 16px;
  }
  .matrix-grid input {
    width: 100%;
    text-align: center;
    margin-bottom: 0;
    padding: 10px 8px;
  }
  .matrix-2x2 { grid-template-columns: 1fr 1fr; }
  .matrix-3x3 { grid-template-columns: 1fr 1fr 1fr; }

  /* Tab for input type */
  .input-tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 16px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 12px;
  }
  .input-tab {
    padding: 7px 16px;
    background: transparent;
    border: 1px solid transparent;
    border-radius: 6px;
    color: var(--muted);
    font-size: 12px;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.2s;
  }
  .input-tab:hover { color: var(--text); }
  .input-tab.active { border-color: var(--accent2); color: var(--accent2); background: rgba(124,58,237,0.1); }

  .input-section { display: none; }
  .input-section.active { display: block; }

  /* Status badge */
  .badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-family: 'Space Mono', monospace;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
  .badge-green { background: rgba(0,255,157,0.1); color: var(--accent); border: 1px solid rgba(0,255,157,0.2); }
  .badge-orange { background: rgba(255,107,53,0.1); color: var(--accent3); border: 1px solid rgba(255,107,53,0.2); }

  /* Enigma rotors display */
  .rotor-display {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
  }
  .rotor-box {
    flex: 1;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px;
    text-align: center;
  }
  .rotor-box label { font-size: 10px; }
  .rotor-val {
    font-family: 'Space Mono', monospace;
    font-size: 20px;
    font-weight: 700;
    color: var(--accent);
    margin-top: 4px;
  }

  /* Download area */
  .download-area {
    background: rgba(0,255,157,0.05);
    border: 1px solid rgba(0,255,157,0.2);
    border-radius: 8px;
    padding: 16px;
    display: none;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  .download-area.show { display: flex; }
  .download-area p { font-size: 13px; color: var(--accent); font-family: 'Space Mono', monospace; }

  /* Scrollbar */
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-track { background: var(--surface); }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
  ::-webkit-scrollbar-thumb:hover { background: var(--muted); }

  @media (max-width: 900px) {
    .main { grid-template-columns: 1fr; }
    .sidebar { position: static; }
    header { padding: 20px; }
    .main { padding: 20px; }
  }
</style>
</head>
<body>

<header>
  <div>
    <div class="logo">Cipher<span>Lab</span></div>
    <div class="subtitle">KALKULATOR UNTUK KRIPTOGRAFI KLASIK</div>
  </div>
  <div class="badge badge-green">DIBUAT OLEH OKFAN SUBEKTI</div>
</header>

<div class="main">
  <!-- Sidebar Nav -->
  <div class="sidebar">
    <div class="nav-label">Pilih Cipher</div>
    <button class="nav-btn active" onclick="showPanel('vigenere')">
      <span class="icon">🔑</span> Vigenere
    </button>
    <button class="nav-btn" onclick="showPanel('affine')">
      <span class="icon">🔢</span> Affine
    </button>
    <button class="nav-btn" onclick="showPanel('playfair')">
      <span class="icon">🔲</span> Playfair
    </button>
    <button class="nav-btn" onclick="showPanel('hill')">
      <span class="icon">📐</span> Hill
    </button>
    <button class="nav-btn" onclick="showPanel('enigma')">
      <span class="icon">⚙️</span> Enigma
    </button>
  </div>

  <!-- Content -->
  <div class="content">

    <!-- ========== VIGENERE ========== -->
    <div class="panel active" id="panel-vigenere">
      <div class="panel-header">
        <div class="panel-title">Vigenere <span>Cipher</span></div>
       </div>
      <div class="card">
        <div class="card-title">Mode Operasi</div>
        <div class="mode-toggle">
          <button class="mode-btn active" id="vig-enc-btn" onclick="setMode('vig','encrypt')">⬆ Enkripsi</button>
          <button class="mode-btn decrypt" id="vig-dec-btn" onclick="setMode('vig','decrypt')">⬇ Dekripsi</button>
        </div>
        <div class="input-tabs">
          <button class="input-tab active" onclick="setInputTab('vig','text')">Teks</button>
          <button class="input-tab" onclick="setInputTab('vig','file')">File/Gambar/Audio/Video</button>
        </div>
        <div class="input-section active" id="vig-text-section">
          <label>Input Teks</label>
          <textarea id="vig-input" placeholder="Masukkan teks di sini..."></textarea>
        </div>
        <div class="input-section" id="vig-file-section">
          <div class="file-drop" onclick="document.getElementById('vig-file').click()">
            <div class="icon">📁</div>
            <p>Klik atau seret file ke sini</p>
            <p>Mendukung: teks, gambar, audio, video, database</p>
            <p class="file-name" id="vig-file-name"></p>
            <input type="file" id="vig-file" onchange="handleFileSelect('vig')">
          </div>
        </div>
        <label>Kunci (Huruf A-Z)</label>
        <input type="text" id="vig-key" placeholder="Contoh: RAHASIA" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z]/g,'')">
        <div class="btn-row">
          <button class="btn btn-primary" onclick="processVigenere()">▶ Proses</button>
          <button class="btn btn-secondary" onclick="resetPanel('vig')">↺ Reset</button>
        </div>
      </div>
      <div class="card">
        <div class="card-title">Hasil</div>
        <div class="progress-bar" id="vig-progress"><div class="progress-fill" id="vig-progress-fill"></div></div>
        <div class="output-box" id="vig-output">—</div>
        <div class="download-area" id="vig-download">
          <p id="vig-download-name">output.bin</p>
          <button class="btn btn-primary" onclick="downloadFile('vig')">⬇ Unduh File</button>
        </div>
      </div>
    </div>

    <!-- ========== AFFINE ========== -->
    <div class="panel" id="panel-affine">
      <div class="panel-header">
        <div class="panel-title">Affine <span>Cipher</span></div>
      </div>
      <div class="card">
        <div class="card-title">Mode Operasi</div>
        <div class="mode-toggle">
          <button class="mode-btn active" id="aff-enc-btn" onclick="setMode('aff','encrypt')">⬆ Enkripsi</button>
          <button class="mode-btn decrypt" id="aff-dec-btn" onclick="setMode('aff','decrypt')">⬇ Dekripsi</button>
        </div>
        <div class="input-tabs">
          <button class="input-tab active" onclick="setInputTab('aff','text')">Teks</button>
          <button class="input-tab" onclick="setInputTab('aff','file')">File/Gambar/Audio/Video</button>
        </div>
        <div class="input-section active" id="aff-text-section">
          <label>Input Teks</label>
          <textarea id="aff-input" placeholder="Masukkan teks di sini..."></textarea>
        </div>
        <div class="input-section" id="aff-file-section">
          <div class="file-drop" onclick="document.getElementById('aff-file').click()">
            <div class="icon">📁</div>
            <p>Klik atau seret file ke sini</p>
            <p>Mendukung: teks, gambar, audio, video, database</p>
            <p class="file-name" id="aff-file-name"></p>
            <input type="file" id="aff-file" onchange="handleFileSelect('aff')">
          </div>
        </div>
        <div class="form-row">
          <div>
            <label>Nilai a (ganjil, coprime 26)</label>
            <select id="aff-a">
              <option value="1">1</option><option value="3">3</option><option value="5">5</option>
              <option value="7">7</option><option value="9">9</option><option value="11">11</option>
              <option value="15">15</option><option value="17">17</option><option value="19">19</option>
              <option value="21">21</option><option value="23">23</option><option value="25">25</option>
            </select>
          </div>
          <div>
            <label>Nilai b (0-25)</label>
            <input type="number" id="aff-b" value="0" min="0" max="25">
          </div>
        </div>
        <div class="btn-row">
          <button class="btn btn-primary" onclick="processAffine()">▶ Proses</button>
          <button class="btn btn-secondary" onclick="resetPanel('aff')">↺ Reset</button>
        </div>
      </div>
      <div class="card">
        <div class="card-title">Hasil</div>
        <div class="progress-bar" id="aff-progress"><div class="progress-fill" id="aff-progress-fill"></div></div>
        <div class="output-box" id="aff-output">—</div>
        <div class="download-area" id="aff-download">
          <p id="aff-download-name">output.bin</p>
          <button class="btn btn-primary" onclick="downloadFile('aff')">⬇ Unduh File</button>
        </div>
      </div>
    </div>

    <!-- ========== PLAYFAIR ========== -->
    <div class="panel" id="panel-playfair">
      <div class="panel-header">
        <div class="panel-title">Playfair <span>Cipher</span></div>
      </div>
      <div class="card">
        <div class="card-title">Mode Operasi</div>
        <div class="mode-toggle">
          <button class="mode-btn active" id="pf-enc-btn" onclick="setMode('pf','encrypt')">⬆ Enkripsi</button>
          <button class="mode-btn decrypt" id="pf-dec-btn" onclick="setMode('pf','decrypt')">⬇ Dekripsi</button>
        </div>
        <div class="input-tabs">
          <button class="input-tab active" onclick="setInputTab('pf','text')">Teks</button>
          <button class="input-tab" onclick="setInputTab('pf','file')">File/Gambar/Audio/Video</button>
        </div>
        <div class="input-section active" id="pf-text-section">
          <label>Input Teks</label>
          <textarea id="pf-input" placeholder="Masukkan teks di sini..."></textarea>
        </div>
        <div class="input-section" id="pf-file-section">
          <div class="file-drop" onclick="document.getElementById('pf-file').click()">
            <div class="icon">📁</div>
            <p>Klik atau seret file ke sini</p>
            <p>Mendukung: teks, gambar, audio, video, database</p>
            <p class="file-name" id="pf-file-name"></p>
            <input type="file" id="pf-file" onchange="handleFileSelect('pf')">
          </div>
        </div>
        <label>Kunci</label>
        <input type="text" id="pf-key" placeholder="Contoh: BYTES" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z]/g,''); buildPlayfairGrid()">
        <label>Grid Playfair (5×5)</label>
        <div id="pf-grid" style="font-family:'Space Mono',monospace;font-size:13px;color:var(--accent);background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:16px;margin-bottom:16px;letter-spacing:8px;line-height:2;">
          A B C D E<br>F G H I K<br>L M N O P<br>Q R S T U<br>V W X Y Z
        </div>
        <div class="btn-row">
          <button class="btn btn-primary" onclick="processPlayfair()">▶ Proses</button>
          <button class="btn btn-secondary" onclick="resetPanel('pf')">↺ Reset</button>
        </div>
      </div>
      <div class="card">
        <div class="card-title">Hasil</div>
        <div class="progress-bar" id="pf-progress"><div class="progress-fill" id="pf-progress-fill"></div></div>
        <div class="output-box" id="pf-output">—</div>
        <div class="download-area" id="pf-download">
          <p id="pf-download-name">output.bin</p>
          <button class="btn btn-primary" onclick="downloadFile('pf')">⬇ Unduh File</button>
        </div>
      </div>
    </div>

    <!-- ========== HILL ========== -->
    <div class="panel" id="panel-hill">
      <div class="panel-header">
        <div class="panel-title">Hill <span>Cipher</span></div>
      </div>
      <div class="card">
        <div class="card-title">Mode Operasi</div>
        <div class="mode-toggle">
          <button class="mode-btn active" id="hill-enc-btn" onclick="setMode('hill','encrypt')">⬆ Enkripsi</button>
          <button class="mode-btn decrypt" id="hill-dec-btn" onclick="setMode('hill','decrypt')">⬇ Dekripsi</button>
        </div>
        <div class="input-tabs">
          <button class="input-tab active" onclick="setInputTab('hill','text')">Teks</button>
          <button class="input-tab" onclick="setInputTab('hill','file')">File/Gambar/Audio/Video</button>
        </div>
        <div class="input-section active" id="hill-text-section">
          <label>Input Teks</label>
          <textarea id="hill-input" placeholder="Masukkan teks di sini..."></textarea>
        </div>
        <div class="input-section" id="hill-file-section">
          <div class="file-drop" onclick="document.getElementById('hill-file').click()">
            <div class="icon">📁</div>
            <p>Klik atau seret file ke sini</p>
            <p>Mendukung: teks, gambar, audio, video, database</p>
            <p class="file-name" id="hill-file-name"></p>
            <input type="file" id="hill-file" onchange="handleFileSelect('hill')">
          </div>
        </div>
        <label>Ukuran Matriks</label>
        <select id="hill-size" onchange="buildHillMatrix()" style="margin-bottom:16px">
          <option value="2">2×2</option>
          <option value="3">3×3</option>
        </select>
        <label>Matriks Kunci</label>
        <div id="hill-matrix" class="matrix-grid matrix-2x2">
          <input type="number" class="hill-cell" value="6" min="0" max="25">
          <input type="number" class="hill-cell" value="24" min="0" max="25">
          <input type="number" class="hill-cell" value="1" min="0" max="25">
          <input type="number" class="hill-cell" value="13" min="0" max="25">
        </div>
        <div class="btn-row">
          <button class="btn btn-primary" onclick="processHill()">▶ Proses</button>
          <button class="btn btn-secondary" onclick="resetPanel('hill')">↺ Reset</button>
        </div>
      </div>
      <div class="card">
        <div class="card-title">Hasil</div>
        <div class="progress-bar" id="hill-progress"><div class="progress-fill" id="hill-progress-fill"></div></div>
        <div class="output-box" id="hill-output">—</div>
        <div class="download-area" id="hill-download">
          <p id="hill-download-name">output.bin</p>
          <button class="btn btn-primary" onclick="downloadFile('hill')">⬇ Unduh File</button>
        </div>
      </div>
    </div>

    <!-- ========== ENIGMA ========== -->
    <div class="panel" id="panel-enigma">
      <div class="panel-header">
        <div class="panel-title">Enigma <span>Cipher</span></div>
      </div>
      <div class="card">
        <div class="card-title">Konfigurasi Rotor</div>
        <div class="rotor-display">
          <div class="rotor-box">
            <label>Rotor I</label>
            <select id="eng-r1" style="margin-bottom:0">
              <option value="0">I (EKMFLGDQVZNTOWYHXUSPAIBRCJ)</option>
              <option value="1">II (AJDKSIRUXBLHWTMCQGZNPYFVOE)</option>
              <option value="2">III (BDFHJLCPRTXVZNYEIWGAKMUSQO)</option>
              <option value="3">IV (ESOVPZJAYQUIRHXLNFTGKDCMWB)</option>
              <option value="4">V (VZBRGITYUPSDNHLXAWMJQOFECK)</option>
            </select>
          </div>
          <div class="rotor-box">
            <label>Rotor II</label>
            <select id="eng-r2" style="margin-bottom:0">
              <option value="1">II (AJDKSIRUXBLHWTMCQGZNPYFVOE)</option>
              <option value="0">I (EKMFLGDQVZNTOWYHXUSPAIBRCJ)</option>
              <option value="2">III (BDFHJLCPRTXVZNYEIWGAKMUSQO)</option>
              <option value="3">IV (ESOVPZJAYQUIRHXLNFTGKDCMWB)</option>
              <option value="4">V (VZBRGITYUPSDNHLXAWMJQOFECK)</option>
            </select>
          </div>
          <div class="rotor-box">
            <label>Rotor III</label>
            <select id="eng-r3" style="margin-bottom:0">
              <option value="2">III (BDFHJLCPRTXVZNYEIWGAKMUSQO)</option>
              <option value="0">I (EKMFLGDQVZNTOWYHXUSPAIBRCJ)</option>
              <option value="1">II (AJDKSIRUXBLHWTMCQGZNPYFVOE)</option>
              <option value="3">IV (ESOVPZJAYQUIRHXLNFTGKDCMWB)</option>
              <option value="4">V (VZBRGITYUPSDNHLXAWMJQOFECK)</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div>
            <label>Posisi Awal (AAA - ZZZ)</label>
            <input type="text" id="eng-pos" value="AAA" maxlength="3" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z]/g,'')">
          </div>
          <div>
            <label>Ring Setting (AAA - ZZZ)</label>
            <input type="text" id="eng-ring" value="AAA" maxlength="3" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z]/g,'')">
          </div>
        </div>
        <label>Plugboard (pasangan huruf, maks 10, contoh: AB CD EF)</label>
        <input type="text" id="eng-plug" placeholder="Contoh: AZ BX CY" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z ]/g,'')">
      </div>
      <div class="card">
        <div class="card-title">Input & Proses</div>
        <div class="input-tabs">
          <button class="input-tab active" onclick="setInputTab('eng','text')">Teks</button>
          <button class="input-tab" onclick="setInputTab('eng','file')">File/Gambar/Audio/Video</button>
        </div>
        <div class="input-section active" id="eng-text-section">
          <label>Input Teks</label>
          <textarea id="eng-input" placeholder="Masukkan teks di sini..."></textarea>
        </div>
        <div class="input-section" id="eng-file-section">
          <div class="file-drop" onclick="document.getElementById('eng-file').click()">
            <div class="icon">📁</div>
            <p>Klik atau seret file ke sini</p>
            <p>Mendukung: teks, gambar, audio, video, database</p>
            <p class="file-name" id="eng-file-name"></p>
            <input type="file" id="eng-file" onchange="handleFileSelect('eng')">
          </div>
        </div>
        <div class="btn-row">
          <button class="btn btn-primary" onclick="processEnigma()">⚙ Proses (Enkripsi/Dekripsi)</button>
          <button class="btn btn-secondary" onclick="resetPanel('eng')">↺ Reset</button>
        </div>
      </div>
      <div class="card">
        <div class="card-title">Hasil</div>
        <div class="progress-bar" id="eng-progress"><div class="progress-fill" id="eng-progress-fill"></div></div>
        <div class="output-box" id="eng-output">—</div>
        <div class="download-area" id="eng-download">
          <p id="eng-download-name">output.bin</p>
          <button class="btn btn-primary" onclick="downloadFile('eng')">⬇ Unduh File</button>
        </div>
      </div>
    </div>

  </div><!-- /content -->
</div><!-- /main -->

<script>
// ==================== STATE ====================
const state = {
  vig: { mode: 'encrypt', inputType: 'text', fileData: null, fileName: '' },
  aff: { mode: 'encrypt', inputType: 'text', fileData: null, fileName: '' },
  pf:  { mode: 'encrypt', inputType: 'text', fileData: null, fileName: '' },
  hill:{ mode: 'encrypt', inputType: 'text', fileData: null, fileName: '' },
  eng: { mode: 'encrypt', inputType: 'text', fileData: null, fileName: '' },
};
const downloadData = {};

// ==================== NAV ====================
function showPanel(name) {
  document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('panel-' + name).classList.add('active');
  event.currentTarget.classList.add('active');
}

// ==================== MODE ====================
function setMode(prefix, mode) {
  state[prefix].mode = mode;
  document.getElementById(prefix + '-enc-btn').classList.toggle('active', mode === 'encrypt');
  document.getElementById(prefix + '-dec-btn').classList.toggle('active', mode === 'decrypt');
}

// ==================== INPUT TAB ====================
function setInputTab(prefix, type) {
  state[prefix].inputType = type;
  const tabs = document.querySelectorAll(`#panel-${getPanelName(prefix)} .input-tab`);
  const sections = document.querySelectorAll(`#panel-${getPanelName(prefix)} .input-section`);
  tabs.forEach((t,i) => t.classList.toggle('active', (i===0 && type==='text') || (i===1 && type==='file')));
  sections.forEach((s,i) => s.classList.toggle('active', (i===0 && type==='text') || (i===1 && type==='file')));
}

function getPanelName(prefix) {
  const map = {vig:'vigenere',aff:'affine',pf:'playfair',hill:'hill',eng:'enigma'};
  return map[prefix];
}

// ==================== FILE HANDLING ====================
function handleFileSelect(prefix) {
  const file = document.getElementById(prefix + '-file').files[0];
  if (!file) return;
  state[prefix].fileName = file.name;
  document.getElementById(prefix + '-file-name').textContent = '📎 ' + file.name;
  const reader = new FileReader();
  reader.onload = e => { state[prefix].fileData = new Uint8Array(e.target.result); };
  reader.readAsArrayBuffer(file);
}

// ==================== RESET ====================
function resetPanel(prefix) {
  state[prefix].fileData = null;
  state[prefix].fileName = '';
  const fnEl = document.getElementById(prefix + '-file-name');
  if (fnEl) fnEl.textContent = '';
  const inEl = document.getElementById(prefix === 'eng' ? 'eng-input' : prefix + '-input');
  if (inEl) inEl.value = '';
  const outEl = document.getElementById(prefix + '-output');
  if (outEl) { outEl.textContent = '—'; outEl.className = 'output-box'; }
  const dlEl = document.getElementById(prefix + '-download');
  if (dlEl) dlEl.classList.remove('show');
}

// ==================== UTILS ====================
function mod(n, m) { return ((n % m) + m) % m; }
function gcd(a,b) { return b===0?a:gcd(b,a%b); }
function modInverse(a, m) {
  a = mod(a, m);
  for (let x = 1; x < m; x++) if (mod(a*x, m) === 1) return x;
  return -1;
}

function showProgress(prefix, pct) {
  const pb = document.getElementById(prefix+'-progress');
  const fill = document.getElementById(prefix+'-progress-fill');
  pb.classList.add('show');
  fill.style.width = pct + '%';
  if (pct >= 100) setTimeout(() => pb.classList.remove('show'), 600);
}

function setOutput(prefix, text, isError=false, isOrange=false) {
  const el = document.getElementById(prefix + '-output');
  el.textContent = text;
  el.className = 'output-box' + (isError?' error':'') + (isOrange?' orange':'');
  // copy button
  const existing = el.querySelector('.copy-btn');
  if (existing) existing.remove();
  if (!isError && text !== '—') {
    const btn = document.createElement('button');
    btn.className = 'copy-btn';
    btn.textContent = 'COPY';
    btn.onclick = () => { navigator.clipboard.writeText(text); btn.textContent='COPIED!'; setTimeout(()=>btn.textContent='COPY',1500); };
    el.appendChild(btn);
  }
}

function uint8ToBase64(arr) {
  let binary = '';
  for (let i = 0; i < arr.length; i++) binary += String.fromCharCode(arr[i]);
  return btoa(binary);
}
function base64ToUint8(b64) {
  const binary = atob(b64);
  const arr = new Uint8Array(binary.length);
  for (let i = 0; i < binary.length; i++) arr[i] = binary.charCodeAt(i);
  return arr;
}

// ==================== VIGENERE ====================
function vigenereChar(c, k, encrypt) {
  const ci = c.charCodeAt(0) - 65;
  const ki = k.charCodeAt(0) - 65;
  return String.fromCharCode(mod(encrypt ? ci+ki : ci-ki, 26) + 65);
}

function vigenereCrypt(text, key, encrypt) {
  if (!key) return {error: 'Kunci tidak boleh kosong'};
  key = key.toUpperCase().replace(/[^A-Z]/g, '');
  if (!key) return {error: 'Kunci harus berisi huruf A-Z'};
  let result = '', ki = 0;
  for (let c of text.toUpperCase()) {
    if (/[A-Z]/.test(c)) {
      result += vigenereChar(c, key[ki % key.length], encrypt);
      ki++;
    } else {
      result += c;
    }
  }
  return {result};
}

function vigenereCryptBytes(bytes, key, encrypt) {
  const keyUpper = key.toUpperCase().replace(/[^A-Z]/g,'');
  const result = new Uint8Array(bytes.length);
  for (let i = 0; i < bytes.length; i++) {
    const ki = keyUpper.charCodeAt(i % keyUpper.length) - 65;
    result[i] = mod(bytes[i] + (encrypt ? ki : -ki), 256);
  }
  return result;
}

function processVigenere() {
  const key = document.getElementById('vig-key').value;
  if (!key) return setOutput('vig','ERROR: Kunci tidak boleh kosong',true);
  const enc = state.vig.mode === 'encrypt';
  showProgress('vig', 30);
  if (state.vig.inputType === 'text') {
    const text = document.getElementById('vig-input').value;
    if (!text) return setOutput('vig','ERROR: Input teks kosong',true);
    const {result, error} = vigenereCrypt(text, key, enc);
    showProgress('vig',100);
    if (error) setOutput('vig','ERROR: '+error,true);
    else { setOutput('vig', result, false, !enc); document.getElementById('vig-download').classList.remove('show'); }
  } else {
    if (!state.vig.fileData) return setOutput('vig','ERROR: Pilih file terlebih dahulu',true);
    const result = vigenereCryptBytes(state.vig.fileData, key, enc);
    showProgress('vig',100);
    const ext = state.vig.fileName.split('.').pop();
    const outName = (enc ? 'encrypted_' : 'decrypted_') + state.vig.fileName;
    downloadData.vig = {data: result, name: outName};
    document.getElementById('vig-download-name').textContent = outName;
    document.getElementById('vig-download').classList.add('show');
    const base64 = uint8ToBase64(result);

setOutput(
  'vig',
  `=== TEKS ENKRIPSI ===\n\n${base64}\n\n` +
  `=== INFO FILE ===\n` +
  `Nama: ${state.vig.fileName}\n` +
  `Ukuran: ${result.length} bytes`,
  false,
  !enc
);
  }
}

// ==================== AFFINE ====================
function affineCrypt(text, a, b, encrypt) {
  if (gcd(a, 26) !== 1) return {error: `a=${a} tidak coprime dengan 26`};
  const aInv = modInverse(a, 26);
  let result = '';
  for (let c of text.toUpperCase()) {
    if (/[A-Z]/.test(c)) {
      const x = c.charCodeAt(0) - 65;
      result += String.fromCharCode(mod(encrypt ? a*x+b : aInv*(x-b), 26) + 65);
    } else result += c;
  }
  return {result};
}

function affineCryptBytes(bytes, a, b, encrypt) {
  const aInv = modInverse(a, 256);
  const result = new Uint8Array(bytes.length);
  for (let i = 0; i < bytes.length; i++) {
    result[i] = mod(encrypt ? a*bytes[i]+b : aInv*(bytes[i]-b), 256);
  }
  return result;
}

function processAffine() {
  const a = parseInt(document.getElementById('aff-a').value);
  const b = parseInt(document.getElementById('aff-b').value);
  const enc = state.aff.mode === 'encrypt';
  showProgress('aff',30);
  if (state.aff.inputType === 'text') {
    const text = document.getElementById('aff-input').value;
    if (!text) return setOutput('aff','ERROR: Input teks kosong',true);
    const {result,error} = affineCrypt(text, a, b, enc);
    showProgress('aff',100);
    if (error) setOutput('aff','ERROR: '+error,true);
    else { setOutput('aff', result, false, !enc); document.getElementById('aff-download').classList.remove('show'); }
  } else {
    if (!state.aff.fileData) return setOutput('aff','ERROR: Pilih file terlebih dahulu',true);
    const result = affineCryptBytes(state.aff.fileData, a, b, enc);
    showProgress('aff',100);
    const outName = (enc ? 'encrypted_' : 'decrypted_') + state.aff.fileName;
    downloadData.aff = {data: result, name: outName};
    document.getElementById('aff-download-name').textContent = outName;
    document.getElementById('aff-download').classList.add('show');
    setOutput('aff', `✓ File diproses: ${state.aff.fileName}\nUkuran: ${result.length} bytes\nKlik tombol "Unduh File" di bawah.`, false, !enc);
  }
}

// ==================== PLAYFAIR ====================
let pfMatrix = [];

function buildPlayfairGrid() {
  const key = (document.getElementById('pf-key').value || '').toUpperCase().replace(/J/g,'I').replace(/[^A-Z]/g,'');
  const seen = new Set();
  const grid = [];
  for (let c of key) if (!seen.has(c)) { seen.add(c); grid.push(c); }
  for (let i = 0; i < 26; i++) {
    const c = String.fromCharCode(65+i);
    if (c !== 'J' && !seen.has(c)) { seen.add(c); grid.push(c); }
  }
  pfMatrix = [];
  for (let r = 0; r < 5; r++) pfMatrix.push(grid.slice(r*5, r*5+5));
  const gridEl = document.getElementById('pf-grid');
  gridEl.innerHTML = pfMatrix.map(row => row.join(' ')).join('<br>');
}

function pfFind(c) {
  c = c === 'J' ? 'I' : c;
  for (let r = 0; r < 5; r++) for (let col = 0; col < 5; col++) if (pfMatrix[r][col] === c) return [r,col];
  return [-1,-1];
}

function playfairCrypt(text, encrypt) {
  if (!pfMatrix.length) buildPlayfairGrid();
  let clean = text.toUpperCase().replace(/J/g,'I').replace(/[^A-Z]/g,'');
  // Prepare digraphs
  let pairs = [];
  let i = 0;
  while (i < clean.length) {
    let a = clean[i], b = i+1 < clean.length ? clean[i+1] : 'X';
    if (a === b) { b = 'X'; i++; } else i += 2;
    pairs.push([a,b]);
  }
  let result = '';
  for (let [a,b] of pairs) {
    let [ra,ca] = pfFind(a), [rb,cb] = pfFind(b);
    if (ra === rb) {
      result += pfMatrix[ra][mod(ca+(encrypt?1:-1),5)] + pfMatrix[rb][mod(cb+(encrypt?1:-1),5)];
    } else if (ca === cb) {
      result += pfMatrix[mod(ra+(encrypt?1:-1),5)][ca] + pfMatrix[mod(rb+(encrypt?1:-1),5)][cb];
    } else {
      result += pfMatrix[ra][cb] + pfMatrix[rb][ca];
    }
  }
  return result;
}

function playfairCryptBytes(bytes, key, encrypt) {
  const keyBytes = new TextEncoder().encode(key);
  const result = new Uint8Array(bytes.length);
  for (let i = 0; i < bytes.length; i++) {
    const k = keyBytes[i % keyBytes.length];
    result[i] = mod(bytes[i] + (encrypt ? k : -k), 256);
  }
  return result;
}

function processPlayfair() {
  const key = document.getElementById('pf-key').value;
  if (!key) return setOutput('pf','ERROR: Kunci tidak boleh kosong',true);
  const enc = state.pf.mode === 'encrypt';
  buildPlayfairGrid();
  showProgress('pf',30);
  if (state.pf.inputType === 'text') {
    const text = document.getElementById('pf-input').value;
    if (!text) return setOutput('pf','ERROR: Input teks kosong',true);
    const result = playfairCrypt(text, enc);
    showProgress('pf',100);
    setOutput('pf', result, false, !enc);
    document.getElementById('pf-download').classList.remove('show');
  } else {
    if (!state.pf.fileData) return setOutput('pf','ERROR: Pilih file terlebih dahulu',true);
    const result = playfairCryptBytes(state.pf.fileData, key, enc);
    showProgress('pf',100);
    const outName = (enc ? 'encrypted_' : 'decrypted_') + state.pf.fileName;
    downloadData.pf = {data: result, name: outName};
    document.getElementById('pf-download-name').textContent = outName;
    document.getElementById('pf-download').classList.add('show');
    setOutput('pf', `✓ File diproses: ${state.pf.fileName}\nUkuran: ${result.length} bytes\nKlik tombol "Unduh File" di bawah.`, false, !enc);
  }
}

// ==================== HILL ====================
function buildHillMatrix() {
  const size = parseInt(document.getElementById('hill-size').value);
  const container = document.getElementById('hill-matrix');
  container.className = 'matrix-grid ' + (size===2?'matrix-2x2':'matrix-3x3');
  const defaults = size===2 ? [6,24,1,13] : [2,4,5,9,2,1,3,17,7];
  container.innerHTML = '';
  for (let i = 0; i < size*size; i++) {
    const inp = document.createElement('input');
    inp.type = 'number'; inp.className = 'hill-cell';
    inp.value = defaults[i]; inp.min = 0; inp.max = 25;
    container.appendChild(inp);
  }
}

function getHillMatrix() {
  return Array.from(document.querySelectorAll('.hill-cell')).map(i => parseInt(i.value)||0);
}

function matMul(A, B, n, m) {
  const result = Array(n).fill(0).map(()=>Array(m).fill(0));
  for (let i=0;i<n;i++) for (let j=0;j<m;j++) for (let k=0;k<n;k++) result[i][j]+=A[i][k]*B[k][j];
  return result.map(row=>row.map(v=>mod(v,26)));
}

function det2(m) { return m[0]*m[3]-m[1]*m[2]; }
function det3(m) {
  return m[0]*(m[4]*m[8]-m[5]*m[7]) - m[1]*(m[3]*m[8]-m[5]*m[6]) + m[2]*(m[3]*m[7]-m[4]*m[6]);
}

function invertMatrix2(m) {
  const d = det2(m);
  const dInv = modInverse(mod(d,26), 26);
  if (dInv === -1) return null;
  return [[mod(m[3]*dInv,26), mod(-m[1]*dInv,26)],[mod(-m[2]*dInv,26), mod(m[0]*dInv,26)]];
}

function invertMatrix3(m) {
  const d = det3(m);
  const dInv = modInverse(mod(d,26),26);
  if (dInv === -1) return null;
  const cof = [
    mod(m[4]*m[8]-m[5]*m[7],26), mod(-(m[3]*m[8]-m[5]*m[6]),26), mod(m[3]*m[7]-m[4]*m[6],26),
    mod(-(m[1]*m[8]-m[2]*m[7]),26), mod(m[0]*m[8]-m[2]*m[6],26), mod(-(m[0]*m[7]-m[1]*m[6]),26),
    mod(m[1]*m[5]-m[2]*m[4],26), mod(-(m[0]*m[5]-m[2]*m[3]),26), mod(m[0]*m[4]-m[1]*m[3],26)
  ];
  // transpose for adjugate
  const adj = [
    [cof[0],cof[3],cof[6]],[cof[1],cof[4],cof[7]],[cof[2],cof[5],cof[8]]
  ];
  return adj.map(row=>row.map(v=>mod(v*dInv,26)));
}

function hillCrypt(text, encrypt) {
  const size = parseInt(document.getElementById('hill-size').value);
  const flatKey = getHillMatrix();
  const keyMat = [];
  for (let i=0;i<size;i++) keyMat.push(flatKey.slice(i*size,(i+1)*size));

  let mat = keyMat;
  if (!encrypt) {
    mat = size===2 ? invertMatrix2(flatKey) : invertMatrix3(flatKey);
    if (!mat) return {error: 'Matriks tidak invertible mod 26'};
  }

  let clean = text.toUpperCase().replace(/[^A-Z]/g,'');
  while (clean.length % size !== 0) clean += 'X';
  let result = '';
  for (let i=0;i<clean.length;i+=size) {
    const block = clean.slice(i,i+size).split('').map(c=>c.charCodeAt(0)-65);
    const col = block.map(v=>[v]);
    const res = matMul(mat, col, size, 1);
    result += res.map(r=>String.fromCharCode(r[0]+65)).join('');
  }
  return {result};
}

function hillCryptBytes(bytes, encrypt) {
  const size = parseInt(document.getElementById('hill-size').value);
  const flatKey = getHillMatrix();
  const result = new Uint8Array(bytes.length);
  for (let i = 0; i < bytes.length; i++) {
    const k = flatKey[i % flatKey.length];
    result[i] = mod(bytes[i] + (encrypt ? k : -k), 256);
  }
  return result;
}

function processHill() {
  const enc = state.hill.mode === 'encrypt';
  showProgress('hill',30);
  if (state.hill.inputType === 'text') {
    const text = document.getElementById('hill-input').value;
    if (!text) return setOutput('hill','ERROR: Input teks kosong',true);
    const {result,error} = hillCrypt(text, enc);
    showProgress('hill',100);
    if (error) setOutput('hill','ERROR: '+error,true);
    else { setOutput('hill', result, false, !enc); document.getElementById('hill-download').classList.remove('show'); }
  } else {
    if (!state.hill.fileData) return setOutput('hill','ERROR: Pilih file terlebih dahulu',true);
    const result = hillCryptBytes(state.hill.fileData, enc);
    showProgress('hill',100);
    const outName = (enc ? 'encrypted_' : 'decrypted_') + state.hill.fileName;
    downloadData.hill = {data: result, name: outName};
    document.getElementById('hill-download-name').textContent = outName;
    document.getElementById('hill-download').classList.add('show');
    setOutput('hill', `✓ File diproses: ${state.hill.fileName}\nUkuran: ${result.length} bytes\nKlik tombol "Unduh File" di bawah.`, false, !enc);
  }
}

// ==================== ENIGMA ====================
const ROTORS = [
  {wiring:'EKMFLGDQVZNTOWYHXUSPAIBRCJ', notch:'Q'},
  {wiring:'AJDKSIRUXBLHWTMCQGZNPYFVOE', notch:'E'},
  {wiring:'BDFHJLCPRTXVZNYEIWGAKMUSQO', notch:'V'},
  {wiring:'ESOVPZJAYQUIRHXLNFTGKDCMWB', notch:'J'},
  {wiring:'VZBRGITYUPSDNHLXAWMJQOFECK', notch:'Z'}
];
const REFLECTOR = 'YRUHQSLDPXNGOKMIEBFZCWVJAT';

function enigmaCryptChar(c, rotors, positions, rings, plugboard) {
  if (!/[A-Z]/.test(c)) return c;
  // plugboard
  c = plugboard[c] || c;
  let sig = c.charCodeAt(0)-65;
  // forward through rotors
  for (let i=2;i>=0;i--) {
    const offset = mod(positions[i]-rings[i],26);
    sig = mod(ROTORS[rotors[i]].wiring.charCodeAt(mod(sig+offset,26))-65-offset,26);
  }
  // reflector
  sig = REFLECTOR.charCodeAt(sig)-65;
  // backward through rotors
  for (let i=0;i<3;i++) {
    const offset = mod(positions[i]-rings[i],26);
    sig = mod(ROTORS[rotors[i]].wiring.indexOf(String.fromCharCode(mod(sig+offset,26)+65))-offset,26);
  }
  // plugboard back
  const out = String.fromCharCode(sig+65);
  return plugboard[out] || out;
}

function stepRotors(positions, rotors) {
  const pos = [...positions];
  const n2 = ROTORS[rotors[1]].notch.charCodeAt(0)-65;
  const n1 = ROTORS[rotors[2]].notch.charCodeAt(0)-65;
  if (pos[1] === n2) { pos[0] = mod(pos[0]+1,26); pos[1] = mod(pos[1]+1,26); }
  if (pos[2] === n1) pos[1] = mod(pos[1]+1,26);
  pos[2] = mod(pos[2]+1,26);
  return pos;
}

function parsePlugboard(str) {
  const pb = {};
  const pairs = str.toUpperCase().replace(/[^A-Z]/g,' ').trim().split(/\s+/);
  for (let p of pairs) {
    if (p.length === 2 && p[0] !== p[1]) { pb[p[0]] = p[1]; pb[p[1]] = p[0]; }
  }
  return pb;
}

function enigmaProcess(input) {
  const rotors = [
    parseInt(document.getElementById('eng-r1').value),
    parseInt(document.getElementById('eng-r2').value),
    parseInt(document.getElementById('eng-r3').value)
  ];
  const posStr = (document.getElementById('eng-pos').value + 'AAA').slice(0,3).toUpperCase();
  const ringStr = (document.getElementById('eng-ring').value + 'AAA').slice(0,3).toUpperCase();
  let positions = posStr.split('').map(c=>c.charCodeAt(0)-65);
  const rings = ringStr.split('').map(c=>c.charCodeAt(0)-65);
  const plugboard = parsePlugboard(document.getElementById('eng-plug').value);

  let result = '';
  for (let c of input.toUpperCase()) {
    if (/[A-Z]/.test(c)) {
      positions = stepRotors(positions, rotors);
      result += enigmaCryptChar(c, rotors, positions, rings, plugboard);
    } else result += c;
  }
  return result;
}

function enigmaProcessBytes(bytes) {
  const rotors = [
    parseInt(document.getElementById('eng-r1').value),
    parseInt(document.getElementById('eng-r2').value),
    parseInt(document.getElementById('eng-r3').value)
  ];
  const posStr = (document.getElementById('eng-pos').value + 'AAA').slice(0,3).toUpperCase();
  const ringStr = (document.getElementById('eng-ring').value + 'AAA').slice(0,3).toUpperCase();
  let positions = posStr.split('').map(c=>c.charCodeAt(0)-65);
  const rings = ringStr.split('').map(c=>c.charCodeAt(0)-65);
  const plugboard = parsePlugboard(document.getElementById('eng-plug').value);

  // For binary: use a custom stream based on Enigma keystream
  const result = new Uint8Array(bytes.length);
  for (let i = 0; i < bytes.length; i++) {
    positions = stepRotors(positions, rotors);
    // Generate keystream byte from enigma output of 'A'+i%26
    const keyChar = String.fromCharCode(65 + (i%26));
    const encChar = enigmaCryptChar(keyChar, rotors, positions, rings, plugboard);
    const keyByte = encChar.charCodeAt(0) - 65;
    result[i] = mod(bytes[i] + keyByte*7 + Math.floor(i/26)%256, 256);
  }
  return result;
}

function processEnigma() {
  showProgress('eng',30);
  if (state.eng.inputType === 'text') {
    const text = document.getElementById('eng-input').value;
    if (!text) return setOutput('eng','ERROR: Input teks kosong',true);
    const result = enigmaProcess(text);
    showProgress('eng',100);
    setOutput('eng', result, false, false);
    document.getElementById('eng-download').classList.remove('show');
  } else {
    if (!state.eng.fileData) return setOutput('eng','ERROR: Pilih file terlebih dahulu',true);
    const result = enigmaProcessBytes(state.eng.fileData);
    showProgress('eng',100);
    const posStr = document.getElementById('eng-pos').value || 'AAA';
    const outName = 'enigma_' + posStr + '_' + state.eng.fileName;
    downloadData.eng = {data: result, name: outName};
    document.getElementById('eng-download-name').textContent = outName;
    document.getElementById('eng-download').classList.add('show');
    setOutput('eng', `✓ File diproses dengan Enigma: ${state.eng.fileName}\nUkuran: ${result.length} bytes\nKlik tombol "Unduh File" di bawah.`, false, false);
  }
}

// ==================== DOWNLOAD ====================
function downloadFile(prefix) {
  const d = downloadData[prefix];
  if (!d) return;
  const blob = new Blob([d.data]);
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = d.name; a.click();
  URL.revokeObjectURL(url);
}

// Init
buildPlayfairGrid();
buildHillMatrix();
</script>
</body>
</html>