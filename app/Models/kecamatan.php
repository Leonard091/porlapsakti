<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kecamatan extends Model
{
    protected $table = 'kecamatans'; // Nama tabel di database
    use HasFactory;
    // untuk relasi one To Many ke tabel lembaga
    public function lembaga() {
        return $this->hasMany(lembaga::class);
    }

    public function kab_kota() {
        return $this->belongsTo(kab_kota::class, 'id_kab_kota');
    }

    public function kelurahanDesas() {
        return $this->hasMany(Kel_desa::class, 'id_kec');
    }
}
