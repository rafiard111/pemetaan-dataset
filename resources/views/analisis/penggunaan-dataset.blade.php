
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Penggunaan Dataset Antar-OPD</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #172033;
        }

        .container {
            max-width: 1250px;
            margin: auto;
            padding: 32px 24px;
        }

        .back {
            color: #475467;
            text-decoration: none;
            font-size: 14px;
        }

        h1 {
            margin: 18px 0 8px;
            font-size: 28px;
        }

        .subtitle {
            color: #667085;
            line-height: 1.6;
            margin-bottom: 26px;
        }

        .notice {
            background: #fff8e7;
            border: 1px solid #f5d98b;
            color: #805b12;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        input, select {
            padding: 12px 14px;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
            background: white;
            font-size: 14px;
        }

        input {
            flex: 1;
            min-width: 220px;
        }

        select {
            min-width: 230px;
        }

        button {
            border: 0;
            background: #155eef;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .card {
            background: white;
            border: 1px solid #eaecf0;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: 0 2px 8px rgba(16, 24, 40, .03);
        }

        .card h2 {
            font-size: 18px;
            margin: 0 0 6px;
        }

        .muted {
            color: #667085;
            font-size: 13px;
            line-height: 1.5;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            min-width: 750px;
        }

        th, td {
            text-align: left;
            padding: 15px 12px;
            border-bottom: 1px solid #eaecf0;
            font-size: 13px;
            vertical-align: top;
        }

        th {
            color: #667085;
            background: #f9fafb;
            font-weight: 600;
        }

        td strong {
            display: block;
            margin-bottom: 5px;
        }

        .number {
            font-weight: 700;
            color: #155eef;
        }

        .detail-link {
            color: #155eef;
            font-weight: 600;
            text-decoration: none;
        }

        .detail-link:hover {
            text-decoration: underline;
        }

        .tag {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #eef4ff;
            color: #3538cd;
            font-size: 11px;
            margin: 3px 3px 3px 0;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 18px;
        }

        .detail-box {
            background: #f9fafb;
            padding: 16px;
            border-radius: 9px;
        }

        .detail-box h3 {
            font-size: 13px;
            color: #667085;
            margin: 0 0 10px;
        }

        .detail-box p {
            margin: 0;
            font-weight: 600;
        }

        .opd-item {
            padding: 12px 0;
            border-bottom: 1px solid #eaecf0;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 13px;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #667085;
        }

        @media(max-width: 650px) {
            .container {
                padding: 22px 14px;
            }

            h1 {
                font-size: 23px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            select, input, button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <a href="{{ url('/analisis') }}" class="back">
        ← Kembali ke Analisis Data
    </a>

    <h1>Analisis Penggunaan Dataset Antar-OPD</h1>

    <p class="subtitle">
        Menelusuri asal dataset dan OPD lain yang tercatat memiliki
        keterkaitan dengan dataset tersebut.
    </p>

    <div class="notice">
        <strong>Catatan interpretasi:</strong>
        Data pada halaman ini berasal dari catatan instansi pendukung.
        Jumlah yang ditampilkan merupakan jumlah catatan keterkaitan,
        bukan jumlah penggunaan aktual dataset.
    </div>

    <form method="GET" action="{{ route('analisis.penggunaan-dataset') }}"
          class="filters">

        <input
            type="search"
            name="search"
            placeholder="Cari nama dataset atau OPD..."
            value="{{ $search }}"
        >

        <select name="opd">
            <option value="">Semua OPD pemilik</option>

            @foreach($daftarOpd as $opd)
                <option
                    value="{{ $opd->kode_opd_pemilik_sumber }}"
                    {{ $opdTerpilih == $opd->kode_opd_pemilik_sumber ? 'selected' : '' }}
                >
                    {{ $opd->nama_opd_pemilik }}
                </option>
            @endforeach
        </select>

        <button type="submit">Terapkan Filter</button>
    </form>

    @if($detailDataset)
        <section class="card">
            <h2>Detail Keterkaitan Dataset</h2>

            <p class="muted">
                Informasi asal dataset dan OPD yang tercatat terkait.
            </p>

            <h3 style="margin-top:22px">
                {{ $detailDataset['nama_dataset'] }}
            </h3>

            <div class="detail-grid">
                <div class="detail-box">
                    <h3>OPD Pemilik / Sumber</h3>
                    <p>{{ $detailDataset['nama_opd'] }}</p>
                    <span class="muted">{{ $detailDataset['kode_opd'] }}</span>
                </div>

                <div class="detail-box">
                    <h3>Jumlah OPD Terkait</h3>
                    <p>{{ $detailDataset['jumlah_opd_terkait'] }} OPD</p>
                </div>
            </div>

            <h3 style="margin-top:25px">Daftar OPD Terkait</h3>

            @forelse($detailDataset['opd_terkait'] as $opd)
                <div class="opd-item">
                    <div>
                        <strong>{{ $opd['nama'] }}</strong>
                        <div class="muted">{{ $opd['kode'] }}</div>
                    </div>

                    <div>
                        <span class="number">
                            {{ $opd['jumlah_catatan'] }}
                        </span>
                        <span class="muted">catatan</span>
                    </div>
                </div>
            @empty
                <p class="muted">Belum ada OPD terkait.</p>
            @endforelse
        </section>
    @endif

    <section class="card">
        <h2>Daftar Dataset dan OPD Terkait</h2>

        <p class="muted">
            Dataset diurutkan berdasarkan jumlah OPD terkait terbanyak.
        </p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Dataset</th>
                        <th>OPD Pemilik</th>
                        <th>Jumlah OPD Terkait</th>
                        <th>Jumlah Catatan</th>
                        <th>Detail</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($datasetList as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <strong>{{ $item['nama_dataset'] }}</strong>
                            </td>

                            <td>
                                {{ $item['nama_opd'] }}
                                <div class="muted">{{ $item['kode_opd'] }}</div>
                            </td>

                            <td>
                                <span class="number">
                                    {{ $item['jumlah_opd_terkait'] }}
                                </span>
                                OPD
                            </td>

                            <td>
                                {{ $item['jumlah_catatan'] }}
                            </td>

                            <td>
                                <a
                                    class="detail-link"
                                    href="{{ route('analisis.penggunaan-dataset', [
                                        'opd' => $opdTerpilih,
                                        'search' => $search,
                                        'dataset' => $item['nama_dataset'],
                                        'pemilik' => $item['kode_opd']
                                    ]) }}"
                                >
                                    Lihat detail →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Dataset tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
</body>
</html>
