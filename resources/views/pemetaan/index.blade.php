
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemetaan Data Antar-OPD - Satu Data OPD</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #12345a;
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --blue-light: #eff6ff;
            --blue-pale: #f5f9ff;
            --bg: #f3f7fc;
            --white: #ffffff;
            --text: #24364b;
            --muted: #718096;
            --line: #e3ebf5;
            --shadow: 0 8px 28px rgba(31, 70, 120, .055);
            --radius: 22px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; }

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

        /* MAIN CONTAINER */
        .container {
            max-width: 1480px;
            margin: 0 auto;
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
            pointer-events: none;
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
            max-width: 760px;
            margin-top: 10px;
            color: #dbeafe;
            font-size: 14px;
            line-height: 1.7;
        }

        /* SECTION TITLE */
        .section-title {
            margin: 34px 0 17px;
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 5px;
            height: 21px;
            background: linear-gradient(180deg, #60a5fa, #1d4ed8);
            border-radius: 999px;
        }

        /* BUTTON */
        .btn {
            min-height: 44px;
            padding: 11px 21px;
            border: 1px solid transparent;
            border-radius: 999px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            font-family: inherit;
            font-size: 13px;
            font-weight: 750;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
            box-shadow: 0 5px 13px rgba(37, 99, 235, .16);
            transition: .2s ease;
        }

        .btn:hover {
            background: var(--blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 7px 17px rgba(37, 99, 235, .22);
        }

        .btn-light {
            background: #fff;
            color: #36516f;
            border-color: #dce7f5;
            box-shadow: none;
        }

        .btn-light:hover {
            background: var(--blue-light);
            color: var(--blue);
            border-color: #b9d2f8;
        }

        /* SUMMARY */
        .summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 17px;
        }

        .summary-card {
            min-width: 0;
            padding: 23px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
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

        .summary-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .summary-label {
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 750;
            letter-spacing: .035em;
            text-transform: uppercase;
        }

        .summary-value {
            color: var(--navy);
            font-size: 30px;
            font-weight: 850;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .summary-icon {
            width: 45px;
            height: 45px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: var(--blue-light);
            color: var(--blue);
        }

        .summary-icon svg {
            width: 21px;
            height: 21px;
        }

        .muted {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .summary-note {
            margin: 3px 0 25px;
        }

        /* PANEL */
        .panel {
            min-width: 0;
            padding: 24px;
            margin-bottom: 24px;
            background: white;
            border: 1px solid var(--line);
            border-radius: 23px;
            box-shadow: var(--shadow);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid #edf2f8;
        }

        .panel h3 {
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
        }

        /* RANK LIST */
        .rank-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rank-item {
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr) auto;
            align-items: center;
            gap: 13px;
            padding: 13px 15px;
            background: #f7faff;
            border: 1px solid #edf2fa;
            border-radius: 17px;
            transition: .18s ease;
        }

        .rank-item:hover {
            background: #eff6ff;
            border-color: #dbeafe;
            transform: translateX(2px);
        }

        .rank-number {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 800;
        }

        .rank-name {
            color: var(--navy);
            font-size: 13px;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .rank-count {
            padding: 6px 13px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* TWO COLUMN */
        .grid-two {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .grid-two .panel {
            margin-bottom: 0;
        }

        /* SEARCH */
        .search-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 17px;
        }

        .search-input-wrapper {
            position: relative;
            flex: 1;
            min-width: 0;
        }

        .search-input-wrapper svg {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search-form input {
            width: 100%;
            min-height: 47px;
            padding: 12px 18px 12px 46px;
            border: 1px solid #d8e4f2;
            border-radius: 999px;
            outline: none;
            background: #fbfdff;
            color: var(--text);
            font-family: inherit;
            font-size: 13px;
            transition: .2s ease;
        }

        .search-form input:focus {
            background: white;
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(59,130,246,.10);
        }

        /* TABLE */
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 17px;
            margin-top: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 12.5px;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid #edf2f8;
        }

        th {
            background: #f3f8ff;
            color: #526b89;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .035em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        td {
            color: #40566f;
            overflow-wrap: anywhere;
        }

        tbody tr {
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #f5f9ff;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 11px;
            border-radius: 999px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #1d4ed8;
            font-size: 10.5px;
            font-weight: 750;
            white-space: nowrap;
        }

        .badge-terpetakan {
            background: #dbeafe;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }

        .badge-belum {
            background: #f1f5f9;
            border-color: #e2e8f0;
            color: #64748b;
        }

        /* PAGINATION */
        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 20px;
        }

        .pagination nav {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            min-height: 36px;
            padding: 0 12px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: white;
            color: var(--text);
            text-decoration: none;
            font-size: 12px;
            font-weight: 650;
        }

        .pagination .active span {
            background: var(--blue);
            color: white;
            border-color: var(--blue);
        }

        /* EMPTY STATE */
        .empty {
            padding: 32px;
            text-align: center;
            color: var(--muted);
        }

        /* OPD CARD */
        .opd {
            overflow: hidden;
            margin-bottom: 20px;
            background: white;
            border: 1px solid var(--line);
            border-radius: 22px;
            box-shadow: var(--shadow);
        }

        .opd-header {
            padding: 20px 24px;
            background: #f3f8ff;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .opd-name {
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .opd-total {
            flex-shrink: 0;
            padding: 6px 13px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 800;
        }

        .sector {
            padding: 20px 24px;
            border-bottom: 1px solid #edf2f8;
        }

        .sector:last-child {
            border-bottom: none;
        }

        .sector-header {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 13px;
        }

        .sector-name {
            color: var(--navy);
            font-size: 14px;
            font-weight: 750;
        }

        .dataset-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 10px;
        }

        .dataset-item {
            padding: 13px 16px;
            background: #f7faff;
            border: 1px solid #e5edf8;
            border-radius: 15px;
            color: #40566f;
            font-size: 12.5px;
            overflow-wrap: anywhere;
            transition: .18s ease;
        }

        .dataset-item:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grid-two {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
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

            .summary {
                grid-template-columns: 1fr;
                gap: 11px;
            }

            .summary-card {
                padding: 18px;
                border-radius: 18px;
            }

            .summary-value {
                font-size: 27px;
            }

            .panel {
                padding: 18px;
            }

            .search-form {
                align-items: stretch;
                flex-direction: column;
            }

            .search-form .btn {
                width: 100%;
            }

            .dataset-list {
                grid-template-columns: 1fr;
            }

            .opd-header,
            .sector {
                padding: 17px;
            }

            .rank-item {
                gap: 9px;
                padding: 11px;
            }
        }

        @media print {
            body { background: white; }

            .navbar,
            .breadcrumb,
            .search-form {
                display: none !important;
            }

            .container {
                max-width: none;
                padding: 0;
            }

            .panel,
            .summary-card,
            .opd {
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
        <a href="/dashboard">Dashboard</a>
        <a href="/dataset">Dataset</a>
        <a href="/pemetaan" class="active">Pemetaan Data</a>
    </div>
</div>

<main class="container">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="/dashboard">Dashboard</a>
        <span>›</span>
        <span>Pemetaan Data Antar-OPD</span>
    </div>

    <!-- PAGE HEADING -->
    <div class="page-heading">
        <div class="heading-content">
            <div class="eyebrow">
                PORTAL DATA SEKTORAL • PEMERINTAH KOTA SURAKARTA
            </div>

            <h1 class="page-title">Pemetaan Data Antar-OPD</h1>

            <p class="page-description">
                Pemetaan dataset, sektor, dan catatan keterkaitan antar-OPD secara terpadu.
            </p>
        </div>
    </div>

    <!-- RINGKASAN RELASI -->
    <h2 class="section-title">Ringkasan Relasi Antar-OPD</h2>

    <div class="summary">

        <div class="summary-card">
            <div class="summary-info">
                <span class="summary-label">Total Catatan Relasi</span>
                <span class="summary-value">
                    {{ number_format($totalRelasi, 0, ',', '.') }}
                </span>
            </div>

            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-info">
                <span class="summary-label">OPD Pemilik</span>
                <span class="summary-value">
                    {{ number_format($totalOpdPemilik, 0, ',', '.') }}
                </span>
            </div>

            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-info">
                <span class="summary-label">OPD Terkait</span>
                <span class="summary-value">
                    {{ number_format($totalOpdTerkait, 0, ',', '.') }}
                </span>
            </div>

            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="18" cy="5" r="3"/>
                    <circle cx="6" cy="12" r="3"/>
                    <circle cx="18" cy="19" r="3"/>
                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                </svg>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-info">
                <span class="summary-label">Pasangan OPD Unik</span>
                <span class="summary-value">
                    {{ number_format($totalPasanganOpd, 0, ',', '.') }}
                </span>
            </div>

            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                </svg>
            </div>
        </div>

    </div>

    <p class="muted summary-note">
        Angka di atas menunjukkan catatan keterkaitan yang tercatat di sumber Excel,
        bukan bukti penggunaan atau integrasi data yang sudah terverifikasi.
    </p>

    <!-- ANALISIS KETERKAITAN -->
    <h2 class="section-title">Analisis Keterkaitan</h2>

    <div class="grid-two">

        <section class="panel">
            <div class="panel-header">
                <h3>10 OPD Pemilik dengan Catatan Relasi Terbanyak</h3>
            </div>

            <div class="rank-list">
                @forelse ($topPemilik as $item)
                    <div class="rank-item">
                        <div class="rank-number">{{ $loop->iteration }}</div>

                        <div>
                            <div class="rank-name">
                                {{ $item->nama_opd_pemilik }}
                            </div>
                            <div class="muted">
                                {{ $item->kode_opd_pemilik_sumber }}
                            </div>
                        </div>

                        <div class="rank-count">
                            {{ number_format($item->jumlah_relasi, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="empty">Belum ada data relasi.</div>
                @endforelse
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h3>10 OPD Terkait yang Paling Sering Disebut</h3>
            </div>

            <div class="rank-list">
                @forelse ($topTerkait as $item)
                    <div class="rank-item">
                        <div class="rank-number">{{ $loop->iteration }}</div>

                        <div>
                            <div class="rank-name">
                                {{ $item->nama_opd_terkait }}
                            </div>
                            <div class="muted">
                                {{ $item->kode_opd_terkait_sumber }}
                            </div>
                        </div>

                        <div class="rank-count">
                            {{ number_format($item->jumlah_relasi, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="empty">Belum ada data relasi.</div>
                @endforelse
            </div>
        </section>

    </div>

    <!-- PASANGAN OPD -->
    <section class="panel">
        <div class="panel-header">
            <h3>10 Pasangan OPD dengan Catatan Relasi Terbanyak</h3>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th>OPD Pemilik</th>
                        <th>OPD Terkait</th>
                        <th style="text-align: right;">Jumlah Catatan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($topPasangan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $item->nama_opd_pemilik }}</strong>
                                <div class="muted">
                                    {{ $item->kode_opd_pemilik_sumber }}
                                </div>
                            </td>

                            <td>
                                <strong>{{ $item->nama_opd_terkait }}</strong>
                                <div class="muted">
                                    {{ $item->kode_opd_terkait_sumber }}
                                </div>
                            </td>

                            <td style="text-align: right;">
                                <span class="rank-count">
                                    {{ number_format($item->jumlah_relasi, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">
                                Belum ada data relasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- DAFTAR RELASI -->
    <h2 class="section-title">Daftar Catatan Relasi Antar-OPD</h2>

    <section class="panel">

        <form method="GET" action="{{ url('/pemetaan') }}" class="search-form">

            <div class="search-input-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>

                <input
                    type="text"
                    name="q"
                    value="{{ $kataKunci }}"
                    placeholder="Cari nama OPD, kode OPD, atau nama data..."
                >
            </div>

            <button class="btn" type="submit">Cari</button>

            @if ($kataKunci !== '')
                <a class="btn btn-light" href="{{ url('/pemetaan') }}">
                    Reset
                </a>
            @endif

        </form>

        <p class="muted">
            Menampilkan {{ $relasi->firstItem() ?? 0 }}–{{ $relasi->lastItem() ?? 0 }}
            dari {{ number_format($relasi->total(), 0, ',', '.') }} catatan.
        </p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th>OPD Pemilik</th>
                        <th>Nama Data</th>
                        <th>Instansi Pendukung (Sumber)</th>
                        <th>OPD Terkait</th>
                        <th>Dasar Relasi</th>
                        <th>Status Bukti</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($relasi as $item)
                        <tr>
                            <td>{{ $relasi->firstItem() + $loop->index }}</td>

                            <td>
                                <strong>{{ $item->nama_opd_pemilik }}</strong>
                                <div class="muted">
                                    {{ $item->kode_opd_pemilik_sumber }}
                                </div>
                            </td>

                            <td>
                                {{ $item->nama_data_sumber ?: 'Tidak tersedia' }}
                            </td>

                            <td>{{ $item->instansi_pendukung_raw }}</td>

                            <td>
                                <strong>{{ $item->nama_opd_terkait }}</strong>
                                <div class="muted">
                                    {{ $item->kode_opd_terkait_sumber }}
                                </div>
                            </td>

                            <td>
                                {{ $item->dasar_relasi ?: 'Tidak dicantumkan' }}
                            </td>

                            <td>
                                <span class="badge">Belum terverifikasi</span>
                                <div class="muted" style="margin-top: 4px;">
                                    {{ $item->status_bukti }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">
                                Tidak ada catatan yang cocok dengan pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $relasi->links() }}
        </div>

    </section>

    <!-- PEMETAAN DATA BERDASARKAN SEKTOR -->
    <h2 class="section-title">Pemetaan Dataset Berdasarkan Sektor</h2>

    <div class="summary">

        <div class="summary-card">
            <div class="summary-info">
                <span class="summary-label">Total Dataset Aplikasi</span>
                <span class="summary-value">
                    {{ number_format($totalDataset, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-info">
                <span class="summary-label">Terpetakan ke Sektor</span>
                <span class="summary-value">
                    {{ number_format($totalTerpetakan, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-info">
                <span class="summary-label">Belum Terpetakan ke Sektor</span>
                <span class="summary-value">
                    {{ number_format($totalBelumTerpetakan, 0, ',', '.') }}
                </span>
            </div>
        </div>

    </div>

    <!-- KELOMPOK DATASET PER OPD -->
    @forelse ($opds as $opd)

        <div class="opd">

            <div class="opd-header">
                <h2 class="opd-name">{{ $opd->nama_opd }}</h2>

                <p class="opd-total">
                    {{ $opd->datasets->count() }} dataset
                </p>
            </div>

            @php
                $kelompokSektor = $opd->datasets->groupBy(function ($dataset) {
                    return $dataset->sektor->nama_sektor ?? 'Belum Terpetakan';
                });
            @endphp

            @forelse ($kelompokSektor as $namaSektor => $datasets)

                <div class="sector">

                    <div class="sector-header">
                        <h3 class="sector-name">{{ $namaSektor }}</h3>

                        @if ($namaSektor === 'Belum Terpetakan')
                            <span class="badge badge-belum">
                                Belum Terpetakan
                            </span>
                        @else
                            <span class="badge badge-terpetakan">
                                Terpetakan
                            </span>
                        @endif
                    </div>

                    <div class="dataset-list">
                        @foreach ($datasets as $dataset)
                            <div class="dataset-item">
                                {{ $dataset->nama_statistik ?? 'Nama dataset tidak tersedia' }}
                            </div>
                        @endforeach
                    </div>

                </div>

            @empty
                <div class="empty">
                    OPD ini belum memiliki dataset di aplikasi.
                </div>
            @endforelse

        </div>

    @empty
        <div class="panel empty">
            Belum ada data OPD pada master aplikasi.
        </div>
    @endforelse

</main>

</body>
</html>
