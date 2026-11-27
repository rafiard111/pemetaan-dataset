<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Opd;
use App\Models\Sektor;
use App\Models\AturanKlasifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DatasetController extends Controller
{
    /**
     * [OPTIMASI] Cache selama satu request agar tidak menghitung
     * atau query hal yang sama berulang-ulang di dalam loop.
     */
    private array $cacheSektorNama = [];
    private array $cacheKolomNullable = [];
    private array $cacheNormalisasi = [];
    private array $cacheOpdDalamTeks = [];

    /**
     * Halaman utama dataset.
     */
    public function index()
    {
        $datasets = Dataset::with(['opd', 'sektor'])
            ->orderBy('id', 'desc')
            ->get();

        $opds = Opd::orderBy('nama_opd')->get();

        return view('datasets.index', compact(
            'datasets',
            'opds'
        ));
    }

    /**
     * Menampilkan dataset yang belum terklasifikasi.
     */
    public function belumTerklasifikasi()
    {
        $datasets = Dataset::with(['opd', 'sektor'])
            ->where('status_klasifikasi', 'belum')
            ->orderBy('id', 'desc')
            ->get();

        $totalBelum = $datasets->count();

        return view('datasets.belum', compact(
            'datasets',
            'totalBelum'
        ));
    }

    /**
     * Import dataset CSV, TXT, XLS, atau XLSX.
     */
    public function import(Request $request)
    {
        // [OPTIMASI] Pengaman untuk file besar.
        set_time_limit(300);

        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|max:20480',
        ]);

        try {
            $namaOpd = trim($request->nama_opd);

            $opd = Opd::firstOrCreate(
                ['nama_opd' => $namaOpd],
                [
                    'kode_opd' => null,
                ]
            );

            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());
            $rows = [];

            /**
             * XLS dan XLSX dibaca menggunakan PhpSpreadsheet.
             * CSV/TXT tetap menggunakan fgetcsv seperti sebelumnya.
             */
            if (in_array($extension, ['xls', 'xlsx'], true)) {
                $spreadsheet = IOFactory::load($file->getRealPath());
                $worksheet = $spreadsheet->getActiveSheet();

                // Indeks kolom dibuat mulai dari 0 agar mapping dataset tetap sama.
                $rows = $worksheet->toArray(null, true, true, false);

                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet, $worksheet);
            } else {
                $handle = fopen($file->getRealPath(), 'r');

                if (!$handle) {
                    return back()->with(
                        'error',
                        'File CSV/TXT tidak dapat dibuka.'
                    );
                }

                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    $rows[] = $row;
                }

                fclose($handle);
            }

            if (empty($rows)) {
                return back()->with(
                    'error',
                    'File yang diunggah kosong atau tidak memiliki data.'
                );
            }

            /**
             * Cari baris header.
             *
             * Header biasanya berada pada baris yang
             * memiliki teks "Nama Statistik".
             */
            $headerIndex = null;

            foreach ($rows as $index => $row) {
                $teksBaris = implode(' ', $row);

                if (
                    stripos($teksBaris, 'Nama Statistik') !== false ||
                    stripos($teksBaris, 'Nama Data Sektoral') !== false
                ) {
                    $headerIndex = $index;
                    break;
                }
            }

            if ($headerIndex === null) {
                return back()->with(
                    'error',
                    'Header dataset tidak ditemukan. Pastikan ada kolom Nama Statistik atau Nama Data Sektoral.'
                );
            }

            $jumlahImport = 0;
            $datasetBaru = collect();

            $jumlahDuplikat = 0;
            $kunciDataset = [];

            /**
             * Siapkan kunci dataset yang sudah ada pada OPD ini.
             * Deteksi duplikat memakai pasangan nama statistik
             * dan nama data sektoral yang dinormalisasi.
             */
            $datasetLama = Dataset::where('opd_id', $opd->id)
                ->get(['nama_statistik', 'nama_data_sektoral']);

            foreach ($datasetLama as $itemLama) {
                $kunciLama = $this->kunciDataset(
                    $itemLama->nama_statistik,
                    $itemLama->nama_data_sektoral
                );

                if ($kunciLama !== null) {
                    $kunciDataset[$kunciLama] = true;
                }
            }

            DB::beginTransaction();

            $totalRows = count($rows);

            for ($i = $headerIndex + 1; $i < $totalRows; $i++) {

                $row = $rows[$i];

                /**
                 * Abaikan baris kosong.
                 */
                $isiBaris = trim(
                    implode('', array_map(
                        fn($value) => trim((string) $value),
                        $row
                    ))
                );

                if ($isiBaris === '') {
                    continue;
                }

                $namaStatistik = $this->nilaiKolom($row, 1);
                $namaDataSektoral = $this->nilaiKolom($row, 2);
                $kunciBaru = $this->kunciDataset(
                    $namaStatistik,
                    $namaDataSektoral
                );

                if ($kunciBaru === null) {
                    continue;
                }

                /**
                 * Jika pasangan nama sudah ada, jangan impor ulang.
                 * Data lama tidak dihapus atau ditimpa.
                 */
                if (isset($kunciDataset[$kunciBaru])) {
                    $jumlahDuplikat++;
                    continue;
                }

                $kunciDataset[$kunciBaru] = true;

                /**
                 * Berdasarkan struktur CSV yang digunakan:
                 * index 0 = No, 1 = Nama Statistik,
                 * 2 = Nama Data Sektoral, ... 25 = Catatan.
                 */

                $dataset = Dataset::create([
                    'opd_id' => $opd->id,

                    'nama_statistik' => $namaStatistik,

                    'nama_data_sektoral' => $namaDataSektoral,

                    'urusan' =>
                        $this->nilaiKolom($row, 3),

                    'bidang' =>
                        $this->nilaiKolom($row, 4),

                    'program' =>
                        $this->nilaiKolom($row, 5),

                    'kegiatan' =>
                        $this->nilaiKolom($row, 6),

                    'sub_kegiatan' =>
                        $this->nilaiKolom($row, 7),

                    'proses_bisnis' =>
                        $this->nilaiKolom($row, 8),

                    'deskripsi_data' =>
                        $this->nilaiKolom($row, 9),

                    'tujuan_pengumpulan_data' =>
                        $this->nilaiKolom($row, 10),

                    'kategori_data' =>
                        $this->nilaiKolom($row, 11),

                    'jenis_data' =>
                        $this->nilaiKolom($row, 12),

                    'nama_atribut_data' =>
                        $this->nilaiKolom($row, 13),

                    'format_data_saat_ini' =>
                        $this->nilaiKolom($row, 14),

                    'frekuensi_update' =>
                        $this->nilaiKolom($row, 15),

                    'aplikasi_yang_digunakan' =>
                        $this->nilaiKolom($row, 16),

                    'status_aplikasi' =>
                        $this->nilaiKolom($row, 17),

                    'ketersediaan_api_integrasi' =>
                        $this->nilaiKolom($row, 18),

                    'integrasi_dengan' =>
                        $this->nilaiKolom($row, 19),

                    'potensi_integrasi' =>
                        $this->nilaiKolom($row, 20),

                    'kendala_pengelolaan_data' =>
                        $this->nilaiKolom($row, 21),

                    'kebutuhan_opd' =>
                        $this->nilaiKolom($row, 22),

                    'digunakan_untuk' =>
                        $this->nilaiKolom($row, 23),

                    'data_sudah_tersedia' =>
                        $this->nilaiKolom($row, 24),

                    'catatan' =>
                        $this->nilaiKolom($row, 25),

                    'status_klasifikasi' => 'belum',

                    'status_pemetaan' => 'belum',

                    'sektor_id' => null,

                    'skor_klasifikasi' => null,
                ]);

                $datasetBaru->push($dataset);

                $jumlahImport++;
            }

            /**
             * Buat kandidat relasi pendukung dari kolom integrasi
             * dataset yang baru diimpor. Relasi tetap berstatus
             * belum terverifikasi, bukan klaim penggunaan aktual.
             */
            $jumlahRelasiBaru =
                $this->buatRelasiPendukungDariDataset(
                    $opd,
                    $datasetBaru
                );

            // Cocokkan ulang semua kandidat relasi yang sudah ada,
            // termasuk data yang diimpor pada batch sebelumnya.
            $jumlahRelasiDipetakan =
                $this->remapRelasiPendukungMassal();

            /**
             * Setelah data masuk:
             * 1. Tambahkan keyword otomatis jika memungkinkan.
             * 2. Jalankan klasifikasi.
             */
            $jumlahKeywordBaru =
                $this->tambahkanKeywordOtomatis(
                    $opd->id,
                    $datasetBaru
                );

            $jumlahTerklasifikasi =
                $this->jalankanKlasifikasi();

            // Commit setelah import, relasi, keyword, dan klasifikasi sukses.
            DB::commit();

            return redirect('/dataset')->with(
                'success',
                $jumlahImport .
                ' dataset baru berhasil diimport. ' .
                $jumlahDuplikat .
                ' baris duplikat dilewati. ' .
                $jumlahKeywordBaru .
                ' keyword baru ditambahkan otomatis. ' .
                $jumlahTerklasifikasi .
                ' dataset berhasil diklasifikasikan. ' .
                $jumlahRelasiBaru .
                ' kandidat relasi pendukung baru dicatat. ' .
                $jumlahRelasiDipetakan .
                ' kandidat relasi lama/baru berhasil dicocokkan ke OPD.'
            );

        } catch (\Throwable $e) {

            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            return back()->with(
                'error',
                'Import gagal: ' . $e->getMessage()
            );
        }
    }

    /**
     * Normalisasi nama untuk mencegah impor pasangan dataset yang sama.
     */
    private function normalisasiNamaDataset(?string $nama): string
    {
        // [OPTIMASI] Teks yang sama tidak dinormalisasi ulang.
        $kunci = (string) $nama;

        if (isset($this->cacheNormalisasi[$kunci])) {
            return $this->cacheNormalisasi[$kunci];
        }

        $hasil = Str::lower(trim($kunci));
        $hasil = preg_replace('/[^a-z0-9]+/u', ' ', $hasil);
        $hasil = preg_replace('/\s+/u', ' ', $hasil);
        $hasil = trim((string) $hasil);

        return $this->cacheNormalisasi[$kunci] = $hasil;
    }

    /**
     * Kunci duplikat berdasarkan pasangan nama statistik dan nama data.
     */
    private function kunciDataset(
        ?string $namaStatistik,
        ?string $namaDataSektoral
    ): ?string {
        $statistik = $this->normalisasiNamaDataset($namaStatistik);
        $data = $this->normalisasiNamaDataset($namaDataSektoral);

        if ($statistik === '' && $data === '') {
            return null;
        }

        return $statistik . '||' . $data;
    }

    /**
     * Membuat kandidat relasi dari kolom-kolom integrasi CSV.
     *
     * Tabel relasi_pendukung_sumber yang ada berbasis nama sumber/OPD,
     * sehingga relasi dicatat sebagai kandidat dan tidak diklaim resmi.
     */
    private function buatRelasiPendukungDariDataset(
        Opd $opd,
        $datasetBaru
    ): int {
        $tabel = 'relasi_pendukung_sumber';

        if (!Schema::hasTable($tabel)) {
            return 0;
        }

        $kolomWajib = [
            'kode_opd_pemilik_sumber',
            'nama_opd_pemilik',
            'nama_data_sumber',
            'instansi_pendukung_raw',
            'kode_opd_terkait_sumber',
            'nama_opd_terkait',
            'dasar_relasi',
            'status_bukti',
        ];

        foreach ($kolomWajib as $kolom) {
            if (!Schema::hasColumn($tabel, $kolom)) {
                return 0;
            }
        }

        // [OPTIMASI] Cek kolom timestamp sekali saja, bukan per insert.
        $punyaCreatedAt = Schema::hasColumn($tabel, 'created_at');
        $punyaUpdatedAt = Schema::hasColumn($tabel, 'updated_at');

        $kolomRelasi = [
            'integrasi_dengan' => 'Kolom integrasi_dengan',
            'potensi_integrasi' => 'Kolom potensi_integrasi',
            'kebutuhan_opd' => 'Kolom kebutuhan_opd',
            'digunakan_untuk' => 'Kolom digunakan_untuk',
        ];

        $daftarOpd = Opd::orderBy('nama_opd')->get();
        $jumlahBaru = 0;
        $kodePemilik = $this->kodeOpdUntukRelasi(
            $opd->kode_opd,
            'kode_opd_pemilik_sumber'
        );

        foreach ($datasetBaru as $dataset) {
            $namaSumber = trim((string) (
                $dataset->nama_data_sektoral
                ?: $dataset->nama_statistik
                ?: ('Dataset #' . $dataset->id)
            ));

            foreach ($kolomRelasi as $kolom => $dasar) {
                if (!isset($dataset->{$kolom})) {
                    continue;
                }

                $raw = trim((string) $dataset->{$kolom});

                if ($raw === '' || $this->nilaiKosongRelasi($raw)) {
                    continue;
                }

                // Batasi panjang untuk kompatibilitas kolom varchar.
                $rawSimpan = Str::limit($raw, 240, '');
                $opdTerkait = $this->cariOpdDalamTeks(
                    $raw,
                    $daftarOpd,
                    $opd->id
                );

                // Satu record untuk tiap OPD yang terdeteksi.
                // Jika belum terdeteksi, simpan sebagai kandidat umum.
                $targetList = $opdTerkait->isNotEmpty()
                    ? $opdTerkait
                    : collect([null]);

                foreach ($targetList as $target) {
                    $kodeTarget = $this->kodeOpdUntukRelasi(
                        $target ? $target->kode_opd : null,
                        'kode_opd_terkait_sumber'
                    );

                    $namaTarget = $target
                        ? $target->nama_opd
                        : 'Belum teridentifikasi';

                    $statusBukti = $target
                        ? 'Kandidat otomatis dari CSV; penggunaan aktual belum terverifikasi.'
                        : 'Kandidat otomatis dari CSV; OPD terkait belum teridentifikasi dan penggunaan aktual belum terverifikasi.';

                    $kondisi = [
                        'kode_opd_pemilik_sumber' => $kodePemilik,
                        'nama_opd_pemilik' => Str::limit($opd->nama_opd, 240, ''),
                        'nama_data_sumber' => Str::limit($namaSumber, 240, ''),
                        'instansi_pendukung_raw' => $rawSimpan,
                        'kode_opd_terkait_sumber' => $kodeTarget,
                        'nama_opd_terkait' => Str::limit($namaTarget, 240, ''),
                        'dasar_relasi' => $dasar,
                    ];

                    $sudahAda = DB::table($tabel)
                        ->where($kondisi)
                        ->exists();

                    if ($sudahAda) {
                        continue;
                    }

                    $dataSimpan = $kondisi + [
                        'status_bukti' => $statusBukti,
                    ];

                    if ($punyaCreatedAt) {
                        $dataSimpan['created_at'] = now();
                    }

                    if ($punyaUpdatedAt) {
                        $dataSimpan['updated_at'] = now();
                    }

                    DB::table($tabel)->insert($dataSimpan);
                    $jumlahBaru++;
                }
            }
        }

        return $jumlahBaru;
    }

    /**
     * Mengabaikan nilai CSV yang hanya berisi penanda kosong.
     */
    private function nilaiKosongRelasi(string $nilai): bool
    {
        $nilai = Str::lower(trim($nilai));

        return in_array($nilai, [
            '-',
            '—',
            'n/a',
            'na',
            'tidak ada',
            'belum ada',
            'tidak tersedia',
            'null',
        ], true);
    }

    /**
     * Mencari OPD yang namanya disebut dalam teks relasi.
     * Hanya mengembalikan OPD yang sudah terdaftar di tabel opd.
     */
    private function cariOpdDalamTeks(
        string $teks,
        $daftarOpd,
        int $opdPemilikId
    ) {
        // [OPTIMASI] Teks relasi yang sama (untuk pemilik yang sama)
        // tidak dicocokkan ulang ke seluruh OPD.
        $kunciCache = $opdPemilikId . '|' . $daftarOpd->count() . '|' . $teks;

        if (isset($this->cacheOpdDalamTeks[$kunciCache])) {
            return $this->cacheOpdDalamTeks[$kunciCache];
        }

        $teksNormal = $this->normalisasiNamaDataset($teks);
        $hasil = collect();

        // Cocokkan nama OPD yang memang sudah tercatat di master.
        foreach ($daftarOpd as $calonOpd) {
            if ((int) $calonOpd->id === $opdPemilikId) {
                continue;
            }

            $namaNormal = $this->normalisasiNamaDataset(
                $calonOpd->nama_opd
            );

            if (
                $namaNormal !== '' &&
                $this->teksMemuatFrasa($teksNormal, $namaNormal)
            ) {
                $hasil->push($calonOpd);
            }
        }

        /*
         * Alias hanya dipakai untuk nama/akronim OPD yang jelas.
         * Target tetap harus ditemukan pada tabel opd; controller
         * tidak membuat OPD baru dan tidak mengarang kode resmi.
         */
        $aliasKeNamaMaster = [
            'disdukcapil' => [
                'dinas kependudukan dan catatan sipil',
                'dinas kependudukan dan pencatatan sipil',
            ],
            'dukcapil' => [
                'dinas kependudukan dan catatan sipil',
                'dinas kependudukan dan pencatatan sipil',
            ],
            'setda' => [
                'sekretariat daerah',
            ],
            'dpupr' => [
                'dinas pekerjaan umum dan penataan ruang',
                'dinas pekerjaan umum dan perumahan rakyat',
                'dpupr',
            ],
            'pupr' => [
                'dinas pekerjaan umum dan penataan ruang',
                'dpupr',
            ],
            'bkpsdm' => [
                'badan kepegawaian dan pengembangan sumber daya manusia',
                'bkpsdm',
            ],
            'bps' => [
                'badan pusat statistik',
                'bps',
            ],
            'dpmptsp' => [
                'dinas penanaman modal dan pelayanan terpadu satu pintu',
                'dpmptsp',
            ],
            'bpbd' => [
                'badan penanggulangan bencana daerah',
                'bpbd',
            ],
            'dinkes' => [
                'dinas kesehatan',
            ],
            'dinsos' => [
                'dinas sosial',
            ],
            'diskominfo' => [
                'dinas komunikasi dan informatika',
            ],
            'satpol pp' => [
                'satuan polisi pamong praja',
            ],
            'inspektorat' => [
                'inspektorat',
            ],
        ];

        foreach ($aliasKeNamaMaster as $alias => $namaMasterList) {
            $aliasNormal = $this->normalisasiNamaDataset($alias);

            if (
                $aliasNormal === '' ||
                !$this->teksMemuatFrasa($teksNormal, $aliasNormal)
            ) {
                continue;
            }

            foreach ($daftarOpd as $calonOpd) {
                if ((int) $calonOpd->id === $opdPemilikId) {
                    continue;
                }

                $namaOpdNormal = $this->normalisasiNamaDataset(
                    $calonOpd->nama_opd
                );

                foreach ($namaMasterList as $namaMaster) {
                    $namaMasterNormal = $this->normalisasiNamaDataset(
                        $namaMaster
                    );

                    if (
                        $namaOpdNormal === $namaMasterNormal ||
                        $this->teksMemuatFrasa(
                            $namaOpdNormal,
                            $namaMasterNormal
                        ) ||
                        $this->teksMemuatFrasa(
                            $namaMasterNormal,
                            $namaOpdNormal
                        )
                    ) {
                        $hasil->push($calonOpd);
                        break;
                    }
                }
            }
        }

        return $this->cacheOpdDalamTeks[$kunciCache] =
            $hasil->unique('id')->values();
    }

    /**
     * Memeriksa frasa sebagai kata/frasa utuh agar alias pendek
     * seperti "bps" tidak cocok dengan bagian kata lain.
     */
    private function teksMemuatFrasa(
        string $teksNormal,
        string $frasaNormal
    ): bool {
        if ($teksNormal === '' || $frasaNormal === '') {
            return false;
        }

        $pattern = '/(?<![a-z0-9])' .
            preg_quote($frasaNormal, '/') .
            '(?![a-z0-9])/iu';

        return preg_match($pattern, $teksNormal) === 1;
    }

    /**
     * Menggunakan kode OPD resmi jika tersedia.
     * Jika belum tersedia, simpan NULL bila kolom database nullable.
     * Placeholder lama hanya dipakai bila skema mewajibkan nilai.
     */
    private function kodeOpdUntukRelasi(
        ?string $kode,
        string $namaKolom
    ): ?string {
        $kode = trim((string) $kode);

        if ($kode !== '') {
            return $kode;
        }

        // [OPTIMASI] Query information_schema hanya sekali per kolom,
        // sebelumnya dijalankan setiap kali fungsi ini dipanggil.
        if (!array_key_exists($namaKolom, $this->cacheKolomNullable)) {
            $metadata = DB::selectOne(
                'SELECT IS_NULLABLE
                 FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = ?
                   AND COLUMN_NAME = ?',
                ['relasi_pendukung_sumber', $namaKolom]
            );

            $this->cacheKolomNullable[$namaKolom] =
                $metadata &&
                strtoupper((string) $metadata->IS_NULLABLE) === 'YES';
        }

        if ($this->cacheKolomNullable[$namaKolom]) {
            return null;
        }

        // Kompatibilitas skema lama yang mensyaratkan kode non-null.
        return 'KODE-BELUM-TERSEDIA';
    }

    /**
     * Memetakan ulang relasi yang sudah tersimpan.
     *
     * Tidak menghapus kandidat, tidak mengubahnya menjadi bukti resmi,
     * dan tidak mengisi kode OPD resmi jika kode di master masih NULL.
     * Jika satu teks menyebut beberapa OPD, baris tambahan dibuat
     * untuk target lain dengan pemeriksaan duplikat.
     */
    private function remapRelasiPendukungMassal(): int
    {
        $tabel = 'relasi_pendukung_sumber';

        if (
            !Schema::hasTable($tabel) ||
            !Schema::hasColumn($tabel, 'id') ||
            !Schema::hasColumn($tabel, 'instansi_pendukung_raw') ||
            !Schema::hasColumn($tabel, 'nama_opd_pemilik') ||
            !Schema::hasColumn($tabel, 'nama_data_sumber') ||
            !Schema::hasColumn($tabel, 'nama_opd_terkait') ||
            !Schema::hasColumn($tabel, 'kode_opd_terkait_sumber')
        ) {
            return 0;
        }

        $daftarOpd = Opd::orderBy('nama_opd')->get();
        if ($daftarOpd->isEmpty()) {
            return 0;
        }

        // [OPTIMASI] Cek kolom sekali saja, bukan per baris relasi.
        $punyaStatusBukti = Schema::hasColumn($tabel, 'status_bukti');
        $punyaCreatedAt = Schema::hasColumn($tabel, 'created_at');
        $punyaUpdatedAt = Schema::hasColumn($tabel, 'updated_at');

        // [OPTIMASI] Index OPD berdasarkan nama untuk pencarian pemilik.
        $opdBerdasarkanNama = $daftarOpd->keyBy('nama_opd');

        $jumlahBerubah = 0;

        DB::table($tabel)
            ->orderBy('id')
            ->chunkById(200, function ($barisRelasi) use (
                $tabel,
                $daftarOpd,
                $opdBerdasarkanNama,
                $punyaStatusBukti,
                $punyaCreatedAt,
                $punyaUpdatedAt,
                &$jumlahBerubah
            ) {
                foreach ($barisRelasi as $baris) {
                    $raw = trim((string) $baris->instansi_pendukung_raw);
                    if ($raw === '' || $this->nilaiKosongRelasi($raw)) {
                        continue;
                    }

                    // Cari OPD pemilik supaya tidak dipetakan sebagai target dirinya.
                    $pemilik = $opdBerdasarkanNama->get(
                        $baris->nama_opd_pemilik
                    );
                    $pemilikId = (int) ($pemilik->id ?? 0);

                    $targetList = $this->cariOpdDalamTeks(
                        $raw,
                        $daftarOpd,
                        $pemilikId
                    );

                    if ($targetList->isEmpty()) {
                        continue;
                    }

                    $targetUtama = $targetList->first();

                    $kodeTarget = $this->kodeOpdUntukRelasi(
                        $targetUtama->kode_opd,
                        'kode_opd_terkait_sumber'
                    );

                    $namaTarget = Str::limit(
                        (string) $targetUtama->nama_opd,
                        240,
                        ''
                    );

                    $statusSaatIni = (string) ($baris->status_bukti ?? '');
                    $statusKandidat = 'Kandidat otomatis dari CSV; penggunaan aktual belum terverifikasi.';

                    $update = [
                        'nama_opd_terkait' => $namaTarget,
                        'kode_opd_terkait_sumber' => $kodeTarget,
                    ];

                    if (
                        $punyaStatusBukti &&
                        (
                            $statusSaatIni === '' ||
                            stripos($statusSaatIni, 'belum teridentifikasi') !== false
                        )
                    ) {
                        $update['status_bukti'] = $statusKandidat;
                    }

                    $sudahSama =
                        (string) $baris->nama_opd_terkait === $namaTarget &&
                        (string) $baris->kode_opd_terkait_sumber === (string) $kodeTarget;

                    if (!$sudahSama || isset($update['status_bukti'])) {
                        DB::table($tabel)
                            ->where('id', $baris->id)
                            ->update($update);

                        $jumlahBerubah++;
                    }

                    // Jika raw menyebut beberapa OPD, buat kandidat tambahan
                    // untuk target lain tanpa menghapus atau menggandakan yang ada.
                    foreach ($targetList->skip(1) as $targetTambahan) {
                        $kodeTambahan = $this->kodeOpdUntukRelasi(
                            $targetTambahan->kode_opd,
                            'kode_opd_terkait_sumber'
                        );

                        $kondisi = [
                            'kode_opd_pemilik_sumber' => $baris->kode_opd_pemilik_sumber,
                            'nama_opd_pemilik' => $baris->nama_opd_pemilik,
                            'nama_data_sumber' => $baris->nama_data_sumber,
                            'instansi_pendukung_raw' => $baris->instansi_pendukung_raw,
                            'kode_opd_terkait_sumber' => $kodeTambahan,
                            'nama_opd_terkait' => Str::limit(
                                (string) $targetTambahan->nama_opd,
                                240,
                                ''
                            ),
                            'dasar_relasi' => $baris->dasar_relasi,
                        ];

                        $ada = DB::table($tabel)
                            ->where($kondisi)
                            ->exists();

                        if (!$ada) {
                            $dataInsert = $kondisi + [
                                'status_bukti' => $statusKandidat,
                            ];

                            if ($punyaCreatedAt) {
                                $dataInsert['created_at'] = now();
                            }
                            if ($punyaUpdatedAt) {
                                $dataInsert['updated_at'] = now();
                            }

                            DB::table($tabel)->insert($dataInsert);
                            $jumlahBerubah++;
                        }
                    }
                }
            });

        return $jumlahBerubah;
    }

    /**
     * Mengambil nilai kolom CSV dengan aman.
     */
    private function nilaiKolom(array $row, int $index): ?string
    {
        if (!isset($row[$index])) {
            return null;
        }

        $nilai = trim((string) $row[$index]);

        return $nilai === '' ? null : $nilai;
    }

    /**
     * Menentukan sektor default berdasarkan OPD.
     *
     * Digunakan sebagai konteks tambahan,
     * bukan satu-satunya dasar klasifikasi.
     */
    private function tentukanSektorDariOpd(?Opd $opd): ?Sektor
    {
        if (!$opd) {
            return null;
        }

        $nama = Str::lower($opd->nama_opd);

        $mapping = [
            'pemadam kebakaran' => 'Penanggulangan Bencana',
            'damkar' => 'Penanggulangan Bencana',
            'dinas sosial' => 'Sosial',
            'dinsos' => 'Sosial',

            'kependudukan' => 'Kependudukan',
            'catatan sipil' => 'Kependudukan',
            'dukcapil' => 'Kependudukan',
            'disdukcapil' => 'Kependudukan',

            'dinas kesehatan' => 'Kesehatan',
            'kesehatan' => 'Kesehatan',

            'dinas pendidikan' => 'Pendidikan',
            'pendidikan' => 'Pendidikan',

            'lingkungan hidup' => 'Lingkungan',
            'dinas lingkungan' => 'Lingkungan',
        ];

        foreach ($mapping as $kata => $namaSektor) {
            if (Str::contains($nama, $kata)) {
                // [OPTIMASI] Query sektor sekali per nama sektor.
                if (!array_key_exists($namaSektor, $this->cacheSektorNama)) {
                    $this->cacheSektorNama[$namaSektor] = Sektor::where(
                        'nama_sektor',
                        $namaSektor
                    )->first();
                }

                return $this->cacheSektorNama[$namaSektor];
            }
        }

        return null;
    }

    /**
     * Membuat keyword otomatis berdasarkan dataset OPD.
     *
     * Hanya menggunakan kata yang cukup sering muncul
     * dan bukan stopword umum.
     */
    private function tambahkanKeywordOtomatis(
        int $opdId,
        $datasetBaru
    ): int {
        $opd = Opd::find($opdId);

        if (!$opd || $datasetBaru->isEmpty()) {
            return 0;
        }

        /**
         * Cari sektor dominan dari dataset OPD yang
         * sudah mempunyai klasifikasi.
         */
        $sektorDominan = Dataset::where(
            'opd_id',
            $opdId
        )
            ->whereNotNull('sektor_id')
            ->select(
                'sektor_id',
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('sektor_id')
            ->orderByDesc('jumlah')
            ->first();

        $sektor = null;

        if ($sektorDominan) {
            $sektor = Sektor::find(
                $sektorDominan->sektor_id
            );
        }

        /**
         * Jika belum ada sektor dominan,
         * gunakan konteks OPD.
         */
        if (!$sektor) {
            $sektor = $this->tentukanSektorDariOpd($opd);
        }

        if (!$sektor) {
            return 0;
        }

        /**
         * Stopword agar kata umum tidak menjadi keyword.
         */
        $stopwords = [
            'yang',
            'dan',
            'atau',
            'dengan',
            'untuk',
            'dari',
            'pada',
            'dalam',
            'oleh',
            'akan',
            'telah',
            'sudah',
            'sesuai',
            'secara',
            'setiap',
            'tahun',
            'jumlah',
            'persentase',
            'tingkat',
            'cakupan',
            'data',
            'dokumen',
            'hasil',
            'pelaksanaan',
            'kegiatan',
            'laporan',
            'penyusunan',
            'penyajian',
            'tersedia',
            'terhadap',
            'melalui',
            'mendapat',
            'mendapatkan',
            'memiliki',
            'menurut',
            'terkait',
            'dapat',
            'sarana',
            'prasarana',
            'pelayanan',
            'layanan',
            'masyarakat',
            'wilayah',
            'daerah',
            'kabupaten',
            'kota',
            'desa',
            'kelurahan',
            'provinsi',
            'nomor',
            'sistem',
            'standar',
            'standarisasi',
            'proses',
            'program',
            'bidang',
            'urusan',
            'aplikasi',
            'penerbitan',
            'pencatatan',
            'penatausahaan',
        ];

        $frekuensi = [];

        foreach ($datasetBaru as $dataset) {

            $teks = implode(' ', array_filter([
                $dataset->nama_statistik,
                $dataset->nama_data_sektoral,
                $dataset->deskripsi_data,
                $dataset->tujuan_pengumpulan_data,
                $dataset->bidang,
                $dataset->program,
                $dataset->kegiatan,
                $dataset->sub_kegiatan,
                $dataset->proses_bisnis,
            ]));

            $teks = Str::lower($teks);

            $kataKata = preg_split(
                '/[^a-zA-Z0-9]+/u',
                $teks
            );

            foreach ($kataKata as $kata) {

                $kata = trim($kata);

                if ($kata === '') {
                    continue;
                }

                if (in_array($kata, $stopwords, true)) {
                    continue;
                }

                /**
                 * Hindari keyword yang terlalu pendek.
                 *
                 * Contoh:
                 * "di", "ke", "kk" dll.
                 */
                if (strlen($kata) < 4) {
                    continue;
                }

                if (is_numeric($kata)) {
                    continue;
                }

                if (!isset($frekuensi[$kata])) {
                    $frekuensi[$kata] = 0;
                }

                $frekuensi[$kata]++;
            }
        }

        // [OPTIMASI] Ambil keyword yang sudah ada untuk sektor ini
        // sekali saja, bukan query per kata.
        $keywordAda = [];

        foreach (
            AturanKlasifikasi::where('sektor_id', $sektor->id)
                ->pluck('keyword') as $k
        ) {
            $keywordAda[Str::lower((string) $k)] = true;
        }

        $jumlahBaru = 0;

        foreach ($frekuensi as $keyword => $jumlah) {

            /**
             * Hanya gunakan kata yang muncul
             * minimal 2 kali.
             */
            if ($jumlah < 2) {
                continue;
            }

            if (isset($keywordAda[Str::lower($keyword)])) {
                continue;
            }

            /**
             * Keyword yang muncul berkali-kali
             * diberi bobot lebih besar.
             */
            $bobot = 1;

            if ($jumlah >= 5) {
                $bobot = 2;
            }

            if ($jumlah >= 10) {
                $bobot = 3;
            }

            AturanKlasifikasi::create([
                'sektor_id' => $sektor->id,
                'keyword' => $keyword,
                'bobot' => $bobot,
            ]);

            $keywordAda[Str::lower($keyword)] = true;
            $jumlahBaru++;
        }

        return $jumlahBaru;
    }

    /**
     * Menjalankan klasifikasi seluruh dataset.
     */
    public function classify()
    {
        // [OPTIMASI] Pengaman untuk data besar.
        set_time_limit(300);

        // [OPTIMASI] Remap + klasifikasi dalam satu transaksi
        // agar update tidak di-commit satu per satu.
        [$jumlahRelasiDipetakan, $jumlah] = DB::transaction(function () {
            return [
                $this->remapRelasiPendukungMassal(),
                $this->jalankanKlasifikasi(),
            ];
        });

        return redirect('/dataset')->with(
            'success',
            $jumlah .
            ' dataset berhasil diklasifikasikan. ' .
            $jumlahRelasiDipetakan .
            ' kandidat relasi pendukung berhasil dicocokkan ke OPD. ' .
            'Status relasi tetap kandidat/belum terverifikasi.'
        );
    }

    /**
     * Simpan hasil klasifikasi dalam batch agar tidak menjalankan
     * UPDATE satu per satu untuk setiap dataset.
     */
    private function simpanBatchKlasifikasi(array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        foreach (array_chunk($rows, 200) as $batch) {
            DB::table('datasets')->upsert(
                $batch,
                ['id'],
                [
                    'sektor_id',
                    'status_klasifikasi',
                    'status_pemetaan',
                    'skor_klasifikasi',
                    'updated_at',
                ]
            );
        }
    }

    /**
     * Algoritma utama klasifikasi.
     */
    private function jalankanKlasifikasi(): int
    {
        $datasets = Dataset::with('opd')
            ->get();

        $aturan = AturanKlasifikasi::with('sektor')
            ->get();

        if ($aturan->isEmpty()) {
            return 0;
        }

        /**
         * [OPTIMASI] Siapkan aturan SEKALI saja.
         * Sebelumnya lower/trim/preg_split/bobot dihitung ulang
         * untuk setiap pasangan dataset x keyword.
         * Logika bobot sama persis seperti sebelumnya.
         */
        $daftarAturan = [];

        foreach ($aturan as $rule) {

            if (!$rule->sektor) {
                continue;
            }

            $keyword = Str::lower(
                trim((string) $rule->keyword)
            );

            if ($keyword === '') {
                continue;
            }

            // Bobot dasar dari database.
            $bobot = (float) $rule->bobot;

            // Keyword/frasa panjang lebih spesifik.
            $jumlahKata = count(
                preg_split('/\s+/', $keyword)
            );

            if ($jumlahKata >= 3) {
                $bobot *= 3;
            } elseif ($jumlahKata === 2) {
                $bobot *= 2;
            }

            // Keyword panjang juga sedikit lebih dipercaya.
            if (strlen($keyword) >= 10) {
                $bobot *= 1.25;
            }

            $daftarAturan[] = [
                'keyword' => $keyword,

                // Keyword pendek: hindari pencocokan substring yang terlalu bebas.
                'pattern' => strlen($keyword) <= 3
                    ? '/(?<![a-z0-9])' . preg_quote($keyword, '/') . '(?![a-z0-9])/iu'
                    : null,

                'sektor_id' => $rule->sektor_id,
                'bobot' => $bobot,
            ];
        }

        unset($aturan);

        $jumlahTerklasifikasi = 0;
        $pendingUpdates = [];
        $sekarang = now();

        // [OPTIMASI] Sektor OPD dihitung sekali per OPD.
        $cacheSektorOpd = [];

        foreach ($datasets as $dataset) {

            /**
             * Gabungkan informasi dataset.
             */
            $teks = implode(' ', array_filter([
                $dataset->nama_statistik,
                $dataset->nama_data_sektoral,
                $dataset->urusan,
                $dataset->bidang,
                $dataset->program,
                $dataset->kegiatan,
                $dataset->sub_kegiatan,
                $dataset->proses_bisnis,
                $dataset->deskripsi_data,
                $dataset->tujuan_pengumpulan_data,
                $dataset->kategori_data,
                $dataset->jenis_data,
                $dataset->nama_atribut_data,
                $dataset->integrasi_dengan,
                $dataset->potensi_integrasi,
                $dataset->kebutuhan_opd,
                $dataset->digunakan_untuk,
                $dataset->catatan,
            ]));

            $teks = Str::lower($teks);

            if (trim($teks) === '') {
                continue;
            }

            /**
             * Skor setiap sektor.
             */
            $skorSektor = [];

            foreach ($daftarAturan as $r) {

                $ditemukan = $r['pattern'] !== null
                    ? preg_match($r['pattern'], $teks) === 1
                    : str_contains($teks, $r['keyword']);

                if (!$ditemukan) {
                    continue;
                }

                $skorSektor[$r['sektor_id']] =
                    ($skorSektor[$r['sektor_id']] ?? 0) + $r['bobot'];
            }

            /**
             * Tambahan konteks OPD.
             *
             * Ini bukan berarti semua dataset OPD
             * dipaksa ke sektor tersebut.
             */
            $opdKey = $dataset->opd_id ?? 0;

            if (!array_key_exists($opdKey, $cacheSektorOpd)) {
                $cacheSektorOpd[$opdKey] =
                    $this->tentukanSektorDariOpd($dataset->opd);
            }

            $sektorOpd = $cacheSektorOpd[$opdKey];

            if ($sektorOpd) {
                /**
                 * Bonus konteks OPD cukup kecil.
                 * Jadi keyword spesifik tetap bisa
                 * mengalahkannya.
                 */
                $skorSektor[$sektorOpd->id] =
                    ($skorSektor[$sektorOpd->id] ?? 0) + 2;
            }

            /**
             * Jika tidak ada skor sama sekali,
             * gunakan fallback berdasarkan OPD.
             */
            if (empty($skorSektor)) {

                if ($sektorOpd) {

                    $pendingUpdates[] = [
                        'id' => $dataset->id,
                        'sektor_id' => $sektorOpd->id,
                        'status_klasifikasi' => 'terklasifikasi',
                        'status_pemetaan' => 'terpetakan',
                        'skor_klasifikasi' => 0.50,
                        'updated_at' => $sekarang,
                    ];

                    if (count($pendingUpdates) >= 200) {
                        $this->simpanBatchKlasifikasi($pendingUpdates);
                        $pendingUpdates = [];
                    }

                    $jumlahTerklasifikasi++;
                }

                continue;
            }

            /**
             * Urutkan sektor berdasarkan skor tertinggi.
             */
            arsort($skorSektor);

            $sektorTerpilihId = array_key_first($skorSektor);

            $skorTertinggi = $skorSektor[$sektorTerpilihId];

            /**
             * Ambil skor tertinggi kedua.
             */
            $skorKedua = array_values($skorSektor)[1] ?? 0;

            /**
             * Jika skor terlalu rendah dan tidak ada
             * konteks OPD, jangan memaksakan klasifikasi.
             */
            if (
                $skorTertinggi < 1 &&
                !$sektorOpd
            ) {
                $pendingUpdates[] = [
                    'id' => $dataset->id,
                    'sektor_id' => null,
                    'status_klasifikasi' => 'belum',
                    'status_pemetaan' => 'belum',
                    'skor_klasifikasi' => null,
                    'updated_at' => $sekarang,
                ];

                if (count($pendingUpdates) >= 200) {
                    $this->simpanBatchKlasifikasi($pendingUpdates);
                    $pendingUpdates = [];
                }

                continue;
            }

            /**
             * Jika dua sektor hampir sama kuat,
             * gunakan konteks OPD untuk menentukan
             * sektor yang lebih relevan.
             */
            if (
                $skorKedua > 0 &&
                ($skorTertinggi - $skorKedua) <= 1 &&
                $sektorOpd &&
                isset($skorSektor[$sektorOpd->id])
            ) {
                $sektorTerpilihId = $sektorOpd->id;
                $skorTertinggi = $skorSektor[$sektorTerpilihId];
            }

            /**
             * Simpan hasil.
             */
            $pendingUpdates[] = [
                'id' => $dataset->id,
                'sektor_id' => $sektorTerpilihId,
                'status_klasifikasi' => 'terklasifikasi',
                'status_pemetaan' => 'terpetakan',
                'skor_klasifikasi' => round($skorTertinggi, 2),
                'updated_at' => $sekarang,
            ];

            if (count($pendingUpdates) >= 200) {
                $this->simpanBatchKlasifikasi($pendingUpdates);
                $pendingUpdates = [];
            }

            $jumlahTerklasifikasi++;
        }

        if (!empty($pendingUpdates)) {
            $this->simpanBatchKlasifikasi($pendingUpdates);
        }

        return $jumlahTerklasifikasi;
    }
}