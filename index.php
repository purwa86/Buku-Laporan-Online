<!doctype html>
<html lang="id" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buku Laporan Online</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="/_sdk/data_sdk.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .toast { animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.7s; }
    @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
    @media print { .no-print { display: none !important; } }
  </style>
  <style>body { box-sizing: border-box; }</style>
 </head>
 <body class="h-full bg-slate-900 text-slate-100">
  <div id="app" class="h-full w-full overflow-auto"><!-- Toast -->
   <div id="toast-container" class="fixed top-4 right-4 z-50"></div><!-- Navigation -->
   <nav class="sticky top-0 z-40 bg-slate-800/95 backdrop-blur border-b border-slate-700 no-print">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
     <h1 id="app-title" class="text-lg font-bold text-emerald-400">📋 Buku Laporan Online</h1>
     <div class="flex gap-2"><button onclick="showView('form')" id="btn-form" class="px-3 py-1.5 rounded-lg text-sm font-medium bg-emerald-600 text-white">Buat Laporan</button> <button onclick="showView('search')" id="btn-search" class="px-3 py-1.5 rounded-lg text-sm font-medium bg-slate-700 text-slate-300 hover:bg-slate-600">Cari Laporan</button>
     </div>
    </div>
   </nav><!-- Form View -->
   <div id="view-form" class="max-w-5xl mx-auto p-4 space-y-6 pb-20"><!-- Bagian A -->
    <section class="bg-slate-800 rounded-xl p-5 border border-slate-700">
     <h2 class="text-base font-bold text-emerald-400 mb-4 flex items-center gap-2"><span class="bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold">A</span> Informasi Umum</h2>
     <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
       <label class="text-xs text-slate-400 mb-1 block">Lokasi</label><input id="f-lokasi" type="text" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Masukkan lokasi">
      </div>
      <div>
       <label class="text-xs text-slate-400 mb-1 block">Tanggal</label><input id="f-tanggal" type="date" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
      </div>
      <div>
       <label class="text-xs text-slate-400 mb-1 block">Hari</label><input id="f-hari" type="text" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Senin/Selasa/...">
      </div>
      <div>
       <label class="text-xs text-slate-400 mb-1 block">Shift Jaga</label><select id="f-shift" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"><option value="">Pilih Shift</option><option>Shift 1 (Pagi)</option><option>Shift 2 (Siang)</option><option>Shift 3 (Malam)</option></select>
      </div>
     </div>
    </section><!-- Bagian B -->
    <section class="bg-slate-800 rounded-xl p-5 border border-slate-700">
     <h2 class="text-base font-bold text-emerald-400 mb-4 flex items-center gap-2"><span class="bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold">B</span> Data Personil</h2>
     <div class="overflow-x-auto">
      <table class="w-full text-sm">
       <thead>
        <tr class="bg-slate-700 text-slate-300">
         <th class="px-2 py-2 rounded-tl-lg w-10">No</th>
         <th class="px-2 py-2">Nama</th>
         <th class="px-2 py-2">Jabatan</th>
         <th class="px-2 py-2">Tempat Dinas</th>
         <th class="px-2 py-2">Keterangan</th>
         <th class="px-2 py-2 rounded-tr-lg w-10"></th>
        </tr>
       </thead>
       <tbody id="personil-body"></tbody>
      </table>
     </div><button onclick="addPersonil()" class="mt-3 flex items-center gap-1 text-sm text-emerald-400 hover:text-emerald-300 font-medium"><i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Personil</button>
    </section><!-- Bagian C -->
    <section class="bg-slate-800 rounded-xl p-5 border border-slate-700">
     <h2 class="text-base font-bold text-emerald-400 mb-4 flex items-center gap-2"><span class="bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold">C</span> Uraian Kegiatan</h2>
     <div class="overflow-x-auto">
      <table class="w-full text-sm">
       <thead>
        <tr class="bg-slate-700 text-slate-300">
         <th class="px-2 py-2 rounded-tl-lg w-10">No</th>
         <th class="px-2 py-2 w-28">Jam</th>
         <th class="px-2 py-2">Kegiatan</th>
         <th class="px-2 py-2 rounded-tr-lg w-10"></th>
        </tr>
       </thead>
       <tbody id="kegiatan-body"></tbody>
      </table>
     </div><button onclick="addKegiatan()" class="mt-3 flex items-center gap-1 text-sm text-emerald-400 hover:text-emerald-300 font-medium"><i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Kegiatan</button>
    </section><!-- Bagian D -->
    <section class="bg-slate-800 rounded-xl p-5 border border-slate-700">
     <h2 class="text-base font-bold text-emerald-400 mb-4 flex items-center gap-2"><span class="bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold">D</span> Serah Terima</h2>
     <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
       <label class="text-xs text-slate-400 mb-1 block">Tempat</label><input id="f-serah-tempat" type="text" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
      </div>
      <div>
       <label class="text-xs text-slate-400 mb-1 block">Tanggal</label><input id="f-serah-tanggal" type="date" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
      </div>
      <div><label class="text-xs text-slate-400 mb-1 block">Nama Petugas Penyerah</label> <input id="f-serah-nama" type="text" oninput="generateQR()" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Ketik nama untuk generate QR tanda tangan">
      </div>
      <div><label class="text-xs text-slate-400 mb-1 block">Nama Penerima</label> <input id="f-serah-nama-penerima" type="text" oninput="generateQR()" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Ketik nama untuk generate QR tanda tangan">
      </div>
     </div>
     <div id="qr-section" class="mt-4 hidden">
      <div class="grid grid-cols-2 gap-4">
       <div>
        <p class="text-xs text-slate-400 mb-2">QR Tanda Tangan Penyerah:</p>
        <div id="qr-code-penyerah" class="inline-block bg-white p-2 rounded-lg"></div>
       </div>
       <div>
        <p class="text-xs text-slate-400 mb-2">QR Tanda Tangan Penerima:</p>
        <div id="qr-code-penerima" class="inline-block bg-white p-2 rounded-lg"></div>
       </div>
      </div>
     </div>
    </section><!-- Submit --> <button onclick="submitReport()" id="btn-submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl text-sm transition-colors flex items-center justify-center gap-2"> <i data-lucide="send" class="w-4 h-4"></i> Kirim &amp; Simpan Laporan </button>
   </div><!-- Search View -->
   <div id="view-search" class="max-w-5xl mx-auto p-4 space-y-4 pb-20 hidden">
    <div class="flex gap-2"><input id="search-input" type="text" placeholder="Cari berdasarkan lokasi, tanggal, atau shift..." class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
    </div>
    <div id="search-results" class="space-y-3"></div>
    <p id="no-results" class="text-center text-slate-500 py-10 hidden">Belum ada laporan tersimpan.</p>
   </div><!-- Detail View -->
   <div id="view-detail" class="max-w-5xl mx-auto p-4 pb-20 hidden"><button onclick="showView('search')" class="mb-4 flex items-center gap-1 text-sm text-emerald-400 hover:text-emerald-300 no-print"><i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali</button>
    <div id="detail-content" class="bg-slate-800 rounded-xl p-6 border border-slate-700"></div><button onclick="downloadPDF()" class="mt-4 w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl text-sm flex items-center justify-center gap-2 no-print"><i data-lucide="download" class="w-4 h-4"></i> Download PDF</button>
   </div>
  </div>
  <script>
