<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Opd;
use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AnalisisController extends Controller
{
    public function index(Request $request)
    {
        // ==============================
        // DATA UTAMA
        // ==============================

        $totalDataset = Dataset::count();

        $totalTerklasifikasi = Dataset::where(
            'status_klasifikasi',
            'terklasifikasi'
        )->count();

        $totalBelumTerklasifikasi = Dataset::where(
            'status_klasifikasi',
            'belum'
        )->count();

        $totalTerpetakan = Dataset::whereNotNull(
            'sektor_id'
        )->count();

        $totalBelumTerpetakan = Dataset::whereNull(
            'sektor_id'
        )->count();

        $totalSektor = Sektor::count();
        $totalOpd = Opd::count();

        // ==============================
        // PERSENTASE KLASIFIKASI
        // ==============================

        $persentaseTerklasifikasi = $totalDataset > 0
            ? round(
                ($totalTerklasifikasi / $totalDataset) * 100,
                1
            )
            : 0;

        // ==============================
        // PERSENTASE PEMETAAN
        // ==============================

        $persentaseTerpetakan = $totalDataset > 0
            ? round(
                ($totalTerpetakan / $totalDataset) * 100,
                1
            )
            : 0;

        // ==============================
        // DISTRIBUSI SEKTOR
        // ==============================

        $distribusiSektor = Sektor::withCount('datasets')
            ->orderByDesc('datasets_count')
            ->get();

        $maksDatasetSektor = max(
            1,
            (int) $distribusiSektor->max('datasets_count')
        );

        // ==============================
        // DISTRIBUSI OPD
        // ==============================

        $distribusiOpd = Opd::withCount('datasets')
            ->orderByDesc('datasets_count')
            ->take(10)
            ->get();

        // ==============================
        // KUALITAS / KELENGKAPAN DATA
        // ==============================

        $kolomWajib = [
            'deskripsi_data',
            'tujuan_pengumpulan_data',
            'format_data_saat_ini',
            'frekuensi_update',
        ];

        // Definisi "kosong" disamakan dengan export():
        // NULL, hanya spasi/enter/tab, atau hanya tanda "-".
        $fieldKosong = [];

        foreach ($kolomWajib as $kolom) {
            $fieldKosong[$kolom] = Dataset::where(function ($query) use ($kolom) {
                $this->kondisiKosong($query, $kolom);
            })->count();
        }

        // ==============================
        // DATASET YANG PERLU DILENGKAPI
        // ==============================
        // Perlu dilengkapi bila salah satu kolom wajib kosong.

        $datasetPerluDilengkapi = Dataset::where(function ($query) use ($kolomWajib) {
            foreach ($kolomWajib as $kolom) {
                $this->kondisiKosong($query, $kolom);
            }
        })->count();

        // ==============================
        // PERSENTASE KELENGKAPAN
        // ==============================

        $persentaseLengkap = $totalDataset > 0
            ? round(
                (($totalDataset - $datasetPerluDilengkapi)
                / $totalDataset) * 100,
                1
            )
            : 0;

        // ==============================
        // SEKTOR TERBANYAK
        // ==============================

        $sektorTerbanyak = $distribusiSektor->first();

        // ==============================
        // OPD TERBANYAK
        // ==============================

        $opdTerbanyak = $distribusiOpd->first();


        // =========================================================
        // ANALISIS RELASI ANTAR-OPD (KANDIDAT, BELUM TERVERIFIKASI)
        // =========================================================
        //
        // [PERBAIKAN] Kode OPD di tabel opd masih NULL, sehingga query
        // berbasis kode_opd_* selalu kosong. Sekarang OPD dikenali dari
        // NAMA OPD (nama_opd_pemilik / nama_opd_terkait), dan target
        // "Belum teridentifikasi" tidak dihitung sebagai OPD terkait.
        //
        $relasiTersedia = Schema::hasTable('relasi_pendukung_sumber');

        $kataKunciRelasi = trim((string) $request->query('q', ''));
        $filterOpdTerkait = trim((string) $request->query('opd_terkait', ''));

        $totalCatatanRelasi = 0;
        $totalKandidatBerulang = 0;
        $totalOpdTerkait = 0;
        $kandidatRelasi = collect();
        $peringkatOpdTerkait = collect();
        $opsiOpdTerkait = collect();
        $kandidatMaster = collect();
        $kandidatDuplikat = collect();
        $detailNamaDuplikat = '';
        $detailDuplikat = collect();

        // [PERBAIKAN] Penanda OPD terkait yang belum dikenali.
        $belumTeridentifikasi = 'Belum teridentifikasi';

        // [PERBAIKAN] Ekspresi SQL: hitung OPD terkait hanya jika sudah dikenali.
        $opdTerkaitValid = "CASE
            WHEN nama_opd_terkait IS NULL
              OR TRIM(nama_opd_terkait) = ''
              OR nama_opd_terkait = '{$belumTeridentifikasi}'
            THEN NULL
            ELSE nama_opd_terkait
        END";

        if ($relasiTersedia) {
            $totalCatatanRelasi = DB::table('relasi_pendukung_sumber')->count();

            $totalKandidatBerulang = DB::table('relasi_pendukung_sumber')
                ->whereNotNull('nama_data_sumber')
                ->whereRaw("TRIM(nama_data_sumber) <> ''")
                ->selectRaw("COUNT(DISTINCT CONCAT(nama_opd_pemilik, '|', LOWER(TRIM(nama_data_sumber)))) AS total")
                ->value('total') ?? 0;

            // [PERBAIKAN] Hitung berdasarkan nama OPD terkait yang dikenali.
            $totalOpdTerkait = DB::table('relasi_pendukung_sumber')
                ->whereNotNull('nama_opd_terkait')
                ->whereRaw("TRIM(nama_opd_terkait) <> ''")
                ->where('nama_opd_terkait', '<>', $belumTeridentifikasi)
                ->distinct()
                ->count('nama_opd_terkait');

            // [PERBAIKAN] Kelompokkan per nama OPD pemilik, bukan kode.
            $queryKandidat = DB::table('relasi_pendukung_sumber')
                ->selectRaw("
                    MIN(kode_opd_pemilik_sumber) AS kode_opd_pemilik_sumber,
                    nama_opd_pemilik,
                    LOWER(TRIM(nama_data_sumber)) AS nama_data_normal,
                    MIN(TRIM(nama_data_sumber)) AS nama_data_sumber,
                    COUNT(*) AS jumlah_catatan,
                    COUNT(DISTINCT {$opdTerkaitValid}) AS jumlah_opd_terkait,
                    GROUP_CONCAT(DISTINCT nama_opd_terkait ORDER BY nama_opd_terkait SEPARATOR ' | ') AS daftar_opd_terkait,
                    GROUP_CONCAT(DISTINCT nama_opd_pemilik ORDER BY nama_opd_pemilik SEPARATOR ' | ') AS daftar_opd_pemilik,
                    GROUP_CONCAT(DISTINCT dasar_relasi ORDER BY dasar_relasi SEPARATOR ' | ') AS dasar_relasi
                ")
                ->whereNotNull('nama_data_sumber')
                ->whereRaw("TRIM(nama_data_sumber) <> ''")
                ->whereNotNull('nama_opd_pemilik')
                ->whereRaw("TRIM(nama_opd_pemilik) <> ''")
                ->groupBy('nama_opd_pemilik')
                ->groupByRaw('LOWER(TRIM(nama_data_sumber))');

            if ($kataKunciRelasi !== '') {
                $queryKandidat->where(function ($query) use ($kataKunciRelasi) {
                    $query->where('nama_data_sumber', 'like', '%' . $kataKunciRelasi . '%')
                        ->orWhere('nama_opd_pemilik', 'like', '%' . $kataKunciRelasi . '%')
                        ->orWhere('nama_opd_terkait', 'like', '%' . $kataKunciRelasi . '%');
                });
            }

            // [PERBAIKAN] Filter memakai nama OPD terkait
            // (nilai dropdown sekarang berisi nama OPD, lihat $opsiOpdTerkait).
            if ($filterOpdTerkait !== '') {
                $queryKandidat->where('nama_opd_terkait', $filterOpdTerkait);
            }

            $kandidatRelasi = $queryKandidat
                ->orderByDesc('jumlah_opd_terkait')
                ->orderByDesc('jumlah_catatan')
                ->paginate(15)
                ->withQueryString();

            // [PERBAIKAN] Peringkat OPD terkait berdasarkan nama.
            $peringkatOpdTerkait = DB::table('relasi_pendukung_sumber')
                ->selectRaw("
                    MIN(kode_opd_terkait_sumber) AS kode_opd_terkait_sumber,
                    nama_opd_terkait,
                    COUNT(*) AS jumlah_catatan_relasi,
                    COUNT(DISTINCT nama_opd_pemilik) AS jumlah_opd_pemilik,
                    COUNT(DISTINCT CONCAT(nama_opd_pemilik, '|', LOWER(TRIM(nama_data_sumber)))) AS jumlah_kandidat_dataset
                ")
                ->whereNotNull('nama_opd_terkait')
                ->whereRaw("TRIM(nama_opd_terkait) <> ''")
                ->where('nama_opd_terkait', '<>', $belumTeridentifikasi)
                ->whereNotNull('nama_opd_pemilik')
                ->whereNotNull('nama_data_sumber')
                ->whereRaw("TRIM(nama_data_sumber) <> ''")
                ->groupBy('nama_opd_terkait')
                ->orderByDesc('jumlah_opd_pemilik')
                ->orderByDesc('jumlah_kandidat_dataset')
                ->orderByDesc('jumlah_catatan_relasi')
                ->limit(15)
                ->get();

            // [PERBAIKAN] Nilai dropdown = nama OPD (kolom tetap bernama
            // kode_opd_terkait_sumber agar view tidak perlu diubah).
            $opsiOpdTerkait = DB::table('relasi_pendukung_sumber')
                ->selectRaw('nama_opd_terkait AS kode_opd_terkait_sumber, nama_opd_terkait')
                ->whereNotNull('nama_opd_terkait')
                ->whereRaw("TRIM(nama_opd_terkait) <> ''")
                ->where('nama_opd_terkait', '<>', $belumTeridentifikasi)
                ->groupBy('nama_opd_terkait')
                ->orderBy('nama_opd_terkait')
                ->get();

            // Kandidat dataset yang berpotensi menjadi sumber/master:
            // satu pemilik dan nama dataset yang tercatat terkait dengan >= 2 OPD.
            // [PERBAIKAN] Dihitung dari nama OPD terkait yang sudah dikenali.
            $kandidatMaster = DB::table('relasi_pendukung_sumber')
                ->selectRaw("
                    MIN(kode_opd_pemilik_sumber) AS kode_opd_pemilik_sumber,
                    nama_opd_pemilik,
                    LOWER(TRIM(nama_data_sumber)) AS nama_data_normal,
                    MIN(TRIM(nama_data_sumber)) AS nama_data_sumber,
                    COUNT(DISTINCT {$opdTerkaitValid}) AS jumlah_opd_terkait,
                    COUNT(*) AS jumlah_catatan,
                    GROUP_CONCAT(DISTINCT {$opdTerkaitValid} ORDER BY nama_opd_terkait SEPARATOR ' | ') AS daftar_opd_terkait
                ")
                ->whereNotNull('nama_data_sumber')
                ->whereRaw("TRIM(nama_data_sumber) <> ''")
                ->whereNotNull('nama_opd_pemilik')
                ->whereRaw("TRIM(nama_opd_pemilik) <> ''")
                ->groupBy('nama_opd_pemilik')
                ->groupByRaw('LOWER(TRIM(nama_data_sumber))')
                ->havingRaw("COUNT(DISTINCT {$opdTerkaitValid}) >= 2")
                ->orderByDesc('jumlah_opd_terkait')
                ->orderByDesc('jumlah_catatan')
                ->limit(15)
                ->get();

            // Detail kandidat duplikat yang dipilih pengguna.
            // Nama dinormalisasi hanya untuk pencarian; catatan sumber tetap ditampilkan apa adanya.
            $detailNamaDuplikat = trim((string) $request->query('detail_duplikat', ''));
            if ($detailNamaDuplikat !== '') {
                $detailDuplikat = DB::table('relasi_pendukung_sumber')
                    ->select([
                        'id',
                        'kode_opd_pemilik_sumber',
                        'nama_opd_pemilik',
                        'nama_data_sumber',
                        'kode_opd_terkait_sumber',
                        'nama_opd_terkait',
                        'dasar_relasi',
                        'status_bukti',
                    ])
                    ->whereNotNull('nama_data_sumber')
                    ->whereRaw('LOWER(TRIM(nama_data_sumber)) = ?', [$detailNamaDuplikat])
                    ->orderBy('nama_opd_pemilik')
                    ->orderBy('nama_opd_terkait')
                    ->paginate(50, ['*'], 'detail_page')
                    ->withQueryString();
            }
        }

        // =========================================================
        // KANDIDAT DUPLIKAT BERDASARKAN KESAMAAN NAMA
        // =========================================================
        //
        // [PERBAIKAN] Sebelumnya hanya membaca tabel relasi (dan butuh
        // kode OPD), sehingga dataset tanpa relasi tidak pernah dicek.
        // Sekarang dihitung langsung dari tabel datasets + opd.
        // Nama yang dipakai sama dengan nama sumber relasi:
        // nama_data_sektoral, atau nama_statistik jika kosong.
        //
        $namaDatasetNormal = "LOWER(TRIM(COALESCE(NULLIF(TRIM(d.nama_data_sektoral), ''), d.nama_statistik)))";
        $namaDatasetAsli = "TRIM(COALESCE(NULLIF(TRIM(d.nama_data_sektoral), ''), d.nama_statistik))";

        $kandidatDuplikat = DB::table('datasets as d')
            ->join('opd as o', 'o.id', '=', 'd.opd_id')
            ->selectRaw("
                {$namaDatasetNormal} AS nama_data_normal,
                MIN({$namaDatasetAsli}) AS nama_data_sumber,
                COUNT(DISTINCT d.opd_id) AS jumlah_opd_pemilik,
                COUNT(*) AS jumlah_catatan,
                GROUP_CONCAT(DISTINCT o.nama_opd ORDER BY o.nama_opd SEPARATOR ' | ') AS daftar_opd_pemilik,
                NULL AS daftar_opd_terkait
            ")
            ->whereRaw("{$namaDatasetNormal} IS NOT NULL")
            ->whereRaw("{$namaDatasetNormal} <> ''")
            // Group berdasarkan alias agar lolos mode ONLY_FULL_GROUP_BY MySQL.
            ->groupBy('nama_data_normal')
            ->havingRaw('COUNT(DISTINCT d.opd_id) >= 2')
            ->orderByDesc('jumlah_opd_pemilik')
            ->orderByDesc('jumlah_catatan')
            ->limit(20)
            ->get();

        return view('analisis.index', compact(

            'totalDataset',

            'totalTerklasifikasi',
            'totalBelumTerklasifikasi',

            'totalTerpetakan',
            'totalBelumTerpetakan',

            'totalSektor',
            'totalOpd',

            'persentaseTerklasifikasi',
            'persentaseTerpetakan',

            'distribusiSektor',
            'maksDatasetSektor',

            'distribusiOpd',

            'fieldKosong',

            'datasetPerluDilengkapi',
            'persentaseLengkap',

            'sektorTerbanyak',
            'opdTerbanyak',

            'relasiTersedia',
            'kataKunciRelasi',
            'filterOpdTerkait',
            'totalCatatanRelasi',
            'totalKandidatBerulang',
            'totalOpdTerkait',
            'kandidatRelasi',
            'peringkatOpdTerkait',
            'opsiOpdTerkait',
            'kandidatMaster',
            'kandidatDuplikat',
            'detailNamaDuplikat',
            'detailDuplikat'

        ));
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT HASIL ANALISIS
    |--------------------------------------------------------------------------
    |
    | Export dibuat sebagai SATU tabel CSV.
    | Tidak ada lagi ringkasan, distribusi sektor, distribusi OPD,
    | dan detail dataset yang dicampur dalam satu file.
    |
    */

    public function export()
    {
        // ==============================
        // AMBIL SEMUA DATASET
        // ==============================

        $datasets = Dataset::with([
            'opd',
            'sektor'
        ])
            ->orderBy('id')
            ->get();

        // ==============================
        // NAMA FILE
        // ==============================

        $namaFile = 'hasil_analisis_dataset_opd_'
            . date('Y-m-d_H-i-s')
            . '.csv';

        // ==============================
        // DOWNLOAD CSV
        // ==============================

        return response()->streamDownload(
            function () use ($datasets) {

                // UTF-8 BOM agar Excel membaca karakter
                // Bahasa Indonesia dengan benar.
                echo "\xEF\xBB\xBF";

                $handle = fopen('php://output', 'w');

                /*
                 * Memberi tahu Excel bahwa separator yang digunakan
                 * adalah koma. Ini membantu Excel dengan konfigurasi
                 * regional yang berbeda.
                 */
                echo "sep=,\r\n";

                // ==============================
                // HEADER TABEL
                // ==============================

                fputcsv(
                    $handle,
                    [
                        'No',
                        'Nama Dataset',
                        'OPD',
                        'Sektor',
                        'Deskripsi Data',
                        'Tujuan Pengumpulan Data',
                        'Format Data Saat Ini',
                        'Frekuensi Update',
                        'Status Klasifikasi',
                        'Skor Klasifikasi',
                        'Status Pemetaan',
                        'Kelengkapan Metadata'
                    ],
                    ',',
                    '"',
                    '\\'
                );

                // ==============================
                // DATA DATASET
                // ==============================

                $no = 1;

                foreach ($datasets as $dataset) {

                    // ==============================
                    // NAMA DATASET
                    // ==============================

                    $namaDataset = $dataset->nama_statistik
                        ?: (
                            $dataset->nama_data_sektoral
                            ?: 'Dataset tanpa nama'
                        );

                    // ==============================
                    // OPD
                    // ==============================

                    $namaOpd = $dataset->opd
                        ? $dataset->opd->nama_opd
                        : 'OPD belum tersedia';

                    // ==============================
                    // SEKTOR
                    // ==============================

                    $namaSektor = $dataset->sektor
                        ? $dataset->sektor->nama_sektor
                        : 'Belum dipetakan';

                    // ==============================
                    // BERSIHKAN DATA TEKS
                    // ==============================
                    //
                    // Enter di dalam data dapat membuat satu
                    // record terlihat seperti beberapa baris.
                    // Karena itu kita ubah menjadi spasi.
                    //

                    $namaDataset = $this->cleanCsvText($namaDataset);

                    $deskripsi = $this->cleanCsvText(
                        $dataset->deskripsi_data
                    );

                    $tujuan = $this->cleanCsvText(
                        $dataset->tujuan_pengumpulan_data
                    );

                    $format = $this->cleanCsvText(
                        $dataset->format_data_saat_ini
                    );

                    $frekuensi = $this->cleanCsvText(
                        $dataset->frekuensi_update
                    );

                    $namaOpd = $this->cleanCsvText($namaOpd);

                    $namaSektor = $this->cleanCsvText($namaSektor);

                    // ==============================
                    // NILAI KOSONG
                    // ==============================

                    $deskripsi = $deskripsi !== ''
                        ? $deskripsi
                        : '-';

                    $tujuan = $tujuan !== ''
                        ? $tujuan
                        : '-';

                    $format = $format !== ''
                        ? $format
                        : '-';

                    $frekuensi = $frekuensi !== ''
                        ? $frekuensi
                        : '-';

                    // ==============================
                    // STATUS KLASIFIKASI
                    // ==============================

                    $statusKlasifikasi =
                        $dataset->status_klasifikasi === 'terklasifikasi'
                            ? 'Terklasifikasi'
                            : 'Belum Diklasifikasi';

                    // ==============================
                    // SKOR KLASIFIKASI
                    // ==============================

                    $skorKlasifikasi =
                        $dataset->skor_klasifikasi !== null
                            ? $dataset->skor_klasifikasi
                            : 0;

                    // ==============================
                    // STATUS PEMETAAN
                    // ==============================

                    $statusPemetaan =
                        $dataset->sektor_id !== null
                            ? 'Terpetakan'
                            : 'Belum Terpetakan';

                    // ==============================
                    // KELENGKAPAN METADATA
                    // ==============================

                    $jumlahTerisi = 0;

                    if ($deskripsi !== '-') {
                        $jumlahTerisi++;
                    }

                    if ($tujuan !== '-') {
                        $jumlahTerisi++;
                    }

                    if ($format !== '-') {
                        $jumlahTerisi++;
                    }

                    if ($frekuensi !== '-') {
                        $jumlahTerisi++;
                    }

                    $persentaseKelengkapan = round(
                        ($jumlahTerisi / 4) * 100,
                        1
                    );

                    // ==============================
                    // TULIS BARIS CSV
                    // ==============================

                    fputcsv(
                        $handle,
                        [
                            $no,
                            $namaDataset,
                            $namaOpd,
                            $namaSektor,
                            $deskripsi,
                            $tujuan,
                            $format,
                            $frekuensi,
                            $statusKlasifikasi,
                            $skorKlasifikasi,
                            $statusPemetaan,
                            $persentaseKelengkapan . '%'
                        ],
                        ',',
                        '"',
                        '\\'
                    );

                    $no++;
                }

                fclose($handle);
            },
            $namaFile,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="' . $namaFile . '"',

                'Cache-Control' =>
                    'no-store, no-cache, must-revalidate',

                'Pragma' =>
                    'no-cache',

                'Expires' =>
                    '0',
            ]
        );
    }

    /**
     * Menambahkan syarat "kolom ini kosong" (OR) ke query.
     *
     * Kosong = NULL, hanya spasi/enter/tab, atau hanya tanda "-".
     * Disamakan dengan aturan pada export() supaya angka di halaman
     * dan di file CSV sama.
     *
     * $kolom selalu berasal dari daftar tetap di controller,
     * bukan dari input pengguna.
     */
    private function kondisiKosong($query, string $kolom): void
    {
        $bersih = "TRIM(REPLACE(REPLACE(REPLACE({$kolom}, CHAR(13), ''), CHAR(10), ''), CHAR(9), ''))";

        $query->orWhere(function ($q) use ($kolom, $bersih) {
            $q->whereNull($kolom)
                ->orWhereRaw("{$bersih} = ''")
                ->orWhereRaw("{$bersih} = '-'");
        });
    }

    /**
     * Membersihkan teks sebelum dimasukkan ke CSV.
     *
     * Menghilangkan enter/tab yang dapat membuat tampilan
     * CSV terlihat berantakan ketika dibuka di Excel.
     */
    private function cleanCsvText($value)
    {
        $value = trim((string) $value);

        $value = str_replace(
            ["\r\n", "\r", "\n", "\t"],
            ' ',
            $value
        );

        // Rapikan spasi ganda
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    }
}