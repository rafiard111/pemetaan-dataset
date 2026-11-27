<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sektor extends Model
{
    protected $table = 'sektor';

    protected $fillable = [
        'nama_sektor',
    ];

    public function datasets(): HasMany
    {
        return $this->hasMany(Dataset::class, 'sektor_id');
    }

    public function aturanKlasifikasi(): HasMany
    {
        return $this->hasMany(AturanKlasifikasi::class, 'sektor_id');
    }
}