let allReports = [];
let qrInstance = null;

// Data SDK
const dataHandler = {
  onDataChanged(data) {
    allReports = data;
    renderSearchResults();
  }
};

(async () => {
  await window.dataSdk.init(dataHandler);
})();

// Element SDK
const defaultConfig = { app_title: 'Buku Laporan Online', background_color: '#0f172a', surface_color: '#1e293b', text_color: '#f1f5f9', primary_action: '#059669', secondary_action: '#475569' };

window.elementSdk.init({
  defaultConfig,
  onConfigChange: async (config) => {
    const t = document.getElementById('app-title');
    if (t) t.textContent = '📋 ' + (config.app_title || defaultConfig.app_title);
  },
  mapToCapabilities: (config) => ({
    recolorables: [
      { get: () => config.background_color || defaultConfig.background_color, set: v => { config.background_color = v; window.elementSdk.setConfig({ background_color: v }); } },
      { get: () => config.surface_color || defaultConfig.surface_color, set: v => { config.surface_color = v; window.elementSdk.setConfig({ surface_color: v }); } },
      { get: () => config.text_color || defaultConfig.text_color, set: v => { config.text_color = v; window.elementSdk.setConfig({ text_color: v }); } },
      { get: () => config.primary_action || defaultConfig.primary_action, set: v => { config.primary_action = v; window.elementSdk.setConfig({ primary_action: v }); } },
      { get: () => config.secondary_action || defaultConfig.secondary_action, set: v => { config.secondary_action = v; window.elementSdk.setConfig({ secondary_action: v }); } }
    ],
    borderables: [],
    fontEditable: undefined,
    fontSizeable: undefined
  }),
  mapToEditPanelValues: (config) => new Map([['app_title', config.app_title || defaultConfig.app_title]])
});

