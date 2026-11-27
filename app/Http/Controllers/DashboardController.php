<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Opd;
use App\Models\Sektor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalDataset = Dataset::count();
        $totalTerklasifikasi = Dataset::where('status_klasifikasi', 'terklasifikasi')->count();
        $totalBelumTerklasifikasi = Dataset::where('status_klasifikasi', 'belum')->count();
        $totalTerpetakan = Dataset::whereNotNull('sektor_id')->count();
        $totalBelumTerpetakan = Dataset::whereNull('sektor_id')->count();
        $totalOpd = Opd::count();
        $totalSektor = Sektor::count();

        $persentaseTerpetakan = $totalDataset > 0
            ? round(($totalTerpetakan / $totalDataset) * 100, 1)
            : 0;

        $distribusiSektor = Sektor::withCount('datasets')
            ->orderByDesc('datasets_count')
            ->get();
        $maksDatasetSektor = max(1, (int) $distribusiSektor->max('datasets_count'));
        $distribusiOpd = Opd::withCount('datasets')
            ->orderByDesc('datasets_count')
            ->get();
        $datasetTerbaru = Dataset::with(['opd', 'sektor'])
            ->orderByDesc('id')
            ->take(5)
            ->get();

        // Pencarian dashboard mencakup seluruh dataset, bukan hanya lima data terbaru.
        $searchQuery = trim((string) $request->query('search', ''));
        $hasilPencarian = collect();
        $jumlahHasilPencarian = 0;

        if ($searchQuery !== '') {
            $hasilQuery = Dataset::query()->with(['opd', 'sektor']);
            $kolomCari = [
                'nama_statistik', 'nama_data_sektoral', 'urusan', 'bidang',
                'program', 'kegiatan', 'sub_kegiatan', 'proses_bisnis',
                'deskripsi_data', 'tujuan_pengumpulan_data', 'kategori_data',
                'jenis_data', 'nama_atribut_data', 'format_data_saat_ini',
                'frekuensi_update', 'aplikasi_yang_digunakan', 'status_aplikasi',
                'integrasi_dengan', 'potensi_integrasi', 'kendala_pengelolaan_data',
                'kebutuhan_opd', 'digunakan_untuk', 'data_sudah_tersedia', 'catatan',
            ];

            $hasilQuery->where(function ($query) use ($kolomCari, $searchQuery) {
                foreach ($kolomCari as $kolom) {
                    $query->orWhere($kolom, 'like', '%' . $searchQuery . '%');
                }
                $query->orWhereHas('opd', function ($opdQuery) use ($searchQuery) {
                    $opdQuery->where('nama_opd', 'like', '%' . $searchQuery . '%');
                });
                $query->orWhereHas('sektor', function ($sektorQuery) use ($searchQuery) {
                    $sektorQuery->where('nama_sektor', 'like', '%' . $searchQuery . '%');
                });
            });

            $jumlahHasilPencarian = (clone $hasilQuery)->count();
            $hasilPencarian = $hasilQuery->orderByDesc('id')->limit(50)->get();
        }

        return view('dashboard.index', compact(
            'totalDataset', 'totalTerklasifikasi', 'totalBelumTerklasifikasi',
            'totalTerpetakan', 'totalBelumTerpetakan', 'totalOpd', 'totalSektor',
            'persentaseTerpetakan', 'distribusiSektor', 'distribusiOpd',
            'datasetTerbaru', 'maksDatasetSektor', 'searchQuery',
            'hasilPencarian', 'jumlahHasilPencarian'
        ));
    }
}
