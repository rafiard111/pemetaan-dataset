<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opd extends Model
{
    protected $table = 'opd';

    protected $fillable = [
        'kode_opd',
        'nama_opd',
    ];

    public function datasets(): HasMany
    {
        return $this->hasMany(Dataset::class, 'opd_id');
    }
}