<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AturanKlasifikasi extends Model
{
    protected $table = 'aturan_klasifikasi';

    protected $fillable = [
        'sektor_id',
        'keyword',
        'bobot',
    ];

    public function sektor(): BelongsTo
    {
        return $this->belongsTo(Sektor::class, 'sektor_id');
    }
}