<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Dataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemetaanController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATASET DAN PEMETAAN SEKTOR LAMA
        |--------------------------------------------------------------------------
        */

        $opds = Opd::with(['datasets.sektor'])
            ->orderBy('nama_opd')
            ->get();

        $totalDataset = 0;
        $totalTerpetakan = 0;
        $totalBelumTerpetakan = 0;

        foreach ($opds as $opd) {
            $totalDataset += $opd->datasets->count();

            foreach ($opd->datasets as $dataset) {
                if ($dataset->sektor_id !== null) {
                    $totalTerpetakan++;
                } else {
                    $totalBelumTerpetakan++;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN RELASI ANTAR-OPD DARI TABEL SUMBER
        |--------------------------------------------------------------------------
        */

        $totalRelasi = DB::table('relasi_pendukung_sumber')
            ->count();

        $totalOpdPemilik = DB::table('relasi_pendukung_sumber')
            ->distinct()
            ->count('kode_opd_pemilik_sumber');

        $totalOpdTerkait = DB::table('relasi_pendukung_sumber')
            ->distinct()
            ->count('kode_opd_terkait_sumber');

        $totalPasanganOpd = DB::table('relasi_pendukung_sumber')
            ->select(
                'kode_opd_pemilik_sumber',
                'kode_opd_terkait_sumber'
            )
            ->distinct()
            ->get()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 10 OPD PEMILIK DENGAN CATATAN RELASI TERBANYAK
        |--------------------------------------------------------------------------
        */

        $topPemilik = DB::table('relasi_pendukung_sumber')
            ->select(
                'kode_opd_pemilik_sumber',
                'nama_opd_pemilik',
                DB::raw('COUNT(*) AS jumlah_relasi')
            )
            ->groupBy(
                'kode_opd_pemilik_sumber',
                'nama_opd_pemilik'
            )
            ->orderByDesc('jumlah_relasi')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 10 OPD TERKAIT DENGAN CATATAN RELASI TERBANYAK
        |--------------------------------------------------------------------------
        */

        $topTerkait = DB::table('relasi_pendukung_sumber')
            ->select(
                'kode_opd_terkait_sumber',
                'nama_opd_terkait',
                DB::raw('COUNT(*) AS jumlah_relasi')
            )
            ->groupBy(
                'kode_opd_terkait_sumber',
                'nama_opd_terkait'
            )
            ->orderByDesc('jumlah_relasi')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 10 PASANGAN OPD DENGAN CATATAN RELASI TERBANYAK
        |--------------------------------------------------------------------------
        */

        $topPasangan = DB::table('relasi_pendukung_sumber')
            ->select(
                'kode_opd_pemilik_sumber',
                'nama_opd_pemilik',
                'kode_opd_terkait_sumber',
                'nama_opd_terkait',
                DB::raw('COUNT(*) AS jumlah_relasi')
            )
            ->groupBy(
                'kode_opd_pemilik_sumber',
                'nama_opd_pemilik',
                'kode_opd_terkait_sumber',
                'nama_opd_terkait'
            )
            ->orderByDesc('jumlah_relasi')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PENCARIAN CATATAN RELASI
        |--------------------------------------------------------------------------
        */

        $kataKunci = trim((string) $request->query('q', ''));

        $queryRelasi = DB::table('relasi_pendukung_sumber');

        if ($kataKunci !== '') {
            $queryRelasi->where(function ($query) use ($kataKunci) {
                $query->where(
                    'nama_opd_pemilik',
                    'like',
                    '%' . $kataKunci . '%'
                )
                ->orWhere(
                    'nama_opd_terkait',
                    'like',
                    '%' . $kataKunci . '%'
                )
                ->orWhere(
                    'nama_data_sumber',
                    'like',
                    '%' . $kataKunci . '%'
                )
                ->orWhere(
                    'kode_opd_pemilik_sumber',
                    'like',
                    '%' . $kataKunci . '%'
                )
                ->orWhere(
                    'kode_opd_terkait_sumber',
                    'like',
                    '%' . $kataKunci . '%'
                );
            });
        }

        $relasi = $queryRelasi
            ->orderBy('nama_opd_pemilik')
            ->orderBy('nama_opd_terkait')
            ->paginate(25)
            ->withQueryString();

        return view('pemetaan.index', compact(
            'opds',
            'totalDataset',
            'totalTerpetakan',
            'totalBelumTerpetakan',
            'totalRelasi',
            'totalOpdPemilik',
            'totalOpdTerkait',
            'totalPasanganOpd',
            'topPemilik',
            'topTerkait',
            'topPasangan',
            'relasi',
            'kataKunci'
        ));
    }
}