// Views
function showView(view) {
  document.getElementById('view-form').classList.toggle('hidden', view !== 'form');
  document.getElementById('view-search').classList.toggle('hidden', view !== 'search');
  document.getElementById('view-detail').classList.toggle('hidden', view !== 'detail');
  document.getElementById('btn-form').className = `px-3 py-1.5 rounded-lg text-sm font-medium ${view === 'form' ? 'bg-emerald-600 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600'}`;
  document.getElementById('btn-search').className = `px-3 py-1.5 rounded-lg text-sm font-medium ${view === 'search' ? 'bg-emerald-600 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600'}`;
  if (view === 'search') renderSearchResults();
}

// Personil
let personilCount = 0;
function addPersonil() {
  personilCount++;
  const tr = document.createElement('tr');
  tr.className = 'border-t border-slate-700';
  tr.innerHTML = `<td class="px-2 py-1.5 text-center text-slate-400">${personilCount}</td><td class="px-1 py-1.5"><input type="text" class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-sm" data-field="nama"></td><td class="px-1 py-1.5"><input type="text" class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-sm" data-field="jabatan"></td><td class="px-1 py-1.5"><input type="text" class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-sm" data-field="tempat"></td><td class="px-1 py-1.5"><input type="text" class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-sm" data-field="ket"></td><td class="px-1 py-1.5 text-center"><button onclick="this.closest('tr').remove();renumberRows('personil-body')" class="text-red-400 hover:text-red-300"><i data-lucide="x" class="w-4 h-4"></i></button></td>`;
  document.getElementById('personil-body').appendChild(tr);
  lucide.createIcons();
}

// Kegiatan
let kegiatanCount = 0;
function addKegiatan() {
  kegiatanCount++;
  const tr = document.createElement('tr');
  tr.className = 'border-t border-slate-700';
  tr.innerHTML = `<td class="px-2 py-1.5 text-center text-slate-400">${kegiatanCount}</td><td class="px-1 py-1.5"><input type="time" class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-sm" data-field="jam"></td><td class="px-1 py-1.5"><input type="text" class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-sm" data-field="kegiatan"></td><td class="px-1 py-1.5 text-center"><button onclick="this.closest('tr').remove();renumberRows('kegiatan-body')" class="text-red-400 hover:text-red-300"><i data-lucide="x" class="w-4 h-4"></i></button></td>`;
  document.getElementById('kegiatan-body').appendChild(tr);
  lucide.createIcons();
}

function renumberRows(tbodyId) {
  const rows = document.getElementById(tbodyId).querySelectorAll('tr');
  rows.forEach((r, i) => r.querySelector('td').textContent = i + 1);
}

