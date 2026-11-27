<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dataset Belum Terklasifikasi - Satu Data OPD</title>
    <style>
        * { box-sizing:border-box; }
        :root {
            --navy:#102a43; --blue:#1c5d85; --blue-dark:#123653;
            --gold:#d4a84f; --bg:#eef2f7; --text:#172b4d;
            --muted:#64748b; --line:#dce5ef; --red:#b91c1c;
        }
        body { margin:0; font-family:Inter,Arial,Helvetica,sans-serif; background:var(--bg); color:var(--text); }
        .navbar {
            min-height:80px; padding:14px clamp(18px,4vw,54px); display:flex;
            align-items:center; justify-content:space-between; gap:20px;
            background:var(--navy); border-bottom:3px solid var(--gold);
            box-shadow:0 4px 14px rgba(15,35,60,.12);
        }
        .brand-wrap { display:flex; align-items:center; gap:13px; min-width:0; }
        .brand-mark {
            width:47px; height:47px; display:grid; place-items:center; flex:none;
            border-radius:14px; background:linear-gradient(145deg,#f5d98b,#d5a83e);
            color:var(--navy); font-weight:800; letter-spacing:-1px;
            box-shadow:inset 0 0 0 3px rgba(255,255,255,.25);
        }
        .brand { color:#fff; font-size:19px; font-weight:800; }
        .brand-subtitle { margin-top:4px; color:#c8d5e3; font-size:12px; }
        .nav-link {
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            color:#fff; text-decoration:none; font-size:13px; font-weight:750;
            padding:11px 20px; border:1px solid rgba(255,255,255,.16);
            border-radius:999px; background:linear-gradient(135deg,#2563eb,#1d4ed8);
            box-shadow:0 5px 13px rgba(37,99,235,.28);
            transition:transform .18s ease,box-shadow .18s ease,filter .18s ease;
        }
        .nav-link:hover {
            transform:translateY(-2px); filter:brightness(1.06);
            box-shadow:0 8px 18px rgba(37,99,235,.35);
        }
        .nav-link:active { transform:translateY(0); }
        .container { max-width:1400px; margin:auto; padding:28px clamp(16px,3vw,38px) 48px; }
        .breadcrumb {
            display:inline-flex; align-items:center; gap:9px; margin-bottom:18px;
            padding:9px 13px; background:#fff; border:1px solid var(--line);
            border-radius:9px; color:var(--muted); font-size:12px;
            box-shadow:0 2px 6px rgba(15,35,60,.025);
        }
        .breadcrumb a { color:var(--blue); font-weight:700; text-decoration:none; }
        .page-heading {
            position:relative; isolation:isolate; overflow:hidden; margin-bottom:22px;
            padding:29px 31px; border-radius:17px; color:#fff;
            background:linear-gradient(115deg,#123653 0%,#174f78 58%,#286a8c 100%);
            box-shadow:0 12px 28px rgba(17,58,88,.17);
        }
        .page-heading:after {
            content:""; position:absolute; z-index:-1; width:280px; height:280px;
            right:-55px; top:-135px; border:1px solid rgba(255,255,255,.15);
            border-radius:50%; box-shadow:0 0 0 28px rgba(255,255,255,.035),0 0 0 58px rgba(255,255,255,.025);
        }
        .eyebrow { margin-bottom:9px; color:#f3d98e; font-size:10px; font-weight:800; letter-spacing:1.5px; }
        h1 { margin:0; color:#fff; font-size:clamp(25px,3vw,34px); letter-spacing:-.7px; }
        .page-heading p { max-width:760px; margin:9px 0 0; color:#d7e6f2; font-size:14px; line-height:1.65; }
        .alert {
            margin-bottom:18px; padding:13px 16px; border-radius:11px;
            font-size:13px; line-height:1.5;
        }
        .alert-success { color:#166534; background:#ecfdf3; border:1px solid #bbf7d0; }
        .alert-error { color:#9f1239; background:#fff1f2; border:1px solid #fecdd3; }
        .summary { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:15px; margin-bottom:21px; }
        .summary-card {
            position:relative; overflow:hidden; min-height:125px; padding:20px 22px;
            background:#fff; border:1px solid var(--line); border-radius:14px;
            box-shadow:0 5px 14px rgba(20,48,75,.045);
        }
        .summary-card:before { content:""; position:absolute; inset:0 auto 0 0; width:5px; background:#d4a84f; }
        .summary-label { color:var(--muted); font-size:13px; font-weight:700; }
        .summary-value { margin-top:12px; color:var(--red); font-size:34px; font-weight:850; letter-spacing:-1px; line-height:1; }
        .summary-note { margin-top:8px; color:#94a3b8; font-size:11px; }
        .section {
            overflow:hidden; background:#fff; border:1px solid var(--line);
            border-radius:15px; box-shadow:0 5px 15px rgba(20,48,75,.045);
        }
        .section-header {
            display:flex; justify-content:space-between; align-items:center; gap:18px;
            padding:20px 23px; border-bottom:1px solid #e8edf3;
            background:linear-gradient(180deg,#fff,#fbfdff);
        }
        .section-heading h2 { display:flex; align-items:center; gap:10px; margin:0; color:var(--navy); font-size:18px; }
        .section-heading h2:before { content:""; width:4px; height:21px; border-radius:3px; background:var(--gold); }
        .section-heading p { margin:6px 0 0 14px; color:var(--muted); font-size:12px; line-height:1.5; }
        .search-wrap { position:relative; width:min(100%,370px); flex:none; }
        .search-wrap:before { content:"⌕"; position:absolute; left:12px; top:5px; color:#94a3b8; font-size:23px; }
        .search {
            width:100%; min-height:43px; padding:10px 13px 10px 36px;
            border:1px solid #cbd7e3; border-radius:9px; outline:none;
            color:var(--text); background:#fff; font:inherit; font-size:13px;
            transition:border-color .18s,box-shadow .18s;
        }
        .search:focus { border-color:#7190e4; box-shadow:0 0 0 3px rgba(49,87,183,.12); }
        .dataset-list { display:flex; flex-direction:column; gap:9px; padding:18px 21px 21px; }
        .dataset-item {
            padding:15px 17px; background:#f7f9fc; border:1px solid #e7edf4;
            border-radius:10px; transition:background .16s,border-color .16s,transform .16s;
        }
        .dataset-item:hover { background:#f0f6fb; border-color:#cbd9e7; transform:translateY(-1px); }
        .dataset-row { display:flex; gap:14px; align-items:flex-start; }
        .number {
            width:32px; min-width:32px; height:32px; display:grid; place-items:center;
            border-radius:9px; background:#e8eff6; color:#45627d; font-size:12px; font-weight:800;
        }
        .dataset-content { flex:1; min-width:0; }
        .dataset-name { margin:1px 0 9px; color:#153c5a; font-size:14px; font-weight:750; line-height:1.55; overflow-wrap:anywhere; }
        .dataset-info { display:flex; flex-wrap:wrap; gap:7px; }
        .info {
            display:inline-flex; align-items:center; padding:5px 9px;
            border:1px solid #e0e7ef; border-radius:7px; background:#fff;
            color:#5b6f82; font-size:11px; line-height:1.4;
        }
        .empty { padding:45px 20px; text-align:center; color:var(--muted); font-size:13px; line-height:1.6; }
        .empty-icon { display:grid; place-items:center; width:48px; height:48px; margin:0 auto 12px; border-radius:14px; background:#e8f7ee; color:#16834a; font-size:23px; }
        .empty strong { display:block; margin-bottom:5px; color:#24445e; font-size:15px; }
        .list-footer { padding:13px 22px; border-top:1px solid #e8edf3; background:#f8fafc; color:var(--muted); font-size:12px; font-weight:600; }
        .hidden-by-search { display:none !important; }
        :focus-visible { outline:3px solid rgba(196,154,58,.55); outline-offset:2px; }
        @media(max-width:800px) {
            .navbar { align-items:flex-start; flex-direction:column; padding:14px 18px; }
            .summary { grid-template-columns:1fr; gap:10px; }
            .summary-card { min-height:110px; }
            .section-header { align-items:stretch; flex-direction:column; }
            .search-wrap { width:100%; }
        }
        @media(max-width:600px) {
            .container { padding:20px 13px 34px; }
            .page-heading { padding:23px 19px; border-radius:14px; }
            .eyebrow { font-size:9px; letter-spacing:1px; }
            h1 { font-size:26px; }
            .summary-card { padding:17px 19px; }
            .summary-value { font-size:31px; }
            .section-header { padding:17px; }
            .dataset-list { padding:13px; gap:8px; }
            .dataset-item { padding:13px 12px; }
            .dataset-row { gap:10px; }
            .number { width:29px; min-width:29px; height:29px; }
            .dataset-name { font-size:13px; }
            .info { font-size:10px; }
        }
        @media(prefers-reduced-motion:reduce) {
            *,*::before,*::after { transition:none !important; animation:none !important; }
        }
        @media print {
            body { background:#fff; }
            .navbar { background:#fff; border-bottom:1px solid #ddd; box-shadow:none; }
            .brand,.brand-subtitle { color:#172b4d; }
            .nav-link { color:#fff; }
            .page-heading { background:#fff; color:#172b4d; box-shadow:none; border:1px solid #ddd; }
            h1,.page-heading p { color:#172b4d; }
            .search-wrap { display:none; }
            .section,.summary-card,.dataset-item { box-shadow:none; break-inside:avoid; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="brand-wrap">
            <div class="brand-mark">SD</div>
            <div>
                <div class="brand">Satu Data OPD</div>
                <div class="brand-subtitle">Portal Pengelolaan Data Pemerintah Kota Surakarta</div>
            </div>
        </div>
        <a href="/dataset" class="nav-link">← Kembali ke Dataset</a>
    </div>

    <main class="container">
        <div class="breadcrumb">
            <a href="/dashboard">Dashboard</a>
            <span>›</span>
            <a href="/dataset">Dataset OPD</a>
            <span>›</span>
            <span>Belum Terklasifikasi</span>
        </div>

        <section class="page-heading">
            <div class="eyebrow">PORTAL DATA SEKTORAL • PEMERINTAH KOTA SURAKARTA</div>
            <h1>Dataset Belum Terklasifikasi</h1>
            <p>Daftar dataset yang belum berhasil dipetakan ke sektor dan masih memerlukan peninjauan lebih lanjut.</p>
        </section>

        <div class="summary">
            <div class="summary-card">
                <div class="summary-label">Belum Terklasifikasi</div>
                <div class="summary-value">{{ $totalBelum }}</div>
                <div class="summary-note">Dataset yang belum memiliki hasil klasifikasi sektor</div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <div class="section-heading">
                    <h2>Daftar Dataset</h2>
                    <p>Telusuri nama dataset, OPD pemilik, kategori, atau jenis data.</p>
                </div>
                <div class="search-wrap">
                    <input type="text" id="searchDataset" class="search" placeholder="Cari nama dataset atau OPD..." aria-label="Cari dataset">
                </div>
            </div>

            <div class="dataset-list" id="datasetList">
                @forelse ($datasets as $dataset)
                    <div
                        class="dataset-item"
                        data-search="{{ strtolower(
                            ($dataset->nama_statistik ?? '') . ' ' .
                            ($dataset->opd->nama_opd ?? '') . ' ' .
                            ($dataset->nama_data_sektoral ?? '') . ' ' .
                            ($dataset->kategori_data ?? '') . ' ' .
                            ($dataset->jenis_data ?? '')
                        ) }}"
                    >
                        <div class="dataset-row">
                            <div class="number">{{ $loop->iteration }}</div>
                            <div class="dataset-content">
                                <div class="dataset-name">{{ $dataset->nama_statistik ?? 'Nama dataset tidak tersedia' }}</div>
                                <div class="dataset-info">
                                    <span class="info">OPD: {{ $dataset->opd->nama_opd ?? '-' }}</span>
                                    <span class="info">Kategori: {{ $dataset->kategori_data ?? '-' }}</span>
                                    <span class="info">Jenis: {{ $dataset->jenis_data ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty">
                        <div class="empty-icon">✓</div>
                        <strong>Semua dataset sudah terklasifikasi!</strong>
                        Tidak ada dataset yang perlu ditinjau saat ini.
                    </div>
                @endforelse
                <div class="empty" id="searchEmpty" style="display:none;">
                    <strong>Dataset tidak ditemukan</strong>
                    Coba gunakan kata kunci lain.
                </div>
            </div>
            <div class="list-footer" id="datasetCount">Menampilkan {{ $datasets->count() }} dataset.</div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchDataset');
            const datasetItems = Array.from(document.querySelectorAll('.dataset-item'));
            const emptyMessage = document.getElementById('searchEmpty');
            const countLabel = document.getElementById('datasetCount');

            if (!searchInput) return;

            function filterDatasets() {
                const keyword = searchInput.value.trim().toLocaleLowerCase('id-ID');
                let visible = 0;

                datasetItems.forEach(function (item) {
                    const text = (item.dataset.search || '').toLocaleLowerCase('id-ID');
                    const matches = text.includes(keyword);
                    item.classList.toggle('hidden-by-search', !matches);
                    if (matches) visible++;
                });

                if (emptyMessage) {
                    emptyMessage.style.display = visible === 0 ? 'block' : 'none';
                }

                if (countLabel) {
                    countLabel.textContent = keyword
                        ? 'Menampilkan ' + visible + ' dari ' + datasetItems.length + ' dataset yang cocok.'
                        : 'Menampilkan ' + datasetItems.length + ' dataset.';
                }
            }

            searchInput.addEventListener('input', filterDatasets);
        });
    </script>
</body>
</html>
