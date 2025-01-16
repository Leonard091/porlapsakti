<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kab_kota extends Model
{
    use HasFactory;
    protected $table = 'kab_kotas';

    // untuk relasi one To Many ke tabel lembaga
    public function lembaga() {
        return $this->hasMany(lembaga::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(provinsi::class, 'id_prov');
    }

    public function kecamatan()
    {
        return $this->hasMany(kecamatan::class, 'id_kab_kota');
    }
}
