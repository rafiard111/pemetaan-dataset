<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Aturan Klasifikasi - Satu Data</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --text-title: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --radius-xl: 20px;
            --radius-lg: 14px;
            --radius-md: 10px;
            --shadow-subtle: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --shadow-glow: 0 10px 25px -5px rgba(37, 99, 235, 0.15);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background: var(--bg-body);
            color: var(--text-body);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Hero Header Banner */
        .hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%);
            color: #ffffff;
            padding: 36px 0 48px;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, transparent 70%);
            pointer-events: none;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Navigasi Tombol Kembali */
        .nav-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-md);
            color: #ffffff;
            font-weight: 600;
            font-size: 13.5px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .hero-content h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .hero-content p {
            color: #94a3b8;
            font-size: 14.5px;
        }

        /* Main Body Content */
        .main-content {
            margin-top: -24px;
            padding-bottom: 60px;
        }

        /* KPI Cards Grid */
        .summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 22px;
            box-shadow: var(--shadow-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-glow);
            border-color: #bfdbfe;
        }

        .summary-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 30px;
            font-weight: 800;
            color: var(--text-title);
            line-height: 1.1;
        }

        .summary-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .summary-icon.blue { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
        .summary-icon.indigo { background: linear-gradient(135deg, #6366f1, #4338ca); }
        .summary-icon.emerald { background: linear-gradient(135deg, #10b981, #047857); }

        /* Panel Box */
        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-subtle);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .panel-header h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-title);
        }

        /* Toolbar Actions & Search */
        .toolbar {
            display: flex;
            gap: 12px;
            width: 100%;
            flex-wrap: wrap;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 260px;
        }

        .search-wrapper svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 46px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .select-filter {
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-family: inherit;
            background: #f8fafc;
            outline: none;
            color: var(--text-body);
            font-weight: 600;
        }

        .btn {
            padding: 12px 22px;
            border: 0;
            border-radius: var(--radius-lg);
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            white-space: nowrap;
        }

        .btn:hover { background: var(--primary-hover); transform: translateY(-1px); }

        .btn-light {
            background: #f1f5f9;
            color: var(--text-body);
            border: 1px solid var(--border-color);
            box-shadow: none;
        }

        .btn-light:hover { background: #e2e8f0; }

        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            box-shadow: none;
            padding: 8px 14px;
            font-size: 12.5px;
            border-radius: var(--radius-md);
        }

        .btn-danger:hover { background: #fca5a5; color: #991b1b; }

        .btn-edit {
            background: #eff6ff;
            color: var(--primary);
            border: 1px solid #bfdbfe;
            box-shadow: none;
            padding: 8px 14px;
            font-size: 12.5px;
            border-radius: var(--radius-md);
        }

        .btn-edit:hover { background: #dbeafe; }

        /* Table */
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            margin-top: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            background: #fff;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            white-space: nowrap;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        tbody tr:hover { background: #f8fafc; }

        /* Badges & Tags */
        .tag-keyword {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 8px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            font-family: monospace;
            font-weight: 700;
            color: #1e293b;
            font-size: 13px;
        }

        .badge-sektor {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: var(--primary);
            font-weight: 700;
            font-size: 12px;
        }

        .bobot-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            padding: 4px 10px;
            border-radius: 20px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            font-weight: 800;
            font-size: 12.5px;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            background: #fff;
            color: var(--text-body);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .pagination .active span {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .empty {
            padding: 36px;
            text-align: center;
            color: var(--text-muted);
        }

        /* Modal Simple Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active { display: flex; }

        .modal-card {
            background: #fff;
            border-radius: var(--radius-xl);
            width: 100%;
            max-width: 500px;
            padding: 28px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .modal-header h3 { font-size: 18px; font-weight: 800; }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 14px;
            font-family: inherit;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        @media (max-width: 900px) {
            .summary { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; }
        }
    </style>
</head>

<body>

<!-- HERO BANNER -->
<header class="hero-banner">
    <div class="container">
        <div class="nav-actions">
            <a href="/dashboard" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Dashboard
            </a>
            <a href="/pemetaan" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Pemetaan Data
            </a>
        </div>

        <div class="hero-content">
            <h1>Aturan Klasifikasi Dataset</h1>
            <p>Kelola kata kunci (keywords) dan bobot pencocokan otomatis dataset ke dalam sektor target.</p>
        </div>
    </div>
</header>

<main class="container main-content">

    <!-- KPI STATISTIK ATURAN -->
    <div class="summary">
        <div class="summary-card">
            <div>
                <div class="summary-label">Total Aturan Keyword</div>
                <div class="summary-value">{{ number_format($totalAturan ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="summary-icon blue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
        </div>

        <div class="summary-card">
            <div>
                <div class="summary-label">Sektor Terhubung</div>
                <div class="summary-value">{{ number_format($totalSektor ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="summary-icon indigo">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            </div>
        </div>

        <div class="summary-card">
            <div>
                <div class="summary-label">Rata-Rata Bobot</div>
                <div class="summary-value">{{ number_format($rataBobot ?? 1.0, 1) }}</div>
            </div>
            <div class="summary-icon emerald">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
        </div>
    </div>

    <!-- MAIN PANEL -->
    <section class="panel">
        <div class="panel-header">
            <h3>Daftar Aturan Klasifikasi</h3>
            <button class="btn" onclick="openModal()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Aturan Baru
            </button>
        </div>

        <!-- SEARCH & FILTER TOOLBAR -->
        <form method="GET" action="{{ url('/aturan-klasifikasi') }}" class="toolbar">
            <div class="search-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input
                    type="text"
                    name="q"
                    class="search-input"
                    value="{{ request('q') }}"
                    placeholder="Cari kata kunci / keyword..."
                >
            </div>

            <select name="sektor_id" class="select-filter" onchange="this.form.submit()">
                <option value="">Semua Sektor</option>
                @foreach ($listSektor ?? [] as $sektor)
                    <option value="{{ $sektor->id }}" {{ request('sektor_id') == $sektor->id ? 'selected' : '' }}>
                        {{ $sektor->nama_sektor }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-light">Filter</button>
            @if(request('q') || request('sektor_id'))
                <a href="{{ url('/aturan-klasifikasi') }}" class="btn btn-light">Reset</a>
            @endif
        </form>

        <!-- TABLE ATURAN -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Kata Kunci (Keyword)</th>
                        <th>Sektor Target</th>
                        <th>Bobot Skor</th>
                        <th style="width: 140px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aturanList ?? [] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="tag-keyword">{{ $item->keyword }}</span>
                            </td>
                            <td>
                                <span class="badge-sektor">
                                    {{ $item->sektor->nama_sektor ?? 'Sektor Tidak Ditemukan' }}
                                </span>
                            </td>
                            <td>
                                <span class="bobot-pill">+{{ number_format($item->bobot, 1) }}</span>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <button class="btn-edit" onclick="editModal({{ $item->id }}, '{{ $item->keyword }}', {{ $item->sektor_id }}, {{ $item->bobot }})">
                                        Edit
                                    </button>
                                    <form action="{{ url('/aturan-klasifikasi/' . $item->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada aturan klasifikasi yang didaftarkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($aturanList) && method_exists($aturanList, 'links'))
            <div class="pagination">
                {{ $aturanList->links() }}
            </div>
        @endif
    </section>

</main>

<!-- MODAL FORM TAMBAH / EDIT -->
<div class="modal" id="modalForm">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Aturan Baru</h3>
            <button class="btn btn-light" style="padding: 6px 12px;" onclick="closeModal()">✕</button>
        </div>

        <form id="formAturan" method="POST" action="{{ url('/aturan-klasifikasi') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="form-group">
                <label for="keyword">Kata Kunci (Keyword)</label>
                <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Contoh: kesehatan, jalan, puskesmas" required>
            </div>

            <div class="form-group">
                <label for="sektor_id">Sektor Target</label>
                <select id="sektor_id" name="sektor_id" class="form-control" required>
                    <option value="">-- Pilih Sektor --</option>
                    @foreach ($listSektor ?? [] as $sektor)
                        <option value="{{ $sektor->id }}">{{ $sektor->nama_sektor }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="bobot">Bobot Klasifikasi</label>
                <input type="number" step="0.1" id="bobot" name="bobot" class="form-control" value="1.0" required>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" class="btn btn-light" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn">Simpan Aturan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Aturan Baru';
        document.getElementById('formAturan').action = '{{ url("/aturan-klasifikasi") }}';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('keyword').value = '';
        document.getElementById('sektor_id').value = '';
        document.getElementById('bobot').value = '1.0';
        document.getElementById('modalForm').classList.add('active');
    }

    function closeModal() {
        document.getElementById('modalForm').classList.remove('active');
    }

    function editModal(id, keyword, sektorId, bobot) {
        document.getElementById('modalTitle').innerText = 'Edit Aturan Klasifikasi';
        document.getElementById('formAturan').action = '{{ url("/aturan-klasifikasi") }}/' + id;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('keyword').value = keyword;
        document.getElementById('sektor_id').value = sektorId;
        document.getElementById('bobot').value = bobot;
        document.getElementById('modalForm').classList.add('active');
    }
</script>

</body>
</html>