// QR
function generateQR() {
  const namaPenyerah = document.getElementById('f-serah-nama').value.trim();
  const namaPenerima = document.getElementById('f-serah-nama-penerima').value.trim();
  const section = document.getElementById('qr-section');
  
  if (!namaPenyerah && !namaPenerima) { 
    section.classList.add('hidden'); 
    return; 
  }
  
  section.classList.remove('hidden');
  
  // QR Penyerah
  const containerPenyerah = document.getElementById('qr-code-penyerah');
  if (namaPenyerah) {
    containerPenyerah.innerHTML = '';
    new QRCode(containerPenyerah, { text: `Tanda Tangan Penyerah: ${namaPenyerah} | ${new Date().toISOString()}`, width: 100, height: 100 });
  } else {
    containerPenyerah.innerHTML = '<p class="text-xs text-slate-500">Isi nama penyerah</p>';
  }
  
  // QR Penerima
  const containerPenerima = document.getElementById('qr-code-penerima');
  if (namaPenerima) {
    containerPenerima.innerHTML = '';
    new QRCode(containerPenerima, { text: `Tanda Tangan Penerima: ${namaPenerima} | ${new Date().toISOString()}`, width: 100, height: 100 });
  } else {
    containerPenerima.innerHTML = '<p class="text-xs text-slate-500">Isi nama penerima</p>';
  }
}

// Submit
async function submitReport() {
  const lokasi = document.getElementById('f-lokasi').value.trim();
  const tanggal = document.getElementById('f-tanggal').value;
  const hari = document.getElementById('f-hari').value.trim();
  const shift = document.getElementById('f-shift').value;
  if (!lokasi || !tanggal || !shift) { showToast('Harap isi Lokasi, Tanggal, dan Shift', 'error'); return; }
  if (allReports.length >= 999) { showToast('Batas maksimum 999 laporan tercapai.', 'error'); return; }

  // Collect personil
  const personilRows = [];
  document.getElementById('personil-body').querySelectorAll('tr').forEach(tr => {
    const inputs = tr.querySelectorAll('input');
    personilRows.push({ nama: inputs[0].value, jabatan: inputs[1].value, tempat: inputs[2].value, ket: inputs[3].value });
  });

  // Collect kegiatan
  const kegiatanRows = [];
  document.getElementById('kegiatan-body').querySelectorAll('tr').forEach(tr => {
    const inputs = tr.querySelectorAll('input');
    kegiatanRows.push({ jam: inputs[0].value, kegiatan: inputs[1].value });
  });

  const btn = document.getElementById('btn-submit');
  btn.disabled = true; btn.innerHTML = '<span class="animate-spin">⏳</span> Menyimpan...';

  const result = await window.dataSdk.create({
    report_id: `${lokasi}_${tanggal}_${shift}`,
    lokasi, tanggal, hari, shift,
    personil: JSON.stringify(personilRows),
    kegiatan: JSON.stringify(kegiatanRows),
    serah_tempat: document.getElementById('f-serah-tempat').value,
    serah_tanggal: document.getElementById('f-serah-tanggal').value,
    serah_nama: document.getElementById('f-serah-nama').value,
    serah_nama_penerima: document.getElementById('f-serah-nama-penerima').value
  });

  btn.disabled = false; btn.innerHTML = '<i data-lucide="send" class="w-4 h-4"></i> Kirim & Simpan Laporan';
  lucide.createIcons();

  if (result.isOk) {
    showToast('Laporan berhasil disimpan!', 'success');
    resetForm();
  } else {
    showToast('Gagal menyimpan. Coba lagi.', 'error');
  }
}

function resetForm() {
  document.getElementById('f-lokasi').value = '';
  document.getElementById('f-tanggal').value = '';
  document.getElementById('f-hari').value = '';
  document.getElementById('f-shift').value = '';
  document.getElementById('personil-body').innerHTML = '';
  document.getElementById('kegiatan-body').innerHTML = '';
  document.getElementById('f-serah-tempat').value = '';
  document.getElementById('f-serah-tanggal').value = '';
  document.getElementById('f-serah-nama').value = '';
  document.getElementById('f-serah-nama-penerima').value = '';
  document.getElementById('qr-section').classList.add('hidden');
  personilCount = 0; kegiatanCount = 0;
}

// Search
document.getElementById('search-input')?.addEventListener('input', renderSearchResults);

