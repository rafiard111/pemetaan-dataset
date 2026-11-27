<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaanDatasetController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('relasi_pendukung_sumber')
            ->whereNotNull('nama_data_sumber')
            ->where('nama_data_sumber', '<>', '');

        if ($request->filled('opd')) {
            $query->where(
                'kode_opd_pemilik_sumber',
                $request->opd
            );
        }

        $data = $query
            ->orderBy('nama_data_sumber')
            ->get([
                'kode_opd_pemilik_sumber',
                'nama_opd_pemilik',
                'nama_data_sumber',
                'kode_opd_terkait_sumber',
                'nama_opd_terkait',
                'status_bukti',
            ]);

        $daftarOpd = DB::table('relasi_pendukung_sumber')
            ->select(
                'kode_opd_pemilik_sumber',
                'nama_opd_pemilik'
            )
            ->whereNotNull('kode_opd_pemilik_sumber')
            ->distinct()
            ->orderBy('nama_opd_pemilik')
            ->get();

        $kelompokDataset = $data->groupBy(function ($item) {
            return $item->kode_opd_pemilik_sumber
                . '||'
                . $item->nama_data_sumber;
        });

        $datasetList = $kelompokDataset->map(function ($items) {
            $pertama = $items->first();

            $opdTerkait = $items
                ->filter(function ($item) {
                    return !empty($item->kode_opd_terkait_sumber)
                        && !empty($item->nama_opd_terkait);
                })
                ->groupBy('kode_opd_terkait_sumber')
                ->map(function ($relasi) {
                    $baris = $relasi->first();

                    return [
                        'kode' => $baris->kode_opd_terkait_sumber,
                        'nama' => $baris->nama_opd_terkait,
                        'jumlah_catatan' => $relasi->count(),
                    ];
                })
                ->values();

            return [
                'kode_opd' => $pertama->kode_opd_pemilik_sumber,
                'nama_opd' => $pertama->nama_opd_pemilik,
                'nama_dataset' => $pertama->nama_data_sumber,
                'jumlah_opd_terkait' => $opdTerkait->count(),
                'jumlah_catatan' => $items->count(),
                'opd_terkait' => $opdTerkait,
            ];
        })->values();

        if ($request->filled('search')) {
            $kataKunci = strtolower($request->search);

            $datasetList = $datasetList
                ->filter(function ($item) use ($kataKunci) {
                    return str_contains(
                        strtolower($item['nama_dataset']),
                        $kataKunci
                    ) || str_contains(
                        strtolower($item['nama_opd'] ?? ''),
                        $kataKunci
                    );
                })
                ->values();
        }

        $datasetList = $datasetList
            ->sortByDesc('jumlah_opd_terkait')
            ->values();

        $detailDataset = null;

        if ($request->filled('dataset') && $request->filled('pemilik')) {
            $detailDataset = $datasetList->first(function ($item) use ($request) {
                return $item['nama_dataset'] === $request->dataset
                    && $item['kode_opd'] === $request->pemilik;
            });
        }

        return view('analisis.penggunaan-dataset', [
            'datasetList' => $datasetList,
            'daftarOpd' => $daftarOpd,
            'detailDataset' => $detailDataset,
            'opdTerpilih' => $request->opd,
            'search' => $request->search,
        ]);
    }
}
