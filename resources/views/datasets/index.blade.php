
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dataset - Satu Data OPD</title>

    <style>
        :root {
            --navy: #12345a;
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --blue-light: #eff6ff;
            --bg: #f3f7fc;
            --text: #24364b;
            --muted: #718096;
            --line: #e3ebf5;
            --shadow: 0 8px 28px rgba(31, 70, 120, .055);
            --radius: 22px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            color: inherit;
        }

        /* NAVBAR */
        .navbar {
            min-height: 78px;
            padding: 14px clamp(18px, 4vw, 55px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: #fff;
            border-bottom: 1px solid var(--line);
            box-shadow: 0 3px 16px rgba(31, 70, 120, .035);
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-mark {
            width: 47px;
            height: 47px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #3b82f6, #1d4ed8);
            color: white;
            font-weight: 800;
            box-shadow: 0 5px 13px rgba(37, 99, 235, .22);
        }

        .brand {
            font-size: 19px;
            font-weight: 800;
            color: var(--navy);
        }

        .brand-subtitle {
            margin-top: 4px;
            font-size: 12px;
            color: var(--muted);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .nav-links a {
            padding: 11px 17px;
            border-radius: 999px;
            text-decoration: none;
            color: #64748b;
            font-size: 13px;
            font-weight: 650;
            transition: .2s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: var(--blue-light);
            color: var(--blue);
        }

        /* CONTAINER */
        .container {
            max-width: 1480px;
            margin: auto;
            padding: 30px clamp(16px, 3vw, 42px) 50px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 22px;
            color: var(--muted);
            font-size: 13px;
        }

        .breadcrumb a {
            color: var(--blue);
            font-weight: 700;
            text-decoration: none;
        }

        /* PAGE HEADING */
        .page-heading {
            position: relative;
            overflow: hidden;
            padding: 34px;
            margin-bottom: 25px;
            border-radius: 26px;
            color: white;
            background: linear-gradient(120deg, #153b68, #2563a6 65%, #60a5fa);
            box-shadow: 0 12px 30px rgba(37, 99, 235, .15);
        }

        .page-heading::after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            right: -65px;
            top: -130px;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 50%;
            box-shadow:
                0 0 0 30px rgba(255,255,255,.045),
                0 0 0 65px rgba(255,255,255,.035);
        }

        .heading-content {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            margin-bottom: 11px;
            color: #bfdbfe;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .page-title {
            margin: 0;
            font-size: clamp(27px, 3vw, 36px);
            letter-spacing: -.8px;
        }

        .page-description {
            max-width: 700px;
            margin: 10px 0 0;
            color: #dbeafe;
            font-size: 14px;
            line-height: 1.7;
        }

        /* BUTTON */
        .btn {
            min-height: 44px;
            padding: 11px 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid transparent;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            font: inherit;
            font-size: 13px;
            font-weight: 750;
            white-space: nowrap;
            transition: .2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 5px 13px rgba(37, 99, 235, .18);
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            box-shadow: 0 7px 17px rgba(37, 99, 235, .25);
        }

        .btn-success {
            color: white;
            background: #2563eb;
            box-shadow: 0 5px 13px rgba(37, 99, 235, .16);
        }

        .btn-success:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            color: #36516f;
            background: white;
            border-color: #dce7f5;
        }

        .btn-secondary:hover {
            color: var(--blue);
            background: #f4f8ff;
            border-color: #b9d2f8;
        }

        /* ALERT */
        .alert {
            padding: 15px 19px;
            margin-bottom: 18px;
            border-radius: 17px;
            line-height: 1.6;
            font-size: 13px;
        }

        .alert-success {
            color: #166534;
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            color: #9f1239;
            background: #fff1f2;
            border: 1px solid #fecdd3;
        }

        /* SUMMARY */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 25px;
        }

        .summary-card {
            position: relative;
            overflow: hidden;
            padding: 23px;
            background: white;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: .22s ease;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 13px 30px rgba(31, 70, 120, .09);
        }

        .summary-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .summary-icon {
            width: 37px;
            height: 37px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: var(--blue-light);
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
        }

        .number {
            margin-top: 15px;
            color: var(--navy);
            font-size: 34px;
            font-weight: 850;
            letter-spacing: -1px;
        }

        .summary-note {
            margin-top: 6px;
            color: #94a3b8;
            font-size: 12px;
        }

        /* PANEL */
        .panel {
            overflow: hidden;
            margin-bottom: 24px;
            background: white;
            border: 1px solid var(--line);
            border-radius: 23px;
            box-shadow: var(--shadow);
        }

        .panel-header {
            padding: 22px 25px;
            border-bottom: 1px solid #edf2f8;
        }

        .panel-header h2 {
            margin: 0;
            color: var(--navy);
            font-size: 18px;
            font-weight: 800;
        }

        .panel-header p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .panel-body {
            padding: 25px;
        }

        /* FORM */
        .form-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto;
            gap: 17px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 9px;
            min-width: 0;
        }

        .form-group label {
            color: #36516f;
            font-size: 13px;
            font-weight: 750;
        }

        .form-group input {
            width: 100%;
            min-height: 48px;
            padding: 12px 17px;
            border: 1px solid #d8e4f2;
            border-radius: 999px;
            outline: none;
            background: #fbfdff;
            color: var(--text);
            font: inherit;
            font-size: 13px;
            transition: .2s ease;
        }

        .form-group input:focus,
        .search-input:focus {
            border-color: #60a5fa;
            background: white;
            box-shadow: 0 0 0 4px rgba(59,130,246,.10);
        }

        .form-group input[type="file"] {
            padding: 7px 12px;
            border-radius: 15px;
        }

        .help-text {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 11px;
            padding: 16px;
            margin-bottom: 24px;
            background: #eaf2fd;
            border: 1px solid #dce9fa;
            border-radius: 20px;
        }

        /* TABLE */
        .table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 18px 24px;
            border-bottom: 1px solid #edf2f8;
        }

        .table-toolbar-title {
            color: var(--muted);
            font-size: 12px;
        }

        .search-wrap {
            position: relative;
            width: min(100%, 370px);
        }

        .search-wrap::before {
            content: "⌕";
            position: absolute;
            left: 16px;
            top: 7px;
            color: #8ba2bf;
            font-size: 23px;
        }

        .search-input {
            width: 100%;
            min-height: 45px;
            padding: 11px 17px 11px 42px;
            border: 1px solid #d8e4f2;
            border-radius: 999px;
            outline: none;
            background: #fbfdff;
            font: inherit;
            font-size: 12px;
            transition: .2s ease;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 960px;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 17px;
            border-bottom: 1px solid #edf2f8;
            text-align: left;
            vertical-align: middle;
            font-size: 13px;
        }

        th {
            color: #526b89;
            background: #f5f9ff;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        tbody tr {
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #f5f9ff;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .dataset-name {
            color: #173f6a;
            font-weight: 750;
            line-height: 1.5;
        }

        .dataset-subname {
            margin-top: 4px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 750;
            white-space: nowrap;
        }

        .badge-green {
            color: #1d4ed8;
            background: #dbeafe;
        }

        .badge-yellow {
            color: #64748b;
            background: #edf2f7;
        }

        .badge-blue {
            color: #1d4ed8;
            background: #dbeafe;
        }

        .badge-gray {
            color: #64748b;
            background: #f1f5f9;
        }

        .empty {
            padding: 45px 20px;
            color: var(--muted);
            text-align: center;
        }

        .empty strong {
            display: block;
            margin-bottom: 7px;
            color: #36516f;
        }

        .table-footer {
            padding: 15px 23px;
            color: var(--muted);
            background: #f8fbff;
            border-top: 1px solid #edf2f8;
            font-size: 12px;
        }

        .hidden-by-search {
            display: none !important;
        }

        /* RESPONSIVE */
        @media(max-width: 1000px) {
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .form-grid {
                grid-template-columns: 1fr 1fr;
            }

            .form-grid > div:last-child {
                grid-column: 1 / -1;
            }

            .form-grid .btn {
                width: 100%;
            }
        }

        @media(max-width: 650px) {
            .navbar {
                align-items: flex-start;
                flex-direction: column;
                padding: 15px 18px;
                gap: 13px;
            }

            .nav-links {
                width: 100%;
            }

            .nav-links a {
                padding: 10px 13px;
            }

            .container {
                padding: 22px 13px 35px;
            }

            .page-heading {
                padding: 25px 21px;
                border-radius: 22px;
            }

            .summary-grid {
                gap: 11px;
            }

            .summary-card {
                padding: 16px;
                border-radius: 18px;
            }

            .summary-top {
                font-size: 11px;
            }

            .summary-icon {
                width: 31px;
                height: 31px;
            }

            .number {
                font-size: 27px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-grid > div:last-child {
                grid-column: auto;
            }

            .form-grid .btn {
                width: 100%;
            }

            .panel-header,
            .panel-body {
                padding: 19px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn,
            .action-buttons form,
            .action-buttons form button {
                width: 100%;
            }

            .table-toolbar {
                align-items: stretch;
                flex-direction: column;
                padding: 17px;
            }

            .search-wrap {
                width: 100%;
            }
        }

        @media print {
            body {
                background: white;
            }

            .navbar,
            .breadcrumb,
            .import-card,
            .action-buttons,
            .table-toolbar {
                display: none !important;
            }

            .container {
                max-width: none;
                padding: 0;
            }

            .panel,
            .summary-card {
                box-shadow: none;
                break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="brand-wrap">
            <div class="brand-mark">SD</div>

            <div>
                <div class="brand">Satu Data OPD</div>
                <div class="brand-subtitle">
                    Portal Pengelolaan Data Pemerintah Kota Surakarta
                </div>
            </div>
        </div>

        <div class="nav-links">
            <a href="/dashboard">← Kembali ke Dashboard</a>
            <a href="/dataset" class="active">Dataset</a>
            <a href="/pemetaan">Pemetaan Data</a>
        </div>
    </div>

    <div class="container">

        <!-- BREADCRUMB -->
        <div class="breadcrumb">
            <a href="/dashboard">Dashboard</a>
            <span>›</span>
            <span>Dataset OPD</span>
        </div>

        <!-- PAGE HEADING -->
        <div class="page-heading">
            <div class="heading-content">
                <div class="eyebrow">
                    PORTAL DATA SEKTORAL • PEMERINTAH KOTA SURAKARTA
                </div>

                <h1 class="page-title">Dataset OPD</h1>

                <p class="page-description">
                    Kelola, klasifikasi, dan pantau pemetaan dataset Pemerintah Kota Surakarta.
                </p>
            </div>
        </div>

        <!-- ALERT -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Terjadi kesalahan:</strong>

                <ul style="margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- SUMMARY -->
        @php
            $totalDataset = $datasets->count();
            $totalTerklasifikasi = $datasets->where('status_klasifikasi', 'terklasifikasi')->count();
            $totalBelumKlasifikasi = $datasets->where('status_klasifikasi', 'belum')->count();
            $totalTerpetakan = $datasets->where('status_pemetaan', 'terpetakan')->count();
        @endphp

        <div class="summary-grid">

            <div class="summary-card">
                <div class="summary-top">
                    <span>Total Dataset</span>
                    <span class="summary-icon">DATA</span>
                </div>

                <div class="number">{{ $totalDataset }}</div>
                <div class="summary-note">Dataset tersimpan di sistem</div>
            </div>

            <div class="summary-card">
                <div class="summary-top">
                    <span>Terklasifikasi</span>
                    <span class="summary-icon">OK</span>
                </div>

                <div class="number">{{ $totalTerklasifikasi }}</div>
                <div class="summary-note">Memiliki hasil klasifikasi</div>
            </div>

            <div class="summary-card">
                <div class="summary-top">
                    <span>Belum Terklasifikasi</span>
                    <span class="summary-icon">!</span>
                </div>

                <div class="number">{{ $totalBelumKlasifikasi }}</div>
                <div class="summary-note">Perlu ditinjau lebih lanjut</div>
            </div>

            <div class="summary-card">
                <div class="summary-top">
                    <span>Sudah Dipetakan</span>
                    <span class="summary-icon">MAP</span>
                </div>

                <div class="number">{{ $totalTerpetakan }}</div>
                <div class="summary-note">Sudah masuk pemetaan sektor</div>
            </div>

        </div>

        <!-- IMPORT DATASET -->
        <div class="panel import-card">

            <div class="panel-header">
                <h2>Import Dataset</h2>
                <p>Upload file CSV, TXT, XLS, atau XLSX dan tentukan OPD pemilik dataset.</p>
            </div>

            <div class="panel-body">

                <form action="/dataset/import" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">

                        <div class="form-group">
                            <label for="nama_opd">Nama OPD</label>

                            <input
                                type="text"
                                id="nama_opd"
                                name="nama_opd"
                                list="daftar-opd"
                                placeholder="Contoh: Dinas Sosial"
                                value="{{ old('nama_opd') }}"
                                required
                            >

                            <datalist id="daftar-opd">
                                @foreach ($opds as $opd)
                                    <option value="{{ $opd->nama_opd }}">
                                @endforeach
                            </datalist>

                            <div class="help-text">
                                Pilih OPD dari saran atau ketik nama OPD baru secara manual.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file">File Dataset</label>

                            <input
                                type="file"
                                id="file"
                                name="file"
                                accept=".csv,.txt,.xls,.xlsx"
                                required
                            >

                            <div class="help-text">
                                Format yang didukung: CSV, TXT, XLS, dan XLSX.
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">
                                Import Dataset
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        <!-- ACTION -->
        <div class="action-buttons">

            <form action="/dataset/classify" method="POST" style="display:inline;">
                @csrf

                <button type="submit" class="btn btn-success">
                    Jalankan Klasifikasi
                </button>
            </form>

            <a href="/dataset/belum-terklasifikasi" class="btn btn-secondary">
                Lihat Belum Terklasifikasi
            </a>

            <a href="/pemetaan" class="btn btn-secondary">
                Lihat Pemetaan Data
            </a>

        </div>

        <!-- DATASET TABLE -->
        <div class="panel table-card">

            <div class="panel-header">
                <h2>Daftar Dataset</h2>
                <p>Menampilkan seluruh dataset yang sudah diimport.</p>
            </div>

            <div class="table-toolbar">
                <div class="table-toolbar-title">
                    Gunakan pencarian untuk menyaring daftar dataset yang ditampilkan.
                </div>

                <div class="search-wrap">
                    <input
                        type="search"
                        id="datasetSearch"
                        class="search-input"
                        placeholder="Cari nama dataset, OPD, atau sektor..."
                        aria-label="Cari dataset"
                    >
                </div>
            </div>

            <div class="table-wrapper">
                <table id="datasetTable">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Statistik</th>
                            <th>OPD</th>
                            <th>Sektor</th>
                            <th>Status Klasifikasi</th>
                            <th>Status Pemetaan</th>
                            <th>Skor</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($datasets as $dataset)

                            <tr class="dataset-row">

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="dataset-name">
                                        {{ $dataset->nama_statistik ?: '-' }}
                                    </div>

                                    @if ($dataset->nama_data_sektoral)
                                        <div class="dataset-subname">
                                            {{ $dataset->nama_data_sektoral }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    {{ $dataset->opd->nama_opd ?? '-' }}
                                </td>

                                <td>
                                    @if ($dataset->sektor)
                                        <span class="badge badge-blue">
                                            {{ $dataset->sektor->nama_sektor }}
                                        </span>
                                    @else
                                        <span class="badge badge-gray">
                                            Belum ada sektor
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($dataset->status_klasifikasi === 'terklasifikasi')
                                        <span class="badge badge-green">
                                            Terklasifikasi
                                        </span>
                                    @else
                                        <span class="badge badge-yellow">
                                            Belum
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($dataset->status_pemetaan === 'terpetakan')
                                        <span class="badge badge-green">
                                            Terpetakan
                                        </span>
                                    @else
                                        <span class="badge badge-yellow">
                                            Belum
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $dataset->skor_klasifikasi ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="empty">
                                    <strong>Belum ada dataset yang diimport.</strong>
                                    Import file CSV, TXT, XLS, atau XLSX untuk mulai mengelola dataset.
                                </td>
                            </tr>

                        @endforelse

                        <tr id="searchEmptyRow" style="display:none;">
                            <td colspan="7" class="empty">
                                <strong>Dataset tidak ditemukan</strong>
                                Coba kata kunci lain, misalnya nama OPD atau sektor.
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="table-footer" id="datasetCount">
                Menampilkan {{ $datasets->count() }} dataset.
            </div>

        </div>

    </div>

    <!-- SEARCH DATASET -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('datasetSearch');

            const rows = Array.from(
                document.querySelectorAll('#datasetTable tbody tr.dataset-row')
            );

            const emptyRow = document.getElementById('searchEmptyRow');
            const countLabel = document.getElementById('datasetCount');

            if (!input) return;

            function filterDatasets() {
                const term = input.value.trim().toLocaleLowerCase('id-ID');
                let visible = 0;

                rows.forEach(function (row) {
                    const matches = row.textContent
                        .toLocaleLowerCase('id-ID')
                        .includes(term);

                    row.classList.toggle('hidden-by-search', !matches);

                    if (matches) visible++;
                });

                if (emptyRow) {
                    emptyRow.style.display = visible === 0 ? 'table-row' : 'none';
                }

                if (countLabel) {
                    countLabel.textContent = term
                        ? 'Menampilkan ' + visible + ' dari ' + rows.length + ' dataset yang cocok.'
                        : 'Menampilkan ' + rows.length + ' dataset.';
                }
            }

            input.addEventListener('input', filterDatasets);
        });
    </script>

</body>
</html>
