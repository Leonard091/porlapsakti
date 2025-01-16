<?php

namespace App\Http\Controllers;

use App\Models\kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function getKecamatan($id_kab_kota)
    {
        $kecamatans = kecamatan::where('id_kab_kota', $id_kab_kota)->get();
        return response()->json($kecamatans);
    }
}
