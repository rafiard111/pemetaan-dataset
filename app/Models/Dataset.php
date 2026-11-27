<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dataset extends Model
{
    protected $table = 'datasets';

    protected $fillable = [
        'opd_id',
        'nama_statistik',
        'nama_data_sektoral',
        'urusan',
        'bidang',
        'program',
        'kegiatan',
        'sub_kegiatan',
        'proses_bisnis',
        'deskripsi_data',
        'tujuan_pengumpulan_data',
        'kategori_data',
        'jenis_data',
        'nama_atribut_data',
        'format_data_saat_ini',
        'frekuensi_update',
        'aplikasi_yang_digunakan',
        'status_aplikasi',
        'ketersediaan_api_integrasi',
        'integrasi_dengan',
        'potensi_integrasi',
        'kendala_pengelolaan_data',
        'kebutuhan_opd',
        'digunakan_untuk',
        'data_sudah_tersedia',
        'catatan',
        'sektor_id',
        'status_klasifikasi',
        'status_pemetaan',
        'skor_klasifikasi',
    ];

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function sektor(): BelongsTo
    {
        return $this->belongsTo(Sektor::class, 'sektor_id');
    }
}