function renderSearchResults() {
  const query = (document.getElementById('search-input')?.value || '').toLowerCase();
  const filtered = allReports.filter(r => `${r.lokasi} ${r.tanggal} ${r.shift} ${r.hari}`.toLowerCase().includes(query));
  const container = document.getElementById('search-results');
  const noRes = document.getElementById('no-results');

  if (!filtered.length) { container.innerHTML = ''; noRes.classList.remove('hidden'); return; }
  noRes.classList.add('hidden');

  container.innerHTML = filtered.map(r => `
    <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 cursor-pointer hover:border-emerald-600 transition-colors" onclick="viewDetail('${r.__backendId}')">
      <div class="flex justify-between items-start">
        <div>
          <h3 class="font-semibold text-emerald-400">${r.lokasi}</h3>
          <p class="text-xs text-slate-400 mt-1">${r.hari}, ${r.tanggal} • ${r.shift}</p>
        </div>
        <i data-lucide="chevron-right" class="w-5 h-5 text-slate-500"></i>
      </div>
    </div>
  `).join('');
  lucide.createIcons();
}

// Detail
function viewDetail(id) {
  const r = allReports.find(x => x.__backendId === id);
  if (!r) return;
  showView('detail');
  const personil = JSON.parse(r.personil || '[]');
  const kegiatan = JSON.parse(r.kegiatan || '[]');

  document.getElementById('detail-content').innerHTML = `
    <div id="pdf-content">
      <h2 class="text-xl font-bold text-emerald-400 mb-1">BUKU LAPORAN</h2>
      <p class="text-xs text-slate-400 mb-5">${r.report_id}</p>
      <div class="mb-5">
        <h3 class="font-semibold text-sm text-slate-300 mb-2 border-b border-slate-700 pb-1">A. Informasi Umum</h3>
        <div class="grid grid-cols-2 gap-2 text-sm"><p><span class="text-slate-400">Lokasi:</span> ${r.lokasi}</p><p><span class="text-slate-400">Tanggal:</span> ${r.tanggal}</p><p><span class="text-slate-400">Hari:</span> ${r.hari}</p><p><span class="text-slate-400">Shift:</span> ${r.shift}</p></div>
      </div>
      <div class="mb-5">
        <h3 class="font-semibold text-sm text-slate-300 mb-2 border-b border-slate-700 pb-1">B. Data Personil</h3>
        <table class="w-full text-xs"><thead><tr class="bg-slate-700"><th class="px-2 py-1">No</th><th class="px-2 py-1">Nama</th><th class="px-2 py-1">Jabatan</th><th class="px-2 py-1">Tempat Dinas</th><th class="px-2 py-1">Ket</th></tr></thead><tbody>${personil.map((p,i) => `<tr class="border-t border-slate-700"><td class="px-2 py-1 text-center">${i+1}</td><td class="px-2 py-1">${p.nama}</td><td class="px-2 py-1">${p.jabatan}</td><td class="px-2 py-1">${p.tempat}</td><td class="px-2 py-1">${p.ket}</td></tr>`).join('')}</tbody></table>
      </div>
      <div class="mb-5">
        <h3 class="font-semibold text-sm text-slate-300 mb-2 border-b border-slate-700 pb-1">C. Uraian Kegiatan</h3>
        <table class="w-full text-xs"><thead><tr class="bg-slate-700"><th class="px-2 py-1">No</th><th class="px-2 py-1">Jam</th><th class="px-2 py-1">Kegiatan</th></tr></thead><tbody>${kegiatan.map((k,i) => `<tr class="border-t border-slate-700"><td class="px-2 py-1 text-center">${i+1}</td><td class="px-2 py-1">${k.jam}</td><td class="px-2 py-1">${k.kegiatan}</td></tr>`).join('')}</tbody></table>
      </div>
      <div>
        <h3 class="font-semibold text-sm text-slate-300 mb-2 border-b border-slate-700 pb-1">D. Serah Terima</h3>
        <div class="text-sm space-y-1"><p><span class="text-slate-400">Tempat:</span> ${r.serah_tempat}</p><p><span class="text-slate-400">Tanggal:</span> ${r.serah_tanggal}</p><p><span class="text-slate-400">Nama Penyerah:</span> ${r.serah_nama}</p><p><span class="text-slate-400">Nama Penerima:</span> ${r.serah_nama_penerima}</p></div>
        <div class="mt-3 grid grid-cols-2 gap-4" id="detail-qr"></div>
      </div>
    </div>
  `;

  if (r.serah_nama || r.serah_nama_penerima) {
    const qrDiv = document.getElementById('detail-qr');
    qrDiv.innerHTML = '';
    
    if (r.serah_nama) {
      const divPenyerah = document.createElement('div');
      divPenyerah.innerHTML = '<p class="text-xs text-slate-400 mb-2">QR Tanda Tangan Penyerah:</p>';
      const qrContainerPenyerah = document.createElement('div');
      qrContainerPenyerah.className = 'inline-block bg-white p-2 rounded';
      divPenyerah.appendChild(qrContainerPenyerah);
      qrDiv.appendChild(divPenyerah);
      new QRCode(qrContainerPenyerah, { text: `Tanda Tangan Penyerah: ${r.serah_nama}`, width: 80, height: 80 });
    }
    
    if (r.serah_nama_penerima) {
      const divPenerima = document.createElement('div');
      divPenerima.innerHTML = '<p class="text-xs text-slate-400 mb-2">QR Tanda Tangan Penerima:</p>';
      const qrContainerPenerima = document.createElement('div');
      qrContainerPenerima.className = 'inline-block bg-white p-2 rounded';
      divPenerima.appendChild(qrContainerPenerima);
      qrDiv.appendChild(divPenerima);
      new QRCode(qrContainerPenerima, { text: `Tanda Tangan Penerima: ${r.serah_nama_penerima}`, width: 80, height: 80 });
    }
  }
}

// PDF Download
async function downloadPDF() {
  const btn = document.querySelector('[onclick="downloadPDF()"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="animate-spin">⏳</span> Mengunduh...';
  
  try {
    const el = document.getElementById('pdf-content');
    if (!el) {
      showToast('Konten laporan tidak ditemukan.', 'error');
      return;
    }

    // Generate canvas dari HTML
    const canvas = await html2canvas(el, { 
      backgroundColor: '#ffffff', 
      scale: 2, 
      useCORS: true,
      allowTaint: true
    });

    if (!canvas) {
      showToast('Gagal membuat gambar laporan.', 'error');
      return;
    }

    // Buat PDF
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');
    const imgWidth = 190;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;
    const imgData = canvas.toDataURL('image/png');
    
    // Tambah gambar ke PDF
    let yPos = 10;
    let heightLeft = imgHeight;
    
    while (heightLeft > 0) {
      pdf.addImage(imgData, 'PNG', 10, yPos, imgWidth, imgHeight);
      heightLeft -= 277; // Tinggi A4 dalam mm
      if (heightLeft > 0) {
        pdf.addPage();
        yPos = -277 + heightLeft;
      }
    }
    
    // Buat nama file yang jelas
    const today = new Date();
    const dateStr = today.toISOString().split('T')[0]; // YYYY-MM-DD
    const timeStr = today.toTimeString().split(' ')[0].replace(/:/g, '-'); // HH-MM-SS
    const fileName = `Laporan_${dateStr}_${timeStr}.pdf`;
    
    // Unduh PDF
    pdf.save(fileName);
    
    showToast(`✅ File "${fileName}" berhasil diunduh ke folder Downloads!`, 'success');
  } catch (error) {
    console.error('Error downloading PDF:', error);
    showToast('❌ Gagal mengunduh PDF. Coba lagi atau hubungi support.', 'error');
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<i data-lucide="download" class="w-4 h-4"></i> Download PDF';
    lucide.createIcons();
  }
}

// Toast
function showToast(msg, type) {
  const container = document.getElementById('toast-container');
  const div = document.createElement('div');
  div.className = `toast px-4 py-2.5 rounded-lg text-sm font-medium mb-2 ${type === 'success' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white'}`;
  div.textContent = msg;
  container.appendChild(div);
  setTimeout(() => div.remove(), 3000);
}

// Init rows
addPersonil();
addKegiatan();
lucide.createIcons();
</script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9f4b026ae42cc8b5',t:'MTc3NzU5ODkwNi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
